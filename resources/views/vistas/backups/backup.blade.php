<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Copias de Seguridad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Animaciones y transiciones */
        .fade-in {
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        tr {
            transition: background-color 0.3s ease;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .btn-animated {
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-animated:hover {
            background-color: #0069d9;
            transform: scale(1.05);
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5 fade-in col-12">
    <h1><i class="fas fa-database"></i> Gestión de Copias de Seguridad</h1>

    <!-- Formulario para crear una nueva copia de seguridad -->
    <form id="createBackupForm">
        <div class="form-group">
            <label for="nombre">Nombre de la copia de seguridad</label>
            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre de la copia de seguridad" required>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha de la copia de seguridad</label>
            <input type="date" id="fecha" name="fecha" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-animated">Crear Copia de Seguridad</button>
    </form>

    <h2 class="mt-5">Copias de Seguridad Existentes</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre del Backup</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="backupList">
            <!-- Los datos se cargarán dinámicamente -->
        </tbody>
    </table>
</div>

<script>
    // Cargar la lista de copias de seguridad
    function loadBackups() {
        fetch('{{ route('backups.index') }}')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }

                const backups = data.backups || [];
                const backupList = document.getElementById('backupList');

                if (backupList) {
                    backupList.innerHTML = ''; // Limpiar la tabla

                    backups.forEach(backup => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${backup}</td>
                            <td>
                                <button class="btn btn-success btn-sm btn-animated" onclick="downloadBackup('${backup}')">
                                    <i class="fas fa-download"></i> Descargar
                                </button>
                                <button class="btn btn-danger btn-sm btn-animated" onclick="deleteBackup('${backup}')">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </td>
                        `;
                        backupList.appendChild(row);
                    });
                } else {
                    console.error('Elemento #backupList no encontrado');
                }
            })
            .catch(error => {
                console.error('Error al cargar la lista de copias de seguridad:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al cargar la lista de copias de seguridad.',
                });
            });
    }

    // Manejar la creación de una nueva copia de seguridad
    document.getElementById('createBackupForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const nombre = document.getElementById('nombre').value;
        const fecha = document.getElementById('fecha').value;

        if (!nombre || !fecha) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos Vacíos',
                text: 'Por favor, complete todos los campos antes de enviar el formulario.',
            });
            return;
        }

        const formData = new FormData(this);
        fetch('{{ route('backups.create') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('No se pudo crear la copia de seguridad');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: data.success,
                });
                loadBackups(); // Actualizar la lista
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error,
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al crear la copia de seguridad.',
            });
        });
    });

    // Descargar una copia de seguridad
    function downloadBackup(file) {
        fetch(`{{ url('backups/download') }}/${file}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('No se pudo descargar el archivo');
                }
                return response.blob();
            })
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                a.download = file;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'La copia de seguridad se descargó correctamente.',
                });
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo descargar el archivo.',
                });
            });
    }

    // Eliminar una copia de seguridad
    function deleteBackup(file) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `Se eliminará la copia de seguridad: ${file}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`{{ url('backups/delete') }}/${file}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('No se pudo eliminar la copia de seguridad');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: data.success,
                        });
                        loadBackups();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error,
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al eliminar la copia de seguridad.',
                    });
                });
            }
        });
    }

    // Inicializar la lista de copias de seguridad
    loadBackups();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

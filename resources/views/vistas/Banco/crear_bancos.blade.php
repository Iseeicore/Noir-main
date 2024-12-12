<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-2xl font-semibold text-gray-800">Gestión de Bancos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Gestión de Bancos</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Formulario para Crear / Editar Banco -->
        <div class="card mb-4 shadow-md">
            <div class="card-header bg-blue-600 text-white font-bold">Registrar o Editar Banco</div>
            <div class="card-body">
                <form id="formBanco" method="POST" action="{{ route('bancos.store') }}">
                    @csrf
                    <input type="hidden" id="banco_id" name="id" value="">

                    <!-- Nombre del Banco -->
                    <div class="mb-4">
                        <label for="nombreBanco" class="form-label text-lg font-medium">Nombre del Banco</label>
                        <input type="text" name="nombre_banco" class="form-control border border-gray-300 rounded-md p-2 w-full" id="nombreBanco" required>
                    </div>

                    <!-- Tipo de Moneda -->
                    <div class="mb-4">
                        <label for="tipoMoneda" class="form-label text-lg font-medium">Tipo de Moneda</label>
                        <select name="tipo_moneda" class="form-select border border-gray-300 rounded-md p-2 w-full" id="tipoMoneda" required>
                            <option value="" disabled selected>Seleccione una moneda</option>
                            <option value="Soles">Soles</option>
                            <option value="Dolares">Dólares</option>
                        </select>
                    </div>

                    <!-- Número de Cuenta -->
                    <div class="mb-4">
                        <label for="numeroCuenta" class="form-label text-lg font-medium">Número de Cuenta</label>
                        <input type="text" name="numero_cuenta" class="form-control border border-gray-300 rounded-md p-2 w-full" id="numeroCuenta" required>
                    </div>

                    <!-- Estado del Banco -->
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="estado" id="estadoBanco" value="1">
                        <label class="form-check-label" for="estadoBanco">Activo</label>
                    </div>

                    <div class="flex justify-between">
                        <!-- Botón para Registrar o Actualizar Banco -->
                        <button type="submit" class="btn btn-success px-6 py-2 rounded-lg bg-green-600 text-white" id="btnSubmit">Registrar</button>

                        <!-- Botón de Cancelar -->
                        <button type="button" class="btn btn-danger px-6 py-2 rounded-lg bg-gray-600 text-white" id="btnCancel" style="display: none;">Cancelar</button>

                        <!-- Botón de Eliminar -->
                        <button type="button" class="btn btn-danger px-6 py-2 rounded-lg bg-red-600 text-white" id="btnDelete" style="display: none;">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de Bancos (Visualización en tarjetas) -->
        <div class="card">
            <div class="card-header bg-gray-800 text-white font-bold">Lista de Bancos</div>
            <div class="card-body">
                <div class="row" id="bancoCardsContainer">
                    <!-- Las tarjetas de bancos se cargarán aquí -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Cargar los bancos al cargar la página
        cargarBancos();

        // Función para cargar los bancos en tarjetas
        function cargarBancos() {
            $.ajax({
                url: '{{ route("bancos.index") }}', // Ruta para obtener los bancos
                method: 'GET',
                beforeSend: function() {
                    $('#bancoCardsContainer').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando bancos...</div>'); // Muestra cargando
                },
                success: function(data) {
                    const container = $('#bancoCardsContainer');
                    container.empty();

                    if (data.length === 0) {
                        container.append('<div class="text-center">No hay bancos registrados.</div>');
                    } else {
                        data.forEach(banco => {
                            container.append(`
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-md border border-gray-200 p-4" data-id="${banco.id}" style="cursor: pointer;">
                                        <div class="card-body">
                                            <h5 class="card-title text-lg font-semibold">${banco.nombre_banco}</h5>
                                            <p class="card-text text-gray-600">Cuenta: ${banco.numero_cuenta}</p>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });

                        // Al hacer clic en una tarjeta, mostrar todos los detalles del banco
                        $('.card').on('click', function() {
                            const bancoId = $(this).data('id');
                            if (bancoId) {
                                $('#banco_id').val(bancoId);
                                mostrarDetallesBanco(bancoId);
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error al cargar los bancos:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar los bancos.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        // Función para mostrar los detalles del banco
        function mostrarDetallesBanco(id) {
            $.ajax({
                url: `/bancos/${id}`,
                method: 'GET',
                success: function(data) {
                    if (data) {
                        $('#nombreBanco').val(data.nombre_banco);
                        $('#tipoMoneda').val(data.tipo_moneda);
                        $('#numeroCuenta').val(data.numero_cuenta);
                        $('#estadoBanco').prop('checked', data.estado);
                        $('#btnSubmit').text('Actualizar');
                        $('#btnCancel').show();
                        $('#btnDelete').show();  // Mostrar botón de eliminar
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error al cargar los detalles del banco:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar los detalles del banco.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        // Función para actualizar el banco
        $('#formBanco').on('submit', function(e) {
            e.preventDefault();
            const id = $('#banco_id').val();
            const url = id ? `/bancos/${id}` : '{{ route("bancos.store") }}';
            const method = id ? 'PUT' : 'POST';

            $('#btnSubmit').prop('disabled', true).text('Guardando...');

            $.ajax({
                url: url,
                method: method,
                data: $(this).serialize(),
                success: function(response) {
                    $('#formBanco')[0].reset();
                    $('#banco_id').val('');
                    $('#btnSubmit').prop('disabled', false).text('Registrar');
                    $('#btnCancel').hide();
                    $('#btnDelete').hide();
                    cargarBancos();
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error al guardar el banco:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al guardar el banco.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Eliminar banco
$('#btnDelete').on('click', function() {
    const bancoId = $('#banco_id').val();
    if (bancoId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarBanco(bancoId);
            }
        });
    }
});

// Función para eliminar el banco
function eliminarBanco(id) {
    $.ajax({
        url: `{{ route('bancos.destroy', ':id') }}`.replace(':id', id), // Usando la ruta correcta de Laravel
        method: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'  // Asegúrate de enviar el token CSRF
        },
        success: function(response) {
            cargarBancos(); // Recargar los bancos
            $('#formBanco')[0].reset();
            $('#banco_id').val('');
            $('#btnSubmit').text('Registrar');
            $('#btnCancel').hide();
            $('#btnDelete').hide();
            Swal.fire({
                icon: 'success',
                title: 'Banco Eliminado',
                text: 'El banco ha sido eliminado exitosamente.',
                confirmButtonText: 'OK'
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al eliminar el banco:", error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo eliminar el banco.',
                confirmButtonText: 'OK'
            });
        }
    });
}


        // Cancelar la edición
        $('#btnCancel').on('click', function() {
            $('#formBanco')[0].reset();
            $('#banco_id').val('');
            $('#btnSubmit').text('Registrar');
            $('#btnCancel').hide();
            $('#btnDelete').hide();
        });
    });
</script>

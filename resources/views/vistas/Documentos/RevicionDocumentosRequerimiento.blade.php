<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">REVICION DE REQUERIMIENTO</h2>
            </div><!-- /.col -->
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                    <li class="breadcrumb-item active">Revicion de Requerimiento</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">

    <div class="container-fluid">

        <div class="card card-gray shadow mt-4">

            <div class="card-body px-3 py-3" style="position: relative;">

                <span class="titulo-fieldset px-3 py-1">LISTADO DE REQUERIMIENTO</span>

                <div class="row my-3">

                    <div class="col-12">
                        <table id="tbl_DocRequerimiento" class="table table-striped w-100 shadow border border-secondary">
                            <thead class="bg-main text-left">
                                <th>Op.</th>
                                <th>Id</th>
                                <th>Codigo</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Zona Socilicitante</th>
                                <th>Solicitante</th>
                                <th>Revisado Por</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        validarAccesoRequerimiento();
        

    });
    function validarAccesoRequerimiento() {
    const usuarioId = "{{ auth()->user()->id_usuario }}"; // ID único del usuario autenticado
    const mensajeMostrado = sessionStorage.getItem(`mensaje_acceso_mostrado_${usuarioId}`); // Almacenar por usuario

    if (mensajeMostrado) {
        fnc_CargarDatatableRequerimientosRevicion(); // Si ya fue mostrado, cargar directamente
        return;
    }

    // Si no se mostró, validar el acceso
    $.ajax({
        url: "{{ route('validar.acceso.requerimiento') }}",
        type: 'GET',
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    title: 'Acceso permitido',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                    html: `
                        <div>
                            <input type="checkbox" id="checkboxMensaje" />
                            <label for="checkboxMensaje">No mostrar este mensaje nuevamente durante esta sesión</label>
                        </div>
                    `
                }).then((result) => {
                    if (result.isConfirmed) {
                        const noMostrarMensaje = $('#checkboxMensaje').is(':checked');
                        if (noMostrarMensaje) {
                            sessionStorage.setItem(`mensaje_acceso_mostrado_${usuarioId}`, true); // Guardar en sessionStorage con el usuario
                        }
                        fnc_CargarDatatableRequerimientosRevicion(); // Cargar la tabla
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Acceso denegado',
                    text: response.message,
                    confirmButtonText: 'Cerrar'
                }).then(() => {
                    window.location.href = '/'; // Redirigir si no tiene acceso
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al validar el acceso.',
                confirmButtonText: 'Cerrar'
            });
        }
    });
}



    function fnc_CargarDatatableRequerimientosRevicion() {
        if ($.fn.DataTable.isDataTable('#tbl_DocRequerimiento')) {
            $('#tbl_DocRequerimiento').DataTable().destroy();
            $('#tbl_DocRequerimiento tbody').empty();
            $('[data-bs-toggle="tooltip"]').tooltip();
        }

        $("#tbl_DocRequerimiento").DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'LISTADO DE REQUERIMIENTOS'
                },
                'pageLength'
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('requerimiento.listarRevicion') }}", // Nueva ruta para este método
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                }
            },
            columns: [
                { data: 'opciones', orderable: false, searchable: false },
                { data: 'id' },
                { data: 'codigo' },
                { data: 'fecha' },
                { data: 'estado' },
                { data: 'zona_solicitante' },
                { data: 'solicitante' },
                {
                    data: 'revisado_req',
                    render: function(data, type, row) {
                        return data ? `<span>${data}</span>` : '<span class="text-muted">Sin revisar</span>';
                    }
                }
            ],
            // scrollX: true,
            columnDefs: [
                { className: "dt-center", targets: "_all" },
                {
    targets: 0, // Columna de opciones
    "width": "10%",
    sortable: false,
    render: function(data, type, full, meta) {
        let opciones = `<center>`;
        
         // Dropdown para aceptar o recepcionar requerimiento
         opciones += `
            <div class="btn-group">
                <button class="btn btn-sm p-0 m-0 text-success fs-5" type="button" onclick="$(this).next('.dropdown-menu').toggle()" style="background: none; border: none;">
                    <i class='fas fa-check-circle'></i>
                </button>
                <div class="dropdown-menu" style="display: none; position: absolute;">
                    <a class="dropdown-item btnAceptarRequerimiento" style='cursor:pointer;' onclick="cambiarEstadoRequerimiento(${full.id}, 5)">
                        <i class='fas fa-check-circle text-success mr-2'></i> Aceptar
                    </a>
                    <a class="dropdown-item btnRecepcionarRequerimiento" style='cursor:pointer;' onclick="cambiarEstadoRequerimiento(${full.id}, 2)">
                        <i class='fas fa-box text-info mr-2'></i> Recepcionar
                    </a>
                </div>
            </div>`;
        // Botón para observar requerimiento
        opciones += `
            <span class='btnObservar text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Observar Requerimiento' onclick="visualizarRequerimiento(${full.id})">
                <i class='fas fa-eye fs-5'></i>
            </span>`;
        // Dropdown para extras
        opciones += `
            <div class="btn-group">
                <button class="btn btn-sm p-0 m-0 text-warning fs-5" type="button" onclick="$(this).next('.dropdown-menu').toggle()" style="background: none; border: none;">
                    <i class='fas fa-exclamation-circle'></i>
                </button>
                <div class="dropdown-menu" style="display: none; position: absolute;">
                    <a class="dropdown-item btnCancelarRequerimiento" style='cursor:pointer;' onclick="cambiarEstadoRequerimiento(${full.id}, 4)">
                        <i class='fas fa-times-circle text-danger mr-2'></i> Cancelar
                    </a>
                    <a class="dropdown-item btnMejorarRequerimiento" style='cursor:pointer;' onclick="cambiarEstadoRequerimiento(${full.id}, 3)">
                        <i class='fas fa-tools text-primary mr-2'></i> Mejorar
                    </a>
                </div>
            </div>`;

        opciones += `</center>`;
        return opciones;
    }
},

                {
                    targets: 4,
                    "width": "25%",
                    createdCell: function(td, cellData, rowData, row, col) {
                        let estadoHtml = '';
                        switch (rowData.estado) {
                            case 0: // Inactivo
                                estadoHtml = '<span class="bg-danger px-2 py-1 rounded-pill fw-bold">Revicion Pendiente</span>';
                                break;
                            case 1: // En revisión
                                estadoHtml = '<span class="bg-warning px-2 py-1 rounded-pill fw-bold">EN REVISIÓN</span>';
                                break;
                            case 2: // Recepcionado
                                estadoHtml = '<span class="bg-success px-2 py-1 rounded-pill fw-bold">RECEPCIONADO</span>';
                                break;
                            case 3: // Mejorar
                                estadoHtml = '<span class="bg-info px-2 py-1 rounded-pill fw-bold">MEJORAR</span>';
                                break;
                            case 4: // Cancelado
                                estadoHtml = '<span class="bg-danger px-2 py-1 rounded-pill fw-bold">CANCELADO</span>';
                                break;
                            case 5: //Aceptar
                                estadoHtml = '<span class="bg-success px-2 py-1 rounded-pill fw-bold">Aceptado</span>';
                                break;

                            case 6: // Cerrado
                                estadoHtml = '<span class=""bg-secondary px-2 py-1 rounded-pill fw-bold"">CERRADO</span>';
                                break;
                            default: // Cualquier otro estado
                        }
                        $(td).html(estadoHtml);
                    }
                }
            ],
            language: {
                url: 'assets/languages/Spanish.json'
            }
        });
    }

    function aceptarRequerimiento(id) {
        Swal.fire({
            title: 'Aceptar Requerimiento',
            text: `¿Estás seguro de aceptar el requerimiento con ID: ${id}?`,
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Lógica para aceptar el requerimiento (llamada a Ajax o redirección)
                console.log(`Requerimiento ${id} aceptado`);
                Swal.fire('Aceptado', `El requerimiento ${id} ha sido aceptado.`, 'success');
            }
        });
    }

    // function visualizarRequerimiento(id) {
    // Swal.fire({
    //         title: 'Detalles del Requerimiento',
    //         text: `Visualizando el requerimiento con ID: ${id}`, // Aquí puedes hacer un llamado a un modal o Ajax para obtener datos detallados
    //         icon: 'info',
    //         confirmButtonText: 'Cerrar'
    //     });
    // }
    // function extrasRequerimiento(id) {
    //     Swal.fire({
    //         title: 'Extras del Requerimiento',
    //         text: `Acciones adicionales para el requerimiento con ID: ${id}.`,
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonText: 'Continuar',
    //         cancelButtonText: 'Cerrar'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             // Lógica para la opción de extras
    //             console.log(`Extras para el requerimiento ${id}`);
    //         }
    //     });
    // }

    function visualizarRequerimiento(id, contenido = 'Documentos/requerimientoExtras/VerRequerimientosRevicion', contenedor = 'content-wrapper') {
        $.ajax({
            url: '/cargar-contenido',  // URL de la ruta para cargar contenido
            type: 'GET',
            data: {
                contenido: contenido,   // Vista que queremos cargar
                id_de_paso: id  // ID del producto (o el dato que necesites)
            },
            success: function(data) {
                // Reemplaza el contenido solo en el contenedor especificado
                $("." + contenedor).html(data);

                // Si usas select2 u otros componentes, reinicialízalos aquí
                if ($('.select2').length) {
                    $('.select2').select2();
                }
            },
            error: function(error) {
                console.log("Error al cargar la página", error);
                alert("Hubo un error al cargar el contenido. Inténtelo de nuevo.");
            }
        });
    }

    function cambiarEstadoRequerimiento(id, estado) {
    Swal.fire({
        title: 'Cambiar Estado',
        text: `¿Estás seguro de cambiar el estado del requerimiento con ID: ${id}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, cambiar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("requerimiento.cambiarEstado") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    estado: estado, // Nuevo estado
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Éxito', response.message, 'success');
                        $('#tbl_DocRequerimiento').DataTable().ajax.reload(); // Recargar la tabla
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error', 'No se pudo cambiar el estado del requerimiento.', 'error');
                    console.error(xhr.responseText);
                }
            });
        }
    });
}




</script>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Unidad de Medida</h2>
            </div><!-- /.col -->
            <div class="col-sm-6  d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Unidad de Medida</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">

    <div class="container-fluid">

        <div class="card card-gray shadow mt-4">

            <div class="card-body px-3 py-3" style="position: relative;">

                <span class="titulo-fieldset px-3 py-1">LISTADO DE Unidad de Medida</span>

                <div class="row my-3">

                    <div class="col-12">
                        <table id="tbl_unidadesmedida" class="table table-striped w-100 shadow border border-secondary">
                            <thead class="bg-main text-left">
                                <th></th>
                                <th>Id</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </thead>
                        </table>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<div class="modal fade" id="mdlGestionarUnidadMedida" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-main py-2">
                <h6 class="modal-title titulo_modal_UnidadMedida">Registrar Unidad de Medida</h6>
                <button type="button" class="text-white m-0 px-1 badge badge-pill badge-danger" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>

            <div class="modal-body">

                <form class="needs-validation-UnidadMedida" novalidate>

                    <div class="row">

                        <div class="col-12 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i
                                    class="fas fa-ruler mr-1 my-text-color"></i>Codigo</label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm"
                                id="codigo" name="codigo" aria-label="Small" aria-describedby="inputGroup-sizing-sm"
                                required>
                            <div class="invalid-feedback">Ingrese el codigo de la unidad de medida</div>
                        </div>

                        <div class="col-12 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i
                                    class="fas fa-ruler mr-1 my-text-color"></i>Unidad de Medida</label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm"
                                id="descripcion" name="descripcion" aria-label="Small"
                                aria-describedby="inputGroup-sizing-sm" required>
                            <div class="invalid-feedback">Ingrese la unidad de medida</div>
                        </div>

                        <div class="col-md-12 mt-3 text-center">
                            <a class="btn btn-sm btn-success fw-bold" id="btnRegistrarUnidadMedida"
                                style="position: relative; width: 50%;">
                                <span class="text-button">GUARDAR</span>
                                <span class="btn fw-bold icon-btn-success d-flex align-items-center">
                                    <i class="fas fa-save fs-5 text-white m-0 p-0"></i>
                                </span>
                            </a>
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
<script>
        //variables para registrar o editar los Proveedores
        var $global_id_unidadmedida = 0;
    $(document).ready(function() {
        fnc_CargarDatatableUnidadMedida();

        $('#mdlGestionarUnidadMedida').on('hidden.bs.modal', function () {
            limpiarCamposUnidadMedida();
        });

        $('#tbl_unidadesmedida tbody').on('click', '.btnEliminarUnidadesMedida', function() {
            var data = $('#tbl_unidadesmedida').DataTable().row($(this).parents('tr')).data();
            fnc_EliminarUnidadesMedida(data.id);
        });

        $("#btnRegistrarUnidadMedida").on('click', function() {
            fnc_guardarUnidadMedida();
        })

        $('#tbl_unidadesmedida tbody').on('click', '.btnEditarUnidadesMedida', function() {
        var data = $('#tbl_unidadesmedida').DataTable().row($(this).parents('tr')).data();
        fnc_MostrarModalEditarUnidadMedida(data);
        });

        $('#tbl_unidadesmedida tbody').on('click', '.btnActivarUnidadesMedida', function() {
            var data = $('#tbl_unidadesmedida').DataTable().row($(this).parents('tr')).data();
            fnc_CambiarEstadoUnidadMedida(data.id, 1); 
        });

        $('#tbl_unidadesmedida tbody').on('click', '.btnDesactivarUnidadesMedida', function() {
            var data = $('#tbl_unidadesmedida').DataTable().row($(this).parents('tr')).data();
            fnc_CambiarEstadoUnidadMedida(data.id, 0); 
        });

    });

    function fnc_CargarDatatableUnidadMedida() {
    if ($.fn.DataTable.isDataTable('#tbl_unidadesmedida')) {
        $('#tbl_unidadesmedida').DataTable().destroy();
        $('#tbl_unidadesmedida tbody').empty();
    }
    
    $("#tbl_unidadesmedida").DataTable({
        dom: 'Bfrtip',
        buttons: [{
                text: 'Agregar Unidades de Medida',
                className: 'addNewRecord',
                action: function(e, dt, node, config) {
                    $(".titulo_modal_UnidadMedida").html("Registrar Unidad Medida");
                    $("#mdlGestionarUnidadMedida").modal('show');
                }
            },
            {
                extend: 'excel',
                title: 'LISTADO DE UNIDAD DE MEDIDA'
            },
            'pageLength'
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('UnidadesMedida.listar') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [{
                data: 'opciones',
                orderable: false,
                searchable: false
            },
            {
                data: 'id'
            },
            {
                data: 'nombre_unidad'
            },
            {
                data: 'estado'
            },
        ],
        scrollX: true,
        columnDefs: [{
                className: "dt-center",
                targets: "_all"
            },
            {
                targets: 0,
                "width": "10%",
                sortable: false,
                render: function(data, type, full, meta) {
                    let opciones = `
                    <center>
                        <span class='btnEditarUnidadesMedida text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Editar UnidadesMedida'> 
                            <i class='fas fa-pencil-alt fs-5'></i> 
                        </span> 
                        <span class='btnEliminarUnidadesMedida text-danger px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar UnidadesMedida'> 
                            <i class='fas fa-trash fs-5'></i> 
                        </span>`;

                    if (full.estado === "ACTIVO") {
                        opciones += `
                        <span class='btnDesactivarUnidadesMedida text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Desactivar UnidadesMedida'>
                            <i class='fas fa-toggle-on fs-5'></i> 
                        </span>`;
                    } else {
                        opciones += `
                        <span class='btnActivarUnidadesMedida text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Activar UnidadesMedida'>
                            <i class='fas fa-toggle-off fs-5'></i>
                        </span>`;
                    }

                    opciones += `</center>`;
                    return opciones;
                }
            },
            {
                targets: 3,
                "width": "25%",
                createdCell: function(td, cellData, rowData, row, col) {
                    if (rowData.estado === 'ACTIVO') {
                        $(td).html(
                            '<span class="bg-success px-2 py-1 rounded-pill fw-bold"> ' +
                            rowData.estado + ' </span>');
                    } else if (rowData.estado === 'INACTIVO') {
                        $(td).html(
                            '<span class="bg-danger px-2 py-1 rounded-pill fw-bold"> ' +
                            rowData.estado + ' </span>');
                    }
                }
            },
        ],
        language: {
            url: 'assets/languages/Spanish.json'
        }
    });
}





function fnc_guardarUnidadMedida() {
    // Validar los campos antes de enviar
    const formValid = $('.needs-validation-UnidadMedida')[0].checkValidity();
    $('.needs-validation-UnidadMedida').addClass('was-validated');

    if (!formValid) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Complete los campos obligatorios.',
        });
        return;
    }

    // Crear un FormData con los valores de los inputs
    var formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('nomb_uniMed', $('#descripcion').val()); // Campo para la descripción
    formData.append('estado', 1); // Asignar estado activo por defecto

    // Determinar si se creará o actualizará la categoría
    if ($global_id_unidadmedida && $global_id_unidadmedida.length > 0){
        // Modo edición: omitimos `codigo` en el FormData
        var url = "{{ route('UnidadMedida.actualizar', '') }}/" + $global_id_unidadmedida;
    } else {
        // Modo registro: incluimos `codigo`
        formData.append('codigo', $('#codigo').val()); // Campo para el código de la categoría
        var url = "{{ route('UnidadMedida.guardar') }}";
    }

    $.ajax({
        url: url, // Ruta de Laravel
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            Swal.fire({
                icon: response.tipo_msj,
                title: response.tipo_msj === "success" ? "Éxito" : "Error",
                text: response.msj,
            });

            if (response.tipo_msj === "success") {
                $('#mdlGestionarUnidadMedida').modal('hide');
                fnc_CargarDatatableUnidadMedida(); // Recargar el DataTable después de guardar
                limpiarCamposUnidadMedida(); // Limpiar campos después de guardar
                $global_id_unidadmedida = 0; // Reiniciar el ID global después de guardar o actualizar
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un problema al guardar la categoría. Intente nuevamente.',
            });
        }
    });
}

function fnc_EliminarUnidadesMedida(id){
    Swal.fire({
        title: '¿Está seguro de eliminar esta unidad de medida?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, enviamos la solicitud AJAX
            $.ajax({
                url: "{{ route('UnidadMedida.eliminar', '') }}/" + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        icon: response.tipo_msj,
                        title: response.tipo_msj === "success" ? "Éxito" : "Error",
                        text: response.msj,
                    });

                    if (response.tipo_msj === "success") {
                        fnc_CargarDatatableUnidadMedida(); // Recargar el DataTable de categorías
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al eliminar la categoría. Intente nuevamente.',
                    });
                }
            });
        }
    });
}

function fnc_CambiarEstadoUnidadMedida(id, estado) {
    const estadoTexto = estado === 1 ? 'activar' : 'desactivar';
    Swal.fire({
        title: `¿Está seguro de ${estadoTexto} esta categoría?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: `Sí, ${estadoTexto}`,
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar solicitud AJAX para cambiar el estado
            $.ajax({
                url: "{{ route('UnidadMedida.cambiar_estado', '') }}/" + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    estado: estado
                },
                success: function(response) {
                    Swal.fire({
                        icon: response.tipo_msj,
                        title: response.tipo_msj === "success" ? "Éxito" : "Error",
                        text: response.msj,
                    });

                    if (response.tipo_msj === "success") {
                        fnc_CargarDatatableUnidadMedida(); // Actualizar la tabla de categorías
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al cambiar el estado. Intente nuevamente.',
                    });
                }
            });
        }
    });
}



// Función para limpiar campos del formulario
function limpiarCamposUnidadMedida() {
    $('#codigo').val('').prop("readonly",false);
    $('#descripcion').val('');

    $('.needs-validation-Categoria').removeClass('was-validated');
}

function fnc_MostrarModalEditarUnidadMedida(data) {
    $global_id_unidadmedida = data.id; // Asignamos el ID de la categoría globalmente para saber que estamos editando
    $("#codigo").val(data.id).prop("readonly", true); // Código en modo solo lectura
    $("#descripcion").val(data.nombre_unidad);

    $(".titulo_modal_UnidadMedida").html("Actualizar Categoría");
    $("#mdlGestionarUnidadMedida").modal('show');
}
    
</script>

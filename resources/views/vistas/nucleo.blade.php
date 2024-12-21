<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Nucleo</h2>
            </div><!-- /.col -->
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                    <li class="breadcrumb-item active">Listado de los Nucleo</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">

    <div class="container-fluid">

        <div class="card card-gray shadow mt-4">

            <div class="card-body px-3 py-3" style="position: relative;">

                <span class="titulo-fieldset px-3 py-1">Listado de Nucleos</span>

                <div class="row my-3">

                    <div class="col-12">
                        <table id="tbl_nucleo" class="table table-striped w-100 shadow border border-secondary">
                            <thead class="bg-main text-left">
                                <th></th>
                                <th>Id</th>
                                <th>Nucleo</th>
                                <th>Estado</th>
                            </thead>
                        </table>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<div class="modal fade" id="mdlGestionarNucleo" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-main py-2">
                <h6 class="modal-title titulo_modal_Nucleo">Registrar Nucleo</h6>
                <button type="button" class="text-white m-0 px-1 badge badge-pill badge-danger" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>

            <div class="modal-body">

                <form class="needs-validation-Nucleo" novalidate>

                    <div class="row">

                        <div class="col-12 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i
                                    class="fas fa-ruler mr-1 my-text-color"></i>Nucleo</label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm"
                                id="nucleo" name="nucleo" aria-label="Small" aria-describedby="inputGroup-sizing-sm"
                                required>
                            <div class="invalid-feedback">Ingrese el codigo Centro costo</div>
                        </div>
                        
                        <div class="col-md-12 mt-3 text-center">
                            <a class="btn btn-sm btn-success fw-bold" id="btnRegistrarNucleo"
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
    var $global_id_nucleo= 0;

$(document).ready(function() {
    fnc_CargarDatatableNucleo();
    $('#mdlGestionarNucleo').on('hidden.bs.modal', function () {
        limpiarNucleo();
    });
    $("#btnRegistrarNucleo").on('click', function() {
        fnc_guardarNucleo();
    });

    // Evento para editar un centro de costo
    $('#tbl_nucleo tbody').on('click', '.btnEditarNucleo', function() {
        var data = $('#tbl_nucleo').DataTable().row($(this).parents('tr')).data();
        fnc_MostrarModalEditarNucleo(data);
    });

    $('#tbl_nucleo tbody').on('click', '.btnEliminarNucleo', function() {
        var data = $('#tbl_nucleo').DataTable().row($(this).parents('tr')).data();
        fnc_EliminarNucleo(data.id);
    });

    $('#tbl_nucleo tbody').on('click', '.btnActivarNucleo', function() {
        var data = $('#tbl_nucleo').DataTable().row($(this).parents('tr')).data();
        fnc_CambiarEstadoNucleo(data.id, 1); // Activar
    });

    $('#tbl_nucleo tbody').on('click', '.btnDesactivarNucleo', function() {
        var data = $('#tbl_nucleo').DataTable().row($(this).parents('tr')).data();
        fnc_CambiarEstadoNucleo(data.id, 0); // Desactivar
    });

});




function fnc_CargarDatatableNucleo() {
        if ($.fn.DataTable.isDataTable('#tbl_nucleo')) {
            $('#tbl_nucleo').DataTable().destroy();
            $('#tbl_nucleo tbody').empty();
        }

        $("#tbl_nucleo").DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    text: 'Agregar Nuevo Nucleo',
                    className: 'addNewRecord',
                    action: function(e, dt, node, config) {
                        $(".titulo_modal_Nucleo").html("Registrar Nucleo");
                        $("#mdlGestionarNucleo").modal('show');
                    }
                },
                {
                    extend: 'excel',
                    title: 'LISTADO DE NUCLEO'
                },
                'pageLength'
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('nucleo.listar') }}", // Ruta definida en web.php
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
                    data: 'cod' // Corresponde a 'nomb_nucleo' en el controlador
                },
                {
                    data: 'estado'
                }
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
                            <span class='btnEditarNucleo text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Editar Nucleo'> 
                                <i class='fas fa-pencil-alt fs-5'></i> 
                            </span> 
                            <span class='btnEliminarNucleo text-danger px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar Nucleo'> 
                                <i class='fas fa-trash fs-5'></i> 
                            </span>`;

                        if (full.estado === "ACTIVO") {
                            opciones += `
                            <span class='btnDesactivarNucleo text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Desactivar Nucleo'>
                                <i class='fas fa-toggle-on fs-5'></i> 
                            </span>`;
                        } else {
                            opciones += `
                            <span class='btnActivarNucleo text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Activar Nucleo'>
                                <i class='fas fa-toggle-off fs-5'></i>
                            </span>`;
                        }

                        opciones += `</center>`;
                        return opciones;
                    }
                },
                {
                    targets: 3, // Columna de estado
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

function limpiarNucleo(){
    $('#nucleo').val('');
    $('.needs-validation-CentroCosto').removeClass('was-validated');
    $global_id_nucleo = 0; // Reiniciar el ID global

}

function fnc_MostrarModalEditarNucleo(data) {
    // Asignamos el ID globalmente para saber que estamos editando
    $global_id_nucleo = data.id; 

    // Asignamos los valores al formulario
    $("#nucleo").val(data.cod); 

    $(".titulo_modal_Nucleo").html("Actualizar Nucleo");
    $("#mdlGestionarNucleo").modal('show');
}


function fnc_guardarNucleo() {
    // Validar los campos antes de enviar
    const formValid = $('.needs-validation-Nucleo')[0].checkValidity();
    $('.needs-validation-Nucleo').addClass('was-validated');

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
    formData.append('nomb_nucleo', $('#nucleo').val()); // Campo para el nombre del núcleo

// Determinar si se creará o actualizará el núcleo
if ($global_id_nucleo && $global_id_nucleo > 0) { // Validar que $global_id_nucleo sea válido
    // Modo edición: omitimos `codigo` en el FormData
    var url = "{{ route('nucleo.actualizar', '') }}/" + $global_id_nucleo;
} else {
    // Modo registro: incluimos `codigo`
    formData.append('codigo', $('#codigo').val()); // Campo para el código del núcleo (si es necesario)
    var url = "{{ route('nucleo.guardar') }}";
}

$.ajax({
    url: url,
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
        if (response.tipo_msj == 'success') {
            Swal.fire({
                icon: 'success',
                title: response.msj,
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                $('#mdlGestionarNucleo').modal('hide');

                fnc_CargarDatatableNucleo(); // Recargar el DataTable después de guardar
                limpiarNucleo(); // Limpiar campos después de guardar
                $global_id_centrocosto = 0; // Reiniciar el ID global después de guardar o actualizar
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.msj,
            });
        }
    },
    error: function(error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ha ocurrido un error al procesar la solicitud.',
        });
    }
});
}

function fnc_EliminarNucleo(id) {
    Swal.fire({
        title: '¿Está seguro de eliminar este núcleo?',
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
                url: "{{ route('nucleo.eliminar', '') }}/" + id,
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
                        fnc_CargarDatatableNucleo(); // Recargar el DataTable después de eliminar
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al eliminar el núcleo. Intente nuevamente.',
                    });
                }
            });
        }
    });
}

function fnc_CambiarEstadoNucleo(id, estado) {
    const estadoTexto = estado === 1 ? 'activar' : 'desactivar';
    Swal.fire({
        title: `¿Está seguro de ${estadoTexto} este núcleo?`,
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
                url: "{{ route('nucleo.cambiarEstado', '') }}/" + id,
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
                        fnc_CargarDatatableNucleo(); // Actualizar la tabla
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




</script>
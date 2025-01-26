<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Categoria</h2>
            </div><!-- /.col -->
            <div class="col-sm-6  d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Categoria</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">

    <div class="container-fluid">

        <div class="card card-gray shadow mt-4">

            <div class="card-body px-3 py-3" style="position: relative;">

                <span class="titulo-fieldset px-3 py-1">LISTADO DE Categorias</span>

                <div class="row my-3">

                    <div class="col-12">
                        <table id="tbl_categorias" class="table table-striped w-100 shadow border border-secondary">
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

<div class="modal fade" id="mdlGestionarCategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-main py-2">
                <h6 class="modal-title titulo_modal_Categoria">Registrar Categoría</h6>
                <button type="button" class="text-white m-0 px-1 badge badge-pill badge-danger" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>

            <div class="modal-body">

                <form class="needs-validation-Categoria" novalidate>

                    <div class="row">

                        <div class="col-12 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-layer-group mr-1 my-text-color"></i>Codigo</label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="codigo" name="codigo" aria-label="Small" aria-describedby="inputGroup-sizing-sm" required>
                            <div class="invalid-feedback">Ingrese el codigo de la categoría</div>
                        </div>

                        <div class="col-12 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-layer-group mr-1 my-text-color"></i>Categoría</label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="descripcion" name="descripcion" aria-label="Small" aria-describedby="inputGroup-sizing-sm" required>
                            <div class="invalid-feedback">Ingrese la categoría</div>
                        </div>

                        <div class="col-md-12 mt-3 text-center">
                            <a class="btn btn-sm btn-success fw-bold" id="btnRegistrarCategoria" style="position: relative; width: 50%;">
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
    var $global_id_Categoria = 0;
    $(document).ready(function() {
    fnc_CargarDatatableCategoria();

        $('#mdlGestionarCategoria').on('hidden.bs.modal', function () {
            limpiarCamposCategoria();
        });
        
        $("#btnRegistrarCategoria").on('click', function() {
            fnc_guardarCategoria();
        })

        $('#tbl_categorias tbody').on('click', '.btnEditarCategoria', function() {
        var data = $('#tbl_categorias').DataTable().row($(this).parents('tr')).data();
        fnc_MostrarModalEditarCategoria(data);
        });

        $('#tbl_categorias tbody').on('click', '.btnEliminarCategoria', function() {
            var data = $('#tbl_categorias').DataTable().row($(this).parents('tr')).data();
            fnc_EliminarCategoria(data.id);
        });

        $('#tbl_categorias tbody').on('click', '.btnActivarCategoria', function() {
            var data = $('#tbl_categorias').DataTable().row($(this).parents('tr')).data();
            fnc_CambiarEstadoCategoria(data.id, 1); 
        });

        $('#tbl_categorias tbody').on('click', '.btnDesactivarCategoria', function() {
            var data = $('#tbl_categorias').DataTable().row($(this).parents('tr')).data();
            fnc_CambiarEstadoCategoria(data.id, 0); 
        });
});

function fnc_CargarDatatableCategoria() {
    if ($.fn.DataTable.isDataTable('#tbl_categorias')) {
        $('#tbl_categorias').DataTable().destroy();
        $('#tbl_categorias tbody').empty();
    }

    $("#tbl_categorias").DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Agregar Categoria',
                className: 'addNewRecord',
                action: function(e, dt, node, config) {
                    $(".titulo_modal_Categoria").html("Registrar Categoria");
                    $("#mdlGestionarCategoria").modal('show');
                }
            },
            {
                extend: 'excel',
                title: 'LISTADO DE CATEGORIAS'
            },
            'pageLength'
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('categoria.listar') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            { data: 'opciones', orderable: false, searchable: false },
            { data: 'id' },
            { data: 'nombre_categoria' },
            { data: 'estado' },
        ],
        scrollX: true,
        columnDefs: [
            { className: "dt-center", targets: "_all" },
            {
                targets: 0,
                "width": "10%",
                sortable: false,
                render: function(data, type, full, meta) {
                    let opciones = `
                        <center>
                            <span class='btnEditarCategoria text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Editar Categoria'> 
                                <i class='fas fa-pencil-alt fs-5'></i> 
                            </span> 
                            <span class='btnEliminarCategoria text-danger px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar Categoria'> 
                                <i class='fas fa-trash fs-5'></i> 
                            </span>`;

                    if (full.estado === "ACTIVO") {
                        opciones += `
                            <span class='btnDesactivarCategoria text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Desactivar Categoria'>
                                <i class='fas fa-toggle-on fs-5'></i> 
                            </span>`;
                    } else {
                        opciones += `
                            <span class='btnActivarCategoria text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Activar Categoria'>
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
                        $(td).html('<span class="bg-success px-2 py-1 rounded-pill fw-bold"> ' + rowData.estado + ' </span>');
                    } else if (rowData.estado === 'INACTIVO') {
                        $(td).html('<span class="bg-danger px-2 py-1 rounded-pill fw-bold"> ' + rowData.estado + ' </span>');
                    }
                }
            },
        ],
        language: {
            url: 'assets/languages/Spanish.json'
        }
    });
}


function fnc_guardarCategoria() {
    // Validar los campos antes de enviar
    const formValid = $('.needs-validation-Categoria')[0].checkValidity();
    $('.needs-validation-Categoria').addClass('was-validated');

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
    formData.append('nomb_cate', $('#descripcion').val()); // Campo para la descripción
    formData.append('estado', 1); // Asignar estado activo por defecto

    // Determinar si se creará o actualizará la categoría
    if ($global_id_Categoria && $global_id_Categoria.length > 0){
        // Modo edición: omitimos `codigo` en el FormData
        var url = "{{ route('categoria.actualizar', '') }}/" + $global_id_Categoria;
    } else {
        // Modo registro: incluimos `codigo`
        formData.append('codigo', $('#codigo').val()); // Campo para el código de la categoría
        var url = "{{ route('categoria.guardar') }}";
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
                $('#mdlGestionarCategoria').modal('hide');
                fnc_CargarDatatableCategoria(); // Recargar el DataTable después de guardar
                limpiarCamposCategoria(); // Limpiar campos después de guardar
                $global_id_Categoria = 0; // Reiniciar el ID global después de guardar o actualizar
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




function fnc_EliminarCategoria(id) {
    Swal.fire({
        title: '¿Está seguro de eliminar esta categoría?',
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
                url: "{{ route('categoria.eliminar', '') }}/" + id,
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
                        fnc_CargarDatatableCategoria(); // Recargar el DataTable de categorías
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

function fnc_CambiarEstadoCategoria(id, estado) {
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
                url: "{{ route('categoria.cambiar_estado', '') }}/" + id,
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
                        fnc_CargarDatatableCategoria(); // Actualizar la tabla de categorías
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
function limpiarCamposCategoria() {
    $('#codigo').val('').prop("readonly", false);
    $('#descripcion').val('');
    $('.needs-validation-Categoria').removeClass('was-validated');
}

function fnc_MostrarModalEditarCategoria(data) {
    $global_id_Categoria = data.id; // Asignamos el ID de la categoría globalmente para saber que estamos editando
    $("#codigo").val(data.id).prop("readonly", true); // Código en modo solo lectura
    $("#descripcion").val(data.nombre_categoria);

    $(".titulo_modal_Categoria").html("Actualizar Categoría");
    $("#mdlGestionarCategoria").modal('show');
}
</script>


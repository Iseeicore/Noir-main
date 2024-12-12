<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Centros de Costo</h2>
            </div><!-- /.col -->
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                    <li class="breadcrumb-item active">Listado de Centro costo</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">

    <div class="container-fluid">

        <div class="card card-gray shadow mt-4">

            <div class="card-body px-3 py-3" style="position: relative;">

                <span class="titulo-fieldset px-3 py-1">Listado de Centro costo</span>

                <div class="row my-3">

                    <div class="col-12">
                        <table id="tbl_centrocosto" class="table table-striped w-100 shadow border border-secondary">
                            <thead class="bg-main text-left">
                                <th></th>
                                <th>Id</th>
                                <th>Cod</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Núcleo</th>
                            </thead>
                        </table>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<div class="modal fade" id="mdlGestionarCentroCosto" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-main py-2">
                <h6 class="modal-title titulo_modal_CentroCosto">Registrar Unidad de Medida</h6>
                <button type="button" class="text-white m-0 px-1 badge badge-pill badge-danger" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>

            <div class="modal-body">

                <form class="needs-validation-CentroCosto" novalidate>

                    <div class="row">

                        <div class="col-12 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i
                                    class="fas fa-ruler mr-1 my-text-color"></i>Codigo</label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm"
                                id="codigo" name="codigo" aria-label="Small" aria-describedby="inputGroup-sizing-sm"
                                required>
                            <div class="invalid-feedback">Ingrese el codigo Centro costo</div>
                        </div>

                        <div class="col-12 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i
                                    class="fas fa-ruler mr-1 my-text-color"></i>Centro Costo</label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm"
                                id="descripcion" name="descripcion" aria-label="Small"
                                aria-describedby="inputGroup-sizing-sm" required>
                            <div class="invalid-feedback">Ingrese nombre de Centro Costo</div>
                        </div>

                        <div class="col-12 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-ruler mr-1 my-text-color"></i>Núcleo</label>
                            <select class="form-select form-select-sm select2 cursor-pointer" id="nucleo" name="nucleo" required>
                                <!-- Aquí puedes cargar las opciones del núcleo -->
                            </select>
                            <div class="invalid-feedback">Seleccione un núcleo</div>
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
    var $global_id_centrocosto = 0;
    $(document).ready(function() {
        fnc_CargarDatatableCentroCosto();

    $('#mdlGestionarCentroCosto').on('hidden.bs.modal', function () {
        limpiarCamposCentroCosto();
    });

    $('#tbl_centrocosto tbody').on('click', '.btnEliminarCentroCosto', function() {
        var data = $('#tbl_centrocosto').DataTable().row($(this).parents('tr')).data();
        fnc_EliminarCentroCosto(data.id);
    });
    
    $('#tbl_centrocosto tbody').on('click', '.btnActivarCentroCosto', function() {
        var data = $('#tbl_centrocosto').DataTable().row($(this).parents('tr')).data();
        fnc_CambiarEstadoCentroCosto(data.id, 1); // Activar
    });

    $('#tbl_centrocosto tbody').on('click', '.btnDesactivarCentroCosto', function() {
        var data = $('#tbl_centrocosto').DataTable().row($(this).parents('tr')).data();
        fnc_CambiarEstadoCentroCosto(data.id, 0); // Desactivar
    });

    $("#btnRegistrarUnidadMedida").on('click', function() {
        fnc_guardarCentroCosto();
    });

    // Evento para editar un centro de costo
    $('#tbl_centrocosto tbody').on('click', '.btnEditarCentroCosto', function() {
        var data = $('#tbl_centrocosto').DataTable().row($(this).parents('tr')).data();
        fnc_MostrarModalEditarCentroCosto(data);
    });
    cargarnucleos();
    });


    function cargarnucleos() {
        $.ajax({
            url: '{{ route('centro-costo.cargar_nucleo') }}',
            // Ruta para obtener los núcleos
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#nucleo'); 
                select.empty(); 
                select.append('<option value="" class="text-center">-- Seleccione el nucleo --</option>'); // Opción predeterminada
                data.nucleo.forEach(function(nucleo) {  // Acceder a data.nucleo
                    select.append('<option value="' + nucleo.id + '">' + nucleo.nomb_nucleo + '</option>');
                });
            },
            error: function(xhr) {
                console.error('Error al cargar áreas:', xhr.responseText);
            }
        });
    }


    function fnc_EliminarCentroCosto(id) {
        Swal.fire({
            title: '¿Está seguro de eliminar este centro de costo?',
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
                    url: "{{ route('centro-costo.eliminar', '') }}/" + id,
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
                            fnc_CargarDatatableCentroCosto(); // Recargar el DataTable después de eliminar
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al eliminar el centro de costo. Intente nuevamente.',
                        });
                    }
                });
            }
        });
    }


    function fnc_CargarDatatableCentroCosto() {
        if ($.fn.DataTable.isDataTable('#tbl_centrocosto')) {
            $('#tbl_centrocosto').DataTable().destroy();
            $('#tbl_centrocosto tbody').empty();
        }

        $("#tbl_centrocosto").DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    text: 'Agregar Centro de Costo',
                    className: 'addNewRecord',
                    action: function(e, dt, node, config) {
                        $(".titulo_modal_CentroCosto").html("Registrar Centro de Costo");
                        $("#mdlGestionarCentroCosto").modal('show');
                    }
                },
                {
                    extend: 'excel',
                    title: 'LISTADO DE CENTROS DE COSTO'
                },
                'pageLength'
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('centro-costo.listar') }}",
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
                    data: 'cod'
                },
                {
                    data: 'nombre'
                },
                {
                    data: 'estado'
                },
                {
                    data: 'nucleo' // Nueva columna para el núcleo
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
                            <span class='btnEditarCentroCosto text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Editar Centro de Costo'> 
                                <i class='fas fa-pencil-alt fs-5'></i> 
                            </span> 
                            <span class='btnEliminarCentroCosto text-danger px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar Centro de Costo'> 
                                <i class='fas fa-trash fs-5'></i> 
                            </span>`;

                        if (full.estado === "ACTIVO") {
                            opciones += `
                            <span class='btnDesactivarCentroCosto text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Desactivar Centro de Costo'>
                                <i class='fas fa-toggle-on fs-5'></i> 
                            </span>`;
                        } else {
                            opciones += `
                            <span class='btnActivarCentroCosto text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Activar Centro de Costo'>
                                <i class='fas fa-toggle-off fs-5'></i>
                            </span>`;
                        }

                        opciones += `</center>`;
                        return opciones;
                    }
                },
                {
                    targets: 4,
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

    function limpiarCamposCentroCosto() {
        $('#codigo').val('').prop("readonly", false);
        $('#descripcion').val('');
        $('#nucleo').val('').trigger('change'); // Para select2
        $('.needs-validation-CentroCosto').removeClass('was-validated');
        $global_id_centrocosto = 0; // Reiniciar el ID global
    }



    function fnc_CambiarEstadoCentroCosto(id, estado) {
        const estadoTexto = estado === 1 ? 'activar' : 'desactivar';
        Swal.fire({
            title: `¿Está seguro de ${estadoTexto} este centro de costo?`,
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
                    url: "{{ route('centro-costo.cambiar_estado', '') }}/" + id,
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
                            fnc_CargarDatatableCentroCosto(); // Actualizar la tabla
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
    function fnc_MostrarModalEditarCentroCosto(data) {
        // console.log(data);
        $global_id_centrocosto = data.id; // Asignamos el ID globalmente para saber que estamos editando
        $("#codigo").val(data.cod).prop("readonly", true); // Código en modo solo lectura
        $("#descripcion").val(data.nombre); // Rellenar el campo de descripción

        // Seleccionar el núcleo en el select
        $('#nucleo').val(data.nucleo_id).trigger('change'); // Rellenar el campo de núcleo y disparar el evento change

        $(".titulo_modal_CentroCosto").html("Actualizar Centro de Costo");
        $("#mdlGestionarCentroCosto").modal('show');
    }


    function fnc_guardarCentroCosto() {
        // Validar los campos antes de enviar
        const formValid = $('.needs-validation-CentroCosto')[0].checkValidity();
        $('.needs-validation-CentroCosto').addClass('was-validated');

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
        formData.append('nomb_centroCos', $('#descripcion').val()); // Campo para el nombre del centro de costo
        formData.append('nucleo', $('#nucleo').val()); // Campo para el núcleo

        // Determinar si se creará o actualizará el centro de costo
        if ($global_id_centrocosto && $global_id_centrocosto > 0) { // Validar que $global_id_centrocosto sea válido
            // Modo edición: omitimos `codigo` en el FormData
            var url = "{{ route('centro-costo.actualizar', '') }}/" + $global_id_centrocosto;
        } else {
            // Modo registro: incluimos `codigo`
            formData.append('codigo', $('#codigo').val()); // Campo para el código del centro de costo
            var url = "{{ route('centro-costo.guardar') }}";
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
                    $('#mdlGestionarCentroCosto').modal('hide');
                    fnc_CargarDatatableCentroCosto(); // Recargar el DataTable después de guardar
                    limpiarCamposCentroCosto(); // Limpiar campos después de guardar
                    $global_id_centrocosto = 0; // Reiniciar el ID global después de guardar o actualizar
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un problema al guardar el centro de costo. Intente nuevamente.',
                });
            }
        });
    }



</script>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Proveedores</h2>
            </div><!-- /.col -->
            <div class="col-sm-6  d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Registro de Proveedores</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<div class="content">

    <div class="container-fluid">

        <div class="card card-gray shadow mt-4">

            <div class="card-body px-3 py-3" style="position: relative;">

                <span class="titulo-fieldset px-3 py-1">LISTADO DE PROVEEDORES</span>

                <div class="row my-3">

                    <div class="col-12">
                        <table id="tbl_Proveedor" class="table table-striped w-100 shadow border border-secondary">
                            <thead class="bg-main text-left">
                                <th></th>
                                <th>Id</th>
                                <th>Codigo</th>
                                <th>Ruc</th>    
                                <th>Razón Social</th>
                                <th>Estado</th>
                                <th>Contacto</th>
                                <th>Numero</th>
                                <th style="display:none;">Direccion</th>
                                <th style="display:none;">Email</th>
                            </thead>
                        </table>
                    </div>

                </div>

            </div>

        </div>

    </div>


</div>


<div class="modal fade" id="mdlGestionarProveedor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-main py-2">
                <h6 class="modal-title titulo_modal_Proveedor">Registrar Proveedor</h6>
                <button  type="button" class="text-white m-0 px-1 badge badge-pill badge-danger" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>

            <div class="modal-body">

                <form class="needs-validation-Proveedor" novalidate>

                    <div class="row">

                         <!-- Código (readonly) -->
                         <div class="col-12 col-lg-3 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-barcode mr-1 my-text-color"></i>Código</label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="cod_proveedor" name="cod_proveedor" readonly>
                        </div>

                        <!-- RUC -->
                        <div class="col-12 col-lg-8 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-id-card mr-1 my-text-color"></i>RUC</label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="ruc" name="ruc" required>
                            <div class="invalid-feedback">Ingrese el RUC</div>
                        </div>

                        <!-- Botón de búsqueda -->
                        <div class="col-12 col-lg-1 mb-2 d-flex align-items-end">
                            <button id="Buscar" type="button" class="btn btn-sm d-flex align-items-center justify-content-center bg-main" style="border-radius: 20px; width: 100%; height: calc(1.5em + .75rem + 2px);">
                                <i class="fas fa-search text-white"></i>
                            </button>
                        </div>


                        <!-- Razón Social -->
                        <div class="col-12 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-building mr-1 my-text-color"></i>Razón Social</label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="razon_social" name="razon_social" required>
                            <div class="invalid-feedback">Ingrese la Razón Social</div>
                        </div>

                        <!-- Dirección -->
                        <div class="col-12 col-lg-6 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-map-marker-alt mr-1 my-text-color"></i>Dirección</label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="direccion" name="direccion" required>
                            <div class="invalid-feedback">Ingrese la Dirección</div>
                        </div>

                        <!-- Contacto -->
                        <div class="col-12 col-lg-6 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-user mr-1 my-text-color"></i>Contacto</label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="contacto" name="contacto" required>
                            <div class="invalid-feedback">Ingrese el Contacto</div>
                        </div>

                        <!-- Número -->
                        <div class="col-12 col-lg-6 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-hashtag mr-1 my-text-color"></i>Número</label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="numero" name="numero" required minlength="9"
                            maxlength="9" pattern="\d{9}">
                            <div class="invalid-feedback">Ingrese el Número</div>
                        </div>

                        <!-- Email -->
                        <div class="col-12 col-lg-6 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-envelope mr-1 my-text-color"></i>Email</label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="email" name="email" required>
                            <div class="invalid-feedback">Ingrese el Email</div>
                        </div>


                        <div class="col-md-12 mt-3 text-center">
                            <a class="btn btn-sm btn-success  fw-bold " id="btnRegistrarProveedor" style="position: relative; width: 50%;">
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
    var $global_id_Proveedor = 0;

    $(document).ready(function() {
        fnc_CargarDatatableProveedores();


        // Limpiar campos al cerrar el modal
        $('#mdlGestionarProveedor').on('hidden.bs.modal', function () {
            limpiarCamposProveedor();
        });
        $('#btnRegistrarProveedor').on('click', function() {
            fnc_guardarProveedor();
        });
        $('#tbl_Proveedor tbody').on('click', '.btnEditarProveedor', function() {
            var data = $('#tbl_Proveedor').DataTable().row($(this).parents('tr')).data();
            fnc_MostrarModalEditar(data);
        });
        $('#tbl_Proveedor tbody').on('click', '.btnEliminarProveedor', function() {
            var data = $('#tbl_Proveedor').DataTable().row($(this).parents('tr')).data();
            fnc_EliminarProveedor(data.id);
        });

        $('#tbl_Proveedor tbody').on('click', '.btnActivarProveedor', function() {
            var data = $('#tbl_Proveedor').DataTable().row($(this).parents('tr')).data();
            fnc_CambiarEstadoProveedor(data.id, 1); 
        });

        $('#tbl_Proveedor tbody').on('click', '.btnDesactivarProveedor', function() {
            var data = $('#tbl_Proveedor').DataTable().row($(this).parents('tr')).data();
            fnc_CambiarEstadoProveedor(data.id, 0); 
        });




        // Evento para mostrar modal de edición
            $('#Buscar').click(function() {
            let ruc = $('#ruc').val();

            // Validar si el RUC tiene 11 dígitos
            if (ruc.length !== 11) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El RUC debe tener 11 dígitos. Verifique e intente de nuevo.',
                });
                return;
            }

            // Hacer la solicitud AJAX al controlador
            $.ajax({
                url: "{{ route('proveedores.obtener_datos_ruc') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ruc: ruc
                },
                success: function(response) {
                    if (response.success) {
                        $('#razon_social').val(response.razon_social);
                        $('#direccion').val(response.direccion);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al consultar el RUC. Intente nuevamente.',
                    });
                }
            });
        });
    });


    function fnc_CargarDatatableProveedores() {
        if ($.fn.DataTable.isDataTable('#tbl_Proveedor')) {
            $('#tbl_Proveedor').DataTable().destroy();
            $('#tbl_Proveedor tbody').empty();
        }

        $("#tbl_Proveedor").DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Agregar Proveedor',
                    className: 'addNewRecord',
                    action: function(e, dt, node, config) {
                        obtenerCodigoProveedor();
                        $(".titulo_modal_Proveedor").html("Registrar Proveedor");
                        $("#mdlGestionarProveedor").modal('show');
                    }
                },
                {
                    extend: 'excel',
                    title: 'LISTADO DE PROVEEDORES'
                },
                'pageLength'
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('proveedores.listar') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                }
            },
            columns: [
                { data: 'opciones', orderable: false, searchable: false },
                { data: 'id'},
                { data: 'codigo' },
                { data: 'ruc' },
                { data: 'razon_social' },
                { data: 'estado' },
                { data: 'contacto' },
                { data: 'numero' },
                { data: 'direccion', visible: false }, 
                { data: 'email', visible: false}      
                
            ],
            scrollX: true,
            columnDefs: [
                { className: "dt-center", targets: "_all" },
                {
                // Ocultar las columnas de dirección y email
                targets: [7, 8], // Índices de columnas a ocultar
                visible: false,
                searchable: false // También puede desactivar la búsqueda en estas columnas si no se necesita
                },
                {
                    targets: 0,
                    "width": "10%",
                    sortable: false,
                    render: function(data, type, full, meta) {

                        $opciones = '';

                        $opciones = $opciones +
                            `<center>
                                    <span class='btnEditarProveedor text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Editar Proveedor'> 
                                        <i class='fas fa-pencil-alt fs-5'></i> 
                                    </span> 
                                    <span class='btnEliminarProveedor text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar Proveedor'> 
                                        <i class='fas fa-trash fs-5'> </i> 
                                    </span>`;


                        if (full.estado == "ACTIVO") {
                            $opciones = $opciones +
                                `<span class='btnDesactivarProveedor text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Desactivar Proveedor'>
                                        <i class='fas fa-toggle-on  fs-5'></i> 
                                    </span>`;

                        } else {
                            $opciones = $opciones +
                                `<span class='btnActivarProveedor text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Activar Proveedor'>
                                        <i class='fas fa-toggle-off  fs-5'></i>
                                    </span>`;
                        }

                        $opciones = $opciones + `</center>`;

                        return $opciones;

                    }
                },
                {
                    targets: 5,
                    "width": "25%",
                    createdCell: function(td, cellData, rowData, row, col) {

                        if (rowData.estado == 'ACTIVO') {
                            $(td).html('<span class="bg-success px-2 py-1 rounded-pill fw-bold"> ' + rowData.estado + ' </span>')
                        }

                        if (rowData.estado == 'INACTIVO') {
                            $(td).html('<span class="bg-danger px-2 py-1 rounded-pill fw-bold"> ' + rowData.estado + ' </span>')
                        }

                    }
                },
            ],
            language: {
                url: 'assets/languages/Spanish.json'
            }
        });
    }
        // Función para obtener el siguiente código de proveedor y rellenar el campo cod_proveedor
    function obtenerCodigoProveedor() {
        $.ajax({
            url: "{{ route('proveedores.generar_codigo') }}",
            type: 'GET',
            success: function(response) {
                $('#cod_proveedor').val(response.nuevo_codigo); // Rellenar el campo cod_proveedor
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo generar el código del proveedor. Intente nuevamente.',
                });
            }
        });
    }
    function limpiarCamposProveedor() {
        $('#cod_proveedor').val('');      // Limpiar el campo de Código
        $('#ruc').val('');                // Limpiar el campo de RUC
        $('#razon_social').val('');       // Limpiar el campo de Razón Social
        $('#direccion').val('');          // Limpiar el campo de Dirección
        $('#contacto').val('');           // Limpiar el campo de Contacto
        $('#numero').val('');             // Limpiar el campo de Número
        $('#email').val('');              // Limpiar el campo de Email

        // Opcional: eliminar mensajes de error de validación
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').hide();
        }   

    function fnc_MostrarModalEditar(data){
        $global_id_Proveedor = data.id; // Asignamos el ID del proveedor globalmente para saber que estamos editando
        $("#cod_proveedor").val(data.codigo).prop("readonly", true); // Código en modo solo lectura
        $("#ruc").val(data.ruc);
        $("#razon_social").val(data.razon_social).prop("readonly", true);
        $("#direccion").val(data.direccion).prop("readonly", true);
        $("#contacto").val(data.contacto);
        $("#numero").val(data.numero);
        $("#email").val(data.email);

        $(".titulo_modal_Proveedor").html("Actualizar Proveedor");
        $("#mdlGestionarProveedor").modal('show');
    }

    function fnc_guardarProveedor() {
        // Validar los campos antes de enviar
        const formValid = $('.needs-validation-Proveedor')[0].checkValidity();
        $('.needs-validation-Proveedor').addClass('was-validated');

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
        formData.append('cod_proveedor', $('#cod_proveedor').val());
        formData.append('ruc', $('#ruc').val());
        formData.append('razon_social', $('#razon_social').val());
        formData.append('direccion', $('#direccion').val());
        formData.append('contacto', $('#contacto').val());
        formData.append('numero', $('#numero').val());
        formData.append('email', $('#email').val());

        // Si $global_id_Proveedor es mayor a 0, se actualiza; si es 0, se crea un nuevo proveedor
        var url = $global_id_Proveedor > 0 
            ? "{{ route('proveedores.actualizar', '') }}/" + $global_id_Proveedor
            : "{{ route('proveedores.guardar') }}";
        formData.append('estado', 1); // Asignar estado activo por defecto

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
                    $('#mdlGestionarProveedor').modal('hide');
                    fnc_CargarDatatableProveedores();
                    limpiarCamposProveedor(); // Limpiar campos después de guardar
                    $global_id_Proveedor = 0; // Reiniciar el ID global después de guardar o actualizar
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un problema al guardar el proveedor. Intente nuevamente.',
                });
            }
        });
    }

    function fnc_EliminarProveedor(id) {
        Swal.fire({
            title: '¿Está seguro de eliminar este proveedor?',
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
                    url: "{{ route('proveedores.eliminar', '') }}/" + id,
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
                            fnc_CargarDatatableProveedores();
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al eliminar el proveedor. Intente nuevamente.',
                        });
                    }
                });
            }
        });
    }

    function fnc_CambiarEstadoProveedor(id, estado) {
        const estadoTexto = estado === 1 ? 'activar' : 'desactivar';
        Swal.fire({
            title: `¿Está seguro de ${estadoTexto} este proveedor?`,
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
                    url: "{{ route('proveedores.cambiar_estado', '') }}/" + id,
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
                            fnc_CargarDatatableProveedores(); // Actualizar la tabla
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

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">ADMINISTRAR USUARIOS</h2>
            </div><!-- /.col -->
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Administrar Usuarios</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div><!-- /.content-header -->

<div class="content">

    <div class="row">

        <div class="col-12 ">

            <div class="card card-primary card-outline card-outline-tabs">

                <div class="card-header p-0 border-bottom-0">

                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">

                        <!-- TAB LISTADO DE USUARIOS -->
                        <li class="nav-item">
                            <a class="nav-link active my-0" id="listado-usuarios-tab" data-toggle="pill"
                                href="#listado-usuarios" role="tab" aria-controls="listado-usuarios"
                                aria-selected="true"><i class="fas fa-list"></i> Listado de Usuarios</a>
                        </li>

                        <!-- TAB REGISTRO DE USUARIOS -->
                        <li class="nav-item">
                            <a class="nav-link my-0" id="registrar-usuarios-tab" data-toggle="pill"
                                href="#registrar-usuarios" role="tab" aria-controls="registrar-usuarios"
                                aria-selected="false"><i class="fas fa-file-signature"></i> Registro de Usuario</a>
                        </li>
                    </ul>

                </div>

                <div class="card-body">

                    <div class="tab-content" id="custom-tabs-four-tabContent">

                        <!-- TAB CONTENT LISTADO DE USUARIOS -->
                        <div class="tab-pane fade active show" id="listado-usuarios" role="tabpanel"
                            aria-labelledby="listado-usuarios-tab">

                            <div class="row">

                                <!--LISTADO DE USUARIOS -->
                                <div class="col-md-12">
                                    <table id="tbl_usuarios" class="table table-striped w-100 shadow border border-secondary">
                                        <thead class="bg-main text-left">
                                            <th></th> <!-- Columna de detalles -->
                                            <th></th> <!-- Columna de opciones -->
                                            <th>Id</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Usuario</th>
                                            <th>Dni</th>
                                            <th>Perfil</th>
                                            <th>Área</th> <!-- Nueva columna de Área -->
                                            <th>Almacén</th> <!-- Nueva columna -->
                                            <th>Estado</th>
                                        </thead>
                                    </table>
                                    
                                </div>

                            </div>

                        </div>

                        <!-- TAB CONTENT REGISTRO DE USUARIOS -->
                        <div class="tab-pane fade" id="registrar-usuarios" role="tabpanel"
                            aria-labelledby="registrar-usuarios-tab">

                            <form id="frm-datos-usuarios" class="needs-validation-usuarios" novalidate>

                                <div class="row">

                                    <!-- NOMBRES -->
                                    <div class="col-3 mb-2">
                                        <input type="hidden" name="id_usuario" id="id_usuario" value="0">
                                        <label class="mb-0 ml-1 text-sm my-text-color"><i
                                                class="fas fa-user-alt mr-1 my-text-color"></i>Nombres</label>
                                        <input type="text" style="border-radius: 20px;"
                                            placeholder="Ingrese los nombres del usuario"
                                            class="form-control form-control-sm " id="nombres" name="nombres"
                                            aria-label="Small" aria-describedby="inputGroup-sizing-sm" required>
                                        <div class="invalid-feedback">Ingrese el nombre del usuario</div>
                                    </div>

                                    <!-- APELLIDOS -->
                                    <div class="col-3 mb-2">
                                        <label class="mb-0 ml-1 text-sm my-text-color"><i
                                                class="fas fa-user-alt mr-1 my-text-color"></i>Apellidos</label>
                                        <input type="text" style="border-radius: 20px;"
                                            placeholder="Ingrese los apellidos del usuario"
                                            class="form-control form-control-sm " id="apellidos" name="apellidos"
                                            aria-label="Small" aria-describedby="inputGroup-sizing-sm" required>
                                        <div class="invalid-feedback">Ingrese el apellidos del usuario</div>
                                        <!-- </div> -->

                                    </div>

                                    <!-- USUARIO DEL SISTEMA -->
                                    <div class="col-3 mb-2">
                                        <label class="mb-0 ml-1 text-sm my-text-color"><i
                                                class="fas fa-id-card mr-1 my-text-color"></i>Usuario del
                                            Sistema</label>
                                        <input type="text" style="border-radius: 20px;"
                                            placeholder="Ingrese el usuario del sistema"
                                            class="form-control form-control-sm" id="usuario" name="usuario"
                                            aria-label="Small" id_usuario="0" aria-describedby="inputGroup-sizing-sm"
                                            onchange="validateJS(event, 'usuario_sistema')" required>
                                        <div class="invalid-feedback">Ingrese usuario del sistema</div>
                                    </div>

                                    <!-- DNI -->
                                    <div class="col-3 mb-2">
                                        <label class="mb-0 ml-1 text-sm my-text-color">
                                            <i class="fas fa-lock mr-1 my-text-color"></i>Dni
                                        </label>
                                        <input type="text" style="border-radius: 20px;"
                                            placeholder="Ingrese un dni" class="form-control form-control-sm"
                                            id="dni" name="dni" aria-label="Small"
                                            aria-describedby="inputGroup-sizing-sm" required minlength="8"
                                            maxlength="8" pattern="\d{8}"
                                            title="Debe ingresar exactamente 8 dígitos">
                                        <div class="invalid-feedback">Ingrese un DNI de 8 dígitos</div>
                                    </div>

                                    <!-- PASSWORD -->
                                    <div class="col-3 mb-2">
                                        <label class="mb-0 ml-1 text-sm my-text-color"><i
                                                class="fas fa-lock mr-1 my-text-color"></i>Contraseña</label>
                                        <input type="password" style="border-radius: 20px;"
                                            placeholder="Ingrese el password" class="form-control form-control-sm"
                                            id="password" name="password" aria-label="Small"
                                            aria-describedby="inputGroup-sizing-sm" required>
                                        <div class="invalid-feedback">Ingrese la contraseña</div>
                                    </div>

                                    <!-- PERFIL -->
                                    <div class="col-3 mb-2">
                                        <label class="mb-0 ml-1 text-sm my-text-color"><i
                                                class="fas fa-id-card-alt mr-1 my-text-color"></i>Perfil</label>
                                        <select class="form-select" id="perfil" name="perfil"
                                            aria-label="Floating label select example" required>
                                            <option value="">-- Seleccione Perfil --</option>
                                        </select>
                                        <div class="invalid-feedback">Seleccione el Perfil</div>
                                    </div>

                                    <!-- Area -->
                                    <div class="col-3 mb-2">
                                        <label class="mb-0 ml-1 text-sm my-text-color"><i
                                                class="fas fa-id-card-alt mr-1 my-text-color"></i>Area</label>
                                        <select class="form-select" id="Area" name="Area"
                                            aria-label="Floating label select example" required>
                                            <option value="">-- Seleccione el Area --</option>
                                        </select>
                                        <div class="invalid-feedback">Seleccione el Area</div>
                                    </div>

                                    <!-- Almacen -->
                                    <div class="col-3 mb-2">
                                        <label class="mb-0 ml-1 text-sm my-text-color"><i
                                                class="fas fa-id-card-alt mr-1 my-text-color"></i>Almacen</label>
                                        <select class="form-select" id="Almacen" name="Almacen"
                                            aria-label="Floating label select example" required>
                                            <option value="">-- Seleccione el Almacen --</option>
                                        </select>
                                        <div class="invalid-feedback">Seleccione el Almacen</div>
                                    </div>

                                    <!-- ESTADO -->
                                    <div class="col-3 mb-2">
                                        <label class="mb-0 ml-1 text-sm my-text-color"><i
                                                class="fas fa-toggle-on mr-1 my-text-color"></i>Estado</label>
                                        <select class="form-select" id="estado" name="estado"
                                            aria-label="Floating label select example" required>
                                            <option value="" disabled>--Seleccione un estado--</option>
                                            <option value="1" selected>ACTIVO</option>
                                            <option value="0">INACTIVO</option>
                                        </select>
                                        <div class="invalid-feedback">Seleccione el estado</div>
                                    </div>


                                    <div class="col-12 mt-2">
                                        <div class="float-right">
                                            <a class="btn btn-sm btn-danger  fw-bold " id="btnCancelarUsuario"
                                                style="position: relative; width: 160px;">
                                                <span class="text-button">CANCELAR</span>
                                                <span class="btn fw-bold icon-btn-danger ">
                                                    <i class="fas fa-times fs-5 text-white m-0 p-0"></i>
                                                </span>
                                            </a>

                                            <a class="btn btn-sm btn-success  fw-bold " id="btnRegistrarUsuario"
                                                style="position: relative; width: 160px;">
                                                <span class="text-button">GUARDAR</span>
                                                <span class="btn fw-bold icon-btn-success ">
                                                    <i class="fas fa-save fs-5 text-white m-0 p-0"></i>
                                                </span>
                                            </a>
                                        </div>

                                    </div>

                                </div>
                            </form>


                        </div>

                    </div>

                </div>

                <!-- /.card -->
            </div>

        </div>

    </div>

</div>
<script>
$(document).ready(function() {
    cargarPerfiles();
    cargarAreas();
    cargarAlmacenes();
    fnc_CargarDatatableUsuarios();

    // Delegación de eventos para capturar el click en el botón de edición
    $(document).on('click', '.btnEditarUsuario', function() {
        fnc_IrFormularioActualizarUsuario($(this));
    });
});


    function cargarAreas() {
        $.ajax({
            url: '{{ route('listar_areas') }}', // Ruta para obtener las áreas
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#Area'); // Aquí seleccionas el id del select donde mostrarás las áreas
                select.empty(); // Limpiamos el select antes de agregar los nuevos elementos
                select.append('<option value="">-- Seleccione Área --</option>'); // Opción predeterminada
                data.forEach(function(area) {
                    select.append('<option value="' + area.id_area + '">' + area.descripcion + '</option>');
                });
            },
            error: function(xhr) {
                console.error('Error al cargar áreas:', xhr.responseText);
            }
        });
    }

    function cargarAlmacenes() {
        $.ajax({
            url: '{{ route('listar_almacenes_register') }}', // Ruta para obtener las áreas
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#Almacen'); // Aquí seleccionas el id del select donde mostrarás las áreas
                select.empty(); // Limpiamos el select antes de agregar los nuevos elementos
                select.append('<option value="">-- Seleccione Almacenes --</option>'); // Opción predeterminada
                data.forEach(function(almacen) {
                    select.append('<option value="' + almacen.id + '">' + almacen.nomb_almacen + '</option>');
                });
            },
            error: function(xhr) {
                console.error('Error al cargar áreas:', xhr.responseText);
            }
        });
    }

    function cargarPerfiles() {
        $.ajax({
            url: '{{ route('listar_perfiles') }}', // Ruta para obtener los perfiles
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#perfil');
                select.empty();
                select.append('<option value="">-- Seleccione Perfil --</option>');
                data.forEach(function(perfil) {
                    select.append('<option value="' + perfil.id_perfil + '">' + perfil.descripcion +
                        '</option>');
                });
            },
            error: function(xhr) {
                console.error('Error al cargar perfiles:', xhr.responseText);
            }
        });
    }


    function fnc_CargarDatatableUsuarios() {
    if ($.fn.DataTable.isDataTable('#tbl_usuarios')) {
        $('#tbl_usuarios').DataTable().destroy();
        $('#tbl_usuarios tbody').empty();
    }

    $("#tbl_usuarios").DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                title: function () {
                    return 'LISTADO DE USUARIOS';
                }
            },
            'pageLength'
        ],
        pageLength: 10,
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url("/ajax/obtener-usuarios") }}',
            type: 'POST',
            data: function (d) {
                d._token = '{{ csrf_token() }}';
            }
        },
        responsive: {
            details: {
                type: 'column'
            }
        },
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                className: 'control'
            },
            {
                targets: [6],
                visible: false
            },
            {
                targets: 9, // Índice de la columna "Almacén"
                createdCell: function (td, cellData) {
                    $(td).html(cellData); // Muestra el nombre del almacén
                }
            },
            {
                targets: 10, // Índice de la columna "Estado"
                createdCell: function (td, cellData, rowData) {
                    if (rowData[10] !== 'ACTIVO') {
                        $(td).parent().css('background', '#F2D7D5');
                        $(td).parent().css('color', 'black');
                    }
                }
            },
            {
                targets: 1,
                orderable: false,
                createdCell: function (td) {
                    $(td).html("<span class='btnEditarUsuario text-primary px-1' style='cursor:pointer;'>" +
                        "<i class='fas fa-pencil-alt fs-6'></i>" +
                        "</span>");
                }
            }
        ],
        language: {
            url: 'assets/languages/Spanish.json'
        }
    });
}


    // function fnc_CargarDatatableUsuarios() {
    //         if ($.fn.DataTable.isDataTable('#tbl_usuarios')) {
    //             $('#tbl_usuarios').DataTable().destroy();
    //             $('#tbl_usuarios tbody').empty();
    //         }

    //         $("#tbl_usuarios").DataTable({
    //     dom: 'Bfrtip',
    //     buttons: [{
    //         extend: 'excel',
    //         title: function() {
    //             return 'LISTADO DE USUARIOS';
    //         }
    //     }, 'pageLength'],
    //     pageLength: 10,
    //     processing: true,
    //     serverSide: true,
    //     ajax: {
    //         url: '{{ url('/ajax/obtener-usuarios') }}',
    //         type: 'POST',
    //         data: function(d) {
    //             d._token = '{{ csrf_token() }}';
    //         }
    //     },
    //     responsive: {
    //         details: {
    //             type: 'column'
    //         }
    //     },
    //     columnDefs: [{
    //         targets: 0,
    //         orderable: false,
    //         className: 'control'
    //     },
    //     {
    //         targets: [6],
    //         visible: false
    //     },
        
    //     {
    //         targets: 9, // Actualiza el índice si es necesario para la columna "estado"
    //         createdCell: function(td, cellData, rowData) {
    //             if (rowData[9] != 'ACTIVO') {
    //                 $(td).parent().css('background', '#F2D7D5');
    //                 $(td).parent().css('color', 'black');
    //             }
    //         }
    //     },
    //     {
    //         targets: 1,
    //         orderable: false,
    //         createdCell: function(td) {
    //             $(td).html("<span class='btnEditarUsuario text-primary px-1' style='cursor:pointer;'>" +
    //                 "<i class='fas fa-pencil-alt fs-6'></i>" +
    //                 "</span>");
    //         }
    //     }],
    //     language: {
    //         url: 'assets/languages/Spanish.json'
    //     }
    // });
    // }

    //     function fnc_IrFormularioActualizarUsuario(fila_actualizar) {
    //     if (fila_actualizar.parents('tr').hasClass('selected')) {
    //         fnc_LimpiarFomulario();
    //     } else {
    //         // Activa el tab de registro de usuarios
    //         $("#registrar-usuarios-tab").addClass('active');
    //         $("#registrar-usuarios-tab").attr('aria-selected', true);
    //         $("#registrar-usuarios").addClass('active show');

    //         // Desactiva el tab de listado de usuarios
    //         $("#listado-usuarios-tab").removeClass('active');
    //         $("#listado-usuarios-tab").attr('aria-selected', false);
    //         $("#listado-usuarios").removeClass('active show');

    //         // Cambia el texto del tab
    //         $("#registrar-usuarios-tab").html('<i class="fas fa-sync-alt"></i> Actualizar Usuario');

    //         // Obtiene los datos de la fila seleccionada
    //         var data = (fila_actualizar.parents('tr').hasClass('child')) ?
    //             $("#tbl_usuarios").DataTable().row(fila_actualizar.parents().prev('tr')).data() :
    //             $("#tbl_usuarios").DataTable().row(fila_actualizar.parents('tr')).data();

    //         // Deshabilita los campos de contraseña para la actualización
    //         $("#password").removeAttr('required').prop('disabled', true);
    //         $("#confirmar_password").removeAttr('required').prop('disabled', true);

    //         // Cargar los valores al formulario
    //         $("#id_usuario").val(data[2]);  // ID del usuario
    //         $("#nombres").val(data[3]);     // Nombres
    //         $("#apellidos").val(data[4]);   // Apellidos
    //         $("#usuario").val(data[5]);     // Usuario del sistema
    //         $("#dni").val(data[6]);         // DNI
    //         $("#perfil").val(data[8]);      // Perfil
    //         $("#estado").val(data[9] === "ACTIVO" ? "1" : "0"); // Estado (Activo/Inactivo)
    //     }
    // }

    function fnc_IrFormularioActualizarUsuario(fila_actualizar) {
        if (fila_actualizar.parents('tr').hasClass('selected')) {
            fnc_LimpiarFomulario();
        } else {
            // Activa el tab de registro de usuarios
            $("#registrar-usuarios-tab").addClass('active');
            $("#registrar-usuarios-tab").attr('aria-selected', true);
            $("#registrar-usuarios").addClass('active show');

            // Desactiva el tab de listado de usuarios
            $("#listado-usuarios-tab").removeClass('active');
            $("#listado-usuarios-tab").attr('aria-selected', false);
            $("#listado-usuarios").removeClass('active show');

            // Cambia el texto del tab
            $("#registrar-usuarios-tab").html('<i class="fas fa-sync-alt"></i> Actualizar Usuario');

            // Obtiene los datos de la fila seleccionada
            var data = (fila_actualizar.parents('tr').hasClass('child')) ?
                $("#tbl_usuarios").DataTable().row(fila_actualizar.parents().prev('tr')).data() :
                $("#tbl_usuarios").DataTable().row(fila_actualizar.parents('tr')).data();

            // Deshabilita los campos de contraseña para la actualización
            $("#password").removeAttr('required').prop('disabled', true);
            $("#confirmar_password").removeAttr('required').prop('disabled', true);

            // Cargar los valores al formulario
            $("#id_usuario").val(data[2]);  // ID del usuario
            $("#nombres").val(data[3]);     // Nombres
            $("#apellidos").val(data[4]);   // Apellidos
            $("#usuario").val(data[5]);     // Usuario del sistema
            $("#dni").val(data[6]);         // DNI

            // Seleccionar perfil y área
            const perfilValue = data[7]; // Nombre del perfil
            const areaValue = data[8];   // Nombre del área
            const almacenValue = data[9]; // ID del almacén asociado

            // Establece el perfil seleccionado
            $('#perfil option').filter(function() {
                return $(this).text() === perfilValue;
            }).prop('selected', true);

            // Establece el área seleccionada
            $('#Area option').filter(function() {
                return $(this).text() === areaValue;
            }).prop('selected', true);

            // Establece el área seleccionada
            $('#Area option').filter(function() {
                return $(this).text() === areaValue;
            }).prop('selected', true);

            // Establece el almacén seleccionado
            $('#Almacen').val(almacenValue);    

            // Configurar el estado (Activo/Inactivo)
            const estadoValue = data[10] === "ACTIVO" ? "1" : "0"; // Determinar si el estado es Activo o Inactivo
            $("#estado").val(estadoValue).trigger('change');
        }
    }







        function fnc_LimpiarFomulario() {
        // Limpiar los campos del formulario
        $('#id_usuario').val('0');
        $('#nombres').val('');
        $('#apellidos').val('');
        $('#usuario').val('');
        $('#dni').val('');
        $('#password').val('');
        $('#perfil').val('');

        $('#estado').val('1'); // Opcional, por si deseas que el estado se reinicie a "ACTIVO"

        // Reestablecer la validación de Bootstrap
        $('#frm-datos-usuarios').removeClass('was-validated');

        // Reiniciar el estado de las validaciones del formulario
        $('#frm-datos-usuarios')[0].reset();

        // Limpiar los mensajes de error de validación
        $('.invalid-feedback').hide();

        // Restablecer el texto del tab a "Registro de Usuario"
        $("#registrar-usuarios-tab").html('<i class="fas fa-file-signature"></i> Registro de Usuario');
        // Habilitar el campo de contraseña y hacerlo requerido nuevamente
        $("#password").attr('required', true).prop('disabled', false);
        $("#confirmar_password").attr('required', true).prop('disabled', false);
    }


    // Asegúrate de que la función se llame al hacer clic en el botón de cancelar
    $('#btnCancelarUsuario').on('click', function() {
        fnc_LimpiarFomulario();
    });
    $('#btnRegistrarUsuario').on('click', function() {
        fnc_GuardarDatosUsuario();
    });

    function fnc_GuardarDatosUsuario() {
    if (!validarFormulario('needs-validation-usuarios')) {
        mensajeToast("error", "Complete los datos obligatorios");
        return;
    }

    // Determinar si es creación o actualización
    var idUsuario = $('#id_usuario').val();
    var url = idUsuario > 0 ? '{{ url("/usuarios/update") }}/' + idUsuario : '{{ route("usuarios.store") }}';
    var method = idUsuario > 0 ? 'POST' : 'POST';

    Swal.fire({
        title: '¿Está seguro(a) de guardar los datos del Usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí!',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url, // Usar la URL correcta (crear o actualizar)
                type: method,
                data: {
                    nombres: $('#nombres').val(),
                    apellidos: $('#apellidos').val(),
                    dni: $('#dni').val(),
                    usuario: $('#usuario').val(),
                    password: $('#password').val(),
                    perfil: $('#perfil').val(),
                    id_Area_usuario:$('#Area').val(),
                    id_almacen_usuario:$('#Almacen').val(),
                    estado: $('#estado').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        position: 'top-center',
                        icon: response.tipo_msj,
                        title: response.msj,
                        showConfirmButton: true,
                        timer: 2000
                    });
                    $("#tbl_usuarios").DataTable().ajax.reload();
                    fnc_LimpiarFomulario();

                    // Volver a la pestaña de listado de usuarios y restablecer el texto del tab
                    $("#listado-usuarios-tab").addClass('active');
                    $("#listado-usuarios-tab").attr('aria-selected', true);
                    $("#listado-usuarios").addClass('active show');
                    $("#registrar-usuarios-tab").removeClass('active');
                    $("#registrar-usuarios-tab").attr('aria-selected', false);
                    $("#registrar-usuarios").removeClass('active show');
                    $("#registrar-usuarios-tab").html('<i class="fas fa-file-signature"></i> Registro de Usuario');
                },
                error: function(xhr) {
                    console.error('Error al guardar datos:', xhr.responseText);
                }
            });
        }
    });
}

</script>

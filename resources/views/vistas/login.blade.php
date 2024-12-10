<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/style_login.css') }}" />


    <style>
        .container,
        .container-lg,
        .container-md,
        .container-sm,
        .container-xl {
            min-width: 100%;
        }
    </style>
</head>

<body>

<div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Formulario de login -->
                <form class="sign-in-form needs-validation-login" method="POST" action="{{ url('/login') }}" novalidate>
                    @csrf <!-- Token CSRF para protección -->
                    <h2 class="title">INICIAR SESION</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Usuario" id="loginUsuario" name="loginUsuario" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Contraseña" id="loginPassword" name="loginPassword"
                            required />
                    </div>
                    <button type="submit" class="btn btn-md w-50" id="btnIniciarSesion">INGRESAR</button>
                    <a style="cursor: pointer;" class="fw-bold text-secondary mt-2"
                        id="btnReestablecerPassword">Reestablecer Contraseña</a>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Noir Beta</h3>
                    <p>Explora las funcionalidades de NOIR</p>
                </div>
                <img src="{{ asset('assets/dist/img/log.svg') }}" class="image" alt="" />
            </div>
        </div>
    </div>

    <!-- Modal para cambiar contraseña -->
    <div class="modal fade" id="modalReestablecerPassword" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header my-bg py-1" style="background: #34495e !important;">

                    <h5 class="modal-title text-white">Reestablecer Contraseña</h5>

                    <button type="button" class="btn btn-danger btn-sm text-white p-0 m-0"
                        style="width: 36px !important;" data-dismiss="modal">
                        <i class="fas fa-times  m-0 p-0" aria-hidden="true"></i>
                    </button>

                </div>

                <div class="modal-body">
                    <form id="frm-datos-usuario" class="needs-validation-usuario" autocomplete="off" novalidate>
                        <div class="row">
                            <!-- Usuario del sistema -->
                            <div class="col-12 mb-2">
                                <label class="mb-0 ml-1 text-sm my-text-color">
                                    <i class="fas fa-id-card mr-1 my-text-color"></i>Usuario del Sistema
                                </label>
                                <input autocomplete="off" type="text" list="usuario-suggestions" style="border-radius: 20px;"
                                    placeholder="Ingrese el usuario del sistema" class="form-control form-control-sm" id="usuario"
                                    name="usuario" required>
                                <datalist id="usuario-suggestions"></datalist>
                                <div class="invalid-feedback">Usuario no encontrado</div>
                                <div class="valid-feedback">Usuario localizado</div>
                            </div>
                            
                            

                            <!-- Contraseña -->
                            <div class="col-12 mb-2">
                                <label class="mb-0 ml-1 text-sm my-text-color"><i
                                        class="fas fa-lock mr-1 my-text-color"></i>Contraseña <span class="text-danger"
                                        style="font-size: 12px;">(Mínimo 6 caracteres)</span></label>
                                <input autocomplete="off" type="password" style="border-radius: 20px;"
                                    placeholder="Ingrese el password" class="form-control form-control-sm w-100"
                                    id="password" name="password" required>
                                <div class="invalid-feedback">Ingrese la contraseña</div>
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div class="col-12 mb-2">
                                <label class="mb-0 ml-1 text-sm my-text-color"><i
                                        class="fas fa-lock mr-1 my-text-color"></i>Confirmar Contraseña</label>
                                <input autocomplete="off" type="password" style="border-radius: 20px;"
                                    placeholder="Ingrese confirmacion de password"
                                    class="form-control form-control-sm w-100" id="confirmar_password"
                                    name="confirmar_password" required>
                                <div class="invalid-feedback">Ingrese la confirmación</div>
                            </div>

                            <div class="col-6 mt-2">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    style="height: 30px !important; font-size: 18px !important; background-color: #dc3545 !important;"
                                    data-dismiss="modal">Cancelar</button>
                            </div>

                            <div class="col-6 mt-2">
                                <button type="button" class="btn btn-primary btn-sm"
                                    style="height: 30px !important; font-size: 18px !important;"
                                    id="btnCambiarPassword">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#btnIniciarSesion").on('click', function(e) {
                e.preventDefault();
                fnc_login();
            });

            $('#loginPassword').keypress(function(e) {
                var key = e.which;
                if (key == 13) {
                    e.preventDefault();
                    fnc_login();
                }
            });

            $("#btnReestablecerPassword").on('click', function() {
                $("#modalReestablecerPassword").modal('show');
            });

            $("#confirmar_password").change(function() {
                if ($("#confirmar_password").val() != $("#password").val()) {
                    $("#confirmar_password").addClass("is-invalid");
                    $("#confirmar_password").next(".invalid-feedback").html("Las contraseñas no coinciden");
                } else {
                    $("#confirmar_password").removeClass("is-invalid");
                }
            });

            $("#password").change(function() {
                if ($("#password").val().length < 6) {
                    $("#password").addClass("is-invalid");
                    $("#password").next(".invalid-feedback").html("Mínimo 6 caracteres");
                } else {
                    $("#password").removeClass("is-invalid");
                }
            });

            $("#btnCambiarPassword").on('click', function() {
                fnc_CambiarPassword();
            });

                // Búsqueda dinámica del usuario
    $("#usuario").on("input", function () {
        const term = $(this).val();

        if (term.length >= 2) { // Buscar a partir de 2 caracteres
            $.ajax({
                url: "/buscar-usuario-dinamico",
                type: "GET",
                data: { term },
                success: function (response) {
                    const input = $("#usuario");

                    if (response.found) {
                        // Usuario localizado: Cambiar a verde
                        input.removeClass("is-invalid").addClass("is-valid");
                        input.next(".invalid-feedback").html("");
                        input.next(".valid-feedback").html(response.message).show();
                    } else {
                        // Usuario no encontrado: Cambiar a rojo
                        input.removeClass("is-valid").addClass("is-invalid");
                        input.next(".invalid-feedback").html(response.message).show();
                    }
                },
                error: function () {
                    Swal.fire("Error al buscar usuario", "", "error");
                },
            });
        } else {
            // Limpiar clases si el input tiene menos de 2 caracteres
            $("#usuario").removeClass("is-valid is-invalid");
            $("#usuario").next(".invalid-feedback").html("").hide();
            $("#usuario").next(".valid-feedback").html("").hide();
        }
    });

    // Validar contraseñas coincidan
    $("#confirmar_password, #password").on("input", function () {
        if ($("#password").val() !== $("#confirmar_password").val()) {
            $("#confirmar_password").addClass("is-invalid");
            $("#confirmar_password").next(".invalid-feedback").html("Las contraseñas no coinciden").show();
        } else {
            $("#confirmar_password").removeClass("is-invalid").addClass("is-valid");
            $("#confirmar_password").next(".invalid-feedback").html("").hide();
        }
    });

    // Cambiar contraseña
    $("#btnCambiarPassword").on("click", function () {
        if (!validateForm("needs-validation-usuario")) {
            Swal.fire("Complete los datos obligatorios", "", "error");
            return;
        }

        const formData = {
            usuario: $("#usuario").val(),
            password: $("#password").val(),
            confirmar_password: $("#confirmar_password").val(),
            _token: $('meta[name="csrf-token"]').attr("content"),
        };

        $.ajax({
            url: "/actualizar-password",
            type: "POST",
            data: formData,
            success: function (response) {
                Swal.fire(response.message, "", "success");
                $("#modalReestablecerPassword").modal("hide");
            },
            error: function (xhr) {
                const error = xhr.responseJSON.message || "Error al cambiar la contraseña";
                Swal.fire(error, "", "error");
            },
        });
    });

    function validateForm(formClass) {
        let isValid = true;
        $(`.${formClass} input[required]`).each(function () {
            if ($(this).val() === "") {
                $(this).addClass("is-invalid");
                isValid = false;
            } else {
                $(this).removeClass("is-invalid");
            }
        });
        return isValid;
    }

        });

        function fnc_login() {
            var forms = document.getElementsByClassName('needs-validation-login');
            var validation = Array.prototype.filter.call(forms, function(form) {
                if (form.checkValidity() === true) {
                    var formData = {
                        usuario: $("#loginUsuario").val(),
                        clave: $("#loginPassword").val(),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    };

                    $.ajax({
                        url: '/login',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.tipo_msj === 'success') {
                                $("#btnIniciarSesion").addClass('disabled');
                                Swal.fire(response.msj, '', 'success').then(() => {
                                    // Redirigir primero a la página raíz
                                    window.location.href = response.redirect_url;  // Redirige a la raíz
                                });
                            } else {
                                Swal.fire(response.msj, '', 'error');
                                $("#btnIniciarSesion").removeClass('disabled');
                            }
                        },
                        error: function() {
                            Swal.fire('Error en la autenticación', '', 'error');
                        }
                    });
                } else {
                    Swal.fire('Ingrese el usuario y contraseña', '', 'error');
                }
            });


        }


        function fnc_CambiarPassword() {
            if (!validateForm('needs-validation-usuario')) {
                Swal.fire("Complete los datos obligatorios", '', 'error');
                return;
            }

            Swal.fire({
                title: 'Está seguro(a) de cambiar la contraseña?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = {
                        usuario: $("#usuario").val(),
                        password: $("#password").val(),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    };

                    $.ajax({
                        url: '/ruta-para-cambiar-password',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            Swal.fire(response.msj, '', response.tipo_msj);
                            $("#modalReestablecerPassword").modal('hide');
                        },
                        error: function() {
                            Swal.fire('Error al cambiar la contraseña', '', 'error');
                        }
                    });
                }
            });
        }

        function validateForm(formClass) {
            var isValid = true;
            $('.' + formClass + ' input[required]').each(function() {
                if ($(this).val() === '') {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            return isValid;
        }

    </script>
</body>

</html>

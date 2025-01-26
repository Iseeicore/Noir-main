<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Agrolit</title>

        <!-- Fuentes y estilos -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/dist/css/login.css') }}">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar superior -->
    <nav id="navbar">
        <div class="navbar-container">
            <span id="logo">AGROLIT</span>
            <span id="info">INFO</span>
        </div>
    </nav>
    <!-- CONTENIDO DE INFO -->
    <div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInfoLabel">Información</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bienvenido a este Sistema de Gestion.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div id="contenido">
        <div id="Centro">
            <div id="ElementosCentro">
                <div id="NombreGrande2"></div>
                <div id="NombreGrande"></div>
                <div id="Floro">
                    <p>Nos dedicamos a cultivar un futuro más verde, combinando innovación y tradición para ofrecer
                        productos agrícolas de alta calidad, comprometidos con la sostenibilidad y el bienestar de
                        nuestras comunidades.</p>
                </div>
                <div id="Boton">
                    <button id="btnIniciarSesion">LOGIN</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer id="footer">
        <p id="Derechos">AGROINDUSTRIAS LITERAS E.I.R.L. © 2024 - Todos los derechos reservados</p>
    </footer>

    <!-- Formulario de inicio de sesión -->
    <div id="formLogin" class="hidden">
        <div class="blur-container">
            <h2>Iniciar Sesión</h2>
            <form class="needs-validation-login" novalidate>
                @csrf
                <div class="form-group">
                    <label for="loginUsuario"></label>
                    <input placeholder="Usuario" type="text" class="form-control" id="loginUsuario"
                        name="loginUsuario" required>
                </div>
                <div class="form-group">
                    <label for="loginPassword"></label>
                    <input placeholder="Contraseña" type="password" class="form-control" id="loginPassword"
                        name="loginPassword" required>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary" id="btnSubmitLogin">Iniciar Sesión</button>
                    <button type="button" class="btn btn-secondary" id="btnCancelar">Cancelar</button>
                </div>
                <a href="#" id="btnReestablecerPassword" class="btn btn-link">¿Olvidó su contraseña?</a>
            </form>
        </div>
    </div>
    <!-- Modal para reestablecer contraseña -->
    <div class="modal fade" id="modalReestablecerPassword" tabindex="-1"
        aria-labelledby="modalReestablecerPasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReestablecerPasswordLabel">Reestablecer Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="formCambiarPassword" class="needs-validation-usuario" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input placeholder="Usuario" type="text" class="form-control" id="usuario"
                                name="usuario" required>
                            <div class="invalid-feedback">Debe ingresar un usuario válido.</div>
                            <div class="valid-feedback">Usuario encontrado.</div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input placeholder="Nueva Contraseña" type="password" class="form-control"
                                id="password" name="password" required>
                            <div class="invalid-feedback">Mínimo 6 caracteres.</div>
                        </div>
                        <div class="mb-3">
                            <label for="confirmar_password" class="form-label">Confirmar Contraseña</label>
                            <input placeholder="Confirmar Contraseña" type="password" class="form-control"
                                id="confirmar_password" name="confirmar_password" required>
                            <div class="invalid-feedback">Las contraseñas no coinciden.</div>
                        </div>

                        <button type="button" class="btn btn-primary w-100" id="btnCambiarPassword">Cambiar
                            Contraseña</button>
                        <button type="button" class="btn btn-secondary w-100 mt-2"
                            data-bs-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Scripts necesarios -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Aquí incluye el script que proporcionaste
    </script>


    <script>
        $(document).ready(function() {

            $('#info').on('click', function() {
                Swal.fire({
                    title: 'Información',
                    text: 'Bienvenido a este Sistema.',
                    icon: 'info',
                    confirmButtonText: 'Entendido',
                });
            });

            // Mostrar formulario de inicio de sesión
            $("#btnIniciarSesion").on("click", function(e) {
                e.preventDefault();
                $("#formLogin").removeClass("hidden").fadeIn();
            });

            // Ocultar formulario de inicio de sesión al hacer clic en cancelar
            $("#btnCancelar").on("click", function() {
                $("#formLogin").fadeOut();
            });

            // Mostrar modal de reestablecimiento de contraseña
            $("#btnReestablecerPassword").on("click", function(e) {
                e.preventDefault();
                $("#formLogin").fadeOut(function() {
                    $("#modalReestablecerPassword").modal("show");
                });
            });

            $("#usuario").on("input", function () {
            const term = $(this).val();

            if (term.length >= 2) { // Buscar a partir de 2 caracteres
                $.ajax({
                    url: "/buscar-usuario-dinamico", // Ruta para buscar usuarios
                    type: "GET",
                    data: {
                        term
                    },
                    success: function(response) {
                        const input = $("#usuario");

                        if (response.found) {
                            // Usuario encontrado
                            input.removeClass("is-invalid").addClass("is-valid");
                            input.next(".invalid-feedback").hide();
                            input.next(".valid-feedback").html(response.message).show();
                        } else {
                            // Usuario no encontrado
                            input.removeClass("is-valid").addClass("is-invalid");
                            input.next(".invalid-feedback").html(response.message).show();
                            input.next(".valid-feedback").hide();
                        }
                    },
                    error: function() {
                        Swal.fire("Error", "No se pudo buscar el usuario.", "error");
                    },
                });
            } else {
                // Limpiar validaciones si hay menos de 2 caracteres
                $("#usuario").removeClass("is-valid is-invalid");
                $("#usuario").next(".invalid-feedback").hide();
                $("#usuario").next(".valid-feedback").hide();
            }
        });

        // Validar contraseñas coincidan
        $("#confirmar_password, #password").on("input", function() {
            if ($("#password").val() !== $("#confirmar_password").val()) {
                $("#confirmar_password").addClass("is-invalid");
                $("#confirmar_password").next(".invalid-feedback").html("Las contraseñas no coinciden").show();
            } else {
                $("#confirmar_password").removeClass("is-invalid").addClass("is-valid");
                $("#confirmar_password").next(".invalid-feedback").hide();
            }
        });

        // Cambiar contraseña
        $("#btnCambiarPassword").on("click", function() {
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
                success: function(response) {
                    Swal.fire(response.message, "", "success");
                    $("#modalReestablecerPassword").modal("hide");
                },
                error: function(xhr) {
                    const error = xhr.responseJSON.message || "Error al cambiar la contraseña";
                    Swal.fire(error, "", "error");
                },
            });
        });


        function validateForm(formClass) {
            let isValid = true;
            $("." + formClass + " input[required]").each(function() {
                if ($(this).val() === "") {
                    $(this).addClass("is-invalid");
                    isValid = false;
                } else {
                    $(this).removeClass("is-invalid");
                }
            });
            return isValid;
        }

        // Login function
        $("#btnSubmitLogin").on("click", function(e) {
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
                                    window.location.href = response.redirect_url;
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
        });


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
                        url: "/actualizar-password", // Verifica que coincida con la ruta
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            Swal.fire(response.message, "", "success");
                            $("#modalReestablecerPassword").modal("hide");
                        },
                        error: function(xhr) {
                            const error = xhr.responseJSON.message || "Error al cambiar la contraseña";
                            Swal.fire(error, "", "error");
                        },
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

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">EMPRESAS</h2>
            </div><!-- /.col -->
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                    <li class="breadcrumb-item active">EMPRESA</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
        <!-- FILA PARA INPUT FILE -->
        <div class="card card-gray shadow mt-4">
            <div class="card-body px-3 py-3" style="position: relative;">
                <span class="titulo-fieldset px-3 py-1">SELECCIONE LA EMPRESA</span>
                <div class="row my-3">
                    <div class="col-lg-9">
                        <form method="POST" enctype="multipart/form-data" id="form_cargar_productos">
                            @csrf
                            <input type="text" name="nombreEmpresa" id="nombreEmpresa" class="form-control" readonly
                                placeholder="Nombre de la Empresa Seleccionada">
                        </form>
                    </div>
                    <div class="col-lg-3">
                        <button class="btn btn-sm btn-success w-100" id="btnCargar" style="position: relative;"onclick="mostrarModalEmpresa()">
                            <span class="text-button fw-bold fs-6">CREAR EMPRESA</span>
                            <span class="btn fw-bold icon-btn-success">
                                <i class="fas fa-save fs-5"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-gray shadow mt-4">
            <div class="row mt-4" id="empresaCards">
                <!-- Aquí se cargarán dinámicamente las tarjetas de empresas -->
                
            </div> 
        </div>
    </div>
</div>

<div class="modal fade" id="mdlGestionarEmpresa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-main py-2">
                <h6 class="modal-title titulo_modal_Empresa">Registrar Empresa</h6>
                <button type="button" class="text-white m-0 px-1 badge badge-pill badge-danger" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>

            <div class="modal-body">

                <form class="needs-validation-Empresa" novalidate>

                    <div class="row">
                        
                        <!-- RUC -->
                        <div class="col-12 col-lg-11 mb-2">
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
                        <div class="col-12  mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-map-marker-alt mr-1 my-text-color"></i>Dirección</label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="direccion" name="direccion" required>
                            <div class="invalid-feedback">Ingrese la Dirección</div>
                        </div>

                        <!-- Imagen -->
                        <div class="col-12 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-image mr-1 my-text-color"></i>Seleccione una imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" onchange="previewFile(this)">
                        </div>

                        <!-- Preview de Imagen -->
                        <div class="col-12 mb-2">
                            <div style="width: 100%; height: 255px;">
                                <img id="previewImg" src="./assets/imagenes/no_image.jpg" class="border border-secondary" style="object-fit: fill; width: 100%; height: 100%;" alt="Preview Imagen">
                            </div>
                        </div>

                        <!-- Botón de Guardado -->
                        <div class="col-md-12 mt-3 text-center">
                            <a class="btn btn-sm btn-success fw-bold" id="btnRegistrarEmpresa" style="position: relative; width: 50%;">
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
      // Función para mostrar el modal
      function mostrarModalEmpresa() {
        $("#mdlGestionarEmpresa").modal('show');
    }


    // Iniciar eventos al cargar el documento
    $(document).ready(function() {
        cargarEmpresas();

            // Cargar el nombre de la empresa seleccionada desde localStorage
        const nombreEmpresaGuardada = localStorage.getItem('nombreEmpresaSeleccionada');
        if (nombreEmpresaGuardada) {
            $('#nombreEmpresa').val(nombreEmpresaGuardada);
        }

        $('#mdlGestionarEmpresa').on('hidden.bs.modal', function () {
            limpiarCamposEmpresa();
        });
        $('#btnRegistrarEmpresa').click(function() {
            guardarEmpresa();
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


    

    function editarEmpresa(idEmpresa) {
        $.ajax({
            url: `/empresas/obtener/${idEmpresa}`, // Ruta al controlador
            type: 'GET',
            success: function(response) {
                if (response.tipo_msj === 'success') {
                    // Cargar los datos en el modal
                    $('#ruc').val(response.data.ruc);
                    $('#razon_social').val(response.data.razon_social);
                    $('#direccion').val(response.data.direccion);

                    // Cargar imagen
                    const imagenUrl = response.data.logo ? '/storage/assets/imagenes/empresas/' + response.data.logo : './assets/imagenes/no_image.jpg';
                    $('#previewImg').attr('src', imagenUrl);

                    // Cambiar el título del modal y mostrar el modal
                    $('.titulo_modal_Empresa').text('Actualizar Empresa');
                    $('#mdlGestionarEmpresa').modal('show');

                    // Cambiar el comportamiento del botón de guardar
                    $('#btnRegistrarEmpresa').off('click').on('click', function() {
                        actualizarEmpresa(idEmpresa);
                    });
                } else {
                    Swal.fire('Error', response.msj, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Hubo un problema al obtener los datos de la empresa.', 'error');
            }
        });
    }

    function usoEmpresa(idEmpresa) {
    $.ajax({
        url: `/empresas/obtener/${idEmpresa}`,
        type: 'GET',
        success: function(response) {
            if (response.tipo_msj === 'success') {
                const nombreEmpresa = response.data.razon_social;
                const logoEmpresa = response.data.logo;

                // Guardar en localStorage
                localStorage.setItem('nombreEmpresaSeleccionada', nombreEmpresa);
                localStorage.setItem('logoEmpresaSeleccionada', logoEmpresa);

                // Actualizar el input de la empresa seleccionada
                $('#nombreEmpresa').val(nombreEmpresa);

                // Actualizar dinámicamente el aside
                $('#nombre_comercial').text(nombreEmpresa);
                $('#logo_sistema').attr('src', `/storage/assets/imagenes/empresas/${logoEmpresa}`);

                // Notificación de éxito
                Swal.fire('Empresa Seleccionada', `La empresa ${nombreEmpresa} ha sido seleccionada.`, 'success');
            } else {
                Swal.fire('Error', response.msj, 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Hubo un problema al seleccionar la empresa.', 'error');
        }
    });
}



    function eliminarEmpresa(idEmpresa) {
        Swal.fire({
            title: '¿Está seguro de eliminar esta empresa?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/empresas/eliminar/${idEmpresa}`,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.tipo_msj === 'success') {
                            Swal.fire('Eliminado', response.msj, 'success');
                            cargarEmpresas(); // Recargar la lista de empresas

                        // Verificar si la empresa eliminada es la seleccionada
                        const nombreEmpresaSeleccionada = $('#nombreEmpresa').val();
                        if (response.nombre_empresa === nombreEmpresaSeleccionada) {
                            // Si es la misma, borrar de localStorage y vaciar el input
                            localStorage.removeItem('nombreEmpresaSeleccionada');
                            $('#nombreEmpresa').val('');
                        }
                        } else {
                            Swal.fire('Error', response.msj, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Ocurrió un error al eliminar la empresa', 'error');
                    }
                });
            }
        });
    }


    function actualizarEmpresa(idEmpresa) {
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('ruc', $('#ruc').val());
        formData.append('razon_social', $('#razon_social').val());
        formData.append('direccion', $('#direccion').val());
        formData.append('imagen', $('#imagen')[0].files[0]);

        Swal.fire({
            title: '¿Está seguro de actualizar la empresa?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/empresas/actualizar/${idEmpresa}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.tipo_msj === 'success') {
                            Swal.fire('Éxito', response.msj, 'success');
                            $('#mdlGestionarEmpresa').modal('hide');
                            cargarEmpresas(); // Recargar la lista de empresas
                        } else {
                            Swal.fire('Error', response.msj, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Ocurrió un error al actualizar la empresa', 'error');
                    }
                });
            }
        });
    }



     // Función para cargar las empresas y mostrar en cards
     function cargarEmpresas() {
        $.ajax({
            url: '{{ route("empresas.listar") }}',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#empresaCards').empty(); // Limpiar el contenedor antes de agregar nuevas tarjetas
                data.forEach(function(empresa) {
                    let cardHtml = `
    <div class="col-md-4 mb-4">
        <div class="card h-100 border">
            <!-- Contenedor de imagen centrado -->
            <div class="d-flex justify-content-center mt-3">
                <img src="${empresa.logo ? '/storage/assets/imagenes/empresas/' + empresa.logo : './assets/imagenes/no_image.jpg'}" 
                    alt="Imagen de Empresa" 
                    class="rounded-circle" 
                    style="width: 200px; height: 200px; object-fit: cover;">
            </div>
            
            <!-- Contenido de la tarjeta -->
            <div class="card-body text-center">
                <h5 class="card-title font-weight-bold mt-3">${empresa.razon_social}</h5>
                <p class="small text-muted">Ubicación: ${empresa.direccion}</p>

                <!-- Action Icons (hover effect) -->
                <div class="d-flex justify-content-center gap-2 mt-3" style="opacity: 0; transition: opacity 0.3s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0">
                    <button type="button" class="btn btn-outline-success btn-sm" aria-label="Check" onclick="usoEmpresa(${empresa.id_empresa})">
                        <i class="fas fa-check"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" aria-label="Refresh" onclick="editarEmpresa(${empresa.id_empresa})">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" aria-label="Delete" onclick="eliminarEmpresa(${empresa.id_empresa})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>

                <!-- Estado de la empresa -->
                <div class="d-flex justify-content-center align-items-center pt-2 border-top mt-3">
                    <span class="badge badge-success">Empresa Registrada</span>
                </div>
            </div>
        </div>
    </div>
`;
$('#empresaCards').append(cardHtml);

                });
            },
            error: function() {
                console.error('Error al cargar las empresas');
            }
        });
    }

    function guardarEmpresa() {
        // Crear un FormData con los valores del formulario
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('ruc', $('#ruc').val());
        formData.append('razon_social', $('#razon_social').val());
        formData.append('direccion', $('#direccion').val());
        formData.append('imagen', $('#imagen')[0].files[0]);

        // Validar la extensión de la imagen antes de enviar
        var file = $("#imagen").val();
        if (file) {
            var ext = file.substring(file.lastIndexOf(".")).toLowerCase();
            if ([".jpg", ".png", ".gif", ".jpeg", ".webp"].indexOf(ext) === -1) {
                Swal.fire('Error', "La extensión " + ext + " no es una imagen válida", 'error');
                return;
            }
        }

        // Confirmación de SweetAlert
        Swal.fire({
            title: '¿Está seguro de registrar la empresa?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, registrar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                // Hacer la solicitud AJAX para guardar la empresa
                $.ajax({
                    url: '{{ route("empresa.guardar") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire('Éxito', response.msj, 'success');
                        if (response.tipo_msj === 'success') {
                            // Ocultar el modal y limpiar campos
                            $('#mdlGestionarEmpresa').modal('hide');
                            limpiarCamposEmpresa();
                            cargarEmpresas();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Ocurrió un error al registrar la empresa', 'error');
                    }
                });
            }
        });
    }



     // Definición de la función previewFile
    window.previewFile = function(input) {
            var file = input.files[0]; // Obtiene el archivo seleccionado
            var reader = new FileReader(); // Crea un nuevo lector de archivos

            reader.onload = function(e) {
                // Cuando la lectura del archivo esté completa, establece la imagen de previsualización
                $('#previewImg').attr('src', e.target.result); // Actualiza el 'src' de la imagen
            };

            if (file) {
                reader.readAsDataURL(file); // Lee el archivo como una URL de datos
            }
        };
        
        function limpiarCamposEmpresa() {
        $('#ruc').val('');                // Limpiar el campo de RUC
        $('#razon_social').val('');       // Limpiar el campo de Razón Social
        $('#direccion').val('');          // Limpiar el campo de Dirección
        $('#imagen').val(''); // Restablecer el input de archivo
        $('#previewImg').attr('src',
        './assets/imagenes/no_image.jpg'); // Restablecer la imagen de vista previa

        // Opcional: eliminar mensajes de error de validación
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').hide();
        }   
</script>

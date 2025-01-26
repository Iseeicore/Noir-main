<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0">Registrar Producto</h2>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                    <li class="breadcrumb-item">Inventario</li>
                    <li class="breadcrumb-item active">Registrar</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- Main content -->
<div class="content">

    <div class="container-fluid">

        <div class="card card-gray shadow mt-3">

            <div class="card-body px-3 py-3" style="position: relative;">

                <span class="titulo-fieldset px-3 py-1">DATOS DEL PRODUCTO </span>

                <div class="row my-1">

                    <div class="col-12">

                        <form id="frm-datos-producto" class="needs-validation" novalidate>

                            <!-- Abrimos una fila -->
                            <div class="row">
                                <!-- CODIGO PRODUCTO -->
                                <div class="col-12 col-lg-4 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color form-label"><i
                                            class="fas fa-barcode mr-1 my-text-color"></i>Código del Producto</label>
                                    <input type="text" class="form-control form-control-sm" id="codigo_productos"
                                        name="codigo_productos" onchange="validateJS(event, 'codigo_productos')"
                                        aria-label="Small" aria-describedby="inputGroup-sizing-sm" required readonly>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <!-- CATEGORÍAS -->
                                <div class="col-12 col-lg-8 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i
                                            class="fas fa-layer-group mr-1 my-text-color"></i>Categoría</label>
                                    <select class="form-select form-select-sm select2 cursor-pointer" id="id_categoria"
                                        name="id_categoria" required>
                                    </select>
                                    <div class="invalid-feedback">Seleccione la categoría</div>
                                </div>

                                <!-- DESCRIPCION DEL PRODUCTO -->
                                <div class="col-12 col-lg-6 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i
                                            class="fas fa-gifts mr-1 my-text-color"></i>Descripción</label>
                                    <input type="text" placeholder="Ingrese la descripción del producto"
                                        class="form-control form-control-sm" id="descripcion" name="descripcion"
                                        aria-label="Small" aria-describedby="inputGroup-sizing-sm" required>
                                    <div class="invalid-feedback">Ingrese descripción del producto</div>
                                </div>

                                <!-- UNIDAD MEDIDA -->
                                <div class="col-12 col-lg-6 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i
                                            class="fas fa-ruler mr-1 my-text-color"></i>Unidad/Medida</label>
                                    <select class="form-select form-select-sm select2 cursor-pointer"
                                        id="id_unidad_medida" name="id_unidad_medida"
                                        aria-label="Floating label select example" required>
                                    </select>
                                    <div class="invalid-feedback">Seleccione la Unidad de Medida</div>
                                </div>

                                <!-- IMAGEN -->
                                <div class="col-12 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i
                                            class="fas fa-image mr-1 my-text-color"></i>Seleccione una imagen</label>
                                    <!-- <input type="file" class="form-control form-control-sm" id="imagen" name="imagen" accept="image/*" onchange="previewFile(this)"> -->
                                    <input type="file" class="form-control" id="imagen" name="imagen"
                                        accept="image/*" onchange="previewFile(this)">
                                </div>

                                <!-- PREVIEW IMAGEN -->
                                <div class="col-12 col-lg-3">
                                    <div style="width: 100%; height: 255px;">
                                        <img id="previewImg" src="./assets/imagenes/no_image.jpg"
                                            class="border border-secondary"
                                            style="object-fit: fill; width: 100%; height: 100%;" alt="">
                                    </div>
                                </div>

                                <div class="col-lg-9">
                                    <div class="row">
                                        <!-- MINIMO STOCK -->
                                        <div class="col-12">
                                            <label class="mb-0 ml-1 text-sm my-text-color">
                                                <i class="fas fa-dollar-sign mr-1 my-text-color"></i>Stock Mínimo
                                            </label>
                                            <input type="number" min="0" step="0.01" placeholder="Ingrese el stock minimo" 
                                                   class="form-control form-control-sm" id="minimo_stock" name="minimo_stock" 
                                                   aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                        <!-- Botones -->
                                        <div class="col-12 mt-3">
                                            <div class="row">
                                                <div class="col-12 col-lg-6 mb-2">
                                                    <a class="btn btn-sm btn-success fw-bold w-100" id="btnAbrirModalUnidadMedida" 
                                                       style="border-radius: 20px;" onclick="abrirModal('unidad_medida');">
                                                        <span class="text-button">GENERAR NUEVA MEDIDA</span>
                                                        <span class="btn fw-bold icon-btn-success">
                                                            <i class="fas fa-plus-circle fs-5 text-white m-0 p-0"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="col-12 col-lg-6 mb-2">
                                                    <a class="btn btn-sm btn-success fw-bold w-100" id="btnAbrirModalCategoria" 
                                                       style="border-radius: 20px;" onclick="abrirModal('categoria');">
                                                        <span class="text-button">GENERAR NUEVA CATEGORÍA</span>
                                                        <span class="btn fw-bold icon-btn-success">
                                                            <i class="fas fa-plus-circle fs-5 text-white m-0 p-0"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- BOTONERA -->
                                <div class="col-12 text-center mt-3">
                                    <a class="btn btn-sm btn-danger  fw-bold " id="btnCancelarRegistro"
                                        style="position: relative; width: 160px;"
                                        onclick="fnc_RegresarListadoProductosModelo();">
                                        <span class="text-button">REGRESAR</span>
                                        <span class="btn fw-bold icon-btn-danger ">
                                            <i class="fas fa-undo-alt fs-5 text-white m-0 p-0"></i>
                                        </span>
                                    </a>

                                    <a class="btn btn-sm btn-success  fw-bold " id="btnGuardarProducto"
                                        style="position: relative; width: 160px;"
                                        onclick="fnc_registrarProductoModelo();">
                                        <span class="text-button">REGISTRAR</span>
                                        <span class="btn fw-bold icon-btn-success ">
                                            <i class="fas fa-save fs-5 text-white m-0 p-0"></i>
                                        </span>
                                    </a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Agregar Categoría o Unidad de Medida -->
<div class="modal fade" id="mdlGestionarGeneral" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-main py-2">
                <h6 class="modal-title" id="modalLabel">Agregar</h6>
                <button type="button" class="text-white m-0 px-1 badge badge-pill badge-danger" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="formGeneral" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color">
                                <i class="fas fa-layer-group mr-1 my-text-color"></i>Codigo
                            </label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="codigoModal" name="codigo" required>
                            <div class="invalid-feedback">Ingrese el codigo</div>
                        </div>
                        <div class="col-12 mb-2">
                            <label class="mb-0 ml-1 text-sm my-text-color">
                                <i class="fas fa-layer-group mr-1 my-text-color"></i>Descripción
                            </label>
                            <input type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="descripcionModal" name="descripcion" required>
                            <div class="invalid-feedback">Ingrese la descripción</div>
                        </div>
                        <div class="col-md-12 mt-3 text-center">
                            <a class="btn btn-sm btn-success fw-bold" id="btnGuardarGeneral" style="position: relative; width: 50%;" onclick="guardarDatos();">
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
    if (typeof modoActual === 'undefined') {
        var modoActual = ''; // Usamos var para evitar conflictos en el ámbito global.
    }
    $(document).ready(function() {
        cargarCategorias();
        cargarUnidadesMedida();
        inicializarSweetAlertCodigoProducto();

    // Swal.fire({
    //     title: '¿Cómo deseas ingresar el código del producto?',
    //     text: "Elige si deseas ingresarlo manualmente o que se genere automáticamente.",
    //     icon: 'question',
    //     showCancelButton: true,
    //     confirmButtonText: 'Generar automáticamente',
    //     cancelButtonText: 'Ingresar manualmente',
    // }).then((result) => {
    //     if (result.isConfirmed) {
    //         $('#codigo_productos').prop('readonly', true);
    //         generarCodigoProductoModelo();
    //     } else if (result.dismiss === Swal.DismissReason.cancel) {
    //         $('#codigo_productos').prop('readonly', false);

    //     }
    // });

    $('#id_categoria').change(function() {
        if ($('#codigo_productos').prop('readonly')) {
            generarCodigoProductoModelo();
        }
    });
});

// Cargar categorías en el select
// function cargarCategorias() {
//     $.ajax({
//         url: '{{ route("listar_Categorias_Formulario") }}',
//         type: 'GET',
//         dataType: 'json',
//         success: function(data) {
//             var select = $('#id_categoria');
//             select.empty().append('<option value="">-- Seleccione una Categoría --</option>');
//             data.forEach(function(categoria) {
//                 select.append('<option value="' + categoria.id + '">' + categoria.nomb_cate + ' (' + categoria.id + ')</option>');
//             });
//         },
//         error: function(xhr) {
//             console.error('Error al cargar categorías:', xhr.responseText);
//         }
//     });
// }


// Cargar unidades de medida en el select
// function cargarUnidadesMedida() {
//     $.ajax({
//         url: '{{ route("listar_unidades_medida") }}',
//         type: 'GET',
//         dataType: 'json',
//         success: function(data) {
//             var select = $('#id_unidad_medida');
//             select.empty().append('<option value="">-- Seleccione Unidad de Medida --</option>');
//             data.forEach(function(unidad) {
//                 select.append('<option value="' + unidad.id + '">' + unidad.nomb_uniMed + ' (' + unidad.id + ')</option>');
//             });
//         },
//         error: function(xhr) {
//             console.error('Error al cargar unidades de medida:', xhr.responseText);
//         }
//     });
// }

function cargarCategorias() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '{{ route("listar_Categorias_Formulario") }}',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#id_categoria');
                select.empty().append('<option value="">-- Seleccione una Categoría --</option>');
                data.forEach(function(categoria) {
                    select.append('<option value="' + categoria.id + '">' + categoria.nomb_cate + ' (' + categoria.id + ')</option>');
                });
                resolve();
            },
            error: function(xhr) {
                console.error('Error al cargar categorías:', xhr.responseText);
                reject();
            }
        });
    });
}

function cargarUnidadesMedida() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '{{ route("listar_unidades_medida") }}',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#id_unidad_medida');
                select.empty().append('<option value="">-- Seleccione Unidad de Medida --</option>');
                data.forEach(function(unidad) {
                    select.append('<option value="' + unidad.id + '">' + unidad.nomb_uniMed + ' (' + unidad.id + ')</option>');
                });
                resolve();
            },
            error: function(xhr) {
                console.error('Error al cargar unidades de medida:', xhr.responseText);
                reject();
            }
        });
    });
}


//mensaje de sweetalert
function inicializarSweetAlertCodigoProducto() {
    Swal.fire({
        title: '¿Cómo deseas ingresar el código del producto?',
        text: "Elige si deseas ingresarlo manualmente o que se genere automáticamente.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Generar automáticamente',
        cancelButtonText: 'Ingresar manualmente',
    }).then((result) => {
        if (result.isConfirmed) {
            $('#codigo_productos').prop('readonly', true);
            generarCodigoProductoModelo();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            $('#codigo_productos').prop('readonly', false);
        }
    });
}

function inicializarVistaRegistrarProducto() {
    // Cargar categorías y unidades de medida en paralelo
    Promise.all([cargarCategorias(), cargarUnidadesMedida()])
        .then(() => {
            inicializarSweetAlertCodigoProducto(); // Mostrar el SweetAlert al cargar la vista
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al cargar los datos. Intente nuevamente.',
            });
        });
}



function generarCodigoProductoModelo() {
    var idCategoria = $('#id_categoria').val();

    if (idCategoria) {
        $.ajax({
            url: '{{ route("generar_codigo_producto_Modelo") }}',
            type: 'POST',
            data: {
                id_categoria: idCategoria,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                $('#codigo_productos').val(data.nuevo_codigo || '');
            },
            error: function(xhr, status, error) {
                console.error('Error al generar el código del producto:', error);
            }
        });
    } else {
        console.warn('ID de categoría no seleccionado.');
        $('#codigo_productos').val('');
    }
}

window.fnc_registrarProductoModelo = function() {
    var formData = new FormData($('#frm-datos-producto')[0]);
    formData.append('_token', '{{ csrf_token() }}'); // CSRF token

    var imagenValida = true;

    // Validar la extensión de la imagen
    var file = $("#imagen").val();
    if (file) {
        var ext = file.substring(file.lastIndexOf(".")).toLowerCase();
        if (ext != ".jpg" && ext != ".png" && ext != ".gif" && ext != ".jpeg" && ext != ".webp") {
            Swal.fire('Error', "La extensión " + ext + " no es una imagen válida", 'error');
            imagenValida = false;
        }
    }

    if (!imagenValida) {
        return;
    }

    // Mostrar confirmación de registro
    Swal.fire({
        title: '¿Está seguro de registrar el producto?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, registrar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            // Realizar la solicitud Ajax para registrar el producto
            $.ajax({
                url: '{{ route("registrar_productomodeloreq") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire('Éxito', response.msj, 'success');
                    if (response.tipo_msj === 'success') {
                        fnc_RegresarListadoProductosModelo(); // Regresa al listado
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Ocurrió un error al registrar el producto', 'error');
                }
            });
        }
    });
}

function limpiarDatos() {
    // Limpiar todos los selects (desplegables)
    $('#id_categoria').val('').trigger('change');
    $('#id_unidad_medida').val('').trigger('change');
    // Limpiar los inputs de texto
    $('#codigo_productos').val(''); // Código del producto
    $('#descripcion').val(''); // Descripción del producto
    $('#minimo_stock').val(''); // Stock mínimo

    // Limpiar el campo de imagen
    $('#imagen').val(''); // Restablecer el input de archivo
    $('#previewImg').attr('src',
    './assets/imagenes/no_image.jpg'); // Restablecer la imagen de vista previa

}

window.fnc_RegresarListadoProductosModelo = function() {
    limpiarDatos();
    cargarPlantilla('ProductoModeloReq/producto_sinubica', 'content-wrapper');
};

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


//Funciones de modal

// Función para abrir el modal con el título correspondiente
window.abrirModal=function(tipo) {
    modoActual = tipo; // Asigna el modo actual

    // Cambiar el título del modal y otros textos según el tipo
    const modalLabel = document.getElementById("modalLabel");
    if (tipo === 'categoria') {
        modalLabel.innerHTML = "Agregar Categoría";
    } else if (tipo === 'unidad_medida') {
        modalLabel.innerHTML = "Agregar Unidad de Medida";
    }

    // Limpiar campos al abrir el modal
    limpiarCamposModal();
    
    // Mostrar el modal
    $('#mdlGestionarGeneral').modal('show');
}

    // Función para limpiar los campos del modal
function limpiarCamposModal() {
    $('#codigoModal').val('');
    $('#descripcionModal').val('');
    $('#formGeneral').removeClass('was-validated');
}

// Función para "guardar" los datos
window.guardarDatos = function() {
    // Validar formulario antes de continuar
    const form = document.getElementById('formGeneral');
    if (form.checkValidity() === false) {
        form.classList.add('was-validated');
        return;
    }

    // Definir la URL y los datos en función del tipo de registro (categoría o unidad de medida)
    let url, data;

    if (modoActual === 'categoria') {
        url = '{{ route("categoria.guardar") }}';
        data = {
            _token: '{{ csrf_token() }}',
            codigo: $('#codigoModal').val(),
            nomb_cate: $('#descripcionModal').val(),
            estado: 1
        };
    } else if (modoActual === 'unidad_medida') {
        url = '{{ route("UnidadMedida.guardar") }}';
        data = {
            _token: '{{ csrf_token() }}',
            codigo: $('#codigoModal').val(),
            nomb_uniMed: $('#descripcionModal').val(),
            estado: 1
        };
    }

    // Realizar la solicitud AJAX para guardar la categoría o la unidad de medida
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function(response) {
            // Mostrar mensaje de éxito o error
            Swal.fire({
                icon: response.tipo_msj === "success" ? "success" : "error",
                title: response.tipo_msj === "success" ? "Éxito" : "Error",
                text: response.msj,
            });

            if (response.tipo_msj === "success") {
                // Cerrar el modal después de guardar
                $('#mdlGestionarGeneral').modal('hide');
                
                // Llamar a la función de carga adecuada
                if (modoActual === 'categoria') {
                    cargarCategorias();
                } else if (modoActual === 'unidad_medida') {
                    cargarUnidadesMedida();
                }
                
                // Limpiar el formulario
                limpiarCamposModal();
            }
        },
        error: function(xhr) {
            // Mostrar mensaje de error
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un problema al intentar guardar. Intente nuevamente.',
            });
        }
    });
};







</script>

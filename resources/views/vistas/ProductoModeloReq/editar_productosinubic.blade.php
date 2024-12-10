@php
    $productomodeloreq = App\Models\ProductoModeloReq::find($id_de_paso);
@endphp
@if($productomodeloreq)
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Edicion</h2>
            </div><!-- /.col -->
            <div class="col-sm-6  d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Editar Producto</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-gray shadow mt-4">
            <div class="card-body px-3 py-3">
                <span class="titulo-fieldset px-3 py-1">DATOS DEL PRODUCTO</span>

                <div class="row my-1">
                    <div class="col-12">
                        <form id="frm-datos-producto" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id_producto" id="id_producto"
                                    value="{{ $productomodeloreq->id }}">
                                <!-- CODIGO PRODUCTO -->
                                <div class="col-12 col-lg-4 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color form-label"><i
                                            class="fas fa-barcode mr-1 my-text-color"></i>Código del Producto</label>
                                    <input type="text" class="form-control form-control-sm" id="codigo_productos"
                                        name="codigo_productos" value="{{ $productomodeloreq->cod_registro }}"
                                        readonly>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <!-- CATEGORÍAS -->
                                <div class="col-12 col-lg-8 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i
                                            class="fas fa-layer-group mr-1 my-text-color"></i>Categoría</label>
                                    <select class="form-select form-select-sm select2 cursor-pointer" id="id_categoria"
                                        name="id_categoria" required>
                                        <!-- Opciones cargadas dinámicamente por JavaScript -->
                                    </select>
                                    <div class="invalid-feedback">Seleccione la categoría</div>
                                </div>

                                <!-- DESCRIPCION DEL PRODUCTO -->
                                <div class="col-12 col-lg-6 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i
                                            class="fas fa-gifts mr-1 my-text-color"></i>Descripción</label>
                                    <input type="text" placeholder="Ingrese la descripción del producto"
                                        class="form-control form-control-sm" id="descripcion" name="descripcion"
                                        value="{{ $productomodeloreq->descripcion }}" required>
                                    <div class="invalid-feedback">Ingrese descripción del producto</div>
                                </div>

                                <!-- UNIDAD MEDIDA -->
                                <div class="col-12 col-lg-4 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i
                                            class="fas fa-ruler mr-1 my-text-color"></i>Unidad/Medida</label>
                                    <select class="form-select form-select-sm select2 cursor-pointer"
                                        id="id_unidad_medida" name="id_unidad_medida" required>
                                        <!-- Opciones cargadas dinámicamente por JavaScript -->
                                    </select>
                                </div>

                                <!-- IMAGEN -->
                                <div class="col-12 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i
                                            class="fas fa-image mr-1 my-text-color"></i>Seleccione una imagen</label>
                                    <input type="file" class="form-control" id="imagen" name="imagen"
                                        value="{{ $productomodeloreq->imagen}}" accept="image/*"
                                        onchange="previewFile(this)">
                                </div>

                                <!-- PREVIEW IMAGEN -->
                                <div class="col-12 col-lg-3">
                                    <div style="width: 100%; height: 255px;">
                                        <img id="previewImg"
                                            src="{{ $productomodeloreq->imagen ? asset('storage/assets/imagenes/productos/' . $productomodeloreq->imagen) : asset('storage/assets/imagenes/productos/no_image.jpg') }}"
                                            class="border border-secondary"
                                            style="object-fit: fill; width: 100%; height: 100%;" alt="">
                                    </div>
                                </div>

                                <div class="col-lg-9">

                                    <div class="row">
                                        <!-- MINIMO STOCK -->
                                        <div class="col-12 col-lg-12">
                                            <label class="mb-0 ml-1 text-sm my-text-color"><i
                                                    class="fas fa-dollar-sign mr-1 my-text-color"></i>Stock
                                                Mínimo</label>
                                            <input type="number" min="0" step="0.01"
                                                placeholder="Ingrese el stock minimo"
                                                class="form-control form-control-sm" id="minimo_stock"
                                                name="minimo_stock" aria-label="Small"
                                                aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                    </div>
                                </div>
                                <!-- BOTONERA -->
                                <div class="col-12 text-center mt-3">
                                    <a class="btn btn-sm btn-danger  fw-bold " id="btnCancelarRegistro"
                                        style="position: relative; width: 160px;"
                                        onclick="fnc_RegresarListadoProductos();">
                                        <span class="text-button">REGRESAR</span>
                                        <span class="btn fw-bold icon-btn-danger ">
                                            <i class="fas fa-undo-alt fs-5 text-white m-0 p-0"></i>
                                        </span>
                                    </a>

                                    <a class="btn btn-sm btn-success  fw-bold " id="btnGuardarProducto"
                                        style="position: relative; width: 160px;" onclick="fnc_ActualizarProducto();">
                                        <span class="text-button">ACTUALIZAR</span>
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
@else
    <div class="content">
        <div class="container-fluid">
            <div class="alert alert-danger">
                Producto no encontrado.
            </div>
        </div>
    </div>
@endif
<script>
$(document).ready(function() {
    const idProducto = $('#id_producto').val();

    // Llamar a todas las funciones de carga como promesas
    Promise.all([
            cargarCategorias(),
            cargarUnidadesMedida()
            ]).then(() => {
            // Cuando todas las listas estén cargadas, cargar los datos del producto
            if (idProducto) {
                cargarDatosProducto(idProducto);
            }
        });
    });
    function cargarCategorias() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '{{ route("listar_categorias") }}',
                type: 'GET',
                success: function(data) {
                    let opciones = '<option value="">Seleccione una categoría</option>';
                    data.forEach(categoria => {
                        opciones += `<option value="${categoria.id}">${categoria.nomb_cate}</option>`;
                    });
                    $('#id_categoria').html(opciones);
                    resolve();
                },
                error: function() {
                    alert('Error al cargar las categorías.');
                    reject();
                }
            });
        });
    }

    // Función para cargar unidades de medida
    function cargarUnidadesMedida() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '{{ route("listar_unidades_medida") }}',
                type: 'GET',
                success: function(data) {
                    let opciones = '<option value="">Seleccione una unidad de medida</option>';
                    data.forEach(unidad => {
                        opciones += `<option value="${unidad.id}">${unidad.nomb_uniMed}</option>`;
                    });
                    $('#id_unidad_medida').html(opciones);
                    resolve();
                },
                error: function() {
                    alert('Error al cargar las unidades de medida.');
                    reject();
                }
            });
        });
    }

    // Función para limpiar datos
    function fnc_LimpiarControles()
    {
        $("#codigo_producto").prop('readonly', false);
        $("#codigo_producto").val('');
        $("#id_categoria").val('');
        $("#descripcion").val('');
        $("#id_unidad_medida").val('');
        $("#minimo_stock").val('');
        $("#iptImagen").val('');
        $("#previewImg").attr("src", "storage/assets/imagenes/productos/no_image.jpg");
    };

     // Función para cargar datos del producto y establecer los valores seleccionados
    function cargarDatosProducto(idProducto) {
        $.ajax({
            url: `/obtener-producto-modelo/${idProducto}`,
            type: 'GET',
            success: function(productomodeloreq) {
                $('#codigo_productos').val(productomodeloreq.codigo_productos);
                $('#descripcion').val(productomodeloreq.descripcion);
                $('#id_categoria').val(productomodeloreq.id_categorias).trigger('change');
                $('#id_unidad_medida').val(productomodeloreq.id_unidad_medida).trigger('change');
                $('#minimo_stock').val(productomodeloreq.minimo_stock);

                const imagenSrc = productomodeloreq.imagen //? `/storage/assets/imagenes/productos/${producto.imagen}` : '/storage/assets/imagenes/productos/no_image.jpg';
                if (imagenSrc && imagenSrc !== 'NoImagen') {
                    $('#previewImg').attr('src', "{{ asset('storage/assets/imagenes/productos') }}" + '/' + imagenSrc);} 
                else {
                    $('#previewImg').attr('src', "{{ asset('storage/assets/imagenes/productos/no_image.jpg') }}");}
                // $('#previewImg').attr('src', imagenSrc);
            },
            error: function() {
                alert('Error al cargar los datos del producto.');
            }
        });
    }
    // Función para regresar a la lista de productos y limpiar los controles
    window.fnc_RegresarListadoProductos=function() {
        fnc_LimpiarControles();
        cargarPlantilla('ProductoModeloReq/producto_sinubica', 'content-wrapper');
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



    window.fnc_ActualizarProducto=function() {

    let camposValidos = true;

    // Función para marcar campos como inválidos
    function marcarCampoInvalido(idCampo, mensaje) {
        camposValidos = false;
            $(idCampo).addClass('is-invalid');
            $(idCampo).next('.invalid-feedback').text(mensaje).show();
        }

        // Validar que todos los campos requeridos estén completos
        if (!$('#id_categoria').val()) marcarCampoInvalido('#id_categoria', 'Seleccione la categoría');
        if (!$('#descripcion').val()) marcarCampoInvalido('#descripcion', 'Ingrese descripción del producto');
        if (!$('#id_unidad_medida').val()) marcarCampoInvalido('#id_unidad_medida', 'Seleccione una unidad de medida');
        if (!$('#minimo_stock').val()) marcarCampoInvalido('#minimo_stock', 'Ingres un minimo stock');
        // Mostrar alerta si falta algún campo
        if (!camposValidos) {
            Swal.fire({
                icon: 'error',
                title: 'Error de Validación',
                text: 'Complete todos los campos obligatorios resaltados en rojo.',
            });
            return;
        }

        var formData = new FormData();

        // Obtener cada campo del formulario y añadirlo a formData
        formData.append('codigo_productos', $('#codigo_productos').val());
        formData.append('id_categoria', $('#id_categoria').val());
        formData.append('descripcion', $('#descripcion').val());
        formData.append('id_unidad_medida', $('#id_unidad_medida').val());
        formData.append('minimo_stock', $('#minimo_stock').val());

        // Agregar imagen si está seleccionada y validar extensión
        var imagen_valida = true;
        var file = $("#imagen").val();

        if (file) {
            var ext = file.substring(file.lastIndexOf("."));
            if (ext != ".jpg" && ext != ".png" && ext != ".gif" && ext != ".jpeg" && ext != ".webp") {
                Swal.fire('Error', "La extensión " + ext + " no es una imagen válida", 'error');
                imagen_valida = false;
            }

            if (!imagen_valida) return;

            const inputImage = document.querySelector('#imagen');
            formData.append('imagen', inputImage.files[0]);
        }

        Swal.fire({
            title: '¿Está seguro de actualizar el producto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('producto.actualizarmodeloreq') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: response.tipo_msj,
                            title: response.msj,
                            showConfirmButton: true
                        });
                        if (response.tipo_msj === "success") {
                            fnc_RegresarListadoProductos();
                        }
                    },
                    error: function(xhr) {
                        // Mostrar los mensajes de error de validación
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = "Errores de validación:\n";
                        for (const [key, value] of Object.entries(errors)) {
                            errorMessage += `${value}\n`;
                        }
                        Swal.fire('Error', errorMessage, 'error');
                    }
                });
            }
    });
}
</script>

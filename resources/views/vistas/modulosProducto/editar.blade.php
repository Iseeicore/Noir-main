@php
    $producto = App\Models\Producto::find($id_de_paso);
@endphp
@if($producto)
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0">Actualizar Producto</h2>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Inventario / Actualizar Producto</li>
                </ol>
            </div>
        </div>
    </div>
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
                                <input type="hidden" name="id_producto" id="id_producto" value="{{ $producto->id }}">

                                <!-- CODIGO PRODUCTO -->
                                <div class="col-12 col-lg-4 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color form-label"><i class="fas fa-barcode mr-1 my-text-color"></i>Código del Producto</label>
                                    <input type="text" class="form-control form-control-sm" id="codigo_productos" name="codigo_productos" value="{{ $producto->codigo_productos }}" readonly>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <!-- CATEGORÍAS -->
                                <div class="col-12 col-lg-8 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-layer-group mr-1 my-text-color"></i>Categoría</label>
                                    <select class="form-select form-select-sm select2 cursor-pointer" id="id_categoria" name="id_categoria" required>
                                        <!-- Opciones cargadas dinámicamente por JavaScript -->
                                    </select>
                                    <div class="invalid-feedback">Seleccione la categoría</div>
                                </div>

                                <!-- DESCRIPCION DEL PRODUCTO -->
                                <div class="col-12 col-lg-6 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-gifts mr-1 my-text-color"></i>Descripción</label>
                                    <input type="text" placeholder="Ingrese la descripción del producto" class="form-control form-control-sm" id="descripcion" name="descripcion" value="{{ $producto->descripcion }}" required>
                                    <div class="invalid-feedback">Ingrese descripción del producto</div>
                                </div>

                                <!-- TIPO AFECTACIÓN -->
                                <div class="col-12 col-lg-6 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-file-invoice-dollar mr-1 my-text-color"></i>Tipo Afectación</label>
                                    <select class="form-select form-select-sm select2 cursor-pointer" id="id_tipo_afectacion_igv" name="id_tipo_afectacion_igv" required>
                                        <!-- Opciones cargadas dinámicamente por JavaScript -->
                                    </select>
                                </div>

                                <!-- IMPUESTO -->
                                <div class="col-12 col-lg-4 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-percentage mr-1 my-text-color"></i>IGV (%)</label>
                                    <input type="text" class="form-control form-control-sm" id="impuesto" name="impuesto" readonly>
                                </div>

                                <!-- UNIDAD MEDIDA -->
                                <div class="col-12 col-lg-4 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-ruler mr-1 my-text-color"></i>Unidad/Medida</label>
                                    <select class="form-select form-select-sm select2 cursor-pointer" id="id_unidad_medida" name="id_unidad_medida" required>
                                        <!-- Opciones cargadas dinámicamente por JavaScript -->
                                    </select>
                                </div>

                                <!-- ALMACÉN -->
                                <div class="col-12 col-lg-4 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-warehouse mr-1 my-text-color"></i>Almacén</label>
                                    <select class="form-select form-select-sm select2 cursor-pointer" id="id_almacen" name="id_almacen" required>
                                        <!-- Opciones cargadas dinámicamente por JavaScript -->
                                    </select>
                                </div>

                                <!-- IMAGEN -->
                                <div class="col-12 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-image mr-1 my-text-color"></i>Seleccione una imagen</label>
                                    <input type="file" class="form-control" id="imagen" name="imagen" value="{{$producto->imagen}}" accept="image/*" onchange="previewFile(this)">
                                </div>

                                <!-- PREVIEW IMAGEN -->
                                <div class="col-12 col-lg-3">
                                    <div style="width: 100%; height: 255px;">
                                        <img id="previewImg" src="{{ $producto->imagen ? asset('storage/assets/imagenes/productos/' . $producto->imagen) : asset('storage/assets/imagenes/productos/no_image.jpg') }}" class="border border-secondary" style="object-fit: fill; width: 100%; height: 100%;" alt="">
                                    </div>
                                </div>

                                <div class="col-lg-9">

                                    <div class="row">

                                        <!-- PRECIO DE VENTA (INC. IGV) -->
                                        <div class="col-12 col-lg-6 mb-2">
                                            <label class="mb-0 ml-1 text-sm my-text-color"><i
                                                    class="fas fa-dollar-sign mr-1 my-text-color"></i>Precio (con
                                                IGV)</label>
                                            <input type="number" min="0" step="0.01"
                                                placeholder="Ingrese Precio con IGV"
                                                class="form-control form-control-sm" id="precio_unitario_con_igv"
                                                name="precio_unitario_con_igv" aria-label="Small"
                                                aria-describedby="inputGroup-sizing-sm" required>
                                        </div>

                                        <!-- PRECIO DE VENTA (SIN. IGV) -->
                                        <div class="col-12 col-lg-6 mb-2">
                                            <label class="mb-0 ml-1 text-sm my-text-color"><i
                                                    class="fas fa-dollar-sign mr-1 my-text-color"></i>Precio (sin
                                                IGV)</label>
                                            <input type="number" min="0" step="0.01"
                                                placeholder="Ingrese Precio sin IGV"
                                                class="form-control form-control-sm" id="precio_unitario_sin_igv"
                                                name="precio_unitario_sin_igv" aria-label="Small"
                                                aria-describedby="inputGroup-sizing-sm">
                                        </div>

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
                                    <a class="btn btn-sm btn-danger  fw-bold " id="btnCancelarRegistro" style="position: relative; width: 160px;" onclick="fnc_RegresarListadoProductos();">
                                        <span class="text-button">REGRESAR</span>
                                        <span class="btn fw-bold icon-btn-danger ">
                                            <i class="fas fa-undo-alt fs-5 text-white m-0 p-0"></i>
                                        </span>
                                    </a>

                                    <a class="btn btn-sm btn-success  fw-bold " id="btnGuardarProducto" style="position: relative; width: 160px;" onclick="fnc_ActualizarProducto();">
                                        <span class="text-button">ACTUALIZAR</span>
                                        <span class="btn fw-bold icon-btn-success ">
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
            cargarUnidadesMedida(),
            cargarTiposAfectacion(),
            cargarAlmacenes()
        ]).then(() => {
            // Cuando todas las listas estén cargadas, cargar los datos del producto
            if (idProducto) {
                cargarDatosProducto(idProducto);
            }
        });
    // Función para cargar las categorías
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

    // Función para cargar tipos de afectación IGV
    function cargarTiposAfectacion() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '{{ route("listar_tipo_afectacion_igv") }}',
                type: 'GET',
                success: function(data) {
                    let opciones = '<option value="">Seleccione tipo de afectación</option>';
                    data.forEach(tipo => {
                        opciones += `<option value="${tipo.id}">${tipo.nomb_impuesto}</option>`;
                    });
                    $('#id_tipo_afectacion_igv').html(opciones);
                    resolve();
                },
                error: function() {
                    alert('Error al cargar los tipos de afectación.');
                    reject();
                }
            });
        });
    }


    // Función para cargar almacenes
    function cargarAlmacenes() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '{{ route("listar_almacenes") }}',
                type: 'GET',
                success: function(data) {
                    let opciones = '<option value="">Seleccione un almacén</option>';
                    data.forEach(almacen => {
                        opciones += `<option value="${almacen.id}">${almacen.nomb_almacen}</option>`;
                    });
                    $('#id_almacen').html(opciones);
                    resolve();
                },
                error: function() {
                    alert('Error al cargar los almacenes.');
                    reject();
                }
            });
        });
    }

    // Función para cargar datos del producto y establecer los valores seleccionados
    function cargarDatosProducto(idProducto) {
        $.ajax({
            url: `/obtener-producto/${idProducto}`,
            type: 'GET',
            success: function(producto) {
                $('#codigo_productos').val(producto.codigo_productos);
                $('#descripcion').val(producto.descripcion);
                $('#id_categoria').val(producto.id_categorias).trigger('change');
                $('#id_unidad_medida').val(producto.id_unidad_medida).trigger('change');
                $('#id_almacen').val(producto.id_almacen).trigger('change');
                $('#id_tipo_afectacion_igv').val(producto.id_tipo_afectacion_igv).trigger('change');
                $('#impuesto').val(producto.impuesto); // Porcentaje IGV
                $('#precio_unitario_con_igv').val(producto.Precio_unitario_con_igv);
                $('#precio_unitario_sin_igv').val(producto.Precio_unitario_sin_igv);
                $('#minimo_stock').val(producto.minimo_stock);

                const imagenSrc = producto.imagen //? `/storage/assets/imagenes/productos/${producto.imagen}` : '/storage/assets/imagenes/productos/no_image.jpg';
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

    function calcularPrecioSinIGV() {
        const precioConIGV = parseFloat($('#precio_unitario_con_igv').val()) || 0;
        const porcentajeIGV = parseFloat($('#impuesto').val()) || 0;
        const precioSinIGV = precioConIGV / (1 + (porcentajeIGV / 100));
        $('#precio_unitario_sin_igv').val(precioSinIGV.toFixed(2));
    }

    // Cambiar el valor del impuesto dinámicamente al cambiar el tipo de afectación
    $('#id_tipo_afectacion_igv').change(function() {
        const idTipoAfectacion = $(this).val();
        $.ajax({
            url: '{{ route("listar_tipo_afectacion_igv") }}',
            type: 'GET',
            success: function(data) {
                const tipoSeleccionado = data.find(tipo => tipo.id == idTipoAfectacion);
                if (tipoSeleccionado) {
                    $('#impuesto').val(tipoSeleccionado.porcentaje); // Actualizar el campo de impuesto
                    calcularPrecioSinIGV();
                } else {
                    $('#impuesto').val(''); // Limpiar si no se encuentra
                }
            },
            error: function() {
                alert('Error al cargar el porcentaje de IGV.');
            }
        });
    });

    // Al cambiar el precio con IGV, recalcular el precio sin IGV
    $('#precio_unitario_con_igv').on('input', function() {
            calcularPrecioSinIGV();
    });
    // Trigger para cargar el valor inicial en caso de que ya esté seleccionado
    $('#id_tipo_afectacion_igv').trigger('change');

    // Función para limpiar datos
    function fnc_LimpiarControles()
    {
        $("#codigo_producto").prop('readonly', false);
        $("#codigo_producto").val('');
        $("#id_categoria").val('');
        $("#descripcion").val('');
        $("#id_tipo_afectacion_igv").val('');
        $("#impuesto").val('');
        $("#id_unidad_medida").val('');
        $("#precio_unitario_con_igv").val('');
        $("#precio_unitario_sin_igv").val('');
        $("#precio_unitario_mayor_con_igv").val('');
        $("#precio_unitario_mayor_sin_igv").val('');
        $("#precio_unitario_oferta_con_igv").val('');
        $("#precio_unitario_oferta_sin_igv").val('');
        $("#minimo_stock").val('');
        $("#iptImagen").val('');
        $("#previewImg").attr("src", "storage/assets/imagenes/productos/no_image.jpg");
    };

    // Función para regresar a la lista de productos y limpiar los controles
    window.fnc_RegresarListadoProductos=function() {
        fnc_LimpiarControles();
        cargarPlantilla('producto', 'content-wrapper');
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
        if (!$('#id_tipo_afectacion_igv').val()) marcarCampoInvalido('#id_tipo_afectacion_igv', 'Seleccione tipo de afectación');
        if (!$('#id_unidad_medida').val()) marcarCampoInvalido('#id_unidad_medida', 'Seleccione una unidad de medida');
        if (!$('#id_almacen').val()) marcarCampoInvalido('#id_almacen', 'Seleccione un almacén');
        if (!$('#precio_unitario_con_igv').val()) marcarCampoInvalido('#precio_unitario_con_igv', 'Ingrese Precio con IGV');

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
        formData.append('id_almacen', $('#id_almacen').val());
        formData.append('descripcion', $('#descripcion').val());
        formData.append('id_tipo_afectacion_igv', $('#id_tipo_afectacion_igv').val());
        formData.append('id_unidad_medida', $('#id_unidad_medida').val());
        formData.append('precio_unitario_con_igv', $('#precio_unitario_con_igv').val());
        formData.append('precio_unitario_sin_igv', $('#precio_unitario_sin_igv').val());
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
                    url: "{{ route('producto.actualizar') }}",
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



});



</script>
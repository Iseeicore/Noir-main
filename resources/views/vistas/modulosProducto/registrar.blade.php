<!-- Content Header (Page header) -->
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

                                <input type="hidden" name="impuesto_producto" id="impuesto_producto">

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

                                <!-- TIPO AFECTACIÓN -->
                                <div class="col-12 col-lg-6 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i
                                            class="fas fa-file-invoice-dollar mr-1 my-text-color"></i>Tipo
                                        Afectación</label>
                                    <select class="form-select form-select-sm select2 cursor-pointer"
                                        id="id_tipo_afectacion_igv" name="id_tipo_afectacion_igv"
                                        aria-label="Floating label select example" required>
                                    </select>
                                    <div class="invalid-feedback">Seleccione el Tipo de Afectación</div>
                                </div>

                                <!-- IMPUESTO -->
                                <div class="col-12 col-lg-4 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i
                                            class="fas fa-percentage mr-1 my-text-color"></i>IGV (%)</label>
                                    <input type="text" class="form-control form-control-sm" id="impuesto"
                                        name="impuesto" aria-label="Small" aria-describedby="inputGroup-sizing-sm"
                                        readonly>
                                </div>

                                <!-- UNIDAD MEDIDA -->
                                <div class="col-12 col-lg-4 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i
                                            class="fas fa-ruler mr-1 my-text-color"></i>Unidad/Medida</label>
                                    <select class="form-select form-select-sm select2 cursor-pointer"
                                        id="id_unidad_medida" name="id_unidad_medida"
                                        aria-label="Floating label select example" required>
                                    </select>
                                    <div class="invalid-feedback">Seleccione la Unidad de Medida</div>
                                </div>

                                <!-- Almacen  -->
                                <div class="col-12 col-lg-4 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i
                                            class="fas fa-ruler mr-1 my-text-color"></i>Almacen</label>
                                    <select class="form-select form-select-sm select2 cursor-pointer" id="id_almacen"
                                        name="id_almacen" aria-label="Floating label select example" required>
                                    </select>
                                    <div class="invalid-feedback">Seleccione la Almacen</div>
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
                                    <a class="btn btn-sm btn-danger  fw-bold " id="btnCancelarRegistro"
                                        style="position: relative; width: 160px;"
                                        onclick="fnc_RegresarListadoProductos();">
                                        <span class="text-button">REGRESAR</span>
                                        <span class="btn fw-bold icon-btn-danger ">
                                            <i class="fas fa-undo-alt fs-5 text-white m-0 p-0"></i>
                                        </span>
                                    </a>

                                    <a class="btn btn-sm btn-success  fw-bold " id="btnGuardarProducto"
                                        style="position: relative; width: 160px;" onclick="fnc_registrarProducto();">
                                        <span class="text-button">REGISTRAR</span>
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
<script>
    $(document).ready(function() {

        cargarTipoAfectacionIgv(); // Cargar la lista de tipo de afectaciones al cargar la página

        // Event listener para cuando se selecciona un tipo de afectación
        $('#id_tipo_afectacion_igv').change(function() {
            var selectedOption = $(this).find(':selected');
            var porcentajeImpuesto = selectedOption.data('porcentaje');

            // Actualizar el campo de impuesto con el porcentaje seleccionado
            $('#impuesto').val(porcentajeImpuesto || '0');
            calcularPrecios();
        });

        // Event listener para los campos de precio
        $('#precio_unitario_con_igv, #precio_unitario_sin_igv').on('keyup', function() {
            // Verificar si se ha seleccionado un tipo de afectación
            if ($('#id_tipo_afectacion_igv').val() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Seleccione el Tipo de Afectación',
                    confirmButtonText: 'OK'
                });
                $('#precio_unitario_con_igv').val('');
                $('#precio_unitario_sin_igv').val('');
                return;
            }

            // Realizar los cálculos si se ha seleccionado un tipo de afectación
            calcularPrecios();
        });

        cargarCategorias();
        cargarUnidadesMedida();
        cargarAlmacenes();


         // Mostrar SweetAlert al cargar la vista
    Swal.fire({
        title: '¿Cómo deseas ingresar el código del producto?',
        text: "Elige si deseas ingresarlo manualmente o que se genere automáticamente.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Generar automáticamente',
        cancelButtonText: 'Ingresar manualmente',
    }).then((result) => {
        if (result.isConfirmed) {
            // Mantener el campo readonly y generar automáticamente
            generarCodigoProducto();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Permitir ingreso manual, quitar readonly
            $('#codigo_productos').prop('readonly', false);
        }
    });

    $('#descripcion, #id_almacen').on('keyup change', function() {
        // Solo generar código si el campo es readonly
        if ($('#codigo_productos').prop('readonly')) {
            generarCodigoProducto();
        }
    });

    function generarCodigoProducto() {
        var idAlmacen = $('#id_almacen').val();
        var descripcion = $('#descripcion').val();

        if (idAlmacen && descripcion.length >= 6) {
            $.ajax({
                url: '{{ route("generar_codigo_producto") }}',
                type: 'POST',
                data: {
                    id_almacen: idAlmacen,
                    descripcion: descripcion,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#codigo_productos').val(data.codigo_productos || '');
                },
                error: function(xhr, status, error) {
                    console.error('Error al generar el código del producto:', error);
                }
            });
        } else {
            $('#codigo_productos').val(''); // Limpia si la descripción no es válida
        }
    }




      


        // Función para realizar los cálculos de precios
        function calcularPrecios() {
            var precio_unitario_con_igv = parseFloat($('#precio_unitario_con_igv').val()) || 0;
            var precio_unitario_sin_igv = parseFloat($('#precio_unitario_sin_igv').val()) || 0;
            var porcentajeImpuesto = parseFloat($('#impuesto').val()) / 100;

            if ($('#precio_unitario_con_igv').val() !== '' && !isNaN(precio_unitario_con_igv)) {
                // Calcular precio sin IGV
                precio_unitario_sin_igv = parseFloat(precio_unitario_con_igv / (1 + porcentajeImpuesto))
                    .toFixed(2);
                $('#precio_unitario_sin_igv').val(precio_unitario_sin_igv);
            } else if ($('#precio_unitario_sin_igv').val() !== '' && !isNaN(precio_unitario_sin_igv)) {
                // Calcular precio con IGV
                precio_unitario_con_igv = parseFloat(precio_unitario_sin_igv * (1 + porcentajeImpuesto))
                    .toFixed(2);
                $('#precio_unitario_con_igv').val(precio_unitario_con_igv);
            }
        }

        // Función para cargar el listado de tipo de afectación IGV
        function cargarTipoAfectacionIgv() {
            $.ajax({
                url: '{{ route('listar_tipo_afectacion_igv') }}', // Ruta para obtener la lista de tipo de afectación IGV
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#id_tipo_afectacion_igv');
                    select.empty();
                    select.append(
                        '<option value="">-- Seleccione un Tipo de Afectación --</option>');
                    data.forEach(function(tipo) {
                        select.append('<option value="' + tipo.id + '" data-porcentaje="' +
                            tipo.porcentaje + '">' + tipo.nomb_impuesto +
                            '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar tipo de afectación IGV:', error);
                }
            });
        }

        // Función para cargar categorías basadas en la familia seleccionada
        function cargarCategorias() {
            $.ajax({
                url: '{{ route('listar_Categorias_Formulario') }}', // Asegúrate de que la ruta es correcta
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#id_categoria');
                    select.empty().append('<option value="">-- Seleccione una Categoría --</option>');
                    
                    // Recorrer los datos y agregar opciones al select
                    data.forEach(function(categoria) {
                        // Cada opción mostrará el nombre, pero el valor será el ID
                        select.append('<option value="' + categoria.id + '">' + categoria.nomb_cate + ' (' + categoria.id + ')</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar categorías:', error);
                }
            });
        }
        // Función para cargar unidades de medida
        function cargarUnidadesMedida() {
            $.ajax({
                url: '{{ route('listar_unidades_medida') }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#id_unidad_medida');
                    select.empty();
                    select.append('<option value="">-- Seleccione Unidad de Medida --</option>');
                    data.forEach(function(unidad) {
                        select.append('<option value="' + unidad.id + '">' + unidad
                            .nomb_uniMed + ' (' + unidad.id + ')</option>');
                    });
                },
                error: function(xhr) {
                    console.error('Error al cargar unidades de medida:', xhr.responseText);
                }
            });
        }
        // Función para cargar almacenes
        function cargarAlmacenes() {
            $.ajax({
                url: '{{ route('listar_almacenesReg') }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#id_almacen'); // Asegúrate de que el ID sea único y correcto
                    select.empty();
                    select.append('<option value="">-- Seleccione Almacén --</option>');
                    data.forEach(function(almacen) {
                        select.append('<option value="' + almacen.id + '">' + almacen
                            .nomb_almacen + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error('Error al cargar almacenes:', xhr.responseText);
                }
            });
        }

        function limpiarDatos() {
            // Limpiar todos los selects (desplegables)
            $('#id_familia').val('').trigger('change'); // Devuelve a estado inicial
            $('#id_categoria').val('').trigger('change');
            $('#id_tipo_afectacion_igv').val('').trigger('change');
            $('#id_unidad_medida').val('').trigger('change');
            $('#id_almacen').val('').trigger('change');

            // Limpiar los inputs de texto
            $('#codigo_productos').val(''); // Código del producto
            $('#descripcion').val(''); // Descripción del producto

            // Limpiar los inputs de precio e impuesto
            $('#precio_unitario_con_igv').val(''); // Precio con IGV
            $('#precio_unitario_sin_igv').val(''); // Precio sin IGV
            $('#impuesto').val('0'); // Impuesto (readonly)
            $('#minimo_stock').val(''); // Stock mínimo

            // Limpiar el campo de imagen
            $('#imagen').val(''); // Restablecer el input de archivo
            $('#previewImg').attr('src',
            './assets/imagenes/no_image.jpg'); // Restablecer la imagen de vista previa

        }

        function CargarContenido(vista, contenedor) {
            $.ajax({
                url: '{{ url('/cargar-contenido') }}', // Correct URL setup for Laravel
                type: 'GET',
                data: {
                    contenido: vista
                },
                success: function(response) {
                    $('.' + contenedor).html(response);
                },
                error: function(xhr) {
                    console.error('Error loading content. Status:', xhr.status, 'Error:', xhr
                        .statusText);
                }
            });
        }

        window.fnc_registrarProducto = function() { 
            var formData = new FormData($('#frm-datos-producto')[0]);
            // Añadir el token CSRF al FormData
            formData.append('_token', '{{ csrf_token() }}');    
            var imagenValida = true;

            // Validar el formulario
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                if (form.checkValidity() === true) {
                    var file = $("#imagen").val();

                    // Validar la extensión de la imagen
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

                    // Mostrar confirmación con SweetAlert
                    Swal.fire({
                        title: '¿Está seguro de registrar el producto?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, deseo registrarlo!',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Hacer la solicitud Ajax para registrar el producto
                            $.ajax({
                                url: '{{ route('registrar_producto') }}',
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    Swal.fire('Éxito', response.msj, 'success');
                                    if (response.tipo_msj === 'success') {
                                        fnc_RegresarListadoProductos(); // Regresar al listado
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire('Error', 'Ocurrió un error al registrar el producto', 'error');
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire('Advertencia', 'Complete los campos obligatorios.', 'warning');
                }

                form.classList.add('was-validated');
            });
        }

        


        window.fnc_RegresarListadoProductos = function() {
        limpiarDatos();
        CargarContenido('producto', 'content-wrapper');
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

    });
</script>

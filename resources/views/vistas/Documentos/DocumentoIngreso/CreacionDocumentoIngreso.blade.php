<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Creacion de Documento Ingreso</h2>
            </div><!-- /.col -->
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                    <li class="breadcrumb-item active">Creacion Doc. Ingreso</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<form id="frm-documento-ingreso" method="POST" onsubmit="return false;">
    @csrf
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Información de Documento Ingreso -->
                    <div class="card card-gray shadow mt-3">
                        <div class="card-body px-3 py-3">
                            <span class="titulo-fieldset px-3 py-1">INFORMACIÓN DE DOCUMENTO INGRESO</span>
                            <div class="row my-2">
                                <input type="hidden" name="id_usuario" value="{{ auth()->user()->id_usuario }}">
                                
                                <div class="col-12 col-lg-3 mb-2">
                                    <label>Código de Documento de Ingreso</label>
                                    <input type="text" id="codigo_documento_ingreso" name="codigo_documento_ingreso" class="form-control form-control-sm" required readonly>
                                </div>
                                
                                <div class="col-12 col-lg-2 mb-2">
                                    <label>Fecha Emisión</label>
                                    <input type="date" id="fecha_emision" name="fecha_emision" class="form-control form-control-sm" required>
                                </div>
                                
                                <div class="col-12 col-lg-2 mb-2">
                                    <label>Fecha Contable</label>
                                    <input type="date" id="fecha_contable" name="fecha_contable" class="form-control form-control-sm" required>
                                </div>
                                
                                <div class="col-12 col-lg-5 mb-2">
                                    <label>Periodo</label>
                                    <input type="text" id="periodo" name="periodo" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                            
                            <div class="row my-2">
                                <div class="col-12 col-lg-4 mb-2">
                                    <label>Tipo de Operación</label>
                                    <select class="form-select" id="tipo_operacion" name="tipo_operacion" required>
                                        <option value="">-- Seleccione --</option>
                                    </select>
                                </div>
                                
                                <div class="col-12 col-lg-4 mb-2">
                                    <label>Proveedor</label>
                                    <select class="form-select" id="proveedor" name="proveedor" required>
                                        <option value="">-- Seleccione --</option>
                                    </select>
                                </div>
                                
                                <div class="col-12 col-lg-4 mb-2">
                                    <label>Almacén</label>
                                    <!-- Campo readonly para mostrar el nombre del almacén -->
                                    <input type="text" class="form-control form-control-sm"  id="almacen_nombre" name="almacen_nombre" readonly>
                                    <!-- Campo oculto para almacenar el ID del almacén -->
                                    <input type="hidden" id="almacen_id" name="almacen_id">
                                </div>
                                
                                
                                <div class="col-12 col-lg-4 mb-2">
                                    <label>Comprobante de Pago</label>
                                    <select class="form-select" id="comprobante_pago" name="comprobante_pago" required>
                                        <option value="">-- Seleccione --</option>
                                    </select>
                                </div>

                                <div class="col-12 col-lg-4 mb-2">
                                    <label>Tipo de Cambio</label>
                                    <select class="form-select" id="tipo_cambio" name="tipo_cambio" required>
                                        <option value="">-- Seleccione --</option>
                                        <option value="USD">USD - Dólar</option>
                                        <option value="PEN">PEN - Sol</option>
                                    </select>
                                </div>
                                <input type="hidden" id="tipo_cambio_id" name="tipo_cambio_id"> <!-- Input oculto para almacenar el id -->
                                <div class="col-12 col-lg-4 mb-2">
                                    <label>Conversion Moneda</label>
                                    <input type="text" id="cantidad_cambio" name="cantidad_cambio" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                            
                            <div class="row my-2">

                                
                                <div class="col-12 col-lg-3 mb-2">
                                    <label>Número Documento</label>
                                    <input type="text" id="numerodocumento" name="numerodocumento" class="form-control form-control-sm" required>
                                </div>
                                
                                <div class="col-12 col-lg-3 mb-2">
                                    <label>Número Secundario Documento</label>
                                    <input type="text" id="numerosecundariodocumento" name="numerosecundariodocumento" class="form-control form-control-sm" required>
                                </div>
                                
                                <div class="col-12 col-lg-3 mb-2">
                                    <label>Glosario</label>
                                    <input type="text" id="glosario" name="glosario" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-12 col-lg-3 mb-2">
                                    <label>Total Efectivo</label>
                                    <input type="text" id="total_efectivo" name="total_efectivo" class="form-control form-control-sm" readonly>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Productos Ingresados -->
                    <div class="card card-gray shadow mt-3">
                        <div class="card-body px-3 py-3">
                            <span class="titulo-fieldset px-3 py-1">PRODUCTOS INGRESADOS</span>
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered shadow border-secondary display" id="productosTable">
                                    <thead class="bg-main text-center">
                                        <tr>
                                            <th>N°</th>
                                            <th>Producto</th>
                                            <th>Unidad Medida</th>
                                            <th>Cantidad</th>
                                            <th>Centro de Costos</th>
                                            <th>Tipo de Afectación(%)</th>
                                            <th>Precio Unitario</th>
                                            <th>Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <select id="producto" name="producto[]" class="form-select form-select-sm">
                                                    <option value="">-- Seleccione --</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" id="unidadMedida" name="unidadMedida_nombre[]" class="form-control form-control-sm" readonly>
                                                <input type="hidden" id="unidadMedida_id" name="unidadMedida_id[]">
                                            </td>
                                            <td>
                                                <input type="number" id="cantidad" name="cantidad[]" class="form-control form-control-sm" min="1" required>
                                            </td>
                                            <td>
                                                <select id="centro_costo" name="centro_costo[]" class="form-select form-select-sm">
                                                    <option value="">-- Seleccione --</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select id="tipo_afectacion" name="tipo_afectacion[]" class="form-select form-select-sm">
                                                    <option value="">-- Seleccione --</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" id="precio_unitario" name="precio_unitario[]" class="form-control form-control-sm" required>
                                            </td>
                                            <td>
                                                <input type="text" id="total" name="total[]" class="form-control form-control-sm" readonly>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group d-flex justify-content-center" role="group">
                                                    <button type="button" class="btn btn-sm btn-primary addRow mx-1" onclick="agregarNuevaFila()">
                                                        <i class="fas fa-plus fs-5"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-success saveRow mx-1" onclick="guardarFila(this)">
                                                        <i class="fas fa-save fs-5"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger deleteRow mx-1" onclick="eliminarFila(this)">
                                                        <i class="fas fa-trash fs-5"></i>
                                                    </button>
                                                </div>
                                            </td>                       
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success"onclick="GuardarDatos()"><i class="fas fa-save"></i> Guardar</button>
                        <button type="reset" class="btn btn-danger" onclick="regresarDocIngreso()"><i class="fas fa-undo-alt"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var contadorFilas = 1; // Contador global para las filas
    var centrosCostoOptions = ''; // Opciones pre-cargadas para centros de costo
    var tipoAfectacionOptions = ''; // Opciones pre-cargadas para productos
    var productosinModeloOptions = ''; // Opciones pre-cargadas para productos

    $(document).ready(function() {
        preCargarOpciones();
        obtenerCodigorReq();
        inicializarEventosDinamicos();
    
    $('#fecha_emision, #fecha_contable').on('change', function () {
        generarCodigoPeriodo(this.value);
    });

    $('#fecha_emision').on('change', function () {
        const fechaSeleccionada = $(this).val(); // Obtener la fecha seleccionada
        const monedaSeleccionada = $('#tipo_cambio').val(); // Obtener la moneda seleccionada

        if (fechaSeleccionada && monedaSeleccionada) {
            cargarTipoCambio(fechaSeleccionada, monedaSeleccionada); // Llamar a la función con la fecha y la moneda
        }
    });



        /// Evento para agregar nuevas filas
    $('#btnAgregar').on('click', function() {
        agregarNuevaFila();
        inicializarEventosDinamicos(); // Reagregar eventos en las nuevas filas
    });

     // Evento para eliminar filas
    $('#productosTable').on('click', '.deleteRow', function () {
        eliminarFila(this);
    });

    // $('#tipo_cambio').on('change', function () {
    //     const monedaSeleccionada = $(this).val(); // USD o PEN
    //     cargarTipoCambio(monedaSeleccionada); // Llamada a la función
    // });

    $('#tipo_cambio').on('change', function () {
        const monedaSeleccionada = $(this).val(); // USD o PEN
        const fechaSeleccionada = $('#fecha_emision').val(); // Obtener la fecha seleccionada

        if (monedaSeleccionada && fechaSeleccionada) {
            cargarTipoCambio(fechaSeleccionada, monedaSeleccionada); // Llamar a la función con la fecha y la moneda
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Por favor, seleccione una fecha de emisión y una moneda.',
            });
        }
    });


    $('#comprobante_pago, #numerodocumento, #numerosecundariodocumento').on('change keyup', function () {
        actualizarGlosario();
    });

    cargarTipoOperacion(); // Cargar los tipos de operación
    cargarProveedores();   // Cargar los proveedores
    cargarAlmacenes();     // Cargar los almacenes
    cargarComprobantePago(); // Cargar los comprobantes de pago
    verificarMinimoFilas();
});

// Verificar si hay al menos una fila
function verificarMinimoFilas() {
    const numeroFilas = $('#productosTable tbody tr').length;

    if (numeroFilas === 1) {
        Swal.fire({
            icon: 'warning',
            title: 'Advertencia',
            text: 'Debe existir al menos una fila en la tabla.',
            timer: 1000, // Tiempo en milisegundos (1 segundo)
            showConfirmButton: false, // Ocultar el botón de confirmación
        });
    }
}


    // Cargar opciones para el centro de costo
    function cargarCentrosCosto() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "{{ route('documento.cargar_centros_costo') }}",
                type: 'GET',
                success: function(response) {
                    resolve(response); // Resuelve la promesa con la respuesta
                },
                error: function() {
                    reject(); // Rechaza la promesa si hay un error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar la lista de centros de costo. Intente nuevamente.',
                    });
                }
            });
        });
    }
    // Cargar opciones para el Tipo afectacion
    function cargarTipoAfectacion() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "{{ route('documento.cargar_tipoafectacion') }}",
                    type: 'GET',
                    success: function(response) {
                        // console.log(response); // Depuración: Verifica el contenido
                        resolve(response); // Resuelve la promesa con la respuesta
                    },
                    error: function() {
                        reject(); // Rechaza la promesa si hay un error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo cargar la lista de Tipo de afectacion. Intente nuevamente.',
                        });
                    }
                });
            });
        }
    // Cargar opciones para el Producto sin Modelo
    function cargarProductoSinModelo() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "{{ route('documento.cargar_productoSinUbicacion') }}",
                type: 'GET',
                success: function(response) {
                    // console.log(response);
                    resolve(response);
                },
                error: function() {
                    reject();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar la lista de productos sin modelo. Intente nuevamente.',
                    });
                }
            });
        });
    }


    function preCargarOpciones() {
        Promise.all([cargarCentrosCosto(), cargarTipoAfectacion(), cargarProductoSinModelo()])
            .then(([centrosCostoResponse, tipoAfectacionResponse, productosinModeloResponse]) => {
                // Guardamos la respuesta completa en una variable global
                window.productosinModeloResponse = productosinModeloResponse;

                centrosCostoOptions = `<option value="">-- Seleccione Centro de Costo --</option>` +
                    centrosCostoResponse.centros_costo
                        .map(cc => `<option value="${cc.id}">${cc.nomb_centroCos}</option>`)
                        .join('');

                tipoAfectacionOptions = `<option value="">-- Seleccione Afectacion --</option>` +
                    tipoAfectacionResponse.tipo_afectacion
                        .map(ta => `<option value="${ta.id}">${ta.porcentaje}</option>`)
                        .join('');

                productosinModeloOptions = `<option value="">-- Seleccione Producto --</option>` +
                    productosinModeloResponse.ProductoSinUbicacion
                        .map(pm => `<option value="${pm.id}">${pm.descripcion}</option>`)
                        .join('');

                cargarPrimeraFila();
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron cargar las opciones. Intente nuevamente.',
                });
            });
    }
function agregarNuevaFila() {
    contadorFilas++;

    const nuevaFila = $(`
        <tr>
            <td>${contadorFilas}</td>
            <td>
                <select id="producto" name="producto[]" class="form-select form-select-sm">
                    ${productosinModeloOptions}
                </select>
            </td>
            <td>
                <input type="text" id="unidadMedida" name="unidadMedida_nombre[]" class="form-control form-control-sm" readonly>
                <input type="hidden" id="unidadMedida_id" name="unidadMedida_id[]">
            </td>
            <td>
                <input type="number" id="cantidad" name="cantidad[]" class="form-control form-control-sm" min="1" required>
            </td>
            <td>
                <select id="centro_costo" name="centro_costo[]" class="form-select form-select-sm">
                    ${centrosCostoOptions}
                </select>
            </td>
            <td>
                <select id="tipo_afectacion" name="tipo_afectacion[]" class="form-select form-select-sm">
                    ${tipoAfectacionOptions}
                </select>
            </td>
            <td>
                <input type="number" id="precio_unitario" name="precio_unitario[]" class="form-control form-control-sm" required>
            </td>
            <td>
                <input type="text" id="total" name="total[]" class="form-control form-control-sm" readonly>
            </td>
            <td class="text-center">
                <div class="btn-group d-flex justify-content-center" role="group">
                    <button type="button" class="btn btn-sm btn-success saveRow mx-1" onclick="guardarFila(this)">
                        <i class="fas fa-save fs-5"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger deleteRow mx-1" onclick="eliminarFila(this)">
                        <i class="fas fa-trash fs-5"></i>
                    </button>
                </div>
            </td>
        </tr>`);

    $('#productosTable tbody').append(nuevaFila);

    // Asignar eventos a la nueva fila
    nuevaFila.find('#producto').on('change', function() {
        actualizarUnidadMedida(this);
    });

    inicializarEventosDinamicos(); // Reasignar eventos dinámicos
    actualizarTotalEfectivo(); // Recalcular el total efectivo
}

function CalculodePorcentajeDinamico() {
    $('#productosTable tbody tr').each(function () {
        const fila = $(this);

        // Obtener valores relevantes
        const porcentajeSelect = fila.find('#tipo_afectacion');
        const porcentaje = parseFloat(porcentajeSelect.find(':selected').text()) || 0; // Porcentaje seleccionado

        const precioUnitarioInput = fila.find('#precio_unitario');
        const precioUnitario = parseFloat(precioUnitarioInput.val()); // Mantener null si está vacío

        const cantidadInput = fila.find('#cantidad');
        const cantidad = parseFloat(cantidadInput.val()) || 0;

        const totalInput = fila.find('#total');

        // Solo calcular si hay un precio unitario válido
        if (!isNaN(precioUnitario)) {
            const porcentaje_precio_unitario = precioUnitario + (precioUnitario * (porcentaje / 100));
            const total = porcentaje_precio_unitario * cantidad;

            // Actualizar el total
            totalInput.val(total.toFixed(2));
        } else {
            totalInput.val(''); // Si no hay precio, limpiar total
        }

        // Actualizar el total efectivo
        actualizarTotalEfectivo();
    });
}
function inicializarEventosDinamicos() {
    // Actualizar porcentaje dinámicamente
    $('#productosTable').on('change', '#tipo_afectacion', function () {
        CalculodePorcentajeDinamico();
    });

    // Actualizar cuando cambien cantidad o precio unitario
    $('#productosTable').on('input', '#cantidad, #precio_unitario', function () {
        CalculodePorcentajeDinamico();
    });
}


function actualizarTotalEfectivo() {
    let sumaTotal = 0;

    // Iterar por cada fila y sumar el valor de `total`
    $('#productosTable tbody tr').each(function() {
        const total = parseFloat($(this).find('#total').val()) || 0; // Obtener el valor del campo total
        sumaTotal += total; // Sumarlo al acumulador
    });

    // Actualizar el campo `total_efectivo` con la suma total
    $('#total_efectivo').val(sumaTotal.toFixed(2)); // Mostrar con dos decimales
}

  // Función para obtener el siguiente código de proveedor y rellenar el campo cod_proveedor
function obtenerCodigorReq() {
    $.ajax({
        url: "{{ route('documento-ingreso.generar-codigo') }}",
        type: 'GET',
        success: function(response) {
            $('#codigo_documento_ingreso').val(response.nuevo_codigo); // Rellenar el campo cod_proveedor
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

//carga de select del head 
function cargarTipoOperacion() {
    $.ajax({
        url: '{{ route("documento-ingreso.cambio-tipo-operaciones-entrada") }}',
        type: 'GET',
        success: function(response) {
            var select = $('#tipo_operacion');
            select.empty().append('<option value="">-- Seleccione --</option>');
            response.tipo_operaciones.forEach(function(tipo) {
                select.append('<option value="' + tipo.id + '">' + tipo.descripcion + ' (' + tipo.tipo + ')</option>');
            });
        },
        error: function() {
            console.error('Error al cargar los tipos de operación.');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar los tipos de operación. Intente nuevamente.',
            });
        }
    });
}



function cargarProveedores() {
    $.ajax({
        url: '{{ route("documento-ingreso.proveedores") }}',
        type: 'GET',
        success: function(response) {
            var select = $('#proveedor');
            select.empty().append('<option value="">-- Seleccione --</option>');
            response.proveedor.forEach(function(prov) {
                select.append('<option value="' + prov.id + '">' + prov.razon_social + '</option>');
            });
        },
        error: function() {
            console.error('Error al cargar los proveedores.');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar los proveedores. Intente nuevamente.',
            });
        }
    });
}

function cargarAlmacenes() {
    $.ajax({
            url: '{{ route("cargar_almacenes_usuario") }}', // Ruta al controlador
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.almacen) {
                    // Asigna el nombre del almacén al campo de texto
                    $('#almacen_nombre').val(response.almacen.nombre);

                    // Asigna el ID del almacén al campo oculto
                    $('#almacen_id').val(response.almacen.id);
                } else {
                    // Si no hay almacén asignado, mostrar mensaje
                    $('#almacen_nombre').val(response.mensaje || 'No asignado');
                }
            },
            error: function (xhr) {
                console.error('Error al cargar el almacén:', xhr.responseText);
            }
        });
}

function cargarComprobantePago() {
    $.ajax({
        url: '{{ route("documento-ingreso.comprobante-pago") }}',
        type: 'GET',
        success: function(response) {
            var select = $('#comprobante_pago');
            select.empty().append('<option value="">-- Seleccione --</option>');
            response.comprobante_pago.forEach(function(comp) {
                select.append('<option value="' + comp.id + '">' + comp.descripcion + '</option>');
            });
        },
        error: function() {
            console.error('Error al cargar los comprobantes de pago.');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar los comprobantes de pago. Intente nuevamente.',
            });
        }
    });
}


function cargarTipoCambio(fechaSeleccionada, monedaSeleccionada) {
    if (monedaSeleccionada && fechaSeleccionada) {
        $.ajax({
            url: '{{ route("documento-ingreso.cargar-tipo-cambio-por-fecha") }}',
            type: 'POST',
            data: {
                fecha: fechaSeleccionada, // Agregar la fecha como parámetro
                moneda: monedaSeleccionada,
                _token: '{{ csrf_token() }}', // Token CSRF
            },
            success: function (response) {
                if (response.success) {
                    // Actualizar el campo de conversión con el tipo de cambio correspondiente
                    const tipoCambio = monedaSeleccionada === 'USD'
                        ? response.tipo_cambio_compra
                        : response.tipo_cambio_venta;

                    $('#cantidad_cambio').val(tipoCambio.toFixed(4)); // Mostrar con 4 decimales

                    // Asignar el id del tipo de cambio en el input oculto
                    $('#tipo_cambio_id').val(response.id);
                } else {
                    // Mostrar alerta si no se encuentra el tipo de cambio
                    Swal.fire({
                        icon: 'warning',
                        title: 'Advertencia',
                        text: response.message,
                    });
                    $('#cantidad_cambio').val(''); // Limpiar el campo
                    $('#tipo_cambio_id').val(''); // Limpiar el ID del tipo de cambio
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al cargar el tipo de cambio. Intente nuevamente.',
                });
            },
        });
    } else {
        // Limpiar el campo de conversión y el ID si no hay selección
        $('#cantidad_cambio').val('');
        $('#tipo_cambio_id').val('');
    }
}

function actualizarGlosario() {
    const comprobantePago = $('#comprobante_pago').val(); // ID del comprobante de pago seleccionado
    const numeroDocumento = $('#numerodocumento').val(); // Valor del número de documento
    const numeroSecundarioDocumento = $('#numerosecundariodocumento').val(); // Valor del número secundario de documento

    // Verificar que los campos no estén vacíos antes de generar el glosario
    if (comprobantePago && numeroDocumento && numeroSecundarioDocumento) {
        const glosario = `${comprobantePago}-${numeroDocumento}-${numeroSecundarioDocumento}`;
        $('#glosario').val(glosario); // Actualizar el campo glosario
    } else {
        $('#glosario').val(''); // Limpiar si falta algún dato
    }
}




// Generar el código del periodo basado en la fecha de emisión
function generarCodigoPeriodo(fechaEmision) {
    if (!fechaEmision) return; // Si no hay fecha, no hacer nada

    // Extraer el mes y el año de la fecha
    const fecha = new Date(fechaEmision);
    const mes = (fecha.getMonth() + 1).toString().padStart(2, '0'); // Obtener el mes (0 = enero, 11 = diciembre)
    const anio = fecha.getFullYear(); // Obtener el año

    // Generar el código en formato "MM/YYYY"
    const codigoPeriodo = `${mes}/${anio}`;

    // Rellenar el campo `periodo`
    $('#periodo').val(codigoPeriodo);
}

//Actualizar  unidad medida 
function actualizarUnidadMedida(selectElement) {
    const productoId = selectElement.value;

    // Buscar el producto en la respuesta cargada previamente
    const producto = productosinModeloResponse.ProductoSinUbicacion.find(
        pm => pm.id == productoId
    );

    // Obtener los campos de unidad de medida en la misma fila
    const unidadMedidaInput = $(selectElement)
        .closest('tr')
        .find('#unidadMedida');
    const unidadMedidaIdInput = $(selectElement)
        .closest('tr')
        .find('#unidadMedida_id');

    if (producto && producto.unidad_medida) {
        unidadMedidaInput.val(producto.unidad_medida.nomb_uniMed); // Mostrar el nombre de la unidad de medida
        unidadMedidaIdInput.val(producto.unidad_medida.id); // Almacenar el ID de la unidad de medida
    } else {
        unidadMedidaInput.val(''); // Limpiar si no se encuentra
        unidadMedidaIdInput.val(''); // Limpiar el ID
    }
}

// Actualizar la numeración después de eliminar filas
function actualizarNumeracion() {
    $('#productosTable tbody tr').each(function(index) {
        $(this).find('td:first').text(index + 1);
    });
    contadorFilas = $('#productosTable tbody tr').length;
}

// Poblar la primera fila con opciones pre-cargadas
function cargarPrimeraFila() {
    $('#productosTable tbody tr:first-child #centro_costo').html(centrosCostoOptions);
    $('#productosTable tbody tr:first-child #tipo_afectacion').html(tipoAfectacionOptions);
    $('#productosTable tbody tr:first-child #producto').html(productosinModeloOptions);

    // // Agregar eventos
    // $('#productosTable tbody tr:first-child #tipo_afectacion').on('change', function() {
    //     CalculodePorcentaje(this);
    // });

    // $('#productosTable tbody tr:first-child #producto').on('change', function() {
    //     actualizarUnidadMedida(this);
    // });

    $('#productosTable').on('change', 'tbody tr #producto', function() {
    actualizarUnidadMedida(this);
    });

}


// Guardar fila (bloquear inputs y botones)
function guardarFila(button) {
    const fila = $(button).closest('tr');
    fila.find('input, select').attr('readonly', true).attr('disabled', true);
    $(button).replaceWith(`
        <button type="button" class="btn btn-sm btn-primary editRow mx-1" onclick="editarFila(this)">
            <i class="fas fa-edit fs-5"></i>
        </button>
    `);
}

// Editar fila (habilitar inputs y botones)
function editarFila(button) {
    const fila = $(button).closest('tr');
    
    // Seleccionar todos los inputs y selects excepto los que tienen los IDs unidadMedida y total
    fila.find('input, select').not('#unidadMedida, #total').removeAttr('readonly').removeAttr('disabled');
    
    // Cambiar el botón a "guardar"
    $(button).replaceWith(`
        <button type="button" class="btn btn-sm btn-success saveRow mx-1" onclick="guardarFila(this)">
            <i class="fas fa-save fs-5"></i>
        </button>
    `);
}


// Eliminar fila
function eliminarFila(button) {
    const numeroFilas = $('#productosTable tbody tr').length;
    const esPrimeraFila = $(button).closest('tr').index() === 0;

    // Mostrar alerta si es la única fila o si es la primera fila
    if (numeroFilas === 1 || esPrimeraFila) {
        Swal.fire({
            icon: 'warning',
            title: 'No se puede eliminar',
            text: 'Debe existir al menos una fila en la tabla o la primera fila no se puede eliminar.',
        });
        return;
    }

    // Eliminar la fila y actualizar la numeración
    $(button).closest('tr').remove();
    actualizarNumeracion();
    actualizarTotalEfectivo();
}

function GuardarDatos() {
    let datosFormulario = {
        codigo_documento_ingreso: $('#codigo_documento_ingreso').val(),
        fecha_emision: $('#fecha_emision').val(),
        fecha_contable: $('#fecha_contable').val(),
        periodo: $('#periodo').val(),
        tipo_operacion: $('#tipo_operacion').val(),
        proveedor: $('#proveedor').val(),
        almacen: $('#almacen_id').val(),
        comprobante_pago: $('#comprobante_pago').val(),
        tipo_cambio: $('#tipo_cambio_id').val(),
        numerodocumento: $('#numerodocumento').val(),
        numerosecundariodocumento: $('#numerosecundariodocumento').val(),
        glosario: $('#glosario').val(),
        total_efectivo: $('#total_efectivo').val(),
        Usuario_creado: {{ auth()->check() ? auth()->user()->id_usuario : 'null' }},
        nomb_moneda: $('#tipo_cambio').val(),
        registro_cambio_al_dia: $('#cantidad_cambio').val(),
        productos: []
    };

    // Agregar los productos
    let error = false; // Para detener el proceso si hay errores
    $('#productosTable tbody tr').each(function () {
        const producto = {
            producto: $(this).find('select[name="producto[]"]').val(),
            unidadMedidaId: $(this).find('input[name="unidadMedida_id[]"]').val(),
            cantidad: $(this).find('input[name="cantidad[]"]').val(),
            centro_costo: $(this).find('select[name="centro_costo[]"]').val(),
            tipo_afectacion: $(this).find('select[name="tipo_afectacion[]"]').val(),
            precio_unitario: $(this).find('input[name="precio_unitario[]"]').val(),
            total: $(this).find('input[name="total[]"]').val()
        };

        // Validar campos del producto
        if (!producto.producto || !producto.unidadMedidaId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe seleccionar un producto y su unidad de medida para cada fila.',
            });
            error = true;
            return false; // Salir del bucle
        }

        datosFormulario.productos.push(producto);
    });

    if (error) return; // Detener si hay errores

    // Verificar si hay productos
    if (datosFormulario.productos.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Debe agregar al menos un producto.',
        });
        return;
    }
    enviarDatos(datosFormulario);
    // // Mostrar los datos en formato JSON
    // console.log(JSON.stringify(datosFormulario, null, 2)); // Mostrar en consola

    // // Mostrar datos en un modal con SweetAlert
    // Swal.fire({
    //     title: 'Datos del Formulario',
    //     html: `<pre>${JSON.stringify(datosFormulario, null, 2)}</pre>`, // Mostrar JSON legible
    //     width: 800, // Ancho del modal
    //     customClass: {
    //         popup: 'text-left' // Alineación del texto
    //     },
    //     confirmButtonText: 'Enviar'
    // }).then(() => {
    //     // Solo enviar datos si el usuario confirma
    //     
    // });
}

function enviarDatos(datosFormulario) {
    $.ajax({
        url: "{{ route('documento-ingreso.store') }}",
        type: "POST",
        data: JSON.stringify(datosFormulario),
        contentType: "application/json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: response.message,
            }).then(() => {
                regresarDocIngreso();
            });
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON.message,
            });
        }
    });
}


function regresarDocIngreso()
{
    limpiarCampos();
    cargarPlantilla('Documentos/DocumentoIngreso/DocumentoIngreso','content-wrapper'); // Recarg
}
function limpiarCampos() {
    // Restablecer todos los campos de texto
    $('#frm-documento-ingreso input[type="text"]').val('');
    $('#frm-documento-ingreso input[type="number"]').val('');
    $('#frm-documento-ingreso input[type="date"]').val('');
    $('#frm-documento-ingreso input[type="hidden"]').val('');

    // Restablecer selects
    $('#frm-documento-ingreso select').prop('selectedIndex', 0);

    // Limpiar filas de la tabla de productos, dejando solo una fila vacía
    const tablaProductos = $('#productosTable tbody');
    tablaProductos.empty();
    tablaProductos.append(`
        <tr>
            <td>1</td>
            <td>
                <select id="producto" name="producto[]" class="form-select form-select-sm">
                    <option value="">-- Seleccione --</option>
                </select>
            </td>
            <td>
                <input type="text" id="unidadMedida" name="unidadMedida_nombre[]" class="form-control form-control-sm" readonly>
                <input type="hidden" id="unidadMedida_id" name="unidadMedida_id[]">
            </td>
            <td>
                <input type="number" id="cantidad" name="cantidad[]" class="form-control form-control-sm" min="1" required>
            </td>
            <td>
                <select id="centro_costo" name="centro_costo[]" class="form-select form-select-sm">
                    <option value="">-- Seleccione --</option>
                </select>
            </td>
            <td>
                <select id="tipo_afectacion" name="tipo_afectacion[]" class="form-select form-select-sm">
                    <option value="">-- Seleccione --</option>
                </select>
            </td>
            <td>
                <input type="number" id="precio_unitario" name="precio_unitario[]" class="form-control form-control-sm"  required>
            </td>
            <td>
                <input type="text" id="total" name="total[]" class="form-control form-control-sm" readonly>
            </td>
            <td class="text-center">
                <div class="btn-group d-flex justify-content-center" role="group">
                    <button type="button" class="btn btn-sm btn-primary addRow mx-1" onclick="agregarNuevaFila()">
                        <i class="fas fa-plus fs-5"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-success saveRow mx-1" onclick="guardarFila(this)">
                        <i class="fas fa-save fs-5"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger deleteRow mx-1" onclick="eliminarFila(this)">
                        <i class="fas fa-trash fs-5"></i>
                    </button>
                </div>
            </td>
        </tr>
    `);
}





</script>

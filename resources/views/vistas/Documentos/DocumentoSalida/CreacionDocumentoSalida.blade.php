<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Creacion de Documento Salida</h2>
            </div><!-- /.col -->
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                    <li class="breadcrumb-item active">Creacion Doc. Salida</li>
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
                                <input type="hidden" id="id_usuario" name="id_usuario" value="{{ auth()->user()->id_usuario }}">
                                
                                <div class="col-12 col-lg-3 mb-2">
                                    <label>Código de Documento de Ingreso</label>
                                    <input type="text" id="codigo_documento_salida" name="codigo_documento_salida" class="form-control form-control-sm" required readonly>
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
                                    <select id="tipo_operacion" name="tipo_operacion" class="form-select" required>
                                        <option value="">-- Seleccione --</option>
                                    </select>                                    
                                </div>
                                
                                <div class="col-12 col-lg-2 mb-2">
                                    <label>Almacén</label>
                                    <!-- Campo readonly para mostrar el nombre del almacén -->
                                    <input type="text" class="form-control form-control-sm"  id="almacen_nombre" name="almacen_nombre" readonly>
                                    <!-- Campo oculto para almacenar el ID del almacén -->
                                    <input type="hidden" id="almacen_id" name="almacen_id">
                                </div>

                                <div class="col-12 col-lg-2 mb-2">
                                    <label>Almacen Destino</label>
                                    <select class="form-select" id="almacen_id_destino" name="almacen_id_destino" required>
                                        <option value="">-- Seleccione --</option>
                                    </select>
                                    <input type="hidden" id="almacen_id_destino" name="almacen_id_destino">
                                </div>
                                
                                <div class="col-12 col-lg-4 mb-2">
                                    <label>Usuario recibir</label>
                                    <select class="form-select" id="UsuarioRecivir" name="UsuarioRecivir" required>
                                        <option value="">-- Seleccione --</option>
                                    </select>
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
                                            <th>Cantidad Act. Producto</th>
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
                                                <input type="number" id="cantidadActProd" name="cantidadActProd[]" class="form-control form-control-sm" min="1" required readonly>
                                            </td>
                                            <td>
                                                <select id="centro_costo" name="centro_costo[]" class="form-select form-select-sm">
                                                    <option value="">-- Seleccione --</option>
                                                </select>
                                            </td>
                                            <td>

                                                <input type="text" class="form-control form-control-sm"  id="tipo_afectacion" name="tipo_afectacion[]" readonly>

                                                <input type="hidden" id="tipo_afectacion_id" name="tipo_afectacion_id">
                                            </td>
                                            <td>
                                                <input type="number" id="precio_unitario" name="precio_unitario[]" class="form-control form-control-sm"  readonly required>
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
                        <button type="reset" class="btn btn-danger" onclick="regresarDocSalida()"><i class="fas fa-undo-alt"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    var contadorFilas = 1; // Contador global para las filas
    var centrosCostoOptions = ''; // Opciones pre-cargadas para centros de costo
    var productoOptions = ''; // Opciones pre-cargadas para productos

    $(document).ready(function() {
        preCargarOpciones(); // Cargar opciones iniciales
        obtenerCodigorSalida(); // Generar el código inicial del documento
        inicializarEventosDinamicos();
        obtenerTipoOperaciones();
        // Eventos
        $('#fecha_emision, #fecha_contable').on('change', function () {
            generarCodigoPeriodo(this.value); // Generar el periodo basado en la fecha
        });

        $('#numerodocumento, #numerosecundariodocumento').on('change keyup', function () {
            actualizarGlosario(); // Generar el glosario automáticamente
        });

        $('#productosTable').on('change', '#producto', function () {
            actualizarProductoRelacionado(this); // Actualizar los valores relacionados al producto seleccionado
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

        // Actualizar cantidad dinámica
        $('#productosTable').on('input', '#cantidad', function () {
            const fila = $(this).closest('tr');
            const cantidadInput = $(this); // Campo de cantidad actual
            const cantidadActProdInput = fila.find('#cantidadActProd'); // Campo de cantidad actual producto

            const cantidad = parseFloat(cantidadInput.val()) || 0; // Obtener valor del campo cantidad
            const cantidadActProd = parseFloat(cantidadActProdInput.val()) || 0; // Obtener valor inicial del producto

            // Validar si la cantidad es mayor que la cantidad actual del producto
            if (cantidad > cantidadActProd) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cantidad inválida',
                    text: 'No se pueden ingresar cantidades superiores a las existentes.',
                }).then(() => {
                    // Reiniciar valores
                    cantidadInput.val(0); // Reiniciar campo cantidad a 0
                });
            } else if (cantidad === 0) {
                // Si cantidad es 0, restablecer al valor inicial
                cantidadInput.val('');
            }
        });

        verificarMinimoFilas(); // Verificar que haya al menos una fila
        obtenerAlmacenUsuario(); // Cargar datos del almacén asignado al usuario
        cargarAlmacenesDestino(); // Cargar opciones de almacenes destino
        cargarUsuariosRecibir(); // Cargar opciones de usuarios para recibir


});

function obtenerTipoOperaciones() {
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

//Generar Glosario
function actualizarGlosario() {
    const numeroDocumento = $('#numerodocumento').val(); // Valor del número de documento
    const numeroSecundarioDocumento = $('#numerosecundariodocumento').val(); // Valor del número secundario de documento

    // Verificar que los campos no estén vacíos antes de generar el glosario
    if ( numeroDocumento && numeroSecundarioDocumento) {
        const glosario = `${numeroDocumento}-${numeroSecundarioDocumento}`;
        $('#glosario').val(glosario); // Actualizar el campo glosario
    } else {
        $('#glosario').val(''); // Limpiar si falta algún dato
    }
}

// Agregar el codigo 
function obtenerCodigorSalida(){
    $.ajax({
        url: "{{ route('documento-salida.generar-codigo') }}",
        type: 'GET',
        success: function(response) {
            $('#codigo_documento_salida').val(response.nuevo_codigo); // Rellenar el campo cod_proveedor
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

function obtenerAlmacenUsuario() {
    $.ajax({
        url: "{{ route('documento-salida.obtener-almacen-usuario') }}", // Ruta al controlador
        type: 'GET',
        success: function (response) {
            if (response.success) {
                $('#almacen_id').val(response.almacen_id); // Asignar ID del almacén
                $('#almacen_nombre').val(response.almacen_nombre); // Asignar nombre del almacén
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: response.message,
                });
                $('#almacen_id').val('');
                $('#almacen_nombre').val('');
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo cargar el almacén del usuario. Intente nuevamente.',
            });
        }
    });
}


function cargarAlmacenesDestino() {
    $.ajax({
        url: "{{ route('documento-salida.obtener-almacenes-destino') }}", // Ruta al controlador
        type: 'GET',
        success: function (response) {
            if (response.success) {
                const almacenDestinoSelect = $('#almacen_id_destino');
                almacenDestinoSelect.empty().append('<option value="">-- Seleccione --</option>');

                response.almacenes.forEach(almacen => {
                    almacenDestinoSelect.append(
                        `<option value="${almacen.id}">${almacen.nomb_almacen}</option>`
                    );
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: response.message,
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar los almacenes destino. Intente nuevamente.',
            });
        }
    });
}

function cargarUsuariosRecibir() {
    $.ajax({
        url: "{{ route('documento-salida.obtener-usuarios') }}", // Ruta al controlador
        type: 'GET',
        success: function (response) {
            if (response.success) {
                const usuarioRecibirSelect = $('#UsuarioRecivir');
                usuarioRecibirSelect.empty().append('<option value="">-- Seleccione --</option>');

                response.usuarios.forEach(usuario => {
                    usuarioRecibirSelect.append(
                        `<option value="${usuario.id_usuario}">
                            ${usuario.nomb_usuarios} ${usuario.apellidos_usuarios} (${usuario.usuario})
                         </option>`
                    );
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: response.message || 'No se pudieron cargar los usuarios.',
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al cargar los usuarios. Intente nuevamente.',
            });
        }
    });
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

// Cargar opciones para el producto
function cargarProductoUsuarioActual() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "{{ route('documento.cargar_producto_usuario_actual') }}",
            type: 'GET',
            success: function (response) {
                if (response.success) {
                    resolve(response.productos); // Resuelve la promesa con los productos
                } else {
                    reject();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Advertencia',
                        text: response.message || 'No se pudieron cargar los productos.',
                    });
                }
            },
            error: function () {
                reject();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al cargar los productos. Intente nuevamente.',
                });
            }
        });
    });
}
// Cargar las opciones iniciales
function preCargarOpciones() {
    Promise.all([cargarCentrosCosto(), cargarProductoUsuarioActual()])
        .then(([centrosCostoResponse, productoResponse]) => {
            // Guardar las opciones globalmente
            window.productoResponse = productoResponse;

            // Opciones de centros de costo
            centrosCostoOptions = `<option value="">-- Seleccione Centro de Costo --</option>` +
                centrosCostoResponse.centros_costo
                    .map(cc => `<option value="${cc.id}">${cc.nomb_centroCos}</option>`)
                    .join('');

            // Opciones de productos
            productoOptions = `<option value="">-- Seleccione Producto --</option>` +
                productoResponse
                    .map(p => `<option value="${p.id}">${p.descripcion}</option>`)
                    .join('');

            cargarPrimeraFila(); // Cargar opciones en la primera fila
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar las opciones. Intente nuevamente.',
            });
        });
}

// Actualizar los datos relacionados al producto seleccionado
function actualizarProductoRelacionado(selectElement) {
    const productoId = selectElement.value;

    // Buscar el producto en la respuesta cargada previamente
    const producto = window.productoResponse.find(p => p.id == productoId);

    if (producto) {
        const fila = $(selectElement).closest('tr');

        // Obtener inputs relacionados en la fila
        const unidadMedidaInput = fila.find('#unidadMedida');
        const unidadMedidaIdInput = fila.find('#unidadMedida_id');
        const tipoAfectacionInput = fila.find('#tipo_afectacion');
        const tipoAfectacionIdInput = fila.find('#tipo_afectacion_id');
        const precioInput = fila.find('#precio_unitario');
        const cantidadActProdInput = fila.find('#cantidadActProd');
        const cantidadInput = fila.find('#cantidad');

        // Asignar valores obtenidos del producto
        unidadMedidaInput.val(producto.unidad_medida?.nomb_uniMed || 'Sin U/M');
        unidadMedidaIdInput.val(producto.unidad_medida?.id || '');
        tipoAfectacionInput.val(producto.tipo_afectacion_igv?.porcentaje);
        tipoAfectacionIdInput.val(producto.tipo_afectacion_igv?.id || '');
        precioInput.val(producto.costo_unitario || 0);
        cantidadActProdInput.val(producto.stock || 0);
        cantidadInput.val('');
    }
}

function cargarPrimeraFila() {
    const primeraFila = $('#productosTable tbody tr:first-child');
    
    // Rellenar centros de costo
    primeraFila.find('#centro_costo').html(centrosCostoOptions);

    // Rellenar productos
    primeraFila.find('#producto').html(productoOptions);

    // Vincular el evento change para actualizar los datos relacionados al producto
    primeraFila.find('#producto').on('change', function () {
        actualizarProductoRelacionado(this);
    });
}


function agregarNuevaFila() {
    contadorFilas++;

    const nuevaFila = $(`
        <tr>
            <td>${contadorFilas}</td>
            <td>
                <select id="producto" name="producto[]" class="form-select form-select-sm">
                    ${productoOptions}
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
                <input type="number" id="cantidadActProd" name="cantidadActProd[]" class="form-control form-control-sm" min="1" required readonly>
            </td>
            <td>
                <select id="centro_costo" name="centro_costo[]" class="form-select form-select-sm">
                    ${centrosCostoOptions}
                </select>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" id="tipo_afectacion" name="tipo_afectacion[]" readonly>
                <input type="hidden" id="tipo_afectacion_id" name="tipo_afectacion_id">
            </td>
            <td>
                <input type="number" id="precio_unitario" name="precio_unitario[]" class="form-control form-control-sm" step="0.01" required readonly >
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

    // Agregar la nueva fila a la tabla
    $('#productosTable tbody').append(nuevaFila);

    // Inicializar eventos y recalcular totales
    inicializarEventosDinamicos(); // Reasignar eventos dinámicos a la nueva fila
    actualizarTotalEfectivo(); // Actualizar el total efectivo
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

    // Habilitar todos los inputs y selects dentro de la fila, excepto los que deben permanecer como solo lectura
    fila.find('input, select').not('#unidadMedida, #total, #tipo_afectacion,#precio_unitario,#cantidadActProd').each(function () {
        $(this).removeAttr('readonly').removeAttr('disabled');
        
        // Si es un select, habilitarlo
        if ($(this).is('select')) {
            $(this).removeAttr('disabled');
        }
    });

    // Cambiar el botón de editar a guardar
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
// Actualizar la numeración después de eliminar filas
function actualizarNumeracion() {
    $('#productosTable tbody tr').each(function(index) {
        $(this).find('td:first').text(index + 1);
    });
    contadorFilas = $('#productosTable tbody tr').length;
}
function limpiarCampos() {
    // Limpiar los campos del formulario principal
    $('#frm-documento-ingreso')[0].reset(); // Restablecer el formulario completo

    // Limpiar campos específicos (si no quieres que se resetee todo)
    $('#codigo_documento_salida').val('');
    $('#fecha_emision').val('');
    $('#fecha_contable').val('');
    $('#periodo').val('');
    $('#tipo_operacion').val('');
    $('#almacen_nombre').val('');
    $('#almacen_id').val('');
    $('#almacen_id_destino').val('');
    $('#UsuarioRecivir').val('');
    $('#numerodocumento').val('');
    $('#numerosecundariodocumento').val('');
    $('#glosario').val('');
    $('#total_efectivo').val('');

    // Limpiar la tabla de productos excepto la primera fila
    const primeraFila = $('#productosTable tbody tr:first-child');
    $('#productosTable tbody').empty().append(primeraFila);

    // Restablecer los valores de la primera fila
    primeraFila.find('#producto').val('');
    primeraFila.find('#unidadMedida').val('');
    primeraFila.find('#unidadMedida_id').val('');
    primeraFila.find('#cantidad').val('');
    primeraFila.find('#cantidadActProd').val('');

    primeraFila.find('#centro_costo').val('');
    primeraFila.find('#tipo_afectacion').val('');
    primeraFila.find('#tipo_afectacion_id').val('');
    primeraFila.find('#precio_unitario').val('');
    primeraFila.find('#total').val('');

    // Resetear numeración y contador de filas
    actualizarNumeracion();
    contadorFilas = 1;
}

function regresarDocSalida(){
    limpiarCampos();
    cargarPlantilla('Documentos/DocumentoSalida/DocumentoSalida','content-wrapper'); // Recarg

}
function GuardarDatos() {
    let datosFormulario = {
        codigo_documento_salida: $('#codigo_documento_salida').val(),
        fecha_emision: $('#fecha_emision').val(),
        fecha_contable: $('#fecha_contable').val(),
        periodo: $('#periodo').val(),
        tipo_operacion: $('#tipo_operacion').val(),
        almacen_id: $('#almacen_id').val(),
        almacen_destino_id: $('#almacen_id_destino').val(),
        usuario_recibir: $('#UsuarioRecivir').val(),
        numerodocumento: $('#numerodocumento').val(),
        numerosecundariodocumento: $('#numerosecundariodocumento').val(),
        glosario: $('#glosario').val(),
        total_efectivo: $('#total_efectivo').val(),
        Usuario_actual: $('#id_usuario').val(),
        productos: [] // Lista de productos
    };

    // Iterar por las filas de productos para agregar los detalles al JSON
    $('#productosTable tbody tr').each(function () {
        const fila = $(this);
        const producto = {
            producto_id: fila.find('#producto').val(),
            unidad_medida_id: fila.find('#unidadMedida_id').val(),
            cantidad: fila.find('#cantidad').val(),
            centro_costo_id: fila.find('#centro_costo').val(),
            tipo_afectacion_id: fila.find('#tipo_afectacion_id').val(),
            precio_unitario: fila.find('#precio_unitario').val(),
            total: fila.find('#total').val()
        };

        // Verificar si el producto tiene datos válidos antes de agregarlo
        if (producto.producto_id && producto.cantidad && producto.precio_unitario) {
            datosFormulario.productos.push(producto);
        }
    });

    // Verificar si hay al menos un producto válido
    if (datosFormulario.productos.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Debe agregar al menos un producto con información válida.',
        });
        return;
    }
    enviarDatos(datosFormulario);



    
   
}
function enviarDatos(datosFormulario) {
        $.ajax({
            url: "{{ route('documento-salida.store') }}", // Ruta al controlador
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
                    regresarDocSalida();
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



</script>

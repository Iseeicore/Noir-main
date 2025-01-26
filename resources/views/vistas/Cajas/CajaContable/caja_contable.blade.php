<div class="col-12">
    <!-- Contenido de Caja Contable -->
    <div id="contenidoCajaContable" style="display: none;" >
        <h2 class="text-center mt-5">Banco Seleccionado: <span id="bancoSeleccionado"></span></h2>
        <!-- Aquí el contenido dinámico de Caja Contable -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-primary font-weight-bold">Gestión de Caja Contable</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right bg-transparent">
                            <li class="breadcrumb-item"><a href="#" class="text-primary">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión de Caja Contable</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Crear Saldo Inicial -->
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white text-center">
                                    <h5 class="card-title m-0 font-weight-bold">Crear Saldo Inicial</h5>
                                </div>
                                <div class="card-body">
                                    <form id="formCrearSaldo">
                                        <div class="form-group">
                                            <label for="responsable">Responsable</label>
                                            <select id="responsable" class="form-control">
                                                <option value="">-- Seleccione un responsable --</option>
                                                <!-- Opciones dinámicas -->
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="montoInicial">Monto Inicial</label>
                                            <input type="number" id="montoInicial" class="form-control" placeholder="Ingrese el monto inicial">
                                        </div>
                                        <div class="form-group">
                                            <label for="descripcion">Descripción</label>
                                            <input type="text" id="descripcion" class="form-control" placeholder="Propósito o detalles">
                                        </div>
                                        <!-- Campo de Fecha -->
                                        <div class="form-group">
                                            <label for="fecha">Fecha</label>
                                            <input type="date" id="fecha" class="form-control" required>
                                        </div>
                                        <button type="button" id="btnGuardarSaldo" class="btn btn-primary btn-block font-weight-bold">
                                            Guardar Saldo
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>


                    <!-- Resumen de Caja Contable -->
                    <div class="col-lg-8">
                        <div class="row">
                            <!-- Tarjetas de Resumen -->
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light shadow-sm text-center">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold">Saldo Inicial</h6>
                                        <p id="saldoInicial" class="text-dark font-weight-bold">S/ 0.00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-success shadow-sm text-white text-center">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold">Saldo Actual</h6>
                                        <p id="saldoActual" class="font-weight-bold">S/ 0.00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-primary shadow-sm text-white text-center">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold">Total Ingresos</h6>
                                        <p id="totalIngresos" class="font-weight-bold">S/ 0.00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-danger shadow-sm text-white text-center">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold">Total Gastado</h6>
                                        <p id="totalGastado" class="font-weight-bold">S/ 0.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de Movimientos -->
                        <div class="table-responsive shadow-sm mt-4">
                            <table class="table table-bordered table-hover text-center" id="tbl_movimientos">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Tipo de Medio de Pago</th>
                                        <th>Nº Referencia</th>
                                        <th>Descripción</th>
                                        <th>Concepto</th>
                                        <th>Ingreso</th>
                                        <th>Egreso</th>
                                        <th>Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Datos dinámicos -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Registrar Movimiento -->
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-danger text-white text-center">
                                <h5 class="card-title m-0 font-weight-bold">Registrar Movimiento</h5>
                            </div>
                            <div class="card-body">
                                <form id="formRegistrarMovimiento">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tipoMovimiento">Tipo de Movimiento</label>
                                                <select id="tipoMovimiento" class="form-control">
                                                    <option value="ingreso">Ingreso</option>
                                                    <option value="egreso">Egreso</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="montoMovimiento">Monto</label>
                                                <input type="number" id="montoMovimiento" class="form-control" placeholder="Ingrese el monto">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="referencia">Referencia Nº</label>
                                                <input type="text" id="referencia" class="form-control" placeholder="Ej: Factura, Boleta">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="categoria_id">Tipo de Medio de Pago</label>
                                                <select id="categoria_id" class="form-control">
                                                    <option value="">-- Seleccione una categoría --</option>
                                                    @isset($categorias)
                                                        @foreach ($categorias as $categoria)
                                                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="">No hay categorías disponibles</option>
                                                    @endisset
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="concepto">Concepto</label>
                                                <input type="text" id="concepto" class="form-control" placeholder="Ingrese el concepto">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="descripcionMovimiento">Descripción</label>
                                                <input type="text" id="descripcionMovimiento" name="descripcion" class="form-control" placeholder="Descripción del movimiento">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fechaMovimiento">Fecha del Movimiento</label>
                                                <input type="date" id="fechaMovimiento" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="btnRegistrarMovimiento" class="btn btn-danger btn-block font-weight-bold mt-3">
                                        Registrar Movimiento
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (function () {
    let idCajaContable = null; // Variable privada dentro del módulo
    const nombreEmpresa = localStorage.getItem('nombreEmpresaSeleccionada') || 'SIN REGISTRAR';

    $(document).ready(function () {
        cargarDatosCajaContable();
        inicializarTablaMovimientosContable();
        mostrarAlertaSeleccionBanco();
        cargarResponsablesContable();
        cargarCategorias();
    });


    function mostrarAlertaSeleccionBanco() {
        $.ajax({
            url: '{{ route("caja_contable.listar_bancos") }}',
            method: 'GET',
            success: function (data) {
                if (data.length > 0) {
                    let selectOptions = data.map(banco => `<option value="${banco.id}">${banco.nombre_banco} - ${banco.tipo_moneda}</option>`).join('');

                    Swal.fire({
                        title: 'Seleccionar Banco',
                        html: `
                            <p>Por favor, seleccione un banco para continuar.</p>
                            <select id="selectBanco" class="swal2-select">
                                <option value="">-- Seleccione un banco --</option>
                                ${selectOptions}
                            </select>
                        `,
                        confirmButtonText: 'Continuar',
                        preConfirm: () => {
                            const bancoId = Swal.getPopup().querySelector('#selectBanco').value;
                            if (!bancoId) {
                                Swal.showValidationMessage('Debe seleccionar un banco.');
                                return false;
                            }
                            return bancoId;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            validarBanco(result.value);
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No hay bancos disponibles.',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al cargar los bancos.',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    function validarBanco(bancoId) {
    $.ajax({
        url: '{{ route("caja_contable.validar_banco") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            banco_id: bancoId
        },
        success: function (data) {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Banco seleccionado',
                    text: `${data.banco.nombre_banco} - ${data.banco.tipo_moneda} ha sido seleccionado.`,
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Mostrar el contenido de Caja Contable
                    $('#contenidoCajaContable').show();
                    $('#bancoSeleccionado').text(`${data.banco.nombre_banco} - ${data.banco.tipo_moneda}`);
                    localStorage.setItem('bancoSeleccionado', bancoId); // Guardar el banco seleccionado
                    cargarDatosCajaContable(bancoId); // Cargar datos de la caja contable para el banco
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al validar el banco.',
                confirmButtonText: 'OK'
            });
        }
    });
}

$('#btnGuardarSaldo').on('click', function () {
    let responsable = $('#responsable').val();
    let montoInicial = parseFloat($('#montoInicial').val());
    let descripcion = $('#descripcion').val();
    let fecha = $('#fecha').val(); // Obtener la fecha seleccionada
    let bancoId = localStorage.getItem('bancoSeleccionado');

    // Validar que se haya seleccionado un banco
    if (!bancoId) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Debe seleccionar un banco antes de crear el saldo.',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Validar los campos requeridos
    if (!responsable || isNaN(montoInicial) || montoInicial <= 0 || !fecha) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Por favor, completa todos los campos correctamente.',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Confirmación antes de crear el saldo inicial
    Swal.fire({
        icon: 'question',
        title: 'Confirmar Creación de Saldo',
        text: `¿Desea crear un saldo inicial de S/${montoInicial.toFixed(2)} en la fecha ${fecha}?`,
        showCancelButton: true,
        confirmButtonText: 'Crear',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar solicitud AJAX
            $.ajax({
                url: '{{ route("caja_contable.crear_saldo") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    responsable_id: responsable,
                    monto_inicial: montoInicial,
                    descripcion: descripcion,
                    fecha: fecha,  // Enviar la fecha
                    banco_id: bancoId
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saldo Creado',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Actualizar los datos de la caja contable (recargar los datos)
                        cargarDatosCajaContable(bancoId);

                        // Limpiar los campos del formulario
                        $('#formCrearSaldo')[0].reset();
                    });
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al crear saldo inicial',
                        text: xhr.responseJSON?.message || 'Error inesperado.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });
});

// Función para cargar los datos de la caja contable
function cargarDatosCajaContable(bancoId) {
    if (!bancoId) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Debe seleccionar un banco antes de cargar los datos.',
            confirmButtonText: 'OK'
        });
        return;
    }

    $.ajax({
        url: '{{ route("caja_contable.listar") }}',
        method: 'GET',
        data: { banco_id: bancoId }, // Enviar el banco seleccionado
        success: function (data) {
            idCajaContable = data.id_caja; // Asignar ID de la caja activa

            // Bloquear formularios si no hay caja activa
            if (!data.caja_activa) {
                $('#formRegistrarMovimiento :input').prop('disabled', true);
                Swal.fire({
                    icon: 'info',
                    title: 'Sin Caja Activa',
                    text: 'No hay una caja activa. Por favor, crea una nueva caja contable.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Habilitar formularios
            $('#formRegistrarMovimiento :input').prop('disabled', false);

            // Convertir valores a números asegurándose de que sean válidos
            const saldoInicial = parseFloat(data.saldo_inicial) || 0;
            const saldoActual = parseFloat(data.saldo_actual) || 0;
            const totalIngresos = parseFloat(data.total_ingresos) || 0;
            const totalEgresos = parseFloat(data.total_egresos) || 0;

            // Actualizar tarjetas
            $('#saldoInicial').text(`$${saldoInicial.toFixed(2)}`);
            $('#saldoActual').text(`$${saldoActual.toFixed(2)}`);
            $('#totalIngresos').text(`$${totalIngresos.toFixed(2)}`);
            $('#totalGastado').text(`$${totalEgresos.toFixed(2)}`);

            // Actualizar tabla de movimientos
            actualizarTablaMovimientosContable(data.movimientos);

            // Mostrar mensaje de éxito si se cargaron correctamente los datos
            Swal.fire({
                icon: 'success',
                title: 'Datos Cargados',
                text: 'Los datos de la caja contable se han cargado correctamente.',
                confirmButtonText: 'OK'
            });
        },
        error: function (xhr) {
            // Mostrar mensaje de error con detalles si están disponibles
            Swal.fire({
                icon: 'error',
                title: 'Error al cargar datos',
                text: xhr.responseJSON?.message || 'Ocurrió un error inesperado al cargar los datos de la caja contable.',
                confirmButtonText: 'OK'
            });
            console.error(xhr.responseText);
        }
    });
}


// Botón para registrar movimiento
$('#btnRegistrarMovimiento').on('click', function () {
    registrarMovimiento();
});

function registrarMovimiento() {
    let tipoMovimiento = $('#tipoMovimiento').val();
    let monto = parseFloat($('#montoMovimiento').val());
    let descripcion = $('#descripcionMovimiento').val();
    let referencia = $('#referencia').val();
    let fechaMovimiento = $('#fechaMovimiento').val();
    let categoria = $('#categoria_id').val();
    let concepto = $('#concepto').val();

    // Validar si la caja contable está seleccionada
    if (!idCajaContable) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Debe seleccionar un banco y asegurarse de que haya una caja activa.',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Validar los campos requeridos
    if (!tipoMovimiento || isNaN(monto) || monto <= 0 || !fechaMovimiento || !categoria) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Por favor, completa todos los campos correctamente.',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Confirmación antes de registrar el movimiento
    Swal.fire({
        icon: 'question',
        title: 'Confirmar Registro',
        text: `¿Desea registrar este movimiento de ${tipoMovimiento}?`,
        showCancelButton: true,
        confirmButtonText: 'Registrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar solicitud AJAX
            $.ajax({
                url: '{{ route("caja_contable.registrar_movimiento") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id_caja_contable: idCajaContable,
                    tipo_movimiento: tipoMovimiento,
                    monto: monto,
                    descripcion: descripcion,
                    referencia: referencia,
                    fecha: fechaMovimiento,
                    categoria_id: categoria,
                    concepto: concepto,
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Movimiento Registrado',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });

                    // Recargar los datos de la tabla de movimientos
                    obtenerMovimientos();

                    // Limpiar el formulario
                    $('#formRegistrarMovimiento')[0].reset();
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Error inesperado al registrar el movimiento.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });
}

function obtenerMovimientos() {
    if (!idCajaContable) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Debe seleccionar una caja contable activa para ver los movimientos.',
            confirmButtonText: 'OK'
        });
        return;
    }

    $.ajax({
        url: '{{ route("caja_contable.listar_movimientos") }}',
        method: 'GET',
        data: { id_caja_contable: idCajaContable }, // Enviar el ID de la caja contable
        success: function (data) {
            if (data.movimientos && data.movimientos.length > 0) {
                actualizarTablaMovimientosContable(data.movimientos);
                Swal.fire({
                    icon: 'success',
                    title: 'Movimientos Cargados',
                    text: 'Los movimientos de la caja contable se han actualizado.',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Sin Movimientos',
                    text: 'No se encontraron movimientos registrados.',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON?.message || 'Error inesperado al obtener los movimientos.',
                confirmButtonText: 'OK'
            });
        }
    });
}

function actualizarTablaMovimientosContable(movimientos) {
    let saldoInicial = parseFloat($('#saldoInicial').text().replace('$', '').replace(',', '')) || 0;
    let saldoAcumulado = saldoInicial;

    let movimientosRenderizados = movimientos.map((movimiento) => {
        let ingreso = movimiento.tipo_movimiento === 'ingreso' ? parseFloat(movimiento.monto) : 0;
        let egreso = movimiento.tipo_movimiento === 'egreso' ? parseFloat(movimiento.monto) : 0;
        saldoAcumulado += ingreso - egreso;

        return {
            fecha: movimiento.fecha ? new Date(movimiento.fecha).toLocaleDateString() : 'N/A',
            tipo_medio_pago: movimiento.categoria ? movimiento.categoria.nombre : 'N/A',
            referencia: movimiento.referencia || 'N/A',
            descripcion: movimiento.descripcion || 'N/A',
            concepto: movimiento.concepto || 'N/A',
            ingreso: ingreso > 0 ? `S/${ingreso.toFixed(2)}` : '',
            egreso: egreso > 0 ? `S/${egreso.toFixed(2)}` : '',
            saldo: `S/${saldoAcumulado.toFixed(2)}`
        };
    });

    let tabla = $('#tbl_movimientos').DataTable();
    tabla.clear();
    tabla.rows.add(movimientosRenderizados).draw();

    // Calcular totales
    let totalIngresos = movimientos.reduce((total, m) => total + (m.tipo_movimiento === 'ingreso' ? parseFloat(m.monto) : 0), 0);
    let totalEgresos = movimientos.reduce((total, m) => total + (m.tipo_movimiento === 'egreso' ? parseFloat(m.monto) : 0), 0);

    // Actualizar tarjetas
    $('#totalIngresos').text(`S/${totalIngresos.toFixed(2)}`);
    $('#totalGastado').text(`S/${totalEgresos.toFixed(2)}`);
    $('#saldoActual').text(`S/${saldoAcumulado.toFixed(2)}`);
}



function inicializarTablaMovimientosContable() {
    // Destruir la tabla si ya está inicializada
    if ($.fn.DataTable.isDataTable('#tbl_movimientos')) {
        $('#tbl_movimientos').DataTable().destroy();
    }

    // Inicializar la tabla
    $('#tbl_movimientos').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: () => `Movimientos de Caja Contable - ${nombreEmpresa || 'Empresa desconocida'} - ${new Date().toLocaleDateString()}`,
                text: '<i class="fas fa-file-excel"></i> Exportar a Excel',
                className: 'btn btn-success',
                exportOptions: {
                    columns: ':visible' // Exportar solo columnas visibles
                }
            },
            {
                extend: 'print',
                title: () => `
                    <h5>${nombreEmpresa || 'Empresa desconocida'}</h5>
                    <h6>Fecha de impresión: ${new Date().toLocaleDateString()}</h6>
                    <h3>Movimientos de Caja Contable</h3>`,
                text: '<i class="fas fa-print"></i> Imprimir',
                className: 'btn btn-primary',
                customize: function (win) {
                    $(win.document.body).find('table').addClass('display').css('font-size', '12px');
                    $(win.document.body).find('h3, h5, h6').css('text-align', 'center');
                },
                exportOptions: {
                    columns: ':visible' // Exportar solo columnas visibles
                }
            }
        ],
        responsive: true,
        language: {
            url: '{{ asset("assets/languages/Spanish.json") }}' // Ruta al archivo de idioma para español
        },
        order: [[0, 'desc']], // Ordenar por fecha (columna 0) en orden descendente
        columnDefs: [
            {
                targets: [5, 6, 7], // Alinear columnas de ingreso, egreso y saldo
                className: 'text-right'
            },
            {
                targets: '_all',
                defaultContent: 'N/A' // Mostrar "N/A" si no hay datos
            }
        ],
        data: [], // Los datos se cargarán dinámicamente
        columns: [
            { data: 'fecha', title: 'Fecha' },
            { data: 'tipo_medio_pago', title: 'Medio de Pago' },
            { data: 'referencia', title: 'Referencia' },
            { data: 'descripcion', title: 'Descripción' },
            { data: 'concepto', title: 'Concepto' },
            { data: 'ingreso', title: 'Ingreso' },
            { data: 'egreso', title: 'Egreso' },
            { data: 'saldo', title: 'Saldo' }
        ]
    });
}


        // Función para cargar responsables
        function cargarResponsablesContable() {
            $.ajax({
                url: '{{ route("caja_contable.listar_responsables") }}',
                method: 'GET',
                success: function (data) {
                    let select = $('#responsable');
                    select.empty().append('<option value="">-- Seleccione --</option>');
                    if (data.length > 0) {
                        data.forEach(responsable => {
                            select.append(`<option value="${responsable.id}">${responsable.nombre}</option>`);
                        });
                    } else {
                        alert('No hay usuarios disponibles.');
                    }
                },
                error: function () {
                    alert('Error al cargar los responsables.');
                }
            });

        }

        function cargarCategorias() {
        console.log('Cargando categorías...');
        $.ajax({
            url: '{{ route("caja_contable.listar_categorias") }}',
            method: 'GET',
            success: function (data) {
                let select = $('#categoria_id');
                select.empty().append('<option value="">-- Seleccione una categoría --</option>');
                if (data.length > 0) {
                    data.forEach(categoria => {
                        select.append(`<option value="${categoria.id}">${categoria.nombre}</option>`);
                    });
                } else {
                    alert('No hay categorías disponibles.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al cargar las categorías:', xhr.responseJSON || error);
                alert('Error al cargar las categorías.');
            }
        });

    }
    // Otras funciones encapsuladas
})();

</script>

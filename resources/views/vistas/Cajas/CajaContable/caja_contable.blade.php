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


<script>
$(document).ready(function () {
    // Identificador único para las tablas y formularios de Caja Contable
    let idCajaContable = null;
     // Obtener el nombre de la empresa desde localStorage
     const nombreEmpresa = localStorage.getItem('nombreEmpresaSeleccionada') || 'SIN REGISTRAR';

    // Inicialización
    inicializarTablaMovimientosContable();
    cargarDatosCajaContable();
    cargarCategorias();
    cargarResponsablesContable();


    // Crear Saldo Inicial
    $('#btnGuardarSaldo').on('click', function () {
    let responsable = $('#responsable').val();
    let montoInicial = $('#montoInicial').val();
    let descripcion = $('#descripcion').val();

    if (!responsable || montoInicial <= 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Por favor, completa los campos correctamente.',
            confirmButtonText: 'OK'
        });
        return;
    }

    $.ajax({
        url: '{{ route("caja_contable.crear_saldo") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            responsable_id: responsable,
            monto_inicial: montoInicial,
            descripcion: descripcion
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Saldo Creado',
                text: response.message,
                confirmButtonText: 'OK'
            });

            // Llamar a la función para obtener y actualizar los movimientos
            $.ajax({
                url: '{{ route("caja_contable.listar") }}',
                method: 'GET',
                success: function (data) {
                    actualizarTablaMovimientosContable(data.movimientos); // Actualizar tabla con movimientos
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al obtener los movimientos después de crear el saldo.',
                        confirmButtonText: 'OK'
                    });
                }
            });

            $('#formCrearSaldo')[0].reset(); // Limpiar formulario
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error al crear saldo inicial',
                text: xhr.responseJSON?.message || 'Error inesperado.',
                confirmButtonText: 'OK'
            });
        }
    });
});


$('#btnRegistrarMovimiento').on('click', function () {
    let tipoMovimiento = $('#tipoMovimiento').val();
    let monto = $('#montoMovimiento').val();
    let descripcion = $('#descripcionMovimiento').val();
    let referencia = $('#referencia').val();
    let fechaMovimiento = $('#fechaMovimiento').val();
    let categoria = $('#categoria_id').val();
    let concepto = $('#concepto').val();

    // Validar campos
    if (!tipoMovimiento || monto <= 0 || !fechaMovimiento || !categoria) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Por favor, completa todos los campos correctamente.',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Realizar solicitud AJAX para registrar movimiento
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
            // Mostrar mensaje de éxito
            Swal.fire({
                icon: 'success',
                title: 'Movimiento Registrado',
                text: response.message,
                confirmButtonText: 'OK'
            });

            // Llamar a la función para obtener y actualizar los movimientos
            $.ajax({
                url: '{{ route("caja_contable.listar") }}', // Asegúrate de tener esta ruta
                method: 'GET',
                success: function (data) {
                    actualizarTablaMovimientosContable(data.movimientos); // Actualizar tabla con movimientos
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al obtener los movimientos después de registrar el movimiento.',
                        confirmButtonText: 'OK'
                    });
                }
            });

            // Limpiar el formulario de registro de movimientos
            $('#formRegistrarMovimiento')[0].reset();
        },
        error: function (xhr) {
            // Manejar errores
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON.message || 'Error inesperado.',
                confirmButtonText: 'OK'
            });
        }
    });
});





    // Función para cargar datos de la caja contable
    function cargarDatosCajaContable() {
        $.ajax({
            url: '{{ route("caja_contable.listar") }}',
            method: 'GET',
            success: function (data) {
                idCajaContable = data.id_caja; // Asignar ID de la caja activa

                // Bloquear formularios si no hay caja activa
                if (!data.caja_activa) {
                    $('#formRegistrarMovimiento :input').prop('disabled', true);
                    alert('No hay una caja activa. Por favor, crea una nueva caja contable.');
                    return;
                }

                // Habilitar formularios
                $('#formRegistrarMovimiento :input').prop('disabled', false);

                // Actualizar tarjetas
                $('#saldoInicial').text(`$${data.saldo_inicial}`);
                $('#saldoActual').text(`$${data.saldo_actual}`);
                $('#totalIngresos').text(`$${data.total_ingresos}`);
                $('#totalGastado').text(`$${data.total_egresos}`);

                // Actualizar tabla de movimientos
                actualizarTablaMovimientosContable(data.movimientos);
            },
            error: function () {
                alert('Error al cargar datos de Caja Contable.');
            }
        });
    }

    function actualizarTablaMovimientosContable(movimientos) {
    let saldoInicial = parseFloat($('#saldoInicial').text().replace('$', '').replace(',', '')); // Tomar el saldo inicial
    let saldoAcumulado = saldoInicial; // Inicializar el saldo acumulado

    let movimientosRenderizados = movimientos.map((movimiento) => {
        let ingreso = movimiento.tipo_movimiento === 'ingreso' ? parseFloat(movimiento.monto) : 0;
        let egreso = movimiento.tipo_movimiento === 'egreso' ? parseFloat(movimiento.monto) : 0;

        saldoAcumulado = saldoAcumulado + ingreso - egreso;

        return {
            fecha: new Date(movimiento.fecha).toLocaleDateString(),
            tipo_medio_pago: movimiento.categoria ? movimiento.categoria.nombre : 'N/A', // Mostrar el nombre de la categoría
            referencia: movimiento.referencia || 'N/A',
            descripcion: movimiento.descripcion,
            concepto: movimiento.concepto || 'N/A',
            ingreso: ingreso > 0 ? `S/${ingreso.toFixed(2)}` : '',
            egreso: egreso > 0 ? `S/${egreso.toFixed(2)}` : '',
            saldo: `S/${saldoAcumulado.toFixed(2)}`
        };
    });

    let tabla = $('#tbl_movimientos').DataTable();
    tabla.clear();
    tabla.rows.add(movimientosRenderizados).draw();

    let totalIngresos = movimientos.reduce((total, m) => total + (m.tipo_movimiento === 'ingreso' ? parseFloat(m.monto) : 0), 0);
    let totalEgresos = movimientos.reduce((total, m) => total + (m.tipo_movimiento === 'egreso' ? parseFloat(m.monto) : 0), 0);

    $('#totalIngresos').text(`S/${totalIngresos.toFixed(2)}`);
    $('#totalGastado').text(`S/${totalEgresos.toFixed(2)}`);
    $('#saldoActual').text(`S/${saldoAcumulado.toFixed(2)}`);
}




function inicializarTablaMovimientosContable() {
    if ($.fn.DataTable.isDataTable('#tbl_movimientos')) {
        $('#tbl_movimientos').DataTable().destroy(); // Destruir instancia previa
    }

        // Inicializar DataTable
    $('#tbl_movimientos').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: function () {
                    return `Movimientos de Caja Contable - ${nombreEmpresa} - ${new Date().toLocaleDateString()}`;
                },
                text: '<i class="fas fa-file-excel"></i> Exportar a Excel',
                className: 'btn btn-success',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                title: function () {
                    return `
                        <h5>${nombreEmpresa}</h5>
                        <h6>Fecha de impresión: ${new Date().toLocaleDateString()}</h6>
                        <h3>Movimientos de Caja Contable</h3>`;
                },
                text: '<i class="fas fa-print"></i> Imprimir',
                className: 'btn btn-primary',
                customize: function (win) {
                    $(win.document.body).find('table').addClass('display').css('font-size', '12px');
                    $(win.document.body).find('h3, h5, h6').css('text-align', 'center');
                },
                exportOptions: {
                    columns: ':visible'
                }
            }
        ],
        responsive: true,
        data: [],
        columns: [
            //{ data: 'id' },
            { data: 'fecha' },
            { data: 'tipo_medio_pago' },
            { data: 'referencia' },
            { data: 'descripcion' },
            { data: 'concepto' },
            { data: 'ingreso' },
            { data: 'egreso' },
            { data: 'saldo' }
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

});
</script>


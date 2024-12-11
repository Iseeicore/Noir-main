<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Gestión de Caja Chica</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Gestión de Caja Chica</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Crear Saldo Inicial -->
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">Crear Saldo Inicial</h5>
                    </div>
                    <div class="card-body">
                        <form id="formCrearSaldo">
                            <div class="form-group">
                                <label for="mes">Mes</label>
                                <input type="month" id="mes" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="responsable">Responsable</label>
                                <select id="responsable" class="form-control">
                                    <!-- Opciones dinámicas -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="montoInicial">Monto Inicial</label>
                                <input type="number" id="montoInicial" class="form-control" placeholder="Monto inicial">
                            </div>
                            <button type="button" id="btnGuardarSaldo" class="btn btn-success">Guardar Saldo</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Resumen de Saldo -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Tarjetas de Resumen -->
                    <div class="col-lg-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5>Saldo Inicial</h5>
                                <p id="saldoInicial">S/0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card bg-warning">
                            <div class="card-body text-center">
                                <h5>Saldo Gastado</h5>
                                <p id="saldoGastado">S/0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card bg-success">
                            <div class="card-body text-center">
                                <h5>Saldo Final</h5>
                                <p id="saldoFinal">S/0.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Movimientos -->
                <div class="container-fluid">
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered shadow border-secondary display" id="tbl_movimientos">
                            <thead class="bg-main text-center">
                                <tr>
                                   <!-- <th>ID</th> -->
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Monto</th>
                                    <th>Tipo Movimiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Los datos se llenarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registrar Gasto -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-danger text-white">
                        <h5 class="card-title">Registrar Gasto</h5>
                    </div>
                    <div class="card-body">
                        <form id="formRegistrarGasto">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="gastoMonto">Monto</label>
                                    <input type="number" id="gastoMonto" class="form-control" placeholder="Monto del gasto">
                                </div>
                                <div class="col-lg-4">
                                    <label for="gastoDescripcion">Descripción</label>
                                    <input type="text" id="gastoDescripcion" class="form-control" placeholder="Descripción del gasto">
                                </div>
                                <div class="col-lg-4">
                                    <label for="gastoFecha">Fecha</label>
                                    <input type="date" id="gastoFecha" class="form-control">
                                </div>
                            </div>
                            <button type="button" id="btnRegistrarGasto" class="btn btn-danger mt-3">Registrar Gasto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        let cajaChicaId = null; // ID de la caja chica activa

        verificarCajaActiva(); // Inicializar estado de la caja activa
        inicializarTablaMovimientos(); // Inicializar tabla
        cargarResponsables(); // Cargar lista de responsables

        // Crear Saldo Inicial
        $('#btnGuardarSaldo').on('click', function () {
            let mes = $('#mes').val();
            let responsable = $('#responsable').val();
            let montoInicial = $('#montoInicial').val();

            if (!responsable || !mes || montoInicial <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor, completa los campos correctamente.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $.ajax({
                url: '{{ route("caja_chica.crear_saldo") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    mes: mes,
                    responsable_id: responsable,
                    monto_inicial: montoInicial
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                    verificarCajaActiva(); // Actualizar la caja activa
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

        // Registrar Gasto
        $('#btnRegistrarGasto').on('click', function () {
            if (!cajaChicaId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'No hay una caja activa para registrar gastos.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            let monto = $('#gastoMonto').val();
            let descripcion = $('#gastoDescripcion').val();
            let fecha = $('#gastoFecha').val();

            if (!monto || monto <= 0 || !descripcion || !fecha) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor, completa los campos correctamente.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $.ajax({
                url: '{{ route("caja_chica.registrar_gasto") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    caja_chica_id: cajaChicaId,
                    monto: monto,
                    descripcion: descripcion,
                    fecha: fecha
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                    verificarCajaActiva(); // Actualizar datos dinámicamente
                    $('#formRegistrarGasto')[0].reset();
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al registrar gasto',
                        text: xhr.responseJSON?.message || 'Error inesperado.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        function verificarCajaActiva() {
            $.ajax({
                url: '{{ route("caja_chica.listar") }}',
                method: 'GET',
                success: function (data) {
                    cajaChicaId = data.caja_id; // Asignar el ID de la caja activa

                    if (!data.caja_activa) {
                        limpiarTarjetas();
                        Swal.fire({
                            icon: 'info',
                            title: 'Sin caja activa',
                            text: 'No hay una caja activa. Por favor, crea un nuevo saldo.',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        actualizarTarjetas(data);
                        actualizarTablaMovimientos(data.movimientos); // Actualizar tabla con los movimientos
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al verificar caja activa.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        function actualizarTarjetas(data) {
            $('#saldoInicial').text(`S/${data.saldo_inicial}`);
            $('#saldoGastado').text(`S/${data.saldo_gastado}`);
            $('#saldoFinal').text(`S/${data.saldo_final}`);
        }

        function inicializarTablaMovimientos() {
            $('#tbl_movimientos').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Movimientos de Caja Chica',
                        className: 'bg-success text-white',
                        text: '<i class="fas fa-file-excel"></i> Exportar a Excel'
                    },
                    {
                        extend: 'print',
                        title: 'Movimientos de Caja Chica',
                        className: 'bg-primary text-white',
                        text: '<i class="fas fa-print"></i> Imprimir'
                    }
                ],
                responsive: true,
                language: { url: 'assets/languages/Spanish.json' },
                data: [],
                columns: [
                   // { data: 'id' },
                    { data: 'fecha' },
                    { data: 'descripcion' },
                    { data: 'monto', render: $.fn.dataTable.render.number(',', '.', 2, '$') },
                    { data: 'tipo_movimiento' }
                ]
            });
        }

        function actualizarTablaMovimientos(movimientos) {
            let tabla = $('#tbl_movimientos').DataTable();
            tabla.clear(); // Limpiar datos previos
            tabla.rows.add(movimientos); // Agregar nuevos datos
            tabla.draw(); // Dibujar la tabla
        }

        function cargarResponsables() {
            $.ajax({
                url: '{{ route("listar_responsables") }}',
                method: 'GET',
                success: function (data) {
                    let select = $('#responsable');
                    select.empty().append('<option value="">-- Seleccione --</option>');
                    data.forEach(responsable => {
                        select.append(`<option value="${responsable.id}">${responsable.nombre}</option>`);
                    });
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al cargar los responsables.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        function limpiarTarjetas() {
            $('#saldoInicial').text('S/0.00');
            $('#saldoGastado').text('S/0.00');
            $('#saldoFinal').text('S/0.00');
        }
    });
</script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Listado de Tipo de Cambio</h2>
            </div>
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Tipo de Cambio</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-gray shadow mt-4">
            <div class="card-body px-3 py-3">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="date" id="fecha" class="form-control" placeholder="Seleccionar fecha">
                    </div>
                    <div class="col-md-4">
                        <select id="moneda" class="form-control">
                            <option value="USD" selected>USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                            <option value="PEN">PEN</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="consultar" class="btn btn-primary">Consultar</button>
                    </div>
                </div>
                <table id="tbl_TipoCambio" class="table table-striped w-100 shadow border border-secondary">
                    <thead class="bg-main text-white">
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Moneda Origen</th>
                            <th>Moneda Destino</th>
                            <th>Compra (PEN)</th>
                            <th>Venta (PEN)</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // Cargar tipo de cambio de hoy al cargar la página
    fetchTipoCambioHoy();

    // Inicializar DataTable
    const table = $('#tbl_TipoCambio').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('tipo.cambio.listar') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            { data: 'id' },
            { data: 'fecha' },
            { data: 'moneda_origen' },
            { data: 'moneda_destino' },
            { data: 'tipo_cambio_compra' },
            { data: 'tipo_cambio_venta' },
            { data: 'estado' }
        ],
        language: {
            url: '/assets/languages/Spanish.json'
        }
    });

    // Evento para consultar por fecha y moneda
    $('#consultar').on('click', function () {
        const fecha = $('#fecha').val();
        const moneda = $('#moneda').val(); // Obtener la moneda seleccionada
        if (fecha && moneda) {
            fetchTipoCambioPorFecha(fecha, moneda);
        } else {
            Swal.fire('Error', 'Por favor, selecciona una fecha y una moneda.', 'warning');
        }
    });

    function fetchTipoCambioHoy() {
        $.ajax({
            url: "{{ route('tipo.cambio.hoy') }}",
            method: "GET",
            success: function (response) {
                if (response.success) {
                    const tipoCambio = response.data;
                    table.row.add({
                        id: tipoCambio.id || 'N/A',
                        fecha: tipoCambio.fecha,
                        moneda_origen: tipoCambio.moneda_origen,
                        moneda_destino: tipoCambio.moneda_destino,
                        tipo_cambio_compra: tipoCambio.tipo_cambio_compra || 'N/A',
                        tipo_cambio_venta: tipoCambio.tipo_cambio_venta || 'N/A',
                        estado: tipoCambio.estado ? 'Activo' : 'Inactivo',
                    }).draw();
                    Swal.fire('Éxito', 'Tipo de cambio cargado correctamente.', 'success');
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function (xhr) {
                Swal.fire('Error', 'No se pudo cargar el tipo de cambio.', 'error');
                console.error(xhr.responseText);
            }
        });
    }

    function fetchTipoCambioPorFecha(fecha, moneda) {
        $.ajax({
            url: "{{ route('tipo.cambio.fecha') }}",
            method: "GET",
            data: { date: fecha, currency: moneda },
            success: function (response) {
                if (response.success) {
                    const tipoCambio = response.data;
                    table.row.add({
                        id: tipoCambio.id || 'N/A',
                        fecha: tipoCambio.fecha,
                        moneda_origen: tipoCambio.moneda,
                        moneda_destino: 'PEN',
                        tipo_cambio_compra: tipoCambio.compra || 'N/A',
                        tipo_cambio_venta: tipoCambio.venta || 'N/A',
                        estado: 'Activo',
                    }).draw();
                    Swal.fire('Éxito', `Tipo de cambio para ${moneda} en ${fecha} cargado correctamente.`, 'success');
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'No se pudo cargar el tipo de cambio para la fecha y moneda seleccionada.', 'error');
            }
        });
    }
});

</script>


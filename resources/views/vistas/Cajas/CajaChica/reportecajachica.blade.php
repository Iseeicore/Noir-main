<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Reporte de Movimientos de Caja Chica</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Reporte de Movimientos</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="mb-3">
            <!-- Filtros dinámicos -->
            <div class="row">
                <div class="col-md-3">
                    <label for="fecha_inicio">Fecha Inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio">
                </div>
                <div class="col-md-3">
                    <label for="fecha_fin">Fecha Fin</label>
                    <input type="date" class="form-control" id="fecha_fin">
                </div>

                <div class="col-md-3">
                    <label for="descripcion">Descripción</label>
                    <select class="form-control" id="descripcion">
                        <option value="">-- Seleccione una descripción --</option>
                        <!-- Opciones dinámicas -->
                    </select>
                </div>
                <div class="col-md-3 align-self-end">
                    <button id="btnFiltrar" class="btn btn-primary">Filtrar</button>
                </div>

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered shadow border-secondary display" id="tbl_movimientos">
                <thead class="bg-main text-center">
                    <tr>
                        <th>ID</th>
                        <th>Caja Chica</th>
                        <th>Tipo Movimiento</th>
                        <th>Monto</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Inicializar DataTable
        const table = $('#tbl_movimientos').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    text: '<i class="fas fa-sync-alt"></i>',
                    className: 'bg-secondary',
                    action: function () {
                        table.ajax.reload();
                    }
                },
                {
                    extend: 'excel',
                    title: 'Reporte de Movimientos de Caja Chica'
                },
                {
                    extend: 'print',
                    title: 'Reporte de Movimientos de Caja Chica'
                },
                'pageLength'
            ],
            ajax: {
                url: "{{ route('reportecajachica.listar') }}",
                type: "GET",
                dataSrc: function (json) {
                    if (!Array.isArray(json)) {
                        console.error('Respuesta del servidor no es un array:', json);
                        return [];
                    }
                    return json;
                }
            },
            columns: [
                { data: 'id', className: 'text-center' },
                { data: 'caja_chica.descripcion', defaultContent: 'N/A', className: 'text-center' },
                { data: 'tipo_movimiento', className: 'text-center' },
                {
                    data: 'monto',
                    className: 'text-center',
                    render: $.fn.dataTable.render.number(',', '.', 2, '$')
                },
                { data: 'descripcion', defaultContent: 'N/A', className: 'text-center' },
                { data: 'fecha', className: 'text-center' }
            ],
            responsive: {
                details: {
                    type: 'column'
                }
            },
            language: {
                url: 'assets/languages/Spanish.json'
            }
        });

        // Filtro dinámico
        $('#btnFiltrar').on('click', function () {
            const fechaInicio = $('#fecha_inicio').val();
            const fechaFin = $('#fecha_fin').val();
            const descripcion = $('#descripcion').val();

            // Construye el objeto de datos dinámicamente
            const data = {
                _token: '{{ csrf_token() }}' // Siempre incluye el token CSRF
            };

            if (fechaInicio) data.fecha_inicio = fechaInicio;
            if (fechaFin) data.fecha_fin = fechaFin;
            if (descripcion) data.descripcion = descripcion;

            console.log('Datos enviados para filtrar:', data); // Depuración

            $.ajax({
                url: "{{ route('reportecajachica.filtrar') }}",
                type: "POST",
                data: data,
                success: function (response) {
                    console.log('Respuesta recibida:', response);
                    table.clear();
                    table.rows.add(response).draw();
                },
                error: function (xhr) {
                    console.error('Error al filtrar:', xhr.responseJSON || xhr.responseText);
                    alert(xhr.responseJSON?.error || 'Ocurrió un error al filtrar los datos.');
                }
            });
        });
    });
    $(document).ready(function () {
    // Cargar descripciones disponibles en el selector
    function cargarDescripciones() {
        $.ajax({
            url: "{{ route('caja_chica.listar_descripciones') }}", // Nueva ruta para obtener descripciones
            type: "GET",
            success: function (response) {
                const select = $('#descripcion');
                select.empty(); // Limpiar opciones previas
                select.append('<option value="">-- Seleccione una descripción --</option>');
                response.forEach(descripcion => {
                    select.append(`<option value="${descripcion}">${descripcion}</option>`);
                });
            },
            error: function () {
                console.error('Error al cargar descripciones.');
            }
        });
    }

    // Llamar a la función al cargar la página
    cargarDescripciones();
});

</script>

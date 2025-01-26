<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Reporte de Movimientos de Caja Contable</h1>
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
        <!-- Filtros avanzados -->
        <div class="row mt-3">
            <div class="col-md-3">
                <label for="fecha_inicio">Fecha Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
            </div>
            <div class="col-md-3">
                <label for="fecha_fin">Fecha Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
            </div>
            <div class="col-md-3">
                <label for="responsable">Responsable</label>
                <select id="responsable" name="responsable" class="form-control">
                    <option value="">Todos</option>
                    <!-- Opciones dinámicas -->
                </select>
            </div>
            <div class="col-md-3">
                <label for="tipo_movimiento">Tipo de Movimiento</label>
                <select id="tipo_movimiento" name="tipo_movimiento" class="form-control">
                    <option value="">Todos</option>
                    <option value="ingreso">Ingreso</option>
                    <option value="egreso">Egreso</option>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="categoria_id">Tipo de Medio de Pago</label>
                    <select id="categoria_id" name="categoria_id" class="form-control">
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
            <div class="col-md-3">
                <label for="caja_contable">Caja Contable</label>
                <select id="caja_contable" class="form-control">
                    <option value="">Todas</option>
                    <!-- Opciones dinámicas se llenarán aquí -->
                </select>
            </div>

            <div class="col-md-3 align-self-end">
                <button id="btnRestablecer" class="btn btn-secondary">Restablecer Filtros</button>
                <button id="btnFiltrar" class="btn btn-primary">Filtrar</button>
            </div>
        </div>

        <!-- Tabla de Reportes -->
        <div class="table-responsive mt-3">
            <table class="table table-bordered shadow border-secondary display" id="tbl_movimientos_caja_contable">
                <thead class="bg-main text-center">
                    <tr>
                        <th>Fecha</th>
                        <th>Responsable</th>
                        <th>Caja Contable</th>
                        <th>Tipo Movimiento</th>
                        <th>Tipo Medio de Pago</th>
                        <th>Descripción</th>
                        <th>Nº Referencia</th>
                        <th>Ingreso</th>
                        <th>Egreso</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        //Inicializacion
        cargarCategorias();



        const table = $('#tbl_movimientos_caja_contable').DataTable({
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
        url: "{{ route('reportecajacontable.listar') }}",
        type: "GET",
        dataSrc: "",
    },
    columns: [
        { data: 'fecha', className: 'text-center' },
        { data: 'responsable', className: 'text-center', defaultContent: 'N/A' },
        { data: 'caja_contable', className: 'text-center', defaultContent: 'N/A' },
        { data: 'tipo_movimiento', className: 'text-center' },
        { data: 'categoria', className: 'text-center', defaultContent: 'Sin categoría' }, // Actualizado para categoría
        { data: 'descripcion', className: 'text-center', defaultContent: 'N/A' },
        { data: 'referencia', className: 'text-center', defaultContent: 'N/A' },
        {
            data: 'ingreso',
            className: 'text-center',
            render: function (data) {
                return data ? `S/${parseFloat(data).toFixed(2)}` : '-';
            },
        },
        {
            data: 'egreso',
            className: 'text-center',
            render: function (data) {
                return data ? `S/${parseFloat(data).toFixed(2)}` : '-';
            },
        },
    ],
    language: {
        url: 'assets/languages/Spanish.json',
    },
});


    $('#btnFiltrar').on('click', function () {
        const filters = {
            fecha_inicio: $('#fecha_inicio').val(),
            fecha_fin: $('#fecha_fin').val(),
            responsable: $('#responsable').val(),
            tipo_movimiento: $('#tipo_movimiento').val(),
            categoria_id: $('#categoria_id').val(), // Cambiado para usar categoría
            caja_contable: $('#caja_contable').val(),
            _token: "{{ csrf_token() }}",
        };

        $.ajax({
            url: "{{ route('reportecajacontable.filtrar') }}",
            type: "POST",
            data: filters,
            success: function (response) {
                table.clear();
                table.rows.add(response).draw();
            },
            error: function (xhr) {
                alert('Error al filtrar los datos: ' + xhr.responseJSON.message);
            },
        });
    });

$('#btnRestablecer').on('click', function () {
    $('#fecha_inicio, #fecha_fin, #responsable, #tipo_movimiento, #categoria_id, #caja_contable').val('');
    table.ajax.reload();
});


    $('#btnRestablecer').on('click', function () {
        $('#fecha_inicio, #fecha_fin, #responsable, #tipo_movimiento, #categoria, #caja_contable').val('');
        table.ajax.reload();
    });

    function cargarCajasContables() {
    $.ajax({
        url: "{{ route('reportecajacontable.cajas') }}", // Ruta al método listarCajasContables
        type: "GET",
        success: function (data) {
            const select = $('#caja_contable');
            select.empty().append('<option value="">Todas</option>'); // Agrega la opción "Todas"

            // Iterar sobre las cajas contables y agregarlas al select
            data.forEach(caja => {
                select.append(`<option value="${caja.id}">${caja.descripcion}</option>`);
            });
        },
        error: function () {
            alert('Error al cargar las cajas contables.');
        },
    });
}

// Llamar a la función para llenar el filtro al cargar la página
cargarCajasContables();

function cargarResponsables() {
    $.ajax({
        url: "{{ route('reportecajacontable.responsables') }}",
        type: "GET",
        success: function (data) {
            const select = $('#responsable');
            select.empty().append('<option value="">Todos</option>');

            data.forEach(responsable => {
                select.append(`<option value="${responsable.id}">${responsable.nombre}</option>`);
            });
        },
        error: function (xhr) {
            console.error('Error al cargar los responsables:', xhr.responseText);
            alert('Error al cargar los responsables. Intenta nuevamente.');
        }
    });
}

// Llama a esta función después de que el documento esté listo
    $(document).ready(function () {
        cargarResponsables();
    });

    function cargarCategorias() {
    $.ajax({
        url: "{{ route('caja_contable.listar_categorias') }}",
        method: "GET",
        success: function (data) {
            let select = $('#categoria_id');
            select.empty().append('<option value="">-- Seleccione una categoría --</option>');
            if (data.length > 0) {
                data.forEach(categoria => {
                    select.append(`<option value="${categoria.id}">${categoria.nombre}</option>`);
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Sin categorías',
                    text: 'No hay categorías disponibles.',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error al cargar las categorías',
                text: xhr.responseJSON?.message || 'Ocurrió un error al cargar las categorías.',
                confirmButtonText: 'OK'
            });
        }
    });
}
}
);
    </script>

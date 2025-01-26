<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">KARDEX</h2>
            </div><!-- /.col -->
            <div class="col-sm-6  d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Kardex</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-gray shadow mt-3">
                    <div class="card-body px-3 py-3" style="position: relative;">
                        <span class="titulo-fieldset px-3 py-1">CRITERIOS DE BÚSQUEDA </span>

                        <div class="row my-2">
                            <div class="col-12 col-lg-3 mb-2">
                                <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-dollar-sign mr-1 my-text-color"></i>Almacene de origen</label>
                                <select data-index="7" class="form-select" id="id_almacen_busqueda" aria-label="Floating label select example" required>
                                </select>
                            </div>

                            <div class="col-12 col-lg-3 mb-2">
                                <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-layer-group mr-1 my-text-color"></i>Almacen de Salida</label>
                                <select data-index="5" class="form-select" id="id_almacen_destino" aria-label="Floating label select example" required>
                                </select>
                            </div>

                            <div class="col-12 col-lg-3 mb-2">
                                <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-layer-group mr-1 my-text-color"></i>Centro Costo</label>
                                <select data-index="5" class="form-select" id="id_Centro_Costo" aria-label="Floating label select example" required>
                                </select>
                            </div>

                            <div class="col-12 col-lg-3 mb-2">
                                <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-gifts mr-1 my-text-color"></i>Producto</label>
                                <input data-index="6" type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="iptProducto" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>

                            <div class="col-12 col-lg-6 mb-2">
                                <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-calendar-alt mr-1 my-text-color"></i>Fecha Desde</label>
                                <input type="date" style="border-radius: 20px;" class="form-control form-control-sm" id="fecha_inicio">
                            </div>
                            <div class="col-12 col-lg-6 mb-2">
                                <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-calendar-alt mr-1 my-text-color"></i>Fecha Hasta</label>
                                <input type="date" style="border-radius: 20px;" class="form-control form-control-sm" id="fecha_fin">
                            </div> 
                            <div class="col-12 col-lg-6 mb-2">
                                <button type="button" class="btn btn-dark" id="btnlimpiar" style="box-shadow: 0 4px 8px rgb(52, 73, 94); border-radius: 20px; border: none; color: white;">
                                    <i class="fas fa-broom"></i> Limpiar
                                </button>
                            </div>                          
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-gray shadow mt-3">

            <div class="card-body px-3 py-3" style="position: relative;">

                <span class="titulo-fieldset px-3 py-1">LISTADO KARDEX </span>

                
                <div class="row my-2">

                    <div class="col-lg-12">

                        <table id="tbl_kardex" class="table w-100 shadow border responsive border-secondary display">
                            <thead class="bg-main">
                                <tr style="font-size: 13px;">
                                    <th>ID</th> <!-- Columna oculta -->
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Almacén</th>
                                    <th>Almacén Destino</th>
                                    <th>Fecha</th>
                                    <th>Concepto</th>
                                    <th>Centro Costo</th>
                                    <th>Unidades Ingresadas</th>
                                    <th>Costo Unitario Ingresado</th>
                                    <th>Costo Total Ingresado</th>
                                    <th>Unidades Salidas</th>
                                    <th>Costo Unitario Salida</th>
                                    <th>Costo Total Salida</th>
                                    <th>Unidades Existentes</th>
                                    <th>Costo Unitario Existente</th>
                                    <th>Costo Total Existente</th>
                                </tr>
                            </thead>
                            <tbody class="text-small"></tbody>
                        </table>
                        
                        
                        
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    inicializarDataTable();
    cargarOrigenAlmacenes();
    cargarDestinoAlmacenes();
    cargarOrigenCentroCosto();
    // Filtrar por rango de fechas
    $('#fecha_inicio, #fecha_fin').change(function () {
        aplicarFiltroFechas();
    });

     // Botón para limpiar filtros
    $('#btnlimpiar').on('click', function () {
        limpiarFiltros();
    });
});

function cargarOrigenCentroCosto() {
    $.ajax({
        url: "{{ route('documento.cargar_centros_costo') }}", // Ruta para obtener la lista de centros de costo
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Asegúrate de acceder a la clave correcta que contiene el array
            var centrosCosto = data.centros_costo || []; // Ajusta según la estructura devuelta por tu API

            var select = $('#id_Centro_Costo');
            select.empty();
            select.append('<option value="">-- Seleccione Centro de Costo --</option>'); // Opción para todos
            centrosCosto.forEach(function(centro) {
                select.append('<option value="' + centro.nomb_centroCos + '">' + centro.nomb_centroCos + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar centros de costo:', error);
        }
    });
}


function cargarOrigenAlmacenes() {
    $.ajax({
        url: '{{ route("listar_almacenes") }}', // Ruta para obtener la lista de almacenes
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('#id_almacen_busqueda');
            select.empty();
            select.append('<option value="">-- Todos los Almacenes --</option>'); // Opción para todos
            data.forEach(function(almacen) {
                select.append('<option value="' + almacen.nomb_almacen + '">' + almacen.nomb_almacen + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar almacenes:', error);
        }
    });
}

function cargarDestinoAlmacenes() {
    $.ajax({
        url: '{{ route("listar_almacenes") }}', // Ruta para obtener la lista de almacenes
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('#id_almacen_destino');
            select.empty();
            select.append('<option value="">-- Todos los Almacenes --</option>'); // Opción para todos
            data.forEach(function(almacen) {
                select.append('<option value="' + almacen.nomb_almacen + '">' + almacen.nomb_almacen + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar almacenes:', error);
        }
    });
}

function inicializarDataTable() {
    var table = $('#tbl_kardex').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                text: '<i class="fas fa-sync-alt"></i>',
                className: 'bg-secondary',
                action: function (e, dt, node, config) {
                    dt.ajax.reload();
                },
            },
            {
                extend: 'excel',
                title: 'LISTADO DE KARDEX',
            },
            {
                extend: 'print',
                title: 'LISTADO DE KARDEX',
                customize: function (win) {
                    $(win.document.body)
                        .css('font-size', '10pt')
                        .prepend(`
                            <h3 class="text-center">Listado Completo de Kardex</h3>
                            <p class="text-center">Fecha: ${new Date().toLocaleDateString()}</p>
                        `);

                    // Mostrar todas las columnas, incluyendo las ocultas, en la impresión
                    $(win.document.body)
                        .find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
            },'pageLength'
        ],
        ajax: {
            url: '{{ route("kardex.listar") }}',
            type: 'GET',
            dataSrc: 'data',
        },
        columns: [
            { data: 'id_kardex', visible: false }, // ID Kardex oculto por defecto
            { data: 'codigo_producto', className: 'dt-center' },
            { data: 'producto', className: 'dt-center' },
            { data: 'almacen', className: 'dt-center' },
            { data: 'almacen_destino', className: 'dt-center' },
            { data: 'fecha', className: 'dt-center' },
            { data: 'concepto', className: 'dt-center' },
            { data: 'descripcion_centro_costo', className: 'dt-center' },
            { data: 'unidades_ingresadas', className: 'dt-center', defaultContent: 'N/A' },
            { data: 'costo_unitario_ingresado', className: 'dt-center', defaultContent: 'N/A' },
            { data: 'costo_total_ingresado', className: 'dt-center', defaultContent: 'N/A' },
            { data: 'unidades_salidas', className: 'dt-center', defaultContent: 'N/A' },
            { data: 'costo_unitario_salida', className: 'dt-center', defaultContent: 'N/A' },
            { data: 'costo_total_salida', className: 'dt-center', defaultContent: 'N/A' },
            { data: 'unidades_existentes', className: 'dt-center', defaultContent: 'N/A' },
            { data: 'costo_unitario_existente', className: 'dt-center', defaultContent: 'N/A' },
            { data: 'costo_total_existente', className: 'dt-center', defaultContent: 'N/A' },
        ],
        responsive: true,
        language: {
            url: '/assets/languages/Spanish.json',
        },
        columnDefs: [
            {
                targets: [0], // Ocultar la columna de ID Kardex
                visible: false,
            },
            {
                targets: [1,3,4], // Ocultar la columna de ID Kardex
                visible: false,
            },
        ],
    });

    
    // Filtros dinámicos
    $('#id_almacen_busqueda').change(function () {
        table.column(3).search($(this).val()).draw(); // Almacén
    });

    $('#id_almacen_destino').change(function () {
        table.column(4).search($(this).val()).draw(); // Almacén Destino
    });

    $('#iptProducto').keyup(function () {
        table.column(2).search($(this).val()).draw(); // Producto
    });
        // Nuevo filtro por Centro Costo
        $('#id_Centro_Costo').change(function () {
        table.column(7).search($(this).val()).draw(); // Centro Costo (Columna 7)
    });



    // Botón de limpiar filtros
    $('#btnlimpiar').on('click', function () {
        $('#id_almacen_busqueda').val('');
        $('#id_almacen_destino').val('');
        $('#iptProducto').val('');
        table.search('').columns().search('').draw();
    });

    // Mostrar/Ocultar columnas manualmente
    $('#tbl_kardex').on('click', 'th', function () {
        var column = table.column($(this).index());
        column.visible(!column.visible());
    });
}
function aplicarFiltroFechas() {
    var table = $('#tbl_kardex').DataTable();
    var fechaInicio = $('#fecha_inicio').val();
    var fechaFin = $('#fecha_fin').val();

    // Validar que ambas fechas estén seleccionadas
    if (fechaInicio && fechaFin) {
        var rangoFechas = fechaInicio + '|' + fechaFin;

        // Usar búsqueda con expresiones regulares en la columna de fecha
        table.column(5).search(rangoFechas, true, false).draw();
    } else {
        table.column(5).search('').draw(); // Limpiar filtro si no hay fechas
    }
}

function limpiarFiltros() {
    $('#fecha_inicio').val('');
    $('#fecha_fin').val('');
    $('#id_almacen_busqueda').val('');
    $('#id_almacen_destino').val('');
    $('#iptProducto').val('');
    var table = $('#tbl_kardex').DataTable();
    table.search('').columns().search('').draw();
}

</script>
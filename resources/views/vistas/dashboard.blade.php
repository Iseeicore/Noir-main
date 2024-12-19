<!-- resources/views/modulos/partials/dashboard_content.blade.php -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">TABLERO PRINCIPAL</h2>
            </div><!-- /.col -->
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Tablero Principal</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- TARJETA TOTAL PRODUCTOS -->
            <div class="col-12 col-md-3 col-lg-2 mb-3">
                <div class="card bg-transparent border-0 text-center">
                    <div class="card-body d-flex align-items-center justify-content-between"
                        style="border: 1px solid #e0e0e0; border-radius: 8px;">
                        <div>
                            <i class="fas fa-box fa-2x text-info"></i>
                        </div>
                        <div>
                            <h5 id="totalProductos" class="font-weight-bold mb-0">42</h5>
                            <p class="text-muted mb-0">Productos</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TARJETA TOTAL COMPRAS -->
            <div class="col-12 col-md-3 col-lg-2 mb-3">
                <div class="card bg-transparent border-0 text-center">
                    <div class="card-body d-flex align-items-center justify-content-between"
                        style="border: 1px solid #e0e0e0; border-radius: 8px;">
                        <div>
                            <i class="fas fa-shopping-cart fa-2x text-success"></i>
                        </div>
                        <div>
                            <h5 id="totalCompras" class="font-weight-bold mb-0">Cargando...</h5>
                            <p class="text-muted mb-0" id="almacenNombre">Almacén</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3 col-lg-2 mb-3">
                <div class="card bg-transparent border-0 text-center">
                    <div class="card-body d-flex align-items-center justify-content-between"
                        style="border: 1px solid #e0e0e0; border-radius: 8px;">
                        <div>
                            <i class="fas fa-undo fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h5 id="totalDevoluciones" class="font-weight-bold mb-0">0</h5>
                            <p class="text-muted mb-0">Devoluciones del día</p>
                        </div>
                    </div>
                </div>
            </div>



            <!-- TARJETA TOTAL GANANCIAS -->
            <div class="col-12 col-md-3 col-lg-2 mb-3">
                <div class="card bg-transparent border-0 text-center">
                    <div class="card-body d-flex align-items-center justify-content-between"
                        style="border: 1px solid #e0e0e0; border-radius: 8px;">
                        <div>
                            <i class="fas fa-chart-line fa-2x text-danger"></i>
                        </div>
                        <div>
                            <h5 id="totalGanancias" class="font-weight-bold mb-0">0</h5>
                            <p class="text-muted mb-0">Doc Ingresos del dia</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TARJETA PRODUCTOS POCO STOCK -->
            <div class="col-12 col-md-3 col-lg-2 mb-3">
                <div class="card bg-transparent border-0 text-center">
                    <div class="card-body d-flex align-items-center justify-content-between"
                        style="border: 1px solid #e0e0e0; border-radius: 8px;">
                        <div>
                            <i class="fas fa-exclamation-triangle fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h5 id="totalProductosMinStock" class="font-weight-bold mb-0">9</h5>
                            <p class="text-muted mb-0">Producto Poco Stock</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TARJETA VENTAS DEL DÍA -->
            <div class="col-12 col-md-3 col-lg-2 mb-3">
                <div class="card bg-transparent border-0 text-center">
                    <div class="card-body d-flex align-items-center justify-content-between"
                        style="border: 1px solid #e0e0e0; border-radius: 8px;">
                        <div>
                            <i class="fas fa-calendar-day fa-2x text-secondary"></i>
                        </div>
                        <div>
                            <h5 id="totalVentasHoy" class="font-weight-bold mb-0">0</h5>
                            <p class="text-muted mb-0">Doc Salida del Día</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-6 col-md-12">

                    <div class="card card-gray shadow w-lg-100 float-right mt-4">

                        <div class="card-body px-3 py-3 fw-bold" style="position: relative;">

                            <span class="titulo-fieldset px-3 py-1" id="title-header-ventas-mes"> Grafica de Movimiento
                                de Producto</span>

                            <div class="row my-1">

                                <div class="col-12 mb-3">
                                    <label for="productoSelect">Seleccionar Producto</label>
                                    <select id="productoSelect" class="form-select">
                                        <!-- Opciones cargadas dinámicamente -->
                                    </select>
                                </div>

                                <div class="col-12">
                                    <div class="card card-gray shadow w-lg-100">
                                        <div class="card-body">
                                            <!-- Imagen de espera -->
                                            <div id="loadingImage" class="chart text-center" style="display: block;">
                                                <img src="{{ asset('storage/assets/imagenes/cargas/Espera.svg') }}" alt="Cargando..."
                                                    style="max-height: 250px;">
                                                <p class="text-muted mt-2">Cargando Movimientos...</p>
                                            </div>
                                            <!-- Gráfico -->
                                            <div class="chart" id="chartContainer" style="display: none;">
                                                <canvas id="barChart"
                                                    style="min-height: 250px; height: 300px; max-height: 350px; width: 100%;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-6 col-md-12">

                    <div class="card card-gray shadow w-lg-100 float-right mt-4">

                        <div class="card-body px-3 py-3 fw-bold" style="position: relative;">

                            <span class="titulo-fieldset px-3 py-1" id="title-variacion-precio-producto"> VARIACION PRECIOS X PRODUCTOS</span>

                            <div class="row my-1">

                                <div class="col-12 mb-3">
                                    <label for="productoSelect_Tiempo">Seleccionar Producto</label>
                                    <select id="productoSelect_Tiempo" class="form-select">

                                    </select>
                                </div>

                                <div class="col-12">
                                    <div class="card card-gray shadow w-lg-100">
                                        <div class="card-body">
                                            <!-- Imagen de espera -->
                                            <div id="loadingImagePrices" class="chart-container text-center" style="display: block;">
                                                <img src="{{ asset('assets/dist/img/loading.svg') }}" alt="Cargando..."
                                                style="max-height: 250px;">
                                                <p class="text-muted mt-2">Cargando variación de precios...</p>
                                            </div>
                                            <!-- Gráfico -->
                                            <div class="chart-container" id="chartPricesContainer" style="display: none;">
                                                <canvas id="lineChartPrecios"  style="min-height: 250px; height: 300px; max-height: 350px; width: 100%;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-12 col-lg-6">

                        <div class="card card-gray shadow mt-4">

                            <div class="card-body px-3 py-3" style="position: relative;">

                                <span class="titulo-fieldset px-3 py-1">PRODUCTOS CON POCO STOCK</span>

                                <div class="row my-1">

                                    <div class="col-12">
                                        <table class="table" id="tbl_productos_poco_stock">
                                            <thead>
                                                <tr class="text-danger">
                                                    <th>Producto</th>
                                                    <th class="text-center">Almacen</th>
                                                    <th class="text-center">Stock Actual</th>
                                                    <th class="text-center">Mín. Stock</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>


                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card card-gray shadow w-lg-100 float-right mt-4">
                            <div class="card-body px-3 py-3 fw-bold" style="position: relative;">
                                <span class="titulo-fieldset px-3 py-1">Gráfico de Movimientos por Medio de Pago</span>
                                <div class="card-body">
                                    <div class="form-group mb-4">
                                        <label for="medioPagoSelect" class="font-weight-bold text-dark">Seleccionar Medio de Pago:</label>
                                        <select id="medioPagoSelect" class="form-control border-primary">
                                            <option value="">-- Todos los Medios de Pago --</option>
                                            <!-- Opciones dinámicas -->
                                        </select>
                                    </div>
                                    <div>
                                        <canvas id="chartMedioPago"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="row">


                </div>
            </div>
        </div>
<script>
    var chart;
    $(document).ready(function() {
        cargarProductos();
        cargarProductosPocoStock();
        cargarTotalProductos();
        cargarTotalComprasPorAlmacen();
        cargarProductosPocoStockConteo();
        cargarVentasDelDia();
        cargarDatosMedioPago();
        cargarTotalIngresosDelDia();
        cargarDevolucionesDelDia();
        cargarProductosTiempo();
        $('#productoSelect').on('change', function() {
            const productoId = $(this).val();
            if (productoId) {
                // Ocultar la imagen de espera y mostrar el gráfico
                $('#loadingImage').hide();
                $('#chartContainer').show();
                cargarMovimientosQuincenales(productoId);
            } else {
                // Mostrar la imagen de espera y ocultar el gráfico
                $('#loadingImage').show();
                $('#chartContainer').hide();
            }
        });

        $('#productoSelect_Tiempo').on('change', function () {
            const codigoProducto = $(this).val();
            if (codigoProducto) {
                $('#loadingImagePrices').hide();
                $('#chartPricesContainer').show();
                cargarVariacionPrecios(codigoProducto);
            } else {
                $('#loadingImagePrices').show();
                $('#chartPricesContainer').hide();
            }
        });



    });

    function cargarProductosTiempo() {
        $.ajax({
          url: '/dashboard/productostiempo',
          type: 'GET',
          success: function (data) {
              const select = $('#productoSelect_Tiempo');
              select.empty().append('<option value="">-- Seleccione un producto --</option>');
              data.forEach(producto => {
                  select.append(`<option value="${producto.codigo_productos}">${producto.descripcion}</option>`);
              });
          },
          error: function () {
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'No se pudieron cargar los productos.',
              });
          },
      });
    }

    function cargarVentasDelDia() {
        $.ajax({
            url: '/dashboard/ventas-dia', // Ruta para llamar al método en el controlador
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#totalVentasHoy').text(response.total_salidas); // Actualizar el conteo en la tarjeta
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron cargar las ventas del día.',
                });
            },
        });
    }

    function cargarTotalIngresosDelDia() {
        $.ajax({
            url: '/kardex/ingresos-dia',
            type: 'GET',
            success: function (response) {
                if (response.success) {
                    $('#totalGanancias').text(response.total_ingresos);
                } else {
                    Swal.fire('Error', 'No se pudo obtener los ingresos del día.', 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Ocurrió un error al cargar los datos.', 'error');
            },
        });
    }

    function cargarProductosPocoStockConteo() {
        $.ajax({
            url: "/productos/poco-stock/conteo",
            type: "GET",
            success: function(response) {
                if (response.success) {
                    // Actualizar el valor en la tarjeta
                    $("#totalProductosMinStock").text(response.total);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo obtener el conteo de productos con poco stock.',
                });
            },
        });
    }

    // Inicialización del gráfico
    function inicializarGraficoMedioPago(datos, categorias, categoriaId = null) {
            const ctx = document.getElementById('chartMedioPago').getContext('2d');

            const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            const totales = Array(12).fill(0);
            const cantidades = Array(12).fill(0);

            if (categoriaId && datos[categoriaId]) {
                const data = datos[categoriaId]['meses'];
                for (const mes in data) {
                    totales[mes - 1] = data[mes].total;
                    cantidades[mes - 1] = data[mes].cantidad;
                }
            } else {
                for (const id in datos) {
                    const data = datos[id]['meses'];
                    for (const mes in data) {
                        totales[mes - 1] += data[mes].total;
                        cantidades[mes - 1] += data[mes].cantidad;
                    }
                }
            }

            if (chart) {
                chart.destroy();
            }

            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: meses,
                    datasets: [
                        {
                            label: 'Total (S/.)',
                            data: totales,
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Cantidad de Movimientos',
                            data: cantidades,
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Meses'
                            }
                        }
                    }
                }
            });
        }

    // Cargar datos para el gráfico
    function cargarDatosMedioPago() {
        $.ajax({
            url: '{{ route("caja_contable.medio_pago_datos") }}',
            method: 'GET',
            success: function (response) {
                const { datos, categorias } = response;

                const select = $('#medioPagoSelect');
                select.empty().append('<option value="">-- Todos los Medios de Pago --</option>');
                for (const id in categorias) {
                    select.append(`<option value="${id}">${categorias[id]}</option>`);
                }

                inicializarGraficoMedioPago(datos, categorias);

                select.off('change').on('change', function () {
                    const categoriaId = $(this).val();
                    inicializarGraficoMedioPago(datos, categorias, categoriaId);
                });
            },
            error: function () {
                alert('Error al cargar los datos del gráfico.');
            }
        });
    }


    function cargarDevolucionesDelDia() {
        $.ajax({
            url: '/devoluciones/del-dia',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#totalDevoluciones').text(response.total_devoluciones);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar las devoluciones del día.',
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al cargar las devoluciones del día.',
                });
            },
        });
    }


    function cargarTotalComprasPorAlmacen() {
        $.ajax({
            url: '/dashboard/total-compras-almacen',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    const totalCompras = parseFloat(response.total_compras) || 0; // Convertir a número
                    $('#totalCompras').text(`S/. ${totalCompras.toFixed(2)}`);
                    $('#almacenNombre').text(`Almacén: ${response.almacen_nombre}`);
                } else {
                    $('#totalCompras').text('Error');
                    $('#almacenNombre').text('Almacén no disponible');
                }
            },
            error: function() {
                $('#totalCompras').text('Error');
                $('#almacenNombre').text('Error la carga');
            },
        });
    }

    function cargarProductosPocoStock() {
        const table = $("#tbl_productos_poco_stock");
        const tbody = table.find("tbody");

        // Mostrar la imagen de carga y limpiar el contenido de la tabla
        tbody.html(`
            <tr id="loadingRow">
                <td colspan="4" class="text-center">
                    <img src="/assets/dist/img/Espera.svg" alt="Cargando..." style="max-height: 150px;">
                    <p class="text-muted mt-2">Cargando productos con poco stock...</p>
                </td>
            </tr>
        `);

        // Realizar la solicitud AJAX
        $.ajax({
            url: "/productos/poco-stock",
            type: "GET",
            success: function(response) {
                if (response.success && response.productos.length > 0) {
                    tbody.empty(); // Remover la fila de carga
                    response.productos.forEach(producto => {
                        const rowClass = producto.stock_actual < producto.minimo_stock ? 'table-danger' : '';
                        tbody.append(`
                            <tr class="${rowClass}">
                                <td>${producto.producto}</td>
                                <td class="text-center">${producto.almacen}</td>
                                <td class="text-center">${producto.stock_actual}</td>
                                <td class="text-center">${producto.minimo_stock}</td>
                            </tr>
                        `);
                    });
                } else {
                    tbody.html(`
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                <img src="/assets/dist/img/Espera.svg" alt="Sin productos" style="max-height: 150px;">
                                <p class="mt-2">No hay productos con poco stock.</p>
                            </td>
                        </tr>
                    `);
                }
            },
            error: function() {
                tbody.html(`
                    <tr>
                        <td colspan="4" class="text-center text-danger">
                            <img src="/assets/dist/img/Espera.svg" alt="Error" style="max-height: 150px;">
                            <p class="mt-2">Error al cargar los productos con poco stock.</p>
                        </td>
                    </tr>
                `);
            },
        });
    }


    function cargarTotalProductos() {
        $.ajax({
            url: '/dashboard/total-productos',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#totalProductos').text(response.total_productos);
                } else {
                    console.error('Error al obtener el total de productos:', response.message);
                    $('#totalProductos').text('Error');
                }
            },
            error: function() {
                console.error('Error al cargar el total de productos.');
                $('#totalProductos').text('Error');
            },
        });
    }

    function cargarProductos() {
        $.ajax({
            url: '/productos/dashboard',
            type: 'GET',
            success: function(productos) {
                const select = $('#productoSelect');
                select.empty().append('<option value="">-- Seleccione un producto --</option>');
                productos.forEach(producto => {
                    select.append(
                        `<option value="${producto.id}">${producto.descripcion}</option>`);
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron cargar los productos.',
                });
            },
        });
    }

    function cargarMovimientosQuincenales(productoId) {
        $.ajax({
            url: '/kardex/quincenas',
            type: 'GET',
            data: {
                producto_id: productoId,
            },
            success: function(data) {
                renderizarGrafico(data);
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron cargar los movimientos.',
                });
            },
        });
    }

    function renderizarGrafico(data) {
        const ctx = document.getElementById('barChart').getContext('2d');

        const etiquetas = ['Primera quincena', 'Segunda quincena'];

        const ingresos = data.ingresos.map(item => ({
            quincena: item.quincena,
            total_movimientos: item.total_movimientos,
        }));
        const salidas = data.salidas.map(item => ({
            quincena: item.quincena,
            total_movimientos: item.total_movimientos,
        }));
        const devoluciones = data.devoluciones.map(item => ({
            quincena: item.quincena,
            total_movimientos: item.total_movimientos,
        }));

        const valoresIngresos = [0, 0];
        const valoresSalidas = [0, 0];
        const valoresDevoluciones = [0, 0];

        ingresos.forEach(item => (valoresIngresos[item.quincena - 1] = item.total_movimientos));
        salidas.forEach(item => (valoresSalidas[item.quincena - 1] = item.total_movimientos));
        devoluciones.forEach(item => (valoresDevoluciones[item.quincena - 1] = item.total_movimientos));

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: etiquetas,
                datasets: [{
                        label: 'Ingresos',
                        data: valoresIngresos,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                    },
                    {
                        label: 'Salidas',
                        data: valoresSalidas,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true,
                    },
                    {
                        label: 'Devoluciones',
                        data: valoresDevoluciones,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    }

    function cargarVariacionPrecios(codigoProducto) {
        $.ajax({
            url: '/dashboard/obtener-variacion-precios',
            type: 'GET',
            data: { codigo_producto: codigoProducto },
            success: function (data) {
                if (data.length > 0) {
                    renderizarGraficoArea(data);
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Sin datos',
                        text: 'No se encontraron datos para el producto seleccionado.',
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al cargar los datos.',
                });
            },
        });
    }


    function renderizarGraficoArea(data) {
    const ctx = document.getElementById('lineChartPrecios').getContext('2d');

    const fechas = data.map(item => item.fecha);
    const costosExistentes = data.map(item => item.costo_existente || 0);

    if (fechas.length === 0 || costosExistentes.length === 0) {
        console.error("No hay datos para mostrar en el gráfico.");
        Swal.fire({
            icon: 'info',
            title: 'Sin datos',
            text: 'No se encontraron datos para el producto seleccionado.',
        });
        return;
    }

    if (window.myAreaChart) {
        window.myAreaChart.destroy();
    }

    window.myAreaChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: fechas,
            datasets: [
                {
                    label: 'Costo Existente',
                    data: costosExistentes,
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0, 0, 255, 0.2)',
                    fill: true,
                }
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Costo Unitario',
                    },
                },
            },
        },
    });
}






</script>

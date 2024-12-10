    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0 fw-bold">REPORTE KARDEX</h2>
                </div><!-- /.col -->
                <div class="col-sm-6  d-none d-md-block">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item active">Reporte Kardex</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content mb-3">

        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-gray shadow mt-3">
                        <div class="card-body px-3 py-3" style="position: relative;">
                            <span class="titulo-fieldset px-3 py-1">CRITERIOS DE BÚSQUEDA </span>

                            <div class="row my-2">
                                <div class="col-12 col-lg-3 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-dollar-sign mr-1 my-text-color"></i>Almacenes</label>
                                    <select data-index="7" class="form-select" id="id_almacen_busqueda" aria-label="Floating label select example" required>
                                    </select>
                                </div>
                                {{-- <div class="col-12 col-lg-3 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-barcode mr-1 my-text-color"></i>Código del Producto</label>
                                    <input data-index="3" type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="iptCodigoProd" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div> --}}
                                <div class="col-12 col-lg-3 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-layer-group mr-1 my-text-color"></i>Categorías</label>
                                    <select data-index="5" class="form-select" id="id_categoria_busqueda" aria-label="Floating label select example" required>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6 mb-2">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-gifts mr-1 my-text-color"></i>Producto</label>
                                    <input data-index="6" type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="iptProducto" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
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

            <!-- row para criterios de busqueda -->
            <div class="row">

                <div class="col-md-12">

                    <table id="tbl_kardex" class="table shadow border border-secondary" style="width:100%">
                        <thead class="bg-main text-left">
                            <th>Cod. Producto</th>
                            <th>Producto</th>
                            <th>Almacen</th>
                            <th>Entradas</th>
                            <th>Salidas</th>
                            <th>Existencias</th>
                            <th>Costo Existencias</th>
                        </thead>
                    </table>

                </div>

            </div>

        </div>

    </div> 
    <script>
        $(document).ready(function() {
        fnc_CargarDataTableKardexPorAlmacen();
        cargarAlmacenes();
        cargarCategorias();
    });

    function fnc_CargarDataTableKardexPorAlmacen() {
    if ($.fn.DataTable.isDataTable('#tbl_kardex')) {
        $('#tbl_kardex').DataTable().destroy();
        $('#tbl_kardex tbody').empty();
    }

    $('#tbl_kardex').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                title: 'KARDEX POR ALMACÉN'
            },
            'pageLength'
        ],
        pageLength: 10,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: "{{ route('reporte.kardex.almacen') }}",
            type: 'POST',
            data: function(d) {
                // Agregar los filtros seleccionados en los selects
                d.id_almacen = $('#id_almacen_busqueda').val();
                d.id_categoria = $('#id_categoria_busqueda').val();
                d.producto = $('#iptProducto').val();
                d._token = '{{ csrf_token() }}';
            }
        },
        scrollX: true,
        columnDefs: [
            {
                className: 'dt-center',
                targets: '_all'
            }
        ],
        language: {
            url: 'assets/languages/Spanish.json'
        }
    });

    window.cargarAlmacenes=function() {
        $.ajax({
            url: '{{ route("listar_almacenes") }}', // Ruta para obtener la lista de almacenes
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#id_almacen_busqueda');
                select.empty();
                select.append('<option value="">-- Todos los Almacenes --</option>'); // Opción para todos
                data.forEach(function(almacen) {
                    select.append('<option value="' + almacen.id + '">' + almacen.nomb_almacen + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar almacenes:', error);
            }
        });
    }

    window.cargarCategorias=function() {
        $.ajax({
            url: '{{ route("listar_categorias") }}', // Ruta para obtener la lista de categorías
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#id_categoria_busqueda');
                select.empty();
                select.append('<option value="">-- Todas las Categorías --</option>'); // Opción para todas
                data.forEach(function(categoria) {
                    select.append('<option value="' + categoria.id + '">' + categoria.nomb_cate + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar categorías:', error);
            }
        });
    }


    // Filtros
$('#id_almacen_busqueda, #id_categoria_busqueda').change(function() {
    $('#tbl_kardex').DataTable().ajax.reload();
});

// Filtro para el campo de búsqueda de productos (con retraso)
$('#iptProducto').on('keyup', function() {
    $('#tbl_kardex').DataTable().ajax.reload();
});

$("#btnlimpiar").on('click', function () {
    $('#id_almacen_busqueda').val('');
    $('#id_categoria_busqueda').val('');
    $('#iptProducto').val('');
    $('#tbl_kardex').DataTable().ajax.reload();
});


}



</script>
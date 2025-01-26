<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">{{ $accion === 'aumentar_stock' ? 'Aumentar Stock' : 'Disminuir Stock' }}</h2>
            </div>
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Inventario / {{ $accion === 'aumentar_stock' ? 'Aumentar stock' : 'Disminuir stock' }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-gray shadow mt-3">
            <div class="card-body px-3 py-3">
                <span class="titulo-fieldset px-2 py-1">DATOS DEL PRODUCTO</span>
                <div class="row my-1">
                    <div class="col-12 mb-3">
                        <label for="" class="form-label text-primary d-block">Codigo: <span id="stock_codigoProducto" class="text-secondary">{{ $producto->codigo_productos }}</span></label>
                        <label for="" class="form-label text-primary d-block">Producto: <span id="stock_Producto" class="text-secondary">{{ $producto->descripcion }}</span></label>
                        <label for="" class="form-label text-primary d-block">Stock actual: <span id="stock_Stock" class="text-secondary">{{ $producto->stock }}</span></label>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-2">
                            <label for="iptStockSumar">
                                <i class="fas fa-plus-circle fs-6"></i> <span class="small">{{ $accion === 'aumentar_stock' ? 'Agregar al Stock' : 'Disminuir al Stock' }}</span>
                            </label>
                            <input type="number" min="0" class="form-control form-control-sm" id="iptStockSumar" placeholder="{{ $accion === 'aumentar_stock' ? 'Ingrese cantidad a agregar al Stock' : 'Ingrese cantidad a disminuir al Stock' }}">
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="" class="form-label text-danger">Nuevo Stock: <span id="stock_NuevoStock" class="text-secondary"></span></label><br>
                    </div>

                    <!-- BOTONERA -->
                    <div class="col-12 text-center mt-3">
                        <a class="btn btn-sm btn-danger  fw-bold " id="btnCancelarRegistro" style="position: relative; width: 160px;" onclick="fnc_RegresarListadoProductos();">
                            <span class="text-button">REGRESAR</span>
                            <span class="btn fw-bold icon-btn-danger ">
                                <i class="fas fa-undo-alt fs-5 text-white m-0 p-0"></i>
                            </span>
                        </a>

                        <a class="btn btn-sm btn-success  fw-bold " id="btnGuardarProducto" style="position: relative; width: 160px;" onclick="fnc_ActualizarStock('{{ $producto->codigo_productos }}', '{{ $accion }}');">
                            <span class="text-button">GUARDAR</span>
                            <span class="btn fw-bold icon-btn-success ">
                                <i class="fas fa-save fs-5 text-white m-0 p-0"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Actualizar el cálculo del nuevo stock al cambiar la cantidad
        $("#iptStockSumar").keyup(function() {
            fnc_CalcularNuevoStock();
        });
    });

    // Función para calcular el nuevo stock basado en la acción de aumento o disminución
    function fnc_CalcularNuevoStock() {
        const accion = '{{ $accion }}';
        const stockActual = parseFloat($("#stock_Stock").html());
        const cantidad = parseFloat($("#iptStockSumar").val());

        if (!isNaN(cantidad) && cantidad > 0) {
            const nuevoStock = accion === 'aumentar_stock' ? stockActual + cantidad : stockActual - cantidad;

            if (accion === 'disminuir_stock' && nuevoStock < 0) {
                Swal.fire('Error', 'La cantidad a disminuir no puede ser mayor al stock actual.', 'error');
                $("#iptStockSumar").val('');
                $("#stock_NuevoStock").html(stockActual);
            } else {
                $("#stock_NuevoStock").html(nuevoStock);
            }
        } else {
            $("#stock_NuevoStock").html(stockActual);
        }
    }

    // Función para actualizar el stock en el servidor
    function fnc_ActualizarStock(codigoProducto, accion) {
        const cantidad = parseFloat($("#iptStockSumar").val());
        const nuevoStock = parseFloat($("#stock_NuevoStock").html());

        if (isNaN(cantidad) || cantidad <= 0) {
            Swal.fire('Error', 'Ingrese un valor mayor a 0', 'error');
            return;
        }

        $.ajax({
            url: '{{ route("producto.actualizar_stock") }}',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                codigo_producto: codigoProducto,
                accion: accion,
                cantidad: cantidad,
                nuevo_stock: nuevoStock
            },
            success: function(response) {
                Swal.fire({
                    icon: response.tipo_msj,
                    title: response.msj
                });
                if (response.tipo_msj === "success") {
                    fnc_LimpiarControles();
                    fnc_RegresarListadoProductos();
                }
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON ? xhr.responseJSON.msj : 'No se pudo actualizar el stock', 'error');
            }
        });
    }

    // Función para limpiar los controles de entrada
    function fnc_LimpiarControles() {
        $("#iptStockSumar").val('');
        $("#stock_NuevoStock").html($("#stock_Stock").html());
    }
    function CargarContenido(vista, contenedor) {
            $.ajax({
                url: '{{ url('/cargar-contenido') }}', // Correct URL setup for Laravel
                type: 'GET',
                data: {
                    contenido: vista
                },
                success: function(response) {
                    $('.' + contenedor).html(response);
                },
                error: function(xhr) {
                    console.error('Error loading content. Status:', xhr.status, 'Error:', xhr
                        .statusText);
                }
            });
        }
    function fnc_RegresarListadoProductos(){
        fnc_LimpiarControles();
        CargarContenido('producto', 'content-wrapper');
    }

</script>
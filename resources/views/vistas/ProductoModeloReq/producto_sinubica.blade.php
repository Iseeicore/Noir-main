<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Producto</h2>
            </div><!-- /.col -->
            <div class="col-sm-6  d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Registro de Producto</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-gray shadow mt-3">
                    <div class="card-body px-3 py-3" style="position: relative;">
                        <span class="titulo-fieldset px-3 py-1">CRITERIOS DE BÚSQUEDA </span>

                        <div class="row my-2">
                            <div class="col-12 col-lg-4 mb-2">
                                <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-layer-group mr-1 my-text-color"></i>Categorías</label>
                                <select data-index="5" class="form-select" id="id_categoria_busqueda" aria-label="Floating label select example" required>
                                </select>
                            </div>
                            <div class="col-12 col-lg-8 mb-2">
                                <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-gifts mr-1 my-text-color"></i>Producto</label>
                                <input data-index="6" type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="iptProducto" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="col-12 col-lg-3 mb-2">
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
        </div>

        <div class="card card-gray shadow mt-3">

            <div class="card-body px-3 py-3" style="position: relative;">

                <span class="titulo-fieldset px-3 py-1">LISTADO DE PRODUCTOS </span>

                <!-- row para listado de productos-->
                <div class="row my-2">

                    <div class="col-lg-12">

                        <table id="tbl_productos" class="table w-100 shadow border responsive border-secondary display">
                            <thead class="bg-main">
                                <tr style="font-size: 15px;">
                                    <th class="text-center">Op.</th> <!-- 0: acciones -->
                                    <th>ID</th> <!-- 1: id -->
                                    <th>Codigo</th> <!-- 2: codigo_productos -->
                                    <th>Id Categoria</th> <!-- 3: id_categorias -->
                                    <th>Categoría</th> <!-- 4: nombre_categoria -->
                                    <th>Producto</th> <!-- 5: producto -->
                                    <th>Id Unidad Medida</th> <!-- 6: id_unidad_medida -->
                                    <th>Unidad Medida</th> <!-- 7: unidad_medida -->
                                    <th>Imagen</th> <!-- 8: imagen -->
                                    <th>Min. Stock</th> <!-- 9: minimo_stock -->
                                    <th>Estado</th> <!-- 10: estado -->
                                </tr>
                            </thead>
                            <tbody class="text-small">
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<script>
    var table;
$(document).ready(function() {
    inicializarDataTable(); // Inicialización de DataTable
    cargarCategorias();
});

// Función para inicializar DataTable
function inicializarDataTable() {
    table = $('#tbl_productos').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                text: '<i class="fas fa-sync-alt"></i>',
                className: 'bg-secondary',
                action: function(e, dt, node, config) {
                    table.ajax.reload();
                }
            },
            {
                text: 'Crear Nuevo Producto',
                className: 'addNewRecord',
                action: function(e, dt, node, config) {
                    cargarRegistroProducto(); // Llama a la función para cargar la vista de registro

                }
            },
            {
                extend: 'excel',
                title: function() {
                    return 'LISTADO DE PRODUCTOS';
                }
            },
            {
                extend: 'print',
                title: function() {
                    return 'LISTADO DE PRODUCTOS';
                }
            },
            'pageLength'
        ],
        ajax: {
            url: '{{ route("productos.listar") }}', // Ruta para obtener los datos
            type: 'GET',
            dataType: 'json',
            dataSrc: '' // DataTables usará directamente el array de datos JSON
        },
        columns: [
            { data: 'opciones', className: 'text-center' },      // Espacio para acciones
            { data: 'id', className: 'dt-center' },              // ID
            { data: 'codigo_productos', className: 'dt-center' },// Código del producto
            { data: 'id_categorias', className: 'dt-center' },   // ID de categoría
            { data: 'nombre_categoria', className: 'dt-center' },// Nombre de la categoría
            { data: 'producto', className: 'dt-center' },        // Descripción del producto
            { data: 'id_unidad_medida', className: 'dt-center' },// ID de unidad de medida
            { data: 'unidad_medida', className: 'dt-center' },   // Unidad de medida
            { data: 'imagen', className: 'dt-center' },          // Imagen
            { data: 'minimo_stock', className: 'dt-center' },    // Mínimo stock
            { data: 'estado', className: 'dt-center' }           // Estado
        ],
        responsive:{
            details:{
                type:'column',
            }
        },
        columnDefs: [
        {
            targets: 0,
            orderable: false,
            createdCell: function(td, cellData, rowData, row, col) {
                let dropdownHtml = `
                    <div class="btn-group">
                        <button class="btn btn-sm dropdown-toggle p-0 m-0 my-text-color fs-5" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-list-alt"></i>
                        </button>
                        <div class="dropdown-menu">`;

                // Opción para editar el producto
                dropdownHtml += `
                    <a class="dropdown-item btnEditarProductoModeloreq" style='cursor:pointer;' onclick="fnc_EditarProductoModeloreq('` + rowData["id"] + `');">
                        <i class='fas fa-pencil-alt fs-6 text-primary mr-2'></i> 
                        <span class='my-color'>Editar</span>
                    </a>`;

                // Condición para activar o desactivar según el estado
                if (rowData['estado'] === 'INACTIVO') {
                    dropdownHtml += `
                        <a class="dropdown-item btnActivarProductoModeloreq" style='cursor:pointer;' onclick="fnc_ActivarProductoModeloreq('` + rowData["id"] + `');">
                            <i class='fas fa-toggle-off fs-6 text-danger mr-2'></i> 
                            <span class='my-color'>Activar</span>
                        </a>`;
                } else {
                    dropdownHtml += `
                        <a class="dropdown-item btnDesactivarProductoModeloreq" style='cursor:pointer;' onclick="fnc_DesactivarProductoModeloreq('` + rowData["id"] + `');">
                            <i class='fas fa-toggle-on fs-6 text-success mr-2'></i> 
                            <span class='my-color'>Desactivar</span>
                        </a>`;
                }

                // Cerrar el menú desplegable
                dropdownHtml += `</div></div>`;

                // Insertar el HTML en la celda
                $(td).html(dropdownHtml);
        }
    },
    {
        targets: 10,
        "width": "5%",
        createdCell: function(td, cellData, rowData, row, col) {

            if (rowData.estado == 'ACTIVO') {
                $(td).html('<span class="bg-success px-2 py-1 rounded-pill fw-bold"> ' + rowData.estado + ' </span>')
            }

            if (rowData.estado == 'INACTIVO') {
                $(td).html('<span class="bg-danger px-2 py-1 rounded-pill fw-bold"> ' + rowData.estado + ' </span>')
            }

        }
    },
    {
        targets: 8, // Imagen
        createdCell: function(td, cellData, rowData, row, col) {
            if (rowData['imagen'] && rowData['imagen'] !== 'NoImagen') {
                $(td).html('<img src="{{ asset("storage/assets/imagenes/productos") }}/' + rowData['imagen'] + '" class="zoom rounded-pill border text-center border-secondary" style="object-fit: cover; width: 40px; height: 40px; transition: transform .5s; overflow: hidden; z-index:100000" alt="">');
            } else {
                $(td).html('<img src="/assets/imagenes/no_image.jpg" class="rounded-pill border text-center border-secondary" style="object-fit: cover; width: 40px; height: 40px;" alt="">');
            }
        }
    }
],

        // scrollX: true,
        language: {
            url: 'assets/languages/Spanish.json'
        }
    });
}
function cargarCategorias() {
    $.ajax({
        url: '{{ route("listar_categorias") }}', // Ruta para obtener la lista de categorías
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('#id_categoria_busqueda');
            select.empty();
            select.append('<option value="">-- Todas las Categorías --</option>'); // Opción para todas
            data.forEach(function(categoria) {
                select.append('<option value="' + categoria.nomb_cate + '">' + categoria.nomb_cate + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar categorías:', error);
        }
    });
}
        // Filtro para categorías
        $("#id_categoria_busqueda").change(function() {
            var valorCategoria = $(this).val(); 
            table.column(4).search(valorCategoria).draw();
        });
        $("#iptProducto").keyup(function () {
            table.column(5).search(this.value).draw();
        });

    $("#btnlimpiar").on('click', function () {
        $("#id_categoria_busqueda").val('');
        $("#iptProducto").val('');
        table.search('').columns().search('').draw();
    });
    
    function fnc_EditarProductoModeloreq(id_producto, contenido = 'ProductoModeloReq/editar_productosinubic', contenedor = 'content-wrapper'){
            $.ajax({
            url: '/cargar-contenido',  // URL de la ruta para cargar contenido
            type: 'GET',
            data: {
                contenido: contenido,   // Vista que queremos cargar
                id_de_paso: id_producto  // ID del producto (o el dato que necesites)
            },
            success: function(data) {
                // Reemplaza el contenido solo en el contenedor especificado
                $("." + contenedor).html(data);

                // Si usas select2 u otros componentes, reinicialízalos aquí
                if ($('.select2').length) {
                    $('.select2').select2();
                }
            },
            error: function(error) {
                console.log("Error al cargar la página", error);
                alert("Hubo un error al cargar el contenido. Inténtelo de nuevo.");
            }
        });
    }

    function fnc_DesactivarProductoModeloreq(idProducto) {
    Swal.fire({
        title: '¿Está seguro de desactivar este producto?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, desactivar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/productomodelo/desactivar/' + idProducto,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire('Desactivado', response.msj, 'success');
                    $('#tbl_productos').DataTable().ajax.reload(); // Recargar tabla
                },
                error: function(xhr) {
                    Swal.fire('Error', 'No se pudo desactivar el producto.', 'error');
                }
            });
        }
    });
}

// Función para activar el producto
function fnc_ActivarProductoModeloreq(idProducto) {
    Swal.fire({
        title: '¿Está seguro de activar este producto?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, activar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/productomodelo/activar/' + idProducto,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire('Activado', response.msj, 'success');
                    $('#tbl_productos').DataTable().ajax.reload(); // Recargar tabla
                },
                error: function(xhr) {
                    Swal.fire('Error', 'No se pudo activar el producto.', 'error');
                }
            });
        }
    });
}
function cargarRegistroProducto() {
        cargarPlantilla('ProductoModeloReq/register_porductosinubic', 'content-wrapper', function() {
        inicializarVistaRegistrarProducto(); // Inicializar lógica específica de la vista
    });
}



</script>

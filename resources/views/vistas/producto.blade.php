<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Inventario / Productos</h2>
            </div><!-- /.col -->
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Inventario / Productos</li>
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

        <div class="card card-gray shadow mt-3">

            <div class="card-body px-3 py-3" style="position: relative;">

                <span class="titulo-fieldset px-3 py-1">LISTADO DE PRODUCTOS </span>

                <!-- row para listado de productos/inventario -->
                <div class="row my-2">

                    <div class="col-lg-12">

                        <table id="tbl_productos" class="table w-100 shadow border responsive border-secondary display">
                            <thead class="bg-main">
                                <tr style="font-size: 15px;">
                                    <th> </th> <!-- 0: detalle -->
                                    <th class="text-center">Icon.</th> <!-- 1: acciones -->
                                    <th>ID</th> <!-- 2: id -->
                                    <th>Codigo</th> <!-- 3: codigo_productos -->
                                    <th>Id Categoria</th> <!-- 4: id_categorias -->
                                    <th>Categoría</th> <!-- 5: nombre_categoria -->
                                    <th>Producto</th> <!-- 6: producto -->
                                    <th>Almacén</th> <!-- 7: almacen -->
                                    <th>Imagen</th> <!-- 8: imagen -->
                                    <th>Id Tipo Afec. IGV</th> <!-- 9: id_tipo_afectacion_igv -->
                                    <th>Tipo Afec. IGV</th> <!-- 10: tipo_afectacion_igv -->
                                    <th>Id Unidad Medida</th> <!-- 11: id_unidad_medida -->
                                    <th>Unidad Medida</th> <!-- 12: unidad_medida -->
                                    <th>Costo Unit.</th> <!-- 13: costo_unitario -->
                                    <th>Precio C/IGV</th> <!-- 14: precio_unitario_con_igv -->
                                    <th>Precio S/IGV</th> <!-- 15: precio_unitario_sin_igv -->
                                    <th>Stock</th> <!-- 16: stock -->
                                    <th>Min. Stock</th> <!-- 17: minimo_stock -->
                                    <th>Costo Total</th> <!-- 19: costo_total -->
                                    <th>Estado</th> <!-- 22: estado -->
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

$(document).ready(function() {
    inicializarDataTable(); // Inicialización de DataTable
    cargarAlmacenes();
    cargarCategorias();

});
function CargarContenido(vista, contenedor) {
    $.ajax({
        url: '{{ url("/cargar-contenido") }}', // Correct URL setup for Laravel
        type: 'GET',
        data: { contenido: vista },
        success: function(response) {
            $('.' + contenedor).html(response);
        },
        error: function(xhr) {
            console.error('Error loading content. Status:', xhr.status, 'Error:', xhr.statusText);
        }
    });
}

function cargarAlmacenes() {
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
function fnc_EditarProducto(id_producto, contenido = 'modulosProducto/editar', contenedor = 'content-wrapper') {
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

// Función para mostrar la vista modal de actualizar stock
function fnc_ActualizarStock(idProducto, accion) {
    $.ajax({
        url: '/producto/actualizar-stock/' + idProducto + '/' + accion,
        type: 'GET',
        success: function(data) {
            $(".content-wrapper").html(data);
        },
        error: function(xhr) {
            console.error('Error al cargar la vista de actualización de stock:', xhr);
            alert("Hubo un error al cargar el contenido. Inténtelo de nuevo.");
        }
    });
}

function fnc_DesactivarProducto(idProducto) {
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
                url: '/producto/desactivar/' + idProducto,
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
function fnc_ActivarProducto(idProducto) {
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
                url: '/producto/activar/' + idProducto,
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
function inicializarDataTable() {
    var table;

    table = $('#tbl_productos').DataTable({
        dom: 'Bfrtip',
            buttons: [{
                    text: '<i class="fas fa-sync-alt"></i>',
                    className: 'bg-secondary',
                    action: function(e, dt, node, config) {
                        //
                    }
                },
                // {
                //     text: 'Agregar Producto',
                //     className: 'addNewRecord',
                //     action: function(e, dt, node, config) {
                //         CargarContenido('modulosProducto/registrar', 'content-wrapper')
                //     }
                // },
                {
                    extend: 'excel',
                    title: function() {
                        var printTitle = 'LISTADO DE PRODUCTOS';
                        return printTitle
                    }
                },
                {
                    extend: 'print',
                    title: function() {
                        var printTitle = 'LISTADO DE PRODUCTOS';
                        return printTitle
                    }
                }, 'pageLength'
            ],
        ajax: {
            url: '{{ route("listar_productos") }}', // Ruta del servidor para obtener los datos
            type: 'GET',
            dataType: 'json',
            dataSrc: '' // DataTables tomará el array de objetos JSON directamente
        },
        columns: [
            { data: 'detalle', defaultContent: '' },         // 0: detalle vacío
            { data: 'acciones', className: 'text-center' },  // 1: acciones
            { data: 'id', className: 'dt-center' },                                  // 2: id
            { data: 'codigo_productos', className: 'dt-center' },                    // 3: codigo_productos
            { data: 'id_categorias', className: 'dt-center' },                       // 4: id_categorias
            { data: 'nombre_categoria', className: 'dt-center' },                    // 5: nombre_categoria
            { data: 'producto', className: 'dt-center' },                            // 6: producto
            { data: 'almacen', className: 'dt-center' },                             // 7: almacen
            { data: 'imagen', className: 'dt-center' },                              // 8: imagen
            { data: 'id_tipo_afectacion_igv', className: 'dt-center' },              // 9: id_tipo_afectacion_igv
            { data: 'tipo_afectacion_igv', className: 'dt-center' },                 // 10: tipo_afectacion_igv
            { data: 'id_unidad_medida', className: 'dt-center' },                    // 11: id_unidad_medida
            { data: 'unidad_medida', className: 'dt-center' },                       // 12: unidad_medida
            { data: 'costo_unitario', className: 'dt-center' },                      // 13: costo_unitario
            { data: 'precio_unitario_con_igv', className: 'dt-center' },             // 14: precio_unitario_con_igv
            { data: 'precio_unitario_sin_igv', className: 'dt-center' },             // 15: precio_unitario_sin_igv
            { data: 'stock', className: 'dt-center' },                               // 16: stock
            { data: 'minimo_stock', className: 'dt-center' },                        // 17: minimo_stock                           // 18: ventas
            { data: 'costo_total', className: 'dt-center' },                         // 18: costo_total
            { data: 'estado', className: 'dt-center' }                               // 19: estado                             // 22: estado
        ],
        responsive:{
            details:{
                type:'column',
            }
        },
        columnDefs: [
            {
                targets:0,
                orderable: false,
                className:'control'
            },
            {
                targets: [2, 4, 9, 14, 15],
                visible: false // Ocultar columnas inicialmente
            },
            {
                targets: 17,
                createdCell: function (td,cellData,rowData,row,col) {
                    if (parseFloat(rowData['stock']) <= parseFloat(rowData['minimo_stock'])) {
                            $(td).parent().css('background', '#F2D7D5')
                            $(td).parent().css('color', 'black')
                        }
                }
            },
            {
                targets: 8,
                createdCell: function(td, cellData, rowData, row, col) {
                    if (rowData['imagen'] != 'NoImagen') {
                        $(td).html('<img src="' + "{{ asset('storage/assets/imagenes/productos') }}" + '/' + rowData['imagen'] + '" class="zoom rounded-pill border text-center border-secondary" style="object-fit: cover; width: 40px; height: 40px; transition: transform .5s;overflow:hidden; z-index:100000" alt="">');
                        $(td).css('overflow', 'hidden')
                    }
                    else {
                        $(td).html('<img src="/assets/imagenes/no_image.jpg" class="rounded-pill border text-center border-secondary" style="object-fit: cover; width: 40px; height: 40px;" alt="">');
                    }
                }
            },
            // {
            //     targets: 1,
            //     orderable: false,
            //     createdCell: function(td, cellData, rowData, row, col) {
            //         let dropdownHtml = `
            //             <div class="btn-group">
            //                 <button class="btn btn-sm dropdown-toggle p-0 m-0 my-text-color fs-5" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            //                     <i class="fas fa-list-alt"></i>
            //                 </button>
            //                 <div class="dropdown-menu">
            //                     <a class="dropdown-item btnEditarProducto" style='cursor:pointer;' onclick="fnc_EditarProducto('` + rowData["id"] + `');">
            //                         <i class='fas fa-pencil-alt fs-6 text-primary mr-2'></i> 
            //                         <span class='my-color'>Editar</span>
            //                     </a>`;

            //         // Validación del costo_unitario para agregar opciones de ajuste de stock
            //         if (parseInt(rowData['costo_unitario']) > 0) {
            //             dropdownHtml += `
            //                 <a class="dropdown-item btnAumentarStock" style='cursor:pointer;' onclick="fnc_ActualizarStock('` + rowData["id"] + `', 'aumentar_stock');">
            //                     <i class='fas fa-plus-circle fs-6 mr-2 text-success'></i> 
            //                     <span class='my-color'>Aumentar Stock</span>
            //                 </a>
            //                 <a class="dropdown-item btnDisminuirStock" style='cursor:pointer;' onclick="fnc_ActualizarStock('` + rowData["id"] + `', 'disminuir_stock');">
            //                     <i class='fas fa-minus-circle fs-6 mr-2 text-warning'></i> 
            //                     <span class='my-color'>Disminuir Stock</span>
            //                 </a>`;
            //         }

            //         // Condición para agregar opciones de activar o desactivar dependiendo del estado
            //         if (rowData['estado'] === 'INACTIVO') {
            //             dropdownHtml += `
            //                 <a class="dropdown-item btnActivarProducto" style='cursor:pointer;' onclick="fnc_ActivarProducto('` + rowData["id"] + `');">
            //                     <i class='fas fa-toggle-off fs-6 text-danger mr-2'></i> 
            //                     <span class='my-color'>Activar</span>
            //                 </a>`;
            //         } else {
            //             dropdownHtml += `
            //                 <a class="dropdown-item btnDesactivarProducto" style='cursor:pointer;' onclick="fnc_DesactivarProducto('` + rowData["id"] + `');">
            //                     <i class='fas fa-toggle-on fs-6 text-success mr-2'></i> 
            //                     <span class='my-color'>Desactivar</span>
            //                 </a>`;
            //         }

            //         // Cerrar el menú desplegable
            //         dropdownHtml += `
            //                 </div>
            //             </div>`;

            //         // Insertar el HTML en la celda
            //         $(td).html(dropdownHtml);
            //     }
            // }

            {
                targets: 1,
                orderable: false,
                createdCell: function(td, cellData, rowData, row, col) {
                    // Agrega el ícono directamente sin funcionalidad de clic
                    let iconHtml = `<i class="fas fa-list-alt text-secondary fs-5"></i>`;
                    $(td).html(iconHtml);
                }
            }
        ],
        language: {
            url: 'assets/languages/Spanish.json' // Ruta al archivo de idioma en español
        }
    });
    
    $("#id_almacen_busqueda").change(function() {
        var valorAlmacen = $(this).val();
        table.column($(this).data('index')).search(valorAlmacen).draw();
    });
      // Filtro para categorías
      $("#id_categoria_busqueda").change(function() {
        var valorCategoria = $(this).val();
        table.column($(this).data('index')).search(valorCategoria).draw();
    });
    // Filtro para nombre de producto
    $("#iptProducto").keyup(function () {
        table.column($(this).data('index')).search(this.value).draw();
    });







    $("#btnlimpiar").on('click', function () {
        $("#iptCodigoProd").val('');
        $("#id_almacen_busqueda").val('');
        $("#id_categoria_busqueda").val('');
        $("#iptProducto").val('');
        table.search('').columns().search('').draw();
    });


    $.ajax({
        url: '{{ route("listar_productos") }}',
        type: 'GET',
        dataType: 'json',
        success: function(response) {

        },
        error: function(xhr, status, error) {
            console.error('Error al listar productos:', error);
        }
    });
    

}

</script>

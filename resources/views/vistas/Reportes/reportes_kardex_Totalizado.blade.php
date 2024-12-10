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

        <!-- row para criterios de busqueda -->
        <div class="row">

            <div class="col-md-12">

                <table id="tbl_kardex" class="table shadow border border-secondary" style="width:100%">
                    <thead class="bg-main text-left">
                        <th></th>
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
    fnc_CargarDataTableKardex();
});

function fnc_CargarDataTableKardex() {
    if ($.fn.DataTable.isDataTable('#tbl_kardex')) {
        $('#tbl_kardex').DataTable().destroy();
        $('#tbl_kardex tbody').empty();
    }

    let table = $('#tbl_kardex').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                title: 'KARDEX / INVENTARIO'
            },
            'pageLength'
        ],
        pageLength: 10,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: "{{ route('reporte.kardex.totalizado') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            }
        },
        scrollX: true,
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                className: 'details-control',
                render: function() {
                    return '<i class="fa fa-plus-circle"></i>';
                }
            },
            {
                className: 'dt-center',
                targets: '_all'
            }
        ],
        language: {
            url: 'assets/languages/Spanish.json'
        }
    });

    $('#tbl_kardex tbody').on('click', 'td.details-control', function() {
    let tr = $(this).closest('tr');
    let row = table.row(tr);

    if (row.child.isShown()) {
        // Cierra la fila expandida
        row.child.hide();
        tr.find('i.fa').removeClass('fa-minus-circle').addClass('fa-plus-circle');
    } else {
        // Abre la fila y carga los datos adicionales
        let codigoProducto = row.data()[1]; // Cod. Producto está en la columna 1
        let almacen = row.data()[3]; // Nombre del almacén está en la columna 3
        
        $.ajax({
            url: "{{ route('reporte.kardex.detalles') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                codigo_producto: codigoProducto,
                almacen: almacen // Enviar el ID del almacén
            },
            success: function(response) {
                // Agregamos el campo 'almacen' al detalle HTML
                let detalleHtml = '<table class="table table-sm"><tr><th>Código Producto</th><th>Fecha</th><th>Concepto</th><th>Almacén</th></tr>';
                response.data.forEach(function(item) {
                    detalleHtml += `<tr>
                        <td>${item.codigo_producto}</td>
                        <td>${item.fecha}</td>
                        <td>${item.concepto}</td>
                        <td>${item.almacen}</td> <!-- Muestra el nombre del almacén -->
                    </tr>`;
                });
                detalleHtml += '</table>';

                // Muestra la fila expandida con el contenido
                row.child(detalleHtml).show();
                tr.find('i.fa').removeClass('fa-plus-circle').addClass('fa-minus-circle');
            }
        });
    }
});

}



</script>
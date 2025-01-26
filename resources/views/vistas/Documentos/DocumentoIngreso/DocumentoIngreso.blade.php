<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Listado de Documento Ingreso</h2>
            </div>
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Listado Doc. Ingreso</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">

    <div class="container-fluid">

        <div class="card card-gray shadow mt-4">

            <div class="card-body px-3 py-3" style="position: relative;">

                <span class="titulo-fieldset px-3 py-1">LISTADO DE Documentos de Ingresos</span>

                <div class="row my-3">

                    <div class="col-12">
                        <table id="tbl_DocumentoIngreso" class="table table-striped w-100 shadow border border-secondary">
                            <thead class="bg-main text-left">
                                <tr>
                                    <th>Op.</th>
                                    <th>ID</th>
                                    <th>Fecha Emisión</th>
                                    <th>Periodo</th>
                                    <th>Operación</th>
                                    <th>Proveedor</th>
                                    <th>Almacén</th>
                                    <th>Comprobante</th>
                                    <th>Moneda</th>
                                    <th>Total Efectivo</th>
                                    <th>Usuario</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>

            </div>

        </div>

    </div>


</div>
<script>
    $(document).ready(function() {
        fnc_CargarDatatableDocumentoIngreso();
    });
    function fnc_CargarDatatableDocumentoIngreso() {
        if ($.fn.DataTable.isDataTable('#tbl_DocumentoIngreso')) {
            $('#tbl_DocumentoIngreso').DataTable().destroy();
            $('#tbl_DocumentoIngreso tbody').empty();
            $('[data-bs-toggle="tooltip"]').tooltip();
        }

        $("#tbl_DocumentoIngreso").DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Generar Documento Ingreso',
                    className: 'addNewRecord',
                    action: function(e, dt, node, config) {
                        cargarPlantilla('Documentos/DocumentoIngreso/CreacionDocumentoIngreso','content-wrapper')
                    }
                },
                {
                    extend: 'excel',
                    title: 'LISTADO DE DOCUMENTOS DE INGRESO'
                },
                'pageLength'
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('listar.documentos') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.usuario_id = "{{ Auth::user()->id_usuario }}";
                }
            },
            columns: [
                { data: 'opciones', orderable: false, searchable: false },
                { data: 'id' },
                { data: 'fecha_emision' },
                { data: 'periodo' },
                { data: 'tipo_operacion' },
                { data: 'proveedor' },
                { data: 'almacen' },
                { data: 'comprobante_pago' },
                { data: 'moneda_origen' },
                { data: 'total_efectivo' },
                { data: 'usuario' },
            ],
            columnDefs: [
                { className: "dt-center", targets: "_all" },
                {
                targets: 0, // Columna de opciones
                "width": "10%",
                sortable: false,
                render: function(data, type, full, meta) {

                    let opciones = `<center>`;

                         // Botón para observar requerimiento
                opciones += `
                    <span class='btnObservar text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Observar Requerimiento' onclick="visualizarDocumentoIngreso(${full.id})">
                        <i class='fas fa-eye fs-5'></i>
                    </span>`;

                                opciones += `</center>`;
                    return opciones;
                }
            },
            ],

            language: {
                url: 'assets/languages/Spanish.json'
            }
        });
    }
    function visualizarDocumentoIngreso(id, contenido = 'Documentos/DocumentoIngreso/VerDocumentoIngreso', contenedor = 'content-wrapper') {
        $.ajax({
            url: '/cargar-contenido',  // URL de la ruta para cargar contenido
            type: 'GET',
            data: {
                contenido: contenido,   // Vista que queremos cargar
                id_de_paso: id  // ID del producto (o el dato que necesites)
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

</script>
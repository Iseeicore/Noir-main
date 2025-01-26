<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">DOCUMENTO REQUERIMIENTO</h2>
            </div><!-- /.col -->
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                    <li class="breadcrumb-item active">Documento de Requerimiento</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">

    <div class="container-fluid">

        <div class="card card-gray shadow mt-4">

            <div class="card-body px-3 py-3" style="position: relative;">

                <span class="titulo-fieldset px-3 py-1">LISTADO DE REQUERIMIENTO</span>

                <div class="row my-3">

                    <div class="col-12">
                        <table id="tbl_DocRequerimiento" class="table table-striped w-100 shadow border border-secondary">
                            <thead class="bg-main text-left">
                                <th>Op.</th>
                                <th>Id</th>
                                <th>Codigo</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Zona Socilicitante</th>
                                <th>Solicitante</th>
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
        fnc_CargarDatatableProveedores();
    });
    function fnc_CargarDatatableProveedores() {
        if ($.fn.DataTable.isDataTable('#tbl_DocRequerimiento')) {
            $('#tbl_DocRequerimiento').DataTable().destroy();
            $('#tbl_DocRequerimiento tbody').empty();
            $('[data-bs-toggle="tooltip"]').tooltip();
        }

        $("#tbl_DocRequerimiento").DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Generar Requerimiento',
                    className: 'addNewRecord',
                    action: function(e, dt, node, config) {
                        cargarPlantilla('Documentos/requerimientoExtras/CreacionRequerimiento','content-wrapper')
                    }
                },
                {
                    extend: 'excel',
                    title: 'LISTADO DE PROVEEDORES'
                },
                'pageLength'
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('requerimiento.listar') }}",  // Ruta de tu controlador
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',  // Token CSRF
                    usuario_id: '{{ Auth::user()->id_usuario }}' // Enviar el ID del usuario autenticado
                }
            },
            columns: [
                { data: 'opciones', orderable: false, searchable: false },
                { data: 'id' },
                { data: 'codigo' },
                { data: 'fecha' },
                { data: 'estado' },
                { data: 'zona_solicitante' },
                { data: 'solicitante' }
            ],
            scrollX: true,
            columnDefs: [
                { className: "dt-center", targets: "_all" },
                // {
                // // Ocultar las columnas de dirección y email
                // targets: [7, 8], // Índices de columnas a ocultar
                // visible: false,
                // searchable: false // También puede desactivar la búsqueda en estas columnas si no se necesita
                // },
                {
                    targets: 0,
                    "width": "10%",
                    sortable: false,
                    render: function(data, type, full, meta) {
                        let opciones = `<center>`;

                        switch (full.estado) {
                            case 0: // Estado Inactivo
                                opciones += `
                                    <span class='text-muted'>
                                        Por el momento no hay opciones disponibles
                                    </span>`;
                                break;

                            case 1: // Estado Revicion
                            opciones += `
                                    <span class='btnObservar text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Observar Requerimiento' onclick="visualizarRequerimiento(${full.id})">
                                        <i class='fas fa-eye fs-5'></i>
                                    </span>`;
                                break;

                            case 2: // Otros estados visibles para "Observar"
                                opciones += `
                                    <span class='btnObservar text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Observar Requerimiento' onclick="visualizarRequerimiento(${full.id})">
                                        <i class='fas fa-eye fs-5'></i>
                                    </span>`;
                                break;

                            case 3: // Estado Mejorar
                                opciones += `
                                    <span class='btnObservar text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Observar Requerimiento' onclick="visualizarRequerimiento(${full.id})">
                                        <i class='fas fa-eye fs-5'></i>
                                    </span>
                                    <span class='btnEditarProveedor text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Editar Requerimiento' onclick="editarRequerimiento(${full.id})">
                                        <i class='fas fa-pencil-alt fs-5'></i>
                                    </span>`;
                                break;
                            case 4: // Cancelado
                            opciones += `
                                <span class='text-muted'>
                                    Contáctese con logística
                                </span>
                                <span class='btnObservar text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Observar Requerimiento' onclick="visualizarRequerimiento(${full.id})">
                                        <i class='fas fa-eye fs-5'></i>
                                </span>
                                `;
                            break;

                            case 5: // Aceptado
                            opciones += `
                                <span class='text-muted'>
                                    Fue aceptado ✔
                                </span>`;
                                break;

                            case 6: // Cancelado
                            opciones += `
                                <span class='text-muted'>
                                    Ya esta cerrado espera pronto llegara 😀
                                </span>`;
                            break;

                            default: // Cualquier otro estado
                                opciones += `
                                    <span class='text-muted'>
                                        Opciones no disponibles para este estado
                                    </span>`;
                        }

                        opciones += `</center>`;
                        return opciones;
                    }
                },
                {
                    targets: 4,
                    "width": "25%",
                    createdCell: function(td, cellData, rowData, row, col) {
                        let estadoHtml = '';
                        switch (rowData.estado) {
                            case 0: // Inactivo
                                estadoHtml = '<span class="bg-danger px-2 py-1 rounded-pill fw-bold">Enviado Pendiente</span>';
                                break;
                            case 1: // En revisión
                                estadoHtml = '<span class="bg-warning px-2 py-1 rounded-pill fw-bold">EN REVISIÓN</span>';
                                break;
                            case 2: // Recepcionado
                                estadoHtml = '<span class="bg-success px-2 py-1 rounded-pill fw-bold">RECEPCIONADO</span>';
                                break;
                            case 3: // Mejorar
                                estadoHtml = '<span class="bg-info px-2 py-1 rounded-pill fw-bold">MEJORAR</span>';
                                break;
                            case 4: // Cancelado
                                estadoHtml = '<span class="bg-danger px-2 py-1 rounded-pill fw-bold">CANCELADO</span>';
                                break;
                            case 5: //Aceptar
                                estadoHtml = '<span class="bg-success px-2 py-1 rounded-pill fw-bold">Aceptado</span>';
                                break;
                            case 6: // Cerrado
                                estadoHtml = '<span class="bg-secondary px-2 py-1 rounded-pill fw-bold">CERRADO</span>';
                                break;
                            default: // Cualquier otro estado
                        }
                        $(td).html(estadoHtml);
                    }
                },
            ],
            language: {
                url: 'assets/languages/Spanish.json'
            }
        });
    }

    function visualizarRequerimiento(id, contenido = 'Documentos/requerimientoExtras/VerRequerimento', contenedor = 'content-wrapper') {
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
    function editarRequerimiento(id) {
        Swal.fire({
            title: 'Editar Requerimiento',
            text: `Redirigiendo para editar el requerimiento con ID: ${id}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ir a editar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                cargarPlantilla(`Documentos/requerimientoExtras/EditarRequerimiento/${id}`, 'content-wrapper');
            }
        });
    }

</script>
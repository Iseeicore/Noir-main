<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Listado de Documento Salida</h2>
            </div>
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Listado Doc. Salida</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-gray shadow mt-4">
            <div class="card-body px-3 py-3">
                <span class="titulo-fieldset px-3 py-1">LISTADO DE DOCUMENTOS DE SALIDA</span>
                <div class="row my-3">
                    <div class="col-12">
                        <table id="tbl_DocumentoSalida" class="table table-striped w-100 shadow border border-secondary">
                            <thead class="bg-main text-left">
                                <tr>
                                    <th>Op.</th>
                                    <th>ID</th>
                                    <th>Fecha Emisión</th>
                                    <th>Periodo</th>
                                    <th>Operación</th>
                                    <th>Almacén Origen</th>
                                    <th>Almacén Destino</th>
                                    <th>Total Efectivo</th>
                                    <th>Usuario Creador</th>
                                    <th>Usuario Recibe</th>
                                    <th>N° Documento</th>
                                    <th>N° Secundario</th>
                                    <th>Glosario</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalVerificacion" tabindex="-1" aria-labelledby="verificacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-main py-2">
                <h6 class="modal-title" id="verificacionLabel">Verificación de Código</h6>
                <button type="button" class="text-white m-0 px-1 badge badge-pill badge-danger" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="formVerificacion" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <label for="codigoVerificacion">Código de Verificación</label>
                            <input type="text" class="form-control" id="codigoVerificacion" required>
                            <div class="invalid-feedback">Ingrese el código.</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="verificarCodigo()">Verificar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        fnc_CargarDatatableDocumentoSalida();
    });
    function fnc_CargarDatatableDocumentoSalida()
    {
        if ($.fn.DataTable.isDataTable('#tbl_DocumentoSalida')) {
            $('#tbl_DocumentoSalida').DataTable().destroy();
            $('#tbl_DocumentoSalida tbody').empty();
            $('[data-bs-toggle="tooltip"]').tooltip();
        }

        $("#tbl_DocumentoSalida").DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Generar Documento Salida',
                    className: 'addNewRecord',
                    action: function(e, dt, node, config) {
                        cargarPlantilla('Documentos/DocumentoSalida/CreacionDocumentoSalida','content-wrapper')
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
                url: "{{ route('documento-salida.listar') }}", // Ruta al controlador
                type: 'POST',
                data: function (d) {
                    d.usuario_id = {{ auth()->check() ? auth()->user()->id_usuario : 'null' }}; // ID del usuario actual
                    d._token = '{{ csrf_token() }}'; // Token CSRF
                }
            },
            columns: [
                { data: 'opciones', orderable: false, searchable: false },
                { data: 'id' },
                { data: 'fecha_emision' },
                { data: 'periodo' },
                { data: 'tipo_operacion' },
                { data: 'almacen_origen' },
                { data: 'almacen_destino' },
                { data: 'total_efectivo', className: 'text-right' },
                { data: 'usuario_creacion' },
                { data: 'usuario_recibir' },
                { data: 'numerodocumento' },
                { data: 'numerosecundariodocumento' },
                { data: 'glosario' }
            ],
            columnDefs: [
                { className: "dt-center", targets: "_all" },
                {
                    targets: 0, // Columna de opciones
                    "width": "10%",
                    sortable: false,
                    render: function(data, type, full, meta) {
                        let opciones = `<center>`;

                        if (data) { // Si los botones deben mostrarse
                            opciones += `
                                <span class='btnObservar text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Observar Requerimiento' onclick="visualizarDocumentoSalida(${full.id})">
                                    <i class='fas fa-eye fs-5'></i>
                                </span>
                                <span class='btnEditar text-warning px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Editar Requerimiento' onclick="editarDocumentoSalida(${full.id})">
                                    <i class='fas fa-pencil-alt fs-5'></i>
                                </span>
                                <span class='btnEliminar text-danger px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar Requerimiento' onclick="eliminarDocumentoSalida(${full.id})">
                                    <i class='fas fa-trash fs-5'></i>
                                </span>`;
                        }

                        opciones += `</center>`;
                        return opciones;
                    }
                },
            ],

            order: [[1, 'desc']], // Ordenar por ID de manera descendente
            language: {
                url: "{{ asset('assets/languages/Spanish.json') }}" // Ruta al archivo de idioma
            }
        });
    
    }
    function visualizarDocumentoSalida(id, contenido = 'Documentos/DocumentoSalida/VerDocumentoSalida', contenedor = 'content-wrapper') {
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

    function editarDocumentoSalida(id) {
    $('#modalVerificacion').modal('show');
    $('#codigoVerificacion').val('');
    $('#codigoVerificacion').data('accion', 'editar').data('id', id);
    }

    function eliminarDocumentoSalida(id) {
        $('#modalVerificacion').modal('show');
        $('#codigoVerificacion').val('');
        $('#codigoVerificacion').data('accion', 'eliminar').data('id', id);
    }

    function verificarCodigo() {
        const codigoIngresado = $('#codigoVerificacion').val();
        const accion = $('#codigoVerificacion').data('accion');
        const id = $('#codigoVerificacion').data('id');

        // Llamar al servidor para validar el código
        $.ajax({
            url: "{{ route('validar.codigo.acceso') }}", // Ruta al controlador
            type: "POST",
            data: {
                codigo: codigoIngresado,
                _token: '{{ csrf_token() }}', // Token CSRF para la solicitud
            },
            success: function(response) {
                if (response.success) {
                    $('#modalVerificacion').modal('hide'); // Cerrar el modal
                    if (accion === 'editar') {

                        //Logica de editar 
                        cargarPlantilla(`Documentos/DocumentoSalida/EditarDocumentoSalida?id=${id}`, 'content-wrapper');
                    } else if (accion === 'eliminar') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Confirmación',
                            text: '¿Está seguro de eliminar este documento?',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                
                                // Logica de eliminar
                            }
                        });
                    }
                } else {
                    Swal.fire('Error', response.message, 'error'); // Mostrar mensaje de error
                }
            },
            error: function(xhr) {
                Swal.fire('Error', 'Hubo un problema al validar el código. Intente nuevamente.', 'error');
            }
        });
    }



</script>
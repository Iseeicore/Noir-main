@php
    $requerimento = App\Models\RequerimientoHead::find($id_de_paso);
    $usuario = Auth::user(); // Si estás usando Auth para gestionar usuarios.
    $nombreUsuario = $usuario ? "{$usuario->nomb_usuarios} {$usuario->apellidos_usuarios}" : 'Usuario desconocido';
@endphp
@if($requerimento)
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Visualizar Requerimiento</h2>
            </div>
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Requerimiento</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-gray shadow mt-4">
            <div class="card-body px-3 py-3">
                <span class="titulo-fieldset px-3 py-1">INFORMACIÓN DEL REQUERIMIENTO</span>
                <div id="encabezadoRequerimiento" class="row my-2"></div>
            </div>
        </div>

        <div class="card card-gray shadow mt-4">
            <div class="card-body px-3 py-3">
                <span class="titulo-fieldset px-3 py-1">PRODUCTOS SOLICITADOS</span>
                <div class="table-responsive mt-3">
                <table class="table table-bordered shadow border-secondary display" id="tablaProductos">
                    <thead class="bg-main text-center">
                        <tr>
                            <th>N°</th>
                            <th>Nombre del Producto</th>
                            <th>Unidad de Medida</th>
                            <th>Marca/Especificaciones</th>
                            <th>Cantidad</th>
                            <th>Centro de Costo</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="text-center mt-4">
                <!-- Botón de Regresar -->
                <button type="reset" id="btnRegresar" class="btn btn-sm btn-primary deleteRow mx-1"onclick="fnc_RegresarListado()">
                    <i class="fas fa-undo-alt fs-5"></i> Regresar
                </button>
                <button type="button" class="btn btn-primary" onclick="imprimirDocumento()"><i class="fas fa-print"></i> Imprimir</button>

            </div>
        </div>
    </div>
</div>

@else
    <div class="content">
        <div class="container-fluid">
            <div class="alert alert-danger">
                Requerimiento no encontrado.
            </div>
        </div>
    </div>
@endif

<script>
    const nombreUsuario = @json($nombreUsuario);
    $(document).ready(function () {
    const idRequerimiento = {{ $id_de_paso }}; // ID pasado desde el backend

    if (idRequerimiento) {
        cargarRequerimiento(idRequerimiento);
    } else {
        Swal.fire('Error', 'No se recibió un ID válido para el requerimiento.', 'error');
    }

    function cargarRequerimiento(id) {
        $.ajax({
            url: `/requerimiento/${id}`,
            type: 'GET',
            success: function (response) {
                if (response.success) {
                    cargarEncabezado(response.encabezado);
                    cargarDetalles(response.detalles);
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'No se pudo cargar el requerimiento.', 'error');
            }
        });
    }

    function cargarEncabezado(encabezado) {
    $('#encabezadoRequerimiento').html(`
        <div class="row my-2">
            <div class="col-12 col-lg-3 mb-2">
                <label>Código de Requerimiento</label>
                <input type="text" id="codigo_requerimiento" name="codigo_requerimiento" class="form-control form-control-sm" readonly value="${encabezado.cod_req}">
            </div>
            <div class="col-12 col-lg-3 mb-2">
                <label>Fecha de Solicitud</label>
                <input type="date" id="fecha_solicitud" name="fecha_solicitud" class="form-control form-control-sm" readonly value="${encabezado.fecha_req}">
            </div>
            <div class="col-12 col-lg-3 mb-2">
                <label>Área Solicitante</label>
                <input type="text" id="areaSolicitante_usu" name="areaSolicitante_usu" class="form-control form-control-sm" readonly value="${encabezado.encargado && encabezado.encargado.area ? encabezado.encargado.area.descripcion : 'No definido'}">
            </div>
            <div class="col-12 col-lg-3 mb-2">
                <label>Estado del Requerimiento</label>
                <input type="text" class="form-control form-control-sm" readonly value="${encabezado.estado === 1 ? 'Activo' : 'Pendiente'}">
            </div>
        </div>
        <div class="row my-2">
            <div class="col-12 col-lg-3 mb-2">
                <label>Encargado de Solicitud</label>
                <input type="text" id="encargado_solicitud" name="encargado_solicitud" class="form-control form-control-sm" readonly value="${encabezado.encargado ? encabezado.encargado.nomb_usuarios : 'No definido'}">
            </div>
            <div class="col-12 col-lg-3 mb-2">
                <label>Nombre del Solicitante</label>
                <input type="text" id="nombre_solicitante" name="nombre_solicitante" class="form-control form-control-sm" readonly value="${encabezado.solicitante ? encabezado.solicitante.nomb_usuarios + ' ' + encabezado.solicitante.apellidos_usuarios : 'No definido'}">
            </div>
            <div class="col-12 col-lg-6 mb-2">
                <label>Área quien recibe</label>
                <input type="text" id="areaInput" name="areaInput" class="form-control form-control-sm" readonly 
                    value="${encabezado.arearecibida ? encabezado.arearecibida.descripcion : 'No definida'}">
            </div>

        </div>
    `);
}


    function cargarDetalles(detalles) {
            const tbody = $('#tablaProductos tbody');
            tbody.empty();
            detalles.forEach((detalle, index) => {
                tbody.append(`
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td class="text-center">${detalle.nombre_prod}</td>
                        <td class="text-center">${detalle.unidad_medida ? detalle.unidad_medida.nomb_uniMed : 'No definido'}</td>
                        <td class="text-center">${detalle.nombre_marca || 'N/A'}</td>
                        <td class="text-center">${detalle.cantidad}</td>
                        <td class="text-center">${detalle.centro_costo ? detalle.centro_costo.nomb_centroCos : 'No definido'}</td>
                    </tr>
                `);
            });
        }
    });

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

    function fnc_RegresarListado() {

        CargarContenido('Documentos/DocumentosRequerimiento', 'content-wrapper');
    }

    function imprimirDocumento() {
    // Capturar el contenido del encabezado y la tabla
    const encabezado = $('#encabezadoRequerimiento').html();
    const tabla = $('#tablaProductos').clone(); // Clonar la tabla para evitar modificar la original

    // Crear un nuevo documento para la impresión
    const printWindow = window.open('', '_blank');
    printWindow.document.open();
    printWindow.document.write(`
        <html>
        <head>
            <title>Imprimir Documento de Requerimiento - ${nombreUsuario}</title>
            <style>
                /* Ajustar estilos para la impresión */
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                }
                .titulo-fieldset {
                    font-size: 1.25rem;
                    font-weight: bold;
                    padding: 10px;
                    border-bottom: 2px solid #007bff;
                    margin-bottom: 20px;
                    color: #007bff;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    padding: 10px;
                    text-align: center;
                }
                th {
                    background-color: #f8f9fa;
                    font-weight: bold;
                }
                .table-bordered th, .table-bordered td {
                    border: 1px solid #dee2e6;
                }
                .text-center {
                    text-align: center;
                }
                .fw-bold {
                    font-weight: bold;
                }
                .card {
                    margin-bottom: 20px;
                    border: 1px solid #dee2e6;
                    border-radius: 8px;
                }
                .card-header {
                    background-color: #f8f9fa;
                    font-weight: bold;
                    border-bottom: 1px solid #dee2e6;
                    padding: 10px;
                }
                .card-body {
                    padding: 20px;
                }
            </style>
        </head>
        <body>
            <!-- Encabezado -->
            <div class="mb-4 text-center">
                <h2 class="fw-bold">Visualizar Documento Ingreso</h2>
                <p class="text-muted">Información detallada del documento</p>
            </div>

            <!-- Encabezado del Documento -->
            <div class="card">
                <div class="card-header">Información del Documento</div>
                <div class="card-body">
                    ${encabezado}
                </div>
            </div>

            <!-- Detalles del Documento -->
            <div class="card">
                <div class="card-header">Productos Ingresados</div>
                <div class="card-body">
                    <div class="table-responsive">
                        ${tabla[0].outerHTML}
                    </div>
                </div>
            </div>
        </body>
        </html>
    `);
    printWindow.document.close();

    // Imprimir el documento
    printWindow.onload = function () {
        printWindow.print();
        printWindow.close();
    };
}

</script>
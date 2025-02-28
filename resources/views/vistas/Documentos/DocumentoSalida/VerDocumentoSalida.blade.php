@php
    $DocumentoSalida_head = App\Models\DocumentoSalidaHead::find($id_de_paso);
@endphp

@if($DocumentoSalida_head)
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Visualizar Documento Salida</h2>
            </div>
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Documento Salida</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Encabezado del Documento -->
        <div class="card card-gray shadow mt-3">
            <div class="card-body px-3 py-3">
                <span class="titulo-fieldset px-3 py-1">INFORMACIÓN DEL DOCUMENTO</span>
                <div id="encabezadoDocumentoIngreso" class="row my-2"></div>
            </div>
        </div>

        <!-- Detalles del Documento -->
        <div class="card card-gray shadow mt-4">
            <div class="card-body px-3 py-3">
                <span class="titulo-fieldset px-3 py-1">PRODUCTOS Salientes</span>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered shadow border-secondary display" id="tablaProductos">
                        <thead class="bg-main text-center">
                            <tr>
                                <th>N°</th>
                                <th>Producto</th>
                                <th>Unidad Medida</th>
                                <th>Cantidad</th>
                                <th>Centro de Costos</th>
                                <th>Tipo de Afectación(%)</th>
                                <th>Precio Unitario</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="text-center mt-4">
                    <!-- Botón de Guardar -->
                    <button type="reset" class="btn btn-danger" onclick="regresar()"><i class="fas fa-undo-alt"></i> Regresar</button>
                </div>
            </div>
        </div>
    </div>
</div>

@else
<div class="content">
    <div class="container-fluid">
        <div class="alert alert-danger">Documento de ingreso no encontrado.</div>
    </div>
</div>
@endif
<script>
    $(document).ready(function () {
        const idDocumento = {{ $id_de_paso }}; // ID pasado desde el backend

        if (idDocumento) {
            cargarDocumentoSalida(idDocumento);
        } else {
            Swal.fire('Error', 'No se recibió un ID válido para el documento de ingreso.', 'error');
        }
    });

    function cargarDocumentoSalida(id) {
        $.ajax({
            url: `/documento-salida/${id}`,
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
                Swal.fire('Error', 'No se pudo cargar el documento de ingreso.', 'error');
            }
        });
    }

    function cargarEncabezado(encabezado) {
        $('#encabezadoDocumentoIngreso').html(`
            <div class="row my-2">
                <div class="col-12 col-lg-3 mb-2">
                    <label>Código de Documento de Ingreso</label>
                    <input type="text" id="codigo_documento_salida" name="codigo_documento_salida" class="form-control form-control-sm" required readonly value="${encabezado.codigo_head}">
                </div>
                
                <div class="col-12 col-lg-2 mb-2">
                    <label>Fecha Emisión</label>
                    <input type="date" id="fecha_emision" name="fecha_emision" class="form-control form-control-sm" required value="${encabezado.fecha_emision}" readonly>
                </div>
                
                <div class="col-12 col-lg-2 mb-2">
                    <label>Fecha Contable</label>
                    <input type="date" id="fecha_contable" name="fecha_contable" class="form-control form-control-sm" required value="${encabezado.fecha_emision}" readonly>
                </div>
                
                <div class="col-12 col-lg-5 mb-2">
                    <label>Periodo</label>
                    <input type="text" id="periodo" name="periodo" class="form-control form-control-sm" readonly value="${encabezado.periodo}">
                </div>
            </div>
            <div class="row my-2">
                <div class="col-12 col-lg-4 mb-2">
                    <label>Tipo de Operación</label>
                    <input type="text" id="tipo_operacion" name="tipo_operacion" class="form-control form-control-sm" readonly  value="${encabezado.tipo_operacion?.descripcion}">
                </div>
                <div class="col-12 col-lg-2 mb-2">
                    <label>Almacén</label>
                    <input type="text" class="form-control form-control-sm"  id="almacen_nombre" name="almacen_nombre" readonly value="${encabezado.almacen_origen?.nomb_almacen}" >
                    <input type="hidden" id="almacen_id" name="almacen_id">
                </div>

                <div class="col-12 col-lg-2 mb-2">
                    <label>Almacen Destino</label>
                    <input type="text" class="form-control form-control-sm"  id="almacen_id_destino" name="almacen_id_destino" readonly value="${encabezado.almacen_destino?.nomb_almacen}" >
                </div>
                
                <div class="col-12 col-lg-4 mb-2">
                    <label>Usuario recibir</label>
                    <input type="text" class="form-control form-control-sm"  id="UsuarioRecivir" name="UsuarioRecivir" readonly  value="${encabezado.usuario_recibir ? `${encabezado.usuario_recibir.nomb_usuarios} ${encabezado.usuario_recibir.apellidos_usuarios} (${encabezado.usuario_recibir.usuario})` : ''}" >
                </div>

            </div>

            <div class="row my-2">
                <div class="col-12 col-lg-3 mb-2">
                    <label>Número Documento</label>
                    <input type="text" id="numerodocumento" name="numerodocumento" class="form-control form-control-sm" required value="${encabezado.numerodocumento}" readonly  >
                </div>

                <div class="col-12 col-lg-3 mb-2">
                    <label>Número Secundario Documento</label>
                    <input type="text" id="numerosecundariodocumento" name="numerosecundariodocumento" class="form-control form-control-sm" required value="${encabezado.numerosecundariodocumento}" readonly >
                </div>

                <div class="col-12 col-lg-3 mb-2">
                    <label>Glosario</label>
                    <input type="text" id="glosario" name="glosario" class="form-control form-control-sm" readonly value="${encabezado.glosario}" >
                </div>
                <div class="col-12 col-lg-3 mb-2">
                    <label>Total Efectivo</label>
                    <input type="text" id="total_efectivo" name="total_efectivo" class="form-control form-control-sm" readonly  value="${encabezado.Total_efectivo_Compelto}"  >
                </div>
            </div>
        `);
    }

    function cargarDetalles(detalles) {
            const tbody = $('#tablaProductos tbody');
            tbody.empty();

            detalles.forEach((detalles, index) => {
                // Convertir a número si es necesario
                const precioUnitario = parseFloat(detalles.precio_unitario) || 0; // Si es null o no numérico, usar 0
                const total = parseFloat(detalles.total) || 0; // Si es null o no numérico, usar 0

                tbody.append(`
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td class="text-center">${detalles.producto?.descripcion || 'No definido'}</td>
                        <td class="text-center">${detalles.producto.unidad_medida?.nomb_uniMed || 'No definido'}</td>
                        <td class="text-center">${detalles.cantidad}</td>
                        <td class="text-center">${detalles.centro_costo?.nomb_centroCos || 'No definido'}</td>
                        <td class="text-center">${detalles.tipo_afectacion_igv?.porcentaje }</td>
                        <td class="text-center">${precioUnitario.toFixed(2)}</td>
                        <td class="text-center">${total.toFixed(2)}</td>
                    </tr>
                `);
            });
        }




function regresar(){
        cargarPlantilla('Documentos/DocumentoSalida/DocumentoSalida','content-wrapper'); // Recarg
    }
</script>
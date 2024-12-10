<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">CREACION REQUERIMIENTO</h2>
            </div><!-- /.col -->
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                    <li class="breadcrumb-item active">Creacion de Requerimiento</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<form id="frm-datos-requerimiento" method="POST" onsubmit="return false;">
    @csrf
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Información del Requerimiento -->
                    <div class="card card-gray shadow mt-3">
                        <div class="card-body px-3 py-3">
                            <span class="titulo-fieldset px-3 py-1">INFORMACIÓN DEL REQUERIMIENTO</span>
                            <div class="row my-2">
                                <input type="hidden" name="id_usuario" value="{{ auth()->user()->id_usuario }}">
                                <div class="col-12 col-lg-3 mb-2">
                                    <label>Código de Requerimiento</label>
                                    <input type="text" id="codigo_requerimiento" name="codigo_requerimiento" class="form-control form-control-sm" required readonly>
                                </div>                                
                                <div class="col-12 col-lg-3 mb-2">
                                    <label>Fecha de Solicitud</label>
                                    <input type="date"id="fecha_solicitud" name="fecha_solicitud" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-12 col-lg-3 mb-2">
                                    <label>Área Solicitante</label>
                                    <input type="text" id="areaSolicitante_usu"name="areaSolicitante_usu" class="form-control form-control-sm"readonly required>
                                </div>
                                <div class="col-12 col-lg-3 mb-2">
                                    <label>Estado del Requerimiento</label>
                                    <input type="text" class="form-control form-control-sm" value="Pendiente" readonly>
                                    <input type="hidden" id="estado" name="estado" value="0">
                                </div>
                                
                            </div>
                            <div class="row my-2">
                                <div class="col-12 col-lg-3 mb-2">
                                    <label>Encargado de Solicitud</label>
                                    <input type="text" id="encargado_solicitud" name="encargado_solicitud" class="form-control form-control-sm" readonly required>
                                </div>
                                <div class="col-12 col-lg-3 mb-2">
                                    <label>Nombre del Solicitante</label>
                                    <input type="text" id="nombre_solicitante" name="nombre_solicitante" class="form-control form-control-sm"  readonly>
                                </div>
                                <!-- Área que recibe -->
                                    <div class="col-12 col-lg-6 mb-2">
                                        <label>Area quien recibe</label>
                                        <select class="form-select" id="areaSelect" name="areaSelect"
                                            aria-label="Floating label select example" required>
                                            <option value="">-- Seleccione el Area --</option>
                                        </select>
                                        <div class="invalid-feedback">Seleccione el Area</div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <!-- Productos Solicitados -->
                    <div class="card card-gray shadow mt-3">
                        <div class="card-body px-3 py-3">
                            <span class="titulo-fieldset px-3 py-1">PRODUCTOS SOLICITADOS</span>
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered shadow border-secondary display" id="productosTable">
                                    <thead class="bg-main text-center">
                                        <tr>
                                            <th>N°</th>
                                            <th>Nombre del Producto</th>
                                            <th>Unidad de Medida</th>
                                            <th>Marca y/o Especificaciones Técnicas</th>
                                            <th>Cantidad</th>
                                            <th>Centra de Costo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td><input type="text" id="producto_nombre" name="producto_nombre[]" class="form-control form-control-sm autocomplete-producto" placeholder="Ej. Camisa Manga Larga"></td>
                                            <td>
                                                <select name="producto_unidad[]" id="producto_unidad" class="form-select form-select-sm unidadSelect">
                                                </select>
                                            </td>
                                            <td><input type="text" name="producto_especificaciones[]" id="producto_especificaciones" class="form-control form-control-sm" placeholder="Ej. Talla M, color blanco"></td>
                                            <td><input type="number" name="producto_cantidad[]" id="producto_cantidad" class="form-control form-control-sm" min="1" value="1"></td>
                                            <td>
                                                <select name="producto_centro_costo[]" id="producto_centro_costo" class="form-select form-select-sm" required>
                                                </select>
                                            </td>

                                            <td class="text-center">
                                                <div class="btn-group d-flex justify-content-center" role="group">
                                                    <!-- Botón de Agregar con espacio lateral -->
                                                    <button type="button" id="btnAgregar" class="btn btn-sm btn-primary addRow mx-1">
                                                        <i class="fas fa-plus fs-5"></i>
                                                    </button>
                                            
                                                    <!-- Botón de Guardar con espacio lateral -->
                                                    <button type="button" id="btnGuardar" class="btn btn-sm btn-success saveRow mx-1" onclick="guardarFila(this)">
                                                        <i class="fas fa-save fs-5"></i>
                                                    </button>
                                            
                                                    <!-- Botón de Eliminar con espacio lateral -->
                                                    <button type="button" id="btnEliminar" class="btn btn-sm btn-danger deleteRow mx-1">
                                                        <i class="fas fa-trash fs-5"></i>
                                                    </button>
                                                </div>
                                            </td>                                                                                                                                  
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center mt-4">
                                <!-- Botón de Guardar -->
                                <button type="submit" id="btnGuardar" class="btn btn-sm btn-success saveRow mx-1" onclick="fnc_guardarRequerimiento()">
                                    <i class="fas fa-save fs-5"></i> Guardar
                                </button>
                                
                                <!-- Botón de Regresar -->
                                <button type="reset" id="btnRegresar" class="btn btn-sm btn-danger deleteRow mx-1" onclick="regresarListado()">
                                    <i class="fas fa-undo-alt fs-5"></i> Regresar
                                </button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    var  contadorFilas = 1; // Contador global para las filas
    var centrosCostoOptions = ''; // Opciones pre-cargadas para centros de costo
    var unidadMedidaOptions = ''; // Opciones pre-cargadas para unidad de medida
    $(document).ready(function() {
            const idUsuario = {{ auth()->user()->id_usuario ?? 'null' }}; // Obtener el ID del usuario

            if (idUsuario) {
                obtenerDatosUsuario(idUsuario);
                obtenerCodigoRequerimiento(idUsuario);
            } else {
                console.error('Usuario no identificado');
            }



            cargarAreas();
            cargarCentrosCosto();
            cargarunidadMedida();
            preCargarOpciones();

            // Evento para agregar nuevas filas
            $('#btnAgregar').on('click', function () {
                agregarNuevaFila();
            });

        // Evento para eliminar filas
            $('#productosTable').on('click', '.deleteRow', function () {
                    if ($('#productosTable tbody tr').length === 1) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No se puede eliminar',
                            text: 'Debes tener al menos dos filas en la tabla.',
                        });
                    } else {
                        $(this).closest('tr').remove();
                        actualizarNumeracion();
                    }
                });
        }
    );

    function obtenerDatosUsuario(idUsuario) {
        $.ajax({
            url: `/usuario/datos/${idUsuario}`,
            type: 'GET',
            success: function(response) {
                // Rellenar los campos en la vista con los datos recibidos
                $('#areaSolicitante_usu').val(response.area); 
                $('#encargado_solicitud').val(response.nombre); //(response.perfil + ' - ' + response.nombre_completo);
                $('#nombre_solicitante').val(response.nombre_completo);
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo obtener la información del usuario. Intente nuevamente.',
                });
            }
        });
    }

    function obtenerCodigoRequerimiento(idUsuario) {
        $.ajax({
            url: `/requerimiento/generar-codigo/${idUsuario}`,
            type: 'GET',
            success: function(response) {
                $('#codigo_requerimiento').val(response.nuevo_codigo);
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo generar el código de requerimiento. Intente nuevamente.',
                });
            }
        });
    }

    function cargarAreas() {
        $.ajax({
            url: '{{ route('listar_areas') }}', // Ruta para obtener las áreas
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#areaSelect'); 
                select.empty(); 
                select.append('<option value="" class="text-center">-- Seleccione el Area --</option>'); // Opción predeterminada
                data.forEach(function(area) {
                    select.append('<option value="' + area.id_area + '">' + area.descripcion + '</option>');
                });
            },
            error: function(xhr) {
                console.error('Error al cargar áreas:', xhr.responseText);
            }
        });
    }





    function cargarunidadMedida() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "{{ route('documento.cargar_unidad_medida') }}",
                type: 'GET',
                success: function(response) {
                    resolve(response); // Resuelve la promesa con la respuesta
                },
                error: function() {
                    reject(); // Rechaza la promesa si hay un error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar la lista de unidades de medida. Intente nuevamente.',
                    });
                }
            });
        });
    }

    function cargarCentrosCosto() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "{{ route('documento.cargar_centros_costo') }}",
                type: 'GET',
                success: function(response) {
                    resolve(response); // Resuelve la promesa con la respuesta
                },
                error: function() {
                    reject(); // Rechaza la promesa si hay un error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar la lista de centros de costo. Intente nuevamente.',
                    });
                }
            });
        });
    }


    function preCargarOpciones() {
        // Pre-carga los centros de costo y unidad de medida
        Promise.all([cargarCentrosCosto(), cargarunidadMedida()])
            .then(([centrosCostoResponse, unidadMedidaResponse]) => {
                // Construimos las opciones para reutilizarlas en cada fila
                centrosCostoOptions = `<option value="">-- Seleccione Centro de Costo --</option>` +
                    centrosCostoResponse.centros_costo
                        .map(cc => `<option value="${cc.id}">${cc.nomb_centroCos}</option>`)
                        .join('');
                
                unidadMedidaOptions = `<option value="">-- Seleccione Unidad de Medida --</option>` +
                    unidadMedidaResponse.unidad_medida
                        .map(um => `<option value="${um.id}">${um.nomb_uniMed}</option>`)
                        .join('');
                // Cargar opciones en la primera fila
                cargarPrimeraFila();
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron cargar las opciones. Intente nuevamente.',
                });
            });
    }


    function agregarNuevaFila() {
        contadorFilas++;

        // Nueva fila dinámica
        const nuevaFila = `
            <tr>
                <td>${contadorFilas}</td>
                <td><input type="text" name="producto_nombre[]" class="form-control form-control-sm autocomplete-producto" placeholder="Ej. Camisa Manga Larga" required></td>
                <td>
                    <select name="producto_unidad[]" class="form-select form-select-sm unidadSelect" required>
                        ${unidadMedidaOptions}
                    </select>
                </td>
                <td><input type="text" name="producto_especificaciones[]" class="form-control form-control-sm" placeholder="Ej. Talla M, color blanco"></td>
                <td><input type="number" name="producto_cantidad[]" class="form-control form-control-sm" min="1" value="1" required></td>
                <td>
                    <select name="producto_centro_costo[]" class="form-select form-select-sm" required>
                        ${centrosCostoOptions}
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-success saveRow mx-1" onclick="guardarFila(this)">
                        <i class="fas fa-save fs-5"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger deleteRow mx-1" onclick="eliminarFila(this)">
                        <i class="fas fa-trash fs-5"></i>
                    </button>
                </td>
            </tr>`;
        $('#productosTable tbody').append(nuevaFila);
    }

    function actualizarNumeracion() {
        // Actualizamos el número de las filas después de eliminar una
        $('#productosTable tbody tr').each(function (index) {
            $(this).find('td:first').text(index + 1);
        });

        // Actualizamos el contador global
        contadorFilas = $('#productosTable tbody tr').length;
    }

    function cargarPrimeraFila() {
        // Poblar los selects de la primera fila
        $('#producto_centro_costo').html(centrosCostoOptions);
        $('#producto_unidad').html(unidadMedidaOptions);
    }
    function guardarFila(button) {
        // Obtenemos la fila actual
        const fila = $(button).closest('tr');

        // Hacemos todos los inputs y selects readonly/disabled
        fila.find('input, select').attr('readonly', true).attr('disabled', true);

        // Cambiamos el botón de guardar por el de editar
        $(button).replaceWith(`
            <button type="button" class="btn btn-sm btn-primary editRow mx-1" onclick="editarFila(this)">
                <i class="fas fa-edit fs-5"></i>
            </button>
        `);
    }

    function editarFila(button) {
        // Obtenemos la fila actual
        const fila = $(button).closest('tr');

        // Habilitamos todos los inputs y selects
        fila.find('input, select').removeAttr('readonly').removeAttr('disabled');

        // Cambiamos el botón de editar por el de guardar
        $(button).replaceWith(`
            <button type="button" class="btn btn-sm btn-success saveRow mx-1" onclick="guardarFila(this)">
                <i class="fas fa-save fs-5"></i>
            </button>
        `);
    }

    function eliminarFila(button) {
        const fila = $(button).closest('tr');
        fila.remove();
        actualizarNumeracion();
    }



    function limpiarCampos() {
        // Limpiar los campos de la cabecera
        $('#codigo_requerimiento').val('');
        $('#fecha_solicitud').val('');
        $('#areaSolicitante_usu').val('');
        $('#estado').val('Pendiente');
        $('#encargado_solicitud').val('');
        $('#nombre_solicitante').val('');
        $('#areaSelect').val('').change();

        // Limpiar el cuerpo de la tabla
        $('#productosTable tbody').empty();

        // Reiniciar el contador
        contadorFilas = 1;
        centrosCostoOptions = ''; // Opciones pre-cargadas para centros de costo
        unidadMedidaOptions = ''; // Opciones pre-cargadas para unidad de medida

        // Agregar la primera fila con campos vacíos
        const primeraFila = `
            <tr>
                <td>${contadorFilas}</td>
                <td><input type="text" id="producto_nombre" name="producto_nombre[]" class="form-control form-control-sm autocomplete-producto" placeholder="Ej. Camisa Manga Larga"></td>
                <td>
                    <select name="producto_unidad[]" id="producto_unidad" class="form-select form-select-sm unidadSelect">
                        ${unidadMedidaOptions}
                    </select>
                </td>
                <td><input type="text" name="producto_especificaciones[]" id="producto_especificaciones" class="form-control form-control-sm" placeholder="Ej. Talla M, color blanco"></td>
                <td><input type="number" name="producto_cantidad[]" id="producto_cantidad" class="form-control form-control-sm" min="1" value="1"></td>
                <td>
                    <select name="producto_centro_costo[]" id="producto_centro_costo" class="form-select form-select-sm" required>
                        ${centrosCostoOptions}
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-success saveRow mx-1" onclick="guardarFila(this)">
                        <i class="fas fa-save fs-5"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger deleteRow mx-1" onclick="eliminarFila(this)">
                        <i class="fas fa-trash fs-5"></i>
                    </button>
                </td>
            </tr>`;
        $('#productosTable tbody').append(primeraFila);
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

    function regresarListado() {
        limpiarCampos(); // Limpiar datos si es necesario
        CargarContenido('Documentos/DocumentosRequerimiento', 'content-wrapper');
    }
    function fnc_guardarRequerimiento() {
        var formData = new FormData($('#frm-datos-requerimiento')[0]);
        formData.append('_token', '{{ csrf_token() }}');

        // Validar si todas las filas tienen datos completos
        var filasCompletas = true;
        $('#productosTable tbody tr').each(function () {
            $(this).find('input, select').each(function () {
                if (!$(this).val()) {
                    filasCompletas = false;
                    return false; // Romper el bucle
                }
            });
            if (!filasCompletas) return false;
        });

        if (!filasCompletas) {
            Swal.fire('Advertencia', 'Complete todos los campos en las filas de productos.', 'warning');
            return;
        }

        Swal.fire({
            title: '¿Está seguro de registrar el requerimiento?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, registrar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("guardar_requerimiento") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire('Éxito', response.message, 'success');
                        if (response.success) {
                            limpiarCampos();
                            regresarListado();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Error al registrar el requerimiento.', 'error');
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    }





</script>

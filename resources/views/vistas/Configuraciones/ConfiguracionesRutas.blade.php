<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">Configuración Rutas API</h2>
            </div>
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                    <li class="breadcrumb-item active">Rutas API</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Apis RUC -->
        <div class="card card-gray shadow mt-4">
            <div class="card-body px-3 py-3">
                <span class="titulo-fieldset px-3 py-1">Rutas APIs RUC</span>
                <div class="row my-2">
                    <div class="col-12 col-lg-11 mb-2">
                        <label><i class="fas fa-link text-primary mr-2"></i>Url:</label>
                        <div class="input-group">
                            <input type="text" id="urlApiRuc" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="col-1 col-lg-1 mb-2 d-flex align-items-end">
                        <button class="btn btn-outline-warning btn-sm w-100" id="editUrlApiRuc" onclick="habilitarEdicion('urlApiRuc', 'btnGuardarApiRuc')">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                    </div>
        
                    <div class="col-12 col-lg-11 mb-2">
                        <label><i class="fas fa-key text-success mr-2"></i>Token:</label>
                        <div class="input-group">
                            <input type="text" id="tokenApiRuc" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="col-1 col-lg-1 mb-2 d-flex align-items-end">
                        <button class="btn btn-outline-warning btn-sm w-100" id="editTokenApiRuc" onclick="habilitarEdicion('tokenApiRuc', 'btnGuardarApiRuc')">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                    </div>
        
                    <div class="text-center mt-4 col-12">
                        <button id="btnGuardarApiRuc" class="btn btn-sm btn-success mx-1" onclick="guardarConfigRuc()" style="display: none;">
                            <i class="fas fa-save fs-5"></i> Guardar
                        </button>
                        <button type="reset" id="btnCancelarApiRuc" class="btn btn-sm btn-danger mx-1" onclick="CancelarRuc()">
                            <i class="fas fa-times fs-5"></i> Cancelar
                        </button>
                        <button type="Restaurar" id="btnRestaurarApiRuc" class="btn btn-sm btn-cyan mx-1" onclick="restaurarConfigRuc()">
                            <i class="fas fa-sync-alt fs-5"></i> Restaurar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        






        <!-- Apis Tipo de Cambio -->
        <div class="card card-gray shadow mt-4">
            <div class="card-body px-3 py-3">
                <span class="titulo-fieldset px-3 py-1">Rutas APIs Tipo de Cambio</span>
                
                <div class="row my-2">
                    <div class="col-12 col-lg-11 mb-2">
                        <label><i class="fas fa-link text-primary mr-2"></i>Rutas APIs Tipo de Cambio</label>
                        <div class="input-group">
                            <input type="text" id="urlApiTipoCambio" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="col-1 col-lg-1 mb-2 d-flex align-items-end">
                        <button class="btn btn-outline-warning btn-sm w-100" id="editUrlApiTipoCambio" onclick="habilitarEdicion('urlApiTipoCambio', 'btnGuardarApiTipoCambio')">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                    </div>
        
                    <div class="col-12 col-lg-11 mb-2">
                        <label><i class="fas fa-key text-success mr-2"></i>Token:</label>
                        <div class="input-group">
                            <input type="text" id="tokenApiTipoCambio" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="col-1 col-lg-1 mb-2 d-flex align-items-end">
                        <button class="btn btn-outline-warning btn-sm w-100" id="editTokenApiTipoCambio" onclick="habilitarEdicion('tokenApiTipoCambio', 'btnGuardarApiTipoCambio')">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                    </div>
        
                    <div class="text-center mt-4">
                        <button id="btnGuardarApiTipoCambio" class="btn btn-sm btn-success mx-1" onclick="guardarConfigTipoCambio()" style="display: none;">
                            <i class="fas fa-save fs-5"></i> Guardar
                        </button>
                        <button type="reset" id="btnCancelarApiTipoCambio" class="btn btn-sm btn-danger deleteRow mx-1" onclick="CancelarTipoCambio()">
                            <i class="fas fa-times fs-5"></i> Cancelar
                        </button>
                        <button type="button" id="btnRestaurarApiTipoCambio" class="btn btn-sm btn-cyan mx-1" onclick="restaurarConfigTipoCambio()">
                            <i class="fas fa-sync-alt fs-5"></i> Restaurar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Código de Validación -->
        <div class="card card-gray shadow mt-4">
            <div class="card-body px-3 py-3">
                <span class="titulo-fieldset px-3 py-1">Código de Validación</span>
                <div class="row my-2">
                    <div class="col-12 col-lg-11 mb-2">
                        <label><i class="fas fa-key text-primary mr-2"></i>Código de Validación:</label>
                        <div class="input-group">
                            <input type="text" id="codigoValidacion" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="col-1 col-lg-1 mb-2 d-flex align-items-end">
                        <button class="btn btn-outline-warning btn-sm w-100" id="editCodigoValidacion"
                            onclick="habilitarEdicionCodigo('codigoValidacion', 'btnGuardarCodigoValidacion')">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                    </div>
                    <div class="text-center mt-4">
                        <button id="btnGuardarCodigoValidacion" class="btn btn-sm btn-success mx-1" style="display: none;"
                            onclick="guardarCodigoValidacion()">
                            <i class="fas fa-save fs-5"></i> Guardar
                        </button>
                        <button type="button" id="btnCancelarCodigoValidacion" class="btn btn-sm btn-danger mx-1"
                            onclick="CancelarCodigo()">
                            <i class="fas fa-times fs-5"></i> Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        

        


    </div>
</div>

<script>
    $(document).ready(function () {
        // Cargar configuración al cargar la página
        fetchConfigRuc();
        fetchConfigTipoCambio();
        fetchCodigoAcceso();
    });

    function habilitarEdicion(inputId, saveButtonId) {
        const inputField = document.getElementById(inputId);
        const saveButton = document.getElementById(saveButtonId);

        // Habilitar edición del campo
        inputField.removeAttribute('readonly');
        inputField.classList.add('border-primary');

        // Mostrar botón de guardar
        saveButton.style.display = 'inline-block';
    }

    function habilitarEdicionCodigo(inputId, saveButtonId) {
        $.get("{{ route('verificar.permiso.editar') }}", function (response) {
            if (response.success) {
                const inputField = document.getElementById(inputId);
                const saveButton = document.getElementById(saveButtonId);

                inputField.removeAttribute('readonly');
                inputField.classList.add('border-primary');
                saveButton.style.display = 'inline-block';
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                });
            }
        }).fail(function () {
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un problema al verificar el permiso.',
                icon: 'error',
                confirmButtonText: 'Aceptar',
            });
        });
    }




    function fetchCodigoAcceso() {
        $.get("{{ route('codigo.acceso.get') }}", function (response) {
            if (response.success) {
                $('#codigoValidacion').val(response.data.codigo); // Mostrar directamente el código
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        }).fail(function () {
            Swal.fire('Error', 'No se pudo obtener el Código de Validación.', 'error');
        });
    }

    function CancelarCodigo() {
        $('#codigoValidacion').attr('readonly', true).removeClass('border-primary');
        $('#btnGuardarCodigoValidacion').hide();
    }

    function guardarCodigoValidacion() {
        const data = {
            codigo: $('#codigoValidacion').val(),
            _token: '{{ csrf_token() }}',
        };

        $.post("{{ route('codigo.acceso.update') }}", data, function (response) {
            if (response.success) {
                Swal.fire('Éxito', response.message, 'success');
                fetchCodigoAcceso(); // Recargar el código enmascarado
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        }).fail(function () {
            Swal.fire('Error', 'No se pudo actualizar el Código de Validación.', 'error');
        });
    }

    

    function fetchConfigRuc() {
        $.get("{{ route('ruc.config.get') }}", function (response) {
            if (response.success) {
                $('#urlApiRuc').val(response.data.apiUrl);
                $('#tokenApiRuc').val(response.data.apiToken);
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        });
    }


    function guardarConfigRuc() {
        const data = {
            apiUrl: $('#urlApiRuc').val(),
            apiToken: $('#tokenApiRuc').val(),
            _token: '{{ csrf_token() }}',
        };

        $.ajax({
            url: "{{ route('ruc.config.update') }}",
            type: "POST",
            data: data,
            success: function (response) {
                if (response.success) {
                    Swal.fire('Éxito', response.message, 'success');
                    // Volver a deshabilitar los campos y ocultar el botón de guardar
                    $('#urlApiRuc').attr('readonly', true).removeClass('border-primary');
                    $('#tokenApiRuc').attr('readonly', true).removeClass('border-primary');
                    $('#btnGuardarApiRuc').hide();
                    fetchConfigRuc(); // Refrescar configuración
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'No se pudo actualizar la configuración.', 'error');
            }
        });
    }


    

    function CancelarRuc() {
        // Restaurar valores originales y deshabilitar campos
        fetchConfigRuc();
        $('#urlApiRuc').attr('readonly', true).removeClass('border-primary');
        $('#tokenApiRuc').attr('readonly', true).removeClass('border-primary');
        $('#btnGuardarApiRuc').hide();

    }

    function restaurarConfigRuc() {
        const data = {
            _token: '{{ csrf_token() }}',
        };

        $.post("{{ route('ruc.config.restaurar') }}", data, function (response) {
            if (response.success) {
                Swal.fire('Éxito', response.message, 'success');
                fetchConfigRuc(); // Refrescar la configuración mostrada
                $('#urlApiRuc').attr('readonly', true).removeClass('border-primary');
                $('#tokenApiRuc').attr('readonly', true).removeClass('border-primary');
                $('#btnGuardarApiRuc').hide();
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        }).fail(function () {
            Swal.fire('Error', 'No se pudo restaurar la configuración.', 'error');
        });
    }


    function fetchConfigTipoCambio() {
        $.get("{{ route('tipo.cambio.config.get') }}", function (response) {
            if (response.success) {
                $('#urlApiTipoCambio').val(response.data.apiUrl);
                $('#tokenApiTipoCambio').val(response.data.apiToken);
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        });
    }
    function guardarConfigTipoCambio() {
        const data = {
            apiUrl: $('#urlApiTipoCambio').val(),
            apiToken: $('#tokenApiTipoCambio').val(),
            _token: '{{ csrf_token() }}',
        };

        $.post("{{ route('tipo.cambio.config.update') }}", data, function (response) {
            if (response.success) {
                Swal.fire('Éxito', response.message, 'success');
                fetchConfigTipoCambio(); // Refrescar la configuración mostrada
                habilitarEdicionTipoCambio();
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        }).fail(function () {
            Swal.fire('Error', 'No se pudo actualizar la configuración.', 'error');
        });
    }

    function restaurarConfigTipoCambio() {
        const data = {
            _token: '{{ csrf_token() }}',
        };

        $.post("{{ route('tipo.cambio.config.restaurar') }}", data, function (response) {
            if (response.success) {
                Swal.fire('Éxito', response.message, 'success');
                fetchConfigTipoCambio(); // Refrescar la configuración mostrada
                habilitarEdicionTipoCambio();
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        }).fail(function () {
            Swal.fire('Error', 'No se pudo restaurar la configuración.', 'error');
        });
    }
    function CancelarTipoCambio() {
        // Recargar la configuración de la API Tipo de Cambio desde el servidor
        fetchConfigTipoCambio();
        habilitarEdicionTipoCambio();
    }
    function habilitarEdicionTipoCambio() {
        $('#urlApiTipoCambio').attr('readonly', true).removeClass('border-primary');
        $('#tokenApiTipoCambio').attr('readonly', true).removeClass('border-primary');
        $('#btnGuardarApiTipoCambio').hide();
    }

</script>

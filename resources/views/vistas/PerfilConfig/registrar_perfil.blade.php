<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 mb-2 fw-bold">REGISTRAR PERFIL</h2>
            </div><!-- /.col -->
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                    <li class="breadcrumb-item">Perfiles</li>
                    <li class="breadcrumb-item active">Registrar</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div><!-- /.content-header -->

<div class="content">

    <div class="container-fluid">

        <div class="card card-gray shadow mt-4">

            <div class="card-body px-3 py-3" style="position: relative;">

                <span class="titulo-fieldset px-3 py-1">DATOS DEL PERFIL </span>

                <div class="row my-3">

                    <div class="col-12">

                        <form id="frm-datos-perfiles" class="needs-validation-perfiles" novalidate>

                            <div class="row">

                                <div class="col-8">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-users mr-1 my-text-color"></i>Perfil</label>
                                    <input type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="descripcion" name="descripcion" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="Ingrese el nombre del perfil" required>
                                    <div class="invalid-feedback">Ingrese el nombre del perfil</div>
                                </div>

                                <!-- ESTADO -->
                                <div class="col-4">
                                    <label class="mb-0 ml-1 text-sm my-text-color"><i class="fas fa-toggle-on mr-1 my-text-color"></i> Estado</label>
                                    <select class="form-select" id="estado" name="estado" aria-label="Floating label select example" required>
                                        <option value="" disabled>--Seleccione un estado--</option>
                                        <option value="1" selected>ACTIVO</option>
                                        <option value="0">INACTIVO</option>
                                    </select>
                                </div>


                                <div class="col-12 mt-3">

                                    <div class="text-center">
                                        <a class="btn btn-sm btn-danger  fw-bold " id="btnCancelarRegistro" style="position: relative; width: 160px;" onclick="fnc_RegresarListadoPerfiles();">
                                            <span class="text-button">REGRESAR</span>
                                            <span class="btn fw-bold icon-btn-danger ">
                                                <i class="fas fa-undo-alt fs-5 text-white m-0 p-0"></i>
                                            </span>
                                        </a>

                                        <a class="btn btn-sm btn-success  fw-bold " id="btnRegistrarPerfil" style="position: relative; width: 160px;" onclick="fnc_RegistrarPerfil();">
                                            <span class="text-button">REGISTRAR</span>
                                            <span class="btn fw-bold icon-btn-success ">
                                                <i class="fas fa-save fs-5 text-white m-0 p-0"></i>
                                            </span>
                                        </a>
                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div><!-- /.container-fluid -->

</div><!-- /.content -->
<script>
     $(document).ready(function() {

    fnc_InicializarFormulario();
    })

    function fnc_InicializarFormulario() {
        fnc_LimpiarFomulario();
    }

    function fnc_LimpiarFomulario() {
        if ($("#descripcion").length) {
            $("#descripcion").val('');
        }
        if ($("#estado").length) {
            $("#estado").val('1');
        }
        if ($(".needs-validation-perfiles").length) {
            $(".needs-validation-perfiles").removeClass("was-validated");
        }
    }

    function fnc_LimpiarControles() {

    $("#descripcion").val('')
    $("#estado").val('1');

    $(".needs-validation-perfiles").removeClass("was-validated");

    }

    function fnc_RegresarListadoPerfiles() {
        fnc_LimpiarControles();
        cargarPlantilla('perfil_seguridad', 'content-wrapper')
    }
    function fnc_RegistrarPerfil() {
    // Validar el formulario antes de enviarlo
    form_perfiles_validate = validarFormulario('needs-validation-perfiles');

    if (!form_perfiles_validate) {
        mensajeToast("error", "Complete los datos obligatorios");
        return;
    }

    // Confirmación con SweetAlert
    Swal.fire({
        title: '¿Está seguro(a) de registrar el Perfil?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, deseo registrarlo!',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            // Crear un FormData con los datos del formulario
            var formData = new FormData($("#frm-datos-perfiles")[0]);
            formData.append('_token', '{{ csrf_token() }}');

            // Realizar la solicitud AJAX a la ruta de Laravel
            $.ajax({
                url: '{{ route('perfiles.registrar') }}', // Ruta de Laravel para registrar el perfil
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        position: 'top-center',
                        icon: response.tipo_msj,
                        title: response.msj,
                        showConfirmButton: true
                    });

                    fnc_LimpiarControles();
                    fnc_RegresarListadoPerfiles();
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Error al registrar el perfil',
                        showConfirmButton: true
                    });
                }
            });
        }
    });
}

</script>
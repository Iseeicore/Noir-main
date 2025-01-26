<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 mb-2 fw-bold">ACTUALIZAR PERFIL</h2>
            </div>
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                    <li class="breadcrumb-item">Perfiles</li>
                    <li class="breadcrumb-item active">Actualizar</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-gray shadow mt-4">
            <div class="card-body px-3 py-3">
                <span class="titulo-fieldset px-3 py-1">DATOS DEL PERFIL</span>
                <div class="row my-3">
                    <div class="col-12">
                        <form id="frm-datos-perfiles" class="needs-validation-perfiles" novalidate>
                            <div class="row">
                                <div class="col-8">
                                    <label class="mb-0 ml-1 text-sm my-text-color">
                                        <i class="fas fa-users mr-1 my-text-color"></i> Perfil
                                    </label>
                                    <input type="text" style="border-radius: 20px;" class="form-control form-control-sm" id="descripcion" name="descripcion" value="{{ $perfil->descripcion }}" required>
                                    <div class="invalid-feedback">Ingrese el nombre del perfil</div>
                                </div>
                                <div class="col-4">
                                    <label class="mb-0 ml-1 text-sm my-text-color">
                                        <i class="fas fa-toggle-on mr-1 my-text-color"></i> Estado
                                    </label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="1" {{ $perfil->estado == 1 ? 'selected' : '' }}>ACTIVO</option>
                                        <option value="0" {{ $perfil->estado == 0 ? 'selected' : '' }}>INACTIVO</option>
                                    </select>
                                </div>
                                <div class="col-12 mt-3 text-center">
                                    <button class="btn btn-sm btn-success fw-bold" id="btnActualizarPerfil" onclick="fnc_ActualizarPerfil(event, {{ $perfil->id_perfil }})">
                                        <span class="text-button">ACTUALIZAR</span>
                                        <span class="btn icon-btn-success">
                                            <i class="fas fa-save fs-5 text-white"></i>
                                        </span>
                                    </button>
                                    <button class="btn btn-sm btn-danger fw-bold" onclick="fnc_RegresarListadoPerfiles(event);">
                                        <span class="text-button">REGRESAR</span>
                                        <span class="btn icon-btn-danger">
                                            <i class="fas fa-undo-alt fs-5 text-white"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Prevenir el comportamiento predeterminado del formulario
    function fnc_ActualizarPerfil(event, id_perfil) {
        event.preventDefault();  // Prevenir el comportamiento predeterminado de submit

        var formData = {
            descripcion: $('#descripcion').val(),
            estado: $('#estado').val(),
            _token: '{{ csrf_token() }}'
        };

        Swal.fire({
            title: '¿Está seguro(a) de actualizar el Perfil?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, deseo actualizarlo',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('perfil.actualizar', $perfil->id_perfil) }}',
                    method: 'PUT',
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Perfil actualizado correctamente',
                        });
                        cargarPlantilla('perfil_seguridad', 'content-wrapper');
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al actualizar el perfil',
                        });
                    }
                });
            }
        });
    }

    // Prevenir el comportamiento predeterminado y regresar sin recargar la página
    function fnc_RegresarListadoPerfiles(event) {
        event.preventDefault();  // Prevenir el comportamiento predeterminado de submit
        cargarPlantilla('perfil_seguridad', 'content-wrapper');
    }
</script>

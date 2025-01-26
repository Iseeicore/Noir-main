<!-- Content Header (Page header) -->
<div class="content-header">

    <div class="container-fluid">

        <div class="row mb-2">

            <div class="col-sm-6">

                <h2 class="m-0 fw-bold">ADMINISTRAR PERFILES</h2>

            </div><!-- /.col -->

            <div class="col-sm-6 d-none d-md-block">

                <ol class="breadcrumb float-sm-right">

                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>

                    <li class="breadcrumb-item active">Administrar Perfiles</li>

                </ol>

            </div><!-- /.col -->

        </div><!-- /.row -->

    </div><!-- /.container-fluid -->

</div><!-- /.content-header -->

<div class="content">

    <div class="container-fluid">

        <div class="card card-gray shadow mt-4">

            <div class="card-body px-3 py-3" style="position: relative;">

                <span class="titulo-fieldset px-3 py-1">LISTADO DE PERFILES </span>

                <div class="row my-3">

                    <div class="col-12">

                        <table id="tbl_perfiles" class="table table-striped w-100 shadow border border-secondary">
                            <thead class="bg-main text-left">
                                <th></th>
                                <th>Id</th>
                                <th>Descripción</th>
                                <th>Estado</th>
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
        // Cargar el DataTable de perfiles
        fnc_CargarDatatablePerfil();
    });

    function fnc_EditarPerfil(id_perfil) {
        $(".content-wrapper").fadeOut('slow', function() {
            $.ajax({
                url: '/perfiles/editar/' + id_perfil, // Llamamos a la nueva ruta de Laravel
                type: 'GET',
                success: function(data) {
                    // Reemplazamos el contenido del contenedor con la nueva vista
                    $(".content-wrapper").html(data).fadeIn('slow');
                },
                error: function(xhr) {
                    console.log("Error al cargar la vista: " + xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar la vista.',
                    });
                }
            });
        });
    }

    function fnc_CargarDatatablePerfil() {
        // Verifica si la tabla ya está inicializada, y la destruye si es necesario
        if ($.fn.DataTable.isDataTable('#tbl_perfiles')) {
            $('#tbl_perfiles').DataTable().destroy();
            $('#tbl_perfiles tbody').empty();
        }

        

        // Inicializa el DataTable con los botones
        $("#tbl_perfiles").DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Registrar Perfil',
                className: 'addNewRecord',
                action: function(e, dt, node, config) {
                    // Redireccionar a la ruta de Laravel para registrar un perfil
                    cargarPlantilla('PerfilConfig/registrar_perfil', 'content-wrapper');
                }
            },
            {
                extend: 'excel',
                title: function() {
                    return 'LISTADO DE PERFILES';
                }
            },
            'pageLength'
        ],
        pageLength: 10,
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('perfiles.obtener') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {
                data: 'opciones', 
                orderable: false,
                width: '5%',
                className: "dt-center",
                render: function(data, type, row) {
                    console.log(row.id_perfil); // Verificar si devuelve el valor esperado
                    return `
                        <div class="btn-group">
                            <button class="btn btn-sm dropdown-toggle p-0 m-0 my-text-color fs-5" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-list-alt"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" style='cursor:pointer;' onclick="fnc_EditarPerfil('${row.id_perfil}');">
                                    <i class='fas fa-pencil-alt fs-6 text-primary mr-2'></i> <span class='my-color'>Editar</span>
                                </a>
                                <a class="dropdown-item" style='cursor:pointer;' onclick="fnc_EliminarPerfil('${row.id_perfil}');">
                                    <i class='fas fa-trash fs-6 text-danger mr-2'></i> <span class='my-color'>Eliminar</span>
                                </a>
                            </div>
                        </div>
                    `;
                }
            },
            { data: 'id_perfil', className: "dt-center" }, // Identificador del perfil
            { data: 'descripcion', className: "dt-center" }, // Descripción del perfil
            {
                data: 'estado',
                className: "dt-center",
                createdCell: function(td, cellData) {
                    if (cellData !== 'ACTIVO') {
                        $(td).parent().css('background', '#F2D7D5').css('color', 'black');
                    }
                }
            }
        ],
        order: [[1, 'asc']],
        language: {
            url: 'assets/languages/Spanish.json'
        }
    });







    
}











</script>
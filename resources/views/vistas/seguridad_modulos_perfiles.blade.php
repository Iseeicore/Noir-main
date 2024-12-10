<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">ADMINISTRAR MÓDULOS Y PERFILES</h2>
            </div><!-- /.col -->
            <div class="col-sm-6  d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active">Administrar Módulos y Perfiles</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</div>

<div class="content">

    <div class="container-fluid">

        <ul class="nav nav-tabs" id="tabs-asignar-modulos-perfil" role="tablist">

            <li class="nav-item">
                <a class="nav-link active" id="content-modulos-tab" data-toggle="pill" href="#content-modulos"
                    role="tab" aria-controls="content-modulos" aria-selected="false">Modulos</a>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="content-modulo-perfil-tab" data-toggle="pill" href="#content-modulo-perfil"
                    role="tab" aria-controls="content-modulo-perfil" aria-selected="false">Asignar Modulo a
                    Perfil</a>
            </li>

        </ul>

        <div class="tab-content" id="tabsContent-asignar-modulos-perfil">

            <div class="tab-pane fade mt-4 px-4" id="content-perfiles" role="tabpanel"
                aria-labelledby="content-perfiles-tab">
                <h4>Administrar Perfiles</h4>
            </div>

            <!--============================================================================================================================================
            CONTENIDO PARA MODULOS
            =============================================================================================================================================-->
            <div class="tab-pane fade active show  mt-4 px-4" id="content-modulos" role="tabpanel"
                aria-labelledby="content-modulos-tab">

                <div class="row">


                    <!--ARBOL DE MODULOS PARA REORGANIZAR -->
                    <div class="col-md-12">

                        <div class="card card-gray shadow">

                            <div class="card-header">

                                <h3 class="card-title"><i class="fas fa-edit"></i> Organizar Módulos</h3>

                            </div>

                            <div class="card-body">

                                <div class="">

                                    <div>Modulos del Sistema</div>

                                    <div class="" id="arbolModulos"></div>

                                </div>

                                <hr>

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="text-center">

                                            <!-- <button id="btnReordenarModulos" class="btn btn-success btn-sm" style="width: 100%;">Organizar Módulos</button>

                                            <button id="btnReiniciar" class="btn btn-sm btn-warning mt-3 " style="width: 100%;">Estado Inicial</button> -->

                                            <a class="btn btn-sm btn-danger  fw-bold " id="btnReiniciar"
                                                style="position: relative; width: 160px;">
                                                <span class="text-button">ESTADO INICIAL</span>
                                                <span class="btn fw-bold icon-btn-danger d-flex align-items-center">
                                                    <i class="fas fa-times fs-5 text-white m-0 p-0"></i>
                                                </span>
                                            </a>

                                            <a class="btn btn-sm btn-success  fw-bold " id="btnReordenarModulos"
                                                style="position: relative; width: 160px;">
                                                <span class="text-button">ORGANIZAR</span>
                                                <span class="btn fw-bold icon-btn-success d-flex align-items-center">
                                                    <i class="fas fa-save fs-5 text-white m-0 p-0"></i>
                                                </span>
                                            </a>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                    <!--/. col-md-3 -->

                </div>
                <!--/.row -->

            </div><!-- /#content-modulos -->

            <div class="tab-pane fade mt-4 px-4" id="content-modulo-perfil" role="tabpanel"
                aria-labelledby="content-modulo-perfil-tab">

                <div class="row">

                    <div class="col-md-8">

                        <div class="card card-gray shadow">

                            <div class="card-header">

                                <h3 class="card-title"><i class="fas fa-list"></i> Listado de Perfiles</h3>

                            </div>

                            <div class="card-body">

                                <table id="tbl_perfiles_asignar" class="table-striped shadow" width: "100%">

                                    <thead class="bg-main text-left">
                                        <th>id Perfil</th>
                                        <th>Perfil</th>
                                        <th>Estado</th>
                                        <th>F. Creación</th>
                                        <th>F. Actualización</th>
                                        <th class="text-center">Opciones</th>
                                    </thead>

                                    <tbody>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="card card-gray shadow" style="display:none" id="card-modulos">

                            <div class="card-header">

                                <h3 class="card-title"><i class="fas fa-laptop"></i> Módulos del Sistema</h3>

                            </div>

                            <div class="card-body" id="card-body-modulos">

                                <div class="row m-2">

                                    <div class="col-md-6">

                                        <button class="btn btn-success btn-small  m-0 p-0 w-100"
                                            id="marcar_modulos">Marcar todo</button>

                                    </div>

                                    <div class="col-md-6">

                                        <button class="btn btn-danger btn-small m-0 p-0 w-100"
                                            id="desmarcar_modulos">Desmarcar todo</button>

                                    </div>

                                </div>

                                <!-- AQUI SE CARGAN TODOS LOS MODULOS DEL SISTEMA -->
                                <div id="modulos" class="demo"></div>

                                <div class="row m-2">

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Seleccione el modulo de inicio</label>
                                            <select class="custom-select" id="select_modulos">
                                            </select>

                                        </div>

                                    </div>

                                </div>

                                <div class="row m-2">

                                    <div class="col-md-12">

                                        <button class="btn btn-success btn-small w-50 text-center"
                                            id="asignar_modulos">Asignar</button>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<script>
    // Variables globales
    var tbl_modulos, modulos_usuario, modulos_sistema;
    $(document).ready(function() {
        // Inicializa el árbol de módulos al cargar la página
        iniciarArbolModulos();

        // Inicializar el DataTable cuando se hace clic en la pestaña
        $("#content-modulo-perfil-tab").on('click', function() {
            cargarDataTables();
        });


        var idPerfil = 0; // Aquí almacenamos el ID del perfil seleccionado
        var selectedElmsIds = []; // Aquí almacenamos los módulos seleccionados del árbol

        // === EVENTOS ===

        // Evento para seleccionar el perfil desde la tabla
        $('#tbl_perfiles_asignar tbody').on('click', '.btnSeleccionarPerfil', function() {
            seleccionarPerfil(this); // Llama a la función que gestiona la selección del perfil
        });

        $("#modulos").on("changed.jstree", function(evt, data) {

            $("#select_modulos option").remove();

            var selectedElms = $('#modulos').jstree("get_selected", true);

            $.each(selectedElms, function() {

                for (let i = 0; i < modulos_sistema.length; i++) {

                    if (modulos_sistema[i]["id"] == this.id && modulos_sistema[i]["vista"]) {

                        $('#select_modulos').append($('<option>', {
                            value: this.id,
                            text: this.text
                        }));
                    }
                }

            })

            if ($("#select_modulos").has('option').length <= 0) {

                $('#select_modulos').append($('<option>', {
                    value: 0,
                    text: "--No hay modulos seleccionados--"
                }));
            }
        })

        //EVENTO PARA MARCAR TODOS LOS CHECKBOX DEL ARBOL DE MODULOS

        $("#marcar_modulos").on('click', function() {
            $('#modulos').jstree('select_all');
        })
        //EVENTO PARA DESMARCAR TODOS LOS CHECKBOX DEL ARBOL DE MODULOS
        $("#desmarcar_modulos").on('click', function() {
            $('#modulos').jstree("deselect_all", false);
            $("#select_modulos option").remove();
            $('#select_modulos').append($('<option>', {
                value: 0,
                text: "--No hay modulos seleccionados--"
            }));
        })

        /* =============================================================
        REGISTRO EN BASE DE DATOS DE LOS MODULOS ASOCIADOS AL PERFIL 
        ============================================================= */
        $("#asignar_modulos").on('click', function() {

            selectedElmsIds = []
            var selectedElms = $('#modulos').jstree("get_selected", true);

            $.each(selectedElms, function() {

                selectedElmsIds.push(this.id);

                if (this.parent != "#") {
                    selectedElmsIds.push(this.parent);
                }

            });

            //quitamos valores duplicados
            let modulosSeleccionados = [...new Set(selectedElmsIds)];

            let modulo_inicio = $("#select_modulos").val();

            if (idPerfil != 0 && modulosSeleccionados.length > 0) {
                registrarPerfilModulos(modulosSeleccionados, idPerfil, modulo_inicio);
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Debe seleccionar el perfil y módulos a registrar',
                    showConfirmButton: false,
                    timer: 3000
                })
            }

        })

        fnCargarArbolModulos();

        /* =============================================================
        REORGANIZAR MODULOS DEL SISTEMA
        ============================================================= */
        $("#btnReordenarModulos").on('click', function() {
            fnOrganizarModulos();
        })


        /* =============================================================
        REINICIALIZAR MODULOS DEL SISTEMA EN EL JSTREE
        ============================================================= */
        $("#btnReiniciar").on('click', function() {
            actualizarArbolModulos();
        })

        // === FUNCIONES ===


        // Función para seleccionar el perfil y obtener los módulos
        function seleccionarPerfil(element) {
            var table = $('#tbl_perfiles_asignar').DataTable();
            var data = table.row($(element).parents('tr')).data(); // Obtenemos los datos de la fila

            if ($(element).parents('tr').hasClass('selected')) {
                // Si ya está seleccionado, deselecciona
                $(element).parents('tr').removeClass('selected');
                $('#modulos').jstree("deselect_all", false); // Deselecciona todos los módulos en el árbol
                $("#select_modulos option").remove(); // Limpia las opciones de módulos seleccionados
                idPerfil = 0; // Reinicia el ID del perfil
                $("#card-modulos").hide();
            } else {
                // Si no está seleccionado, selecciona el nuevo perfil
                table.$('tr.selected').removeClass('selected'); // Deselecciona otras filas
                $(element).parents('tr').addClass('selected'); // Marca la fila como seleccionada
                idPerfil = data.id_perfil; // Obtiene el ID del perfil correctamente
                obtenerModulosPorPerfil(idPerfil); // Llama a la función con el id del perfil seleccionado
                console.log(data); // Verifica los datos que estás recibiendo
                $("#card-modulos").show()
            }
        }

        // Función para obtener módulos por perfil usando AJAX
        function obtenerModulosPorPerfil(idPerfil) {
            $.ajax({
                url: "{{ route('obtener_modulos_por_perfil') }}", // Llamada AJAX a la ruta en Laravel
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}", // Token CSRF de Laravel
                    id_perfil: idPerfil // Enviamos el id del perfil seleccionado
                },
                dataType: 'json',
                success: function(respuesta) {
                    console.log("Respuesta de módulos por perfil:",
                        respuesta); // Verifica la respuesta en la consola
                    modulos_usuario = respuesta;
                    seleccionarModulosPerfil(idPerfil);

                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener módulos por perfil:', error);
                }
            });
        }

        function seleccionarModulosPerfil(idPerfil) {
            $('#modulos').jstree('deselect_all');

            // Iterar sobre los módulos de usuario obtenidos y seleccionarlos si sel es 1
            let moduloInicio = null;
            for (let i = 0; i < modulos_usuario.length; i++) {
                if (modulos_usuario[i]["sel"] == "1") {
                    let moduloId = modulos_usuario[i]["id"];
                    $("#modulos").jstree("select_node", moduloId);

                    // Si el módulo es el inicio, guárdalo para seleccionarlo en el select_modulos
                    if (modulos_usuario[i]["vista_inicio"] == 1) {
                        moduloInicio = moduloId;
                    }
                }
            }

            // Marcar el módulo de inicio en el select_modulos si existe
            if (moduloInicio !== null) {
                $('#select_modulos').val(moduloInicio).trigger('change');
            }
        }

        function actualizarArbolModulosPerfiles() {
            $.ajax({
                async: false,
                url: "{{ route('obtener_modulos') }}", // Ruta definida en Laravel para obtener los módulos
                method: 'GET', // Cambiamos a GET ya que solo estamos obteniendo datos
                dataType: 'json',
                success: function(respuesta) {
                    modulos_sistema = respuesta; // Guardamos la respuesta en una variable

                    // Actualizamos los datos del árbol de módulos en jsTree
                    $('#modulos').jstree(true).settings.core.data = respuesta;
                    $('#modulos').jstree(true).refresh(); // Refrescamos el árbol
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los módulos:', error); // Manejamos el error
                }
            });
        }

        //mantenimineto de los modulos
        function fnCargarArbolModulos() {

            var dataSource;

            // Realiza la llamada AJAX a la ruta de Laravel
            $.ajax({
                async: false, // Evita el uso de async: false en la medida de lo posible; es mejor manejar asíncronamente
                url: "{{ route('obtener_modulos') }}", // Utiliza la ruta de Laravel
                method: 'GET', // La solicitud en Laravel es de tipo GET
                dataType: 'json',
                success: function(respuesta) {
                    // Almacena los datos en la variable dataSource
                    dataSource = respuesta;

                },
                error: function(xhr, status, error) {
                    console.error("Error al obtener los módulos: ", error);
                }
            });


            /*
            $.jstree.defaults.core.check_callback:
                Determina lo que sucede cuando un usuario intenta modificar la estructura del árbol.
                Si se deja como false se impiden todas las operaciones como crear, renombrar, eliminar, mover o copiar.
                Puede configurar esto en true para permitir todas las interacciones o usar una función para tener un mejor control.
            */
            $('#arbolModulos').jstree({
                "core": {
                    "check_callback": true, // Permite operaciones como crear, eliminar, etc.
                    "data": dataSource // Carga los módulos obtenidos desde Laravel
                },
                "types": {
                    "default": {
                        "icon": "fas fa-laptop" // Icono por defecto para los módulos
                    },
                    "file": {
                        "icon": "fas fa-laptop" // Icono para archivos
                    }
                },
                "plugins": ["types", "dnd"] // Plugins para jstree
            }).bind('ready.jstree', function(e, data) {
                $('#arbolModulos').jstree(
                'open_all'); // Abre todos los nodos cuando el árbol esté listo
            });
        }

        //funciones de la actualizacion 
        function actualizarArbolModulos() {
            $.ajax({
                async: false, // De preferencia, maneja las solicitudes de forma asíncrona
                url: "{{ route('obtener_modulos') }}", // Cambia la URL para que apunte a la ruta de Laravel
                method: 'GET', // Usa GET porque tu ruta en Laravel usa este método
                dataType: 'json',
                success: function(respuesta) {
                    // Actualiza los datos del árbol con los módulos obtenidos
                    $('#arbolModulos').jstree(true).settings.core.data = respuesta;
                    // Refresca el árbol para que muestre los cambios
                    $('#arbolModulos').jstree(true).refresh();
                },
                error: function(xhr, status, error) {
                    console.error("Error al actualizar el árbol de módulos: ", error);
                }
            });
        }

        //funcion para reorganizar los modulos
        function fnOrganizarModulos() {
            var array_modulos = [];

            var reg_id, reg_padre_id, reg_orden;

            var v = $("#arbolModulos").jstree(true).get_json('#', {
                'flat': true
            });

            for (i = 0; i < v.length; i++) {
                var z = v[i];

                // Asignamos el id, el padre Id y el orden del módulo
                reg_id = z["id"];
                reg_padre_id = z["parent"];
                reg_orden = i;

                array_modulos[i] = reg_id + ';' + reg_padre_id + ';' + reg_orden;
            }

            /* Enviar los módulos organizados a Laravel para ser actualizados en la base de datos */
            $.ajax({
                url: "{{ route('reorganizar_modulos') }}", // Ruta en Laravel
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}", // Añadimos el token CSRF por seguridad
                    modulos: array_modulos
                },
                dataType: 'json',
                success: function(respuesta) {
                    mensajeToast(respuesta.tipo_msj, respuesta.msj);
                    tbl_modulos.ajax.reload();

                    // Recargar el árbol de módulos después de actualizar
                    actualizarArbolModulosPerfiles();
                },
                error: function(xhr, status, error) {
                    console.error("Error al reorganizar los módulos: ", error);
                }
            });
        }




        // Función para  REGISTRAR PERFILE MODULOS 
        function registrarPerfilModulos(modulosSeleccionados, idPerfil, idModulo_inicio) {
            $.ajax({
                async: false,
                url: "{{ route('registrar_perfil_modulo') }}", // Nueva ruta en Laravel
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}", // Token CSRF para seguridad
                    id_modulosSeleccionados: modulosSeleccionados,
                    id_Perfil: idPerfil,
                    id_modulo_inicio: idModulo_inicio
                },
                dataType: 'json',
                success: function(respuesta) {
                    if (respuesta > 0) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Se registró correctamente',
                            showConfirmButton: false,
                            timer: 2000
                        });

                        $("#select_modulos option").remove();
                        $('#modulos').jstree("deselect_all", false);
                        $('#tbl_perfiles_asignar').DataTable().ajax.reload();
                        $("#card-modulos").hide();
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Error al registrar',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Error en la solicitud',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
        }



        // Función para cargar el DataTable
        function cargarDataTables() {
            if ($.fn.DataTable.isDataTable('#tbl_perfiles_asignar')) {
                $('#tbl_perfiles_asignar').DataTable().destroy();
                $('#tbl_perfiles_asignar tbody').empty();
            }

            tbl_modulos = $('#tbl_perfiles_asignar').DataTable({
                ajax: {
                    url: '{{ route('perfiles.asignar') }}', // Llamada AJAX a la ruta
                    type: 'GET',
                    dataSrc: ''
                },
                columns: [{
                        data: 'id_perfil'
                    },
                    {
                        data: 'descripcion'
                    },
                    {
                        data: 'estado'
                    },
                    {
                        data: 'fecha_creacion'
                    },
                    {
                        data: 'fecha_actualizacion'
                    },
                    {
                        data: 'opciones'
                    }
                ],
                responsive: {
                    details: {
                        type: 'column', // Esto mantiene la tabla responsive y permite ocultar las columnas
                        target: 0 // Control en la primera columna para mostrar detalles en pantallas pequeñas
                    }
                },
                columnDefs: [{
                        targets: [3, 4],
                        visible: false
                    }, // Ocultar columnas de fecha creación y actualización
                    {
                        targets: 2, // Columna de estado
                        createdCell: function(td, cellData) {
                            $(td).html(cellData === 'Activo' ? 'Activo' : 'Inactivo');
                        }
                    },
                    {
                        targets: 5, // Columna de opciones
                        sortable: false,
                        render: function() {
                            return "<center>" +
                                "<span class='btnSeleccionarPerfil text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Seleccionar perfil'>" +
                                "<i class='fas fa-check fs-5'></i>" +
                                "</span>" +
                                "</center>";
                        }
                    }
                ],
                initComplete: function() {
                    $('#tbl_perfiles_asignar').DataTable().columns.adjust();
                },
                language: {
                    url: 'assets/languages/Spanish.json' // Ruta del archivo de idioma en español
                }
            });
        }

        // Función para cargar el árbol de módulos usando jsTree
        function iniciarArbolModulos() {
            $.ajax({
                url: '{{ route('obtener_modulos') }}',
                type: 'GET',
                success: function(response) {
                    modulos_sistema = response; // Guarda la respuesta en la variable global
                    $('#modulos').jstree({
                        'core': {
                            "check_callback": true,
                            'data': response
                        },
                        "checkbox": {
                            "keep_selected_style": true,
                        },
                        "types": {
                            "default": {
                                "icon": "fas fa-laptop text-warning"
                            }
                        },
                        "plugins": ["wholerow", "checkbox", "types", "changed"]
                    }).bind("loaded.jstree", function(event, data) {
                        $(this).jstree("open_all");
                    });
                },
                error: function(xhr) {
                    console.error('Error al obtener los módulos:', xhr);
                }
            });
        }
    });
</script>


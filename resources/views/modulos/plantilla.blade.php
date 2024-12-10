<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Noir Beta')</title>

    <link rel="shortcut icon" href="/assets/dist/img/logos_empresas/Image_fox_white.png" type="image/x-icon">

    <!-- ============================================================================================================= -->
    <!-- REQUIRED CSS -->
    <!-- ============================================================================================================= -->


    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- iCheck for checkboxes and radio inputs -->
    <!-- <link rel="stylesheet" href="public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css"> -->

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

    <!-- Notie Alert -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/notie/dist/notie.min.css">

    <link rel="stylesheet" href="/assets/dist/css/toastr.min.css">

    <!-- Jquery CSS -->
    <link rel="stylesheet" href="/assets/plugins/jquery-ui/css/jquery-ui.css">

    <!-- Bootstrap 5 -->
    <link href="/assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/dist/css/select.dataTables.min.css" rel="stylesheet">

    <!-- JSTREE CSS -->
    <link rel="stylesheet" href="/assets/dist/css/jstree.min.css" />

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">


    <!-- Select2 -->
    <link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


    <!-- ============================================================
    =ESTILOS PARA USO DE DATATABLES CSS
    ===============================================================-->
    <link rel="stylesheet" href="/assets/dist/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/assets/dist/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="/assets/dist/css/buttons.dataTables.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="/assets/dist/css/style_width_responsive.css">

    <!-- Estilos personzalidos -->
    <link rel="stylesheet" href="/assets/dist/css/plantilla.css">

    <!-- ============================================================================================================= -->
    <!-- ============================================================================================================= -->
    <!-- ============================================================================================================= -->
    <!-- ============================================================================================================= -->
    <!-- REQUIRED SCRIPTS -->
    <!-- ============================================================================================================= -->
    <!-- ============================================================================================================= -->
    <!-- ============================================================================================================= -->
    <!-- ============================================================================================================= -->

    <!-- jQuery -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->

    <!-- Bootstrap 4 -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- ChartJS -->
    <script src="/assets/plugins/chart.js/Chart.min.js"></script>

    <script src="/assets/dist/js/canvasjs.min.js"></script>

    <!-- InputMask -->
    <script src="/assets/plugins/moment/moment.min.js"></script>
    <!-- <script src="public/assets/plugins/inputmask/jquery.inputmask.min.js"></script> -->

    <!-- SweetAlert2 -->
    <script src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>

    <!-- Notie Alert -->
    <script src="https://unpkg.com/notie"></script>

    <script src="/assets/dist/js/toastr.min.js"></script>

    <!-- jquery UI -->
    <script src="/assets/plugins/jquery-ui/js/jquery-ui.js"></script>

    <!-- JS Bootstrap 5 -->
    <script src="/assets/dist/js/bootstrap.bundle.min.js"></script>


    <!-- JSTREE JS -->
    <script src="/assets/dist/js/jstree.min.js"></script>


    <script src="https://unpkg.com/quagga@0.12.1/dist/quagga.min.js"></script>

    <!-- date-range-picker -->
    <script src="/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- ============================================================
    =LIBRERIAS PARA USO DE DATATABLES JS
    ===============================================================-->
    <script src="/assets/dist/js/jquery.dataTables.min.js"></script>
    <script src="/assets/dist/js/dataTables.responsive.min.js"></script>
    <script src="/assets/dist/js/jquery.tabledit.min.js"></script>



    <!-- <script src="public/assets/dist/js/dataTables.fixedColumns.min.js"></script> -->


    <!-- ============================================================
    =LIBRERIAS PARA EXPORTAR A ARCHIVOS
    ===============================================================-->
    <script src="/assets/dist/js/dataTables.buttons.min.js"></script>
    <script src="/assets/dist/js/jszip.min.js"></script>
    <script src="/assets/dist/js/buttons.html5.min.js"></script>
    <script src="/assets/dist/js/buttons.print.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.colVis.min.js"></script>

    <!-- Bootstrap Switch -->
    <!-- <script src="public/assets/dist/js/bootstrap-switch"></script>
    <script src="public/assets/dist/js/bootstrap4-toggle.min.js"></script> -->

    <!-- Select2 -->
    <script src="/assets/plugins/select2/js/select2.full.min.js"></script>

    <!-- Select2 -->
    <script src="/assets/plugins/select2/js/select2.full.min.js"></script>

    <!-- AdminLTE App -->
    <script src="/assets/dist/js/adminlte.min.js"></script>
    <script src="/assets/dist/js/plantilla.js"></script>

    <script src="/assets/dist/js/funciones_globales.js"></script>

    {{-- <!-- <script src="public/assets/dist/js/demo.js"></script> -->
    <style>
        .nav-treeview .nav-item .nav-link {
            padding-left: 30px;
        }
    </style>
     --}}

</head>


<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('modulos.layouts.navbar')
        @include('modulos.layouts.aside')

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script>
        // $(document).ready(function() {
        //     // Verificar si hay una vista almacenada en la sesión
        //     @if(session('vista_usuario'))
        //         // Cargar la vista almacenada dinámicamente
        //         cargarPlantilla('{{ session('vista_usuario') }}', 'content-wrapper');
        //         // Marcar el enlace correspondiente como activo
        //         $(".nav-link").removeClass('active');
        //         $(".nav-link").filter(function() {
        //             return $(this).attr('onclick') === "cargarPlantilla('{{ session('vista_usuario') }}', 'content-wrapper')";
        //         }).addClass('active');
        //     @else
        //         // Si no hay vista, cargar por defecto el dashboard
        //         cargarPlantilla('dashboard', 'content-wrapper');
        //         $(".nav-link").removeClass('active');
        //         $(".nav-link").first().addClass('active'); // Marca "Dashboard" como activo por defecto
        //     @endif
        // });

        // function cargarPlantilla(contenido, contenedor) {
        //     $.ajax({
        //         url: '{{ route('cargar.contenido') }}',
        //         type: 'GET',
        //         data: { contenido: contenido }, // Envía qué contenido cargar
        //         success: function(data) {
        //             $("." + contenedor).html(data); // Reemplaza solo el contenido del contenedor
        //         },
        //         error: function(error) {
        //             console.log("Error al cargar la página", error);
        //         }
        //     });
        // }

        // Manejar el clic en los enlaces de navegación
        $(".nav-link").on('click', function() {
            $(".nav-link").removeClass('active');
            $(this).addClass('active');
        });
        $(document).ready(function() {
            // Verificar si hay una vista almacenada en la sesión
            @if(session('vista_usuario'))
                // Cargar la vista almacenada dinámicamente
                cargarPlantilla('{{ session('vista_usuario') }}', 'content-wrapper');
            @else
                // Si no hay vista, cargar por defecto el dashboard
                cargarPlantilla('dashboard', 'content-wrapper');
            @endif

            
        // Obtener el nombre y logo de la empresa desde localStorage
        const nombreEmpresa = localStorage.getItem('nombreEmpresaSeleccionada') || 'SIN REGISTRAR';
            const logoEmpresa = localStorage.getItem('logoEmpresaSeleccionada') || 'no_image.jpg';

            // Establecer el nombre comercial y logo en el aside
            $('#nombre_comercial').text(nombreEmpresa);
            $('#logo_sistema').attr('src', `/storage/assets/imagenes/empresas/${logoEmpresa}`);
    });

        function cargarPlantilla(contenido, contenedor) {
            $.ajax({
                url: '{{ route('cargar.contenido') }}',
                type: 'GET',
                data: { contenido: contenido }, // Envía qué contenido cargar
                success: function(data) {
                    $("." + contenedor).html(data); // Reemplaza solo el contenido del contenedor
                },
                error: function(error) {
                    console.log("Error al cargar la página", error);
                }
            });
        }

    </script>

</body>




</html>

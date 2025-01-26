<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="m-0 fw-bold">CARGA MASIVA DE PRODUCTOS</h2>
            </div><!-- /.col -->
            <div class="col-sm-6 d-none d-md-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                    <li class="breadcrumb-item active">Carga Masiva de Productos</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- FILA PARA INPUT FILE -->
        <div class="card card-gray shadow mt-4">
            <div class="card-body px-3 py-3" style="position: relative;">
                <span class="titulo-fieldset px-3 py-1">SELECCIONE EL ARCHIVO EXCEL</span>
                <div class="row my-3">
                    <div class="col-lg-9">
                        <form method="POST" action="{{ route('carga_masiva_productos') }}"
                            enctype="multipart/form-data" id="form_cargar_productos">
                            @csrf
                            <input type="file" name="fileProductos" id="fileProductos" class="form-control"
                                accept=".xls, .xlsx, .xlsm">
                        </form>
                    </div>
                    <div class="col-lg-3">
                        <button class="btn btn-sm btn-success w-100" id="btnCargar" style="position: relative;">
                            <span class="text-button fw-bold fs-6">INICIAR CARGA</span>
                            <span class="btn fw-bold icon-btn-success">
                                <i class="fas fa-save fs-5"></i>
                            </span>
                        </button>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <a href='archivos/DataPAraLEER CRGMSV(1).xlsx' class="btn btn-sm btn-info w-25 fw-bold"
                            style="position: relative;">
                            <span class="text-button">Descargar Plantilla</span>
                            <span class="btn fw-bold icon-btn-custom d-flex align-items-center">
                                <i class="fas fa-cloud-download-alt fs-5"></i>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-12">
                        <table id="tbl_cargas_masivas" class="table w-100 shadow border responsive border-secondary">
                            <thead class="bg-main">
                                <tr style="font-size: 15px;">
                                    <th>Carga N°</th> <!-- 1 -->
                                    <th>Núcleos Insert.</th> <!-- 2 -->
                                    <th>Núcleos Omit.</th> <!-- 3 -->
                                    <th>Centros Costo Insert.</th> <!-- 4 -->
                                    <th>Centros Costo Omit.</th> <!-- 5 -->
                                    <th>Categorías Insert.</th> <!-- 6 -->
                                    <th>Categorías Omit.</th> <!-- 7 -->
                                    <th>Almacenes Insert.</th> <!-- 8 -->
                                    <th>Almacenes Omit.</th> <!-- 9 -->
                                    <th>Unds Med. Insert.</th> <!-- 10 -->
                                    <th>Unds Med. Omit.</th> <!-- 11 -->
                                    <th>Tipo Afectación Insert.</th> <!-- 12 -->
                                    <th>Tipo Afectación Omit.</th> <!-- 13 -->
                                    <th>Productos Insert.</th> <!-- 14 -->
                                    <th>Productos Omit.</th> <!-- 15 -->
                                    <th>Estado</th> <!-- 16 -->
                                    <th>Fecha Carga</th> <!-- 17 -->
                                </tr>
                            </thead>
                            <tbody class="text-small">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- Div para loading -->
<div class="loading d-none">Loading</div>

<!-- Script JS para manejar la carga -->
<script>
$(document).ready(function() {
    // Inicializa el DataTable de cargas masivas
    inicializarDataTableCargasMasivas();

    // Manejador del botón para cargar el archivo Excel
    $("#btnCargar").on('click', function(e) {
        e.preventDefault();
        cargarArchivoExcel();
    });
});

// Función para inicializar el DataTable de cargas masivas
function inicializarDataTableCargasMasivas() {
    if ($.fn.DataTable.isDataTable('#tbl_cargas_masivas')) {
        $('#tbl_cargas_masivas').DataTable().destroy();
        $('#tbl_cargas_masivas tbody').empty();
    }

    $("#tbl_cargas_masivas").DataTable({
        dom: 'Bfrtip',
        buttons: ['pageLength'],
        pageLength: 25,
        ajax: {
            url: "{{ route('listar_cargas_masivas') }}", // Ruta que llama al proceso almacenado
            type: 'GET',  // Usa GET para obtener los datos
            dataType: 'json',  // Especifica que esperas datos en formato JSON
            dataSrc: '',  // Los datos son planos

        },
        autoWidth: false,
        columns: [
            { data: 'id' },  // Carga N°
            { data: 'nucleos_insertados' },  // Núcleos Insertados
            { data: 'nucleos_omitidos' },  // Núcleos Omitidos
            { data: 'centros_costo_insertados' },  // Centros Costo Insertados
            { data: 'centros_costo_omitidos' },  // Centros Costo Omitidos
            { data: 'categorias_insertadas' },  // Categorías Insertadas
            { data: 'categorias_omitidas' },  // Categorías Omitidas
            { data: 'almacenes_insertados' },  // Almacenes Insertados
            { data: 'almacenes_omitidos' },  // Almacenes Omitidos
            { data: 'codigo_unidades_medida_insertadas' },  // Unidades de Medida Insertadas
            { data: 'codigo_unidades_medida_omitidas' },  // Unidades de Medida Omitidas
            { data: 'tipo_afectacion_insertados' },  // Tipo Afectación Insertados
            { data: 'tipo_afectacion_omitidos' },  // Tipo Afectación Omitidos
            { data: 'productos_insertados' },  // Productos Insertados
            { data: 'productos_omitidos' },  // Productos Omitidos
            {
                data: 'estado_carga',
                render: function(data, type, row) {
                    return data == 1 
                        ? `<i class='fas fa-check-circle text-success'></i>` 
                        : `<i class='fas fa-times-circle text-danger'></i>`;
                }
            },  // Estado
            { data: 'created_at' }  // Fecha Carga
        ],
        columnDefs: [
            {
                targets: [2, 4, 9, 14, 15],
                visible: false  // Ocultar columnas si es necesario
            }
        ],
        language: {
            url: 'assets/languages/Spanish.json'  // Ruta al archivo de idioma español
        }
    });
}

// Función para cargar el archivo Excel
function cargarArchivoExcel() {
    if ($("#fileProductos").get(0).files.length == 0) {
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Debes seleccionar un archivo (Excel)',
            showConfirmButton: false,
            timer: 2000
        });
    } else {
        var extensiones_permitidas = ['xlsx', 'xls', 'xlsm'];
        var input_file_productos = $("#fileProductos");
        var exp_reg = new RegExp("([a-zA-Z0-9\\s_\\.-:])+(" + extensiones_permitidas.join('|') + ")$");

        if (!exp_reg.test(input_file_productos.val().toLowerCase())) {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Debes seleccionar un archivo con extensión .xls, .xlsx, o .xlsm',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }

        var datos = new FormData($("#form_cargar_productos")[0]);
        $("#btnCargar").prop("disabled", true);
        $(".loading").removeClass("d-none"); // Mostrar el div "Loading"

        $.ajax({
            url: "{{ route('carga_masiva_productos') }}",
            type: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                $("#btnCargar").prop("disabled", false);
                $(".loading").addClass("d-none"); // Ocultar el div "Loading"
                $("#fileProductos").val(''); // Limpiar el campo de archivo

                if (response.tipo_msj === 'success') {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.msj +
                            '<br>Núcleos Insertados: ' + response.nucleosInsertados +
                            '<br>Centros de Costo Insertados: ' + response.centrosCostoInsertados +
                            '<br>Categorías Insertadas: ' + response.categoriasInsertadas +
                            '<br>Almacenes Insertados: ' + response.almacenesInsertados +
                            '<br>Unidades de Medida Insertadas: ' + response.codigoUnidadesMedidaInsertadas +
                            '<br>Tipo Afectación IGV Insertados: ' + response.tipoAfectacionInsertados +
                            '<br>Productos Insertados: ' + response.productosInsertados,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    inicializarDataTableCargasMasivas(); // Recargar la tabla tras la carga exitosa
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: response.msj,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            },
            error: function() {
                $("#btnCargar").prop("disabled", false);
                $(".loading").addClass("d-none");
                $("#fileProductos").val('');

                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Ocurrió un error al procesar la solicitud.',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    }
}

</script>

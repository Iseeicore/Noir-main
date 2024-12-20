<?php

use App\Http\Controllers\AjaxrutasController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CodigoUnidadMedidaController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SeguridadController;
use App\Http\Controllers\TipoAfectacionIgvController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdministrativoController;
use App\Http\Controllers\ProductoModeloreqController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\TipoCambioController;
use App\Http\Controllers\DocumentoIngresoController;
use App\Http\Controllers\DocumentoSalidaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CajaChicaController;
use App\Http\Controllers\CajaContableController;
use App\Http\Controllers\ReporteCajaContableController;
use App\Http\Controllers\ReporteCajaChicaController;
use App\Http\Controllers\CentroCostoController;
use App\Http\Controllers\BancoController;






// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    // Verifica si el usuario está autenticado
    if (Auth::check()) {
        // Si está autenticado, cargar la plantilla
        return view('welcome');  // Cargar la plantilla principal
    } else {
        // Si no está autenticado, redirigir a la vista de login
        return redirect()->route('login_validacion');
    }
});

// routes/web.php

//Carga de la vistas
Route::get('/cargar-contenido', [AjaxrutasController::class, 'cargarContenido'])->name('cargar.contenido');
Route::get('/listar-cargas-masivas', [ProductoController::class, 'listarCargasMasivas'])->name('listar_cargas_masivas');


//Prodcutos Modelo
Route::get('/productos/listar', [ProductoModeloreqController::class, 'listarProductos'])->name('productos.listar');
Route::post('/productos/generar-codigo', [ProductoModeloreqController::class, 'generarCodigoProducto'])->name('generar_codigo_producto_Modelo');
Route::post('/productos/registrar_producto_modelo', [ProductoModeloreqController::class, 'registrarProductoModelo'])->name('registrar_productomodeloreq');
Route::get('/obtener-producto-modelo/{id}', [ProductoModeloreqController::class, 'obtenerProducto'])->name('obtener_producto_modeloreq');
Route::post('/producto/actualizarmodeloreq', [ProductoModeloreqController::class, 'actualizarProductoModeloreq'])->name('producto.actualizarmodeloreq');
Route::post('/productomodelo/desactivar/{id}', [ProductoModeloreqController::class, 'desactivarProductomodelo'])->name('producto.desactivarmodelo');
Route::post('/productomodelo/activar/{id}', [ProductoModeloreqController::class, 'activarProductomodelo'])->name('producto.activarmodelo');


//categoria
Route::post('/Categoria/listar', action: [CategoriaController::class, 'listarCategoriasDatos'])->name('categoria.listar');
Route::post('/categorias/actualizar/{id}', [CategoriaController::class, 'actualizarCategoria'])->name('categoria.actualizar');
Route::post('/categorias/guardar', [CategoriaController::class, 'guardarCategoria'])->name('categoria.guardar');
Route::delete('/categoria/eliminar/{id}', [CategoriaController::class, 'eliminarCategoria'])->name('categoria.eliminar');
Route::post('/categoria/cambiar_estado/{id}', [CategoriaController::class, 'cambiarEstadoCategoria'])->name('categoria.cambiar_estado');

//Unidad Medida
Route::post('/UnidadMedida/listar', action: [CodigoUnidadMedidaController::class, 'listarUnidadesMedidaDatos'])->name('UnidadesMedida.listar');
Route::post('/UnidadMedida/actualizar/{id}', [CodigoUnidadMedidaController::class, 'actualizarUnidadMedida'])->name('UnidadMedida.actualizar');
Route::post('/UnidadMedida/guardar', [CodigoUnidadMedidaController::class, 'guardarUnidadMedida'])->name('UnidadMedida.guardar');
Route::delete('/UnidadMedida/eliminar/{id}', [CodigoUnidadMedidaController::class, 'eliminarUnidadMedida'])->name('UnidadMedida.eliminar');
Route::post('/UnidadMedida/cambiar_estado/{id}', [CodigoUnidadMedidaController::class, 'cambiarEstadoUnidadMedida'])->name('UnidadMedida.cambiar_estado');


//Empresa
Route::post('/empresas/guardar', [EmpresasController::class, 'guardarEmpresa'])->name('empresa.guardar');
Route::get('/empresas/listar', [EmpresasController::class, 'listarEmpresas'])->name('empresas.listar');
Route::get('/empresas/obtener/{id}', [EmpresasController::class, 'obtenerEmpresa'])->name('empresas.obtener');
Route::post('/empresas/actualizar/{id}', [EmpresasController::class, 'actualizarEmpresa'])->name('empresas.actualizar');
Route::delete('/empresas/eliminar/{id}', [EmpresasController::class, 'eliminarEmpresa'])->name('empresas.eliminar');
Route::get('/empresa-seleccionada', [EmpresasController::class, 'obtenerEmpresaSeleccionada'])->name('empresa.seleccionada');

//centro costo
Route::post('/centro-costo/listarvista', action: [CentroCostoController::class, 'listarCentroCostoDatos'])->name('centro-costo.listar');
Route::post('/centro-costo/cambiar_estado/{id}', [CentroCostoController::class, 'cambiarEstadoCentroCosto'])->name('centro-costo.cambiar_estado');
Route::post('/centro-costo/guardar', [CentroCostoController::class, 'guardarCentroCosto'])->name('centro-costo.guardar');
Route::post('/centro-costo/actualizar/{id}', [CentroCostoController::class, 'actualizarCentroCosto'])->name('centro-costo.actualizar');
Route::get('/centro-costo/cargar-nucleo', [CentroCostoController::class, 'listarnucleo'])->name('centro-costo.cargar_nucleo');
Route::delete('/centro-costo/eliminar/{id}', [CentroCostoController::class, 'eliminarCentroCosto'])->name('centro-costo.eliminar');



//Documentos


Route::post('/documentos/requerimientos', [DocumentosController::class, 'listarRequerimientos'])->name('requerimiento.listar');
Route::get('/requerimiento/generar-codigo/{idUsuario}', [DocumentosController::class, 'generarCodigoRequerimiento'])->name('requerimiento.generar_codigo');
Route::get('/usuario/datos/{idUsuario}', [DocumentosController::class, 'obtenerDatosUsuario'])->name('usuario.datos');
Route::get('/documento/cargar-centros-costo', [DocumentosController::class, 'cargarCentrosCosto'])->name('documento.cargar_centros_costo');


Route::get('/documento/cargar-unidad-medida', [DocumentosController::class, 'cargarUnidadMedida'])->name('documento.cargar_unidad_medida');
Route::post('/guardar-requerimiento', [DocumentosController::class, 'guardarRequerimiento'])->name('guardar_requerimiento');
Route::get('/validar-acceso-requerimiento', [DocumentosController::class, 'validarAccesoRequerimiento'])->name('validar.acceso.requerimiento');

Route::post('/documentos/requerimientos_rev', [DocumentosController::class, 'listarRequerimientosRevicion'])->name('requerimiento.listarRevicion');
Route::get('/requerimiento/{id}', [DocumentosController::class, 'obtenerRequerimiento'])->name('obtener_requerimiento');

Route::post('/requerimiento/actualizarEstado', [DocumentosController::class, 'actualizarEstadoRequerimiento'])->name('requerimiento.actualizarEstado');


Route::post('/requerimiento/cambiarEstado', [DocumentosController::class, 'cambiarEstadoRequerimiento'])->name('requerimiento.cambiarEstado');
Route::post('/documento-ingreso', [DocumentoIngresoController::class, 'store'])->name('documento-ingreso.store');




//Documento Ingreso


Route::post('/listar-documentos', [DocumentoIngresoController::class, 'listarDocumentos'])->name('listar.documentos');

Route::get('/documento/cargar-tipoafectacion', [DocumentoIngresoController::class, 'cargarTipoAfectacionIgv'])->name('documento.cargar_tipoafectacion');
Route::get('/documento/producto-sin-ubicacion', [DocumentoIngresoController::class, 'cargarProductosinubicacion'])->name('documento.cargar_productoSinUbicacion');
Route::get('/documento-ingreso/generar-codigo', [DocumentoIngresoController::class, 'generarCodigoDocumento'])->name('documento-ingreso.generar-codigo');



// Route::get('/documento-ingreso/tipo-operacion', [DocumentoIngresoController::class, 'cargarTipoOperacion'])->name('documento-ingreso.tipo-operacion');
Route::get('/documento-ingreso/cambio-tipo-operaciones-entrada', [DocumentoIngresoController::class, 'cambioDeTipoOperacionesEntrada'])->name('documento-ingreso.cambio-tipo-operaciones-entrada');



Route::get('/documento-ingreso/proveedores', [DocumentoIngresoController::class, 'cargarProveedores'])->name('documento-ingreso.proveedores');

Route::get('/cargar-almacenes-usuario', [DocumentoIngresoController::class, 'cargarAlmacenes'])->name('cargar_almacenes_usuario');


Route::get('/documento-ingreso/comprobante-pago', [DocumentoIngresoController::class, 'cargarComprobantePago'])->name('documento-ingreso.comprobante-pago');
Route::post('/documento-ingreso/cargar-tipo-cambio', [DocumentoIngresoController::class, 'cargarTipoCambioPorFecha'])->name('documento-ingreso.cargar-tipo-cambio-por-fecha');

Route::get('/documento-ingreso/{id}', [DocumentoIngresoController::class, 'obtenerDocumentoIngreso'])->name('obtener_documento_ingreso');


//Documento Salida
Route::post('/listar-documentos-Salida', [DocumentoSalidaController::class, 'listarDocumentosSalida'])->name('documento-salida.listar');
Route::get('/documento-salida/generar-codigo', [DocumentoSalidaController::class, 'generarCodigoDocumentoSalida'])->name('documento-salida.generar-codigo');
Route::get('/documento-salida/obtener-almacen-usuario', [DocumentoSalidaController::class, 'obtenerAlmacenUsuario'])->name('documento-salida.obtener-almacen-usuario');
Route::get('/documento-salida/obtener-almacenes-destino', [DocumentoSalidaController::class, 'obtenerAlmacenesExcluyendoActual'])->name('documento-salida.obtener-almacenes-destino');
Route::get('/documento-salida/obtener-usuarios', [DocumentoSalidaController::class, 'obtenerUsuariosExcluyendoActual'])->name('documento-salida.obtener-usuarios');
Route::get('/documento/cargar-producto-usuario-actual', [DocumentoSalidaController::class, 'cargarProductoUsuarioActual'])->name('documento.cargar_producto_usuario_actual');
Route::post('/documento-salida/store', [DocumentoSalidaController::class, 'store'])->name('documento-salida.store');
Route::get('/documento-salida/{id}', [DocumentoSalidaController::class, 'obtenerDocumentoSalida'])->name('documento-salida.obtener');




//Dashboard
Route::get('/kardex/quincenas', [DashboardController::class, 'obtenerMovimientosQuincenales'])->name('kardex.quincenas');
Route::get('/productos/dashboard', [DashboardController::class, 'listarProductosDashboard'])->name('productos.listar.dashboard');
Route::get('/productos/poco-stock', [DashboardController::class, 'obtenerProductosPocoStock']);
Route::get('/dashboard/total-productos', [DashboardController::class, 'obtenerTotalProductos']);

Route::get('/dashboard/total-compras-almacen', [DashboardController::class, 'obtenerTotalComprasPorAlmacen']);

Route::get('/dashboard/productostiempo', [DashboardController::class, 'obtenerProductosPorAlmacen']);
Route::get('/dashboard/obtener-variacion-precios', [DashboardController::class, 'obtenerVariacionPrecios']);




Route::get('/productos/poco-stock/conteo', [DashboardController::class, 'obtenerConteoProductosPocoStock']);
Route::get('/dashboard/ventas-dia', [DashboardController::class, 'obtenerSalidasDelDia']);
Route::get('/kardex/ingresos-dia', [DashboardController::class, 'obtenerTotalIngresosDelDia']);
Route::get('/devoluciones/del-dia', [DashboardController::class, 'obtenerDevolucionesDelDia']);





//Rutas referentes de Productos
Route::post('/carga-masiva-productos', [ProductoController::class, 'cargaMasivaProductos'])->name('carga_masiva_productos');
Route::get('/listar-productos', [ProductoController::class, 'listarProductos'])->name('listar_productos');
// Route::get('/almacenes', 'AlmacenController@index')->name('almacenes.index');
Route::get('/listar-almacenes', [AlmacenController::class, 'listarAlmacenes'])->name('listar_almacenes');
Route::get('/listar-categorias', [CategoriaController::class, 'listarCategorias'])->name('listar_categorias');
Route::get('/productos/registrar', [ProductoController::class, 'mostrarFormularioRegistro'])->name('productos.registrar');
Route::get('/obtener-producto/{id}', [ProductoController::class, 'obtenerProducto'])->name('obtener_producto');
Route::post('/producto/desactivar/{id}', [ProductoController::class, 'desactivarProducto'])->name('producto.desactivar');
Route::post('/producto/activar/{id}', [ProductoController::class, 'activarProducto'])->name('producto.activar');
Route::get('/producto/actualizar-stock/{id}/{accion}', [ProductoController::class, 'gestionarStockVista'])->name('producto.gestionar_stock');
Route::post('/producto/actualizar-stock', [ProductoController::class, 'actualizarStock'])->name('producto.actualizar_stock');
Route::get('/listar_categorias_formulario', [CategoriaController::class, 'listarCategoriasFormulario'])->name('listar_Categorias_Formulario');
// Route::get('/listar-familias', [FamiliaController::class, 'listarFamilias'])->name('listar_familias');


Route::post('/producto/actualizar', [ProductoController::class, 'actualizarProducto'])->name('producto.actualizar');
Route::get('/listar-tipo-afectacion-igv', [TipoAfectacionIgvController::class, 'listarTipoAfectacionIgv'])->name('listar_tipo_afectacion_igv');
Route::get('/listar_almacenesReg', [AlmacenController::class, 'listarAlmacenesReg'])->name('listar_almacenesReg');
Route::get('/listar-unidades-medida', [CodigoUnidadMedidaController::class, 'listarUnidadesMedida'])->name('listar_unidades_medida');
Route::post('/registrar_producto', [ProductoController::class, 'registrarProducto'])->name('registrar_producto');

Route::get('/modulosProducto/editar/{id}', [ProductoController::class, 'editarProducto'])->name('editarProducto');
Route::post('/generar_codigo_producto', [ProductoController::class, 'generarCodigoProducto'])->name('generar_codigo_producto');


//kardex

// Route::post('/reporte-kardex-producto', [KardexController::class, 'reporteKardexPorProducto'])->name('reporte.kardex.producto');
Route::get('/kardex/listar', [KardexController::class, 'listarKardex'])->name('kardex.listar');

Route::post('/reporte-kardex-totalizado', [KardexController::class, 'reporteKardex'])->name('reporte.kardex.totalizado');
Route::post('/reporte/kardex/almacen', [KardexController::class, 'reporteKardexPorAlmacen'])->name('reporte.kardex.almacen');
Route::post('/reporte/kardex/detalles', [KardexController::class, 'reporteKardexDetalles'])->name('reporte.kardex.detalles');

//Administracion
Route::post('/proveedores/listar',  [AdministrativoController::class, 'listarProveedores'])->name('proveedores.listar');
Route::post('/administrativo/proveedores/obtener-datos-ruc', [AdministrativoController::class, 'obtenerDatosDelRuc'])->name('proveedores.obtener_datos_ruc');
Route::get('/administrativo/proveedores/generar-codigo', [AdministrativoController::class, 'generarCodigoProveedor'])->name('proveedores.generar_codigo');
Route::post('/proveedores/guardar', [AdministrativoController::class, 'guardarProveedor'])->name('proveedores.guardar');
Route::post('/proveedores/actualizar/{id}', [AdministrativoController::class, 'actualizarProveedor'])->name('proveedores.actualizar');
Route::delete('/proveedores/eliminar/{id}', [AdministrativoController::class, 'eliminarProveedor'])->name('proveedores.eliminar');
Route::post('/proveedores/cambiar_estado/{id}', [AdministrativoController::class, 'cambiarEstadoProveedor'])->name('proveedores.cambiar_estado');

//Extras Config
Route::get('/tipo-cambio/config', [TipoCambioController::class, 'getTipoCambioConfig'])->name('tipo.cambio.config.get');
Route::post('/tipo-cambio/config/update', [TipoCambioController::class, 'updateTipoCambioConfig'])->name('tipo.cambio.config.update');
Route::post('/tipo-cambio/config/restaurar', [TipoCambioController::class, 'restaurarTipoCambioConfig'])->name('tipo.cambio.config.restaurar');


Route::get('ruc/config', [AdministrativoController::class, 'getRucConfig'])->name('ruc.config.get');
Route::post('ruc/config', [AdministrativoController::class, 'updateRucConfig'])->name('ruc.config.update');
Route::post('/ruc/config/restaurar', [AdministrativoController::class, 'restaurarRucConfig'])->name('ruc.config.restaurar');

Route::get('/verificar-permiso-editar', [AdministrativoController::class, 'verificarPermisoEditar'])->name('verificar.permiso.editar');
Route::get('/codigo-acceso', [AdministrativoController::class, 'getCodigoAcceso'])->name('codigo.acceso.get');
Route::post('/codigo-acceso', [AdministrativoController::class, 'updateCodigoAcceso'])->name('codigo.acceso.update');
Route::post('/validar-codigo-acceso', [AdministrativoController::class, 'validarCodigo'])->name('validar.codigo.acceso');

Route::get('/buscar-usuario-dinamico', [SeguridadController::class, 'buscarUsuarioDinamico']);
Route::post('/actualizar-password', [SeguridadController::class, 'actualizarPassword']);


//purebas tipo de cambio

Route::get('/tipo-cambio/hoy', [TipoCambioController::class, 'tipoCambioHoy'])->name('tipo.cambio.hoy');
Route::get('/tipo-cambio/fecha', [TipoCambioController::class, 'tipoCambioPorFecha'])->name('tipo.cambio.fecha');

Route::post('/tipo-cambio/listar', [TipoCambioController::class, 'listarTipoCambio'])->name('tipo.cambio.listar');


// CAJA CHICA

Route::get('caja-chica', [CajaChicaController::class, 'index'])->name('caja_chica.index');

Route::post('/crear-saldo-inicial', [CajaChicaController::class, 'crearSaldoInicial'])->name('caja_chica.crear_saldo');
Route::post('/registrar-gasto', [CajaChicaController::class, 'registrarGasto'])->name('caja_chica.registrar_gasto');
Route::get('/listar-responsables', [CajaChicaController::class, 'listarResponsables'])->name('listar_responsables');
Route::get('/caja-chica/listar', [CajaChicaController::class, 'listar'])->name('caja_chica.listar');
Route::get('/caja-chica/movimientos', [CajaChicaController::class, 'listarMovimientos'])->name('caja_chica.listar_movimientos');

Route::post('/caja-chica/validar-banco', [CajaChicaController::class, 'validarBanco'])->name('caja_chica.validar_banco');

Route::get('/caja-chica/listar-bancos', [CajaChicaController::class, 'listarBancos'])->name('caja_chica.listar_bancos');




// CAJA CONTABLE
Route::prefix('caja-contable')->group(function () {
    Route::get('/caja-contable', [CajaContableController::class, 'index'])->name('caja_contable.index');
    Route::post('/caja-contable/crear-saldo', [CajaContableController::class, 'crearSaldoInicial'])->name('caja_contable.crear_saldo');
    Route::post('/registrar-movimiento', [CajaContableController::class, 'registrarMovimiento'])->name('caja_contable.registrar_movimiento');
    Route::get('/listar', [CajaContableController::class, 'listar'])->name('caja_contable.listar');
    Route::get('/listar-movimientos', [CajaContableController::class, 'listarMovimientos'])->name('caja_contable.listar_movimientos');

    Route::get('/listar-responsables', [CajaContableController::class, 'listarResponsables'])->name('caja_contable.listar_responsables');
    // Ruta para cargar categorías
    Route::get('/caja-contable/categorias', [CajaContableController::class, 'listarCategorias'])->name('caja_contable.listar_categorias');

    Route::post('/caja-contable/validar-banco', [CajaContableController::class, 'validarBanco'])->name('caja_contable.validar_banco');
    Route::get('/caja-contable/listar-bancos', [CajaChicaController::class, 'listarBancos'])->name('caja_contable.listar_bancos');
});




// reporte caja chica
Route::post('/reportecajachica/filtrar', [ReporteCajaChicaController::class, 'filtrar'])->name('reportecajachica.filtrar');
Route::get('/reportecajachica/imprimir/{id}', [ReporteCajaChicaController::class, 'imprimir'])->name('reportecajachica.imprimir');
Route::get('/reportecajachica', [ReporteCajaChicaController::class, 'index'])->name('reportecajachica');
Route::get('/reportecajachica/listar', [ReporteCajaChicaController::class, 'listarMovimientos'])->name('reportecajachica.listar');
Route::get('/caja_chica/descripciones', [ReporteCajaChicaController::class, 'listarDescripciones'])->name('caja_chica.listar_descripciones');



// Rutas para el reporte de caja contable
Route::get('/reporte-caja-contable/listar', [ReporteCajaContableController::class, 'listar'])->name('reportecajacontable.listar');
Route::post('/reporte-caja-contable/filtrar', [ReporteCajaContableController::class, 'filtrar'])->name('reportecajacontable.filtrar');
// Ruta para listar las cajas contables
// Rutas para Reporte Caja Contable
Route::get('/reporte-caja-contable/cajas', [ReporteCajaContableController::class, 'listarCajasContables'])->name('reportecajacontable.cajas');
// Rutas para cargar los responsables
Route::get('/reporte-caja-contable/responsables', [ReporteCajaContableController::class, 'listarResponsables'])->name('reportecajacontable.responsables');
Route::get('/reportecajacontable/categorias', [ReporteCajaContableController::class, 'listarCategorias'])
    ->name('caja_contable.listar_categorias');

Route::post('/reportecajacontable/filtrar', [ReporteCajaContableController::class, 'filtrar'])
    ->name('reportecajacontable.filtrar');


// ruta de dashboard caja contable
Route::get('/caja-contable/medio-pago-datos', [CajaContableController::class, 'obtenerDatosMedioPago'])->name('caja_contable.medio_pago_datos');





Route::post('/bancos', [BancoController::class, 'store'])->name('bancos.store');
Route::resource('bancos', BancoController::class);
Route::delete('/bancos/{id}', [BancoController::class, 'destroy'])->name('bancos.destroy');



//Validaciones
Route::post('/login', [SeguridadController::class, 'login'])->name('login');
Route::get('/LoginValidacion', [SeguridadController::class,'LoginValidacion'])->name('login_validacion');
Route::post('/logout', [SeguridadController::class, 'logout'])->name('logout');

//seguridad
Route::get('/obtener-menu', [SeguridadController::class, 'obtenerMenu'])->name('obtener_menu');
Route::get('/obtener-submenu/{idMenu}', [SeguridadController::class, 'obtenerSubMenu'])->name('obtener_submenu');
Route::get('/perfiles/asignar', [PerfilController::class, 'obtenerPerfilesAsignar'])->name('perfiles.asignar');
//----------------------------------------------------------------
Route::post('/ajax/obtener-usuarios', [RegisterController::class, 'obtenerUsuarios']);
Route::get('/ajax/listar-perfiles', [RegisterController::class, 'listarPerfiles'])->name('listar_perfiles');
Route::get('/ajax/listar-areas', [RegisterController::class, 'listarAreas'])->name('listar_areas');
Route::get('/ajax/listar-almacenes', [RegisterController::class, 'listarAlmacenesRegister'])->name('listar_almacenes_register');

Route::post('/usuarios/update/{id}', [RegisterController::class, 'update'])->name('usuarios.update');

Route::post('/usuarios/store', [RegisterController::class, 'store'])->name('usuarios.store');
//----------------------------------------------------------------
Route::get('/listar-perfiles-asignar', [PerfilController::class, 'obtenerPerfilesAsignar'])->name('perfiles.asignar');
Route::get('/obtener-modulos', [ModuloController::class, 'obtenerModulos'])->name('obtener_modulos');
Route::post('/obtener-modulos-por-perfil', [PerfilController::class, 'obtenerModulosPorPerfil'])->name('obtener_modulos_por_perfil');
//----------------------------------------------------------------
Route::post('/registrar-perfil-modulo', [PerfilController::class, 'registrarPerfilModulo'])->name('registrar_perfil_modulo');
Route::post('/reorganizar-modulos', [PerfilController::class, 'reorganizarModulos'])->name('reorganizar_modulos');
Route::post('perfiles/obtener', [PerfilController::class, 'obtenerPerfiles'])->name('perfiles.obtener');
Route::post('perfiles/registrar', [PerfilController::class, 'registrarPerfil'])->name('perfiles.registrar');
Route::get('perfiles/editar/{id_perfil}', [PerfilController::class, 'editar'])->name('perfiles.editar');
Route::put('/perfiles/actualizar/{id_perfil}', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');





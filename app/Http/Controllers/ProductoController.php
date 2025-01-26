<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Almacen;
use App\Models\CentroCosto;
use App\Models\CodigoUnidadMedida;
use App\Models\TipoAfectacionIgv;
use App\Models\HistoricoCargaMasiva; // Añadido: Importar el modelo HistoricoCargaMasiva
use App\Models\Nucleo;
use App\Models\Producto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductoController extends Controller
{
    public function cargaMasivaProductos(Request $request)
{
    try {
        // Validar el archivo recibido
        $request->validate([
            'fileProductos' => 'required|mimes:xlsx,xls,xlsm'
        ]);

        $file = $request->file('fileProductos'); // Obtener el archivo de la solicitud
        $nombreArchivo = $file->getPathName(); // Obtener la ruta del archivo temporal

        // Cargar el archivo Excel
        $documento = IOFactory::load($nombreArchivo);

        // Contadores para cada tabla
        $nucleosInsertados = 0;
        $nucleosOmitidos = 0;
        $centrosCostoInsertados = 0;
        $centrosCostoOmitidos = 0;
        $categoriasInsertadas = 0;
        $categoriasOmitidas = 0;
        $almacenesInsertados = 0;
        $almacenesOmitidos = 0;
        $codigoUnidadesMedidaInsertadas = 0;
        $codigoUnidadesMedidaOmitidas = 0;
        $tipoAfectacionInsertados = 0;
        $tipoAfectacionOmitidos = 0;
        $productosInsertados = 0;
        $productosOmitidos = 0;

        // Insertar datos en la tabla Nucleo
        $hojaNucleo = $documento->getSheetByName("NUCLEO");
        if ($hojaNucleo && $hojaNucleo->getHighestDataRow() > 1) {
            [$nucleosInsertados, $nucleosOmitidos] = $this->insertarNucleos($hojaNucleo);
        }

        // Obtener todos los IDs de Nucleo para referencia
        $nucleos = Nucleo::pluck('id', 'nomb_nucleo')->toArray();

        // Insertar datos en la tabla Centro_Costo
        $hojaCentroCosto = $documento->getSheetByName("CENTRO COSTO");
        if ($hojaCentroCosto && $hojaCentroCosto->getHighestDataRow() > 1) {
            [$centrosCostoInsertados, $centrosCostoOmitidos] = $this->insertarCentrosCosto($hojaCentroCosto, $nucleos);
        }

        // Insertar datos en la tabla Categorias
        $hojaCategorias = $documento->getSheetByName("CATEGORIA");
        if ($hojaCategorias && $hojaCategorias->getHighestDataRow() > 1) {
            [$categoriasInsertadas, $categoriasOmitidas] = $this->insertarCategorias($hojaCategorias);
        }

        // Insertar datos en la tabla Unidad de Medida (CodigoUnidadMedida)
        $hojaUnidadMedida = $documento->getSheetByName("UNI_MED");
        if ($hojaUnidadMedida && $hojaUnidadMedida->getHighestDataRow() > 1) {
            [$codigoUnidadesMedidaInsertadas, $codigoUnidadesMedidaOmitidas] = $this->insertarCodigoUnidadMedida($hojaUnidadMedida);
        }

        // Insertar datos en la tabla Tipo_Afectacion_IGV
        $hojaTipoAfectacion = $documento->getSheetByName("Tipo_Afectacion_IGV");
        if ($hojaTipoAfectacion && $hojaTipoAfectacion->getHighestDataRow() > 1) {
            [$tipoAfectacionInsertados, $tipoAfectacionOmitidos] = $this->insertarTipoAfectacion($hojaTipoAfectacion);
        }

        // Insertar datos en la tabla Almacenes
        $hojaAlmacenes = $documento->getSheetByName("ALMACEN");
        if ($hojaAlmacenes && $hojaAlmacenes->getHighestDataRow() > 1) {
            [$almacenesInsertados, $almacenesOmitidos] = $this->insertarAlmacenes($hojaAlmacenes);
        }

        // Insertar datos en la tabla Productos
        $hojaProductos = $documento->getSheetByName("ProductoInicial");
        if ($hojaProductos && $hojaProductos->getHighestDataRow() > 1) {
            [$productosInsertados, $productosOmitidos] = $this->insertarProductos($hojaProductos);
        }

        // Guardar el resultado en la tabla historico_cargas_masivas
        $historico = HistoricoCargaMasiva::create([
            'nucleos_insertados' => $nucleosInsertados,
            'nucleos_omitidos' => $nucleosOmitidos,
            'centros_costo_insertados' => $centrosCostoInsertados,
            'centros_costo_omitidos' => $centrosCostoOmitidos,
            'categorias_insertadas' => $categoriasInsertadas,
            'categorias_omitidas' => $categoriasOmitidas,
            'almacenes_insertados' => $almacenesInsertados,
            'almacenes_omitidos' => $almacenesOmitidos,
            'codigo_unidades_medida_insertadas' => $codigoUnidadesMedidaInsertadas,
            'codigo_unidades_medida_omitidas' => $codigoUnidadesMedidaOmitidas,
            'tipo_afectacion_insertados' => $tipoAfectacionInsertados,
            'tipo_afectacion_omitidos' => $tipoAfectacionOmitidos,
            'productos_insertados' => $productosInsertados,
            'productos_omitidos' => $productosOmitidos,
            'estado_carga' => ($nucleosOmitidos == 0 && $centrosCostoOmitidos == 0 && $categoriasOmitidas == 0 && $almacenesOmitidos == 0 && $codigoUnidadesMedidaOmitidas == 0 && $tipoAfectacionOmitidos == 0 && $productosOmitidos == 0) ? 1 : 0,
        ]);

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => "Datos cargados correctamente.",
            'historico_id' => $historico->id, // ID del registro creado en historico_cargas_masivas
            'nucleosInsertados' => $nucleosInsertados,
            'nucleosOmitidos' => $nucleosOmitidos,
            'centrosCostoInsertados' => $centrosCostoInsertados,
            'centrosCostoOmitidos' => $centrosCostoOmitidos,
            'categoriasInsertadas' => $categoriasInsertadas,
            'categoriasOmitidas' => $categoriasOmitidas,
            'almacenesInsertados' => $almacenesInsertados,
            'almacenesOmitidos' => $almacenesOmitidos,
            'codigoUnidadesMedidaInsertadas' => $codigoUnidadesMedidaInsertadas,
            'codigoUnidadesMedidaOmitidas' => $codigoUnidadesMedidaOmitidas,
            'tipoAfectacionInsertados' => $tipoAfectacionInsertados,
            'tipoAfectacionOmitidos' => $tipoAfectacionOmitidos,
            'productosInsertados' => $productosInsertados,
            'productosOmitidos' => $productosOmitidos
        ]);

    } catch (Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Error inesperado: ' . $e->getMessage()
        ], 500);
    }
}

    private function insertarNucleos($hojaNucleo)
    {
        try {
            $numeroFilasNucleo = $hojaNucleo->getHighestDataRow();
            $nucleosRegistrados = 0;
            $nucleosOmitidos = 0;
            for ($i = 2; $i <= $numeroFilasNucleo; $i++) {
                $descripcion = $hojaNucleo->getCell("A" . $i)->getValue();
                $estado = $hojaNucleo->getCell("B" . $i)->getValue() ?? 1;

                if (!empty($descripcion)) {
                    Nucleo::firstOrCreate(
                        ['nomb_nucleo' => $descripcion],
                        ['estado' => $estado]
                    );
                    $nucleosRegistrados++;
                } else {
                    $nucleosOmitidos++;
                }
            }
            return [$nucleosRegistrados, $nucleosOmitidos];
        } catch (Exception $e) {
            throw new Exception('Error al cargar los núcleos al sistema: ' . $e->getMessage());
        }
    }

    private function insertarCentrosCosto($hojaCentroCosto, $nucleos)
    {
        try {
            $numeroFilasCentroCosto = $hojaCentroCosto->getHighestDataRow();
            $centrosCostoRegistrados = 0;
            $centrosCostoOmitidos = 0;
            for ($i = 2; $i <= $numeroFilasCentroCosto; $i++) {
                $codigo = $hojaCentroCosto->getCell("A" . $i)->getValue();
                $nombreCentroCosto = $hojaCentroCosto->getCell("B" . $i)->getValue();
                $nucleoNombre = $hojaCentroCosto->getCell("C" . $i)->getValue();
                $estado = $hojaCentroCosto->getCell("D" . $i)->getValue() ?? 1;

                // Buscar el ID del núcleo
                $nucleoId = $nucleos[$nucleoNombre] ?? null;

                if (!empty($codigo) && !empty($nombreCentroCosto) && $nucleoId) {
                    CentroCosto::firstOrCreate(
                        ['Codigo' => $codigo],  // Buscar por código
                        ['nomb_centroCos' => $nombreCentroCosto, 'nucleo' => $nucleoId, 'estado' => $estado]  // Datos a insertar
                    );
                    $centrosCostoRegistrados++;
                } else {
                    $centrosCostoOmitidos++;
                }
            }
            return [$centrosCostoRegistrados, $centrosCostoOmitidos];
        } catch (Exception $e) {
            throw new Exception('Error al cargar los centros de costo al sistema: ' . $e->getMessage());
        }
    }

    private function insertarCategorias($hojaCategorias)
    {
        try {
            $numeroFilasCategorias = $hojaCategorias->getHighestDataRow();
            $categoriasRegistradas = 0;
            $categoriasOmitidas = 0;
            for ($i = 2; $i <= $numeroFilasCategorias; $i++) {
                $id = $hojaCategorias->getCell("A" . $i)->getValue();
                $descripcion = $hojaCategorias->getCell("B" . $i)->getValue();
                $estado = $hojaCategorias->getCell("C" . $i)->getValue() ?? 1;

                if (!empty($id) && !empty($descripcion)) {
                    Categoria::firstOrCreate(
                        ['id' => $id],
                        ['nomb_cate' => $descripcion, 'estado' => $estado]
                    );
                    $categoriasRegistradas++;
                } else {
                    $categoriasOmitidas++;
                }
            }
            return [$categoriasRegistradas, $categoriasOmitidas];
        } catch (Exception $e) {
            throw new Exception('Error al cargar las categorías al sistema: ' . $e->getMessage());
        }
    }

    private function insertarCodigoUnidadMedida($hojaUnidadMedida)
    {
        try {
            $numeroFilasUnidadMedida = $hojaUnidadMedida->getHighestDataRow();
            $unidadesMedidaRegistradas = 0;
            $unidadesMedidaOmitidas = 0;
            for ($i = 2; $i <= $numeroFilasUnidadMedida; $i++) {
                $id = $hojaUnidadMedida->getCell("A" . $i)->getValue();
                $descripcion = $hojaUnidadMedida->getCell("B" . $i)->getValue();
                $estado = $hojaUnidadMedida->getCell("C" . $i)->getValue() ?? 1;

                if (!empty($id) && !empty($descripcion)) {
                    CodigoUnidadMedida::firstOrCreate(
                        ['id' => $id],
                        ['nomb_uniMed' => $descripcion, 'estado' => $estado]
                    );
                    $unidadesMedidaRegistradas++;
                } else {
                    $unidadesMedidaOmitidas++;
                }
            }
            return [$unidadesMedidaRegistradas, $unidadesMedidaOmitidas];
        } catch (Exception $e) {
            throw new Exception('Error al cargar las unidades de medida al sistema: ' . $e->getMessage());
        }
    }

    private function insertarTipoAfectacion($hojaTipoAfectacion)
    {
        try {
            $numeroFilasTipoAfectacion = $hojaTipoAfectacion->getHighestDataRow();
            $tipoAfectacionRegistrados = 0;
            $tipoAfectacionOmitidos = 0;
            for ($i = 2; $i <= $numeroFilasTipoAfectacion; $i++) {
                $codigo = $hojaTipoAfectacion->getCell("A" . $i)->getValue();
                $tipoAfectacion = $hojaTipoAfectacion->getCell("B" . $i)->getValue();
                $letraTributo = $hojaTipoAfectacion->getCell("C" . $i)->getValue();
                $codigoTributo = $hojaTipoAfectacion->getCell("D" . $i)->getValue();
                $nombreTributo = $hojaTipoAfectacion->getCell("E" . $i)->getValue();
                $tipoTributo = $hojaTipoAfectacion->getCell("F" . $i)->getValue();
                $porcentaje = $hojaTipoAfectacion->getCell("G" . $i)->getValue();

                
            // Verificar si los campos necesarios contienen datos
            if (!empty($codigo) && !empty($tipoAfectacion) && !empty($nombreTributo)) {
                    TipoAfectacionIgv::firstOrCreate(
                        ['codigo' => $codigo],
                        [
                            'nomb_impuesto' => $tipoAfectacion,
                            'letra_tributo' => $letraTributo,
                            'codigo_tributo' => $codigoTributo,
                            'nomb_tributo' => $nombreTributo,
                            'tipo_tributo' => $tipoTributo,
                            'porcentaje' => $porcentaje ?? 0,
                            'estado' => 1
                        ]
                    );
                    $tipoAfectacionRegistrados++;
                } else {
                    $tipoAfectacionOmitidos++;
                }
            }
            return [$tipoAfectacionRegistrados, $tipoAfectacionOmitidos];
        } catch (Exception $e) {
            throw new Exception('Error al cargar los tipos de afectación al sistema: ' . $e->getMessage());
        }
    }

    private function insertarAlmacenes($hojaAlmacenes)
    {
        try {
            $numeroFilasAlmacenes = $hojaAlmacenes->getHighestDataRow();
            $almacenesRegistrados = 0;
            $almacenesOmitidos = 0;
            for ($i = 2; $i <= $numeroFilasAlmacenes; $i++) {
                $nombreAlmacen = $hojaAlmacenes->getCell("A" . $i)->getValue();
                $ubicacionAlmacen = $hojaAlmacenes->getCell("B" . $i)->getValue();
                $estado = $hojaAlmacenes->getCell("C" . $i)->getValue() ?? 1;

                if (!empty($nombreAlmacen) && !empty($ubicacionAlmacen)) {
                    Almacen::firstOrCreate(
                        ['nomb_almacen' => $nombreAlmacen],
                        ['ubic_almacen' => $ubicacionAlmacen, 'estado' => $estado]
                    );
                    $almacenesRegistrados++;
                } else {
                    $almacenesOmitidos++;
                }
            }
            return [$almacenesRegistrados, $almacenesOmitidos];
        } catch (Exception $e) {
            throw new Exception('Error al cargar los almacenes al sistema: ' . $e->getMessage());
        }
    }

    private function insertarProductos($hojaProductos)
    {
        try {
            $numeroFilasProductos = $hojaProductos->getHighestDataRow();
            $productosRegistrados = 0;
            $productosOmitidos = 0;
    
            for ($i = 2; $i <= $numeroFilasProductos; $i++) {
                $codigoProducto = $hojaProductos->getCell("A" . $i)->getValue();
                $categoriaId = $hojaProductos->getCell("B" . $i)->getValue(); // Aquí se asume que la categoría ya está en ID
                $almacenNombre = $hojaProductos->getCell("C" . $i)->getValue();
                $descripcion = $hojaProductos->getCell("D" . $i)->getValue();
                $tipoAfectacionNombre = $hojaProductos->getCell("E" . $i)->getValue();
                $unidadMedidaCodigo = $hojaProductos->getCell("F" . $i)->getValue();
                $stock = $hojaProductos->getCell("G" . $i)->getValue();
                $costoUnitario = $hojaProductos->getCell("H" . $i)->getValue();
                $precioUnitarioSinIgv = $hojaProductos->getCell("I" . $i)->getValue();
                $precioUnitarioConIgv = $hojaProductos->getCell("J" . $i)->getValue();
                $minimoStock = $hojaProductos->getCell("K" . $i)->getValue();
                $imagen = $hojaProductos->getCell("M" . $i)->getValue() ?? 'no_imagen.jpg';
    
                // Calcular el costo total usando el stock y el precio unitario sin IGV
                $costoTotal = $stock * $precioUnitarioSinIgv;
    
                // Validar referencias
                $almacen = Almacen::where('nomb_almacen', $almacenNombre)->first();
                $tipoAfectacion = TipoAfectacionIgv::where('nomb_impuesto', $tipoAfectacionNombre)->first();
                $unidadMedida = CodigoUnidadMedida::where('id', $unidadMedidaCodigo)->first();
    
                if ($almacen && $tipoAfectacion && $unidadMedida) {
                    Producto::updateOrCreate(
                        ['codigo_productos' => $codigoProducto, 'id_almacen' => $almacen->id,'id_unidad_medida'=>$unidadMedida->id],
                        [
                            'id_categorias' => $categoriaId,
                            'id_almacen' => $almacen->id,
                            'descripcion' => $descripcion,
                            'id_tipo_afectacion_igv' => $tipoAfectacion->id,
                            'id_unidad_medida' => $unidadMedida->id,
                            'costo_unitario' => $costoUnitario,
                            'precio_unitario_sin_igv' => $precioUnitarioSinIgv,
                            'precio_unitario_con_igv' => $precioUnitarioConIgv,
                            'stock' => $stock,
                            'minimo_stock' => $minimoStock,
                            'costo_total' => $costoTotal, // Calculado directamente
                            'imagen' => $imagen
                        ]
                    );
                    $productosRegistrados++;

                      // Variables necesarias para el procedimiento almacenado
                    $concepto = 'INVENTARIO INICIAL';
                    $comprobante = '';

                    // Registrar en el kardex
                    DB::statement('CALL prc_registrar_kardex_existencias(?, ?, ?, ?, ?, ?, ?)', [
                        $codigoProducto,
                        $concepto,
                        $comprobante,
                        $stock,
                        $costoUnitario,
                        $costoTotal,
                        $almacen->id
                    ]);
                } 
                else
                {
                    $productosOmitidos++;
                }
            }
            return [$productosRegistrados, $productosOmitidos];
        } catch (Exception $e) {
            throw new Exception('Error al cargar los productos al sistema: ' . $e->getMessage());
        }
    }

    // Modelo del controlador (ejemplo Laravel)

    public function listarCargasMasivas() {
        try {
            $cargasMasivas = DB::select('CALL prc_ListarCargasMasivas()');
            return response()->json($cargasMasivas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listarProductos()
    {
        try {
            // Ejecutar el procedimiento almacenado
            $productos = DB::select('CALL prc_ListarProductos()');

            // Retornar los productos como una respuesta JSON
            return response()->json($productos);
        } catch (\Exception $e) {
            return response()->json(['tipo_msj' => 'error', 'msj' => 'Error al listar productos: ' . $e->getMessage()], 500);
        }
    }
    public function mostrarFormularioRegistro()
    {
        return view('vistas.modulosProducto.registrar');
    }
    public function generarCodigoProducto(Request $request)
    {
        $idAlmacen = $request->input('id_almacen');
        $descripcion = $request->input('descripcion');
    
        // Verifica que la descripción tenga al menos 6 caracteres
        if (strlen($descripcion) >= 6) {
            // Llama a la función que generará el código del producto
            $codigoProducto = $this->crearCodigoProducto($idAlmacen, $descripcion);
        } else {
            $codigoProducto = ''; // O cualquier valor que desees para indicar que no se generó código
        }
    
        return response()->json(['codigo_productos' => $codigoProducto]);
    }
    
    private function crearCodigoProducto($idAlmacen, $nombreProducto)
    {
        // Mapea el ID del almacén a su abreviación
        $abreviacionAlmacen = 'A' . $idAlmacen;
    
        // Sanitiza el nombre del producto
        $nombreSanitizado = preg_replace('/[^A-Za-z0-9]/', '', $nombreProducto); // Elimina caracteres especiales
    
        // Genera un código aleatorio
        $codigoAleatorio = substr(md5(uniqid(rand(), true)), 0, 6); // Genera un código aleatorio de 6 caracteres
    
        // Formatea el código del producto
        $codigoProducto = $abreviacionAlmacen . '-' . $codigoAleatorio;
    
        // Verifica si el código ya existe en la base de datos
        if ($this->codigoExisteEnBaseDeDatos($codigoProducto)) {
            // Si existe, genera un nuevo código
            return $this->crearCodigoProducto($idAlmacen, $nombreProducto);
        }
    
        return $codigoProducto;
    }
    
    private function codigoExisteEnBaseDeDatos($codigoProducto)
    {
        // Verifica si el código ya existe en la base de datos
        return DB::table('producto')->where('codigo_productos', $codigoProducto)->exists();
    }

    public function registrarProducto(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validar si se subió una imagen
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = uniqid() . '_' . rand(100, 999) . '.' . $imagen->getClientOriginalExtension();
                $rutaImagen = 'assets/imagenes/productos/' . $nombreImagen;

                // Guardar la imagen
                $imagen->storeAs('public/assets/imagenes/productos/', $nombreImagen);
            } else {
                $nombreImagen = 'no_image.jpg';
            }

            $Stock=0;

            // Registrar el producto
            $producto = new Producto();
            $producto->codigo_productos = $request->input('codigo_productos');
            $producto->id_categorias = $request->input('id_categoria');
            $producto->id_almacen = $request->input('id_almacen');
            $producto->descripcion = strtoupper($request->input('descripcion'));
            $producto->id_tipo_afectacion_igv = $request->input('id_tipo_afectacion_igv');
            $producto->id_unidad_medida = $request->input('id_unidad_medida');
            $producto->costo_unitario = $request->input('precio_unitario_sin_igv');
            $producto->precio_unitario_sin_igv = $request->input('precio_unitario_sin_igv');
            $producto->precio_unitario_con_igv = $request->input('precio_unitario_con_igv');
            $producto->stock = $Stock;
            $producto->imagen = $nombreImagen;
            $producto->minimo_stock = $request->input('minimo_stock');
            $producto->costo_total = $producto->costo_unitario * $Stock;
            $producto->save();

            // Registro en el Kardex
            $concepto = 'REGISTRADO EN SISTEMA';
            $comprobante = '';
            $stmt = DB::statement('CALL prc_registrar_kardex_existencias(?,?,?,?,?,?,?)', [
                $producto->codigo_productos,
                $concepto,
                $comprobante,
                0,
                $producto->costo_unitario,
                0, // Costo total del producto (puedes ajustar este valor según tus necesidades)
                $producto->id_almacen
            ]);

            DB::commit();

            return response()->json(['tipo_msj' => 'success', 'msj' => 'Producto registrado correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['tipo_msj' => 'error', 'msj' => 'Error al registrar el producto: ' . $e->getMessage()]);
        }
    }

    public function editarProducto($id_producto)
    {
        // Obtener el producto por su ID
        $producto = Producto::findOrFail($id_producto);
        
        // Pasar el producto a la vista
        return view('vistas.modulosProducto.editar', compact('producto'));
    }
    public function actualizarProducto(Request $request)
{
    $request->validate([
        'codigo_productos' => 'required|string',
        'id_categoria' => 'required',
        'id_almacen' => 'required',
        'descripcion' => 'required|string',
        'id_tipo_afectacion_igv' => 'required|integer',
        'id_unidad_medida' => 'required',
        'precio_unitario_con_igv' => 'required|numeric',
        'precio_unitario_sin_igv' => 'required|numeric',
        'minimo_stock' => 'required|numeric',
        'imagen' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
    ]);

    DB::beginTransaction();

    try {
        // Buscar el producto por código
        $codigoProducto = $request->input('codigo_productos');
        $producto = Producto::where('codigo_productos', $codigoProducto)->first();

        if (!$producto) {
            return response()->json([
                'tipo_msj' => 'error',
                'msj' => 'Producto no encontrado'
            ]);
        }

        // Manejar la imagen: guardar una nueva y eliminar la antigua si existe
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = uniqid() . '_' . rand(100, 999) . '.' . $imagen->getClientOriginalExtension();
            $rutaImagen = 'assets/imagenes/productos/' . $nombreImagen;

            // Guardar la imagen en almacenamiento
            $imagen->storeAs('public/' . $rutaImagen);

            // Eliminar la imagen anterior si existía
            if ($producto->imagen && $producto->imagen != 'no_image.jpg') {
                Storage::delete('public/assets/imagenes/productos/' . $producto->imagen);
            }

            $producto->imagen = $nombreImagen;
        }

        // Preparar los datos para la actualización
        $producto->id_categorias = $request->input('id_categoria');
        $producto->id_almacen = $request->input('id_almacen');
        $producto->descripcion = strtoupper($request->input('descripcion'));
        $producto->id_tipo_afectacion_igv = $request->input('id_tipo_afectacion_igv');
        $producto->id_unidad_medida = $request->input('id_unidad_medida');
        $producto->costo_unitario = $request->input('precio_unitario_sin_igv');
        $producto->precio_unitario_sin_igv = $request->input('precio_unitario_sin_igv');
        $producto->precio_unitario_con_igv = $request->input('precio_unitario_con_igv');
        $producto->minimo_stock = $request->input('minimo_stock');
        $producto->costo_total = $producto->costo_unitario * $producto->stock;

        $producto->save();

        // Confirmar transacción
        DB::commit();

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Producto actualizado correctamente'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Error al actualizar el producto: ' . $e->getMessage()
        ]);
    }
}

public function obtenerProducto($id) {
    $producto = Producto::with('TipoAfectacionIgv')->find($id); // Asegúrate de tener definida la relación tipoAfectacion en el modelo Producto

    if ($producto) {
        return response()->json([
            'codigo_productos' => $producto->codigo_productos,
            'descripcion' => $producto->descripcion,
            'id_categorias' => $producto->id_categorias,
            'id_unidad_medida' => $producto->id_unidad_medida,
            'id_almacen' => $producto->id_almacen,
            'id_tipo_afectacion_igv' => $producto->id_tipo_afectacion_igv,
            'impuesto' => $producto->TipoAfectacionIgv->porcentaje ?? null, // Porcentaje del IGV
            'Precio_unitario_con_igv' => $producto->Precio_unitario_con_igv,
            'Precio_unitario_sin_igv' => $producto->Precio_unitario_sin_igv,
            'minimo_stock' => $producto->minimo_stock,
            'imagen' => $producto->imagen
        ]);
    }

    return response()->json(['error' => 'Producto no encontrado'], 404);
}

public function desactivarProducto($id)
{
    $producto = Producto::find($id);
    if ($producto) {
        $producto->estado = 0;
        $producto->save();

        return response()->json(['tipo_msj' => 'success', 'msj' => 'Producto desactivado exitosamente.']);
    }

    return response()->json(['tipo_msj' => 'error', 'msj' => 'Producto no encontrado.'], 404);
}

public function activarProducto($id)
{
    $producto = Producto::find($id);
    if ($producto) {
        $producto->estado = 1;
        $producto->save();

        return response()->json(['tipo_msj' => 'success', 'msj' => 'Producto activado exitosamente.']);
    }

    return response()->json(['tipo_msj' => 'error', 'msj' => 'Producto no encontrado.'], 404);
}

public function gestionarStockVista($id, $accion)
{
    $producto = Producto::find($id);
    return view('vistas.modulosProducto.actualizar', compact('producto', 'accion'));
}



public function actualizarStock(Request $request)
{
    $codigo_producto = $request->codigo_producto;
    $cantidad = $request->cantidad;
    $accion = $request->accion;
    $nuevo_stock = $request->nuevo_stock;


    // Validación del producto usando el código
    $producto = Producto::where('codigo_productos', $codigo_producto)->first();

    if ($producto) {
        if ($accion === 'aumentar_stock') {
            $concepto = 'AUMENTO DE STOCK POR MODULO DE INVENTARIO';
            $producto->stock += $cantidad;
            
            // Guardar el cambio de stock en el producto
            $producto->save();

            // Registro en el Kardex mediante el procedimiento almacenado
            try {
                DB::beginTransaction();

                DB::statement("CALL prc_registrar_kardex_bono(?, ?, ?)", [
                    $codigo_producto,
                    $concepto,
                    $nuevo_stock
                ]);

                DB::commit();

                return response()->json(['tipo_msj' => 'success', 'msj' => 'Stock actualizado y registro en Kardex completado.']);

            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['tipo_msj' => 'error', 'msj' => 'Error al registrar en Kardex: ' . $e->getMessage()], 500);
            }

        } elseif ($accion === 'disminuir_stock') {
            if ($producto->stock >= $cantidad) {
                $concepto = 'DISMINUCIÓN DE STOCK POR MODULO DE INVENTARIO';
                $producto->stock -= $cantidad;
                
                // Guardar el cambio de stock en el producto
                $producto->save();

                // Registro en el Kardex mediante el procedimiento almacenado prc_registrar_kardex_vencido
                try {
                    DB::beginTransaction();

                    DB::statement("CALL prc_registrar_kardex_vencido(?, ?, ?)", [
                        $codigo_producto,
                        $concepto,
                        $nuevo_stock
                    ]);

                    DB::commit();

                    return response()->json(['tipo_msj' => 'success', 'msj' => 'Stock disminuido y registro en Kardex completado.']);

                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json(['tipo_msj' => 'error', 'msj' => 'Error al registrar en Kardex: ' . $e->getMessage()], 500);
                }
            } else {
                return response()->json(['tipo_msj' => 'error', 'msj' => 'Cantidad a disminuir mayor que el stock actual.'], 400);
            }
        } else {
            return response()->json(['tipo_msj' => 'error', 'msj' => 'Acción no válida.'], 400);
        }
    }

    return response()->json(['tipo_msj' => 'error', 'msj' => 'Producto no encontrado.'], 404);
}


    

}

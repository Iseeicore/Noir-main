<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Producto;

class DashboardController extends Controller
{
    public function obtenerMovimientosQuincenales(Request $request)
    {
        $productoId = $request->input('producto_id');
        $almacenId = auth()->user()->id_almacen_usuario; // Almacén asociado al usuario
        $year = date('Y'); // Año actual
    
        $resultados = DB::select('CALL prc_kardex_quincenas_Dashboard(?, ?, ?)', [
            $productoId,
            $almacenId,
            $year,
        ]);
    
        // Organizar los datos en categorías para el gráfico
        $datos = [
            'ingresos' => [],
            'salidas' => [],
            'devoluciones' => [],
        ];
    
        foreach ($resultados as $resultado) {
            $datos[$resultado->tipo_movimiento][] = [
                'quincena' => $resultado->quincena,
                'total_movimientos' => $resultado->total_movimientos,
            ];
        }
    
        return response()->json($datos);
    }
    
    


    public function listarProductosDashboard()
    {
        $almacenId = auth()->user()->id_almacen_usuario;
        $productos = Producto::where('id_almacen', $almacenId)->get(['id', 'descripcion']);

        return response()->json($productos);
    }

    public function obtenerProductosPocoStock()
    {
        try {
            $usuario = Auth::user();
    
            if (!$usuario || !$usuario->id_almacen_usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'El usuario no tiene un almacén asignado.',
                ], 404);
            }
    
            $almacenId = $usuario->id_almacen_usuario;
    
            // Consulta directa en caso de que el procedimiento almacenado no funcione
            $productos = DB::table('producto as p')
                ->join('almacen as a', 'p.id_almacen', '=', 'a.id')
                ->where('p.id_almacen', $almacenId)
                ->whereColumn('p.stock', '<', 'p.minimo_stock')
                ->select(
                    'p.descripcion as producto',
                    'a.nomb_almacen as almacen',
                    'p.stock as stock_actual',
                    'p.minimo_stock'
                )
                ->get();
    
            if ($productos->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'productos' => [],
                    'message' => 'No hay productos con poco stock en este almacén.',
                ]);
            }
    
            return response()->json([
                'success' => true,
                'productos' => $productos,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener productos con poco stock.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    public function obtenerTotalProductos()
    {
        try {
            $usuario = Auth::user();

            if (!$usuario || !$usuario->id_almacen_usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'El usuario no tiene un almacén asignado.',
                ], 404);
            }

            $almacenId = $usuario->id_almacen_usuario;

            // Llamar al procedimiento almacenado
            $resultado = DB::select('CALL prc_listar_cantidad_total_productos_usuarioAct_Dashboard(?)', [$almacenId]);

            $totalProductos = $resultado[0]->total_productos ?? 0;

            return response()->json([
                'success' => true,
                'total_productos' => $totalProductos,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el total de productos.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function obtenerTotalComprasPorAlmacen()
{
    try {
        $usuario = Auth::user();

        if (!$usuario || !$usuario->id_almacen_usuario) {
            return response()->json([
                'success' => false,
                'message' => 'El usuario no tiene un almacén asignado.',
            ], 404);
        }

        $almacenId = $usuario->id_almacen_usuario;

        $resultado = DB::select('CALL prc_listar_cantidad_total_Preciosxproductos_usuario_Dashboard(?)', [$almacenId]);

        $totalCompras = $resultado[0]->total_compras ?? 0; // Maneja valores nulos
        $almacenNombre = $resultado[0]->almacen_nombre ?? 'No especificado';

        return response()->json([
            'success' => true,
            'total_compras' => (float)$totalCompras, // Asegúrate de que sea un número
            'almacen_nombre' => $almacenNombre,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener el total de compras por almacén.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function obtenerConteoProductosPocoStock()
{
    try {
        $idAlmacenUsuario = Auth::user()->id_almacen_usuario; // ID del almacén del usuario actual

        // Llamar al procedimiento almacenado
        $resultado = DB::select('CALL prc_conteo_total_productos_poco_stock_Dashboard(?)', [
            $idAlmacenUsuario,
        ]);

        // Obtener el conteo del resultado
        $totalProductosPocoStock = $resultado[0]->total_productos_poco_stock ?? 0;

        return response()->json([
            'success' => true,
            'total' => $totalProductosPocoStock,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener productos con poco stock',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    public function obtenerSalidasDelDia()
    {
        try {
            $almacenId = auth()->user()->id_almacen_usuario; // ID del almacén asociado al usuario
            $fechaActual = date('Y-m-d'); // Fecha actual

            // Llamar al procedimiento almacenado
            $resultado = DB::select('CALL prc_conteo_salidas_Dashboard(?, ?)', [
                $almacenId,
                $fechaActual
            ]);

            return response()->json([
                'success' => true,
                'total_salidas' => $resultado[0]->total_salidas ?? 0,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las salidas del día.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function obtenerTotalIngresosDelDia(Request $request)
    {
        try {
            $almacenId = auth()->user()->id_almacen_usuario; // Obtener el almacén asociado al usuario

            // Ejecutar el procedimiento almacenado
            $resultados = DB::select('CALL prc_conteo_ingresos_dashboard(?)', [$almacenId]);

            return response()->json([
                'success' => true,
                'total_ingresos' => $resultados[0]->total_ingresos ?? 0,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los ingresos del día.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function obtenerDevolucionesDelDia()
{
    try {
        $almacenId = auth()->user()->id_almacen_usuario; // Almacén asociado al usuario actual
        $fechaActual = date('Y-m-d'); // Fecha actual

        // Ejecutar el procedimiento almacenado
        $resultado = DB::select('CALL prc_conteo_Devolucion_dashboard(?, ?)', [
            $almacenId,
            $fechaActual
        ]);

        // Respuesta en formato JSON
        return response()->json([
            'success' => true,
            'total_devoluciones' => $resultado[0]->total_devoluciones ?? 0,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener devoluciones del día.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function obtenerProductosPorAlmacen(Request $request)
{
    $almacenId = auth()->user()->id_almacen_usuario;
    $productos = Producto::where('id_almacen', $almacenId)
    ->select('codigo_productos', 'descripcion')
    ->get();

return response()->json($productos);
}

public function obtenerVariacionPrecios(Request $request)
{
    $anio = date('Y');
    $codigoProducto = $request->input('codigo_producto');
    $idAlmacen = auth()->user()->id_almacen_usuario;

    // Llamar al procedimiento almacenado
    $resultados = DB::select('CALL prc_variacion_precio_Dashboard(?, ?, ?)', [$anio, $codigoProducto, $idAlmacen]);

    // Normalizar los datos
    foreach ($resultados as &$resultado) {
        $resultado->costo_anterior= $resultado->costo_anterior ?? 0;
        	
        $resultado->variacion_absoluta = $resultado->variacion_absoluta ?? 0;

        $resultado->costo_existente = $resultado->costo_existente ?? 0;
        $resultado->variacion_porcentual = $resultado->variacion_porcentual ?? 0;
        $resultado->costo_ingreso = $resultado->costo_ingreso ?? 0;
    }

    return response()->json($resultados);
}







}

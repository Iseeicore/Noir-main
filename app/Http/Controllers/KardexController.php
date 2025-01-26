<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class KardexController extends Controller
{

// public function reporteKardexPorProducto(Request $request)
// {
//     $column = ["codigo_producto", "producto", "almacen", "fecha", "tipo_movimiento", "cantidad", "stock"];

//     // Construir consulta base para datos y conteo filtrado
//     $baseQuery = DB::table('kardex as k')
//         ->join('producto as p', 'k.codigo_producto', '=', 'p.codigo_productos')
//         ->join('almacen as a', 'k.almacen', '=', 'a.id') 
//         ->select(
//             'k.codigo_producto',
//             DB::raw("MAX(REPLACE(REPLACE(p.descripcion, '\"', ''), '''', '')) as producto"),
//             DB::raw("MAX(a.nomb_almacen) as almacen"),
//             DB::raw("MAX(DATE(k.fecha)) as fecha"),
//             DB::raw("MAX(CASE 
//                 WHEN k.concepto = 'Saldo Inicial Registro Doc Ingreso' THEN 'INVENTARIO INICIAL'
//                 WHEN UPPER(k.concepto) LIKE '%Actualizar%' THEN 'ACTUALIZACIÓN DE STOCK'
//                 WHEN k.concepto = 'Registro Salida de Producto' THEN 'DISMINUCIÓN DE STOCK'
//                 WHEN UPPER(k.concepto) LIKE '%Devolución%' THEN 'DEVOLUCIÓN'
//                 END) as tipo_movimiento"),
//             DB::raw("SUM(CASE 
//                 WHEN k.concepto = 'Saldo Inicial Registro Doc Ingreso' THEN k.ex_unidades
//                 WHEN UPPER(k.concepto) LIKE '%Actualizar%' THEN k.in_unidades
//                 WHEN k.concepto = 'Registro Salida de Producto' THEN k.out_unidades * -1
//                 WHEN UPPER(k.concepto) LIKE '%Devolución%' THEN k.out_unidades
//                 END) as cantidad"),
//             DB::raw("MAX(k.ex_unidades) as stock")
//         )
//         ->groupBy('k.codigo_producto', 'k.almacen'); // Agrupar por campos clave

//     // Aplicar condición de búsqueda en la consulta base
//     if ($request->input('search.value')) {
//         $searchValue = '%' . $request->input('search.value') . '%';
//         $baseQuery->where(function ($query) use ($searchValue) {
//             $query->where('p.descripcion', 'like', $searchValue)
//                   ->orWhere('k.codigo_producto', 'like', $searchValue);
//         });
//     }

//     // Clonar la consulta para obtener el conteo filtrado correctamente
//     $filteredQuery = clone $baseQuery;
//     $filtered_count = DB::table(DB::raw("({$filteredQuery->toSql()}) as filtered"))
//                         ->mergeBindings($filteredQuery)
//                         ->count();

//     // Conteo total de registros sin aplicar filtros de búsqueda ni agrupación
//     $total_count = DB::table('kardex')->count();

//     // Paginación y ordenación en la consulta base
//     if ($request->input('order')) {
//         $baseQuery->orderBy($column[$request->input('order.0.column')], $request->input('order.0.dir'));
//     } else {
//         $baseQuery->orderBy('k.id', 'asc');
//     }

//     // Obtener los datos paginados para mostrar en la tabla
//     $data = $baseQuery->skip($request->input('start'))
//                       ->take($request->input('length'))
//                       ->get();

//     // Formatear la salida para el DataTable
//     $output = [
//         'draw' => intval($request->input('draw')),
//         'recordsTotal' => $total_count,
//         'recordsFiltered' => $filtered_count,
//         'data' => $data->map(function ($row) {
//             return [
//                 $row->codigo_producto,
//                 $row->producto,
//                 $row->almacen,
//                 $row->fecha,
//                 $row->tipo_movimiento,
//                 $row->cantidad,
//                 $row->stock,
//             ];
//         })
//     ];

//     return response()->json($output);
// }

    
public function listarKardex()
{
    try {
        $resultados = DB::select('CALL prc_listar_Kardex()');
        return response()->json(['data' => $resultados]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al listar el Kardex.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    
public function reporteKardex(Request $request)
{
    $column = ["codigo_producto", "producto", "almacen", "entradas", "salidas", "existencias", "costo_existencias"];
    
    // Consulta principal para obtener datos paginados, aplicando funciones de agregación
    $query = DB::table('kardex as k')
        ->join('producto as p', 'k.codigo_producto', '=', 'p.codigo_productos')
        ->join('almacen as a', 'k.almacen', '=', 'a.id') 
        ->select(
            'k.codigo_producto',
            DB::raw("MAX(REPLACE(REPLACE(p.descripcion, '\"', ''), '''', '')) as producto"), // Evita duplicados en el producto
            DB::raw("MAX(a.nomb_almacen) as almacen"), // Evita duplicados en el nombre del almacén
            DB::raw('SUM(IFNULL(k.in_unidades, 0)) as entradas'), // Totaliza las entradas
            DB::raw('SUM(IFNULL(k.out_unidades, 0)) as salidas'), // Totaliza las salidas
            DB::raw('(SELECT k1.ex_unidades FROM kardex k1 WHERE k1.codigo_producto = k.codigo_producto AND k1.almacen = k.almacen ORDER BY k1.id DESC LIMIT 1) as existencias'),
            DB::raw('(SELECT k2.ex_costo_total FROM kardex k2 WHERE k2.codigo_producto = k.codigo_producto AND k2.almacen = k.almacen ORDER BY k2.id DESC LIMIT 1) as costo_existencias')
        )
        ->groupBy('k.codigo_producto', 'k.almacen'); // Agrupación solo en campos clave
    
    // Condición de búsqueda
    if ($request->input('search.value')) {
        $searchValue = '%' . $request->input('search.value') . '%';
        $query->where(function($query) use ($searchValue) {
            $query->where('p.descripcion', 'like', $searchValue)
                  ->orWhere('k.codigo_producto', 'like', $searchValue)
                  ->orWhere('a.nomb_almacen', 'like', $searchValue); // Filtrar también por nombre de almacén
        });
    }

    // Conteo de registros filtrados sin duplicados
    $filtered_count = DB::table(DB::raw("({$query->toSql()}) as filtered"))
                        ->mergeBindings($query)
                        ->count();

    // Conteo total de registros sin filtros ni duplicados
    $total_count = DB::table('kardex')->count();
    
    // Aplicar paginación y ordenación
    if ($request->input('order')) {
        $query->orderBy($column[$request->input('order.0.column')], $request->input('order.0.dir'));
    } else {
        $query->orderBy('k.id', 'asc');
    }
    
    $data = $query->skip($request->input('start'))
                  ->take($request->input('length'))
                  ->get();
    
    // Formatear la salida para el DataTable
    $output = [
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $total_count,
        'recordsFiltered' => $filtered_count,
        'data' => $data->map(function ($row) {
            return [
                "",
                $row->codigo_producto,
                $row->producto,
                $row->almacen,
                $row->entradas,
                $row->salidas,
                $row->existencias,
                $row->costo_existencias,
            ];
        })
    ];
    
    return response()->json($output);
}

// {
//     $column = ["codigo_producto", "producto", "almacen", "entradas", "salidas", "existencias", "costo_existencias"];
    
//     // Consulta principal para obtener datos paginados
//     $query = DB::table('kardex as k')
//         ->join('producto as p', 'k.codigo_producto', '=', 'p.codigo_productos')
//         ->join('almacen as a', 'k.almacen', '=', 'a.id') // Join con la tabla almacen
//         ->select(
//             'k.codigo_producto as codigo_producto',
//             'p.descripcion as producto',
//             'a.nomb_almacen as almacen', // Obtener el nombre del almacén
//             DB::raw('SUM(IFNULL(k.in_unidades, 0)) as entradas'),
//             DB::raw('SUM(IFNULL(k.out_unidades, 0)) as salidas'),
//             DB::raw('(SELECT k1.ex_unidades FROM kardex k1 WHERE k1.codigo_producto = k.codigo_producto AND k1.almacen = k.almacen ORDER BY k1.id DESC LIMIT 1) as existencias'),
//             DB::raw('(SELECT k2.ex_costo_total FROM kardex k2 WHERE k2.codigo_producto = k.codigo_producto AND k2.almacen = k.almacen ORDER BY k2.id DESC LIMIT 1) as costo_existencias')
//         )
//         ->groupBy('k.codigo_producto', 'p.descripcion', 'a.nomb_almacen', 'k.almacen'); // Agrupamiento por producto y almacén
    
//     // Condición de búsqueda
//     if ($request->input('search.value')) {
//         $query->where(function($query) use ($request) {
//             $query->where('p.descripcion', 'like', '%' . $request->input('search.value') . '%')
//                   ->orWhere('k.codigo_producto', 'like', '%' . $request->input('search.value') . '%')
//                   ->orWhere('a.nomb_almacen', 'like', '%' . $request->input('search.value') . '%'); // Filtrar también por nombre de almacén
//         });
//     }

//     // Conteo de registros filtrados sin paginación
//     $filtered_count = DB::table('kardex as k')
//         ->join('producto as p', 'k.codigo_producto', '=', 'p.codigo_productos')
//         ->join('almacen as a', 'k.almacen', '=', 'a.id')
//         ->select(DB::raw('COUNT(DISTINCT k.codigo_producto, k.almacen) as count'))
//         ->where(function($query) use ($request) {
//             if ($request->input('search.value')) {
//                 $query->where('p.descripcion', 'like', '%' . $request->input('search.value') . '%')
//                       ->orWhere('k.codigo_producto', 'like', '%' . $request->input('search.value') . '%')
//                       ->orWhere('a.nomb_almacen', 'like', '%' . $request->input('search.value') . '%');
//             }
//         })
//         ->value('count');

//     // Conteo total de registros sin filtros y sin paginación
//     $total_count = DB::table('kardex as k')
//         ->join('producto as p', 'k.codigo_producto', '=', 'p.codigo_productos')
//         ->join('almacen as a', 'k.almacen', '=', 'a.id')
//         ->select(DB::raw('COUNT(DISTINCT k.codigo_producto, k.almacen) as count'))
//         ->value('count');
    
//     // Aplicar paginación a la consulta principal
//     if ($request->input('order')) {
//         $query->orderBy($column[$request->input('order.0.column')], $request->input('order.0.dir'));
//     } else {
//         $query->orderBy('k.id', 'asc');
//     }
    
//     $data = $query->skip($request->input('start'))
//                   ->take($request->input('length'))
//                   ->get();
    
//     $output = [
//         'draw' => intval($request->input('draw')),
//         'recordsTotal' => $total_count,
//         'recordsFiltered' => $filtered_count,
//         'data' => $data->map(function ($row) {
//             return [
//                 "",
//                 $row->codigo_producto,
//                 $row->producto,
//                 $row->almacen, // Nombre del almacén
//                 $row->entradas,
//                 $row->salidas,
//                 $row->existencias,
//                 $row->costo_existencias,
//             ];
//         })
//     ];
    
//     return response()->json($output);
// }

public function reporteKardexDetalles(Request $request)
{
    $codigoProducto = $request->input('codigo_producto');
    $almacenNombre = $request->input('almacen'); // Nombre del almacén recibido

    // Buscar el ID del almacén por nombre
    $almacen = DB::table('almacen')
        ->where('nomb_almacen', $almacenNombre)
        ->orWhere('nomb_almacen', str_replace('+', ' ', $almacenNombre))
        ->value('id');

    // Si no se encuentra el almacén, devolvemos un error
    if (!$almacen) {
        return response()->json(['error' => 'Almacén no encontrado'], 404);
    }

    // Consulta para obtener detalles de kardex según el código de producto y el almacén
    $data = DB::table('kardex as k')
        ->join('almacen as a', 'k.almacen', '=', 'a.id') // Join con la tabla almacen
        ->where('k.codigo_producto', $codigoProducto)
        ->where('k.almacen', $almacen) // Filtrar por el ID del almacén encontrado
        ->select('k.codigo_producto', 'k.fecha', 'k.concepto', 'a.nomb_almacen as almacen') // Seleccionar nombre del almacén
        ->orderBy('k.fecha', 'desc')
        ->get();

    return response()->json(['data' => $data]);
}

// public function reporteKardexPorAlmacen(Request $request)
// {
//     $column = ["codigo_producto", "producto", "almacen", "entradas", "salidas", "existencias", "costo_existencias"];

//     // Consulta principal con joins y selecciones, aplicando funciones de agregación y grupo
//     $query = DB::table('kardex as k')
//         ->join('producto as p', 'k.codigo_producto', '=', 'p.codigo_productos')
//         ->join('almacen as a', 'p.id_almacen', '=', 'a.id')
//         ->select(
//             'k.codigo_producto',
//             'p.descripcion as producto',
//             'a.nomb_almacen as almacen',
//             DB::raw('SUM(IFNULL(k.in_unidades, 0)) as entradas'),
//             DB::raw('SUM(IFNULL(k.out_unidades, 0)) as salidas'),
//             DB::raw('(SELECT k1.ex_unidades FROM kardex k1 WHERE k1.codigo_producto = k.codigo_producto ORDER BY k1.id DESC LIMIT 1) as existencias'),
//             DB::raw('(SELECT k2.ex_costo_total FROM kardex k2 WHERE k2.codigo_producto = k.codigo_producto ORDER BY k2.id DESC LIMIT 1) as costo_existencias')
//         )
//         ->groupBy('k.codigo_producto', 'p.descripcion', 'a.nomb_almacen'); // Agrupación necesaria para evitar duplicados

//     // Aplicar filtros en la consulta principal
//     if ($request->id_almacen) {
//         $query->where('a.id', '=', $request->id_almacen);
//     }

//     if ($request->id_categoria) {
//         $query->where('p.id_categorias', '=', $request->id_categoria);
//     }

//     if ($request->producto) {
//         $query->where('p.descripcion', 'like', '%' . $request->producto . '%');
//     }

//     // Conteo filtrado: realiza una subconsulta envolviendo el conteo sobre la consulta principal
//     $filtered_count = DB::table(DB::raw("({$query->toSql()}) as filtered"))
//         ->mergeBindings($query)
//         ->count();

//     // Conteo total sin filtros ni agrupación
//     $total_count = DB::table('kardex')->count();

//     // Ordenar y paginar la consulta principal
//     if ($request->input('order')) {
//         $query->orderBy($column[$request->input('order.0.column')], $request->input('order.0.dir'));
//     } else {
//         $query->orderBy('k.id', 'asc');
//     }

//     // Paginación en los datos obtenidos después de agrupar y filtrar
//     $data = $query->skip($request->input('start'))
//                   ->take($request->input('length'))
//                   ->get();

//     // Preparar la respuesta para DataTable
//     $output = [
//         'draw' => intval($request->input('draw')),
//         'recordsTotal' => $total_count,
//         'recordsFiltered' => $filtered_count,
//         'data' => $data->map(function ($row) {
//             return [
//                 $row->codigo_producto,
//                 $row->producto,
//                 $row->almacen,
//                 $row->entradas,
//                 $row->salidas,
//                 $row->existencias,
//                 $row->costo_existencias,
//             ];
//         })
//     ];

//     return response()->json($output);
// }

public function reporteKardexPorAlmacen(Request $request)
{
    $column = ["codigo_producto", "producto", "almacen", "entradas", "salidas", "existencias", "costo_existencias"];

    // Consulta principal con lógica para diferenciar por almacén
    $query = DB::table('kardex as k')
        ->join('producto as p', function ($join) {
            $join->on('k.codigo_producto', '=', 'p.codigo_productos')
                 ->on('k.almacen', '=', 'p.id_almacen'); // Relación específica por almacén
        })
        ->join('almacen as a', 'k.almacen', '=', 'a.id') // Unión con el almacén desde Kardex
        ->select(
            'k.codigo_producto',
            'p.descripcion as producto',
            'a.nomb_almacen as almacen',
            DB::raw('SUM(IFNULL(k.in_unidades, 0)) as entradas'),
            DB::raw('SUM(IFNULL(k.out_unidades, 0)) as salidas'),
            DB::raw('
                (SELECT k1.ex_unidades 
                 FROM kardex k1 
                 WHERE k1.codigo_producto = k.codigo_producto 
                   AND k1.almacen = k.almacen 
                 ORDER BY k1.id DESC LIMIT 1
                ) as existencias
            '),
            DB::raw('
                (SELECT k2.ex_costo_total 
                 FROM kardex k2 
                 WHERE k2.codigo_producto = k.codigo_producto 
                   AND k2.almacen = k.almacen 
                 ORDER BY k2.id DESC LIMIT 1
                ) as costo_existencias
            ')
        )
        ->groupBy('k.codigo_producto', 'p.descripcion', 'a.nomb_almacen', 'k.almacen'); // Agregar almacen en la agrupación

    // Aplicar filtros en la consulta principal
    if ($request->id_almacen) {
        $query->where('k.almacen', '=', $request->id_almacen);
    }

    if ($request->id_categoria) {
        $query->where('p.id_categorias', '=', $request->id_categoria);
    }

    if ($request->producto) {
        $query->where('p.descripcion', 'like', '%' . $request->producto . '%');
    }

    // Conteo filtrado
    $filtered_count = DB::table(DB::raw("({$query->toSql()}) as filtered"))
        ->mergeBindings($query)
        ->count();

    // Conteo total
    $total_count = DB::table('kardex')->count();

    // Ordenar y paginar
    if ($request->input('order')) {
        $query->orderBy($column[$request->input('order.0.column')], $request->input('order.0.dir'));
    } else {
        $query->orderBy('k.id', 'asc');
    }

    // Paginación en los datos obtenidos
    $data = $query->skip($request->input('start'))
                  ->take($request->input('length'))
                  ->get();

    // Preparar respuesta
    $output = [
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $total_count,
        'recordsFiltered' => $filtered_count,
        'data' => $data->map(function ($row) {
            return [
                $row->codigo_producto,
                $row->producto,
                $row->almacen,
                $row->entradas,
                $row->salidas,
                $row->existencias,
                $row->costo_existencias,
            ];
        })
    ];

    return response()->json($output);
}








}

<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CategoriaController extends Controller
{
    public function listarCategorias()
    {
        $categorias = DB::table('categoria')->select('id', 'nomb_cate')->get();
        return response()->json($categorias);
    }
    // CategoriaController.php
    public function listarCategoriasFormulario(Request $request)
    {
        $categorias = DB::table('categoria')->select('id', 'nomb_cate')->get();

        return response()->json($categorias);
    }

    public function listarCategoriasDatos(Request $request)
{
    $columnas = ["id", "nomb_cate", "estado"];

    // Consulta base para obtener las categorías
    $query = Categoria::select(
        'id',
        'nomb_cate',
        DB::raw("IF(estado = 1, 'ACTIVO', 'INACTIVO') as estado")
    );

    // Aplicar filtros
    if ($request->search['value']) {
        $search = $request->search['value'];
        $query->where(function($query) use ($search) {
            $query->where('id', 'like', "%{$search}%")
                  ->orWhere('nomb_cate', 'like', "%{$search}%");
        });
    }

    // Obtener el conteo total y el conteo filtrado
    $total_count = Categoria::count();
    $filtered_count = $query->count();

    // Aplicar paginación
    if ($request->length != -1) {
        $query->skip($request->start)->take($request->length);
    }

    // Aplicar ordenación
    if ($request->order) {
        $order_column = $columnas[$request->order[0]['column']];
        $order_dir = $request->order[0]['dir'];
        $query->orderBy($order_column, $order_dir);
    }

    // Ejecutar la consulta y dar formato a los datos
    $data = $query->get()->map(function($row) {
        return [
            'opciones' => '',
            'id' => $row->id,
            'nombre_categoria' => $row->nomb_cate,
            'estado' => $row->estado
        ];
    });

    // Formato de respuesta para DataTables
    $output = [
        'draw' => intval($request->draw),
        'recordsTotal' => $total_count,
        'recordsFiltered' => $filtered_count,
        'data' => $data
    ];

    return response()->json($output);
}
public function guardarCategoria(Request $request)
{
    // Validar los datos de entrada
    $request->validate([
        'codigo' => 'required|string|max:10',
        'nomb_cate' => 'required|string|max:255',
    ]);

    // Verificar si el código ya existe
    if (Categoria::where('id', $request->input('codigo'))->exists()) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'No se pudo registrar porque el código ingresado ya existe.',
        ]);
    }

    try {
        // Crear o actualizar categoría
        Categoria::create([
                'id' => $request->input('codigo'),
                'nomb_cate' => $request->input('nomb_cate'),
                'estado' => $request->input('estado', 1), // Asignar estado por defecto como activo
            ]
        );

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Categoría registrada exitosamente',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Error al registrar categoría: ' . $e->getMessage(),
        ]);
    }
}


public function actualizarCategoria(Request $request, $id)
{
    // Validar los datos de entrada
    $request->validate([
        'nomb_cate' => 'required|string|max:255',
    ]);

    try {
        // Buscar la categoría y actualizar sus datos sin modificar el ID
        $categoria = Categoria::findOrFail($id);
        $categoria->update([
            'nomb_cate' => $request->input('nomb_cate'),
            'estado' => $request->input('estado', 1), // Estado por defecto a 1 si no se proporciona
        ]);

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Categoría actualizada exitosamente',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Error al actualizar categoría: ' . $e->getMessage(),
        ]);
    }
}

public function eliminarCategoria($id)
{
    try {
        // Intentamos encontrar la categoría y eliminarla
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Categoría eliminada correctamente'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Ocurrió un error al eliminar la categoría'
        ]);
    }
}
public function cambiarEstadoCategoria(Request $request, $id)
{
    try {
        // Encontrar la categoría por ID
        $categoria = Categoria::findOrFail($id);

        // Cambiar el estado
        $categoria->estado = $request->estado;
        $categoria->save();

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Estado de la categoría actualizado correctamente',
            'nuevo_estado' => $categoria->estado == 1 ? 'ACTIVO' : 'INACTIVO'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Ocurrió un error al cambiar el estado de la categoría'
        ]);
    }
}



}

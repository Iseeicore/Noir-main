<?php

namespace App\Http\Controllers;

use App\Models\CodigoUnidadMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CodigoUnidadMedidaController extends Controller
{
    public function listarUnidadesMedida()
    {
        $unidades = CodigoUnidadMedida::all();
        return response()->json($unidades);
    }

    public function listarUnidadesMedidaDatos(Request $request)
{
    $columnas = ["id", "nomb_uniMed", "estado"];

    // Consulta base para obtener las categorías
    $query = CodigoUnidadMedida::select(
        'id',
        'nomb_uniMed',
        DB::raw("IF(estado = 1, 'ACTIVO', 'INACTIVO') as estado")
    );

    // Aplicar filtros
    if ($request->search['value']) {
        $search = $request->search['value'];
        $query->where(function($query) use ($search) {
            $query->where('id', 'like', "%{$search}%")
                    ->orWhere('nomb_uniMed', 'like', "%{$search}%");
        });
    }

    // Obtener el conteo total y el conteo filtrado
    $total_count = CodigoUnidadMedida::count();
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
            'nombre_unidad' => $row->nomb_uniMed,
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

public function guardarUnidadMedida(Request $request)
{
    // Validar los datos de entrada
    $request->validate([
        'codigo' => 'required|string|max:10',
        'nomb_uniMed' => 'required|string|max:255',
    ]);

    // Verificar si el código ya existe
    if (CodigoUnidadMedida::where('id', $request->input('codigo'))->exists()) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'No se pudo registrar porque el código ingresado ya existe.',
        ]);
    }

    try {
        // Crear o actualizar categoría
        CodigoUnidadMedida::create(
            [
                'id' => $request->input('codigo'),
                'nomb_uniMed' => $request->input('nomb_uniMed'),
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


public function actualizarUnidadMedida(Request $request, $id)
{
    // Validar los datos de entrada
    $request->validate([
        'nomb_uniMed' => 'required|string|max:255',
    ]);

    try {
        // Buscar la categoría y actualizarla
        $categoria = CodigoUnidadMedida::findOrFail($id);
        $categoria->update([
            'nomb_uniMed' => $request->input('nomb_uniMed'),
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

public function eliminarUnidadMedida($id)
{
    try {
        // Intentamos encontrar la categoría y eliminarla
        $categoria = CodigoUnidadMedida::findOrFail($id);
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

public function cambiarEstadoUnidadMedida(Request $request, $id)
{
    try {
        // Encontrar la categoría por ID
        $categoria = CodigoUnidadMedida::findOrFail($id);

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

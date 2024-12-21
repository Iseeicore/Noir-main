<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nucleo;
use Illuminate\Support\Facades\DB;



class NucleoController extends Controller
{
    public function listarNucleoView(Request $request)
{
    $columnas = ["id", 'nomb_nucleo', 'estado']; 

    // Consulta base para obtener los datos de los núcleos
    $query = Nucleo::select(
        'nucleo.id',
        'nucleo.nomb_nucleo',
        DB::raw("IF(nucleo.estado = 1, 'ACTIVO', 'INACTIVO') as estado")
    );

    // Aplicar filtros de búsqueda
    if ($request->search['value']) {
        $search = $request->search['value'];
        $query->where(function($query) use ($search) {
            $query->where('nucleo.id', 'like', "%{$search}%")
                  ->orWhere('nucleo.nomb_nucleo', 'like', "%{$search}%")
                  ->orWhere('nucleo.estado', 'like', "%{$search}%"); // Filtramos por estado si es necesario
        });
    }

    // Obtener el conteo total y el conteo filtrado
    $total_count = Nucleo::count();
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
            'cod' => $row->nomb_nucleo,
            'estado' => $row->estado,
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


    // Guardar núcleo
public function guardarNucleo(Request $request)
{
    $request->validate([
        'nomb_nucleo' => 'required',
    ]);

    try {
        Nucleo::create([
            'nomb_nucleo' => $request->input('nomb_nucleo'),
            'estado' => 1, // Estado activo por defecto
        ]);

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Núcleo registrado exitosamente',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Error al registrar el núcleo: ' . $e->getMessage(),
        ]);
    }
}

// Actualizar núcleo
public function actualizarNucleo(Request $request, $id)
{
    $request->validate([
        'nomb_nucleo' => 'required',
    ]);

    try {
        $nucleo = Nucleo::findOrFail($id);
        $nucleo->update([
            'nomb_nucleo' => $request->input('nomb_nucleo'),
        ]);

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Núcleo actualizado exitosamente',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Error al actualizar el núcleo: ' . $e->getMessage(),
        ]);
    }
}

public function eliminarNucleo($id)
{
    try {
        // Intentamos encontrar el núcleo
        $nucleo = Nucleo::findOrFail($id);

        // Eliminamos los centros de costo relacionados
        $nucleo->centrosCosto()->delete();

        // Eliminamos el núcleo
        $nucleo->delete();

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Núcleo y sus centros de costo asociados eliminados correctamente.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Ocurrió un error al eliminar el núcleo y sus centros de costo.'
        ]);
    }
}

public function cambiarEstadoNucleo(Request $request, $id)
{
    try {
        // Encontrar el núcleo por ID
        $nucleo = Nucleo::findOrFail($id);

        // Cambiar el estado
        $nucleo->estado = $request->estado;
        $nucleo->save();

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Estado del núcleo actualizado correctamente',
            'nuevo_estado' => $nucleo->estado == 1 ? 'ACTIVO' : 'INACTIVO'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Ocurrió un error al cambiar el estado del núcleo'
        ]);
    }
}



}

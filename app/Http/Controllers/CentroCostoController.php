<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CentroCosto;
use App\Models\Nucleo;
use Illuminate\Support\Facades\DB;


class CentroCostoController extends Controller
{
    
    public function listarCentroCostoDatos(Request $request)
{
    $columnas = ["id", "Codigo", "nomb_centroCos", "estado", "nomb_nucleo"]; // Agregamos la columna del núcleo

    // Consulta base para obtener los datos de centro de costo
    $query = CentroCosto::select(
        'centro_costo.id',
        'centro_costo.Codigo',
        'centro_costo.nomb_centroCos',
        DB::raw("IF(centro_costo.estado = 1, 'ACTIVO', 'INACTIVO') as estado"),
        'nucleo.nomb_nucleo', // Agregamos el nombre del núcleo
        'nucleo.id as nucleo_id' // Agregamos el ID del núcleo
    )->join('nucleo', 'centro_costo.nucleo', '=', 'nucleo.id'); // Unimos la tabla nucleo

    // Aplicar filtros de búsqueda
    if ($request->search['value']) {
        $search = $request->search['value'];
        $query->where(function($query) use ($search) {
            $query->where('centro_costo.id', 'like', "%{$search}%")
                  ->orWhere('centro_costo.Codigo', 'like', "%{$search}%")
                  ->orWhere('centro_costo.nomb_centroCos', 'like', "%{$search}%")
                  ->orWhere('nucleo.nomb_nucleo', 'like', "%{$search}%"); // Filtramos por el nombre del núcleo
        });
    }

    // Obtener el conteo total y el conteo filtrado
    $total_count = CentroCosto::count();
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
            'cod' => $row->Codigo,
            'nombre' => $row->nomb_centroCos,
            'estado' => $row->estado,
            'nucleo' => $row->nomb_nucleo, // Nombre del núcleo
            'nucleo_id' => $row->nucleo_id, // ID del núcleo
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


public function cambiarEstadoCentroCosto(Request $request, $id)
{
    try {
        // Encontrar el centro de costo por ID
        $centroCosto = CentroCosto::findOrFail($id);

        // Cambiar el estado
        $centroCosto->estado = $request->estado;
        $centroCosto->save();

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Estado del centro de costo actualizado correctamente',
            'nuevo_estado' => $centroCosto->estado == 1 ? 'ACTIVO' : 'INACTIVO'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Ocurrió un error al cambiar el estado del centro de costo'
        ]);
    }
}
public function guardarCentroCosto(Request $request)
{
    // Validar los datos de entrada
    $request->validate([
        'codigo' => 'required', // Asegurarse de que el código sea único
        'nomb_centroCos' => 'required',
        'nucleo' => 'required',
    ]);

    try {
        // Crear un nuevo centro de costo
        CentroCosto::create([
            'Codigo' => $request->input('codigo'),
            'nomb_centroCos' => $request->input('nomb_centroCos'),
            'nucleo' => $request->input('nucleo'),
            'estado' => 1, // Estado activo por defecto
        ]);

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Centro de costo registrado exitosamente',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Error al registrar el centro de costo: ' . $e->getMessage(),
        ]);
    }
}
public function actualizarCentroCosto(Request $request, $id)
{
    // Validar los datos de entrada
    $request->validate([
        'nomb_centroCos' => 'required',
        'nucleo' => 'required',
    ]);

    try {
        // Buscar el centro de costo y actualizarlo
        $centroCosto = CentroCosto::findOrFail($id);
        $centroCosto->update([
            'nomb_centroCos' => $request->input('nomb_centroCos'),
            'nucleo' => $request->input('nucleo'),
        ]);

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Centro de costo actualizado exitosamente',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Error al actualizar el centro de costo: ' . $e->getMessage(),
        ]);
    }
}

public function listarnucleo(){
    $listanucleo = Nucleo::all();
    return response()->json(['nucleo' => $listanucleo]);
}

public function eliminarCentroCosto($id)
{
    try {
        // Intentamos encontrar el centro de costo y eliminarlo
        $centroCosto = CentroCosto::findOrFail($id);
        $centroCosto->delete();

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Centro de costo eliminado correctamente'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Ocurrió un error al eliminar el centro de costo'
        ]);
    }
}




}

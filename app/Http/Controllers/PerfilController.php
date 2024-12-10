<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller
{
    public function obtenerPerfilesAsignar()
    {
        try {
            // Llamar al procedimiento almacenado
            $perfiles = DB::select('CALL prc_ListarPerfilesAsignar()');

            // Devolver los perfiles en formato JSON para el DataTable
            return response()->json($perfiles);
        } catch (\Exception $e) {
            return response()->json([
                'tipo_msj' => 'error',
                'msj' => 'Error al listar perfiles: ' . $e->getMessage()
            ], 500);
        }
    }
    public function obtenerModulosPorPerfil(Request $request)
    {
        try {
            // Obtener el id_perfil desde la solicitud AJAX
            $id_perfil = $request->input('id_perfil');

            // Llamar al procedimiento almacenado o consulta
            $modulos = DB::select('
                SELECT id, modulo, 
                IFNULL(
                    CASE WHEN (m.vista IS NULL OR m.vista = "") 
                    THEN "0" 
                    ELSE (
                        SELECT "1" FROM perfil_modulo pm 
                        WHERE pm.id_modulo = m.id 
                        AND pm.id_perfil = :id_perfil
                    ) END, 0) AS sel
                FROM modulos m
                ORDER BY m.orden', ['id_perfil' => $id_perfil]);

            // Devolver los módulos en formato JSON
            return response()->json($modulos);
        } catch (\Exception $e) {
            return response()->json([
                'tipo_msj' => 'error',
                'msj' => 'Error al obtener módulos por perfil: ' . $e->getMessage()
            ], 500);
        }
    }

    
    public function registrarPerfilModulo(Request $request)
    {
        $idPerfil = $request->input('id_Perfil');
        $modulosSeleccionados = $request->input('id_modulosSeleccionados');
        $id_modulo_inicio = $request->input('id_modulo_inicio');
        $total_registros = 0;
    
        // Si el perfil es "Admin" con ID 1, no borra el módulo 13
        if ($idPerfil == 1) {
            DB::table('perfil_modulo')->where('id_perfil', $idPerfil)->where('id_modulo', '!=', 10)->delete();
        } else {
            DB::table('perfil_modulo')->where('id_perfil', $idPerfil)->delete();
        }
    
        foreach ($modulosSeleccionados as $moduloId) {
            if ($idPerfil == 1 && $moduloId == 10) {
                continue;
            }
    
            $vista_inicio = ($moduloId == $id_modulo_inicio) ? 1 : 0;
    
            $inserted = DB::table('perfil_modulo')->insert([
                'id_perfil' => $idPerfil,
                'id_modulo' => $moduloId,
                'vista_inicio' => $vista_inicio,
                'estado' => 1
            ]);
    
            $total_registros += $inserted ? 1 : 0;
    
            // Si es la vista de inicio, actualizamos la sesión
            if ($vista_inicio == 1) {
                $vista = DB::table('modulos')->where('id', $moduloId)->value('vista');
                session(['vista_usuario' => $vista]); // Actualizamos la sesión con la vista seleccionada
            }
        }
    
        return response()->json($total_registros, 200);
    }


    // Función para reorganizar los módulos
    public function reorganizarModulos(Request $request)
    {
        // Obtenemos el array de módulos enviados desde la vista
        $modulosOrdenados = $request->input('modulos');
        $respuesta = [];

        DB::beginTransaction();
        try {
            // Recorremos el array de módulos
            foreach ($modulosOrdenados as $modulo) {
                // Dividimos el string para obtener id, padre_id y orden
                $array_item_modulo = explode(';', $modulo);

                // Actualizamos la base de datos con el nuevo orden y padre_id
                DB::table('modulos')
                    ->where('id', $array_item_modulo[0])
                    ->update([
                        'padre_id' => ($array_item_modulo[1] === '#') ? 0 : $array_item_modulo[1],
                        'orden' => $array_item_modulo[2]
                    ]);
            }

            DB::commit();
            // Si todo sale bien
            $respuesta['tipo_msj'] = 'success';
            $respuesta['msj'] = 'Se reorganizaron los módulos correctamente';
        } catch (\Exception $e) {
            DB::rollBack();
            // En caso de error
            $respuesta['tipo_msj'] = 'error';
            $respuesta['msj'] = 'Error al reorganizar los módulos: ' . $e->getMessage();
        }

        // Retornamos la respuesta en formato JSON
        return response()->json($respuesta);
    }

    public function obtenerPerfiles(Request $request)
    {
        $columns = ['id_perfil', 'descripcion', 'estado'];
        $searchValue = $request->input('search.value');
        $orderColumn = $columns[$request->input('order.0.column')];
        $orderDir = $request->input('order.0.dir');
        $start = $request->input('start');
        $length = $request->input('length');

        $query = Perfil::select([
            DB::raw("'' as opciones"),
            'id_perfil',
            'descripcion',
            DB::raw("CASE WHEN estado = 1 THEN 'ACTIVO' ELSE 'INACTIVO' END AS estado"),
        ]);

        // Filtro de búsqueda
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('descripcion', 'like', '%' . $searchValue . '%')
                    ->orWhere('id_perfil', 'like', '%' . $searchValue . '%')
                    ->orWhereRaw("CASE WHEN estado = 1 THEN 'ACTIVO' ELSE 'INACTIVO' END LIKE ?", ['%' . $searchValue . '%']);
            });
        }

        // Ordenar
        $query->orderBy($orderColumn, $orderDir);

        // Paginación
        $recordsTotal = Perfil::count();
        $recordsFiltered = $query->count();
        $perfiles = $query->skip($start)->take($length)->get();

        // Formatear los datos para DataTables
        $data = $perfiles->map(function ($perfil) {
            return [
                'opciones' => '',
                'id_perfil' => $perfil->id_perfil,
                'descripcion' => $perfil->descripcion,
                'estado' => $perfil->estado,
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
    public function registrarPerfil(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'descripcion' => 'required|string|max:255',
            'estado' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            // Registrar el perfil en la base de datos
            Perfil::create([
                'descripcion' => strtoupper($validatedData['descripcion']),
                'estado' => $validatedData['estado'],
            ]);

            DB::commit();

            return response()->json([
                'tipo_msj' => 'success',
                'msj' => 'Se registró el perfil correctamente',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'tipo_msj' => 'error',
                'msj' => 'Error al registrar el perfil: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function editar($id_perfil)
    {
        // Obtener los datos del perfil a partir del ID
        $perfil = Perfil::find($id_perfil);

        if (!$perfil) {
            return response()->json(['error' => 'Perfil no encontrado'], 404);
        }

        // Cargar la vista y pasar los datos del perfil
        return view('vistas.PerfilConfig.actualizar_perfil', compact('perfil'));
    }

        public function actualizar(Request $request, $id_perfil)
        {
            // Validar los datos del formulario
            $request->validate([
                'descripcion' => 'required|string|max:255',
                'estado' => 'required|in:0,1',
            ]);

            // Actualizar el perfil
            $perfil = Perfil::findOrFail($id_perfil);
            $perfil->descripcion = $request->input('descripcion');
            $perfil->estado = $request->input('estado');
            $perfil->save();

            return response()->json(['message' => 'Perfil actualizado correctamente']);
        }


}
    


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequerimientoHead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CentroCosto;
use App\Models\CodigoUnidadMedida;
use App\Models\RequerimientoBody;
use Illuminate\Support\Facades\Log;



class DocumentosController extends Controller
{
    public function listarRequerimientos(Request $request)
    {
        $columnas = ["requerimiento_head.id", "cod_req", "fecha_req", "estado", "Area_recibida", "usuarios.nomb_usuarios"];
    
        // Obtener el id del usuario autenticado
        $usuario_id = Auth::user()->id_usuario;
    
        // Consulta base para obtener los requerimientos con el join a la tabla usuarios
        $query = RequerimientoHead::select(
            'requerimiento_head.id',
            'requerimiento_head.cod_req',
            'requerimiento_head.fecha_req',
            'requerimiento_head.estado',
            'area.descripcion as Area_recibida',
            'usuarios.nomb_usuarios as solicitante'
        )
        ->leftJoin('usuarios', 'requerimiento_head.solicitante', '=', 'usuarios.id_usuario')
        ->leftJoin('area', 'requerimiento_head.Area_recibida', '=', 'area.id_area') // Ajusta si `Area_recibida` apunta a `id_area`.
        ->where('requerimiento_head.solicitante', $usuario_id);
    
        // Aplicar filtros si se recibe un valor de búsqueda
        if ($request->search['value']) {
            $search = $request->search['value'];
            $query->where(function ($query) use ($search) {
                $query->where('requerimiento_head.cod_req', 'like', "%{$search}%")
                      ->orWhere('requerimiento_head.fecha_req', 'like', "%{$search}%")
                      ->orWhere('requerimiento_head.estado', 'like', "%{$search}%");
            });
        }
    
        // Obtener el conteo total y el conteo filtrado
        $total_count = RequerimientoHead::count();
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
        $data = $query->get()->map(function ($row) {
            return [
                'opciones' => '',
                'id' => $row->id,
                'codigo' => $row->cod_req,
                'fecha' => $row->fecha_req,
                'estado' => $row->estado,
                'zona_solicitante' => $row->Area_recibida ?: 'Sin Área Recibida',
                'solicitante' => $row->solicitante ?: 'Sin Solicitante',
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
    


    public function generarCodigoRequerimiento($idUsuario)
    {
        // Obtener el usuario y su área asociada
        $usuario = DB::table('usuarios')
                    ->leftJoin('area', 'usuarios.id_Area_usuario', '=', 'area.id_area')
                    ->where('usuarios.id_usuario', $idUsuario)
                    ->select('usuarios.id_usuario', 'area.descripcion')
                    ->first();
    
        // Determinar el prefijo en función del área
        if ($usuario && $usuario->descripcion) {
            // Si el usuario tiene un área asignada, extraer los valores
            $areaParts = explode(' ', $usuario->descripcion);
            $prefijo = strtoupper(substr($areaParts[0], 0, 1));
            if (isset($areaParts[1])) {
                $prefijo .= strtoupper(substr($areaParts[1], 0, 3));
            }
        } else {
            // Si no tiene un área, usar el prefijo estándar "000"
            $prefijo = "000";
        }
    
        // Obtener el último código con el prefijo generado
        $ultimoCodigo = DB::table('requerimiento_head')
                          ->where('cod_req', 'like', $prefijo . '%')
                          ->orderByDesc('id')
                          ->value('cod_req');
    
        if ($ultimoCodigo) {
            // Extraer la parte numérica y convertirla a entero
            $numero = (int) substr($ultimoCodigo, strlen($prefijo));
    
            // Generar el nuevo número incrementado y formatearlo
            $nuevoNumero = str_pad($numero + 1, 6, '0', STR_PAD_LEFT);
            $nuevoCodigo = $prefijo . $nuevoNumero;
        } else {
            // Si no existe ningún registro con ese prefijo, empezar con el primer código
            $nuevoCodigo = $prefijo . '000001';
        }
    
        return response()->json(['nuevo_codigo' => $nuevoCodigo]);
    }
    public function obtenerDatosUsuario($idUsuario)
    {
        $usuario = DB::table('usuarios')
                    ->leftJoin('area', 'usuarios.id_Area_usuario', '=', 'area.id_area')
                    ->leftJoin('perfiles', 'usuarios.id_perfil_usuario', '=', 'perfiles.id_perfil')
                    ->where('usuarios.id_usuario', $idUsuario)
                    ->select(
                        'usuarios.id_usuario',
                        'usuarios.nomb_usuarios',
                        'usuarios.apellidos_usuarios',
                        'area.descripcion as area',
                        'perfiles.descripcion as perfil'
                    )
                    ->first();

        if ($usuario) {
            return response()->json([
                'id_usuario' => $usuario->id_usuario,
                'nombre'=> $usuario->nomb_usuarios,
                'nombre_completo' => $usuario->nomb_usuarios . ' ' . $usuario->apellidos_usuarios,
                'area' => $usuario->area ?? 'N/A',
                'perfil' => $usuario->perfil,
            ]);
        } else {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    }


    public function cargarCentrosCosto()
    {
        $centrosCosto = CentroCosto::all(); // Obtener todos los registros de la tabla centro_costo
    
        return response()->json(['centros_costo' => $centrosCosto]);
    }



    public function cargarUnidadMedida()
    {
        $unidadMedida = CodigoUnidadMedida::all(); // Obtener todos los registros de la tabla centro_costo
    
        return response()->json(['unidad_medida' => $unidadMedida]);
    }
    
    public function guardarRequerimiento(Request $request)
{
    DB::beginTransaction();

    try {
        // Validar datos del formulario
        $request->validate([
            'codigo_requerimiento' => 'required|string|max:60',
            'fecha_solicitud' => 'required|date',
            'estado' => 'required|integer',
            'id_usuario' => 'required|integer',
            'areaSelect' => 'required|integer',
            'producto_nombre' => 'required|array|min:1',
            'producto_nombre.*' => 'required|string|max:250',
            'producto_unidad.*' => 'required|string|max:10',
            'producto_especificaciones.*' => 'nullable|string|max:250',
            'producto_cantidad.*' => 'required|integer|min:1',
            'producto_centro_costo.*' => 'required|integer',
        ]);

        // Registrar encabezado
        $requerimientoHead = RequerimientoHead::create([
            'cod_req' => $request->input('codigo_requerimiento'),
            'fecha_req' => $request->input('fecha_solicitud'),
            'estado' => $request->input('estado'),
            'encargado' => $request->input('id_usuario'),
            'solicitante' => $request->input('id_usuario'),
            'Area_recibida' => $request->input('areaSelect'),
        ]);

        // Registrar productos
        foreach ($request->producto_nombre as $index => $producto) {
            RequerimientoBody::create([
                'id_requerimiento_head' => $requerimientoHead->id,
                'nombre_prod' => $producto,
                'unidad_medida' => $request->producto_unidad[$index],
                'nombre_marca' => $request->producto_especificaciones[$index],
                'cantidad' => $request->producto_cantidad[$index],
                'centro_costo' => $request->producto_centro_costo[$index],
            ]);
        }

        DB::commit();

        return response()->json(['success' => true, 'message' => 'Requerimiento registrado correctamente.']);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json(['success' => false, 'message' => 'Error al registrar el requerimiento.', 'error' => $e->getMessage()], 500);
    }
}

public function validarAccesoRequerimiento()
{
    try {
        $usuario = auth()->user(); // Obtener el usuario autenticado
        
        // Validar que el usuario tenga perfil "Administrador" y área "Gerencia General"
        $perfilAdministrador = $usuario->perfil->id_perfil === 1;
        $areaGerenciaGeneral = $usuario->area->id_area === 6;

        if ($perfilAdministrador && $areaGerenciaGeneral) {
            return response()->json(['success' => true, 'message' => 'Puedes Revisar Los Requerimientos']);
        } else {
            return response()->json(['success' => false, 'message' => 'Disculpa, no podemos cargar los datos.']);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Ocurrió un error al validar el acceso.', 'error' => $e->getMessage()], 500);
    }
}

public function listarRequerimientosRevicion(Request $request)
{
    $columnas = [
        "requerimiento_head.id", 
        "cod_req", 
        "fecha_req", 
        "estado", 
        "area.descripcion", 
        "usuarios_solicitante.nomb_usuarios", 
        "usuarios_revisado.nomb_usuarios"
    ];

    // Consulta base para obtener los requerimientos
    $query = RequerimientoHead::select(
        'requerimiento_head.id',
        'requerimiento_head.cod_req',
        'requerimiento_head.fecha_req',
        'requerimiento_head.estado',
        'area.descripcion as Area_recibida',
        'usuarios_solicitante.nomb_usuarios as solicitante',
        'usuarios_revisado.nomb_usuarios as revisado_req'
    )
    ->leftJoin('usuarios as usuarios_solicitante', 'requerimiento_head.solicitante', '=', 'usuarios_solicitante.id_usuario')
    ->leftJoin('area', 'requerimiento_head.Area_recibida', '=', 'area.id_area')
    ->leftJoin('usuarios as usuarios_revisado', 'requerimiento_head.revisado_req', '=', 'usuarios_revisado.id_usuario');

    // Aplicar filtros si se recibe un valor de búsqueda
    if ($request->search['value']) {
        $search = $request->search['value'];
        $query->where(function ($query) use ($search) {
            $query->where('requerimiento_head.cod_req', 'like', "%{$search}%")
                  ->orWhere('requerimiento_head.fecha_req', 'like', "%{$search}%")
                  ->orWhere('requerimiento_head.estado', 'like', "%{$search}%")
                  ->orWhere('area.descripcion', 'like', "%{$search}%")
                  ->orWhere('usuarios_solicitante.nomb_usuarios', 'like', "%{$search}%")
                  ->orWhere('usuarios_revisado.nomb_usuarios', 'like', "%{$search}%");
        });
    }

    // Obtener el conteo total y el conteo filtrado
    $total_count = RequerimientoHead::count();
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
    $data = $query->get()->map(function ($row) {
        return [
            'opciones' => '',
            'id' => $row->id,
            'codigo' => $row->cod_req,
            'fecha' => $row->fecha_req,
            'estado' => $row->estado,
            'zona_solicitante' => $row->Area_recibida ?: 'Sin Área Recibida',
            'solicitante' => $row->solicitante ?: 'Sin Solicitante',
            'revisado_req' => $row->revisado_req ?: 'N/A',
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


    public function obtenerRequerimiento($id)
    {
        // Obtener el encabezado del requerimiento
        $requerimiento = RequerimientoHead::with(['encargado.area', 'solicitante', 'arearecibida'])->find($id);

        if (!$requerimiento) {
            return response()->json(['success' => false, 'message' => 'Requerimiento no encontrado.'], 404);
        }

        // Obtener los detalles del requerimiento
        $detalles = RequerimientoBody::with(['unidadMedida', 'centroCosto'])
            ->where('id_requerimiento_head', $id)
            ->get();

        return response()->json([
            'success' => true,
            'encabezado' => $requerimiento,
            'detalles' => $detalles,
        ]);
    }

public function cambiarEstadoRequerimiento(Request $request)
{
    try {
        // Validar los datos enviados
        $request->validate([
            'id' => 'required|integer|exists:requerimiento_head,id',
            'estado' => 'required|integer|in:2,3,4,5', // Estados permitidos
        ]);

        // Buscar el requerimiento por ID
        $requerimiento = RequerimientoHead::find($request->id);

        if (!$requerimiento) {
            return response()->json([
                'success' => false,
                'message' => 'Requerimiento no encontrado.',
            ], 404);
        }

        // Cambiar el estado y registrar el usuario que revisó
        $requerimiento->estado = $request->estado;
        $requerimiento->revisado_req = auth()->user()->id_usuario; // Registrar el usuario actual
        $requerimiento->save();

        return response()->json([
            'success' => true,
            'message' => 'Estado del requerimiento actualizado correctamente.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar el estado.',
            'error' => $e->getMessage(),
        ], 500);
    }
}



// public function actualizarEstadoRequerimiento(Request $request)
// {
//     try {
//         // Validar los datos enviados
//         $request->validate([
//             'id' => 'required|integer|exists:requerimiento_head,id',
//             'estado' => 'required|integer|in:1,2,3,4,5', // Incluye todos los estados permitidos
//         ]);

//         // Buscar el requerimiento por ID
//         $requerimiento = RequerimientoHead::find($request->id);

//         if (!$requerimiento) {
//             Log::warning('Requerimiento no encontrado.', [
//                 'id' => $request->id
//             ]);

//             return response()->json([
//                 'success' => false,
//                 'message' => 'Requerimiento no encontrado.',
//             ], 404);
//         }

//         // Registrar el estado antes de la actualización
//         Log::info('Preparando para actualizar estado del requerimiento.', [
//             'id' => $requerimiento->id,
//             'estado_actual' => $requerimiento->estado,
//             'nuevo_estado' => $request->estado,
//         ]);

//         // Cambiar el estado
//         $requerimiento->estado = $request->estado;
//         $requerimiento->save();

//         // Confirmar que el estado se actualizó correctamente
//         Log::info('Estado actualizado correctamente para el requerimiento.', [
//             'id' => $requerimiento->id,
//             'estado' => $requerimiento->estado,
//         ]);

//         return response()->json([
//             'success' => true,
//             'message' => 'Estado del requerimiento actualizado correctamente.',
//         ]);
//     } catch (\Exception $e) {
//         // Registrar cualquier excepción que ocurra
//         Log::error('Error al cambiar el estado del requerimiento.', [
//             'error' => $e->getMessage(),
//             'request' => $request->all()
//         ]);

//         return response()->json([
//             'success' => false,
//             'message' => 'Error al actualizar el estado.',
//             'error' => $e->getMessage(),
//         ], 500);
//     }
// }

public function actualizarEstadoRequerimiento(Request $request)
{
    try {
        // Validar los datos enviados
        $request->validate([
            'id' => 'required|integer|exists:requerimiento_head,id',
            'estado' => 'required|integer|in:1,2,3,4,5', // Estados permitidos
        ]);

        // Buscar el requerimiento por ID
        $requerimiento = RequerimientoHead::find($request->id);

        if (!$requerimiento) {
            Log::warning('Requerimiento no encontrado.', [
                'id' => $request->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Requerimiento no encontrado.',
            ], 404);
        }

        // Registrar el estado antes de la actualización
        Log::info('Preparando para actualizar estado del requerimiento.', [
            'id' => $requerimiento->id,
            'estado_actual' => $requerimiento->estado,
            'nuevo_estado' => $request->estado,
        ]);

        // Cambiar el estado y registrar el usuario autenticado
        $requerimiento->estado = $request->estado;
        $requerimiento->revisado_req = auth()->user()->id_usuario; // Registrar el ID del usuario autenticado
        $requerimiento->save();

        // Confirmar que el estado se actualizó correctamente
        Log::info('Estado y revisado_req actualizados correctamente.', [
            'id' => $requerimiento->id,
            'estado' => $requerimiento->estado,
            'revisado_req' => $requerimiento->revisado_req,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Estado del requerimiento actualizado correctamente.',
        ]);
    } catch (\Exception $e) {
        // Registrar cualquier excepción que ocurra
        Log::error('Error al cambiar el estado del requerimiento.', [
            'error' => $e->getMessage(),
            'request' => $request->all()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar el estado.',
            'error' => $e->getMessage(),
        ], 500);
    }
}







}

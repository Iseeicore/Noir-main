<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\ConfigRutas;
use App\Models\CodigoAcceso;



class AdministrativoController extends Controller
{

    private $apiUrlConfig = 'https://dniruc.apisperu.com/api/v1/ruc';
    private $apiTokenProveedor = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImFyaXNlc2NycEBnbWFpbC5jb20ifQ.xE8AVDAGBNR7j1DSr56rUXbjJzhy7oXo59qdjAL_wLY';
    
    public function listarProveedores(Request $request)
    {
        $columnas = ["id", "cod_proveedor", "ruc", "razon_social", "estado", "contacto", "numero"];

        // Consulta base para obtener los proveedores
        $query = Proveedor::select(
            'id',
            'cod_proveedor',
            'ruc',
            'razon_social',
            DB::raw("IF(estado = 1, 'ACTIVO', 'INACTIVO') as estado"),
            'contacto',
            'numero',
            'direccion', 
            'email'
        );

        // Aplicar filtros
        if ($request->search['value']) {
            $search = $request->search['value'];
            $query->where(function($query) use ($search) {
                $query->where('cod_proveedor', 'like', "%{$search}%")
                      ->orWhere('ruc', 'like', "%{$search}%")
                      ->orWhere('razon_social', 'like', "%{$search}%")
                      ->orWhere('contacto', 'like', "%{$search}%");
            });
        }

        // Obtener el conteo total y el conteo filtrado
        $total_count = Proveedor::count();
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
                'codigo' => $row->cod_proveedor,
                'ruc' => $row->ruc,
                'razon_social' => $row->razon_social,
                'estado' => $row->estado,
                'contacto' => $row->contacto,
                'numero' => $row->numero,
                'direccion' => $row->direccion, // Enviar direccion sin mostrar
                'email' => $row->email 
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
    // public function obtenerDatosDelRuc(Request $request)
    // {

        

    //     $ruc = $request->input('ruc');

    //     // Validar si el RUC tiene 11 dígitos
    //     if (strlen($ruc) !== 11) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'El RUC debe tener 11 dígitos.',
    //         ]);
    //     }


    //       // Llamar a la API
    //         try {
    //             $response = Http::get("{$this->apiUrlConfig}/{$ruc}", [
    //                 'token' => $this->apiTokenProveedor,
    //             ]);

    //         // Verificar si la solicitud fue exitosa y si se encontró el RUC
    //         if ($response->successful() && isset($response['razonSocial'])) {
    //             return response()->json([
    //                 'success' => true,
    //                 'razon_social' => $response['razonSocial'],
    //                 'direccion' => $response['direccion'] ?? '',
    //             ]);
    //         }
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No se encontró la empresa para el RUC ingresado.',
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error al conectar con la API.',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    
    public function obtenerDatosDelRuc(Request $request)
    {
        DB::beginTransaction();
        try {
            // Obtener la configuración de la tabla Config_Rutas
            $configuracion = ConfigRutas::first();
            if (!$configuracion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Configuración de la API no encontrada.',
                ], 500);
            }

            $apiUrl = $configuracion->api_url;
            $apiToken = $configuracion->api_token;
            $ruc = $request->input('ruc');

            // Validar si el RUC tiene 11 dígitos
            if (strlen($ruc) !== 11) {
                return response()->json([
                    'success' => false,
                    'message' => 'El RUC debe tener 11 dígitos.',
                ]);
            }

            // Llamar a la API
            try {
                $response = Http::get("{$apiUrl}/{$ruc}", [
                    'token' => $apiToken,
                ]);

                // Verificar si la solicitud fue exitosa y si se encontró el RUC
                if ($response->successful() && isset($response['razonSocial'])) {
                    return response()->json([
                        'success' => true,
                        'razon_social' => $response['razonSocial'],
                        'direccion' => $response['direccion'] ?? '',
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró la empresa para el RUC ingresado.',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al conectar con la API.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



public function generarCodigoProveedor()
{
    // Obtener el último `cod_proveedor` de la tabla `proveedores`
    $ultimoCodigo = DB::table('proveedores')
                      ->select('cod_proveedor')
                      ->orderByDesc('id') // Ordenar por `id` de forma descendente para obtener el último
                      ->limit(1)
                      ->value('cod_proveedor');

    if ($ultimoCodigo) {
        // Extraer la parte numérica y convertirla a entero
        $numero = (int) substr($ultimoCodigo, 4);

        // Generar el nuevo número incrementado y formatearlo
        $nuevoNumero = str_pad($numero + 1, 3, '0', STR_PAD_LEFT);
        $nuevoCodigo = "PROV" . $nuevoNumero;
    } else {
        // Si no existe ningún registro, empezar con `PROV001`
        $nuevoCodigo = "PROV001";
    }

    return response()->json(['nuevo_codigo' => $nuevoCodigo]);
}

public function guardarProveedor(Request $request)
{
    // Validar los datos de entrada
    $request->validate([
        'cod_proveedor' => 'required|string|max:10',
        'ruc' => 'required|digits:11',
        'razon_social' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'contacto' => 'required|string|max:255',
        'numero' => 'required|string|max:20',
        'email' => 'required|email|max:255',
    ]);

    try {
        // Crear o actualizar proveedor
        Proveedor::updateOrCreate(
            ['cod_proveedor' => $request->input('cod_proveedor')],
            $request->only('cod_proveedor', 'ruc', 'razon_social', 'direccion', 'contacto', 'numero', 'email', 'estado')
        );

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Proveedor registrado exitosamente',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Error al registrar proveedor: ' . $e->getMessage(),
        ]);
    }
}
public function actualizarProveedor(Request $request, $id)
{
    // Validar los datos de entrada
    $request->validate([
        'cod_proveedor' => 'required|string|max:10',
        'ruc' => 'required|digits:11',
        'razon_social' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'contacto' => 'required|string|max:255',
        'numero' => 'required|string|max:20',
        'email' => 'required|email|max:255',
    ]);

    try {
        // Buscar el proveedor y actualizarlo
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->only('cod_proveedor', 'ruc', 'razon_social', 'direccion', 'contacto', 'numero', 'email'));

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Proveedor actualizado exitosamente',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Error al actualizar proveedor: ' . $e->getMessage(),
        ]);
    }
}
public function eliminarProveedor($id)
{
    try {
        // Intentamos encontrar el proveedor y eliminarlo
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Proveedor eliminado correctamente'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Ocurrió un error al eliminar el proveedor'
        ]);
    }
}
public function cambiarEstadoProveedor(Request $request, $id)
{
    try {
        // Encontrar el proveedor por ID
        $proveedor = Proveedor::findOrFail($id);

        // Cambiar el estado
        $proveedor->estado = $request->estado;
        $proveedor->save();

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Estado del proveedor actualizado correctamente',
            'nuevo_estado' => $proveedor->estado == 1 ? 'ACTIVO' : 'INACTIVO'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Ocurrió un error al cambiar el estado del proveedor'
        ]);
    }
}

public function getRucConfig()
{
    // Obtener la configuración actual desde la tabla
    $configuracion = ConfigRutas::find(1);

    if (!$configuracion) {
        return response()->json([
            'success' => false,
            'message' => 'No se encontró la configuración de RUC.',
        ]);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'apiUrl' => $configuracion->api_url,
            'apiToken' => $configuracion->api_token,
        ]
    ]);
}
public function updateRucConfig(Request $request)
{
    $request->validate([
        'apiUrl' => 'required|url',
        'apiToken' => 'required|string',
    ]);

    try {
        $configuracion = ConfigRutas::find(1);

        if (!$configuracion) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró la configuración de RUC para actualizar.',
            ]);
        }

        // Actualizar los valores en la base de datos
        $configuracion->update([
            'api_url' => $request->apiUrl,
            'api_token' => $request->apiToken,
            'UsuarioModificar' => auth()->user()->id_usuario, // Usuario que realiza la actualización
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Configuración de RUC actualizada correctamente.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error al actualizar la configuración de RUC.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function restaurarRucConfig()
{
    try {
        // Buscar la configuración con ID 1
        $configuracion = ConfigRutas::find(1);

        if (!$configuracion) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró la configuración de RUC para restaurar.',
            ]);
        }

        // Restaurar los valores de las variables globales
        $configuracion->update([
            'api_url' => $this->apiUrlConfig,
            'api_token' => $this->apiTokenProveedor,
            'UsuarioModificar' => auth()->user()->id_usuario, // Usuario que realiza la restauración
        ]);

        return response()->json([
            'success' => true,
            'message' => 'La configuración de RUC fue restaurada correctamente.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error al restaurar la configuración de RUC.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function verificarPermisoEditar()
{
    $usuarioActual = auth()->user();

    if ($usuarioActual->id_almacen_usuario !== 1) {
        return response()->json([
            'success' => false,
            'message' => 'No estás permitido para editar, Solo Almacen 1',
        ], 403);
    }

    return response()->json([
        'success' => true,
        'message' => 'Permiso concedido.',
    ]);
}

public function getCodigoAcceso()
{
    $codigoAcceso = CodigoAcceso::find(1);

    if (!$codigoAcceso) {
        return response()->json([
            'success' => false,
            'message' => 'No se encontró el Código de Validación.',
        ]);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'codigo' => $codigoAcceso->CodigoAcceso, // Mostrar directamente el código
        ],
    ]);
}



public function updateCodigoAcceso(Request $request)
{
    $request->validate([
        'codigo' => 'required|string|min:8',
    ]);

    try {
        $codigoAcceso = CodigoAcceso::find(1);

        if (!$codigoAcceso) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró el Código de Validación para actualizar.',
            ]);
        }

        $codigoAcceso->update([
            'CodigoAcceso' => $request->codigo,
            'UsuarioModificar' => auth()->user()->id_usuario,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Código de Validación actualizado correctamente.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error al actualizar el Código de Validación.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function validarCodigo(Request $request)
    {
        $codigo = $request->input('codigo');

        // Buscar el código en la base de datos
        $existeCodigo = CodigoAcceso::where('CodigoAcceso', $codigo)->exists();

        if ($existeCodigo) {
            return response()->json([
                'success' => true,
                'message' => 'Código válido.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Código incorrecto o no autorizado.',
        ], 400);
    }



}

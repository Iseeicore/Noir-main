<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\TipoCambio;
use App\Models\ConfigRutas;

class TipoCambioController extends Controller
{
    private $apiUrl = 'https://api.apis.net.pe/v2/sbs/tipo-cambio';
    private $apiToken = 'apis-token-11661.mg6ob2gQLMRkvYPVeZwr78glq7eCZDlr';

    public function tipoCambioHoy()
{
    $fechaHoy = now()->toDateString();

    // Verificar si ya existe un registro para el día actual
    $tipoCambio = TipoCambio::where('fecha', $fechaHoy)->first();

    if ($tipoCambio) {
        return response()->json([
            'success' => true,
            'data' => [
                'fecha' => $tipoCambio->fecha,
                'moneda_origen' => $tipoCambio->moneda_origen,
                'moneda_destino' => $tipoCambio->moneda_destino,
                'tipo_cambio_compra' => (float) $tipoCambio->tipo_cambio_compra,
                'tipo_cambio_venta' => (float) $tipoCambio->tipo_cambio_venta,
            ]
        ]);
    }

    // Si no existe, obtener de la API
    try {
        $response = Http::withToken($this->apiToken)->get($this->apiUrl);

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['precioCompra'], $data['precioVenta'], $data['fecha'])) {
                // Guardar en la base de datos
                $tipoCambio = TipoCambio::create([
                    'fecha' => $fechaHoy,
                    'moneda_origen' => 'USD',
                    'moneda_destino' => 'PEN',
                    'tipo_cambio_compra' => $data['precioCompra'],
                    'tipo_cambio_venta' => $data['precioVenta'],
                    'estado' => 1
                ]);

                return response()->json([
                    'success' => true,
                    'data' => [
                        'fecha' => $tipoCambio->fecha,
                        'moneda_origen' => $tipoCambio->moneda_origen,
                        'moneda_destino' => $tipoCambio->moneda_destino,
                        'tipo_cambio_compra' => (float) $tipoCambio->tipo_cambio_compra,
                        'tipo_cambio_venta' => (float) $tipoCambio->tipo_cambio_venta,
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'La API no devolvió los datos esperados.',
                ], 500);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'No se pudo conectar con la API de tipo de cambio.'
        ], 500);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al conectar con la API.',
            'error' => $e->getMessage()
        ], 500);
    }
}


    // public function tipoCambioPorFecha(Request $request)
    // {
    //     $fecha = $request->input('date');
    //     $moneda = $request->input('currency', 'USD'); // Por defecto será USD si no se especifica

    //     try {
    //         $response = Http::withToken($this->apiToken)
    //             ->get("{$this->apiUrl}?date={$fecha}&currency={$moneda}");

    //         if ($response->successful()) {
    //             $data = $response->json();
    //             return response()->json([
    //                 'success' => true,
    //                 'data' => [
    //                     'fecha' => $data['fecha'],
    //                     'compra' => $data['precioCompra'] ?? null, // Asegúrate de que el nombre del campo coincida
    //                     'venta' => $data['precioVenta'] ?? null,
    //                     'moneda' => $moneda
    //                 ]
    //             ]);
    //         }

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No se pudo obtener el tipo de cambio para la fecha y moneda seleccionada.'
    //         ], 500);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error al conectar con la API.',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function tipoCambioPorFecha(Request $request)
{
    $fecha = $request->input('date');
    $moneda = $request->input('currency', 'USD'); // Por defecto será USD

    // Validar parámetros
    if (!$fecha || !$moneda) {
        return response()->json([
            'success' => false,
            'message' => 'La fecha y la moneda son requeridas.'
        ], 400);
    }

    // Verificar si ya existe un registro para la fecha y moneda
    $tipoCambio = TipoCambio::where('fecha', $fecha)
        ->where('moneda_origen', $moneda)
        ->where('moneda_destino', 'PEN')
        ->first();

    if ($tipoCambio) {
        return response()->json([
            'success' => true,
            'data' => [
                'fecha' => $tipoCambio->fecha,
                'moneda' => $tipoCambio->moneda_origen,
                'compra' => $tipoCambio->tipo_cambio_compra ?? 'N/A',
                'venta' => $tipoCambio->tipo_cambio_venta ?? 'N/A',
            ]
        ]);
    }

    // Si no existe, obtener de la API
    try {
        $response = Http::withToken($this->apiToken)
            ->get("{$this->apiUrl}?date={$fecha}&currency={$moneda}");

        if ($response->successful()) {
            $data = $response->json();

            // Validar que la API devolvió datos válidos
            if (isset($data['precioCompra'], $data['precioVenta'], $data['fecha'])) {
                // Guardar en la base de datos
                $tipoCambio = TipoCambio::create([
                    'fecha' => $fecha,
                    'moneda_origen' => $moneda,
                    'moneda_destino' => 'PEN',
                    'tipo_cambio_compra' => $data['precioCompra'],
                    'tipo_cambio_venta' => $data['precioVenta'],
                    'estado' => 1
                ]);

                return response()->json([
                    'success' => true,
                    'data' => [
                        'fecha' => $tipoCambio->fecha,
                        'moneda' => $tipoCambio->moneda_origen,
                        'compra' => $tipoCambio->tipo_cambio_compra,
                        'venta' => $tipoCambio->tipo_cambio_venta,
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'La API no devolvió los datos esperados.'
            ], 500);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se pudo conectar con la API de tipo de cambio.'
        ], 500);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al conectar con la API.',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function listarTipoCambio(Request $request)
{
    $columnas = [
        'id', 
        'fecha', 
        'moneda_origen', 
        'moneda_destino', 
        'tipo_cambio_compra', 
        'tipo_cambio_venta', 
        'estado'
    ];

    // Consulta base para obtener los registros de tipo de cambio
    $query = TipoCambio::query();

    // Aplicar filtros si se recibe un valor de búsqueda
    if ($request->search['value']) {
        $search = $request->search['value'];
        $query->where(function ($query) use ($search) {
            $query->where('fecha', 'like', "%{$search}%")
                  ->orWhere('moneda_origen', 'like', "%{$search}%")
                  ->orWhere('moneda_destino', 'like', "%{$search}%")
                  ->orWhere('tipo_cambio_compra', 'like', "%{$search}%")
                  ->orWhere('tipo_cambio_venta', 'like', "%{$search}%")
                  ->orWhere('estado', 'like', "%{$search}%");
        });
    }

    // Obtener el conteo total y el conteo filtrado
    $total_count = TipoCambio::count();
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
            'id' => $row->id,
            'fecha' => $row->fecha,
            'moneda_origen' => $row->moneda_origen,
            'moneda_destino' => $row->moneda_destino,
            'tipo_cambio_compra' => $row->tipo_cambio_compra ? number_format($row->tipo_cambio_compra, 4) : 'N/A',
            'tipo_cambio_venta' => $row->tipo_cambio_venta ? number_format($row->tipo_cambio_venta, 4) : 'N/A',
            'estado' => $row->estado ? 'Activo' : 'Inactivo',
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

    public function getTipoCambioConfig()
    {
        // Obtener la configuración actual desde la tabla con id = 2
        $configuracion = ConfigRutas::find(2);

        if (!$configuracion) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró la configuración de Tipo de Cambio.',
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


    public function updateTipoCambioConfig(Request $request)
    {
        $request->validate([
            'apiUrl' => 'required|url',
            'apiToken' => 'required|string',
        ]);
    
        try {
            // Buscar la configuración con ID 2
            $configuracion = ConfigRutas::find(2);
    
            if (!$configuracion) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró la configuración de Tipo de Cambio para actualizar.',
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
                'message' => 'Configuración de Tipo de Cambio actualizada correctamente.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al actualizar la configuración de Tipo de Cambio.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    public function restaurarTipoCambioConfig()
{
    try {
        // Buscar la configuración con ID 2
        $configuracion = ConfigRutas::find(2);

        if (!$configuracion) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró la configuración de Tipo de Cambio para restaurar.',
            ]);
        }

        // Restaurar los valores de las variables globales
        $configuracion->update([
            'api_url' => $this->apiUrl, // Cambiar si hay variables específicas
            'api_token' => $this->apiToken, // Cambiar si hay variables específicas
            'UsuarioModificar' => auth()->user()->id_usuario, // Usuario que realiza la restauración
        ]);

        return response()->json([
            'success' => true,
            'message' => 'La configuración de Tipo de Cambio fue restaurada correctamente.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error al restaurar la configuración de Tipo de Cambio.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}




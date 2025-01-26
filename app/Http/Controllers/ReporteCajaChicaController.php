<?php

namespace App\Http\Controllers;

use App\Models\MovimientoCajaChica;
use App\Models\CajaChica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ReporteCajaChicaController extends Controller
{
    /**
     * Carga la vista principal del reporte.
     */
    public function index()
    {
        return view('vistas.cajas.cajachica.reportecajachica');
    }

    /**
     * Lista todos los movimientos de caja chica con sus relaciones.
     */
    public function listarMovimientos()
    {
        $movimientos = MovimientoCajaChica::with('cajaChica:id,descripcion') // Asegúrate de incluir el ID y la descripción
            ->select('id', 'id_caja_chica', 'tipo_movimiento', 'monto', 'descripcion', 'fecha')
            ->get();

        return response()->json($movimientos);
    }



    /**
     * Filtra movimientos de caja chica por rango de fechas y caja.
     */
    public function filtrar(Request $request)
    {
        // Registra los datos recibidos para depuración
        Log::info('Datos recibidos en filtrar:', $request->all());

        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $descripcion = $request->input('descripcion'); // Descripción seleccionada

        // Consulta base
        $query = MovimientoCajaChica::with('cajaChica');

        // Aplicar filtro por rango de fechas si están presentes
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }

        // Aplicar filtro por descripción si está presente
        if (!empty($descripcion)) {
            $query->whereHas('cajaChica', function ($q) use ($descripcion) {
                $q->where('descripcion', 'LIKE', '%' . $descripcion . '%');
            });
        }

        // Obtener los resultados filtrados
        $movimientos = $query->get();

        return response()->json($movimientos);
    }

    /**
     * Muestra un reporte detallado de un movimiento específico para impresión.
     */
    public function imprimir($id)
    {
        $movimiento = MovimientoCajaChica::with(['cajaChica', 'categoria', 'usuario'])
            ->where('id', $id)
            ->firstOrFail();

        return view('vistas.imprimir', compact('movimiento'));
    }
    public function listarDescripciones()
    {
        $descripciones = CajaChica::whereNotNull('descripcion') // Evitar descripciones nulas
            ->pluck('descripcion')
            ->unique()
            ->values(); // Asegurar un índice limpio

        return response()->json($descripciones);
    }


}

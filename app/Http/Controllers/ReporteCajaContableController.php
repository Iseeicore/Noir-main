<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovimientoCajaContable;
use App\Models\CajaContable;
use App\Models\Usuario;
use App\Models\CategoriaMovimiento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteCajaContableController extends Controller
{
    /*** Listar todos los movimientos de caja contable.*/
    public function listar()
    {
        $movimientos = MovimientoCajaContable::with(['cajaContable', 'usuario', 'categoria'])
            ->orderBy('fecha', 'desc')
            ->get();

        $formattedMovimientos = $this->formatMovimientos($movimientos);

        return response()->json($formattedMovimientos);
    }

    /*** Filtrar movimientos de caja contable.*/
    public function filtrar(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
            'responsable' => 'nullable|integer|exists:usuarios,id_usuario',
            'tipo_movimiento' => 'nullable|in:ingreso,egreso',
            'categoria_id' => 'nullable|integer|exists:categorias_movimientos,id', // Tabla correcta
            'caja_contable' => 'nullable|integer|exists:caja_contable,id',
        ]);

        $query = MovimientoCajaContable::with(['cajaContable', 'usuario', 'categoria']);

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha', [
                Carbon::parse($request->fecha_inicio)->startOfDay(),
                Carbon::parse($request->fecha_fin)->endOfDay(),
            ]);
        }

        if ($request->filled('responsable')) {
            $query->where('usuario_id', $request->responsable);
        }

        if ($request->filled('tipo_movimiento')) {
            $query->where('tipo_movimiento', $request->tipo_movimiento);
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('caja_contable')) {
            $query->where('id_caja_contable', $request->caja_contable);
        }

        $movimientos = $query->orderBy('fecha', 'desc')->get();

        $formattedMovimientos = $this->formatMovimientos($movimientos);

        return response()->json($formattedMovimientos);
    }

    /**
     * Formatear movimientos para el frontend.
     */
    private function formatMovimientos($movimientos)
    {
        return $movimientos->map(function ($movimiento) {
            return [
                'fecha' => $movimiento->fecha->format('Y-m-d'),
                'responsable' => $movimiento->usuario
                    ? $movimiento->usuario->nomb_usuarios . ' ' . $movimiento->usuario->apellidos_usuarios
                    : 'N/A',
                'caja_contable' => $movimiento->cajaContable->descripcion ?? 'N/A',
                'tipo_movimiento' => ucfirst($movimiento->tipo_movimiento),
                'categoria' => $movimiento->categoria->nombre ?? 'Sin categoría', // Cambiar a la relación 'categoria'
                'descripcion' => $movimiento->descripcion ?? 'N/A',
                'referencia' => $movimiento->referencia ?? 'N/A',
                'ingreso' => $movimiento->tipo_movimiento === 'ingreso' ? (float) $movimiento->monto : null,
                'egreso' => $movimiento->tipo_movimiento === 'egreso' ? (float) $movimiento->monto : null,
            ];
        });
    }
    public function listarCajasContables()
    {
        // Obtener todas las cajas contables con sus descripciones
        $cajas = CajaContable::select('id', 'descripcion')->get();

        // Retornar las cajas contables en formato JSON
        return response()->json($cajas);
    }
    public function listarResponsables()
    {
        try {
            // Obtener usuarios activos con id y nombre completo
            $responsables = Usuario::where('estado', 1)
                ->select('id_usuario as id', DB::raw("CONCAT(nomb_usuarios, ' ', apellidos_usuarios) as nombre"))
                ->get();

            return response()->json($responsables);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error al listar los responsables: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function listarCategorias()
    {
        $categorias = CategoriaMovimiento::getActivas();
        return response()->json($categorias);
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\CajaContable;
use App\Models\MovimientoCajaContable;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\CategoriaMovimiento;

class CajaContableController extends Controller
{
    // Vista principal


    public function index()
    {
        $categorias = CategoriaMovimiento::where('estado', 1)->get(); // Obtener categorías activas
        return view('vistas.cajas.cajacontable.caja_contable', compact('categorias')); // Pasar las categorías a la vista
    }

    // Listar datos de la caja activa
    public function listar()
    {
        $cajaActiva = CajaContable::where('estado', 1)->first();

        if (!$cajaActiva) {
            return response()->json([
                'saldo_inicial' => 0,
                'saldo_actual' => 0,
                'total_ingresos' => 0,
                'total_egresos' => 0,
                'movimientos' => [],
                'crear_saldo_habilitado' => true,
                'caja_activa' => false,
            ]);
        }

        // Obtener movimientos con relación a la categoría
        $movimientos = $cajaActiva->movimientos()
            ->with('categoria:id,nombre') // Incluir solo el campo "nombre" de la categoría
            ->orderBy('fecha', 'asc')
            ->get();

        $saldoAcumulado = $cajaActiva->monto_inicial;
        foreach ($movimientos as $movimiento) {
            if ($movimiento->tipo_movimiento === 'ingreso') {
                $saldoAcumulado += $movimiento->monto;
            } else {
                $saldoAcumulado -= $movimiento->monto;
            }
            $movimiento->saldo = $saldoAcumulado; // Añadir saldo acumulado
        }

        return response()->json([
            'id_caja' => $cajaActiva->id,
            'saldo_inicial' => number_format($cajaActiva->monto_inicial, 2),
            'saldo_actual' => number_format($cajaActiva->monto_actual, 2),
            'total_ingresos' => number_format($cajaActiva->calcularTotalIngresos(), 2),
            'total_egresos' => number_format($cajaActiva->calcularTotalEgresos(), 2),
            'movimientos' => $movimientos, // Movimientos con la categoría incluida
            'crear_saldo_habilitado' => $cajaActiva->monto_actual == 0,
            'caja_activa' => true,
        ]);
    }


    // Crear saldo inicial para una nueva caja
    public function crearSaldoInicial(Request $request)
    {
        $validated = $request->validate([
            'responsable_id' => 'required|integer|exists:usuarios,id_usuario',
            'monto_inicial' => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string|max:255',
        ]);

        // Verificar si hay una caja activa con saldo
        $cajaActiva = CajaContable::where('estado', 1)->first();
        if ($cajaActiva) {
            $ingresos = $cajaActiva->movimientos()->where('tipo_movimiento', 'ingreso')->sum('monto');
            $egresos = $cajaActiva->movimientos()->where('tipo_movimiento', 'egreso')->sum('monto');
            $saldoCalculado = $cajaActiva->monto_inicial + $ingresos - $egresos;

            if ($saldoCalculado > 0) {
                return response()->json(['message' => 'No puedes crear una nueva caja con saldo disponible.'], 400);
            }

            // Desactivar la caja activa
            $cajaActiva->estado = 0;
            $cajaActiva->save();
        }


        // Crear nueva caja
        $cajaContable = new CajaContable();
        $cajaContable->monto_inicial = $validated['monto_inicial'];
        $cajaContable->monto_actual = $validated['monto_inicial'];
        $cajaContable->responsable = $validated['responsable_id'];
        $cajaContable->descripcion = $validated['descripcion'];
        $cajaContable->fecha_creacion = now();
        $cajaContable->estado = 1;
        $cajaContable->save();

        return response()->json([
            'message' => 'Nueva caja contable creada exitosamente.',
            'id_caja' => $cajaContable->id
        ]);
    }

    // Registrar un movimiento (ingreso o egreso)
    public function registrarMovimiento(Request $request)
{
    $validatedData = $request->validate([
        'id_caja_contable' => 'required|exists:caja_contable,id',
        'tipo_movimiento' => 'required|in:ingreso,egreso',
        'monto' => 'required|numeric|min:0',
        'descripcion' => 'nullable|string|max:255',
        'referencia' => 'nullable|string|max:255',
        'fecha' => 'required|date',
        'categoria_id' => 'required|exists:categorias_movimientos,id',
        'concepto' => 'nullable|string|max:255',
    ]);

    DB::beginTransaction();

    try {
        // Crear movimiento
        $movimiento = MovimientoCajaContable::create([
            'id_caja_contable' => $validatedData['id_caja_contable'],
            'tipo_movimiento' => $validatedData['tipo_movimiento'],
            'monto' => $validatedData['monto'],
            'descripcion' => $validatedData['descripcion'],
            'referencia' => $validatedData['referencia'],
            'fecha' => $validatedData['fecha'],
            'categoria_id' => $validatedData['categoria_id'],
            'concepto' => $validatedData['concepto'],
            'usuario_id' => auth()->id(),
        ]);

        // Actualizar el saldo actual en la caja contable
        $caja = CajaContable::find($validatedData['id_caja_contable']);
        if ($validatedData['tipo_movimiento'] === 'ingreso') {
            $caja->monto_actual += $validatedData['monto'];
        } else {
            $caja->monto_actual -= $validatedData['monto'];
        }
        $caja->save();

        DB::commit();

        return response()->json(['message' => 'Movimiento registrado con éxito.'], 201);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error($e->getMessage());
        return response()->json(['message' => 'Error al registrar el movimiento.'], 500);
    }
}




    // Listar responsables activos
    public function listarResponsables()
    {
        $responsables = Usuario::where('estado', 1)
            ->select('id_usuario as id', DB::raw("CONCAT(nomb_usuarios, ' ', apellidos_usuarios) as nombre"))
            ->get();

        return response()->json($responsables);
    }
    public function listarCategorias()
    {
        $categorias = CategoriaMovimiento::where('estado', 1)
            ->select('id', 'nombre') // Seleccionar sólo los campos necesarios
            ->get();

        return response()->json($categorias);
    }




}

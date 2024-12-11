<?php

namespace App\Http\Controllers;

use App\Models\CajaChica;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class CajaChicaController extends Controller
{
    public function index()
    {
        session(['vista_usuario' => 'caja_chica']);
        return view('vistas.cajas.cajachica.caja_chica');
    }

    public function listar()
    {
        $cajaActiva = CajaChica::where('estado', 1)->first();

        if (!$cajaActiva) {
            return response()->json([
                'saldo_inicial' => 0,
                'saldo_gastado' => 0,
                'saldo_final' => 0,
                'movimientos' => [],
                'crear_saldo_habilitado' => true,
                'caja_id' => null,
                'caja_activa' => false,
            ]);
        }

        return response()->json([
            'saldo_inicial' => number_format($cajaActiva->monto_inicial, 2),
            'saldo_gastado' => number_format($cajaActiva->calcularGastoAcumulado(), 2),
            'saldo_final' => number_format($cajaActiva->calcularSaldo(), 2),
            'movimientos' => $cajaActiva->movimientos()->orderBy('fecha', 'desc')->get(),
            'crear_saldo_habilitado' => $cajaActiva->calcularSaldo() == 0,
            'caja_id' => $cajaActiva->id,
            'caja_activa' => true,
        ]);
    }

    public function crearSaldoInicial(Request $request)
    {
        // Verificar si hay una caja activa con saldo mayor a 0
        $cajaActiva = CajaChica::where('estado', 1)->first();

        if ($cajaActiva && $cajaActiva->calcularSaldo() > 0) {
            return response()->json(['message' => 'No puedes crear un nuevo saldo mientras el saldo de la caja activa no sea cero.'], 400);
        }

        $validated = $request->validate([
            'mes' => 'required|date_format:Y-m',
            'responsable_id' => 'required|integer|exists:usuarios,id_usuario',
            'monto_inicial' => 'required|numeric|min:0.01',
        ]);

        // Desactivar cualquier caja previa si existe
        if ($cajaActiva) {
            $cajaActiva->estado = 0;
            $cajaActiva->save();
        }

        // Crear una nueva caja chica
        $cajaChica = new CajaChica();
        $cajaChica->monto_inicial = $validated['monto_inicial'];
        $cajaChica->monto_actual = $validated['monto_inicial'];
        $cajaChica->encargado = $validated['responsable_id'];
        //crea descripcion automaticamente del mes inicial
        $cajaChica->descripcion = "Saldo inicial para el mes de " . date('F Y', strtotime($validated['mes']));
        $cajaChica->fecha_creacion = now();
        $cajaChica->estado = 1;
        $cajaChica->save();

        return response()->json([
            'message' => 'Saldo inicial creado exitosamente.',
            'saldo_inicial' => number_format($cajaChica->monto_inicial, 2),
            'saldo_gastado' => number_format(0, 2),
            'saldo_final' => number_format($cajaChica->monto_actual, 2),
            'caja_id' => $cajaChica->id,
        ]);
    }

    public function registrarGasto(Request $request)
    {
        $validated = $request->validate([
            'caja_chica_id' => 'required|integer|exists:caja_chica,id',
            'monto' => 'required|numeric|min:0.01',
            'descripcion' => 'required|string|max:255',
            'fecha' => 'required|date',
        ]);

        $cajaChica = CajaChica::findOrFail($validated['caja_chica_id']);

        if ($cajaChica->calcularSaldo() < $validated['monto']) {
            return response()->json(['message' => 'El monto del gasto excede el saldo actual.'], 400);
        }

        // Registrar el movimiento
        $movimiento = $cajaChica->movimientos()->create([
            'monto' => $validated['monto'],
            'descripcion' => $validated['descripcion'],
            'fecha' => $validated['fecha'],
            'tipo_movimiento' => 'egreso',
            'usuario_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Gasto registrado exitosamente.',
            'movimiento' => $movimiento, // Retorna el movimiento para actualizaciones en frontend
        ]);
    }


    public function listarResponsables()
    {
        $responsables = Usuario::where('estado', 1)
            ->select('id_usuario as id', DB::raw("CONCAT(nomb_usuarios, ' ', apellidos_usuarios) as nombre"))
            ->get();

        return response()->json($responsables);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CajaChica;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Banco;
use Illuminate\Support\Facades\DB;

class CajaChicaController extends Controller
{
    public function index()
    {
        $bancos = Banco::where('estado', 1)->get();
        dd($bancos); // Depuración
        return view('vistas.cajas.cajachica.caja_chica', compact('bancos'));
    }
    public function listarBancos()
    {
        $bancos = Banco::where('estado', 1)->get(['id', 'nombre_banco', 'tipo_moneda']); // Filtrar por estado activo
        return response()->json($bancos);
    }

    public function validarBanco(Request $request)
    {
        $request->validate([
            'banco_id' => 'required|exists:bancos,id',
        ]);

        $banco = Banco::findOrFail($request->banco_id);

        // Verificar si es el banco BBVA Soles
        if ($banco->id == 1) {
            return response()->json([
                'success' => true,
                'message' => 'Acceso permitido a Caja Chica.',
                'banco' => $banco,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Solo el banco BBVA en soles tiene acceso a Caja Chica.',
        ], 400);
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

    if ($cajaActiva && $cajaActiva->monto_actual > 0) {
        return response()->json([
            'message' => 'No puedes crear un nuevo saldo mientras el saldo de la caja activa no sea cero.'
        ], 400);
    }

    $validated = $request->validate([
        'mes' => 'required|date_format:Y-m',
        'responsable_id' => 'required|integer|exists:usuarios,id_usuario',
        'monto_inicial' => 'required|numeric|min:0.01',
    ]);

    // Verificar si el banco BBVA SOLES existe
    $bancoBBVASoles = Banco::where('nombre_banco', 'BBVA SOLES')
        ->where('tipo_moneda', 'Soles')
        ->where('estado', 1)
        ->first();

    if (!$bancoBBVASoles) {
        return response()->json([
            'message' => 'El banco BBVA SOLES no está configurado o no está activo.'
        ], 400);
    }

    // Desactivar cualquier caja previa si existe
    if ($cajaActiva) {
        $cajaActiva->estado = 0;
        $cajaActiva->save();
    }

    // Crear una nueva caja chica
    $cajaChica = new CajaChica();
    $cajaChica->monto_inicial = $validated['monto_inicial'];
    $cajaChica->monto_actual = $validated['monto_inicial'];
    $cajaChica->monto_gastado = 0.00; // Inicializar con 0
    $cajaChica->encargado = $validated['responsable_id'];
    $cajaChica->banco_id = $bancoBBVASoles->id; // Asignar el banco BBVA SOLES automáticamente
    $cajaChica->descripcion = "Saldo inicial para el mes de " . date('F Y', strtotime($validated['mes']));
    $cajaChica->fecha_creacion = now();
    $cajaChica->estado = 1;
    $cajaChica->save();

    return response()->json([
        'message' => 'Saldo inicial creado exitosamente.',
        'saldo_inicial' => number_format($cajaChica->monto_inicial, 2),
        'saldo_gastado' => number_format($cajaChica->monto_gastado, 2),
        'saldo_final' => number_format($cajaChica->monto_actual, 2),
        'caja_id' => $cajaChica->id,
        'banco' => $bancoBBVASoles->nombre_banco, // Incluir el nombre del banco en la respuesta
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

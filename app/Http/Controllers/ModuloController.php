<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ModuloController extends Controller
{
    // Función para obtener los módulos en formato JSON
    public function obtenerModulos()
    {
        // Obtener los módulos ordenados por el campo 'orden'
        $modulos = Modulo::select('id', 'modulo as text', 'vista', 
            DB::raw("(CASE WHEN padre_id IS NULL OR padre_id = 0 THEN '#' ELSE padre_id END) AS parent"))
            ->orderBy('orden', 'asc')
            ->get();

        return response()->json($modulos);
    }
}

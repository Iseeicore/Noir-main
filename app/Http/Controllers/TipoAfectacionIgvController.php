<?php

namespace App\Http\Controllers;

use App\Models\TipoAfectacionIgv;
use Illuminate\Http\Request;

class TipoAfectacionIgvController extends Controller
{
    public function listarTipoAfectacionIgv()
    {
        $tipoAfectaciones = TipoAfectacionIgv::all();
        return response()->json($tipoAfectaciones);
    }
}

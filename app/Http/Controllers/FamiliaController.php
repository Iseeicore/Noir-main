<?php

namespace App\Http\Controllers;

use App\Models\Familia;
use Illuminate\Http\Request;

class FamiliaController extends Controller
{
    public function listarFamilias()
    {
        $familias = Familia::all();
        return response()->json($familias);
    }
}

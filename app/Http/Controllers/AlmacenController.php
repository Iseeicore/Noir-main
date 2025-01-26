<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AlmacenController extends Controller
{
    public function listarAlmacenes()
    {
        $almacenes = DB::table('almacen')->select('id', 'nomb_almacen')->get();
        return response()->json($almacenes);
    }
    public function listarAlmacenesReg()
    {
        $almacenes = Almacen::all();
        return response()->json($almacenes);
    }
}

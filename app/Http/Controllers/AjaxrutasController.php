<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
class AjaxrutasController extends Controller
{

    public function cargarContenido(Request $request)
    {
        // Obtener el nombre de la vista y el ID de paso desde la solicitud
        $nombreVista = $request->input('contenido') ?? session('vista_usuario');
        $id_de_paso = $request->input('id_de_paso');

        // Dividir el nombre de la vista en partes usando '/'
        $pathParts = explode('/', $nombreVista);
        $pathCount = count($pathParts);

        // Construir la ruta de la vista
        switch ($pathCount) {
            case 1: // Solo nombre de archivo en 'vistas'
                $rutaVista = 'vistas.' . $nombreVista;
                break;
            
            case 2: // Ruta con carpeta y archivo en 'vistas'
                $rutaVista = 'vistas.' . $pathParts[0] . '.' . $pathParts[1];
                break;
                
            case 3: // Subcarpeta y archivo
                $rutaVista = 'vistas.' . $pathParts[0] . '.' . $pathParts[1] . '.' . $pathParts[2];
                break;

            default:
                return response()->json(['error' => 'Vista no encontrada.'], 404);
        }

        // Verificar si la vista existe
        if (!View::exists($rutaVista)) {
            return response()->json(['error' => 'Vista no encontrada.'], 404);
        }

        // Enviar el ID a la vista de manera flexible
        return view($rutaVista, ['id_de_paso' => $id_de_paso])->render();
    }

}

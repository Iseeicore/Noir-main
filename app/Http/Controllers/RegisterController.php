<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Perfil;
use App\Models\Area;
use App\Models\Usuario; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class RegisterController extends Controller
{
//     public function obtenerUsuarios(Request $request)
// {
//     // Construir la consulta con join a la tabla area
//     // $query = Usuario::leftJoin('perfiles', 'usuarios.id_perfil_usuario', '=', 'perfiles.id_perfil')
//     //     ->leftJoin('area', 'usuarios.id_Area_usuario', '=', 'area.id_area') // Join con la tabla area
//     //     ->select([
//     //         'usuarios.id_usuario',
//     //         'usuarios.nomb_usuarios',
//     //         'usuarios.apellidos_usuarios',
//     //         'usuarios.usuario',
//     //         'usuarios.dni',
//     //         'perfiles.descripcion as perfil',
//     //         DB::raw('IFNULL(area.descripcion, "N/A") as area'), // Campo de área con "N/A" si es null
//     //         DB::raw('CASE WHEN usuarios.estado = 1 THEN "ACTIVO" ELSE "INACTIVO" END as estado')
//     //     ]);
//         $query = Usuario::leftJoin('perfiles', 'usuarios.id_perfil_usuario', '=', 'perfiles.id_perfil')
//         ->leftJoin('area', 'usuarios.id_Area_usuario', '=', 'area.id_area')
//         ->leftJoin('almacen', 'usuarios.id_almacen_usuario', '=', 'almacen.id') // Relación con almacén
//         ->select([
//             'usuarios.id_usuario',
//             'usuarios.nomb_usuarios',
//             'usuarios.apellidos_usuarios',
//             'usuarios.usuario',
//             'usuarios.dni',
//             'perfiles.descripcion as perfil',
//             DB::raw('IFNULL(area.descripcion, "N/A") as area'),
//             DB::raw('IFNULL(almacen.nomb_almacen, "N/A") as almacen'), // Nombre del almacén
//             'usuarios.id_almacen_usuario', // ID del almacén
//             DB::raw('CASE WHEN usuarios.estado = 1 THEN "ACTIVO" ELSE "INACTIVO" END as estado')
//         ]);

//     // Obtener los datos del request
//     $post = $request->all();

//     // Filtrar por búsqueda
//     if (isset($post['search']['value'])) {
//         $query->where(function ($q) use ($post) {
//             $q->where('usuarios.nomb_usuarios', 'like', '%' . $post['search']['value'] . '%')
//                 ->orWhere('usuarios.apellidos_usuarios', 'like', '%' . $post['search']['value'] . '%')
//                 ->orWhere('usuarios.usuario', 'like', '%' . $post['search']['value'] . '%')
//                 ->orWhere('perfiles.descripcion', 'like', '%' . $post['search']['value'] . '%')
//                 ->orWhere(DB::raw('IFNULL(area.descripcion, "N/A")'), 'like', '%' . $post['search']['value'] . '%') // Filtro para área con "N/A"
//                 ->orWhere(DB::raw('CASE WHEN usuarios.estado = 1 THEN "ACTIVO" ELSE "INACTIVO" END'), 'like', '%' . $post['search']['value'] . '%');
//         });
//     }

//     // Ordenar los resultados
//     if (isset($post['order'])) {
//         $columnIndex = $post['order'][0]['column'];
//         $columnDirection = $post['order'][0]['dir'];
//         $columns = ['id_usuario', 'nomb_usuarios', 'apellidos_usuarios', 'usuario', 'dni', 'perfil', 'area', 'estado']; // Columnas permitidas para ordenar
//         $query->orderBy($columns[$columnIndex], $columnDirection);
//     } else {
//         $query->orderBy('usuarios.id_usuario', 'desc');
//     }

//     // Paginación
//     $users = $query->skip($post['start'])->take($post['length'])->get();

//     // Contar todos los registros sin filtros
//     $count_all_data = Usuario::count();
//     // Contar los registros filtrados
//     $number_filter_row = $query->count();

//     // Preparar los datos para la respuesta
//     $data = [];
//     foreach ($users as $user) {
//         $data[] = [
//             '', // Detalles
//             '', // Opciones
//             $user->id_usuario,
//             $user->nomb_usuarios,
//             $user->apellidos_usuarios,
//             $user->usuario,
//             $user->dni,
//             $user->perfil,
//             $user->area,
//             $user->almacen, // Nombre del almacén
//             $user->id_almacen_usuario, // ID del almacén
//             $user->estado
//         ];
//     }
//     // $data = [];
//     // foreach ($users as $user) {
//     //     $data[] = [
//     //         '', // Espacio para detalles (columna 0)
//     //         '', // Espacio para opciones (columna 1)
//     //         $user->id_usuario,
//     //         $user->nomb_usuarios,
//     //         $user->apellidos_usuarios,
//     //         $user->usuario,
//     //         $user->dni,
//     //         $user->perfil,
//     //         $user->area, // Mostrar la descripción del área (o "N/A" si es null)
//     //         $user->estado
//     //     ];
//     // }

//     return response()->json([
//         'draw' => $post['draw'],
//         'recordsTotal' => $count_all_data,
//         'recordsFiltered' => $number_filter_row,
//         'data' => $data
//     ]);
// }

public function obtenerUsuarios(Request $request)
{
    $query = Usuario::leftJoin('perfiles', 'usuarios.id_perfil_usuario', '=', 'perfiles.id_perfil')
        ->leftJoin('area', 'usuarios.id_Area_usuario', '=', 'area.id_area')
        ->leftJoin('almacen', 'usuarios.id_almacen_usuario', '=', 'almacen.id')
        ->select([
            'usuarios.id_usuario',
            'usuarios.nomb_usuarios',
            'usuarios.apellidos_usuarios',
            'usuarios.usuario',
            'usuarios.dni',
            'perfiles.descripcion as perfil',
            DB::raw('IFNULL(area.descripcion, "N/A") as area'),
            DB::raw('IFNULL(almacen.nomb_almacen, "N/A") as almacen'),
            DB::raw('CASE WHEN usuarios.estado = 1 THEN "ACTIVO" ELSE "INACTIVO" END as estado')
        ]);

    $post = $request->all();

    if (isset($post['search']['value'])) {
        $query->where(function ($q) use ($post) {
            $q->where('usuarios.nomb_usuarios', 'like', '%' . $post['search']['value'] . '%')
                ->orWhere('usuarios.apellidos_usuarios', 'like', '%' . $post['search']['value'] . '%')
                ->orWhere('usuarios.usuario', 'like', '%' . $post['search']['value'] . '%')
                ->orWhere('perfiles.descripcion', 'like', '%' . $post['search']['value'] . '%')
                ->orWhere(DB::raw('IFNULL(area.descripcion, "N/A")'), 'like', '%' . $post['search']['value'] . '%')
                ->orWhere(DB::raw('IFNULL(almacen.nomb_almacen, "N/A")'), 'like', '%' . $post['search']['value'] . '%')
                ->orWhere(DB::raw('CASE WHEN usuarios.estado = 1 THEN "ACTIVO" ELSE "INACTIVO" END'), 'like', '%' . $post['search']['value'] . '%');
        });
    }

    if (isset($post['order'])) {
        $columnIndex = $post['order'][0]['column'];
        $columnDirection = $post['order'][0]['dir'];
        $columns = ['id_usuario', 'nomb_usuarios', 'apellidos_usuarios', 'usuario', 'dni', 'perfil', 'area', 'almacen', 'estado'];
        $query->orderBy($columns[$columnIndex], $columnDirection);
    } else {
        $query->orderBy('usuarios.id_usuario', 'desc');
    }

    $users = $query->skip($post['start'])->take($post['length'])->get();

    $count_all_data = Usuario::count();
    $number_filter_row = $query->count();

    $data = [];
    foreach ($users as $user) {
        $data[] = [
            '', // Detalles
            '', // Opciones
            $user->id_usuario,
            $user->nomb_usuarios,
            $user->apellidos_usuarios,
            $user->usuario,
            $user->dni,
            $user->perfil,
            $user->area,
            $user->almacen,
            $user->estado
        ];
    }

    return response()->json([
        'draw' => $post['draw'],
        'recordsTotal' => $count_all_data,
        'recordsFiltered' => $number_filter_row,
        'data' => $data
    ]);
}



    public function listarPerfiles()
    {
        $perfiles = Perfil::all(); // Asegúrate de que tu modelo se llama Perfil y tiene los datos correctos
        return response()->json($perfiles);
    }

    public function listarAreas()
    {
        $areas = Area::all(); // Asegúrate de que tu modelo se llama 'Area' y tiene los datos correctos
        return response()->json($areas);
    }

    public function listarAlmacenesRegister()
    {
        $almacen = Almacen::all(); // Asegúrate de que tu modelo se llama 'Area' y tiene los datos correctos
        return response()->json($almacen);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => 'required|digits:8',
            'usuario' => 'required|string|max:255|unique:usuarios,usuario',
            'password' => 'required|string|min:6',
            'perfil' => 'required|exists:perfiles,id_perfil',
            'id_Area_usuario' => 'required|exists:area,id_area',
            'id_almacen_usuario' => 'required|exists:almacen,id',
            'estado' => 'required|boolean',
        ]);

        try {
            $user = new Usuario();
            $user->nomb_usuarios = $validatedData['nombres'];
            $user->apellidos_usuarios = $validatedData['apellidos'];
            $user->dni = $validatedData['dni'];
            $user->usuario = $validatedData['usuario'];
            $user->clave = bcrypt($validatedData['password']); // Encripta la contraseña
            $user->id_perfil_usuario = $validatedData['perfil'];
            $user->id_Area_usuario = $validatedData['id_Area_usuario'];
            $user->id_almacen_usuario = $validatedData['id_almacen_usuario'];
            $user->estado = $validatedData['estado'];
            $user->save();

            return response()->json([
                'tipo_msj' => 'success',
                'msj' => 'Usuario registrado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'tipo_msj' => 'error',
                'msj' => 'Error al registrar el usuario: ' . $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => 'required|digits:8',
            'usuario' => 'required|string|max:255|unique:usuarios,usuario,' . $id . ',id_usuario',
            'perfil' => 'required|exists:perfiles,id_perfil',
            'id_Area_usuario' => 'required|exists:area,id_area',
            'id_almacen_usuario' => 'required|exists:almacen,id',
            'estado' => 'required|boolean',
        ]);
    
        try {
            $user = Usuario::findOrFail($id); // Encuentra el usuario por su ID
            $user->nomb_usuarios = $validatedData['nombres'];
            $user->apellidos_usuarios = $validatedData['apellidos'];
            $user->dni = $validatedData['dni'];
            $user->usuario = $validatedData['usuario'];
            $user->id_perfil_usuario = $validatedData['perfil'];
            $user->id_Area_usuario = $validatedData['id_Area_usuario'];
            $user->id_almacen_usuario = $validatedData['id_almacen_usuario'];
            $user->estado = $validatedData['estado'];
    
            // Si se ingresa la contraseña, actualízala
            if ($request->filled('password')) {
                $user->clave = bcrypt($request->input('password'));
            }
    
            $user->save();
    
            return response()->json([
                'tipo_msj' => 'success',
                'msj' => 'Usuario actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'tipo_msj' => 'error',
                'msj' => 'Error al actualizar el usuario: ' . $e->getMessage()
            ]);
        }
    }
    


}

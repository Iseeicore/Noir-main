<?php

namespace App\Http\Controllers;

use App\Models\PerfilModulo;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
class SeguridadController extends Controller
{
    public function LoginValidacion(){
        return view("vistas.login");
    }

    
    public function login(Request $request)
    {
        // Validación de entrada
        $request->validate([
            'usuario' => 'required|string',
            'clave' => 'required|string',
        ]);
    
        $usuario = $request->input('usuario');
        $clave = trim($request->input('clave'));
    
        // Buscar usuario por nombre de usuario utilizando el modelo Usuario
        $user = Usuario::where('usuario', $usuario)->first();
    
        // Verificar la contraseña
        if ($user && Hash::check($clave, $user->clave)) {
            Log::info('Contraseña verificada correctamente');
    
            // Ahora obtenemos el id_perfil_usuario y buscamos la vista predeterminada
            $vista = PerfilModulo::where('id_perfil', $user->id_perfil_usuario)
                ->where('vista_inicio', 1)
                ->join('modulos', 'perfil_modulo.id_modulo', '=', 'modulos.id')
                ->value('modulos.vista');
    
            // Verificar si la vista fue obtenida correctamente
            if (!$vista) {
                return response()->json([
                    'tipo_msj' => 'error',
                    'msj' => 'No se encontró una vista predeterminada para el usuario.',
                ]);
            }
    
            // Guardar en la sesión la vista predeterminada del usuario
            session(['vista_usuario' => $vista]);
    
            // Iniciar sesión
            Auth::login($user);
    
            // Redirigir a la raíz para que cargue la vista almacenada
            return response()->json([
                'tipo_msj' => 'success',
                'msj' => 'Usuario autenticado',
                'redirect_url' => url('/'),
            ]);
        } else {
            Log::info('La verificación de la contraseña falló');
            return response()->json([
                'tipo_msj' => 'error',
                'msj' => 'El usuario y/o contraseña son inválidos',
            ]);
        }
    }
    
    public function logout(Request $request)
    {
        // Destruir la sesión del usuario actual
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->flush(); // Limpiar todas las sesiones activas
        // Redirigir a la página de Login
        return redirect()->route('login_validacion');
    }

    public function obtenerMenu()
    {
        $usuario = Auth::user(); // Obtener el usuario autenticado

        // Obtener los módulos principales (menús principales)
        $menuUsuario = PerfilModulo::where('id_perfil', $usuario->id_perfil_usuario)
            ->join('modulos', 'perfil_modulo.id_modulo', '=', 'modulos.id')
            ->where(function ($query) {
                $query->whereNull('modulos.padre_id')
                    ->orWhere('modulos.padre_id', 0);
            })
            ->select('modulos.id', 'modulos.modulo', 'modulos.icon_menu', 'modulos.vista', 'perfil_modulo.vista_inicio',
                DB::raw("(SELECT COUNT(1) 
                            FROM modulos m1 
                            WHERE m1.padre_id = modulos.id
                            AND EXISTS (
                                SELECT 1 
                                FROM perfil_modulo pm1
                                WHERE pm1.id_modulo = m1.id 
                                AND pm1.vista_inicio = 1
                                AND pm1.id_perfil = {$usuario->id_perfil_usuario}
                            )) as abrir_arbol")
            )
            ->orderBy('modulos.orden', 'ASC')
            ->get();

        return $menuUsuario; // Devolver los menús
    }

    public function obtenerSubMenu($idMenu)
    {
        $usuario = Auth::user(); // Obtener el usuario autenticado

        // Obtener los submódulos
        $subMenuUsuario = PerfilModulo::where('id_perfil', $usuario->id_perfil_usuario)
            ->join('modulos', 'perfil_modulo.id_modulo', '=', 'modulos.id')
            ->where('modulos.padre_id', $idMenu) // Submódulos de un módulo
            ->select('modulos.id', 'modulos.modulo', 'modulos.icon_menu', 'modulos.vista', 'perfil_modulo.vista_inicio')
            ->orderBy('modulos.orden', 'ASC')
            ->get();

        return $subMenuUsuario;
    }
    

    public function buscarUsuarioDinamico(Request $request)
    {
        $term = $request->input('term'); // Obtener el término de búsqueda
        $usuario = Usuario::where('usuario', $term)->select('id_usuario', 'usuario')->first();
    
        if (!$usuario) {
            return response()->json(['found' => false, 'message' => 'Usuario no encontrado']);
        }
    
        return response()->json(['found' => true, 'message' => 'Usuario localizado', 'data' => $usuario]);
    }
    

    public function actualizarPassword(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|exists:usuarios,usuario',
            'password' => 'required|string|min:6|same:confirmar_password',
            'confirmar_password' => 'required|string|min:6',
        ]);

        $usuario = Usuario::where('usuario', $request->input('usuario'))->first();

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado',
            ], 404);
        }

        $usuario->clave = Hash::make($request->input('password'));
        $usuario->save();

        return response()->json([
            'success' => true,
            'message' => 'Contraseña actualizada correctamente',
        ]);
    }
}

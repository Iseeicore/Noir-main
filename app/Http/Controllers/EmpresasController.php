<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Empresas;
use Illuminate\Support\Facades\Storage;

class EmpresasController extends Controller
{
    public function guardarEmpresa(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validar los datos de entrada
            $request->validate([
                'ruc' => 'required|string|max:20',
                'razon_social' => 'required|string|max:255',
                'direccion' => 'required|string|max:255',
                'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
            ]);

            // Validar y procesar la imagen
            $nombreImagen = 'no_image.jpg'; // Valor por defecto
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = uniqid() . '_' . rand(100, 999) . '.' . $imagen->getClientOriginalExtension();
                $rutaImagen = 'assets/imagenes/empresas/' . $nombreImagen;
                $imagen->storeAs('public/' . $rutaImagen);
            }

            // Crear el registro en la tabla `empresas`
            $empresa = new Empresas();
            $empresa->ruc = $request->input('ruc');
            $empresa->razon_social = strtoupper($request->input('razon_social'));
            $empresa->direccion = $request->input('direccion');
            $empresa->logo = $nombreImagen; // Guardar el nombre de la imagen en la base de datos
            $empresa->save();

            DB::commit();

            return response()->json(['tipo_msj' => 'success', 'msj' => 'Empresa registrada correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['tipo_msj' => 'error', 'msj' => 'Error al registrar la empresa: ' . $e->getMessage()]);
        }
    }
    public function listarEmpresas()
    {
        $empresas = Empresas::select('id_empresa', 'razon_social', 'direccion', 'logo')->get();
        return response()->json($empresas);
    }

    public function obtenerEmpresa($id)
    {
        $empresa = Empresas::find($id);
    
        if (!$empresa) {
            return response()->json([
                'tipo_msj' => 'error',
                'msj' => 'Empresa no encontrada'
            ]);
        }
    
        return response()->json([
            'tipo_msj' => 'success',
            'data' => $empresa
        ]);
    }
    
    public function actualizarEmpresa(Request $request, $id)
    {
        $request->validate([
            'ruc' => 'required|string',
            'razon_social' => 'required|string',
            'direccion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);
    
        DB::beginTransaction();
    
        try {
            // Buscar la empresa por ID
            $empresa = Empresas::find($id);
    
            if (!$empresa) {
                return response()->json([
                    'tipo_msj' => 'error',
                    'msj' => 'Empresa no encontrada'
                ]);
            }
    
            // Manejar la imagen: guardar una nueva y eliminar la antigua si existe
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = uniqid() . '_' . rand(100, 999) . '.' . $imagen->getClientOriginalExtension();
                $rutaImagen = 'assets/imagenes/empresas/' . $nombreImagen;
    
                // Guardar la imagen en almacenamiento
                $imagen->storeAs('public/' . $rutaImagen);
    
                // Eliminar la imagen anterior si existía
                if ($empresa->logo && $empresa->logo != 'no_image.jpg') {
                    Storage::delete('public/assets/imagenes/empresas/' . $empresa->logo);
                }
    
                $empresa->logo = $nombreImagen;
            }
    
            // Actualizar los datos de la empresa
            $empresa->ruc = $request->input('ruc');
            $empresa->razon_social = strtoupper($request->input('razon_social'));
            $empresa->direccion = $request->input('direccion');
    
            $empresa->save();
    
            // Confirmar transacción
            DB::commit();
    
            return response()->json([
                'tipo_msj' => 'success',
                'msj' => 'Empresa actualizada correctamente'
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'tipo_msj' => 'error',
                'msj' => 'Error al actualizar la empresa: ' . $e->getMessage()
            ]);
        }
    }

    public function eliminarEmpresa($id)
    {
        DB::beginTransaction();

        try {
            $empresa = Empresas::find($id);

            if (!$empresa) {
                return response()->json([
                    'tipo_msj' => 'error',
                    'msj' => 'Empresa no encontrada'
                ]);
            }

            // Guardar el nombre de la empresa antes de eliminarla
            $nombreEmpresa = $empresa->razon_social;

            // Eliminar la imagen si existe y no es la imagen predeterminada
            if ($empresa->logo && $empresa->logo != 'no_image.jpg') {
                Storage::delete('public/assets/imagenes/empresas/' . $empresa->logo);
            }

            // Eliminar la empresa
            $empresa->delete();

            DB::commit();

            return response()->json([
                'tipo_msj' => 'success',
                'msj' => 'Empresa eliminada correctamente',
                'nombre_empresa' => $nombreEmpresa
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'tipo_msj' => 'error',
                'msj' => 'Error al eliminar la empresa: ' . $e->getMessage()
            ]);
        }
    }

    public function obtenerEmpresaSeleccionada()
    {
        $empresa = Empresas::where('id_empresa', session('empresa_id'))->first();
    
        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'Empresa no encontrada'
            ]);
        }
    
        return response()->json([
            'success' => true,
            'data' => [
                'logo' => asset('storage/assets/imagenes/empresas/' . ($empresa->logo ?? 'no_image.jpg')),
                'nombre_comercial' => $empresa->nombre_comercial ?? 'SIN REGISTRAR'
            ]
        ]);
    }
    

    

}

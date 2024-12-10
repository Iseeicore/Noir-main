<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\ProductoModeloreq;
use Illuminate\Support\Facades\Storage;
class ProductoModeloreqController extends Controller
{
    public function listarProductos()
    {
        $productos = DB::select('CALL prc_ListarProductosModelosreq()');
        return response()->json($productos);
    }
    public function generarCodigoProducto(Request $request)
    {
        // Captura el ID de la categoría desde la solicitud y verifica que esté presente
        $idCategoria = $request->input('id_categoria');
        Log::info('ID de categoría recibido: ' . $idCategoria);

        if (!$idCategoria) {
            Log::error("ID de categoría no recibido.");
            return response()->json(['error' => 'Categoría no seleccionada'], 400);
        }

        // Buscar el último código de producto en la categoría seleccionada
        $ultimoCodigo = DB::table('producto_sin_ubicacion')
            ->where('categoria', $idCategoria)
            ->select('cod_registro')
            ->orderByDesc('id')
            ->first();

        // Generar nuevo código dependiendo si hay registros previos o no
        if ($ultimoCodigo && isset($ultimoCodigo->cod_registro)) {
            // Si existe un último código, extraer la parte numérica y sumar uno
            $numero = (int) substr($ultimoCodigo->cod_registro, strlen($idCategoria));
            $nuevoNumero = str_pad($numero + 1, 4, '0', STR_PAD_LEFT);
            $nuevoCodigo = $idCategoria . $nuevoNumero;
            Log::info("Código generado por incremento: $nuevoCodigo");
        } else {
            // Si no hay registros previos, comienza con `idCategoria + 0001`
            $nuevoCodigo = $idCategoria . '0001';
            Log::info("Código generado por ausencia de registros previos: $nuevoCodigo");
        }

        // Retornar el código generado
        return response()->json(['nuevo_codigo' => $nuevoCodigo]);
    }

    public function registrarProductoModelo(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validar y procesar la imagen
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = uniqid() . '_' . rand(100, 999) . '.' . $imagen->getClientOriginalExtension();
                $rutaImagen = 'assets/imagenes/productos/' . $nombreImagen;
                $imagen->storeAs('public/' . $rutaImagen);
            } else {
                $nombreImagen = 'no_image.jpg';
            }

            // Crear el registro en la tabla `producto_sin_ubicacion`
            $producto = new ProductoModeloreq();
            $producto->cod_registro = $request->input('codigo_productos');
            $producto->categoria = $request->input('id_categoria');
            $producto->descripcion = strtoupper($request->input('descripcion'));
            $producto->unidad_medida = $request->input('id_unidad_medida');
            $producto->imagen = $nombreImagen;
            $producto->minimo_stock = $request->input('minimo_stock');
            $producto->estado = 1; // Estado activo por defecto
            $producto->save();

            DB::commit();

            return response()->json(['tipo_msj' => 'success', 'msj' => 'Producto registrado correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al registrar producto: " . $e->getMessage());
            return response()->json(['tipo_msj' => 'error', 'msj' => 'Error al registrar el producto: ' . $e->getMessage()]);
        }
    }

    public function obtenerProducto($id) {
        $productomodeloreq = ProductoModeloreq::find($id); // Asegúrate de tener definida la relación tipoAfectacion en el modelo Producto
    
        if ($productomodeloreq) {
            return response()->json([
                'codigo_productos' => $productomodeloreq->cod_registro,
                'id_categorias' => $productomodeloreq->categoria,
                'descripcion' => $productomodeloreq->descripcion,
                'id_unidad_medida' => $productomodeloreq->unidad_medida,
                'minimo_stock' => $productomodeloreq->minimo_stock,
                'imagen' => $productomodeloreq->imagen
            ]);
        }
    
        return response()->json(['error' => 'Producto no encontrado'], 404);
    }
    public function actualizarProductoModeloreq(Request $request)
{
    $request->validate([
        'codigo_productos' => 'required|string',
        'id_categoria' => 'required',
        'descripcion' => 'required|string',
        'id_unidad_medida' => 'required',
        'minimo_stock' => 'required|numeric',
        'imagen' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
    ]);

    DB::beginTransaction();

    try {
        // Buscar el producto por código
        $codigoProducto = $request->input('codigo_productos');
        $producto = ProductoModeloreq::where('cod_registro', $codigoProducto)->first();

        if (!$producto) {
            return response()->json([
                'tipo_msj' => 'error',
                'msj' => 'Producto no encontrado'
            ]);
        }

        // Manejar la imagen: guardar una nueva y eliminar la antigua si existe
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = uniqid() . '_' . rand(100, 999) . '.' . $imagen->getClientOriginalExtension();
            $rutaImagen = 'assets/imagenes/productos/' . $nombreImagen;

            // Guardar la imagen en almacenamiento
            $imagen->storeAs('public/' . $rutaImagen);

            // Eliminar la imagen anterior si existía
            if ($producto->imagen && $producto->imagen != 'no_image.jpg') {
                Storage::delete('public/assets/imagenes/productos/' . $producto->imagen);
            }

            $producto->imagen = $nombreImagen;
        }

        // Actualizar los datos del producto
        $producto->categoria = $request->input('id_categoria');
        $producto->descripcion = strtoupper($request->input('descripcion'));
        $producto->unidad_medida = $request->input('id_unidad_medida');
        $producto->minimo_stock = $request->input('minimo_stock');

        $producto->save();

        // Confirmar transacción
        DB::commit();

        return response()->json([
            'tipo_msj' => 'success',
            'msj' => 'Producto actualizado correctamente'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'tipo_msj' => 'error',
            'msj' => 'Error al actualizar el producto: ' . $e->getMessage()
        ]);
    }
}
public function desactivarProductomodelo($id)
{
    $producto = ProductoModeloreq::find($id);
    if ($producto) {
        $producto->estado = 0;
        $producto->save();

        return response()->json(['tipo_msj' => 'success', 'msj' => 'Producto desactivado exitosamente.']);
    }

    return response()->json(['tipo_msj' => 'error', 'msj' => 'Producto no encontrado.'], 404);
}

public function activarProductomodelo($id)
{
    $producto = ProductoModeloreq::find($id);
    if ($producto) {
        $producto->estado = 1;
        $producto->save();

        return response()->json(['tipo_msj' => 'success', 'msj' => 'Producto activado exitosamente.']);
    }

    return response()->json(['tipo_msj' => 'error', 'msj' => 'Producto no encontrado.'], 404);
}


}

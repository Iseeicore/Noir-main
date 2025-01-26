<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\ComprobantePago;
use App\Models\DocumentoIngresoHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TipoAfectacionIgv;
use App\Models\Producto;
use App\Models\ProductoModeloreq;
use App\Models\Proveedor;
use App\Models\TipoCambio;
use App\Models\TipoOperacion;
use Illuminate\Support\Facades\DB;
use App\Models\CentroCosto;
use App\Models\DocumentoIngresoBody;

class DocumentoIngresoController extends Controller
{
    
    public function listarDocumentos(Request $request)
    {
        $columnas = [
            "documento_ingreso_head.id",
            "fecha_emision",
            "periodo",
            "tipo_operaciones.descripcion",
            "almacen.nomb_almacen",
            "Total_efectivo_Compelto",
            "usuarios.nomb_usuarios"
        ];

        $usuario_id = $request->usuario_id;

        $query = DocumentoIngresoHead::select(
            'documento_ingreso_head.id',
            'documento_ingreso_head.fecha_emision',
            'documento_ingreso_head.periodo',
            'tipo_operaciones.descripcion as tipo_operacion',
            'proveedores.razon_social as proveedor',
            'almacen.nomb_almacen as almacen',
            'comprobante_pago.descripcion as comprobante_pago',
            'tipo_cambio.moneda_origen as moneda_origen',
            'tipo_cambio.moneda_destino as moneda_destino',
            'tipo_cambio.tipo_cambio_venta as tipo_cambio',
            'documento_ingreso_head.Total_efectivo_Compelto',
            'usuarios.nomb_usuarios as usuario'
        )
        ->leftJoin('tipo_operaciones', 'documento_ingreso_head.tipo_operacion', '=', 'tipo_operaciones.id')
        ->leftJoin('proveedores', 'documento_ingreso_head.proveedor', '=', 'proveedores.id')
        ->leftJoin('almacen', 'documento_ingreso_head.almacen', '=', 'almacen.id')
        ->leftJoin('comprobante_pago', 'documento_ingreso_head.comprobante_pago', '=', 'comprobante_pago.id')
        ->leftJoin('tipo_cambio', 'documento_ingreso_head.tipo_cambio', '=', 'tipo_cambio.id')
        ->leftJoin('usuarios', 'documento_ingreso_head.UsuarioCreacion', '=', 'usuarios.id_usuario')
        ->where('documento_ingreso_head.UsuarioCreacion', $usuario_id)
        ->orderBy('documento_ingreso_head.id', 'desc'); // Ordenar de manera descendente


        if ($request->search['value']) {
            $search = $request->search['value'];
            $query->where(function ($query) use ($search) {
                $query->where('documento_ingreso_head.fecha_emision', 'like', "%{$search}%")
                    ->orWhere('tipo_operaciones.descripcion', 'like', "%{$search}%")
                    ->orWhere('proveedores.razon_social', 'like', "%{$search}%")
                    ->orWhere('almacen.nomb_almacen', 'like', "%{$search}%")
                    ->orWhere('comprobante_pago.descripcion', 'like', "%{$search}%");
            });
        }

        $total_count = DocumentoIngresoHead::count();
        $filtered_count = $query->count();

        if ($request->length != -1) {
            $query->skip($request->start)->take($request->length);
        }

        if ($request->order) {
            $order_column = $columnas[$request->order[0]['column']];
            $order_dir = $request->order[0]['dir'];
            $query->orderBy($order_column, $order_dir);
        }

        $data = $query->get()->map(function ($row) {
            return [
                'opciones' => '',
                'id' => $row->id,
                'fecha_emision' => $row->fecha_emision,
                'periodo' => $row->periodo,
                'tipo_operacion' => $row->tipo_operacion,
                'proveedor' => $row->proveedor,
                'almacen' => $row->almacen,
                'comprobante_pago' => $row->comprobante_pago,
                'moneda_origen' => $row->moneda_origen,
                'moneda_destino' => $row->moneda_destino,
                'tipo_cambio' => $row->tipo_cambio,
                'total_efectivo' => $row->Total_efectivo_Compelto,
                'usuario' => $row->usuario,
            ];
        });

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $total_count,
            'recordsFiltered' => $filtered_count,
            'data' => $data
        ];

        return response()->json($output);
    }

    public function cargarTipoAfectacionIgv()
    {
            $tipoAfectaciones = TipoAfectacionIgv::all();
            return response()->json(['tipo_afectacion' => $tipoAfectaciones]);
    }

    public function cargarProductosinubicacion()
    {
        $ProductoSinUbicacion = ProductoModeloreq::with('unidadMedida:id,nomb_uniMed')->get();
        return response()->json(['ProductoSinUbicacion' => $ProductoSinUbicacion]);
    }
    public function generarCodigoDocumento()
{
    // Obtener el último `codigo_head` de la tabla `documento_ingreso_head`
    $ultimoCodigo = DB::table('documento_ingreso_head')
                      ->select('codigo_head')
                      ->orderByDesc('id') // Ordenar por `id` de forma descendente
                      ->limit(1)
                      ->value('codigo_head');

    if ($ultimoCodigo) {
        // Extraer la parte numérica del código y convertirla a entero
        $numero = (int) substr($ultimoCodigo, 6);

        // Generar el nuevo número incrementado y formatearlo con 6 dígitos
        $nuevoNumero = str_pad($numero + 1, 6, '0', STR_PAD_LEFT);
        $nuevoCodigo = "DOCING" . $nuevoNumero;
    } else {
        // Si no existe ningún registro, empezar con `DOCING000001`
        $nuevoCodigo = "DOCING000001";
    }

    return response()->json(['nuevo_codigo' => $nuevoCodigo]);
}

public function cambioDeTipoOperacionesEntrada()
{
    $tipoOperaciones = TipoOperacion::all();

    return response()->json(['tipo_operaciones' => $tipoOperaciones]);

}






public function cargarProveedores()
{
        $Proveedores = Proveedor::all();
        return response()->json(['proveedor' => $Proveedores]);
}

public function cargarAlmacenes()
{
    // Obtener el usuario actual
    $usuario = auth()->user();

    // Verificar si el usuario tiene un almacén asignado
    $almacen = Almacen::find($usuario->id_almacen_usuario);

    // Retornar la información del almacén
    if ($almacen) {
        return response()->json([
            'almacen' => [
                'id' => $almacen->id,
                'nombre' => $almacen->nomb_almacen
            ]
        ]);
    } else {
        return response()->json([
            'almacen' => null,
            'mensaje' => 'El usuario no tiene un almacén asignado.'
        ]);
    }
}


public function cargarComprobantePago()
{
    $comprobantePago = ComprobantePago::all();
    return response()->json(['comprobante_pago' => $comprobantePago]);
}


public function cargarTipoCambioPorFecha(Request $request)
{
    $fecha = $request->input('fecha'); // Fecha proporcionada desde el formulario
    $moneda = $request->input('moneda'); // Moneda seleccionada (USD o PEN)

    // Validar que la fecha no esté vacía
    if (!$fecha) {
        return response()->json([
            'success' => false,
            'message' => 'La fecha es requerida.',
        ], 400);
    }

    // Buscar el tipo de cambio en la base de datos para la fecha proporcionada
    $tipoCambio = TipoCambio::where('fecha', $fecha)
        ->where('moneda_origen', $moneda === 'PEN' ? 'USD' : $moneda)
        ->where('moneda_destino', 'PEN')
        ->first();

    if ($tipoCambio) {
        // Si se encuentra el tipo de cambio, devolver los datos
        return response()->json([
            'success' => true,
            'id' => $tipoCambio->id,
            'tipo_cambio_compra' => $tipoCambio->tipo_cambio_compra,
            'tipo_cambio_venta' => $tipoCambio->tipo_cambio_venta,
        ]);
    } else {
        // Si no se encuentra el tipo de cambio, devolver un mensaje de error
        return response()->json([
            'success' => false,
            'message' => 'No se encontró un tipo de cambio para la fecha seleccionada.',
        ], 404);
    }
}


public function store(Request $request)
{
    DB::beginTransaction();

    try {
        // 1. Registrar el documento head
        $headData = [
            'codigo_head' => $request->codigo_documento_ingreso,
            'fecha_emision' => $request->fecha_emision,
            'fecha_contable' => $request->fecha_contable,
            'periodo' => $request->periodo,
            'tipo_operacion' => $request->tipo_operacion,
            'proveedor' => $request->proveedor,
            'almacen' => $request->almacen,
            'comprobante_pago' => $request->comprobante_pago,
            'tipo_cambio' => $request->tipo_cambio,
            'numerodocumento' => $request->numerodocumento,
            'numerosecundariodocumento' => $request->numerosecundariodocumento,
            'glosario' => $request->glosario,
            'Total_efectivo_Compelto' => $request->total_efectivo,
            'UsuarioCreacion' => $request->Usuario_creado,
            'nomb_moneda' => $request->nomb_moneda,
            'registro_cambio_al_dia' => $request->registro_cambio_al_dia,
        ];

        $documentoIngresoHead = DocumentoIngresoHead::create($headData);

         // Guardar el código del documento en $comprobante
        $comprobante = $documentoIngresoHead->codigo_head;

        // Obtener el ID del almacén destino
        $almacenDestinoNombre = 'Ninguno';
        $p_almacenDestino = Almacen::whereRaw('LOWER(nomb_almacen) = ?', [strtolower($almacenDestinoNombre)])
            ->value('id');

        // 2. Registrar el documento body y actualizar/registrar productos
        foreach ($request->productos as $producto) {
            // Validar producto en ProductoModeloreq
            $productoModelo = ProductoModeloreq::with('unidadMedida')
                ->where('id', $producto['producto'])
                ->first();

            if (!$productoModelo) {
                throw new \Exception("El producto con ID {$producto['producto']} no existe en la tabla producto_sin_ubicacion.");
            }

            // Validar unidad de medida
            if ($productoModelo->unidadMedida->id !== $producto['unidadMedidaId']) {
                throw new \Exception("La unidad de medida para el producto con ID {$producto['producto']} no coincide con la registrada.");
            }

            // Registrar en DocumentoIngresoBody
            $bodyData = [
                'documento_ingreso_head_id' => $documentoIngresoHead->id,
                'producto' => $productoModelo->id,
                'cantidad' => $producto['cantidad'],
                'centro_costos' => $producto['centro_costo'],
                'tipo_afectacion' => $producto['tipo_afectacion'],
                'precio_unitario' => $producto['precio_unitario'],
                'total' => $producto['total'],
            ];

            DocumentoIngresoBody::create($bodyData);

            // Obtener producto existente
            $productoExistente = Producto::where('codigo_productos', $productoModelo->cod_registro)
                ->where('id_almacen', $request->almacen)
                ->first();

            // Usar switch para manejar los casos
            switch (true) {
                case $productoExistente !== null:
                    // Producto existente: actualizar
                    $nuevoStock = $productoExistente->stock + $producto['cantidad'];
                    $nuevoCostoTotal = $productoExistente->costo_total + $producto['total'];
                    $nuevoCostoUnitario = $nuevoCostoTotal / $nuevoStock;

                    $productoExistente->update([
                        'stock' => $nuevoStock,
                        'costo_total' => $nuevoCostoTotal,
                        'costo_unitario' => round($nuevoCostoUnitario, 2),
                    ]);

                    // Concepto basado en tipo_operacion
                    $concepto = TipoOperacion::where('id', $request->tipo_operacion)
                    ->selectRaw("CONCAT('Actualizar ', descripcion, ' ', tipo) AS concepto")
                    ->value('concepto');
                
                     // Registrar en el kardex
                    $descripcionCentroCosto = CentroCosto::where('id', $producto['centro_costo'])
                    ->value('nomb_centroCos');

                    DB::statement('CALL prc_actualizar_kardex_producto_existencia(?,?,?,?,?,?,?,?,?,?,?)', [
                        $productoExistente->id,
                        $productoExistente->codigo_productos,
                        $request->almacen,
                        $p_almacenDestino,
                        $concepto,
                        $comprobante,
                        $producto['centro_costo'],
                        $descripcionCentroCosto,
                        $producto['cantidad'],
                        $producto['precio_unitario'],
                        $producto['total'],
                    ]);
                



                    break;

                case $productoExistente === null:
                    // Producto no existente: registrar
                    $nuevoProducto = Producto::create([
                        'codigo_productos' => $productoModelo->cod_registro,
                        'id_categorias' => $productoModelo->categoria,
                        'id_almacen' => $request->almacen,
                        'descripcion' => $productoModelo->descripcion,
                        'id_tipo_afectacion_igv' => $producto['tipo_afectacion'],
                        'id_unidad_medida' => $productoModelo->unidad_medida,
                        'costo_unitario' => $producto['precio_unitario'],
                        'precio_unitario_sin_igv' => 0,
                        'precio_unitario_con_igv' => 0,
                        'stock' => $producto['cantidad'],
                        'minimo_stock' => $productoModelo->minimo_stock,
                        'costo_total' => $producto['total'],
                        'imagen' => $productoModelo->imagen,
                        'estado' => $productoModelo->estado,
                    ]);

                    // Registro en el Kardex
                    $concepto = 'Saldo Inicial Registro Doc Ingreso';

                    // Obtener el nombre del centro de costo
                    $descripcionCentroCosto = CentroCosto::where('id', $producto['centro_costo'])
                        ->value('nomb_centroCos');

                        DB::statement('CALL prc_registrar_kardex_producto_existencia(?,?,?,?,?,?,?,?,?,?,?)', [
                            $nuevoProducto->id,                  // p_id_producto
                            $nuevoProducto->codigo_productos,    // p_codigo_producto
                            $request->almacen,                   // p_almacen
                            $p_almacenDestino,                   // p_almacenDestino
                            $concepto,                           // p_concepto
                            $comprobante,                        // p_comprobante
                            $producto['centro_costo'],           // p_centro_costo
                            $descripcionCentroCosto,             // p_descripcion_centro_costo
                            $producto['cantidad'],               // p_unidades
                            $producto['precio_unitario'],        // p_costo_unitario
                            $producto['total'],                  // p_costo_total
                        ]);

                    break;

                default:
                    throw new \Exception("Error inesperado al procesar el producto con ID {$producto['producto']}.");
            }
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Documento ingresado, productos registrados y kardex actualizado correctamente.',
        ], 201);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error al guardar el documento.',
            'error' => $e->getMessage(),
        ], 500);
    }
}






    public function obtenerDocumentoIngreso($id)
    {
        // Buscar el encabezado del documento de ingreso por su ID
        $documentoIngreso = DocumentoIngresoHead::with(['tipoOperacion', 'proveedor', 'almacen', 'comprobantePago', 'tipoCambio', 'usuarioCreacion'])
            ->find($id);

        if (!$documentoIngreso) {
            return response()->json(['success' => false, 'message' => 'Documento de ingreso no encontrado.'], 404);
        }

        // Obtener los detalles asociados al encabezado
        $detalles = DocumentoIngresoBody::with(['producto.unidadMedida', 'centroCosto', 'tipoAfectacionIgv'])
            ->where('documento_ingreso_head_id', $id)
            ->get();

        // Retornar los datos como JSON
        return response()->json([
            'success' => true,
            'encabezado' => $documentoIngreso,
            'detalles' => $detalles,
        ]);
    }




}

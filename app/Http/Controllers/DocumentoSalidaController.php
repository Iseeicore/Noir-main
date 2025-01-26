<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentoSalidaHead;
use Illuminate\Support\Facades\DB;
use App\Models\Almacen;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\TipoOperacion;
use App\Models\DocumentoSalidaBody;
use App\Models\CentroCosto;







class DocumentoSalidaController extends Controller
{
    // public function listarDocumentosSalida(Request $request)
    // {
    //     $columnas = [
    //         "documento_salida_head.id",
    //         "fecha_emision",
    //         "periodo",
    //         "tipo_operaciones.descripcion",
    //         "almacen_origen.nomb_almacen as almacen_origen",
    //         "almacen_destino.nomb_almacen as almacen_destino",
    //         "Total_efectivo_Compelto",
    //         "usuarios_creacion.nomb_usuarios"
    //     ];
    
    //     $usuario_id = $request->usuario_id;
    
    //     $query = DocumentoSalidaHead::select(
    //         'documento_salida_head.id',
    //         'documento_salida_head.fecha_emision',
    //         'documento_salida_head.periodo',
    //         'tipo_operaciones.descripcion as tipo_operacion',
    //         'almacen_origen.nomb_almacen as almacen_origen',
    //         'almacen_destino.nomb_almacen as almacen_destino',
    //         'documento_salida_head.Total_efectivo_Compelto',
    //         'usuarios_creacion.nomb_usuarios as usuario_creacion',
    //         'usuarios_recibir.nomb_usuarios as usuario_recibir',
    //         'documento_salida_head.numerodocumento',
    //         'documento_salida_head.numerosecundariodocumento',
    //         'documento_salida_head.glosario'
    //     )
    //         ->leftJoin('tipo_operaciones', 'documento_salida_head.tipo_operacion', '=', 'tipo_operaciones.id')
    //         ->leftJoin('almacen as almacen_origen', 'documento_salida_head.almacenOrigenUsuario', '=', 'almacen_origen.id')
    //         ->leftJoin('almacen as almacen_destino', 'documento_salida_head.almacenDestino', '=', 'almacen_destino.id')
    //         ->leftJoin('usuarios as usuarios_creacion', 'documento_salida_head.UsuarioCreacion', '=', 'usuarios_creacion.id_usuario')
    //         ->leftJoin('usuarios as usuarios_recibir', 'documento_salida_head.UsuarioRecivir', '=', 'usuarios_recibir.id_usuario')
    //         ->where('documento_salida_head.UsuarioCreacion', $usuario_id)
    //         ->orderBy('documento_salida_head.id', 'desc'); // Ordenar de manera descendente
    
    //     if ($request->search['value']) {
    //         $search = $request->search['value'];
    //         $query->where(function ($query) use ($search) {
    //             $query->where('documento_salida_head.fecha_emision', 'like', "%{$search}%")
    //                 ->orWhere('tipo_operaciones.descripcion', 'like', "%{$search}%")
    //                 ->orWhere('almacen_origen.nomb_almacen', 'like', "%{$search}%")
    //                 ->orWhere('almacen_destino.nomb_almacen', 'like', "%{$search}%")
    //                 ->orWhere('documento_salida_head.glosario', 'like', "%{$search}%");
    //         });
    //     }
    
    //     $total_count = DocumentoSalidaHead::count();
    //     $filtered_count = $query->count();
    
    //     if ($request->length != -1) {
    //         $query->skip($request->start)->take($request->length);
    //     }
    
    //     if ($request->order) {
    //         $order_column = $columnas[$request->order[0]['column']];
    //         $order_dir = $request->order[0]['dir'];
    //         $query->orderBy($order_column, $order_dir);
    //     }
    
    //     $data = $query->get()->map(function ($row) {
    //         return [
    //             'opciones' => '',
    //             'id' => $row->id,
    //             'fecha_emision' => $row->fecha_emision,
    //             'periodo' => $row->periodo,
    //             'tipo_operacion' => $row->tipo_operacion,
    //             'almacen_origen' => $row->almacen_origen,
    //             'almacen_destino' => $row->almacen_destino,
    //             'total_efectivo' => $row->Total_efectivo_Compelto,
    //             'usuario_creacion' => $row->usuario_creacion,
    //             'usuario_recibir' => $row->usuario_recibir,
    //             'numerodocumento' => $row->numerodocumento,
    //             'numerosecundariodocumento' => $row->numerosecundariodocumento,
    //             'glosario' => $row->glosario,
    //         ];
    //     });
    
    //     $output = [
    //         'draw' => intval($request->draw),
    //         'recordsTotal' => $total_count,
    //         'recordsFiltered' => $filtered_count,
    //         'data' => $data
    //     ];
    
    //     return response()->json($output);
    // }

    public function listarDocumentosSalida(Request $request)
    {
        $columnas = [
            "documento_salida_head.id",
            "fecha_emision",
            "periodo",
            "tipo_operaciones.descripcion",
            "almacen_origen.nomb_almacen as almacen_origen",
            "almacen_destino.nomb_almacen as almacen_destino",
            "Total_efectivo_Compelto",
            "usuarios_creacion.nomb_usuarios"
        ];
    
        $usuario_id = $request->usuario_id;
    
        $query = DocumentoSalidaHead::select(
            'documento_salida_head.id',
            'documento_salida_head.fecha_emision',
            'documento_salida_head.periodo',
            'tipo_operaciones.descripcion as tipo_operacion',
            'almacen_origen.nomb_almacen as almacen_origen',
            'almacen_destino.nomb_almacen as almacen_destino',
            'documento_salida_head.Total_efectivo_Compelto',
            'usuarios_creacion.nomb_usuarios as usuario_creacion',
            'usuarios_recibir.nomb_usuarios as usuario_recibir',
            'documento_salida_head.numerodocumento',
            'documento_salida_head.numerosecundariodocumento',
            'documento_salida_head.glosario',
            'documento_salida_head.almacenOrigenUsuario' // Incluimos almacén de origen
        )
            ->leftJoin('tipo_operaciones', 'documento_salida_head.tipo_operacion', '=', 'tipo_operaciones.id')
            ->leftJoin('almacen as almacen_origen', 'documento_salida_head.almacenOrigenUsuario', '=', 'almacen_origen.id')
            ->leftJoin('almacen as almacen_destino', 'documento_salida_head.almacenDestino', '=', 'almacen_destino.id')
            ->leftJoin('usuarios as usuarios_creacion', 'documento_salida_head.UsuarioCreacion', '=', 'usuarios_creacion.id_usuario')
            ->leftJoin('usuarios as usuarios_recibir', 'documento_salida_head.UsuarioRecivir', '=', 'usuarios_recibir.id_usuario')
            ->where('documento_salida_head.UsuarioCreacion', $usuario_id)
            ->orderBy('documento_salida_head.id', 'desc'); // Ordenar de manera descendente
    
        if ($request->search['value']) {
            $search = $request->search['value'];
            $query->where(function ($query) use ($search) {
                $query->where('documento_salida_head.fecha_emision', 'like', "%{$search}%")
                    ->orWhere('tipo_operaciones.descripcion', 'like', "%{$search}%")
                    ->orWhere('almacen_origen.nomb_almacen', 'like', "%{$search}%")
                    ->orWhere('almacen_destino.nomb_almacen', 'like', "%{$search}%")
                    ->orWhere('documento_salida_head.glosario', 'like', "%{$search}%");
            });
        }
    
        $total_count = DocumentoSalidaHead::count();
        $filtered_count = $query->count();
    
        if ($request->length != -1) {
            $query->skip($request->start)->take($request->length);
        }
    
        $data = $query->get()->map(function ($row) {
            // Determinar si se pueden mostrar los botones
            $mostrarBotones = in_array($row->almacenOrigenUsuario, [1, 2, 3]);
    
            return [
                'opciones' => $mostrarBotones,
                'id' => $row->id,
                'fecha_emision' => $row->fecha_emision,
                'periodo' => $row->periodo,
                'tipo_operacion' => $row->tipo_operacion,
                'almacen_origen' => $row->almacen_origen,
                'almacen_destino' => $row->almacen_destino,
                'total_efectivo' => $row->Total_efectivo_Compelto,
                'usuario_creacion' => $row->usuario_creacion,
                'usuario_recibir' => $row->usuario_recibir,
                'numerodocumento' => $row->numerodocumento,
                'numerosecundariodocumento' => $row->numerosecundariodocumento,
                'glosario' => $row->glosario,
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
    


    public function generarCodigoDocumentoSalida()
    {
        // Obtener el último `codigo_head` de la tabla `documento_salida_head`
        $ultimoCodigo = DB::table('documento_salida_head')
                        ->select('codigo_head')
                        ->orderByDesc('id') // Ordenar por `id` de forma descendente
                        ->limit(1)
                        ->value('codigo_head');

        if ($ultimoCodigo) {
            // Extraer la parte numérica del código y convertirla a entero
            $numero = (int) substr($ultimoCodigo, 6);

            // Generar el nuevo número incrementado y formatearlo con 6 dígitos
            $nuevoNumero = str_pad($numero + 1, 6, '0', STR_PAD_LEFT);
            $nuevoCodigo = "DOCSAL" . $nuevoNumero;
        } else {
            // Si no existe ningún registro, empezar con `DOCING000001`
            $nuevoCodigo = "DOCSAL000001";
        }

        return response()->json(['nuevo_codigo' => $nuevoCodigo]);
    }
    public function obtenerAlmacenUsuario(Request $request)
    {
        $usuario = auth()->user(); // Obtener el usuario autenticado

        if ($usuario && $usuario->almacen) {
            return response()->json([
                'success' => true,
                'almacen_id' => $usuario->almacen->id,
                'almacen_nombre' => $usuario->almacen->nomb_almacen,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'El usuario no tiene un almacén asignado.',
        ], 404);
    }

    public function obtenerAlmacenesExcluyendoActual(Request $request)
    {
        $usuario = auth()->user(); // Usuario autenticado
    
        if (!$usuario || !$usuario->almacen) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo determinar el almacén actual del usuario.',
            ], 404);
        }
    
        // Obtener el ID del almacén actual del usuario
        $almacenActualId = $usuario->almacen->id;
    
        // Obtener todos los almacenes excepto el actual
        $almacenes = Almacen::where('id', '!=', $almacenActualId)
            ->where('estado', 1) // Considerando almacenes activos
            ->get(['id', 'nomb_almacen']);
    
        return response()->json([
            'success' => true,
            'almacenes' => $almacenes,
        ]);
    }
    public function obtenerUsuariosExcluyendoActual(Request $request)
    {
        $usuarioActualId = auth()->user()->id_usuario; // Obtener el ID del usuario autenticado
    
        // Obtener usuarios excluyendo al actual
        $usuarios = Usuario::where('id_usuario', '!=', $usuarioActualId)
            ->where('estado', 1) // Filtrar solo usuarios activos
            ->get(['id_usuario', 'nomb_usuarios', 'apellidos_usuarios', 'usuario']);
    
        return response()->json([
            'success' => true,
            'usuarios' => $usuarios,
        ]);
    }

    
    
    
    public function cargarProductoUsuarioActual()
    {
        try {
            $usuario = auth()->user(); // Obtener el usuario actual
            $almacenId = $usuario->id_almacen_usuario; // ID del almacén asignado al usuario
    
            // Obtener productos del almacén del usuario actual
            $productos = Producto::where('id_almacen', $almacenId)
                ->with([
                    'unidadMedida:id,nomb_uniMed',
                    'tipoAfectacionIgv:id,porcentaje' // Asegurar que 'descripcion' existe
                ])
                ->get(['id', 'descripcion', 'id_unidad_medida', 'id_tipo_afectacion_igv','costo_unitario','stock']); // Seleccionar campos relevantes
    
            return response()->json([
                'success' => true,
                'productos' => $productos,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los productos.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
    
        try {
            // Crear el registro en DocumentoSalidaHead
            $documentoSalidaHead = DocumentoSalidaHead::create([
                'codigo_head' => $request->input('codigo_documento_salida'),
                'fecha_emision' => $request->input('fecha_emision'),
                'fecha_contable' => $request->input('fecha_contable'),
                'periodo' => $request->input('periodo'),
                'tipo_operacion' => $request->input('tipo_operacion'),
                'almacenOrigenUsuario' => $request->input('almacen_id'),
                'almacenDestino' => $request->input('almacen_destino_id'),
                'UsuarioRecivir' => $request->input('usuario_recibir'),
                'numerodocumento' => $request->input('numerodocumento'),
                'numerosecundariodocumento' => $request->input('numerosecundariodocumento'),
                'glosario' => $request->input('glosario'),
                'Total_efectivo_Compelto' => $request->input('total_efectivo'),
                'UsuarioCreacion' => $request->input('Usuario_actual'),
            ]);
    
            $documentoSalidaHeadId = $documentoSalidaHead->id;
            $codigoHead = $documentoSalidaHead->codigo_head;
    
            // Validar tipo de operación
            $tipoOperacion = TipoOperacion::find($request->input('tipo_operacion'));
            if (!$tipoOperacion) {
                throw new \Exception("Tipo de operación no encontrado: ID {$request->input('tipo_operacion')}");
            }
    
            $esDevolucion = strtoupper($tipoOperacion->tipo) === 'DEVOLUCIÓN';
            $esSalida = strtoupper($tipoOperacion->tipo) === 'SALIDA';
    
            foreach ($request->input('productos') as $producto) {
                // Crear registro en DocumentoSalidaBody
                DocumentoSalidaBody::create([
                    'documento_salida_head_id' => $documentoSalidaHeadId,
                    'producto' => $producto['producto_id'],
                    'cantidad' => $producto['cantidad'],
                    'centro_costos' => $producto['centro_costo_id'],
                    'tipo_afectacion' => $producto['tipo_afectacion_id'],
                    'precio_unitario' => $producto['precio_unitario'],
                    'total' => $producto['total'],
                ]);
    
                // Validar producto existente en el almacén origen
                $productoExistente = Producto::find($producto['producto_id']);
                if (!$productoExistente) {
                    throw new \Exception("Producto no encontrado: ID {$producto['producto_id']}");
                }
    
                // Obtener descripción del centro de costo
                $descripcionCentroCosto = CentroCosto::where('id', $producto['centro_costo_id'])->value('nomb_centroCos');
                if (!$descripcionCentroCosto) {
                    throw new \Exception("Centro de costo no encontrado: ID {$producto['centro_costo_id']}");
                }
    
                // Validar almacenDestino
                $almacenDestinoId = $request->input('almacen_destino_id');
                $almacenId = $request->input('almacen_id');
                $descripcionAlmacenDestino = Almacen::where('id', $almacenDestinoId)->value('nomb_almacen');
    
                if ($esDevolucion) {
                    if ($almacenDestinoId == 4) {
                        // **Devolución: Almacén Destino es 'Ninguno' (ID 4)**
                        DB::statement('CALL prc_devolucion_kardex_producto_salida(?,?,?,?,?,?,?,?,?,?,?)', [
                            $producto['producto_id'],
                            $productoExistente->codigo_productos,
                            $almacenId,
                            $almacenDestinoId,
                            "Devolución de Producto a $descripcionAlmacenDestino",
                            $codigoHead,
                            $producto['centro_costo_id'],
                            $descripcionCentroCosto,
                            $producto['cantidad'],
                            $producto['precio_unitario'],
                            $producto['total'],
                        ]);
                    } else {
                        // **Devolución entre almacenes**
                        DB::statement('CALL prc_registrar_kardex_producto_salida(?,?,?,?,?,?,?,?,?,?,?)', [
                            $producto['producto_id'],
                            $productoExistente->codigo_productos,
                            $almacenId,
                            $almacenDestinoId,
                            "Devolución de Producto a Almacén ID {$almacenDestinoId}",
                            $codigoHead,
                            $producto['centro_costo_id'],
                            $descripcionCentroCosto,
                            $producto['cantidad'],
                            $producto['precio_unitario'],
                            $producto['total'],
                        ]);
    
                        $productoExistenteEnDestino = Producto::where('codigo_productos', $productoExistente->codigo_productos)
                            ->where('id_almacen', $almacenDestinoId)
                            ->first();
    
                        if ($productoExistenteEnDestino) {
                            DB::statement('CALL prc_actualizar_kardex_producto_existencia(?,?,?,?,?,?,?,?,?,?,?)', [
                                $productoExistenteEnDestino->id,
                                $productoExistenteEnDestino->codigo_productos,
                                $almacenDestinoId,
                                $almacenId,
                                "Actualización por Devolución",
                                $codigoHead,
                                $producto['centro_costo_id'],
                                $descripcionCentroCosto,
                                $producto['cantidad'],
                                $producto['precio_unitario'],
                                $producto['total'],
                            ]);
                        } else {
                            $nuevoProducto = Producto::create([
                                'codigo_productos' => $productoExistente->codigo_productos,
                                'id_categorias' => $productoExistente->id_categorias,
                                'id_almacen' => $almacenDestinoId,
                                'descripcion' => $productoExistente->descripcion,
                                'id_tipo_afectacion_igv' => $producto['tipo_afectacion_id'],
                                'id_unidad_medida' => $productoExistente->id_unidad_medida,
                                'stock' => $producto['cantidad'],
                                'costo_unitario' => $producto['precio_unitario'],
                                'costo_total' => $producto['total'],
                                'imagen' => $productoExistente->imagen,
                            ]);
    
                            DB::statement('CALL prc_registrar_kardex_producto_existencia(?,?,?,?,?,?,?,?,?,?,?)', [
                                $nuevoProducto->id,
                                $nuevoProducto->codigo_productos,
                                $almacenDestinoId,
                                $almacenId,
                                "Saldo Inicial por Devolución",
                                $codigoHead,
                                $producto['centro_costo_id'],
                                $descripcionCentroCosto,
                                $producto['cantidad'],
                                $producto['precio_unitario'],
                                $producto['total'],
                            ]);
                        }
                    }
                } elseif ($esSalida && $almacenDestinoId != 4) {
                    // **Salida entre almacenes**
                    DB::statement('CALL prc_registrar_kardex_producto_salida(?,?,?,?,?,?,?,?,?,?,?)', [
                        $producto['producto_id'],
                        $productoExistente->codigo_productos,
                        $almacenId,
                        $almacenDestinoId,
                        "Salida entre Almacenes",
                        $codigoHead,
                        $producto['centro_costo_id'],
                        $descripcionCentroCosto,
                        $producto['cantidad'],
                        $producto['precio_unitario'],
                        $producto['total'],
                    ]);
    
                    $productoExistenteEnDestino = Producto::where('codigo_productos', $productoExistente->codigo_productos)
                        ->where('id_almacen', $almacenDestinoId)
                        ->first();
    
                    if ($productoExistenteEnDestino) {
                        DB::statement('CALL prc_actualizar_kardex_producto_existencia(?,?,?,?,?,?,?,?,?,?,?)', [
                            $productoExistenteEnDestino->id,
                            $productoExistenteEnDestino->codigo_productos,
                            $almacenDestinoId,
                            $almacenId,
                            "Actualización por Salida entre Almacenes",
                            $codigoHead,
                            $producto['centro_costo_id'],
                            $descripcionCentroCosto,
                            $producto['cantidad'],
                            $producto['precio_unitario'],
                            $producto['total'],
                        ]);
                    } else {
                        $nuevoProducto = Producto::create([
                            'codigo_productos' => $productoExistente->codigo_productos,
                            'id_categorias' => $productoExistente->id_categorias,
                            'id_almacen' => $almacenDestinoId,
                            'descripcion' => $productoExistente->descripcion,
                            'id_tipo_afectacion_igv' => $producto['tipo_afectacion_id'],
                            'id_unidad_medida' => $productoExistente->id_unidad_medida,
                            'stock' => $producto['cantidad'],
                            'costo_unitario' => $producto['precio_unitario'],
                            'costo_total' => $producto['total'],
                            'imagen' => $productoExistente->imagen,
                        ]);
    
                        DB::statement('CALL prc_registrar_kardex_producto_existencia(?,?,?,?,?,?,?,?,?,?,?)', [
                            $nuevoProducto->id,
                            $nuevoProducto->codigo_productos,
                            $almacenDestinoId,
                            $almacenId,
                            "Saldo Inicial por Salida entre Almacenes",
                            $codigoHead,
                            $producto['centro_costo_id'],
                            $descripcionCentroCosto,
                            $producto['cantidad'],
                            $producto['precio_unitario'],
                            $producto['total'],
                        ]);
                    }
                } else {
                    // **Salida normal**
                    DB::statement('CALL prc_registrar_kardex_producto_salida(?,?,?,?,?,?,?,?,?,?,?)', [
                        $producto['producto_id'],
                        $productoExistente->codigo_productos,
                        $almacenId,
                        $almacenDestinoId,
                        "Registro Salida de Producto",
                        $codigoHead,
                        $producto['centro_costo_id'],
                        $descripcionCentroCosto,
                        $producto['cantidad'],
                        $producto['precio_unitario'],
                        $producto['total'],
                    ]);
                }
            }
    
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Documento de salida registrado correctamente.',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al registrar el documento de salida.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    


    // public function store(Request $request)
    // {
    //     DB::beginTransaction();
    
    //     try {
    //         // Crear el registro en DocumentoSalidaHead
    //         $documentoSalidaHead = DocumentoSalidaHead::create([
    //             'codigo_head' => $request->input('codigo_documento_salida'),
    //             'fecha_emision' => $request->input('fecha_emision'),
    //             'fecha_contable' => $request->input('fecha_contable'),
    //             'periodo' => $request->input('periodo'),
    //             'tipo_operacion' => $request->input('tipo_operacion'),
    //             'almacenOrigenUsuario' => $request->input('almacen_id'),
    //             'almacenDestino' => $request->input('almacen_destino_id'),
    //             'UsuarioRecivir' => $request->input('usuario_recibir'),
    //             'numerodocumento' => $request->input('numerodocumento'),
    //             'numerosecundariodocumento' => $request->input('numerosecundariodocumento'),
    //             'glosario' => $request->input('glosario'),
    //             'Total_efectivo_Compelto' => $request->input('total_efectivo'),
    //             'UsuarioCreacion' => $request->input('Usuario_actual'),
    //         ]);
    
    //         $documentoSalidaHeadId = $documentoSalidaHead->id;
    //         $codigoHead = $documentoSalidaHead->codigo_head;
    
    //         // Validar tipo de operación
    //         $tipoOperacion = TipoOperacion::find($request->input('tipo_operacion'));
    //         if (!$tipoOperacion) {
    //             throw new \Exception("Tipo de operación no encontrado: ID {$request->input('tipo_operacion')}");
    //         }
    
    //         // Comparar tipo de operación con "DEVOLUCIÓN" en mayúsculas
    //         $esDevolucion = strtoupper($tipoOperacion->tipo) === 'DEVOLUCIÓN';
    
    //         // Iterar por cada producto
    //         foreach ($request->input('productos') as $producto) {
    //             // Crear registro en DocumentoSalidaBody
    //             DocumentoSalidaBody::create([
    //                 'documento_salida_head_id' => $documentoSalidaHeadId,
    //                 'producto' => $producto['producto_id'],
    //                 'cantidad' => $producto['cantidad'],
    //                 'centro_costos' => $producto['centro_costo_id'],
    //                 'tipo_afectacion' => $producto['tipo_afectacion_id'],
    //                 'precio_unitario' => $producto['precio_unitario'],
    //                 'total' => $producto['total'],
    //             ]);
    
    //             // Buscar el producto
    //             $productoExistente = Producto::find($producto['producto_id']);
    //             if (!$productoExistente) {
    //                 throw new \Exception("Producto no encontrado: ID {$producto['producto_id']}");
    //             }
    
    //             // Obtener la descripción del centro de costo
    //             $descripcionCentroCosto = CentroCosto::where('id', $producto['centro_costo_id'])->value('nomb_centroCos');
    
    //             if ($esDevolucion) {
    //                 // Devolución: Ejecutar el procedimiento prc_devolucion_kardex_producto_salida
    //                 $descripcionAlmacenDestino = Almacen::where('id', $request->input('almacen_destino_id'))
    //                     ->value('nomb_almacen');
    
    //                 DB::statement('CALL prc_devolucion_kardex_producto_salida(?,?,?,?,?,?,?,?,?,?,?)', [
    //                     $producto['producto_id'],                // p_id_producto
    //                     $productoExistente->codigo_productos,   // p_codigo_producto
    //                     $request->input('almacen_id'),          // p_almacen
    //                     $request->input('almacen_destino_id'),  // p_almacenDestino
    //                     "Devolución de Producto a $descripcionAlmacenDestino", // p_concepto
    //                     $codigoHead,                            // p_comprobante
    //                     $producto['centro_costo_id'],           // p_centro_costo
    //                     $descripcionCentroCosto,                // p_descripcion_centro_costo
    //                     $producto['cantidad'],                  // p_unidades
    //                     $producto['precio_unitario'],           // p_costo_unitario
    //                     $producto['total'],                     // p_costo_total
    //                 ]);
    //             } else {
    //                 // Registro de salida normal: Ejecutar prc_registrar_kardex_producto_salida
    //                 DB::statement('CALL prc_registrar_kardex_producto_salida(?,?,?,?,?,?,?,?,?,?,?)', [
    //                     $producto['producto_id'],                // p_id_producto
    //                     $productoExistente->codigo_productos,   // p_codigo_producto
    //                     $request->input('almacen_id'),          // p_almacen
    //                     $request->input('almacen_destino_id'),  // p_almacenDestino
    //                     'Registro Salida de Producto',          // p_concepto
    //                     $codigoHead,                            // p_comprobante
    //                     $producto['centro_costo_id'],           // p_centro_costo
    //                     $descripcionCentroCosto,                // p_descripcion_centro_costo
    //                     $producto['cantidad'],                  // p_unidades
    //                     $producto['precio_unitario'],           // p_costo_unitario
    //                     $producto['total'],                     // p_costo_total
    //                 ]);
    //             }
    //         }
    
    //         DB::commit();
    
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Documento de salida registrado correctamente.',
    //         ], 201);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Ocurrió un error al registrar el documento de salida.',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }
    
    public function cambioDeTipoOperacionesSalida()
    {
        $tipoOperaciones = TipoOperacion::whereIn('tipo', ['SALIDA', 'DEVOLUCIÓN', 'NINGUNO'])->get();
        return response()->json(['tipo_operaciones' => $tipoOperaciones]);
    }

    public function obtenerDocumentoSalida($id)
    {
        // Buscar el encabezado del documento de salida por su ID
        $documentoSalida = DocumentoSalidaHead::with([
            'tipoOperacion', 
            'almacenOrigen', 
            'almacenDestino', 
            'usuarioRecibir', 
            'usuarioCreacion'
        ])->find($id);

        if (!$documentoSalida) {
            return response()->json(['success' => false, 'message' => 'Documento de salida no encontrado.'], 404);
        }

        // Obtener los detalles asociados al encabezado
        $detalles = DocumentoSalidaBody::with([
            'producto.unidadMedida', 
            'centroCosto', 
            'tipoAfectacionIgv'
        ])
        ->where('documento_salida_head_id', $id)
        ->get();

        // Retornar los datos como JSON
        return response()->json([
            'success' => true,
            'encabezado' => $documentoSalida,
            'detalles' => $detalles,
        ]);
    }


    
    
    
    
    



}

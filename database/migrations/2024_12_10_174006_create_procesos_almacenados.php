<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_actualizar_kardex_producto_existencia` (
            IN `p_id_producto` INT, 
            IN `p_codigo_producto` VARCHAR(255), 
            IN `p_almacen` INT, 
            IN `p_almacenDestino` INT, 
            IN `p_concepto` VARCHAR(255), 
            IN `p_comprobante` VARCHAR(255), 
            IN `p_centro_costo` INT, 
            IN `p_descripcion_centro_costo` VARCHAR(150), 
            IN `p_unidades` FLOAT, 
            IN `p_costo_unitario` FLOAT, 
            IN `p_costo_total` FLOAT
        )
        BEGIN
            -- VARIABLES PARA EXISTENCIAS ACTUALES
            DECLARE v_unidades_ex FLOAT DEFAULT 0;
            DECLARE v_costo_unitario_ex FLOAT DEFAULT 0;
            DECLARE v_costo_total_ex FLOAT DEFAULT 0;

            -- OBTENER LAS EXISTENCIAS ACTUALES DEL PRODUCTO EN EL ALMACÉN
            SELECT ex_unidades, ex_costo_unitario, ex_costo_total
            INTO v_unidades_ex, v_costo_unitario_ex, v_costo_total_ex
            FROM kardex
            WHERE id_producto = p_id_producto AND almacen = p_almacen
            ORDER BY id DESC
            LIMIT 1;

            -- CALCULAR NUEVAS EXISTENCIAS
            SET v_unidades_ex = v_unidades_ex + p_unidades;
            SET v_costo_total_ex = v_costo_total_ex + p_costo_total;

            IF v_unidades_ex > 0 THEN
                SET v_costo_unitario_ex = ROUND(v_costo_total_ex / v_unidades_ex, 2);
            ELSE
                SET v_costo_unitario_ex = 0;
            END IF;

            -- INSERTAR EL REGISTRO DE ACTUALIZACIÓN EN EL KARDEX
            INSERT INTO kardex (
                id_producto, 
                codigo_producto, 
                almacen, 
                almacenDestino,
                fecha, 
                concepto, 
                comprobante, 
                centro_costo, 
                descripcion_centro_costo,
                in_unidades, 
                in_costo_unitario, 
                in_costo_total, 
                ex_unidades, 
                ex_costo_unitario, 
                ex_costo_total
            )
            VALUES (
                p_id_producto,
                p_codigo_producto,
                p_almacen,
                p_almacenDestino,
                CURDATE(),
                p_concepto,
                p_comprobante,
                p_centro_costo,
                p_descripcion_centro_costo,
                p_unidades,
                p_costo_unitario,
                p_costo_total,
                v_unidades_ex,
                v_costo_unitario_ex,
                v_costo_total_ex
            );

            -- ACTUALIZAR EL STOCK Y LOS COSTOS DEL PRODUCTO
            UPDATE producto
            SET stock = v_unidades_ex,
                costo_unitario = v_costo_unitario_ex,
                costo_total = v_costo_total_ex
            WHERE id = p_id_producto AND id_almacen = p_almacen;
        END;
    SQL);
    

    DB::unprepared(<<<SQL
        CREATE  PROCEDURE `prc_conteo_Devolucion_dashboard` (IN `p_almacen` INT, IN `p_fecha_actual` DATE)   BEGIN
            SELECT 
                COUNT(*) AS total_devoluciones
            FROM kardex
            WHERE almacen = p_almacen
            AND fecha = p_fecha_actual
            AND (
                concepto LIKE 'Actualización por Devolución'
                OR concepto LIKE 'Saldo Inicial por Devolución'
                OR concepto LIKE 'Devolución de Producto a Almacén ID%'
                OR concepto LIKE 'Devolución de Producto a%'
            );
        END;
    SQL);
    
    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_conteo_ingresos_dashboard` (IN `p_almacen` INT)   BEGIN
            SELECT COUNT(*) AS total_ingresos
            FROM kardex
            WHERE almacen = p_almacen
            AND concepto IN (
                'Actualizar',
                'Saldo Inicial Registro Doc Ingreso',
                'Devolución de Producto a [Descripción del Almacén Destino]',
                'Devolución entre almacenes'
            )
            AND DATE(fecha) = CURDATE(); -- Fecha actual
        END;
    SQL);


    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_conteo_salidas_Dashboard` (IN `p_almacen` INT, IN `p_fecha_actual` DATE)   BEGIN
            SELECT COUNT(*) AS total_salidas
            FROM kardex
            WHERE almacen = p_almacen
            AND fecha = p_fecha_actual
            AND concepto IN ('Salida entre Almacenes', 'Registro Salida de Producto');
        END;
    SQL);


    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_conteo_total_productos_poco_stock_Dashboard` (IN `p_id_almacen_usuario` INT)   BEGIN
            SELECT 
                COUNT(*) AS total_productos_poco_stock
            FROM producto p
            WHERE p.id_almacen = p_id_almacen_usuario
            AND p.stock < p.minimo_stock
            AND p.estado = 1; -- Asegura que el producto esté activo
        END;
    SQL);

    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_devolucion_kardex_producto_salida` (IN `p_id_producto` INT, IN `p_codigo_producto` VARCHAR(255), IN `p_almacen` INT, IN `p_almacenDestino` INT, IN `p_concepto` VARCHAR(255), IN `p_comprobante` VARCHAR(255), IN `p_centro_costo` INT, IN `p_descripcion_centro_costo` VARCHAR(150), IN `p_unidades` FLOAT, IN `p_costo_unitario` FLOAT, IN `p_costo_total` FLOAT)   BEGIN
            -- Variables para las existencias actuales
            DECLARE v_unidades_ex FLOAT DEFAULT 0;
            DECLARE v_costo_unitario_ex FLOAT DEFAULT 0;
            DECLARE v_costo_total_ex FLOAT DEFAULT 0;

            -- Obtener las últimas existencias del producto en el almacén
            SELECT ex_unidades, ex_costo_unitario, ex_costo_total
            INTO v_unidades_ex, v_costo_unitario_ex, v_costo_total_ex
            FROM kardex
            WHERE id_producto = p_id_producto AND almacen = p_almacen
            ORDER BY id DESC
            LIMIT 1;

            -- Calcular nuevas existencias tras la devolución
            SET v_unidades_ex = v_unidades_ex + p_unidades;
            SET v_costo_total_ex = v_costo_total_ex + p_costo_total;

            IF v_unidades_ex > 0 THEN
                SET v_costo_unitario_ex = ROUND(v_costo_total_ex / v_unidades_ex, 2);
            ELSE
                SET v_costo_unitario_ex = 0;
            END IF;

            -- Insertar el nuevo registro en el Kardex
            INSERT INTO kardex (
                id_producto,
                codigo_producto,
                almacen,
                almacenDestino,
                fecha,
                concepto,
                comprobante,
                centro_costo,
                descripcion_centro_costo,
                out_unidades,
                out_costo_unitario,
                out_costo_total,
                ex_unidades,
                ex_costo_unitario,
                ex_costo_total
            )
            VALUES (
                p_id_producto,
                p_codigo_producto,
                p_almacen,
                p_almacenDestino,
                CURDATE(),
                p_concepto,
                p_comprobante,
                p_centro_costo,
                p_descripcion_centro_costo,
                -p_unidades, -- Registrar cantidad negativa para la devolución
                p_costo_unitario,
                -p_costo_total, -- Registrar costo total negativo
                v_unidades_ex,
                v_costo_unitario_ex,
                v_costo_total_ex
            );

            -- Actualizar el stock y los costos del producto
            UPDATE producto
            SET stock = v_unidades_ex,
                costo_unitario = v_costo_unitario_ex,
                costo_total = v_costo_total_ex
            WHERE id = p_id_producto AND id_almacen = p_almacen;
        END;
    SQL);

    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_kardex_quincenas_Dashboard` (IN `p_producto` INT, IN `p_almacen` INT, IN `p_year` INT)   BEGIN
            SELECT
                CEIL(DAY(fecha) / 15) AS quincena,
                CASE
                    WHEN concepto LIKE 'Actualizar%' OR concepto = 'Saldo Inicial Registro Doc Ingreso' THEN 'ingresos'
                    WHEN concepto LIKE 'Devolución%' AND almacenDestino IS NOT NULL THEN 'ingresos'
                    WHEN concepto LIKE 'Devolución%' AND almacenDestino IS NULL THEN 'devoluciones'
                    ELSE 'salidas'
                END AS tipo_movimiento,
                COUNT(*) AS total_movimientos
            FROM kardex
            WHERE id_producto = p_producto
            AND almacen = p_almacen
            AND YEAR(fecha) = p_year
            GROUP BY quincena, tipo_movimiento
            ORDER BY quincena, tipo_movimiento;
        END;
    SQL);
    
    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_ListarCargasMasivas` ()   BEGIN
            SELECT 
                id, 
                nucleos_insertados, nucleos_omitidos,
                centros_costo_insertados, centros_costo_omitidos,
                categorias_insertadas, categorias_omitidas,
                almacenes_insertados, almacenes_omitidos,
                codigo_unidades_medida_insertadas, codigo_unidades_medida_omitidas,
                tipo_afectacion_insertados, tipo_afectacion_omitidos,
                productos_insertados, productos_omitidos,
                estado_carga, created_at
            FROM historico_carga_masivas
            ORDER BY id DESC;
        END;
    SQL);

    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_ListarPerfilesAsignar` ()   SELECT 
        id_perfil,
        descripcion,
        CASE 
            WHEN estado = 1 THEN 'Activo' 
            ELSE 'Inactivo' 
        END AS estado,
        DATE(fecha_creacion) AS fecha_creacion,
        fecha_actualizacion,
        '' AS opciones
    FROM perfiles
    ORDER BY id_perfil ASC;
    SQL);

    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_ListarProductos` ()   SELECT  
        '' AS detalle,
        '' AS acciones,
        p.id,
        p.codigo_productos,
        p.id_categorias,
        UPPER(c.nomb_cate) AS nombre_categoria,
        UPPER(p.descripcion) AS producto,
        UPPER(a.nomb_almacen) AS almacen, -- Información del almacén
        p.imagen,
        p.id_tipo_afectacion_igv,
        UPPER(tai.nomb_impuesto) AS tipo_afectacion_igv,
        p.id_unidad_medida,
        UPPER(cum.nomb_uniMed) AS unidad_medida,
        ROUND(p.costo_unitario, 2) AS costo_unitario,
        ROUND(p.precio_unitario_con_igv, 2) AS precio_unitario_con_igv,
        ROUND(p.precio_unitario_sin_igv, 2) AS precio_unitario_sin_igv,
        p.stock,
        p.minimo_stock,
        ROUND(p.costo_total, 2) AS costo_total,
        CASE WHEN p.estado = 1 THEN 'ACTIVO' ELSE 'INACTIVO' END AS estado
    FROM 
        producto p 
        INNER JOIN categoria c ON p.id_categorias = c.id
        INNER JOIN tipo_afectacion_igv tai ON tai.id = p.id_tipo_afectacion_igv
        INNER JOIN unidad_medida cum ON cum.id = p.id_unidad_medida
        INNER JOIN almacen a ON p.id_almacen = a.id -- Uniendo con la tabla de almacén
    WHERE 
        p.estado IN (0, 1);
    SQL);
    
    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_ListarProductosModelosreq` ()   SELECT
        '' AS opciones,              -- 0: espacio para opciones
        psu.id,                      -- 1: ID de producto sin ubicación
        psu.cod_registro AS codigo_productos, -- 2: código del producto
        psu.categoria AS id_categorias,       -- 3: ID de categoría
        UPPER(c.nomb_cate) AS nombre_categoria, -- 4: nombre de la categoría
        UPPER(psu.descripcion) AS producto,     -- 5: descripción del producto
        psu.unidad_medida AS id_unidad_medida,  -- 6: ID de unidad de medida
        UPPER(um.nomb_uniMed) AS unidad_medida, -- 7: nombre de unidad de medida
        psu.imagen,                  -- 8: imagen del producto
        psu.minimo_stock,            -- 9: mínimo stock
        CASE WHEN psu.estado = 1 THEN 'ACTIVO' ELSE 'INACTIVO' END AS estado -- 10: estado
    FROM
        producto_sin_ubicacion psu
        INNER JOIN categoria c ON psu.categoria = c.id
        INNER JOIN unidad_medida um ON psu.unidad_medida = um.id
    WHERE
        psu.estado IN (0, 1);
    SQL);

    DB::unprepared(<<<SQL
        CREATE  PROCEDURE `prc_listar_cantidad_total_Preciosxproductos_usuario_Dashboard` (IN `p_almacen_id` INT)   BEGIN
        SELECT 
            SUM(p.costo_total) AS total_compras,
            MAX(a.nomb_almacen) AS almacen_nombre
        FROM producto p
        INNER JOIN almacen a ON p.id_almacen = a.id
        WHERE p.id_almacen = p_almacen_id
        AND p.estado = 1;
    END;
    SQL);

    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_listar_cantidad_total_productos_usuarioAct_Dashboard` (IN `almacen_id` INT)   BEGIN
            SELECT COUNT(*) AS total_productos
            FROM producto
            WHERE id_almacen = almacen_id AND estado = 1; -- Solo productos activos
        END;
    SQL);

    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_listar_Kardex` ()   BEGIN
            SELECT 
                "" AS opciones, -- Campo para el botón de opciones
                k.id AS id_kardex,
                k.codigo_producto,
                k.id_producto,
                p.descripcion AS producto,
                k.almacen AS id_almacen,
                a.nomb_almacen AS almacen,
                k.almacenDestino AS id_almacen_destino,
                ad.nomb_almacen AS almacen_destino,
        DATE_FORMAT(k.fecha, '%d/%m/%Y') AS fecha,
                k.concepto,
                k.comprobante,
                k.centro_costo,
                cc.nomb_centroCos AS descripcion_centro_costo,
                k.in_unidades AS unidades_ingresadas,
                k.in_costo_unitario AS costo_unitario_ingresado,
                k.in_costo_total AS costo_total_ingresado,
                k.out_unidades AS unidades_salidas,
                k.out_costo_unitario AS costo_unitario_salida,
                k.out_costo_total AS costo_total_salida,
                k.ex_unidades AS unidades_existentes,
                k.ex_costo_unitario AS costo_unitario_existente,
                k.ex_costo_total AS costo_total_existente
            FROM kardex k
            LEFT JOIN producto p ON k.id_producto = p.id
            LEFT JOIN almacen a ON k.almacen = a.id
            LEFT JOIN almacen ad ON k.almacenDestino = ad.id
            LEFT JOIN centro_costo cc ON k.centro_costo = cc.id;
        END;
    SQL);

    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_obtener_productos_poco_stock` (IN `almacen_id` INT)   BEGIN
        SELECT 
            p.descripcion AS producto,
            a.nomb_almacen AS almacen,
            p.stock AS stock_actual,
            p.minimo_stock AS minimo_stock
        FROM producto p
        INNER JOIN almacen a ON p.id_almacen = a.id
        WHERE p.id_almacen = almacen_id
        AND p.stock < p.minimo_stock;
    END;
    SQL);

    
    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_registrar_kardex_bono` (IN `p_codigo_producto` VARCHAR(20), IN `p_concepto` VARCHAR(100), IN `p_nuevo_stock` FLOAT)   BEGIN

        /*VARIABLES PARA EXISTENCIAS ACTUALES*/
        declare v_unidades_ex float;
        declare v_costo_unitario_ex float;    
        declare v_costo_total_ex float;

        declare v_unidades_in float;
        declare v_costo_unitario_in float;    
        declare v_costo_total_in float;
        declare v_almacen INT;    

        /* OBTENEMOS EL ALMACÉN MÁS RECIENTE PARA EL PRODUCTO */
        SELECT almacen
        INTO v_almacen
        FROM kardex
        WHERE codigo_producto = p_codigo_producto
        ORDER BY id DESC
        LIMIT 1;



        /*OBTENEMOS LAS ULTIMAS EXISTENCIAS DEL PRODUCTO*/    
        SELECT k.ex_costo_unitario , k.ex_unidades, k.ex_costo_total
        into v_costo_unitario_ex, v_unidades_ex, v_costo_total_ex
        FROM kardex k
        WHERE k.codigo_producto = p_codigo_producto
        AND k.almacen = v_almacen
        ORDER BY id DESC
        LIMIT 1;

        /*SETEAMOS LOS VALORES PARA EL REGISTRO DE INGRESO*/
        SET v_unidades_in = p_nuevo_stock - v_unidades_ex;
        SET v_costo_unitario_in = v_costo_unitario_ex;
        SET v_costo_total_in = v_unidades_in * v_costo_unitario_in;

        /*SETEAMOS LAS EXISTENCIAS ACTUALES*/
        SET v_unidades_ex = ROUND(p_nuevo_stock,2);    
        SET v_costo_total_ex = ROUND(v_costo_total_ex + v_costo_total_in,2);

        IF(v_costo_total_ex > 0) THEN
            SET v_costo_unitario_ex = ROUND(v_costo_total_ex/v_unidades_ex,2);
        else
            SET v_costo_unitario_ex = ROUND(0,2);
        END IF;

            
        INSERT INTO kardex(codigo_producto,
                        almacen,
                            fecha,
                            concepto,
                            comprobante,
                            in_unidades,
                            in_costo_unitario,
                            in_costo_total,
                            ex_unidades,
                            ex_costo_unitario,
                            ex_costo_total)
                    VALUES(p_codigo_producto,
                            v_almacen,
                            curdate(),
                            p_concepto,
                            '',
                            v_unidades_in,
                            v_costo_unitario_in,
                            v_costo_total_in,
                            v_unidades_ex,
                            v_costo_unitario_ex,
                            v_costo_total_ex);

        /*ACTUALIZAMOS EL STOCK, EL NRO DE VENTAS DEL PRODUCTO*/
        UPDATE producto 
        SET stock = v_unidades_ex, 
            costo_unitario = v_costo_unitario_ex,
            costo_total= v_costo_total_ex
        WHERE codigo_productos = p_codigo_producto 
        AND id_almacen = v_almacen;                      

        END;
    SQL);

    
    DB::unprepared(<<<SQL
        CREATE  PROCEDURE `prc_registrar_kardex_existencias` (IN `p_codigo_producto` VARCHAR(255), IN `p_concepto` VARCHAR(255), IN `p_comprobante` VARCHAR(255), IN `p_unidades` FLOAT, IN `p_costo_unitario` FLOAT, IN `p_costo_total` FLOAT, IN `p_almacen` INT)   BEGIN
        INSERT INTO kardex (codigo_producto, almacen, fecha, concepto, comprobante, in_unidades, in_costo_unitario, in_costo_total, ex_unidades, ex_costo_unitario, ex_costo_total)
        VALUES (p_codigo_producto,p_almacen,CURDATE(), p_concepto, p_comprobante, p_unidades, p_costo_unitario, p_costo_total, p_unidades, p_costo_unitario, p_costo_total);
    END;
    SQL);

    DB::unprepared(<<<SQL
            CREATE PROCEDURE `prc_registrar_kardex_producto_existencia` (IN `p_id_producto` INT, IN `p_codigo_producto` VARCHAR(255), IN `p_almacen` INT, IN `p_almacenDestino` INT, IN `p_concepto` VARCHAR(255), IN `p_comprobante` VARCHAR(255), IN `p_centro_costo` INT, IN `p_descripcion_centro_costo` VARCHAR(150), IN `p_unidades` FLOAT, IN `p_costo_unitario` FLOAT, IN `p_costo_total` FLOAT)   BEGIN
        -- VARIABLES PARA EXISTENCIAS ACTUALES
        DECLARE v_unidades_ex FLOAT DEFAULT 0;
        DECLARE v_costo_unitario_ex FLOAT DEFAULT 0;
        DECLARE v_costo_total_ex FLOAT DEFAULT 0;

        -- OBTENER LAS ÚLTIMAS EXISTENCIAS DEL PRODUCTO EN EL ALMACÉN
        SELECT ex_unidades, ex_costo_unitario, ex_costo_total
        INTO v_unidades_ex, v_costo_unitario_ex, v_costo_total_ex
        FROM kardex
        WHERE id_producto = p_id_producto AND almacen = p_almacen
        ORDER BY id DESC
        LIMIT 1;

        -- CALCULAR NUEVAS EXISTENCIAS
        SET v_unidades_ex = v_unidades_ex + p_unidades;
        SET v_costo_total_ex = v_costo_total_ex + p_costo_total;

        IF v_unidades_ex > 0 THEN
            SET v_costo_unitario_ex = ROUND(v_costo_total_ex / v_unidades_ex, 2);
        ELSE
            SET v_costo_unitario_ex = 0;
        END IF;

        -- INSERTAR EL NUEVO REGISTRO EN EL KARDEX
        INSERT INTO kardex (
            id_producto, 
            codigo_producto, 
            almacen, 
            almacenDestino,
            fecha, 
            concepto, 
            comprobante, 
            centro_costo, 
            descripcion_centro_costo,
            ex_unidades, 
            ex_costo_unitario, 
            ex_costo_total
        )
        VALUES (
            p_id_producto,
            p_codigo_producto,
            p_almacen,
            p_almacenDestino,
            CURDATE(),
            p_concepto,
            p_comprobante,
            p_centro_costo,
            p_descripcion_centro_costo,
            v_unidades_ex,
            v_costo_unitario_ex,
            v_costo_total_ex
        );

        -- ACTUALIZAR EL STOCK Y LOS COSTOS DEL PRODUCTO
        UPDATE producto
        SET stock = v_unidades_ex,
            costo_unitario = v_costo_unitario_ex,
            costo_total = v_costo_total_ex
        WHERE id = p_id_producto AND id_almacen = p_almacen;
    END;
    SQL);

    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_registrar_kardex_producto_salida` (IN `p_id_producto` INT, IN `p_codigo_producto` VARCHAR(255), IN `p_almacen` INT, IN `p_almacenDestino` INT, IN `p_concepto` VARCHAR(255), IN `p_comprobante` VARCHAR(255), IN `p_centro_costo` INT, IN `p_descripcion_centro_costo` VARCHAR(150), IN `p_unidades` FLOAT, IN `p_costo_unitario` FLOAT, IN `p_costo_total` FLOAT)   BEGIN
            -- Variables para las existencias actuales
            DECLARE v_unidades_ex FLOAT DEFAULT 0;
            DECLARE v_costo_unitario_ex FLOAT DEFAULT 0;
            DECLARE v_costo_total_ex FLOAT DEFAULT 0;

            -- Obtener las últimas existencias del producto en el almacén
            SELECT ex_unidades, ex_costo_unitario, ex_costo_total
            INTO v_unidades_ex, v_costo_unitario_ex, v_costo_total_ex
            FROM kardex
            WHERE id_producto = p_id_producto AND almacen = p_almacen
            ORDER BY id DESC
            LIMIT 1;

            -- Calcular nuevas existencias
            SET v_unidades_ex = v_unidades_ex - p_unidades;
            SET v_costo_total_ex = v_costo_total_ex - p_costo_total;

            IF v_unidades_ex > 0 THEN
                SET v_costo_unitario_ex = ROUND(v_costo_total_ex / v_unidades_ex, 2);
            ELSE
                SET v_costo_unitario_ex = 0;
            END IF;

            -- Insertar el nuevo registro en el Kardex
            INSERT INTO kardex (
                id_producto, 
                codigo_producto, 
                almacen, 
                almacenDestino,
                fecha, 
                concepto, 
                comprobante, 
                centro_costo, 
                descripcion_centro_costo,
                out_unidades, 
                out_costo_unitario, 
                out_costo_total, 
                ex_unidades, 
                ex_costo_unitario, 
                ex_costo_total
            )
            VALUES (
                p_id_producto,
                p_codigo_producto,
                p_almacen,
                p_almacenDestino,
                CURDATE(),
                p_concepto,
                p_comprobante,
                p_centro_costo,
                p_descripcion_centro_costo,
                p_unidades,
                p_costo_unitario,
                p_costo_total,
                v_unidades_ex,
                v_costo_unitario_ex,
                v_costo_total_ex
            );

            -- Actualizar el stock y los costos del producto
            UPDATE producto
            SET stock = v_unidades_ex,
                costo_unitario = v_costo_unitario_ex,
                costo_total = v_costo_total_ex
            WHERE id = p_id_producto AND id_almacen = p_almacen;
        END;
    SQL);

    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_registrar_kardex_vencido` (IN `p_codigo_producto` VARCHAR(20), IN `p_concepto` VARCHAR(100), IN `p_nuevo_stock` FLOAT)   BEGIN

        declare v_unidades_ex float;
        declare v_costo_unitario_ex float;    
        declare v_costo_total_ex float;

        declare v_unidades_out float;
        declare v_costo_unitario_out float;    
        declare v_costo_total_out float;
        declare v_almacen INT;    

        /* OBTENEMOS EL ALMACÉN MÁS RECIENTE PARA EL PRODUCTO */
        SELECT almacen
        INTO v_almacen
        FROM kardex
        WHERE codigo_producto = p_codigo_producto
        ORDER BY id DESC
        LIMIT 1;

        /*OBTENEMOS LAS ULTIMAS EXISTENCIAS DEL PRODUCTO*/    
        SELECT k.ex_costo_unitario , k.ex_unidades, k.ex_costo_total
        into v_costo_unitario_ex, v_unidades_ex, v_costo_total_ex
        FROM kardex k
        WHERE k.codigo_producto = p_codigo_producto
        AND k.almacen = v_almacen
        ORDER BY ID DESC
        LIMIT 1;

        /*SETEAMOS LOS VALORES PARA EL REGISTRO DE SALIDA*/
        SET v_unidades_out = v_unidades_ex - p_nuevo_stock;
        SET v_costo_unitario_out = v_costo_unitario_ex;
        SET v_costo_total_out = v_unidades_out * v_costo_unitario_out;

        /*SETEAMOS LAS EXISTENCIAS ACTUALES*/
        SET v_unidades_ex = ROUND(p_nuevo_stock,2);    
        SET v_costo_total_ex = ROUND(v_costo_total_ex - v_costo_total_out,2);

        IF(v_costo_total_ex > 0) THEN
            SET v_costo_unitario_ex = ROUND(v_costo_total_ex/v_unidades_ex,2);
        else
            SET v_costo_unitario_ex = ROUND(0,2);
        END IF;

            
        INSERT INTO kardex(codigo_producto,
                            almacen,
                            fecha,
                            concepto,
                            comprobante,
                            out_unidades,
                            out_costo_unitario,
                            out_costo_total,
                            ex_unidades,
                            ex_costo_unitario,
                            ex_costo_total)
                    VALUES(p_codigo_producto,
                            v_almacen,
                            curdate(),
                            p_concepto,
                            '',
                            v_unidades_out,
                            v_costo_unitario_out,
                            v_costo_total_out,
                            v_unidades_ex,
                            v_costo_unitario_ex,
                            v_costo_total_ex);

        /*ACTUALIZAMOS EL STOCK, EL NRO DE VENTAS DEL PRODUCTO*/
        UPDATE producto 
        SET stock = v_unidades_ex, 
            costo_unitario = v_costo_unitario_ex,
            costo_total = v_costo_total_ex
        WHERE codigo_productos = p_codigo_producto
        AND id_almacen = v_almacen;                       

        END;
    SQL);

    DB::unprepared(<<<SQL
        CREATE PROCEDURE `prc_variacion_precio_Dashboard` (IN `anio` INT, IN `codigo_producto` VARCHAR(50), IN `id_almacen` INT)   BEGIN
            SELECT 
                DATE(k.fecha) AS fecha,
                k.codigo_producto,
                k.ex_costo_unitario AS costo_existente,
                k.in_costo_unitario AS costo_ingreso,
                LAG(k.ex_costo_unitario) OVER (PARTITION BY k.codigo_producto, k.almacen ORDER BY k.fecha) AS costo_anterior,
                (k.ex_costo_unitario - LAG(k.ex_costo_unitario) OVER (PARTITION BY k.codigo_producto, k.almacen ORDER BY k.fecha)) AS variacion_absoluta,
                ((k.ex_costo_unitario - LAG(k.ex_costo_unitario) OVER (PARTITION BY k.codigo_producto, k.almacen ORDER BY k.fecha)) /
                LAG(k.ex_costo_unitario) OVER (PARTITION BY k.codigo_producto, k.almacen ORDER BY k.fecha)) * 100 AS variacion_porcentual
            FROM 
                kardex k
            WHERE 
                YEAR(k.fecha) = anio
                AND k.codigo_producto = codigo_producto COLLATE utf8mb4_unicode_ci
                AND k.almacen = id_almacen
                AND k.concepto NOT LIKE 'Devolución%' COLLATE utf8mb4_unicode_ci
                AND k.ex_costo_unitario IS NOT NULL
            ORDER BY 
                k.fecha;
        END;
    SQL);

}


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_actualizar_kardex_producto_existencia`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_conteo_Devolucion_dashboard`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_conteo_ingresos_dashboard`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_conteo_salidas_Dashboard`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_conteo_total_productos_poco_stock_Dashboard`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_devolucion_kardex_producto_salida`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_kardex_quincenas_Dashboard`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_ListarCargasMasivas`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_ListarPerfilesAsignar`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_ListarProductos`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_ListarProductosModelosreq`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_listar_cantidad_total_Preciosxproductos_usuario_Dashboard`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_listar_cantidad_total_productos_usuarioAct_Dashboard`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_listar_Kardex`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_obtener_productos_poco_stock`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_registrar_kardex_bono`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_registrar_kardex_existencias`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_registrar_kardex_producto_existencia`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_registrar_kardex_producto_salida`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_registrar_kardex_vencido`;");
        DB::unprepared("DROP PROCEDURE IF EXISTS `prc_variacion_precio_Dashboard`;");
    }
    

};

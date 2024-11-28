<?php
require_once 'BaseModel.php';

class Compras extends BaseModel
{
    public function getComprasNormalesByDate($date)
    {
        $sql = "SELECT 
                cn.descripcion_compra AS nombre,
                cn.cantidad AS cantidad,
                cn.costo_unitario AS costo_unitario,
                cn.total AS total,
                cn.fecha AS fecha,
                cn.metodo_pago AS metodo_pago
            FROM compras_normales cn
            WHERE cn.fecha = :date";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getComprasConsumiblesByDate($date)
    {
        $sql = "SELECT 
                c.nombre AS nombre,
                cc.cantidad AS cantidad,
                cc.costo_unitario AS costo_unitario,
                cc.total AS total,
                cc.fecha_ingreso AS fecha,
                cc.metodo_pago AS metodo_pago
            FROM compras_consumibles cc
            INNER JOIN consumibles c ON c.id = cc.consumible_id
            WHERE cc.fecha_ingreso = :date";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllCategorias()
    {
        $sql = "SELECT * FROM categorias";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getConsumiblesPorCategoria($categoriaId)
    {
        try {
            $sql = "
                SELECT c.id, 
                       c.nombre, 
                       l.cantidad AS stock, 
                       l.precio_unitario AS precio,
                       l.fecha_vencimiento,
                       c.es_compuesto 
                FROM consumibles c
                LEFT JOIN compras_consumibles cc ON c.id = cc.consumible_id
                LEFT JOIN lotes l ON cc.id = l.compras_consumibles_id
                WHERE c.categoria_id = :categoriaId AND c.es_compuesto = 0
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':categoriaId', $categoriaId, PDO::PARAM_INT);
            $stmt->execute();

            $consumibles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($consumibles as &$consumible) {
                $consumible['precio'] = (float) $consumible['precio'];
                $consumible['stock'] = (int) $consumible['stock'];
            }

            return $consumibles;
        } catch (Exception $e) {
            error_log("Error al obtener consumibles por categoría: " . $e->getMessage());
            return [];
        }
    }
    public function registrarCompraNormal($descripcion_compra, $cantidad, $costo_unitario, $total, $fecha, $proveedor, $metodoPago, $observacion)
    {
        try {
            $sql = "INSERT INTO compras_normales (descripcion_compra, cantidad, costo_unitario, total, fecha, proveedor, metodo_pago, observacion)
                    VALUES (:descripcion_compra, :cantidad, :costo_unitario, :total, :fecha, :proveedor, :metodo_pago, :observacion)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':descripcion_compra', $descripcion_compra);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':costo_unitario', $costo_unitario);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':proveedor', $proveedor);
            $stmt->bindParam(':metodo_pago', $metodoPago);
            $stmt->bindParam(':observacion', $observacion);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar la compra normal: " . $e->getMessage());
            return false;
        }
    }
    public function registrarCompraConsumibles($productos, $metodoPago)
    {
        try {
            $this->db->beginTransaction();

            foreach ($productos as $producto) {
                if (!isset($producto['id']) || empty($producto['id'])) {
                    throw new Exception("ID de producto no especificado.");
                }
                $id = $producto['id'];
                $cantidad = isset($producto['cantidad']) ? $producto['cantidad'] : 0;
                $costoTotal = isset($producto['costo_total']) ? $producto['costo_total'] : 0;
                $precioUnitario = isset($producto['precio_unitario']) ? $producto['precio_unitario'] : 0;
                $fechaIngreso = isset($producto['fecha_ingreso']) ? $producto['fecha_ingreso'] : date('Y-m-d');
                $fechaVencimiento = isset($producto['fecha_vencimiento']) ? $producto['fecha_vencimiento'] : null;

                // Verificar si el consumible existe en la base de datos
                $sqlCheckConsumible = "SELECT id FROM consumibles WHERE id = :id";
                $stmtCheck = $this->db->prepare($sqlCheckConsumible);
                $stmtCheck->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtCheck->execute();
                $exists = $stmtCheck->fetch();

                if (!$exists) {
                    throw new Exception("El consumible con ID $id no existe.");
                }
                error_log("Insertando compra para consumible ID $id con cantidad: $cantidad, costo total: $costoTotal, precio unitario: $precioUnitario");

                // Insertar en la tabla `compras_consumibles`
                $sqlCompra = "INSERT INTO compras_consumibles (consumible_id, cantidad, costo_unitario, total, fecha_ingreso, fecha_vencimiento, metodo_pago)
                          VALUES (:consumible_id, :cantidad, :precio_unitario, :costo_total, :fecha_ingreso, :fecha_vencimiento, :metodo_pago)";
                $stmtCompra = $this->db->prepare($sqlCompra);
                $stmtCompra->bindParam(':consumible_id', $id, PDO::PARAM_INT);
                $stmtCompra->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
                $stmtCompra->bindParam(':precio_unitario', $precioUnitario, PDO::PARAM_STR);
                $stmtCompra->bindParam(':costo_total', $costoTotal, PDO::PARAM_STR);
                $stmtCompra->bindParam(':fecha_ingreso', $fechaIngreso);
                $stmtCompra->bindParam(':fecha_vencimiento', $fechaVencimiento);
                $stmtCompra->bindParam(':metodo_pago', $metodoPago);

                if (!$stmtCompra->execute()) {
                    throw new Exception("Error al registrar la compra de consumible $id.");
                }

                $compraConsumibleId = $this->db->lastInsertId();

                // Insertar el nuevo lote
                $sqlLote = "INSERT INTO lotes (compras_consumibles_id, cantidad, costo_total, precio_unitario, fecha_ingreso, fecha_vencimiento)
                        VALUES (:compras_consumibles_id, :cantidad, :costo_total, :precio_unitario, :fecha_ingreso, :fecha_vencimiento)";
                $stmtLote = $this->db->prepare($sqlLote);
                $stmtLote->bindParam(':compras_consumibles_id', $compraConsumibleId, PDO::PARAM_INT);
                $stmtLote->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
                $stmtLote->bindParam(':costo_total', $costoTotal, PDO::PARAM_STR);
                $stmtLote->bindParam(':precio_unitario', $precioUnitario, PDO::PARAM_STR);
                $stmtLote->bindParam(':fecha_ingreso', $fechaIngreso);
                $stmtLote->bindParam(':fecha_vencimiento', $fechaVencimiento);

                if (!$stmtLote->execute()) {
                    throw new Exception("Error al registrar el lote para la compra de consumible $id.");
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Error al registrar la compra: " . $e->getMessage());
            return false;
        }
    }
}

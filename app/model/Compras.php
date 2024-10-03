<?php
require_once 'BaseModel.php';

class Compras extends BaseModel {

    // Obtener compras por fecha
    public function getComprasByDate($date) {
        $sql = "SELECT * FROM compras_normales WHERE fecha = :date ORDER BY fecha DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener total por método de pago
    public function getTotalPorMetodoPago($date) {
        $sql = "SELECT metodo_pago, SUM(total) as total_por_metodo
                FROM compras_normales
                WHERE fecha  = :date
                GROUP BY metodo_pago";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener todas las categorías
    public function getAllCategorias() {
        $sql = "SELECT * FROM categorias";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear compra normal
    public function createCompraNormal($descripcion, $cantidad, $costo_unitario, $total, $fecha, $proveedor, $metodo_pago, $observacion) {
        $sql = "INSERT INTO compras_normales (descripcion_compra, cantidad, costo_unitario, total, fecha, proveedor, metodo_pago, observacion) 
                VALUES (:descripcion, :cantidad, :costo_unitario, :total, :fecha, :proveedor, :metodo_pago, :observacion)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':descripcion' => $descripcion,
            ':cantidad' => $cantidad,
            ':costo_unitario' => $costo_unitario,
            ':total' => $total,
            ':fecha' => $fecha,
            ':proveedor' => $proveedor,
            ':metodo_pago' => $metodo_pago,
            ':observacion' => $observacion
        ]);
    }

    // Crear compra de consumibles
    public function createCompraConsumible($consumible_id, $cantidad, $costo_unitario, $total, $fecha_ingreso, $fecha_vencimiento) {
        $sql = "INSERT INTO compras_consumibles (consumible_id, cantidad, costo_unitario, total, fecha_ingreso, fecha_vencimiento) 
                VALUES (:consumible_id, :cantidad, :costo_unitario, :total, :fecha_ingreso, :fecha_vencimiento)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':consumible_id' => $consumible_id,
            ':cantidad' => $cantidad,
            ':costo_unitario' => $costo_unitario,
            ':total' => $total,
            ':fecha_ingreso' => $fecha_ingreso,
            ':fecha_vencimiento' => $fecha_vencimiento
        ]);
        return $this->db->lastInsertId(); 
    }

    // Crear lote
    public function createLote($compras_consumibles_id, $lote, $cantidad, $costo_unitario, $precio_unitario, $fecha_ingreso, $fecha_vencimiento) {
        $sql = "INSERT INTO lotes (compras_consumibles_id, lote, cantidad, costo_unitario, precio_unitario, fecha_ingreso, fecha_vencimiento) 
                VALUES (:compras_consumibles_id, :lote, :cantidad, :costo_unitario, :precio_unitario, :fecha_ingreso, :fecha_vencimiento)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':compras_consumibles_id' => $compras_consumibles_id,
            ':lote' => $lote,
            ':cantidad' => $cantidad,
            ':costo_unitario' => $costo_unitario,
            ':precio_unitario' => $precio_unitario,
            ':fecha_ingreso' => $fecha_ingreso,
            ':fecha_vencimiento' => $fecha_vencimiento
        ]);
    }

    // Actualizar el stock del consumible
    public function updateStockConsumible($consumible_id, $cantidad) {
        $sql = "UPDATE consumibles SET stock = stock + :cantidad WHERE id = :consumible_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':cantidad' => $cantidad,
            ':consumible_id' => $consumible_id
        ]);
    }
    

    // Obtener consumibles por categoría
    public function getConsumiblesPorCategoria($categoriaId) {
        $query = "SELECT *
                  FROM consumibles c 
                  JOIN consumibles_categorias cc ON c.id = cc.consumible_id 
                  WHERE cc.categoria_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$categoriaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>

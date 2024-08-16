<?php
require_once 'BaseModel.php';
class Compras extends BaseModel {

    public function getAllCompras() {
        $sql = "SELECT * FROM compras ORDER BY fecha DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getComprasByDate($date) {
        $sql = "SELECT * FROM compras WHERE fecha = :date ORDER BY fecha DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCompra($descripcion, $cantidad, $costo_unitario, $total, $fecha, $proveedor = null, $metodo_pago = null, $observacion = null) {
        $sql = "INSERT INTO compras (descripcion_compra, cantidad, costo_unitario, total, fecha, proveedor, metodo_pago, observacion)
                VALUES (:descripcion, :cantidad, :costo_unitario, :total, :fecha, :proveedor, :metodo_pago, :observacion)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':costo_unitario', $costo_unitario);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':proveedor', $proveedor);
        $stmt->bindParam(':metodo_pago', $metodo_pago);
        $stmt->bindParam(':observacion', $observacion);
        $stmt->execute();
    }
}

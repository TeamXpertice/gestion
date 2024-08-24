<?php
require_once 'BaseModel.php';

class Compras extends BaseModel {

    public function getAllCompras() {
        $sql = "SELECT * FROM compras ORDER BY fecha_compra DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getComprasByDate($date) {
        $sql = "SELECT * FROM compras WHERE fecha_compra = :date ORDER BY fecha_compra DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCompra($descripcion, $cantidad, $costo_unitario, $total, $fecha, $proveedor = null, $metodo_pago = null, $observacion = null) {
        $sql = "INSERT INTO compras (descripcion_compra, cantidad, costo_unitario, total, fecha_compra, proveedor, metodo_pago, observacion)
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

    public function getCompraById($id) {
        $sql = "SELECT * FROM compras WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTotalPorMetodoPago($date) {
        $sql = "SELECT metodo_pago, SUM(total) as total_por_metodo
                FROM compras
                WHERE fecha_compra = :date
                GROUP BY metodo_pago";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategorias() {
        $sql = "SELECT * FROM categorias";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConsumiblesPorCategoria($categoriaId) {
        $sql = "SELECT * FROM consumibles WHERE categoria_id = :categoriaId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':categoriaId', $categoriaId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

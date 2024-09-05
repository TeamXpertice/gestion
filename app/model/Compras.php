<?php
require_once 'BaseModel.php';

class Compras extends BaseModel {

    public function getAllCompras() {
        $sql = "SELECT * FROM compras ORDER BY fecha_compra DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllCategorias() {
        $sql = "SELECT * FROM categorias";
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
    public function registrarCompraConsumible($consumible_id, $cantidad, $costo_unitario, $fecha, $observacion, $proveedor, $metodo_pago) {
        $query = "SELECT nombre FROM consumibles WHERE id = :consumible_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':consumible_id', $consumible_id, PDO::PARAM_INT);
        $stmt->execute();
        $consumible = $stmt->fetch(PDO::FETCH_ASSOC);
        $nombre_consumible = $consumible['nombre'] ?? 'Compra de consumible';
    
        $sql = "INSERT INTO compras (descripcion_compra, cantidad, costo_unitario, total, fecha_compra, proveedor, metodo_pago, observacion)
                VALUES (:descripcion, :cantidad, :costo_unitario, :total, :fecha, :proveedor, :metodo_pago, :observacion)";
        $stmt = $this->db->prepare($sql);
        $total = $cantidad * $costo_unitario;
        $stmt->bindParam(':descripcion', $nombre_consumible);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':costo_unitario', $costo_unitario);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':proveedor', $proveedor);
        $stmt->bindParam(':metodo_pago', $metodo_pago);
        $stmt->bindParam(':observacion', $observacion);
        return $stmt->execute();
    }
    public function registrarCompraNormal($descripcion, $cantidad, $costo_unitario, $fecha, $proveedor, $metodo_pago, $observacion) {
        try {
            $sql = "INSERT INTO compras_normales (descripcion, cantidad, costo_unitario, fecha, proveedor, metodo_pago, observacion)
                    VALUES (:descripcion, :cantidad, :costo_unitario, :fecha, :proveedor, :metodo_pago, :observacion)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':costo_unitario', $costo_unitario);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':proveedor', $proveedor);
            $stmt->bindParam(':metodo_pago', $metodo_pago);
            $stmt->bindParam(':observacion', $observacion);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Error al registrar compra normal: ' . $e->getMessage());
            return false;
        }
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
    public function getConsumiblesPorCategoria($categoriaId) {
        $query = "SELECT *
                  FROM consumibles c 
                  JOIN consumibles_categorias cc ON c.id = cc.consumible_id 
                  WHERE cc.categoria_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$categoriaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function reponerStock($consumible_id, $cantidad) {
        $sql = "UPDATE consumibles SET stock = stock + :cantidad WHERE id = :consumible_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':consumible_id', $consumible_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>

<?php
require_once 'BaseModel.php';

class Perdidas extends BaseModel {

    public function obtenerConsumiblesPorCategoria($categoria_id) {
        $sql = "SELECT * FROM consumibles WHERE categoria_id = :categoria_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->execute();
        $consumibles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $consumibles;
    }

    public function registrarPerdida($consumible_id, $cantidad, $tipo, $descripcion, $fecha) {
        $sql = "INSERT INTO perdidas (consumible_id, cantidad, tipo, descripcion, fecha)
                VALUES (:consumible_id, :cantidad, :tipo, :descripcion, :fecha)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':consumible_id' => $consumible_id,
            ':cantidad' => $cantidad,
            ':tipo' => $tipo,
            ':descripcion' => $descripcion,
            ':fecha' => $fecha
        ]);

        return $stmt->rowCount() > 0;
    }
}
?>

<?php
require_once 'BaseModel.php';

class Dashboard extends BaseModel {

    public function obtenerProductosPorVencer($limite = 3) {
        $hoy = date('Y-m-d');
        $pasadoManana = date('Y-m-d', strtotime('+2 days'));
    
        $sql = "SELECT nombre, fecha_vencimiento, stock FROM consumibles 
                WHERE fecha_vencimiento BETWEEN :hoy AND :pasadoManana
                AND stock > 0
                LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':hoy', $hoy);
        $stmt->bindParam(':pasadoManana', $pasadoManana);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>

<?php
require_once 'BaseModel.php';
class ConsumiblesVencidos extends BaseModel {

    // Función para reducir el stock de productos vencidos a 0
    public function reducirStockProductosVencidos() {
        $fechaHoy = date('Y-m-d');  // Fecha actual
        $sql = "UPDATE consumibles 
                SET stock = 0 
                WHERE fecha_vencimiento < :fechaHoy AND stock > 0";  // Reducir el stock solo si aún hay stock
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':fechaHoy', $fechaHoy);
        $stmt->execute();
    }


}   

<?php
require_once 'BaseModel.php';
class ConsumiblesVencidos extends BaseModel {
    public function reducirStockProductosVencidos() {
        $fechaHoy = date('Y-m-d'); 
        $sql = "UPDATE consumibles 
                SET stock = 0 
                WHERE fecha_vencimiento < :fechaHoy AND stock > 0"; 
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':fechaHoy', $fechaHoy);
        $stmt->execute();
    }


}   

<?php
require_once 'BaseModel.php';

class Dashboard extends BaseModel {

    // Obtener las compras por mes
 // Obtener las compras por mes y año
public function getComprasPorMes() {
    $sql = "SELECT YEAR(fecha_ingreso) AS anio, MONTH(fecha_ingreso) AS mes, SUM(total) AS total_compras
            FROM compras_consumibles
            GROUP BY YEAR(fecha_ingreso), MONTH(fecha_ingreso)
            ORDER BY YEAR(fecha_ingreso), MONTH(fecha_ingreso)";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener las ventas por mes y año
public function getVentasPorMes() {
    $sql = "SELECT YEAR(fecha) AS anio, MONTH(fecha) AS mes, SUM(total) AS total_ventas
            FROM ventas
            GROUP BY YEAR(fecha), MONTH(fecha)
            ORDER BY YEAR(fecha), MONTH(fecha)";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
?>

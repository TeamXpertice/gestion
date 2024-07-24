<?php
require_once 'BaseModel.php';

class Arsenal extends BaseModel {
    
    public function getBienes() {
        $stmt = $this->db->query("SELECT * FROM bienes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConsumibles() {
        $stmt = $this->db->query("SELECT * FROM consumibles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createBien($nombre, $descripcion_bien, $nombre_proveedor, $modelo, $serie_codigo, $marca, $unidad_medida, $tamano, $color, $tipo_material, $estado_fisico_actual, $observacion) {
        try {
            $sql = "INSERT INTO bienes 
                    (nombre, descripcion_bien, nombre_proveedor, modelo, serie_codigo, marca, unidad_medida, tamano, color, tipo_material, estado_fisico_actual, observacion) 
                    VALUES 
                    (:nombre, :descripcion_bien, :nombre_proveedor, :modelo, :serie_codigo, :marca, :unidad_medida, :tamano, :color, :tipo_material, :estado_fisico_actual, :observacion)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nombre' => $nombre,
                ':descripcion_bien' => $descripcion_bien,
                ':nombre_proveedor' => $nombre_proveedor,
                ':modelo' => $modelo,
                ':serie_codigo' => $serie_codigo,
                ':marca' => $marca,
                ':unidad_medida' => $unidad_medida,
                ':tamano' => $tamano,
                ':color' => $color,
                ':tipo_material' => $tipo_material,
                ':estado_fisico_actual' => $estado_fisico_actual,
                ':observacion' => $observacion
            ]);
    
            return true; 
        } catch (PDOException $e) {
            echo "Error al insertar el bien: " . $e->getMessage();
            return false; 
        }
    }
    

 public function updateBien($id, $nombre, $descripcion_bien, $nombre_proveedor, $modelo, $serie_codigo, $marca, $unidad_medida, $tamano, $color, $tipo_material, $estado_fisico_actual, $observacion) {
        $sql = "UPDATE bienes SET 
                    nombre = :nombre, 
                    descripcion_bien = :descripcion_bien,
                    nombre_proveedor = :nombre_proveedor,
                    modelo = :modelo,
                    serie_codigo = :serie_codigo,
                    marca = :marca,
                    unidad_medida = :unidad_medida,
                    tamano = :tamano,
                    color = :color,
                    tipo_material = :tipo_material,
                    estado_fisico_actual = :estado_fisico_actual,
                    observacion = :observacion
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
            'descripcion_bien' => $descripcion_bien,
            'nombre_proveedor' => $nombre_proveedor,
            'modelo' => $modelo,
            'serie_codigo' => $serie_codigo,
            'marca' => $marca,
            'unidad_medida' => $unidad_medida,
            'tamano' => $tamano,
            'color' => $color,
            'tipo_material' => $tipo_material,
            'estado_fisico_actual' => $estado_fisico_actual,
            'observacion' => $observacion
        ]);
    }
    
    public function createConsumible($nombre, $descripcion_consumible, $nombre_proveedor, $modelo, $serie_codigo, $marca, $unidad_medida, $tamano, $color, $tipo_material, $estado_fisico_actual, $observacion, $fecha_vencimiento, $lote) {
        try {
            $sql = "INSERT INTO consumibles 
                    (nombre, descripcion_consumible, nombre_proveedor, modelo, serie_codigo, marca, unidad_medida, tamano, color, tipo_material, estado_fisico_actual, observacion, fecha_vencimiento, lote) 
                    VALUES 
                    (:nombre, :descripcion_consumible, :nombre_proveedor, :modelo, :serie_codigo, :marca, :unidad_medida, :tamano, :color, :tipo_material, :estado_fisico_actual, :observacion, :fecha_vencimiento, :lote)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nombre' => $nombre,
                ':descripcion_consumible' => $descripcion_consumible,
                ':nombre_proveedor' => $nombre_proveedor,
                ':modelo' => $modelo,
                ':serie_codigo' => $serie_codigo,
                ':marca' => $marca,
                ':unidad_medida' => $unidad_medida,
                ':tamano' => $tamano,
                ':color' => $color,
                ':tipo_material' => $tipo_material,
                ':estado_fisico_actual' => $estado_fisico_actual,
                ':observacion' => $observacion,
                ':fecha_vencimiento' => $fecha_vencimiento,
                ':lote' => $lote
            ]);
    
            return true; 
        } catch (PDOException $e) {
            echo "Error al insertar el consumible: " . $e->getMessage();
            return false; 
        }
    }
    
    public function updateConsumible($id, $nombre, $descripcion_consumible, $nombre_proveedor, $modelo, $serie_codigo, $marca, $unidad_medida, $tamano, $color, $tipo_material, $estado_fisico_actual, $observacion, $fecha_vencimiento, $lote) {
        $sql = "UPDATE consumibles SET 
                    nombre = :nombre, 
                    descripcion_consumible = :descripcion_consumible,
                    nombre_proveedor = :nombre_proveedor,
                    modelo = :modelo,
                    serie_codigo = :serie_codigo,
                    marca = :marca,
                    unidad_medida = :unidad_medida,
                    tamano = :tamano,
                    color = :color,
                    tipo_material = :tipo_material,
                    estado_fisico_actual = :estado_fisico_actual,
                    observacion = :observacion,
                    fecha_vencimiento = :fecha_vencimiento,
                    lote = :lote
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
            'descripcion_consumible' => $descripcion_consumible,
            'nombre_proveedor' => $nombre_proveedor,
            'modelo' => $modelo,
            'serie_codigo' => $serie_codigo,
            'marca' => $marca,
            'unidad_medida' => $unidad_medida,
            'tamano' => $tamano,
            'color' => $color,
            'tipo_material' => $tipo_material,
            'estado_fisico_actual' => $estado_fisico_actual,
            'observacion' => $observacion,
            'fecha_vencimiento' => $fecha_vencimiento,
            'lote' => $lote
        ]);
    }
    

    public function deleteBien($id) {
        $stmt = $this->db->prepare("DELETE FROM bienes WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function deleteConsumible($id) {
        $stmt = $this->db->prepare("DELETE FROM consumibles WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getBienById($id) {
        $stmt = $this->db->prepare("SELECT * FROM bienes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getConsumibleById($id) {
        $stmt = $this->db->prepare("SELECT * FROM consumibles WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

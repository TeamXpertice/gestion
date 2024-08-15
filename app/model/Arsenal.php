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

    public function getVentas() {
        $stmt = $this->db->query("SELECT * FROM ventas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVentasPorFecha($selectedDate) {
        $sql = "
            SELECT 
                c.nombre as nombre,
                vd.cantidad as cantidad,
                v.total as total,
                v.fecha as fecha
            FROM ventas v
            JOIN ventas_detalles vd ON v.id = vd.venta_id
            JOIN consumibles c ON vd.consumible_id = c.id
            WHERE v.fecha = :selectedDate
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':selectedDate', $selectedDate);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function showVentaConsumible($id) {
        $consumible = $this->getConsumibleById($id);
        include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/arsenal/showVentasRegistradas.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/arsenal/ventaConsumible.php';
    }

    public function getAllCategorias() {
        $sql = "SELECT * FROM categorias";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllConsumibles() {
        $sql = "SELECT * FROM consumibles";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getConsumiblesPorCategoria($categoriaId) {
        try {
            $sql = "SELECT c.id, c.nombre, c.stock, c.precio 
                    FROM consumibles c
                    INNER JOIN consumibles_categorias cc ON c.id = cc.consumible_id
                    WHERE cc.categoria_id = :categoria_id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':categoria_id' => $categoriaId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching consumibles by category: " . $e->getMessage());
            return []; 
        }
    }

    
    
    
    public function createVentaConsumible($idConsumible, $cantidad) {
        $consumible = $this->getConsumibleById($idConsumible);

        if ($consumible && $consumible['stock'] >= $cantidad) {
            $nuevoStock = $consumible['stock'] - $cantidad;
            $this->updateConsumibleStock($idConsumible, $nuevoStock);

            $precio = $consumible['precio'];
            $total = $cantidad * $precio;

            $sql = "INSERT INTO ventas (nombre, cantidad, total, fecha) VALUES (:nombre, :cantidad, :total, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nombre' => $consumible['nombre'],
                ':cantidad' => $cantidad,
                ':total' => $total
            ]);

            return true;
        } else {
            return false;
        }
    }
    public function insertVenta($total) {
        $sql = "INSERT INTO ventas (total, fecha) VALUES (:total, CURDATE())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':total', $total, PDO::PARAM_STR);
    
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
    public function insertVentaDetalle($ventaId, $consumibleId, $cantidad, $precioUnitario) {
        $sql = "INSERT INTO ventas_detalles (venta_id, consumible_id, cantidad, precio_unitario) 
                VALUES (:venta_id, :consumible_id, :cantidad, :precio_unitario)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':venta_id', $ventaId, PDO::PARAM_INT);
        $stmt->bindParam(':consumible_id', $consumibleId, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':precio_unitario', $precioUnitario, PDO::PARAM_STR);
    
        return $stmt->execute();
    }
    
    public function getStockConsumible($consumibleId) {
        $sql = "SELECT stock FROM consumibles WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $consumibleId, PDO::PARAM_INT);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['stock'] : 0;
    }
    public function updateStockConsumible($consumibleId, $nuevoStock) {
        $sql = "UPDATE consumibles SET stock = :stock WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':stock', $nuevoStock, PDO::PARAM_INT);
        $stmt->bindParam(':id', $consumibleId, PDO::PARAM_INT);
    
        return $stmt->execute();
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
            error_log("Error inserting bien: " . $e->getMessage());
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
    
    public function createConsumible($nombre, $descripcion_consumible, $nombre_proveedor, $modelo, $serie_codigo, $marca, $unidad_medida, $tamano, $color, $estado_fisico_actual, $observacion, $fecha_vencimiento, $lote, $precio, $stock) {
        try {
            $sql = "INSERT INTO consumibles 
                    (nombre, descripcion_consumible, nombre_proveedor, modelo, serie_codigo, marca, unidad_medida, tamano, color, estado_fisico_actual, observacion, fecha_vencimiento, lote, precio, stock) 
                    VALUES 
                    (:nombre, :descripcion_consumible, :nombre_proveedor, :modelo, :serie_codigo, :marca, :unidad_medida, :tamano, :color, :estado_fisico_actual, :observacion, :fecha_vencimiento, :lote, :precio, :stock)";
            
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
                ':estado_fisico_actual' => $estado_fisico_actual,
                ':observacion' => $observacion,
                ':fecha_vencimiento' => $fecha_vencimiento,
                ':lote' => $lote,
                ':precio' => $precio,  
                ':stock' => $stock    
            ]);
    
            return $this->db->lastInsertId(); 
        } catch (PDOException $e) {
            error_log("Error inserting consumible: " . $e->getMessage());
            return false; 
        }
    }
    
    
    
    public function assignCategoriasToConsumible($consumibleId, $categorias) {
        try {
            $this->db->beginTransaction();
    
            // Elimina las categorías actuales del consumible
            $sql = "DELETE FROM consumibles_categorias WHERE consumible_id = :consumible_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':consumible_id' => $consumibleId]);
    
            // Inserta las nuevas categorías
            $sql = "INSERT INTO consumibles_categorias (consumible_id, categoria_id) VALUES (:consumible_id, :categoria_id)";
            $stmt = $this->db->prepare($sql);
    
            foreach ($categorias as $categoriaId) {
                $stmt->execute([':consumible_id' => $consumibleId, ':categoria_id' => $categoriaId]);
            }
    
            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollBack();
            echo "Error al asignar categorías al consumible: " . $e->getMessage();
        }
    }

    
    public function updateConsumible($id, $nombre, $descripcion_consumible, $nombre_proveedor, $modelo, $serie_codigo, $marca, $unidad_medida, $tamano, $color, $estado_fisico_actual, $observacion, $fecha_vencimiento, $lote) {
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
            'estado_fisico_actual' => $estado_fisico_actual,
            'observacion' => $observacion,
            'fecha_vencimiento' => $fecha_vencimiento,
            'lote' => $lote
        ]);
    }
    


public function getLastInsertId() {
    return $this->db->lastInsertId();
}
public function addCategoria($nombre) {
    try {
        $sql = "INSERT INTO categorias (nombre) VALUES (:nombre)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nombre' => $nombre]);

        return $this->db->lastInsertId(); 
    } catch (PDOException $e) {
        echo "Error al agregar la categoría: " . $e->getMessage();
        return false; 
    }
}
    public function deleteBien($id) {
        $sql = "DELETE FROM bienes WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    public function deleteConsumible($id) {
        $sql = "DELETE FROM consumibles WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    public function getBienById($id) {
        $stmt = $this->db->prepare("SELECT * FROM bienes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getConsumibleById($id) {
        $stmt = $this->db->prepare("SELECT * FROM consumibles WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function updateConsumibleStock($id, $nuevoStock) {
        $stmt = $this->db->prepare("UPDATE consumibles SET stock = :stock WHERE id = :id");
        $stmt->execute([
            ':stock' => $nuevoStock,
            ':id' => $id
        ]);
    }
}

?>

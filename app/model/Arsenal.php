<?php
require_once 'BaseModel.php';

class Arsenal extends BaseModel
{

    public function getBienes()
    {
        $stmt = $this->db->query("SELECT * FROM bienes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConsumibles()
    {
        $stmt = $this->db->query("SELECT * FROM consumibles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function reabastecerStock($productoId, $cantidad) {
        $this->db->beginTransaction();
        
        try {
            // Actualizar stock
            $query = "UPDATE consumibles SET stock = stock + ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$cantidad, $productoId]);
            
            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    
    public function registrarVenta($productos, $totalVenta) {
        $this->db->beginTransaction();
        
        try {
            // Insertar la venta
            $query = "INSERT INTO ventas (total, fecha) VALUES (?, NOW())";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$totalVenta]);
            $ventaId = $this->db->lastInsertId();
            
            // Insertar los detalles de la venta y actualizar el stock
            foreach ($productos as $producto) {
                // Verificar stock
                $query = "SELECT stock FROM consumibles WHERE id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$producto['id']]);
                $stockActual = $stmt->fetchColumn();
                
                if ($stockActual < $producto['cantidad']) {
                    throw new Exception("No hay suficiente stock para el producto ID " . $producto['id']);
                }
                
                // Insertar detalle de venta
                $query = "INSERT INTO ventas_detalles (venta_id, consumible_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$ventaId, $producto['id'], $producto['cantidad'], $producto['precio']]);
                
                // Actualizar stock
                $nuevoStock = $stockActual - $producto['cantidad'];
                $query = "UPDATE consumibles SET stock = ? WHERE id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$nuevoStock, $producto['id']]);
            }
            
            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    
    

    
    public function getVentas()
    {
        $stmt = $this->db->query("SELECT * FROM ventas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVentasPorFecha($selectedDate)
    {
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


    public function showVentaConsumible($id)
    {
        $consumible = $this->getConsumibleById($id);
        include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/arsenal/showVentasRegistradas.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/arsenal/ventaConsumible.php';
    }


    public function getAllConsumibles()
    {
        $sql = "SELECT * FROM consumibles";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    


    public function createVentaConsumible($idConsumible, $cantidad)
    {
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
public function createConsumible($nombre, $descripcion_consumible, $marca, $unidad_medida, $observacion, $fecha_vencimiento, $precio, $stock, $coste)
    {
        try {
            $sql = "INSERT INTO consumibles 
                    (nombre, descripcion_consumible, marca, unidad_medida, observacion, fecha_vencimiento, precio, stock, coste) 
                    VALUES 
                    (:nombre, :descripcion_consumible, :marca, :unidad_medida, :observacion, :fecha_vencimiento, :precio, :stock, :coste)";
        
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nombre' => $nombre,
                ':descripcion_consumible' => $descripcion_consumible,
                ':marca' => $marca,
                ':unidad_medida' => $unidad_medida,
                ':observacion' => $observacion,
                ':fecha_vencimiento' => $fecha_vencimiento,
                ':precio' => $precio,
                ':stock' => $stock,
                ':coste' => $coste
            ]);
    
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error inserting consumible: " . $e->getMessage());
            return false;
        }
    }
    
    public function updateConsumible($id, $nombre, $descripcion_consumible, $marca, $unidad_medida, $observacion, $fecha_vencimiento, $precio, $stock, $coste)
    {
        try {
            $sql = "UPDATE consumibles SET 
                    nombre = :nombre, 
                    descripcion_consumible = :descripcion_consumible,
                    marca = :marca,
                    unidad_medida = :unidad_medida,
                    observacion = :observacion,
                    fecha_vencimiento = :fecha_vencimiento,
                    precio = :precio,
                    stock = :stock,
                    coste = :coste
                WHERE id = :id";
        
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':id' => $id,
                ':nombre' => $nombre,
                ':descripcion_consumible' => $descripcion_consumible,
                ':marca' => $marca,
                ':unidad_medida' => $unidad_medida,
                ':observacion' => $observacion,
                ':fecha_vencimiento' => $fecha_vencimiento,
                ':precio' => $precio,
                ':stock' => $stock,
                ':coste' => $coste
            ]);
        } catch (PDOException $e) {
            error_log("Error updating consumible: " . $e->getMessage());
            return false;
        }
    }

public function assignCategoriasToConsumible($consumibleId, $categorias)
{
    try {
        $this->db->beginTransaction();
        $sql = "DELETE FROM consumibles_categorias WHERE consumible_id = :consumible_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':consumible_id' => $consumibleId]);

        $sql = "INSERT INTO consumibles_categorias (consumible_id, categoria_id) VALUES (:consumible_id, :categoria_id)";
        $stmt = $this->db->prepare($sql);

        foreach ($categorias as $categoriaId) {
            $stmt->execute([':consumible_id' => $consumibleId, ':categoria_id' => $categoriaId]);
        }

        $this->db->commit();
    } catch (PDOException $e) {
        $this->db->rollBack();
        error_log("Error assigning categories to consumible: " . $e->getMessage());
    }
}

    private function updateConsumibleStock($id, $nuevoStock)
    {
        $stmt = $this->db->prepare("UPDATE consumibles SET stock = :stock WHERE id = :id");
        $stmt->execute([
            ':stock' => $nuevoStock,
            ':id' => $id
        ]);
    }

    public function getConsumibleById($id)
    {
        try {
            $sql = "SELECT * FROM consumibles WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching consumible: " . $e->getMessage());
            return false;
        }
    }
    

    
    public function getCategoriasByConsumible($consumibleId)
    {
        try {
            $sql = "SELECT categoria_id FROM consumibles_categorias WHERE consumible_id = :consumible_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':consumible_id' => $consumibleId]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        } catch (PDOException $e) {
            error_log("Error fetching categories by consumible: " . $e->getMessage());
            return [];
        }
    }
    public function getAllCategorias()
    {
        try {
            $sql = "SELECT * FROM categorias";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching categorias: " . $e->getMessage());
            return [];
        }
    }
    public function addCategoria($nombre) {
        try {
            $sql = "INSERT INTO categorias (nombre) VALUES (:nombre)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':nombre' => $nombre]);

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error al agregar la categoría: " . $e->getMessage());
            return false;
        }
    }
    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }

    public function createBien( $descripcion_bien, $nombre_proveedor, $modelo, $serie_codigo, $marca, $estado, $dimensiones, $color, $tipo_material, $estado_fisico_actual, $cantidad, $coste, $observacion)
    {
        try {
            $sql = "INSERT INTO bienes 
                ( descripcion_bien, nombre_proveedor, modelo, serie_codigo, marca, estado, dimensiones, color, tipo_material, estado_fisico_actual, cantidad, coste, observacion) 
                VALUES 
                ( :descripcion_bien, :nombre_proveedor, :modelo, :serie_codigo, :marca, :estado, :dimensiones, :color, :tipo_material, :estado_fisico_actual, :cantidad, :coste, :observacion)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':descripcion_bien' => $descripcion_bien,
                ':nombre_proveedor' => $nombre_proveedor,
                ':modelo' => $modelo,
                ':serie_codigo' => $serie_codigo,
                ':marca' => $marca,
                ':estado' => $estado,
                ':dimensiones' => $dimensiones,
                ':color' => $color,
                ':tipo_material' => $tipo_material,
                ':estado_fisico_actual' => $estado_fisico_actual,
                ':cantidad' => $cantidad,
                ':coste' => $coste,
                ':observacion' => $observacion
            ]);

            return true;
        } catch (PDOException $e) {
            error_log("Error inserting bien: " . $e->getMessage());
            return false;
        }
    }
    public function updateBien($id, $descripcion_bien, $nombre_proveedor, $modelo, $serie_codigo, $marca, $estado, $dimensiones, $color, $tipo_material, $estado_fisico_actual, $cantidad, $coste, $observacion)
    {
        $sql = "UPDATE bienes SET 
                descripcion_bien = :descripcion_bien,
                nombre_proveedor = :nombre_proveedor,
                modelo = :modelo,
                serie_codigo = :serie_codigo,
                marca = :marca,
                estado = :estado,
                dimensiones = :dimensiones,
                color = :color,
                tipo_material = :tipo_material,
                estado_fisico_actual = :estado_fisico_actual,
                cantidad = :cantidad,
                coste = :coste,
                observacion = :observacion
            WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':descripcion_bien' => $descripcion_bien,
            ':nombre_proveedor' => $nombre_proveedor,
            ':modelo' => $modelo,
            ':serie_codigo' => $serie_codigo,
            ':marca' => $marca,
            ':estado' => $estado,
            ':dimensiones' => $dimensiones,
            ':color' => $color,
            ':tipo_material' => $tipo_material,
            ':estado_fisico_actual' => $estado_fisico_actual,
            ':cantidad' => $cantidad,
            ':coste' => $coste,
            ':observacion' => $observacion
        ]);
    }

    
    public function getCategoriaByConsumible($consumibleId) {
        $query = "SELECT categoria_id FROM consumibles_categorias WHERE consumible_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$consumibleId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['categoria_id'] : null;
    }
    
    // Method to update the category for a consumible
    public function updateCategoriaForConsumible($consumibleId, $categoriaId) {
        // Remove existing category for the consumible
        $this->db->prepare("DELETE FROM consumibles_categorias WHERE consumible_id = ?")->execute([$consumibleId]);
    
        // Insert the new category
        if ($categoriaId) {
            $query = "INSERT INTO consumibles_categorias (consumible_id, categoria_id) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$consumibleId, $categoriaId]);
        }
    }

    public function deleteBien($id)
    {
        $sql = "DELETE FROM bienes WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function deleteConsumible($id)
    {
        $sql = "DELETE FROM consumibles WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function getBienById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM bienes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // public function getCategorias() {
    //     $sql = "SELECT * FROM categorias WHERE estado = 'activo'"; // Ejemplo: solo categorías activas
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // Obtener consumibles por categoría
    
    public function getCategorias() {
        $sql = "SELECT * FROM categorias";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        var_dump($categorias); // Agrega esta línea para ver qué categorías se están obteniendo
        return $categorias;
    }
    
    public function getConsumiblesPorCategoria($categoriaId) {
        $query = "SELECT c.id, c.nombre, c.stock, c.precio
                  FROM consumibles c 
                  JOIN consumibles_categorias cc ON c.id = cc.consumible_id 
                  WHERE cc.categoria_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$categoriaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Reponer stock de un consumible
    public function reponerStock($consumible_id, $cantidad) {
        $sql = "UPDATE consumibles SET stock = stock + :cantidad WHERE id = :consumible_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':consumible_id', $consumible_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Obtener ID de categoría por ID de consumible
    public function getCategoriaIdPorConsumible($consumible_id) {
        $sql = "SELECT categoria_id FROM consumibles_categorias WHERE consumible_id = :consumible_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':consumible_id', $consumible_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

}

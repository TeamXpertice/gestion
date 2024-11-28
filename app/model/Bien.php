<?php
require_once 'BaseModel.php';

class Bien extends BaseModel
{
    // Obtener todos los bienes con su categoría asociada
    public function getAllBienes()
    {
        $sql = "SELECT b.*, cb.nombre AS categoria_nombre 
                FROM bienes b
                JOIN categorias_bienes cb ON b.categoria_bien_id = cb.id
                ORDER BY b.id ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllCategorias()
    {
        $sql = "SELECT id, nombre FROM categorias_bienes ORDER BY id ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Crear un nuevo bien
    public function crearBien($datos)
    {
        $sql = "INSERT INTO bienes 
                (descripcion_bien, nombre_proveedor, modelo, serie_codigo, marca, estado, dimensiones, 
                color, tipo_material, estado_fisico_actual, cantidad, coste, observacion, categoria_bien_id)
                VALUES (:descripcion_bien, :nombre_proveedor, :modelo, :serie_codigo, :marca, :estado, 
                :dimensiones, :color, :tipo_material, :estado_fisico_actual, :cantidad, :coste, :observacion, :categoria_bien_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($datos);
    }

    // Editar un bien
    public function editarBien($id, $datos)
    {
        try {
            $setClause = [];
            foreach ($datos as $key => $value) {
                if ($value !== null) {
                    $setClause[] = "$key = :$key";
                }
            }
            $sql = "UPDATE bienes SET " . implode(', ', $setClause) . " WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            foreach ($datos as $key => $value) {
                if ($value !== null) {
                    $stmt->bindValue(":$key", $value);
                }
            }
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
    
        } catch (Exception $e) {
            // Registra el error
            error_log("Error al actualizar el bien: " . $e->getMessage());
            throw new Exception('Error al actualizar el bien.');
        }
    }
    

    // Eliminar un bien
    public function eliminarBien($id)
    {
        $sql = "DELETE FROM bienes WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Validar si un bien pertenece a una categoría
    public function bienesEnCategoria($categoriaId)
    {
        $sql = "SELECT COUNT(*) FROM bienes WHERE categoria_bien_id = :categoriaId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':categoriaId', $categoriaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Obtener un bien por su ID
    public function getBienById($id)
    {
        $sql = "SELECT * FROM bienes WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

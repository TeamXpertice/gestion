<?php
require_once 'BaseModel.php';

class CategoriaBienes extends BaseModel
{
    public function getAllCategorias()
    {
        $sql = "SELECT id, nombre FROM categorias_bienes ORDER BY id ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearCategoria($nombre)
    {
        $sql = "INSERT INTO categorias_bienes (nombre) VALUES (:nombre)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function editarCategoria($id, $nombre)
    {
        $sql = "UPDATE categorias_bienes SET nombre = :nombre WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function eliminarCategoria($id)
    {
        $sql = "DELETE FROM categorias_bienes WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function categoriaEnUso($id)
{
    $sql = "SELECT COUNT(*) FROM bienes WHERE categoria_bien_id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}
}

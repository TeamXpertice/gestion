<?php
require_once 'BaseModel.php';

class Categoria extends BaseModel
{
    public function getAllCategorias()
    {
        $sql = "SELECT 
                id,
                nombre
            FROM categorias
            ORDER BY id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearCategoria($nombre)
{
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



    public function editarCategoria($id, $nombre)
    {
        $sql = "UPDATE categorias 
            SET nombre = :nombre 
            WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->execute();
    }


    public function categoriaEnUso($id)
    {
        $sql = "SELECT COUNT(*) 
            FROM consumibles 
            WHERE categoria_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }


    public function eliminarCategoria($id)
    {
        $sql = "DELETE FROM categorias 
            WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
 

}

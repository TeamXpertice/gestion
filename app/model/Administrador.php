<?php
require_once 'BaseModel.php';

class Administrador extends BaseModel
{
    public function getAdministradoresHabilitados()
    {
        $sql = "SELECT id, nombres, apellidos, correo, dni, celular, direccion, ocupacion 
                FROM administradores 
                WHERE estado = 1 AND id > 1";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAdministradorEditar($id)
    {
        $sql = "SELECT * FROM administradores WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function crear($datos)
    {
        $stmt = $this->db->prepare("INSERT INTO administradores 
            (nombres, apellidos, correo, contrasena, dni, celular, fecha_nacimiento, direccion, ocupacion, estado) 
            VALUES (:nombres, :apellidos, :correo, :contrasena, :dni, :celular, :fecha_nacimiento, :direccion, :ocupacion, 1)");

        $stmt->execute($datos);
    }

    public function editar($id, $datos)
    {
        $setClause = [];
        foreach ($datos as $key => $value) {
            if ($value !== null) {
                $setClause[] = "$key = :$key";
            }
        }
        $sql = "UPDATE administradores SET " . implode(', ', $setClause) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        foreach ($datos as $key => $value) {
            if ($value !== null) {
                $stmt->bindValue(":$key", $value);
            }
        }
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function deshabilitar($id)
    {
        $stmt = $this->db->prepare("UPDATE administradores SET estado = 0 WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function existeCorreoODni($correo, $dni)
{
    $sql = "SELECT COUNT(*) 
            FROM administradores 
            WHERE correo = :correo OR dni = :dni";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}



}

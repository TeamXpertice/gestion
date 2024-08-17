<?php

include 'BaseModel.php';

class Login extends BaseModel {
    public function authenticate($correo, $contrasena) {
        $query = "SELECT * FROM administradores WHERE correo = :correo AND contrasena = :contrasena";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
}
?>

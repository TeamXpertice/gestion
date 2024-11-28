<?php

include 'BaseModel.php';

class Login extends BaseModel {
    public function authenticate($correo, $contrasena) {
        $query = "SELECT * FROM administradores WHERE correo = :correo AND estado = 1"; 
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($contrasena, $user['contrasena'])) {
            return $user;
        }

        return false;
    }
}

?>

<?php

require_once 'conexion.php';

class User extends Conexion {
    public function __construct() {
        parent::__construct();
    }

    public function authenticate($username, $password) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return true;
        }

        return false;
    }
}

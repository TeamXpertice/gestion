<?php

include '../models/login.php';

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = new User();
            if ($user->authenticate($username, $password)) {
                echo "Login exitoso.";
            } else {
                echo "Login fallido.";
            }
        }
    }
}
?>

<?php

class logoutController {
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /gestion/app/view/login/login.php");
        exit;
    }
}

$controller = new logoutController();
$controller->logout();
?>

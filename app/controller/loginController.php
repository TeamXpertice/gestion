<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../model/login.php';

class loginController extends BaseController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $loginModel = new login();
            $user = $loginModel->authenticate($username, $password);

            if ($user) {
                session_start();
                $_SESSION['username'] = $username;
                header('Location: /gestion/app/controller/dashboardController.php?action=showDashboard');
                exit();
            } else {
                header('Location: /gestion/app/view/login/login.php?error=invalid_credentials');
                exit();
            }
        }
    }
}

if (isset($_GET['action'])) {
    $controller = new loginController();
    $action = $_GET['action'];
    $controller->$action();
}
?>

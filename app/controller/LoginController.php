<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Login.php';

class LoginController extends BaseController
{
    public function Login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];
            $loginModel = new Login();
            $user = $loginModel->authenticate($correo, $contrasena);

            if ($user) {
                session_start();
                $_SESSION['id'] = $user['id'];
                $_SESSION['correo'] = $user['correo'];
                $_SESSION['nombres'] = $user['nombres'];
                header('Location: /gestion/app/controller/DashboardController.php?action=showDashboard');
                exit();
            } else {
                header('Location: /gestion/app/view/login/login.php?error=invalid_credentials');
                exit();
            }
        }
    }
}

if (isset($_GET['action'])) {
    $controller = new LoginController();
    $action = $_GET['action'];
    $controller->$action();
}
    
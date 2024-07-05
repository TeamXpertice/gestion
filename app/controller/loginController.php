<?php

include 'BaseController.php';
include '../model/login.php';

class loginController extends BaseController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = new Login();
            if ($user->authenticate($username, $password)) {
                session_start();
                $_SESSION['username'] = $username;
                $this->redirect('/gestion/app/controller/dashboardController.php?action=showDashboard');
            } else {
                $error = "Login fallido.";
                $this->loadView('login.login', ['error' => $error]);
            }
        } else {
            $this->loadView('login.login');
        }
    }
}

if (isset($_GET['action'])) {
    $controller = new loginController();
    $action = $_GET['action'];
    $controller->$action();
}
?>

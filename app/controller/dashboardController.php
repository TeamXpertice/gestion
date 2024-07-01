<?php

include 'BaseController.php';

class dashboardController extends BaseController {
    public function showDashboard() {
        session_start();
        if (!isset($_SESSION['username'])) {
            $this->redirect('/gestion/app/view/login/login.php');
        } else {
            $username = $_SESSION['username'];
            $this->loadView('dashboard.dashboard', ['username' => $username]);
        }
    }
}

if (isset($_GET['action'])) {
    $controller = new dashboardController();
    $action = $_GET['action'];
    $controller->$action();
}
?>

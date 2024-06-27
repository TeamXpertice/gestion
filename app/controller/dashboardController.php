<?php

include 'BaseController.php';

class dashboardController extends BaseController {
    public function showDashboard() {
        session_start();
        if (!isset($_SESSION['username'])) {
            $this->redirect('loginController.php?action=login');
        } else {
            $this->loadView('dashboard/dashboard');
        }
    }
}

if (isset($_GET['action'])) {
    $controller = new dashboardController();
    $action = $_GET['action'];
    $controller->$action();
}
?>

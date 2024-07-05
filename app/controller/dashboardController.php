<?php

require_once 'BaseController.php';

class dashboardController extends BaseController {
    public function showDashboard() {
        $username = $this->checkLogin();
        $this->loadView('dashboard.dashboard', ['username' => $username]);
    }
}

if (isset($_GET['action'])) {
    $controller = new dashboardController();
    $action = $_GET['action'];
    $controller->$action();
}
?>

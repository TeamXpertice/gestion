<?php
require_once 'BaseController.php';

class dashboardController extends BaseController {
    public function showDashboard() {
        $nombre = $this->checkLogin(); 
        $this->loadView('dashboard.dashboard', ['nombre' => $nombre]);
    }
}

if (isset($_GET['action'])) {
    $controller = new dashboardController();
    $action = $_GET['action'];
    $controller->$action();
}

?>

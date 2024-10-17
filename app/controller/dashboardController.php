<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Dashboard.php';

class DashboardController extends BaseController {
    private $model;

    public function __construct()
    {
        $this->model = new Dashboard();
    }

    public function showDashboard() {
        $nombre = $this->checkLogin();
        $this->loadView('dashboard.dashboard', [
            'nombre' => $nombre
        ]);
    }
}

if (isset($_GET['action'])) {
    $controller = new DashboardController();
    $action = $_GET['action'];

    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        echo "Error: Acción no encontrada.";
    }
}
?>

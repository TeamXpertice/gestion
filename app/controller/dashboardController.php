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
        $productosPorVencer = $this->model->obtenerProductosPorVencer();
        $this->loadView('dashboard.dashboard', [
            'nombre' => $nombre,
            'productosPorVencer' => $productosPorVencer
        ]);
    }
}

if (isset($_GET['action'])) {
    $controller = new DashboardController();
    $action = $_GET['action'];
    if (method_exists($controller, $action)) {
        $controller->$action();
        echo "Error: Acción no encontrada.";
    }
}

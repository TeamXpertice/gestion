<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Dashboard.php';  // Asegúrate de que el nombre del archivo y clase coincidan

class DashboardController extends BaseController {
    private $model;

    public function __construct()
    {
        $this->model = new Dashboard(); 
    }

    public function showDashboard() {
        $nombre = $this->checkLogin();

        $comprasPorMes = $this->model->getComprasPorMes();
        $ventasPorMes = $this->model->getVentasPorMes();

        $this->loadView('dashboard.dashboard', [
            'nombre' => $nombre,
            'comprasPorMes' => json_encode($comprasPorMes),  
            'ventasPorMes' => json_encode($ventasPorMes),    
        ], [], [
            '/gestion/app/view/dashboard/recursos/dashboard.min.js'
        ], 'Dashboard');
    }

    // Controlador para obtener los datos en formato JSON para la solicitud AJAX
    public function getData() {
        $comprasPorMes = $this->model->getComprasPorMes();
        $ventasPorMes = $this->model->getVentasPorMes();

        $data = [
            'comprasPorMes' => $comprasPorMes,
            'ventasPorMes' => $ventasPorMes
        ];

        echo json_encode($data);
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

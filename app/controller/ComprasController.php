<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Compra.php';
class ComprasController extends BaseController {

    private $model;

    public function __construct() {
        $this->model = new Compras();  // Instanciamos el modelo de Compras
    }

    public function showCompras() {
        $this->loadView('compras/createCompra');
    }

    public function showRegistroCompras() {
        $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
        $compras = $this->model->getComprasByDate($date);
        $this->loadView('compras/showRegistroCompras', ['compras' => $compras, 'selectedDate' => $date]);
    }

    public function createCompra() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion = $_POST['descripcion'];
            $cantidad = $_POST['cantidad'];
            $costo_unitario = $_POST['costo_unitario'];
            $total = $cantidad * $costo_unitario;
            $fecha = $_POST['fecha'];
            $proveedor = $_POST['proveedor'] ?? null;
            $metodo_pago = $_POST['metodo_pago'] ?? null;
            $observacion = $_POST['observacion'] ?? null;

            $this->model->createCompra($descripcion, $cantidad, $costo_unitario, $total, $fecha, $proveedor, $metodo_pago, $observacion);

            header("Location: /gestion/app/controller/ComprasController.php?action=showRegistroCompras");
            exit;
        }
    }
}

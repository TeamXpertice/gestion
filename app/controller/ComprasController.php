<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Compras.php';

class ComprasController extends BaseController {

    private $model;

    public function __construct() {
        $this->model = new Compras(); 
    }
public function showCompras() {
    $nombre = $this->checkLogin(); 
    $this->loadView('compras.createCompra', [
        'nombre' => $nombre
    ]);
}


public function showRegistroCompras() {
    $nombre = $this->checkLogin(); 
    $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
    $compras = $this->model->getComprasByDate($date);
    $totalPorMetodo = $this->model->getTotalPorMetodoPago($date);
    $this->loadView('compras.comprasRegistradas', [
        'compras' => $compras, 
        'selectedDate' => $date,
        'nombre' => $nombre,
        'totalPorMetodo' => $totalPorMetodo
    ]);
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
        } else {
            $this->loadView('compras.createCompra');
        }
    }
    // public function editCompra() {
    //     $id = $_GET['id'];
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $descripcion = $_POST['descripcion'];
    //         $cantidad = $_POST['cantidad'];
    //         $costo_unitario = $_POST['costo_unitario'];
    //         $total = $cantidad * $costo_unitario;
    //         $fecha = $_POST['fecha'];
    //         $proveedor = $_POST['proveedor'] ?? null;
    //         $metodo_pago = $_POST['metodo_pago'] ?? null;
    //         $observacion = $_POST['observacion'] ?? null;

    //         $this->model->updateCompra($id, $descripcion, $cantidad, $costo_unitario, $total, $fecha, $proveedor, $metodo_pago, $observacion);

    //         header("Location: /gestion/app/controller/ComprasController.php?action=showRegistroCompras");
    //         exit;
    //     } else {
    //         $compra = $this->model->getCompraById($id);
    //         $this->loadView('compras.editCompra', ['compra' => $compra]);
    //     }
    // }

    // public function deleteCompra() {
    //     $id = $_GET['id'];
    //     $this->model->deleteCompra($id);
    //     header('Location: /gestion/app/controller/ComprasController.php?action=showRegistroCompras');
    //     exit;
    // }
}

$action = $_GET['action'] ?? 'showCompras';
$controller = new ComprasController();
$controller->$action($_GET['id'] ?? null);

?>

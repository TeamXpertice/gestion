<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Compras.php';
require_once __DIR__ . '/../model/Arsenal.php';

class ComprasController extends BaseController {

    private $model;
    private $arsenalModel;

    public function __construct() {
        $this->model = new Compras();
        $this->arsenalModel = new Arsenal(); 
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
            $categorias = $this->model->getCategorias();

            $this->loadView('compras.createCompra', ['categorias' => $categorias]);
        }
    }

    public function getCategorias() {
        $categorias = $this->arsenalModel->getCategorias();
        echo json_encode($categorias);
    }

    public function getConsumiblesPorCategoria() {
        $categoriaId = $_GET['categoria_id'];
        if ($categoriaId) {
            $consumibles = $this->arsenalModel->getConsumiblesPorCategoria($categoriaId);
            echo json_encode($consumibles);
        } else {
            echo json_encode([]);
        }
    }

    public function reponerStock() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $consumible_id = $_POST['consumible_id'];
            $cantidad = $_POST['cantidad'];
            $result = $this->arsenalModel->reponerStock($consumible_id, $cantidad);
            
            if ($result) {
                $categoria_id = $this->arsenalModel->getCategoriaIdPorConsumible($consumible_id);
                echo json_encode(['success' => true, 'categoria_id' => $categoria_id]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al reponer stock']);
            }
        }
    }

}

$action = $_GET['action'] ?? 'showCompras';
$controller = new ComprasController();
$controller->$action($_GET['id'] ?? null);

?>

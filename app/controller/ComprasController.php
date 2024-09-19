<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Compras.php';

class ComprasController extends BaseController {
    private $model;

    public function __construct() {
        $this->model = new Compras();
    }
    public function showRegistroCompras() {
        $nombre = $this->checkLogin();
        date_default_timezone_set('America/Lima');
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
    public function showCompras() {
        $nombre = $this->checkLogin();
        $categorias = $this->model->getAllCategorias();
        $this->loadView('compras.createCompra', [
            'nombre' => $nombre,
            'categorias' => $categorias 
        ]);
    }

    public function registrarCompraConsumibles($productos, $proveedor, $metodo_pago) {
        foreach ($productos as $producto) {
            $consumible_id = $producto['id'] ?? null;
            $cantidad = $producto['cantidad'] ?? null;
            $costo_unitario = $producto['coste'] ?? null;
            $observacion = $producto['observacion'] ?? null;

            if ($consumible_id && $cantidad && $costo_unitario) {
                $this->model->reponerStock($consumible_id, $cantidad);
                $this->model->registrarCompraConsumible($consumible_id, $cantidad, $costo_unitario, date('Y-m-d'), $observacion, $proveedor, $metodo_pago);
            } else {
                return false;
            }
        }
        return true;
    }

    public function createCompra() {
        $action = $_POST['action'] ?? '';
        if ($action === 'normal') {
            $descripcion = $_POST['descripcion'] ?? '';
            $cantidad = $_POST['cantidad'] ?? 0;
            $costo_unitario = $_POST['costo_unitario'] ?? 0;
            $fecha = $_POST['fecha'] ?? date('Y-m-d');
            $proveedor = $_POST['proveedor'] ?? '';
            $metodo_pago = $_POST['metodo_pago'] ?? '';
            $observacion = $_POST['observacion'] ?? '';

            $result = $this->model->registrarCompraNormal($descripcion, $cantidad, $costo_unitario, $fecha, $proveedor, $metodo_pago, $observacion);
            echo json_encode(['success' => $result]);
        } elseif ($action === 'consumible') {
            $productos = json_decode($_POST['productosSeleccionados'], true);
            $proveedor = $_POST['proveedor'] ?? '';
            $metodo_pago = $_POST['metodo_pago'] ?? '';

            if ($productos && $this->registrarCompraConsumibles($productos, $proveedor, $metodo_pago)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function getConsumiblesPorCategoria() {
        $categoriaId = $_GET['categoria_id'] ?? null;
        if ($categoriaId) {
            $consumibles = $this->model->getConsumiblesPorCategoria($categoriaId);
            echo json_encode(array_filter($consumibles, function($consumible) {
                return $consumible['stock'] !== null; // Filtrar consumibles con stock null
            }));
        } else {
            echo json_encode([]);
        }
        exit;
    }
}

$action = $_GET['action'] ?? 'showCompras';
$controller = new ComprasController();
if (method_exists($controller, $action)) {
    $controller->$action($_GET['id'] ?? null);
} else {
    $controller->showCompras();
}
?>

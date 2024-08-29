<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Compras.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class ComprasController extends BaseController {

    private $model;

    public function __construct() {
        $this->model = new Compras();
    }

    public function showCompras() {
        $nombre = $this->checkLogin();
        $categorias = $this->model->getAllCategorias(); // Obtener todas las categorías
        $this->loadView('compras.createCompra', [
            'nombre' => $nombre,
            'categorias' => $categorias // Pasar las categorías a la vista
        ]);
    }
    
    // Muestra la vista con las compras registradas
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

    // Registra una nueva compra
    public function createCompra() {
        $action = $_POST['action'] ?? '';
    
        if ($action === 'normal') {
            // Código para manejar la compra normal
            $descripcion = $_POST['descripcion'] ?? '';
            $cantidad = $_POST['cantidad'] ?? 0;
            $costo_unitario = $_POST['costo_unitario'] ?? 0;
            $fecha = $_POST['fecha'] ?? date('Y-m-d');
            $proveedor = $_POST['proveedor'] ?? '';
            $metodo_pago = $_POST['metodo_pago'] ?? '';
            $observacion = $_POST['observacion'] ?? '';
    
            // Llamar a un método del modelo para registrar la compra normal
            $result = $this->model->registrarCompraNormal($descripcion, $cantidad, $costo_unitario, $fecha, $proveedor, $metodo_pago, $observacion);
            
            echo json_encode(['success' => $result]);
        } elseif ($action === 'consumible') {
            // Código para manejar el abastecimiento de consumibles
            $productos = json_decode($_POST['productosSeleccionados'], true);
            foreach ($productos as $producto) {
                $consumible_id = $producto['id'];
                $cantidad = $producto['cantidad'];
                $costo_unitario = $producto['coste'];
                $observacion = $producto['observacion'];
    
                // Reponer stock del consumible
                $this->model->reponerStock($consumible_id, $cantidad);
    
                // Registrar la compra del consumible
                $this->model->registrarCompraConsumible($consumible_id, $cantidad, $costo_unitario, date('Y-m-d'), $observacion);
            }
    
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Acción no válida']);
        }
    }
    
    
    

    // Obtener los consumibles por categoría

    public function getConsumiblesPorCategoria() {
        $categoriaId = $_GET['categoria_id'] ?? null;
        if ($categoriaId) {
            $consumibles = $this->model->getConsumiblesPorCategoria($categoriaId);
            echo json_encode($consumibles);
        } else {
            echo json_encode([]);
        }
        exit;
    }
    
}

// Instanciar el controlador y ejecutar la acción solicitada
$action = $_GET['action'] ?? 'showCompras';
$controller = new ComprasController();
if (method_exists($controller, $action)) {
    $controller->$action($_GET['id'] ?? null);
} else {
    $controller->showCompras(); // Acción por defecto
}
?>

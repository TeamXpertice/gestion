<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Compras.php';

class ComprasController extends BaseController {
    private $model;

    public function __construct() {
        $this->model = new Compras();
    }

    // Mostrar registros de compras
    public function showRegistroCompras() {
        $nombre = $this->checkLogin();
        $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
        $compras = $this->model->getComprasByDate($date);
        $this->loadView('compras.comprasRegistradas', [
            'compras' => $compras,
            'selectedDate' => $date,
            'nombre' => $nombre
        ]);
    }

    // Mostrar formulario de compras
    public function showCompras() {
        $nombre = $this->checkLogin();
        $categorias = $this->model->getAllCategorias();
        $this->loadView('compras.createCompra', [
            'nombre' => $nombre,
            'categorias' => $categorias 
        ]);
    }

    // Crear compra normal
    public function createCompraNormal() {
        $descripcion = $_POST['descripcion_compra'];
        $cantidad = $_POST['cantidad'];
        $costo_unitario = $_POST['costo_unitario'];
        $total = $_POST['total'];
        $fecha = $_POST['fecha'];
        $proveedor = $_POST['proveedor'];
        $metodo_pago = $_POST['metodo_pago'];
        $observacion = $_POST['observacion'];
    
        $this->model->createCompraNormal($descripcion, $cantidad, $costo_unitario, $total, $fecha, $proveedor, $metodo_pago, $observacion);
        echo json_encode(['success' => true]);
    }

    // Crear compra de consumibles y sus lotes
    public function createCompraConsumible() {
        $productosSeleccionados = json_decode($_POST['productosSeleccionados'], true); // Productos enviados desde la vista
        $proveedor = $_POST['proveedor'];
        $metodo_pago = $_POST['metodo_pago'];
    
        foreach ($productosSeleccionados as $producto) {
            $consumible_id = $producto['id'];
            $cantidad = $producto['cantidad'];
            $costo_unitario = $producto['costo'];
            $precio_unitario = $producto['precio'];
            $total = $cantidad * $costo_unitario;
            $fecha_ingreso = date('Y-m-d');
            $fecha_vencimiento = $producto['fecha_vencimiento'];
            $lote = uniqid(); // Generar un identificador de lote único
    
            // Insertar en compras_consumibles y obtener el ID
            $compras_consumibles_id = $this->model->createCompraConsumible($consumible_id, $cantidad, $costo_unitario, $total, $fecha_ingreso, $fecha_vencimiento);
    
            // Insertar en lotes
            $this->model->createLote($compras_consumibles_id, $lote, $cantidad, $costo_unitario, $precio_unitario, $fecha_ingreso, $fecha_vencimiento);
    
            // Actualizar el stock del consumible
            $this->model->updateStockConsumible($consumible_id, $cantidad);
        }
    
        echo json_encode(['success' => true]);
    }

    // Obtener consumibles por categoría
    public function getConsumiblesPorCategoria() {
        $categoriaId = $_GET['categoria_id'] ?? null;
        if ($categoriaId) {
            $consumibles = $this->model->getConsumiblesPorCategoria($categoriaId);
            echo json_encode($consumibles);  // Elimina el filtro del stock
        } else {
            echo json_encode([]);
        }
        exit;
    }
    
}

// Determinar la acción a ejecutar
$action = $_GET['action'] ?? 'showCompras';
$controller = new ComprasController();
if (method_exists($controller, $action)) {
    $controller->$action($_GET['id'] ?? null);
} else {
    $controller->showCompras();
}
?>

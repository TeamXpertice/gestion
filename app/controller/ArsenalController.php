<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Arsenal.php';

class ArsenalController extends BaseController {
    private $model;

    public function __construct() {
        $this->model = new Arsenal();
    }
////////////////////////////////////////////////SHOWS///////////////////////////////////////////////////
    public function showArsenal() {
        $nombre = $this->checkLogin();
        $bienes = $this->model->getBienes();
        $consumibles = $this->model->getConsumibles();
        $this->loadView('arsenal.showArsenal', [
            'bienes' => $bienes, 
            'consumibles' => $consumibles, 
            'nombre' => $nombre
        ]);
    }

    public function showBien() {
        $nombre = $this->checkLogin();
        $bienes = $this->model->getBienes();
        $this->loadView('arsenal.showBien', [
        'bienes' => $bienes, 
        'nombre' => $nombre]);
    }
    public function showVentasRegistradas() {
        $nombre = $this->checkLogin();
        $selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
        $ventas = $this->model->getVentasPorFecha($selectedDate);
    
        if (!$ventas) {
            echo '<p>No se encontraron ventas para esta fecha.</p>';
            return;
        }
    
        $this->loadView('arsenal/showVentasRegistradas', [
            'ventas' => $ventas, 
            'selectedDate' => $selectedDate, 
            'nombre' => $nombre
        ]);
    }
    
    public function showConsumible() {
        $nombre = $this->checkLogin();
        $consumibles = $this->model->getConsumibles();
        $this->loadView('arsenal.showConsumible', [
        'consumibles' => $consumibles, 
        'nombre' => $nombre]);
    }

    public function showCreateConsumible() {
        $nombre = $this->checkLogin();
        $categorias = $this->model->getAllCategorias();
        
        $this->loadView('arsenal.createConsumible', [
            'categorias' => $categorias, 
            'nombre' => $nombre
        ]);
    }
    public function showVentaConsumible() {
        $nombre = $this->checkLogin();
        $consumibles = $this->model->getAllConsumibles();
        $categorias = $this->model->getAllCategorias();

        $this->loadView('arsenal.ventaConsumible', [
            'consumibles' => $consumibles,
            'categorias' => $categorias, 
            'nombre' => $nombre
        ]);
    }

    

    
    public function createConsumible() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion_consumible = $_POST['descripcion_consumible'];
            $marca = $_POST['marca'];
            $unidad_medida = $_POST['unidad_medida'];
            $observacion = $_POST['observacion'];
            $fecha_vencimiento = $_POST['fecha_vencimiento'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $coste = $_POST['coste'];
            $categorias = isset($_POST['categorias']) ? $_POST['categorias'] : [];
    
            $consumibleId = $this->model->createConsumible(
                $nombre, $descripcion_consumible, $marca, $unidad_medida, $observacion, $fecha_vencimiento, $precio, $stock, $coste
            );
    
            if ($consumibleId) {
                $this->model->assignCategoriasToConsumible($consumibleId, $categorias);
                header('Location: /gestion/app/controller/ArsenalController.php?action=showConsumible');
                exit;
            } else {
                echo "Failed to create consumible.";
            }
        } else {
            $categorias = $this->model->getAllCategorias();
            $this->loadView('arsenal.createConsumible', ['categorias' => $categorias]);
        }
    }
    
    public function editConsumible() {
        $id = $_GET['id']; // Get the consumible ID from the query parameters
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Form submission
            $nombre = $_POST['nombre'];
            $descripcion_consumible = $_POST['descripcion_consumible'];
            $marca = $_POST['marca'];
            $unidad_medida = $_POST['unidad_medida'];
            $observacion = $_POST['observacion'];
            $fecha_vencimiento = $_POST['fecha_vencimiento'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $coste = $_POST['coste'];
            $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;
        
            $this->model->updateConsumible(
                $id, $nombre, $descripcion_consumible, $marca, $unidad_medida, $observacion, $fecha_vencimiento, $precio, $stock, $coste
            );
    
            $this->model->updateCategoriaForConsumible($id, $categoria);
    
            header('Location: /gestion/app/controller/ArsenalController.php?action=showConsumible');
            exit;
        } else {
            $consumible = $this->model->getConsumibleById($id);
            $categorias = $this->model->getAllCategorias();
    
            $selectedCategoria = $this->model->getCategoriaByConsumible($id);
    
            // Load the edit form view with data
            $this->loadView('arsenal.editConsumible', [
                'consumible' => $consumible,
                'categorias' => $categorias,
                'selectedCategoria' => $selectedCategoria
            ]);
        }
    }
    
    
////////////////////////////////////////////////GET///////////////////////////////////////////////////

public function getConsumiblesPorCategoria() {
    $categoriaId = $_GET['categoria_id'];
    
    if ($categoriaId) {
        $consumibles = $this->model->getConsumiblesPorCategoria($categoriaId);
        echo json_encode($consumibles);
    } else {
        echo json_encode([]);
    }
}


    public function addCategoria() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $categoriaId = $this->model->addCategoria($nombre);

            if ($categoriaId) {
                echo json_encode(['success' => true, 'id' => $categoriaId, 'nombre' => $nombre]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }
////////////////////////////////////////////////CREATE///////////////////////////////////////////////////
    
   
    
    public function deleteConsumible() {
        $id = $_GET['id'];
        $this->model->deleteConsumible($id);
        header('Location: /gestion/app/controller/ArsenalController.php?action=showConsumible');
    }
    public function createBien() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $descripcion_bien = $_POST['descripcion_bien'];
            $nombre_proveedor = $_POST['nombre_proveedor'];
            $modelo = $_POST['modelo'];
            $serie_codigo = $_POST['serie_codigo'];
            $marca = $_POST['marca'];
            $estado = $_POST['estado'];
            $dimensiones = $_POST['dimensiones'];
            $color = $_POST['color'];
            $tipo_material = $_POST['tipo_material'];
            $estado_fisico_actual = $_POST['estado_fisico_actual'];
            $cantidad = $_POST['cantidad'];
            $coste = $_POST['coste'];
            $observacion = $_POST['observacion'];
    
            $result = $this->model->createBien(
                 $descripcion_bien, $nombre_proveedor, $modelo, $serie_codigo, $marca, $estado, $dimensiones, $color, $tipo_material, $estado_fisico_actual, $cantidad, $coste, $observacion
            );
    
            if ($result) {
                header('Location: /gestion/app/controller/ArsenalController.php?action=showBien');
                exit;
            } else {
                echo "Failed to create bien.";
            }
        } else {
            $this->loadView('arsenal.createBien');
        }
    }
    public function editBien() {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion_bien = $_POST['descripcion_bien'];
            $nombre_proveedor = $_POST['nombre_proveedor'];
            $modelo = $_POST['modelo'];
            $serie_codigo = $_POST['serie_codigo'];
            $marca = $_POST['marca'];
            $estado = $_POST['estado'];
            $dimensiones = $_POST['dimensiones'];
            $color = $_POST['color'];
            $tipo_material = $_POST['tipo_material'];
            $estado_fisico_actual = $_POST['estado_fisico_actual'];
            $cantidad = $_POST['cantidad'];
            $coste = $_POST['coste'];
            $observacion = $_POST['observacion'];
    
            $this->model->updateBien(
                $id, $descripcion_bien, $nombre_proveedor, $modelo, $serie_codigo, $marca, $estado, $dimensiones, $color, $tipo_material, $estado_fisico_actual, $cantidad, $coste, $observacion
            );
    
            header('Location: /gestion/app/controller/ArsenalController.php?action=showBien');
        } else {
            $bien = $this->model->getBienById($id);
            $this->loadView('arsenal.editBien', ['bien' => $bien]);
        }
    }
    
    
    public function deleteBien() {
        $id = $_GET['id'];
        $this->model->deleteBien($id);
        header('Location: /gestion/app/controller/ArsenalController.php?action=showBien');
    }
    public function createVentaConsumible() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productosSeleccionados = isset($_POST['productosSeleccionados']) ? json_decode($_POST['productosSeleccionados'], true) : [];
    
            if (empty($productosSeleccionados)) {
                echo json_encode(['error' => 'No se han seleccionado productos.']);
                exit;
            }
    
            $totalVenta = 0;
    
            foreach ($productosSeleccionados as $producto) {
                $totalVenta += $producto['cantidad'] * $producto['precio'];
            }
    
            try {
                $this->model->registrarVenta($productosSeleccionados, $totalVenta);
                echo json_encode(['success' => 'Venta registrada exitosamente.']);
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error al registrar la venta: ' . $e->getMessage()]);
            }
            exit;
        }
    }



}

$action = $_GET['action'] ?? 'showArsenal';
$controller = new ArsenalController();
$controller->$action($_GET['id'] ?? null);
?>

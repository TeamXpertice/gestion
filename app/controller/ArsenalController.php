<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Arsenal.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class ArsenalController extends BaseController {
    private $model;

    public function __construct() {
        $this->model = new Arsenal();
    }

    public function showArsenal() {
        $bienes = $this->model->getBienes();
        $consumibles = $this->model->getConsumibles();
        $this->loadView('arsenal.showArsenal', ['bienes' => $bienes, 'consumibles' => $consumibles]);
    }

    public function showBien() {
        $bienes = $this->model->getBienes();
        $this->loadView('arsenal.showBien', ['bienes' => $bienes]);
    }

    public function showConsumible() {
        $consumibles = $this->model->getConsumibles();
        $this->loadView('arsenal.showConsumible', ['consumibles' => $consumibles]);
    }

    public function showCreateConsumible() {
        $categorias = $this->model->getAllCategorias();
        
        $this->loadView('arsenal.createConsumible', [
            'categorias' => $categorias
        ]);
    }

  
    public function showVentaConsumible() {
        $consumibles = $this->model->getAllConsumibles();
        $categorias = $this->model->getAllCategorias();

        $this->loadView('arsenal.ventaConsumible', [
            'consumibles' => $consumibles,
            'categorias' => $categorias
        ]);
    }
    public function getConsumiblesPorCategoria() {
        $categoriaId = $_GET['categoria_id'];
        $consumibles = $this->model->getConsumiblesPorCategoria($categoriaId);
        error_log(print_r($consumibles, true)); 
        echo json_encode($consumibles);
    }
    
    
    
    public function showVentasRegistradas() {
        $selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
        $ventas = $this->model->getVentasPorFecha($selectedDate);
        $this->loadView('arsenal/showVentasRegistradas', ['ventas' => $ventas, 'selectedDate' => $selectedDate]);
    }
    
    public function createVentaConsumible() {
        if (isset($_POST['productosSeleccionados'])) {
            $productosSeleccionados = json_decode($_POST['productosSeleccionados'], true);
    
            if (!empty($productosSeleccionados)) {
                $total = 0;
                foreach ($productosSeleccionados as $producto) {
                    $total += $producto['precio'] * $producto['cantidad'];
                }
    
                $ventaId = $this->model->insertVenta($total);
    
                if ($ventaId) {
                    foreach ($productosSeleccionados as $producto) {
                        $stockActual = $this->model->getStockConsumible($producto['id']);
                        if ($stockActual >= $producto['cantidad']) {
                            $this->model->insertVentaDetalle($ventaId, $producto['id'], $producto['cantidad'], $producto['precio']);
                            $this->model->updateStockConsumible($producto['id'], $stockActual - $producto['cantidad']);
                        } else {
                            echo json_encode(['error' => 'No hay suficiente stock para realizar la venta.']);
                            return;
                        }
                    }
    
                    
                    echo json_encode(['success' => 'Venta registrada con éxito.']);
                    return;
                } else {
                    echo json_encode(['error' => 'Error al registrar la venta.']);
                    return;
                }
            }
        } else {
            echo json_encode(['error' => 'No se seleccionaron productos.']);
            return;
        }
    }
    

    public function createBien() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion_bien = $_POST['descripcion_bien'];
            $nombre_proveedor = $_POST['nombre_proveedor'];
            $modelo = $_POST['modelo'];
            $serie_codigo = $_POST['serie_codigo'];
            $marca = $_POST['marca'];
            $unidad_medida = $_POST['unidad_medida'];
            $tamano = $_POST['tamano'];
            $color = $_POST['color'];
            $tipo_material = $_POST['tipo_material'];
            $estado_fisico_actual = $_POST['estado_fisico_actual'];
            $observacion = $_POST['observacion'];
    
            $result = $this->model->createBien(
                $nombre, $descripcion_bien, $nombre_proveedor, $modelo, $serie_codigo, $marca, $unidad_medida, $tamano, $color, $tipo_material, $estado_fisico_actual, $observacion
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
            $nombre = $_POST['nombre'];
            $descripcion_bien = $_POST['descripcion_bien'];
            $nombre_proveedor = $_POST['nombre_proveedor'];
            $modelo = $_POST['modelo'];
            $serie_codigo = $_POST['serie_codigo'];
            $marca = $_POST['marca'];
            $unidad_medida = $_POST['unidad_medida'];
            $tamano = $_POST['tamano'];
            $color = $_POST['color'];
            $tipo_material = $_POST['tipo_material'];
            $estado_fisico_actual = $_POST['estado_fisico_actual'];
            $observacion = $_POST['observacion'];
    
            $this->model->updateBien(
                $id, $nombre, $descripcion_bien, $nombre_proveedor, $modelo, $serie_codigo, $marca, $unidad_medida, $tamano, $color, $tipo_material, $estado_fisico_actual, $observacion
            );
    
            header('Location: /gestion/app/controller/ArsenalController.php?action=showBien');
        } else {
            $bien = $this->model->getBienById($id);
            $this->loadView('arsenal.editBien', ['bien' => $bien]);
        }
    }
    public function addCategoria() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $categoriaId = $this->model->addCategoria($nombre);
    
            if ($categoriaId) {
                echo json_encode(['success' => true, 'id' => $categoriaId]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }
    
    public function createConsumible() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion_consumible = $_POST['descripcion_consumible'];
            $nombre_proveedor = $_POST['nombre_proveedor'];
            $modelo = $_POST['modelo'];
            $serie_codigo = $_POST['serie_codigo'];
            $marca = $_POST['marca'];
            $unidad_medida = $_POST['unidad_medida'];
            $tamano = $_POST['tamano'];
            $color = $_POST['color'];
            $estado_fisico_actual = $_POST['estado_fisico_actual'];
            $observacion = $_POST['observacion'];
            $fecha_vencimiento = $_POST['fecha_vencimiento'];
            $lote = $_POST['lote'];
            $precio = $_POST['precio']; 
            $stock = $_POST['stock']; 
            $categorias = isset($_POST['categorias']) ? $_POST['categorias'] : []; 
    
            $consumibleId = $this->model->createConsumible(
                $nombre, $descripcion_consumible, $nombre_proveedor, $modelo, $serie_codigo, $marca, $unidad_medida, $tamano, $color, $estado_fisico_actual, $observacion, $fecha_vencimiento, $lote, $precio, $stock  // Nuevo campo
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
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion_consumible = $_POST['descripcion_consumible'];
            $nombre_proveedor = $_POST['nombre_proveedor'];
            $modelo = $_POST['modelo'];
            $serie_codigo = $_POST['serie_codigo'];
            $marca = $_POST['marca'];
            $unidad_medida = $_POST['unidad_medida'];
            $tamano = $_POST['tamano'];
            $color = $_POST['color'];
            $estado_fisico_actual = $_POST['estado_fisico_actual'];
            $observacion = $_POST['observacion'];
            $fecha_vencimiento = $_POST['fecha_vencimiento'];
            $lote = $_POST['lote'];
            $categorias = isset($_POST['categorias']) ? $_POST['categorias'] : []; // Suponiendo que recibes las categorías como un array

            $this->model->updateConsumible(
                $id, $nombre, $descripcion_consumible, $nombre_proveedor, $modelo, $serie_codigo, $marca, $unidad_medida, $tamano, $color, $categoria, $estado_fisico_actual, $observacion, $fecha_vencimiento, $lote
            );
            $this->model->assignCategoriasToConsumible($id, $categorias);
    
            header('Location: /gestion/app/controller/ArsenalController.php?action=showConsumible');
        } else {
            $consumible = $this->model->getConsumibleById($id);
            $this->loadView('arsenal.editConsumible', ['consumible' => $consumible]);
        }
    }

    
    public function deleteBien() {
        $id = $_GET['id'];
        $this->model->deleteBien($id);
        header('Location: /gestion/app/controller/ArsenalController.php?action=showBien');
    }

    public function deleteConsumible() {
        $id = $_GET['id'];
        $this->model->deleteConsumible($id);
        header('Location: /gestion/app/controller/ArsenalController.php?action=showConsumible');
    }
}

$action = $_GET['action'] ?? 'showArsenal';
$controller = new ArsenalController();
$controller->$action($_GET['id'] ?? null);
?>

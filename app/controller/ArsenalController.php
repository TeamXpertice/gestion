<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Arsenal.php';

class ArsenalController extends BaseController {
    private $arsenal;

    public function __construct() {
        $this->arsenal = new Arsenal();
        $this->checkLogin();
    }

    public function index() {
        $bienes = $this->arsenal->getBienes();
        $consumibles = $this->arsenal->getConsumibles();
        include __DIR__ . '/../view/arsenal/arsenal.php';
    }

    public function showArsenal() {
        $this->index();
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
    
            $result = $this->arsenal->createBien(
                $nombre, $descripcion_bien, $nombre_proveedor, $modelo, $serie_codigo, $marca, $unidad_medida, $tamano, $color, $tipo_material, $estado_fisico_actual, $observacion
            );
    
            if ($result) {
                header('Location: /gestion/app/controller/ArsenalController.php?action=index');
                exit;
            } else {
                echo "Failed to create bien.";
            }
        } else {
            include __DIR__ . '/../view/arsenal/createBien.php';
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
    
            $this->arsenal->updateBien(
                $id, $nombre, $descripcion_bien, $nombre_proveedor, $modelo, $serie_codigo, $marca, $unidad_medida, $tamano, $color, $tipo_material, $estado_fisico_actual, $observacion
            );
    
            header('Location: /gestion/app/controller/ArsenalController.php?action=index');
        } else {
            $bien = $this->arsenal->getBienById($id);
            include __DIR__ . '/../view/arsenal/editBien.php';
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
            $tipo_material = $_POST['tipo_material'];
            $estado_fisico_actual = $_POST['estado_fisico_actual'];
            $observacion = $_POST['observacion'];
            $fecha_vencimiento = $_POST['fecha_vencimiento'];
            $lote = $_POST['lote'];
    
            $result = $this->arsenal->createConsumible(
                $nombre, $descripcion_consumible, $nombre_proveedor, $modelo, $serie_codigo, $marca, $unidad_medida, $tamano, $color, $tipo_material, $estado_fisico_actual, $observacion, $fecha_vencimiento, $lote
            );
    
            if ($result) {
                header('Location: /gestion/app/controller/ArsenalController.php?action=index');
                exit;
            } else {
                echo "Failed to create consumible.";
            }
        } else {
            include __DIR__ . '/../view/arsenal/createConsumible.php';
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
            $tipo_material = $_POST['tipo_material'];
            $estado_fisico_actual = $_POST['estado_fisico_actual'];
            $observacion = $_POST['observacion'];
            $fecha_vencimiento = $_POST['fecha_vencimiento'];
            $lote = $_POST['lote'];
    
            $this->arsenal->updateConsumible(
                $id, $nombre, $descripcion_consumible, $nombre_proveedor, $modelo, $serie_codigo, $marca, $unidad_medida, $tamano, $color, $tipo_material, $estado_fisico_actual, $observacion, $fecha_vencimiento, $lote
            );
    
            header('Location: /gestion/app/controller/ArsenalController.php?action=index');
        } else {
            $consumible = $this->arsenal->getConsumibleById($id);
            include __DIR__ . '/../view/arsenal/editConsumible.php';
        }
    }
    
    public function deleteBien() {
        $id = $_GET['id'];
        $this->arsenal->deleteBien($id);
        header('Location: /gestion/app/controller/ArsenalController.php?action=index');
    }

    public function deleteConsumible() {
        $id = $_GET['id'];
        $this->arsenal->deleteConsumible($id);
        header('Location: /gestion/app/controller/ArsenalController.php?action=index');
    }
}

$action = $_GET['action'] ?? 'index';
$controller = new ArsenalController();
$controller->$action();
?>

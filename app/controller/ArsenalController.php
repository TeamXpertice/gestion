<?php
require_once '../model/Arsenal.php';
require_once 'BaseController.php';

class ArsenalController extends BaseController {
    private $arsenal;

    public function __construct() {
        $this->arsenal = new Arsenal();
    }

    public function showArsenal() {
        $arsenal = new Arsenal();
        $bienes = $arsenal->getBienes();
        $consumibles = $arsenal->getConsumibles();
        include '../view/arsenal/arsenal.php';
    }
    
    public function createBien() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $this->arsenal->createBien($nombre, $descripcion);
            header("Location: /gestion/ArsenalController.php?action=showArsenal");
            exit;
        } else {
            $this->loadView('arsenal/createBien');
        }
    }

    public function createConsumible() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $this->arsenal->createConsumible($nombre, $descripcion);
            header("Location: /gestion/ArsenalController.php?action=showArsenal");
            exit;
        } else {
            $this->loadView('arsenal/createConsumible');
        }
    }

    public function updateBien() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $this->arsenal->updateBien($id, $nombre, $descripcion);
            header("Location: /gestion/ArsenalController.php?action=showArsenal");
            exit;
        } else {
            $id = $_GET['id'];
            $bien = $this->arsenal->getBien($id);
            $this->loadView('arsenal/updateBien', ['bien' => $bien]);
        }
    }

    public function updateConsumible() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $this->arsenal->updateConsumible($id, $nombre, $descripcion);
            header("Location: /gestion/ArsenalController.php?action=showArsenal");
            exit;
        } else {
            $id = $_GET['id'];
            $consumible = $this->arsenal->getConsumible($id);
            $this->loadView('arsenal/updateConsumible', ['consumible' => $consumible]);
        }
    }

    public function deleteBien() {
        $id = $_GET['id'];
        $this->arsenal->deleteBien($id);
        header("Location: /gestion/ArsenalController.php?action=showArsenal");
        exit;
    }

    public function deleteConsumible() {
        $id = $_GET['id'];
        $this->arsenal->deleteConsumible($id);
        header("Location: /gestion/ArsenalController.php?action=showArsenal");
        exit;
    }
}

$controller = new ArsenalController();
$action = $_GET['action'] ?? 'showArsenal';
$controller->$action();
?>

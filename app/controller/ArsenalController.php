<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/model/Arsenal.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/controller/BaseController.php';

class ArsenalController extends BaseController {
    private $arsenalModel;

    public function __construct() {
        $this->checkLogin();
        $this->arsenalModel = new Arsenal();
    }

    public function showArsenal() {
        $bienes = $this->arsenalModel->getBienes();
        $consumibles = $this->arsenalModel->getConsumibles();
        $username = $_SESSION['username'];
        $this->loadView('arsenal.arsenal', ['bienes' => $bienes, 'consumibles' => $consumibles, 'username' => $username]);
    }

    public function createBien() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $this->arsenalModel->createBien($nombre, $descripcion);
            $this->redirect('/gestion/ArsenalController.php?action=showArsenal');
        } else {
            $this->loadView('arsenal.createBien');
        }
    }

    public function createConsumible() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $this->arsenalModel->createConsumible($nombre, $descripcion);
            $this->redirect('/gestion/ArsenalController.php?action=showArsenal');
        } else {
            $this->loadView('arsenal.createConsumible');
        }
    }

    public function editBien() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $this->arsenalModel->updateBien($id, $nombre, $descripcion);
            $this->redirect('/gestion/ArsenalController.php?action=showArsenal');
        } else {
            $id = $_GET['id'];
            $bien = $this->arsenalModel->getBienById($id);
            $this->loadView('arsenal.editBien', ['bien' => $bien]);
        }
    }

    public function editConsumible() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $this->arsenalModel->updateConsumible($id, $nombre, $descripcion);
            $this->redirect('/gestion/ArsenalController.php?action=showArsenal');
        } else {
            $id = $_GET['id'];
            $consumible = $this->arsenalModel->getConsumibleById($id);
            $this->loadView('arsenal.editConsumible', ['consumible' => $consumible]);
        }
    }

    public function deleteBien() {
        $id = $_GET['id'];
        $this->arsenalModel->deleteBien($id);
        $this->redirect('/gestion/ArsenalController.php?action=showArsenal');
    }

    public function deleteConsumible() {
        $id = $_GET['id'];
        $this->arsenalModel->deleteConsumible($id);
        $this->redirect('/gestion/ArsenalController.php?action=showArsenal');
    }
}

if (isset($_GET['action'])) {
    $controller = new ArsenalController();
    $action = $_GET['action'];
    $controller->$action();
}
?>

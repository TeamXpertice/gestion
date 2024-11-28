<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/NoEncontrado.php';

class NoEncontradoController extends BaseController
{
    private $model;
    public function __construct()
    {
        $this->model = new NoEncontrado();
    }
    public function showNoEncontradoController()
    {
        $nombre = $this->checkLogin();
        $this->loadView('NoEncontrado.NoEncontrado', [
            'nombre' => $nombre
        ], [
            
        ], [
          
        ], '404');
    }
}
$action = $_GET['action'] ?? 'showNoEncontradoController';
$controller = new NoEncontradoController();
if (method_exists($controller, $action)) {
    $controller->$action($_GET['id'] ?? null);
} else {
    $controller->showNoEncontradoController();
}

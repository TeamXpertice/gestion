<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Categoria.php';

class CategoriaController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new Categoria();
    }

    public function showCategorias()
    {
        $nombre = $this->checkLogin();
        $categorias = $this->model->getAllCategorias();

        $this->loadView(
            'configuracion.categoria',
            [
                'categorias' => $categorias,
                'nombre' => $nombre
            ],
            [
                 '/gestion/app/view/configuracion/recursos/css/categoria.min.css'
            ],
            [
                '/gestion/app/view/configuracion/recursos/js/categoria.min.js'
            ], 
            'Gestión de Categorías'
        );
    }

    public function crearCategoria()
    {
        $nombre = $_POST['nombre'] ?? null;

        if (!$nombre) {
            echo json_encode(['status' => 'error', 'message' => 'El nombre de la categoría es obligatorio.']);
            exit;
        }

        $this->model->crearCategoria($nombre);

        echo json_encode(['status' => 'success', 'message' => 'Categoría creada exitosamente.']);
    }

    public function editarCategoria()
    {
        $id = $_POST['id'] ?? null;
        $nombre = $_POST['nombre'] ?? null;

        if (!$id || !$nombre) {
            echo json_encode(['status' => 'error', 'message' => 'ID y nombre de la categoría son obligatorios.']);
            exit;
        }

        $this->model->editarCategoria($id, $nombre);

        echo json_encode(['status' => 'success', 'message' => 'Categoría actualizada exitosamente.']);
    }

    public function eliminarCategoria()
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'El ID de la categoría es obligatorio.']);
            exit;
        }

        if ($this->model->categoriaEnUso($id)) {
            echo json_encode(['status' => 'error', 'message' => 'No se puede eliminar la categoría porque está en uso.']);
            exit;
        }

        $this->model->eliminarCategoria($id);

        echo json_encode(['status' => 'success', 'message' => 'Categoría eliminada exitosamente.']);
    }
}


$action = $_GET['action'] ?? 'showCategorias';
$controller = new CategoriaController();
$controller->$action($_GET['id'] ?? null);
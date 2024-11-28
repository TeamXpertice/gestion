<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Perdidas.php';

class PerdidasController extends BaseController {

    // Registrar una pérdida
    public function registrarPerdida() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener los datos del formulario
            $consumible_id = $_POST['consumible_id'];
            $cantidad = $_POST['cantidad'];
            $tipo = $_POST['tipo'];
            $descripcion = $_POST['descripcion'];
            $fecha = $_POST['fecha'];

            // Validar y registrar la pérdida en la base de datos
            $perdidaModel = new Perdidas();
            $result = $perdidaModel->registrarPerdida($consumible_id, $cantidad, $tipo, $descripcion, $fecha);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Pérdida registrada correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Hubo un error al registrar la pérdida']);
            }
        }
    }

    // Mostrar la vista de pérdidas
    public function showRegistrarPerdidas() {
        $this->loadView('perdidas.perdidas');
    }

    // Obtener los consumibles por categoría
  // Obtener los consumibles por categoría
public function obtenerConsumiblesPorCategoria() {
    // Verificar si la categoría_id está presente en la URL
    if (isset($_GET['categoria_id'])) {
        $categoria_id = $_GET['categoria_id'];  // Obtener el id de la categoría

        // Instanciamos el modelo de pérdidas
        $perdidasModel = new Perdidas();
        
        // Llamamos al método del modelo para obtener los consumibles de esa categoría
        $consumibles = $perdidasModel->obtenerConsumiblesPorCategoria($categoria_id);

        // Devolver los consumibles en formato JSON
        echo json_encode($consumibles);
    } else {
        echo json_encode(["error" => "No se especificó la categoría."]);
    }
}

}

if (isset($_GET['action'])) {
    $controller = new PerdidasController();
    $action = $_GET['action'];
    $controller->$action();
}

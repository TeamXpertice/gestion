<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Bien.php';

class BienesController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new Bien();
    }

    public function listarBienes()
    {
        $this->checkLogin();

        $bienes = $this->model->getAllBienes();
        $categorias = $this->model->getAllCategorias();

        $this->loadView(
            'bienes.bienes',
            [
                'bienes' => $bienes,
                'categorias' => $categorias,
            ],
            [
                '/gestion/app/view/bienes/recursos/css/bienes.min.css'
            ],
            [
                '/gestion/app/view/bienes/recursos/js/bienes.min.js'

            ],
            'Gestión de Bienes'
        );
    }
    public function crearBien()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $datos = [
                    'descripcion_bien' => htmlspecialchars($_POST['descripcion_bien'] ?? null),
                    'nombre_proveedor' => htmlspecialchars($_POST['nombre_proveedor'] ?? null),
                    'modelo' => htmlspecialchars($_POST['modelo'] ?? null),
                    'serie_codigo' => htmlspecialchars($_POST['serie_codigo'] ?? null),
                    'marca' => htmlspecialchars($_POST['marca'] ?? null),
                    'estado' => htmlspecialchars($_POST['estado'] ?? null),
                    'dimensiones' => htmlspecialchars($_POST['dimensiones'] ?? null),
                    'color' => htmlspecialchars($_POST['color'] ?? null),
                    'tipo_material' => htmlspecialchars($_POST['tipo_material'] ?? null),
                    'estado_fisico_actual' => htmlspecialchars($_POST['estado_fisico_actual'] ?? null),
                    'cantidad' => (int) ($_POST['cantidad'] ?? 0),
                    'coste' => !empty($_POST['coste']) ? (float) $_POST['coste'] : 0.0,
                    'observacion' => htmlspecialchars($_POST['observacion'] ?? null),
                    'categoria_bien_id' => (int) ($_POST['categoria_bien_id'] ?? null),
                ];
    
                if (empty($datos['descripcion_bien']) || $datos['cantidad'] <= 0) {
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => 'Por favor complete los campos obligatorios.']);
                    exit;
                }
    
                $this->model->crearBien($datos);
    
                echo json_encode(['status' => 'success', 'message' => 'Bien creado exitosamente.']);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Ocurrió un error al crear el bien.', 'error' => $e->getMessage()]);
            }
        } else {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
        }
    }
    
    

    public function editarBien()
    {
        $id = $_POST['id'] ?? null;
        if (empty($id)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'El ID del bien es obligatorio.']);
            exit;
        }
    
        $datos = [
            'descripcion_bien' => $_POST['descripcion_bien'] ?? null,
            'nombre_proveedor' => $_POST['nombre_proveedor'] ?? null,
            'modelo' => $_POST['modelo'] ?? null,
            'serie_codigo' => $_POST['serie_codigo'] ?? null,
            'marca' => $_POST['marca'] ?? null,
            'estado' => $_POST['estado'] ?? null,
            'dimensiones' => $_POST['dimensiones'] ?? null,
            'color' => $_POST['color'] ?? null,
            'tipo_material' => $_POST['tipo_material'] ?? null,
            'estado_fisico_actual' => $_POST['estado_fisico_actual'] ?? null,
            'cantidad' => $_POST['cantidad'] ?? null,
            'coste' => $_POST['coste'] ?? null,
            'observacion' => $_POST['observacion'] ?? null,
            'categoria_bien_id' => $_POST['categoria_bien_id'] ?? null,
        ];
    
        try {
            $this->model->editarBien($id, $datos);
            echo json_encode(['status' => 'success', 'message' => 'Bien actualizado correctamente.']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Ocurrió un error al actualizar el bien.', 'error' => $e->getMessage()]);
        }
    }
    
    

    public function eliminarBien()
    {
        $id = $_POST['id'];
        $this->model->eliminarBien($id);

        echo json_encode(['status' => 'success', 'message' => 'Bien eliminado exitosamente.']);
    }
}

// Ejecutar la acción correspondiente
$action = $_GET['action'] ?? 'listarBienes';
$controller = new BienesController();
$controller->$action();

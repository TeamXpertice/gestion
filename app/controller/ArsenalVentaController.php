<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/ArsenalVenta.php';

class ArsenalVentaController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new ArsenalVenta();
    }

    public function showVentaConsumible()
    {
        $nombre = $this->checkLogin();
        $categorias = $this->model->getCategorias();
        
        $this->loadView('arsenal.ventaConsumible', [
            'nombre' => $nombre,
            'categorias' => $categorias
        ], [
            '/gestion/app/view/arsenal/recursos/css/ventaConsumible.min.css'
        ], [
            '/gestion/app/view/arsenal/recursos/js/ventaConsumible.min.js'
        ], 'Ventas'
    );
    }

    public function obtenerConsumiblesPorCategoria()
    {
        try {
            $categoriaId = $_GET['categoria_id'] ?? null;
    
            if (!$categoriaId) {
                throw new Exception('Categoría no especificada.');
            }
    
            $consumibles = $this->model->getConsumiblesPorCategoria($categoriaId);
    
            if (empty($consumibles)) {
                echo json_encode([]);
                return;
            }
    
            foreach ($consumibles as &$consumible) {
                if ($consumible['es_compuesto'] == 1) {
                    $consumible['cantidad_maxima'] = $this->model->calcularCantidadMaximaCompuesto($consumible['id']);
                }
            }
    
            echo json_encode($consumibles);
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo json_encode(['error' => 'Error al obtener los consumibles por categoría.']);
        }
    }
    

  

  public function crearVentaConsumible() {
    ob_start();
    try {
        $productos = json_decode($_POST['productosSeleccionados'], true);
        $metodoPago = $_POST['metodo_pago'] ?? '';

        if (empty($productos)) {
            throw new Exception('No se seleccionaron productos.');
        }

        if (empty($metodoPago)) {
            throw new Exception('Método de pago no especificado.');
        }

        $resultado = $this->model->registrarVenta($productos, $metodoPago);

        if ($resultado) {
            ob_end_clean();
            echo json_encode(['success' => 'La venta ha sido registrada correctamente.']);
        } else {
            throw new Exception('Error al registrar la venta.');
        }
    } catch (Exception $e) {
        ob_end_clean(); 
        error_log($e->getMessage());
        echo json_encode(['error' => $e->getMessage()]);
    }
}



}

$action = $_GET['action'] ?? 'showVentaConsumible';
$controller = new ArsenalVentaController();
$controller->$action($_GET['id'] ?? null);

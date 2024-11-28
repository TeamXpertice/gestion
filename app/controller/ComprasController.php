<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Compras.php';

class ComprasController extends BaseController
{
    private $model;
    public function __construct()
    {
        $this->model = new Compras();
    }
    public function showRegistroCompras()
    {
        $nombre = $this->checkLogin();
        $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
        $type = isset($_GET['type']) ? $_GET['type'] : 'all';

        if ($type === 'normales') {
            $compras_normales = $this->model->getComprasNormalesByDate($date);
            $compras_consumibles = [];
        } elseif ($type === 'consumibles') {
            $compras_normales = [];
            $compras_consumibles = $this->model->getComprasConsumiblesByDate($date);
        } else {

            $compras_normales = $this->model->getComprasNormalesByDate($date);
            $compras_consumibles = $this->model->getComprasConsumiblesByDate($date);
        }
        $this->loadView(
            'compras.comprasRegistradas',
            [
                'compras_normales' => $compras_normales,
                'compras_consumibles' => $compras_consumibles,
                'selectedDate' => $date,
                'nombre' => $nombre
            ],
            [
                '/gestion/app/view/compras/recursos/css/comprasRegistradas.min.css'
            ],
            [
                '/gestion/app/view/compras/recursos/js/comprasRegistradas.min.js'
            ],
            'Registro Ventas'
        );
    }
    public function showCompras()
    {
        $nombre = $this->checkLogin();
        $categorias = $this->model->getAllCategorias();
        $this->loadView('compras.crearCompras', [
            'nombre' => $nombre,
            'categorias' => $categorias
        ], [
            '/gestion/app/view/compras/recursos/css/crearCompras.min.css'
        ], [
            '/gestion/app/view/compras/recursos/js/crearCompras.min.js'
        ]);
    }
    public function obtenerConsumiblesPorCategoria()
    {
        try {
            $categoriaId = $_GET['categoria_id'];

            if ($categoriaId) {
                $consumibles = $this->model->getConsumiblesPorCategoria($categoriaId);

                foreach ($consumibles as &$consumible) {
                    $consumible['precio'] = (float) $consumible['precio'];
                }
                echo json_encode($consumibles);
            } else {
                throw new Exception('Categoría no especificada.');
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo json_encode(['error' => 'Error al obtener los consumibles por categoría.']);
        }
    }
    public function registrarCompraConsumible()
    {
        try {
            $productos = json_decode($_POST['productosSeleccionados'], true);
            $metodoPago = $_POST['metodo_pago'];

            if (empty($productos)) {
                throw new Exception('No se seleccionaron productos.');
            }

            $resultado = $this->model->registrarCompraConsumibles($productos, $metodoPago);

            header('Content-Type: application/json; charset=utf-8');
            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Compra registrada con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al registrar la compra.']);
            }
            exit;
        } catch (Exception $e) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            exit;
        }
    }
    public function registrarCompraComun()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion = $_POST['descripcion_compra'] ?? '';
            $cantidad = $_POST['cantidad'] ?? 0;
            $costoUnitario = $_POST['costo_unitario'] ?? 0;
            $total = $_POST['total'] ?? 0;
            $fecha = $_POST['fecha'] ?? '';
            $proveedor = $_POST['proveedor'] ?? '';
            $metodoPago = $_POST['metodo_pago'] ?? '';
            $observacion = $_POST['observacion'] ?? '';

            header('Content-Type: application/json; charset=utf-8');

            if (!empty($descripcion) && $cantidad > 0 && $costoUnitario > 0 && !empty($fecha)) {
                $resultado = $this->model->registrarCompraNormal($descripcion, $cantidad, $costoUnitario, $total, $fecha, $proveedor, $metodoPago, $observacion);

                if ($resultado) {
                    echo json_encode(['success' => true, 'message' => 'Compra registrada con éxito']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al registrar la compra común']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos obligatorios']);
            }
            exit;
        }
    }
}
$action = $_GET['action'] ?? 'showCompras';
$controller = new ComprasController();
if (method_exists($controller, $action)) {
    $controller->$action($_GET['id'] ?? null);
} else {
    $controller->showCompras();
}

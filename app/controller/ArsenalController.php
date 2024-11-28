<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../model/Arsenal.php';

class ArsenalController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new Arsenal();
    }

    public function showConsumible()
{
    date_default_timezone_set('America/Lima');
    $nombre = $this->checkLogin();
    $categorias = $this->model->getAllCategorias();

    $consumiblesSimples = $this->model->getConsumibles();

    $agrupadosSimples = [];
    foreach ($consumiblesSimples as $consumible) {
        $nombre = $consumible['nombre'];
        if (!isset($agrupadosSimples[$nombre])) {
            $agrupadosSimples[$nombre] = [];
        }
        $agrupadosSimples[$nombre][] = $consumible;
    }

    $consumiblesCompuestos = $this->model->getConsumiblesCompuestos();

    $this->loadView(
        'arsenal.showConsumible',
        [
            'agrupadosSimples' => $agrupadosSimples, 
            'consumiblesCompuestos' => $consumiblesCompuestos,
            'categorias' => $categorias,
            'nombre' => $nombre
        ],
        [
            '/gestion/app/view/arsenal/recursos/css/showConsumible.min.css'
        ],
        [
            '/gestion/app/view/arsenal/recursos/js/showConsumible.min.js'
        ],
        'Productos'
    );
}



    public function showVentasRegistradas()
{
    $nombre = $this->checkLogin();
    date_default_timezone_set('America/Lima');
    $selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
    $ventas = $this->model->getVentasPorFecha($selectedDate);

    $totalesPorMetodo = [
        'Efectivo' => 0,
        'Visa' => 0,
        'Yape' => 0,
        'Plin' => 0
    ];

    foreach ($ventas as $venta) {
        error_log('Venta: ' . json_encode($venta));

        if (isset($totalesPorMetodo[$venta['metodo_pago']])) {
            if (is_numeric($venta['total'])) {
                $totalesPorMetodo[$venta['metodo_pago']] += $venta['total'];
            }
        }
    }
    $this->loadView('arsenal/showVentasRegistradas', [
        'ventas' => $ventas,
        'totalesPorMetodo' => $totalesPorMetodo, 
        'selectedDate' => $selectedDate,
        'nombre' => $nombre
    ],
    [
        '/gestion/app/view/arsenal/recursos/css/showVentasRegistradas.min.css'
    ],
    [
        '/gestion/app/view/arsenal/recursos/js/showVentasRegistradas.min.js'
    ], 'Registro');
}


    

    ////////////////////////////////////////////////ALMACENES///////////////////////////////////////////////////
    public function CrearConsumibleSimple()
    {
        try {
            if (!isset($_POST['nombre'], $_POST['marca'], $_POST['unidad_medida'], $_POST['categoria'], $_POST['descripcion_consumible'], $_POST['stock'], $_POST['precio_unitario'], $_POST['fecha_ingreso'], $_POST['fecha_vencimiento'])) {
                throw new Exception('Campos faltantes en el formulario.');
            }
            $nombre = $_POST['nombre'];
            $marca = $_POST['marca'] ?? 'Sin datos';
            $unidad_medida = $_POST['unidad_medida'];
            $categoria = $_POST['categoria'];
            $descripcion = $_POST['descripcion_consumible'] ?? 'Sin datos';
            $observacion = $_POST['observacion'] ?? 'Sin datos'; 
            $stock = $_POST['stock'];
            $precio_unitario = $_POST['precio_unitario'];
            $fecha_ingreso = $_POST['fecha_ingreso'];
            $fecha_vencimiento = $_POST['fecha_vencimiento'];

            $resultado = $this->model->crearConsumibleSimple($nombre, $marca, $unidad_medida, $categoria, $descripcion, $observacion, $stock, $precio_unitario, $fecha_ingreso, $fecha_vencimiento);

            if ($resultado) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception('Error al crear el consumible simple en el modelo.');
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    // Crear consumible compuesto
    public function crearConsumibleCompuesto()
    {
        $nombre = $_POST['nombre'] ?? '';
        $categoria = $_POST['categoria'] ?? '';
        $descripcion = $_POST['descripcion'] ?? 'Consumible Compuesto';
        $observacion = $_POST['observacion'] ?? 'Consumible Compuesto';
        $precio_sugerido = $_POST['precio_sugerido'] ?? 0;
        $componentes = json_decode($_POST['componentes'], true) ?? [];

        error_log('Componentes recibidos: ' . print_r($componentes, true));

        if (empty($componentes)) {
            error_log('Error: No se recibieron componentes.');
            echo json_encode(['error' => 'No se recibieron componentes.']);
            return;
        }
        $resultado = $this->model->crearConsumibleCompuesto($nombre, $categoria, $descripcion, $observacion, $precio_sugerido, $componentes);
        if ($resultado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Error al crear el consumible compuesto.']);
        }
    }
    public function crearVentaConsumible()
    {
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

    public function addCategoria()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $categoriaId = $this->model->addCategoria($nombre);
            if ($categoriaId) {
                echo json_encode(['success' => true, 'id' => $categoriaId, 'nombre' => $nombre]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }
    public function obtenerConsumiblesPorCategoria()
    {
        try {
            $categoriaId = $_GET['categoria_id'];

            if ($categoriaId) {
                $consumibles = $this->model->getConsumiblesPorCategoria($categoriaId);

                foreach ($consumibles as &$consumible) {
                    $consumible['precio'] = (float) $consumible['precio'];

                    if (isset($consumible['cantidad_maxima'])) {
                        $consumible['cantidad_maxima'] = (int) $consumible['cantidad_maxima'];
                    }
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



    public function obtenerComponentesDeCompuesto()
    {
        try {
            $consumibleId = $_GET['consumible_id'] ?? null;

            if ($consumibleId) {
                $componentes = $this->model->getComponentesDeCompuesto($consumibleId);
                echo json_encode($componentes);
            } else {
                throw new Exception('ID de consumible compuesto no especificado.');
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo json_encode(['error' => 'Error al obtener los componentes del compuesto.']);
        }
    }




    ////////////////////////////////////////////////DELETE Y ADD///////////////////////////////////////////////////
    public function deleteConsumible()
    {
        $id = $_GET['id'];
        $this->model->deleteConsumible($id);
        header('Location: /gestion/app/controller/ArsenalController.php?action=showConsumible');
    }
  
}
$action = $_GET['action'] ?? 'showArsenal';
$controller = new ArsenalController();
$controller->$action($_GET['id'] ?? null);

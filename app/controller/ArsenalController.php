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
    ////////////////////////////////////////////////SHOWS///////////////////////////////////////////////////
    public function showArsenal()
    {
        $nombre = $this->checkLogin();
        $bienes = $this->model->getBienes();
        $consumibles = $this->model->getConsumibles();
        $this->loadView('arsenal.showArsenal', [
            'bienes' => $bienes,
            'consumibles' => $consumibles,
            'nombre' => $nombre
        ]);
    }
    public function showBien()
    {
        $nombre = $this->checkLogin();
        $bienes = $this->model->getBienes();
        $this->loadView('arsenal.showBien', [
            'bienes' => $bienes,
            'nombre' => $nombre
        ]);
    }
    public function showConsumible()
    {
        $nombre = $this->checkLogin();
        $consumibles = $this->model->getConsumibles();
        $categorias = $this->model->getAllCategorias();
        $this->loadView('arsenal.showConsumible', [
            'consumibles' => $consumibles,
            'categorias' => $categorias,
            'nombre' => $nombre
        ]);
    }
    public function showCreateConsumible()
    {
        $nombre = $this->checkLogin();
        $categorias = $this->model->getAllCategorias();

        $this->loadView('arsenal.createConsumible', [
            'categorias' => $categorias,
            'nombre' => $nombre
        ]);
    }
    public function showVentaConsumible()
    {
        $nombre = $this->checkLogin();
        $consumibles = $this->model->getAllConsumibles();
        $categorias = $this->model->getAllCategorias();
        $this->loadView('arsenal.ventaConsumible', [
            'consumibles' => $consumibles,
            'categorias' => $categorias,
            'nombre' => $nombre
        ]);
    }
    public function showVentasRegistradas()
    {
        $nombre = $this->checkLogin();
        date_default_timezone_set('America/Lima');
        $selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
        $ventas = $this->model->getVentasPorFecha($selectedDate);

        $this->loadView('arsenal/showVentasRegistradas', [
            'ventas' => $ventas,
            'selectedDate' => $selectedDate,
            'nombre' => $nombre
        ]);
    }
    ////////////////////////////////////////////////ALMACENES///////////////////////////////////////////////////
    public function createConsumible()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion_consumible = $_POST['descripcion_consumible'];
            $marca = isset($_POST['marca']) && !empty($_POST['marca']) ? $_POST['marca'] : 'S/D';
            $unidad_medida = $_POST['unidad_medida'];
            $observacion = $_POST['observacion'];
            $precio = $_POST['precio'];
            $es_compuesto = isset($_POST['consumible_multiple']) ? 1 : 0;

            if ($es_compuesto && isset($_POST['componentes'])) {
                $coste = 0;
                foreach ($_POST['componentes'] as $componenteId => $datosComponente) {
                    $cantidad = $datosComponente['cantidad'];
                    $costeComponente = $datosComponente['precio'] * $cantidad;
                    $coste += $costeComponente;
                }
                $stock = NULL; // Los compuestos no tienen stock propio
            } else {
                $coste = $_POST['coste'];
                $stock = $_POST['stock'];
            }

            // Crear el consumible
            $consumibleId = $this->model->createConsumible(
                $nombre,
                $descripcion_consumible,
                $marca,
                $unidad_medida,
                $observacion,
                null, // no se utiliza fecha_compra
                null, // no se utiliza fecha_vencimiento
                $precio,
                $stock,
                $coste,
                $es_compuesto
            );

            if ($consumibleId) {
                // Asignar categorías
                if (isset($_POST['categorias'])) {
                    $this->model->assignCategoriasToConsumible($consumibleId, $_POST['categorias']);
                }

                // Añadir componentes si es compuesto
                if ($es_compuesto && isset($_POST['componentes'])) {
                    foreach ($_POST['componentes'] as $componenteId => $datosComponente) {
                        $cantidad = $datosComponente['cantidad'];
                        $this->model->addComponenteToConsumible($consumibleId, $componenteId, $cantidad);
                    }
                } else {
                    // Crear el lote para los consumibles simples
                    // Utiliza las fechas de compra y vencimiento aquí
                    $fecha_compra = $_POST['fecha_compra']; // Obtener la fecha de compra del formulario
                    $fecha_vencimiento = $_POST['fecha_vencimiento']; // Obtener la fecha de vencimiento del formulario

                    $this->model->createLote($consumibleId, $stock, $coste / $stock, $precio, $fecha_compra, $fecha_vencimiento);
                }

                header('Location: /gestion/app/controller/ArsenalController.php?action=showConsumible');
                exit;
            } else {
                echo "Error al crear consumible.";
            }
        } else {
            $categorias = $this->model->getAllCategorias();
            $consumibles = $this->model->getAllConsumibles();
            $this->loadView('arsenal.createConsumible', [
                'categorias' => $categorias,
                'consumibles' => $consumibles
            ]);
        }
    }




    public function editConsumible()
    {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion_consumible = $_POST['descripcion_consumible'];
            $marca = $_POST['marca'];
            $unidad_medida = $_POST['unidad_medida'];
            $observacion = $_POST['observacion'];
            $fecha_vencimiento = $_POST['fecha_vencimiento'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $coste = $_POST['coste'];
            $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;

            $this->model->updateConsumible(
                $id,
                $nombre,
                $descripcion_consumible,
                $marca,
                $unidad_medida,
                $observacion,
                $fecha_vencimiento,
                $precio,
                $stock,
                $coste
            );

            $this->model->updateCategoriaForConsumible($id, $categoria);
            header('Location: /gestion/app/controller/ArsenalController.php?action=showConsumible');
            exit;
        } else {
            $consumible = $this->model->getConsumibleById($id);
            $categorias = $this->model->getAllCategorias();
            $selectedCategoria = $this->model->getCategoriaByConsumible($id);
            $this->loadView('arsenal.editConsumible', [
                'consumible' => $consumible,
                'categorias' => $categorias,
                'selectedCategoria' => $selectedCategoria
            ]);
        }
    }
    public function createVentaConsumible()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productosSeleccionados = isset($_POST['productosSeleccionados']) ? json_decode($_POST['productosSeleccionados'], true) : [];
            $metodoPago = isset($_POST['metodo_pago']) ? $_POST['metodo_pago'] : '';

            if (empty($productosSeleccionados)) {
                echo json_encode(['error' => 'No se han seleccionado productos.']);
                exit;
            }

            $totalVenta = 0;
            foreach ($productosSeleccionados as $producto) {
                $totalVenta += $producto['cantidad'] * $producto['precio'];
            }

            try {
                $this->model->registrarVenta($productosSeleccionados, $totalVenta, $metodoPago);
                echo json_encode(['success' => 'Venta registrada exitosamente.']);
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error al registrar la venta: ' . $e->getMessage()]);
            }
            exit;
        }
    }
    public function createBien()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion_bien = $_POST['descripcion_bien'];
            $nombre_proveedor = $_POST['nombre_proveedor'];
            $modelo = $_POST['modelo'];
            $serie_codigo = $_POST['serie_codigo'];
            $marca = $_POST['marca'];
            $estado = $_POST['estado'];
            $dimensiones = $_POST['dimensiones'];
            $color = $_POST['color'];
            $tipo_material = $_POST['tipo_material'];
            $estado_fisico_actual = $_POST['estado_fisico_actual'];
            $cantidad = $_POST['cantidad'];
            $coste = $_POST['coste'];
            $observacion = $_POST['observacion'];

            $result = $this->model->createBien(
                $descripcion_bien,
                $nombre_proveedor,
                $modelo,
                $serie_codigo,
                $marca,
                $estado,
                $dimensiones,
                $color,
                $tipo_material,
                $estado_fisico_actual,
                $cantidad,
                $coste,
                $observacion
            );
            if ($result) {
                header('Location: /gestion/app/controller/ArsenalController.php?action=showBien');
                exit;
            } else {
                echo "Failed to create bien.";
            }
        } else {
            $this->loadView('arsenal.createBien');
        }
    }
    public function editBien()
    {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $descripcion_bien = $_POST['descripcion_bien'];
            $nombre_proveedor = $_POST['nombre_proveedor'];
            $modelo = $_POST['modelo'];
            $serie_codigo = $_POST['serie_codigo'];
            $marca = $_POST['marca'];
            $estado = $_POST['estado'];
            $dimensiones = $_POST['dimensiones'];
            $color = $_POST['color'];
            $tipo_material = $_POST['tipo_material'];
            $estado_fisico_actual = $_POST['estado_fisico_actual'];
            $cantidad = $_POST['cantidad'];
            $coste = $_POST['coste'];
            $observacion = $_POST['observacion'];

            $this->model->updateBien(
                $id,
                $descripcion_bien,
                $nombre_proveedor,
                $modelo,
                $serie_codigo,
                $marca,
                $estado,
                $dimensiones,
                $color,
                $tipo_material,
                $estado_fisico_actual,
                $cantidad,
                $coste,
                $observacion
            );

            header('Location: /gestion/app/controller/ArsenalController.php?action=showBien');
        } else {
            $bien = $this->model->getBienById($id);
            $this->loadView('arsenal.editBien', ['bien' => $bien]);
        }
    }
    ////////////////////////////////////////////////GET///////////////////////////////////////////////////
    public function getConsumiblesByCategoria()
    {
        header('Content-Type: application/json');
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('ID de categoría no especificado.');
            }

            $categoriaId = $_GET['id'];
            $consumibles = $this->model->getConsumiblesByCategoria($categoriaId);

            echo json_encode(['consumibles' => $consumibles]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    public function getConsumiblesPorCategoria()
    {
        $categoriaId = $_GET['categoria_id'];
        if ($categoriaId) {
            $consumibles = $this->model->getConsumiblesPorCategoria($categoriaId);

            foreach ($consumibles as &$consumible) {
                $esCompuesto = isset($consumible['es_compuesto']) ? $consumible['es_compuesto'] : 0;

                if ($esCompuesto == 1) {
                    $componentes = $this->model->getComponentesByConsumible($consumible['id']);

                    $stockCompuesto = PHP_INT_MAX;

                    foreach ($componentes as $componente) {
                        $stockDisponible = floor($componente['stock'] / $componente['cantidad']);
                        $stockCompuesto = min($stockCompuesto, $stockDisponible);
                    }

                    $consumible['stock'] = $stockCompuesto;
                    $consumible['componentes'] = $componentes;
                }
            }

            echo json_encode($consumibles);
        } else {
            echo json_encode([]);
        }
    }
    ////////////////////////////////////////////////DELETE Y ADD///////////////////////////////////////////////////
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
    public function deleteConsumible()
    {
        $id = $_GET['id'];
        $this->model->deleteConsumible($id);
        header('Location: /gestion/app/controller/ArsenalController.php?action=showConsumible');
    }
    public function deleteBien()
    {
        $id = $_GET['id'];
        $this->model->deleteBien($id);
        header('Location: /gestion/app/controller/ArsenalController.php?action=showBien');
    }
}
$action = $_GET['action'] ?? 'showArsenal';
$controller = new ArsenalController();
$controller->$action($_GET['id'] ?? null);

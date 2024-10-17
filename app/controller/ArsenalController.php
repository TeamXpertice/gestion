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
    // ////////////////////////////////////////////////SHOWS///////////////////////////////////////////////////
    // public function showArsenal() {
    //     $nombre = $this->checkLogin();
    //     $this->loadView('arsenal.arsenal', [
    //         'nombre' => $nombre
    //     ], [
    //         '/gestion/public/css/datatables.css',  // Incluye el archivo CSS de DataTables
    //         '/gestion/public/css/buttons.dataTables.min.css'
    //     ], [
    //         'https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js',
    //         'https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js',
    //         'https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js',
    //         'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
    //         'https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js',
    //         'https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js',
    //         'https://cdn.jsdelivr.net/npm/sweetalert2@10'
    //     ]);
    // }
    
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
    
        // Pasamos los datos a la vista, junto con los scripts y estilos adicionales
        $this->loadView('arsenal.showConsumible', [
            'consumibles' => $consumibles,
            'categorias' => $categorias,
            'nombre' => $nombre
        ], [
           
        ], [
            '/gestion/app/view/arsenal/recursos/js/showConsumible.min.js'
        ]);
    }
    
    
    // public function showCreateConsumible()
    // {
    //     $nombre = $this->checkLogin();
    //     $categorias = $this->model->getAllCategorias();

    //     $this->loadView('arsenal.createConsumible', [
    //         'categorias' => $categorias,
    //         'nombre' => $nombre
    //     ]);
    // }
    public function showVentaConsumible()
    {
        $nombre = $this->checkLogin();
        $consumibles = $this->model->getAllConsumibles();
        $categorias = $this->model->getAllCategorias();
        $this->loadView('arsenal.ventaConsumible', [
            'consumibles' => $consumibles,
            'categorias' => $categorias,
            'nombre' => $nombre
        ], [
           
        ], [
            '/gestion/app/view/arsenal/recursos/js/ventaConsumible.min.js'
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
        ], [
           
        ], [
            '/gestion/app/view/arsenal/recursos/js/showVentasRegistradas.min.js'
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
            $es_compuesto = isset($_POST['consumible_multiple']) ? 1 : 0;
            $precio_sugerido = isset($_POST['precio_sugerido']) ? $_POST['precio_sugerido'] : 0;
    
            // Validar si es un consumible compuesto o simple
            if ($es_compuesto && isset($_POST['componentes'])) {
                // Para consumibles compuestos, calcular el coste basado en los componentes
                $coste = 0;
                foreach ($_POST['componentes'] as $componenteId => $datosComponente) {
                    $cantidad = $datosComponente['cantidad'];
                    $costeComponente = $datosComponente['precio'] * $cantidad;
                    $coste += $costeComponente;
                }
                $stock = NULL; // Los consumibles compuestos no tienen stock propio
            } else {
                // Consumible simple
                $coste = $_POST['coste'];
                $stock = $_POST['stock'];
                $precio_unitario = $_POST['precio_unitario'];
            }
    
            // Crear el consumible en la base de datos
            $consumibleId = $this->model->createConsumible(
                $nombre,
                $descripcion_consumible,
                $marca,
                $unidad_medida,
                $observacion,
                $precio_sugerido, // precio sugerido solo aplica a compuestos
                $es_compuesto
            );
    
            if ($consumibleId) {
    // Asignar la primera categoría al consumible directamente
    if (isset($_POST['categorias']) && !empty($_POST['categorias'])) {
        // Solo se toma la primera categoría seleccionada para asignarla al campo 'categoria_id'
        $categoria_id = $_POST['categorias'][0];
        $this->model->updateCategoriaForConsumible($consumibleId, $categoria_id);
    }
    
                // Si es compuesto, añadir los componentes
                if ($es_compuesto && isset($_POST['componentes'])) {
                    foreach ($_POST['componentes'] as $componenteId => $datosComponente) {
                        $cantidad = $datosComponente['cantidad'];
                        $this->model->addComponenteToConsumible($consumibleId, $componenteId, $cantidad);
                    }
                } else {
                    // Si es consumible simple, crear el lote con fechas de compra y vencimiento
                    $fecha_ingreso = $_POST['fecha_ingreso']; // Fecha de ingreso obtenida del formulario
                    $fecha_vencimiento = $_POST['fecha_vencimiento']; // Fecha de vencimiento obtenida del formulario
                    $lote = uniqid('lote_'); 
                    // Crear el lote para este consumible simple
                    // Crear la compra en compras_consumibles
                    $compraConsumibleId = $this->model->createCompraConsumible(
                        $consumibleId,    // ID del consumible creado
                        $stock,           // Cantidad de productos
                        $precio_unitario, // Costo unitario
                        $coste,           // Costo total
                        $fecha_ingreso,   // Fecha de ingreso
                        $fecha_vencimiento // Fecha de vencimiento
                    );

                    // Crear el lote para este consumible simple, usando el ID de la compra recién creada
                    $this->model->createLote(
                        $compraConsumibleId, // compras_consumibles_id
                        $lote,               // Identificador único para el lote
                        $stock,              // Cantidad
                        $coste,              // Costo total
                        $precio_unitario,    // Precio unitario definido en el formulario
                        $fecha_ingreso,      // Fecha de ingreso
                        $fecha_vencimiento   // Fecha de vencimiento
                    );

                }
    
                // Redirigir después de crear el consumible
                header('Location: /gestion/app/controller/ArsenalController.php?action=showConsumible');
                exit;
            } else {
                echo "Error al crear consumible.";
            }
        } else {
            // Mostrar el formulario
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

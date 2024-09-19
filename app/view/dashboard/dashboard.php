<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/gestion/public/css/style.css">
    <style>
        .producto-cuadro {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1>Dashboard</h1>
    <p>Usuario: <strong><?php echo htmlspecialchars($nombre ?? 'Invitado'); ?></strong></p>

    <!-- Cuadro de productos por vencer -->
    <h2>Productos a un día de vencer</h2>
    <div id="productosPorVencer">


        <?php if (!empty($productosConStock)): ?>
            <?php foreach ($productosConStock as $producto): ?>
                <div class="producto-cuadro">
                    <p><strong>Producto:</strong> <?php echo htmlspecialchars($producto['nombre']); ?></p>
                    <p><strong>Fecha de vencimiento:</strong> <?php echo htmlspecialchars($producto['fecha_vencimiento']); ?></p>
                    <p><strong>Cantidad:</strong> <?php echo htmlspecialchars($producto['stock']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay productos con stock a punto de vencer en el día de mañana.</p>
        <?php endif; ?>
    </div>

    <!-- Espacio para futuras implementaciones -->
    <div id="perdidas">
        <h2>Gestión de Pérdidas</h2>
        <p>Aquí se gestionarán las pérdidas futuras, incluyendo productos vencidos y usados por empleados.</p>
        <!-- Aquí puedes agregar más código para la vista de pérdidas en el futuro -->
    </div>
</div>
</body>
</html>

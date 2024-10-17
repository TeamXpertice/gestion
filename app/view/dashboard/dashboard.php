<div class="container mt-5">
    <h1>Dashboard</h1>
    <p>Usuario: <strong><?= htmlspecialchars($nombre ?? 'Invitado'); ?></strong></p>

    <!-- Cuadro de productos por vencer -->
    <h2 class="mt-4">Productos a un día de vencer</h2>
    
    <div id="productosPorVencer" class="row">
        <?php if (!empty($productosConStock)): ?>
            <?php foreach ($productosConStock as $producto): ?>
                <div class="col-md-4 mb-4"> <!-- Cada producto ocupa 4 columnas en pantallas medianas o más grandes -->
                    <div class="producto-cuadro h-100"> <!-- "h-100" asegura que las cajas tengan la misma altura -->
                        <p><strong>Producto:</strong> <?= htmlspecialchars($producto['nombre']); ?></p>
                        <p><strong>Fecha de vencimiento:</strong> <?= htmlspecialchars($producto['fecha_vencimiento']); ?></p>
                        <p><strong>Cantidad:</strong> <?= htmlspecialchars($producto['stock']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay productos con stock a punto de vencer en el día de mañana.</p>
        <?php endif; ?>
    </div>

    <!-- Espacio para futuras implementaciones -->
    <div id="perdidas" class="mt-5">
        <h2>Gestión de Pérdidas</h2>
        <p>Aquí se gestionarán las pérdidas futuras, incluyendo productos vencidos y usados por empleados.</p>
    </div>
</div>

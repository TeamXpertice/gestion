<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas Registradas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Ventas Registradas</h1>
        <div class="mb-4">
            <form action="/gestion/app/controller/ArsenalController.php" method="get">
                <input type="hidden" name="action" value="showVentasRegistradas">
                <input type="date" name="date" value="<?php echo htmlspecialchars($selectedDate); ?>" class="form-control" onchange="this.form.submit()">
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
    <?php if (!empty($ventas)): ?>
        <?php foreach ($ventas as $venta): ?>
        <tr>
            <td><?php echo htmlspecialchars($venta['nombre'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($venta['cantidad'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($venta['total'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($venta['fecha'] ?? ''); ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" class="text-center">No hay ventas registradas para esta fecha.</td>
        </tr>
    <?php endif; ?>
</tbody>

            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

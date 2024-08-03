<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
</head>
<body>
    <div class="container mt-1">
        <h2>Registrar Venta de Consumible</h2>
        <form action="/gestion/app/controller/ArsenalController.php?action=createVentaConsumible&id=<?php echo $consumible['id']; ?>" method="post">
            <div class="form-group">
                <label for="nombre">Nombre del Consumible</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($consumible['nombre']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="stock">Stock Disponible</label>
                <input type="number" id="stock" name="stock" class="form-control" value="<?php echo htmlspecialchars($consumible['stock']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" step="0.1" id="precio" name="precio" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Venta</button>
        </form>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

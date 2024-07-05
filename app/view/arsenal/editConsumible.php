<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Consumible</title>
    <link rel="stylesheet" href="/gestion/public/css/style.css">
</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/header.php'; ?>
    <div class="container mt-5">
        <h1>Editar Consumible</h1>
        <form action="/gestion/ArsenalController.php?action=editConsumible" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($consumible['id']); ?>">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($consumible['nombre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required><?php echo htmlspecialchars($consumible['descripcion']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>
</body>
</html>

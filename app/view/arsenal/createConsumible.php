<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Consumible</title>
    <link rel="stylesheet" href="/gestion/public/css/style.css">
</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/header.php'; ?>
    <div class="container mt-5">
        <h1>Crear Consumible</h1>
        <form action="/gestion/ArsenalController.php?action=createConsumible" method="post">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>
</body>
</html>

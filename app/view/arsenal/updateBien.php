<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Bien</title>
    <link rel="stylesheet" href="/gestion/public/css/style.css">
    <style>
        .main-content {
            margin-left: 250px; /* Adjust based on the sidebar width */
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/header.php'; ?>
    <div class="main-content">
        <div class="container mt-5">
            <h1>Actualizar Bien</h1>
            <form action="/gestion/ArsenalController.php?action=updateBien" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($bien['id']); ?>">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($bien['nombre']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" required><?php echo htmlspecialchars($bien['descripcion']); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsenal</title>
    <link rel="stylesheet" href="/gestion/public/css/style.css">
    <style>
        .main-content {
            margin-left: 250px; /* Ajusta esto según el ancho de tu sidebar */
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/header.php'; ?>
    <div class="main-content">
        <div class="container mt-5">
            <h1>Arsenal</h1>
            <h2>Bienes</h2>
            <a href="/gestion/ArsenalController.php?action=createBien" class="btn btn-primary mb-3">Agregar Bien</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bienes as $bien): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($bien['id']); ?></td>
                        <td><?php echo htmlspecialchars($bien['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($bien['descripcion']); ?></td>
                        <td>
                            <a href="/gestion/ArsenalController.php?action=updateBien&id=<?php echo $bien['id']; ?>" class="btn btn-warning">Editar</a>
                            <a href="/gestion/ArsenalController.php?action=deleteBien&id=<?php echo $bien['id']; ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h2>Consumibles</h2>
            <a href="/gestion/ArsenalController.php?action=createConsumible" class="btn btn-primary mb-3">Agregar Consumible</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consumibles as $consumible): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($consumible['id']); ?></td>
                        <td><?php echo htmlspecialchars($consumible['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($consumible['descripcion']); ?></td>
                        <td>
                            <a href="/gestion/ArsenalController.php?action=updateConsumible&id=<?php echo $consumible['id']; ?>" class="btn btn-warning">Editar</a>
                            <a href="/gestion/ArsenalController.php?action=deleteConsumible&id=<?php echo $consumible['id']; ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>
</body>
</html>

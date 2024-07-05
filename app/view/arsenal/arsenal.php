<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsenal</title>
    <link rel="stylesheet" href="/gestion/public/css/style.css">
</head>
<body>
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
                        <a href="/gestion/ArsenalController.php?action=editBien&id=<?php echo $bien['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="/gestion/ArsenalController.php?action=deleteBien&id=<?php echo $bien['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este bien?');">Eliminar</a>
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
                        <a href="/gestion/ArsenalController.php?action=editConsumible&id=<?php echo $consumible['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="/gestion/ArsenalController.php?action=deleteConsumible&id=<?php echo $consumible['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este consumible?');">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>
</body>
</html>

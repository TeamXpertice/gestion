<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsenal</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px;
        }
        .sidebar .nav-item a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 0;
        }
        .sidebar .nav-item a:hover {
            background-color: #495057;
            border-radius: 5px;
        }
        .user-info {
            margin-top: auto;
        }
        .content {
            margin-left: 250px; 
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar d-flex flex-column">
            <div class="text-center mb-4">
                <img src="/gestion/public/img/logo.png" alt="Icono" class="img-fluid mb-3" style="width: 100px;">
                <h4>Bienvenido</h4>
                <p>Usuario: <strong><?php echo isset($username) ? htmlspecialchars($username) : 'Invitado'; ?></strong></p>
            </div>
            <nav class="nav flex-column">
                <div class="nav-item">
                    <a href="/gestion/app/controller/dashboardController.php?action=showDashboard">Dashboard</a>
                </div>
                <div class="nav-item">
                    <a href="/gestion/app/controller/ArsenalController.php?action=showArsenal">Arsenal</a>
                </div>
            </nav>
            <div class="user-info mt-auto text-center">
                <a href="/gestion/app/controller/logoutController.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>
        
        <div class="content flex-grow-1">
            <div class="container mt-5">
                <h1>Arsenal</h1>
                <h2>Bienes</h2>
                <a href="/gestion/app/controller/ArsenalController.php?action=createBien" class="btn btn-primary mb-3">Agregar Bien</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Proveedor</th>
                            <th>Modelo</th>
                            <th>Serie/Código</th>
                            <th>Marca</th>
                            <th>Unidad de Medida</th>
                            <th>Tamaño</th>
                            <th>Color</th>
                            <th>Tipo de Material</th>
                            <th>Estado Físicol</th>
                            <th>Descripción</th>
                            <th>Observación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bienes as $bien): ?>
                        <tr>
                        
                            <td><?php echo htmlspecialchars($bien['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($bien['nombre_proveedor']); ?></td>
                            <td><?php echo htmlspecialchars($bien['modelo']); ?></td>
                            <td><?php echo htmlspecialchars($bien['serie_codigo']); ?></td>
                            <td><?php echo htmlspecialchars($bien['marca']); ?></td>
                            <td><?php echo htmlspecialchars($bien['unidad_medida']); ?></td>
                            <td><?php echo htmlspecialchars($bien['tamano']); ?></td>
                            <td><?php echo htmlspecialchars($bien['color']); ?></td>
                            <td><?php echo htmlspecialchars($bien['tipo_material']); ?></td>
                            <td><?php echo htmlspecialchars($bien['estado_fisico_actual']); ?></td>
                            <td><?php echo htmlspecialchars($bien['descripcion_bien']); ?></td>
                            <td><?php echo htmlspecialchars($bien['observacion']); ?></td>
                            <td>
                                <a href="/gestion/app/controller/ArsenalController.php?action=editBien&id=<?php echo $bien['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="/gestion/app/controller/ArsenalController.php?action=deleteBien&id=<?php echo $bien['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este bien?');">Eliminar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h2>Consumibles</h2>
                <a href="/gestion/app/controller/ArsenalController.php?action=createConsumible" class="btn btn-primary mb-3">Agregar Consumible</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Proveedor</th>
                            <th>Modelo</th>
                            <th>Serie/Código</th>
                            <th>Marca</th>
                            <th>Unidad de Medida</th>
                            <th>Tamaño</th>
                            <th>Color</th>
                            <th>Tipo de Material</th>
                            <th>Estado Físicol</th>
                            <th>Descripción</th>
                            <th>Fecha de Vencimiento</th>
                            <th>Lote</th>
                            <th>Observación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consumibles as $consumible): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($consumible['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($consumible['nombre_proveedor']); ?></td>
                            <td><?php echo htmlspecialchars($consumible['modelo']); ?></td>
                            <td><?php echo htmlspecialchars($consumible['serie_codigo']); ?></td>
                            <td><?php echo htmlspecialchars($consumible['marca']); ?></td>
                            <td><?php echo htmlspecialchars($consumible['unidad_medida']); ?></td>
                            <td><?php echo htmlspecialchars($consumible['tamano']); ?></td>
                            <td><?php echo htmlspecialchars($consumible['color']); ?></td>
                            <td><?php echo htmlspecialchars($consumible['tipo_material']); ?></td>
                            <td><?php echo htmlspecialchars($consumible['estado_fisico_actual']); ?></td>
                            <td><?php echo htmlspecialchars($consumible['descripcion_consumible']); ?></td>
                            <td><?php echo htmlspecialchars($consumible['fecha_vencimiento']); ?></td>
                            <td><?php echo htmlspecialchars($consumible['lote']); ?></td>
                            <td><?php echo htmlspecialchars($consumible['observacion']); ?></td>
                            <td>
                                <a href="/gestion/app/controller/ArsenalController.php?action=editConsumible&id=<?php echo $consumible['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="/gestion/app/controller/ArsenalController.php?action=deleteConsumible&id=<?php echo $consumible['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este consumible?');">Eliminar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>
</body>
</html>

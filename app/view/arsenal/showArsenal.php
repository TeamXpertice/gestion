<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsenal</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">

</head>
<body>
            <div class="container mt-1">
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
                            <th>Categoria</th>
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
                            <th>Categoria</th>
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
                            <td><?php echo htmlspecialchars($consumible['categoria']); ?></td>
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
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#consumiblesTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ]
            });
        });
    </script>
    </body>
</html>

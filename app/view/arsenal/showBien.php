<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsenal - Bienes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
</head>
<body>
    <div class="container mt-1">
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
                    <th>Color</th>
                    <th>Estado Físico</th>
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
                    <td><?php echo htmlspecialchars($bien['color']); ?></td>
                    <td><?php echo htmlspecialchars($bien['estado_fisico_actual']); ?></td>
                    <td><?php echo htmlspecialchars($bien['observacion']); ?></td>
                    <td>
                        <a href="/gestion/app/controller/ArsenalController.php?action=editBien&id=<?php echo $bien['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="/gestion/app/controller/ArsenalController.php?action=deleteBien&id=<?php echo $bien['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este bien?');">Eliminar</a>
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
            $('.table').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json" // Configuración de idioma en español
                },
                dom: 'Bfrtip', // Botones de exportación
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Excel',
                        title: 'Bienes_Registrados' // Título del archivo exportado
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Bienes_Registrados' // Título del archivo exportado
                    },
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        title: 'Bienes Registrados' // Título en la impresión
                    }
                ]
            });
        });
    </script>
</body>
</html>

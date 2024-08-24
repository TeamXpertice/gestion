<?php
$totalGanancia = 0;

if (!empty($ventas)) {
    foreach ($ventas as $venta) {
        $totalGanancia += $venta['total'];
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas Registradas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
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
            <table id="ventasTable" class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio Total</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ventas)): ?>
                        <?php foreach ($ventas as $venta): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($venta['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($venta['cantidad']); ?></td>
                                <td><?php echo htmlspecialchars($venta['total']); ?></td>
                                <td><?php echo htmlspecialchars($venta['fecha']); ?></td>
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


        <div class="alert alert-info mt-4">

            <strong>Total del Día: </strong><?php echo number_format($totalGanancia, 2); ?> Soles
        </div>
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
            var table = $('#ventasTable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        text: 'Excel',
                        title: 'Ventas_Registradas'
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Ventas_Registradas',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        title: 'Ventas Registradas',
                        customize: function(win) {
                            $(win.document.body).append('<div class="alert alert-info"><strong>Ganancia Total del Día: </strong><?php echo number_format($totalGanancia, 2); ?> USD</div>');
                        }
                    }
                ]
            });
        });
    </script>
</body>

</html>
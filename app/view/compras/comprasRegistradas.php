<?php
$totalGasto = 0;

if (!empty($compras)) {
    foreach ($compras as $compra) {
        $totalGasto += $compra['total'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Compras</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Registro de Compras</h1>
        <div class="mb-4">
            <form action="/gestion/app/controller/ComprasController.php" method="get">
                <input type="hidden" name="action" value="showRegistroCompras">
                <input type="date" name="date" value="<?php echo htmlspecialchars($selectedDate); ?>" class="form-control" onchange="this.form.submit()">
            </form>
        </div>
        <div class="table-responsive">
            <table id="comprasTable" class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Costo Unitario</th>
                        <th>Total</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($compras)): ?>
                        <?php foreach ($compras as $compra): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($compra['descripcion_compra'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($compra['cantidad'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($compra['costo_unitario'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($compra['total'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($compra['fecha'] ?? ''); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No hay compras registradas para esta fecha.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="alert alert-info mt-4">
            <strong>Total del Día: </strong><?php echo number_format($totalGasto, 2); ?> Soles
        </div>
    </div>

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
            var table = $('#comprasTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                dom: 'Bfrtip', 
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Excel',
                        title: 'Compras_Registradas'
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Compras_Registradas',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        title: 'Compras Registradas',
                        customize: function (win) {
                            $(win.document.body).append('<div class="alert alert-info"><strong>Gasto Total del Día: </strong><?php echo number_format($totalGasto, 2); ?> Soles</div>');
                        }
                    }
                ]
            });
        });
    </script>
</body>
</html>

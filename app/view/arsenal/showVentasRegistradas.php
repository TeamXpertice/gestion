<?php
$totalGanancia = 0;
$totalesPorMetodo = [
    'Efectivo' => 0,
    'Visa' => 0,
    'Yape' => 0,
    'Plin' => 0,
];

if (!empty($ventas)) {
    foreach ($ventas as $venta) {
        $totalGanancia += $venta['total'];
        $metodo_pago = $venta['metodo_pago'];
        if (isset($totalesPorMetodo[$metodo_pago])) {
            $totalesPorMetodo[$metodo_pago] += $venta['total'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas Registradas</title>
    <link href="/gestion/public/css/stackpathbootstrap4.5.2.css/bootstrap.min.css" rel="stylesheet">
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
                                <td><?php echo htmlspecialchars($venta['cantidad_total']); ?></td>
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

        <div class="row mt-4">
            <div class="col-md-5 d-flex align-items-center">
                <div class="alert alert-info w-100">
                    <strong>Total del Día: </strong><?php echo number_format($totalGanancia, 2); ?> Soles
                </div>
            </div>
            <div class="col-md-7 d-flex align-items-center">
                <div class="w-100">
                    <?php foreach ($totalesPorMetodo as $metodo => $total): ?>
                        <?php if ($total > 0): ?>
                            <div class="alert alert-<?php echo $metodo == 'Efectivo' ? 'primary' : ($metodo == 'Visa' ? 'success' : ($metodo == 'Yape' ? 'warning' : 'info')); ?> mt-2">
                                <strong><?php echo htmlspecialchars($metodo); ?>:</strong>
                                <?php echo number_format($total, 2); ?> Soles
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
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
                            var totalGanancia = <?php echo json_encode(number_format($totalGanancia, 2)); ?>;
                            var resumenMetodos = <?php echo json_encode(array_filter($totalesPorMetodo, function($total) { return $total > 0; })); ?>;

                            $(win.document.body).append(
                                '<div class="alert alert-info mt-4">' +
                                    '<strong>Total del Día: </strong>' + totalGanancia + ' Soles' +
                                '</div>' +
                                '<h2 class="mt-4">Resumen por Método de Pago</h2>' +
                                '<div class="mt-4">' +
                                    Object.keys(resumenMetodos).map(function(metodo) {
                                        var total = resumenMetodos[metodo];
                                        var alertClass = metodo === 'Efectivo' ? 'primary' : 
                                                         metodo === 'Visa' ? 'success' : 
                                                         metodo === 'Yape' ? 'warning' :
                                                         metodo === 'Plin' ? 'danger' :  
                                                         'info';    
                                        return '<div class="alert alert-' + alertClass + ' mt-2">' +
                                                '<strong>' + metodo + ':</strong> ' +
                                                total.toFixed(2) + ' Soles' +
                                               '</div>';
                                    }).join('')
                                + '</div>'
                            );
                        }
                    }
                ]
            });
        });
    </script>
</body>
</html>

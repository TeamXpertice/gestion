<?php
$totalGasto = 0;
$totalesPorMetodo = [
    'Efectivo' => 0,
    'Visa' => 0,
    'Yape' => 0,
    'Plin' => 0,
];

if (!empty($compras)) {
    foreach ($compras as $compra) {
        $totalGasto += $compra['total'];
        $metodo_pago = $compra['metodo_pago'];
        if (isset($totalesPorMetodo[$metodo_pago])) {
            $totalesPorMetodo[$metodo_pago] += $compra['total'];
        }
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
                    <th>Fecha de Compra</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($compras)): ?>
                    <?php foreach ($compras as $compra): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($compra['descripcion_compra']); ?></td>
                        <td><?php echo htmlspecialchars($compra['cantidad']); ?></td>
                        <td><?php echo htmlspecialchars($compra['costo_unitario']); ?></td>
                        <td><?php echo htmlspecialchars($compra['total']); ?></td>
                        <td><?php echo htmlspecialchars($compra['fecha_compra']); ?></td>
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

    <div class="row mt-4">
        <div class="col-md-5 d-flex align-items-center">
            <div class="alert alert-info w-100">
                <strong>Total del Día: </strong><?php echo number_format($totalGasto, 2); ?> Soles
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
                    var totalGasto = <?php echo json_encode(number_format($totalGasto, 2)); ?>;
                    var resumenMetodos = <?php echo json_encode(array_filter($totalesPorMetodo, function($total) { return $total > 0; })); ?>;

                    $(win.document.body).append(
                        '<div class="alert alert-info mt-4">' +
                            '<strong>Total del Día: </strong>' + totalGasto + ' Soles' +
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

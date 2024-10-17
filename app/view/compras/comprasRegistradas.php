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
                    <th>Nombre</th>
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
                        <td><?php echo htmlspecialchars($compra['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($compra['cantidad']); ?></td>
                        <td><?php echo htmlspecialchars($compra['costo_unitario']); ?></td>
                        <td><?php echo htmlspecialchars($compra['total']); ?></td>
                        <td><?php echo htmlspecialchars($compra['fecha']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>

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

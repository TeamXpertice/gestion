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

<div class="col-sm-6">
    <h3 class="mb-0">Registro de Compras</h3>
</div>


<div class="col-sm-6">
    <ol class="breadcrumb float-sm-end">
        <li class="breadcrumb-item"><a href="/gestion/app/controller/DashboardController.php?action=showDashboard">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">
            Registro Compras
        </li>
    </ol>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="row">



            <div class="mb-4">
                <form action="/gestion/app/controller/ComprasController.php" method="get">
                    <input type="hidden" name="action" value="showRegistroCompras">
                    <input type="date" name="date" value="<?php echo htmlspecialchars($selectedDate); ?>" class="form-control" onchange="this.form.submit()">
                </form>
            </div>

            <div class="mb-4">
                <a href="/gestion/app/controller/ComprasController.php?action=showRegistroCompras&type=all&date=<?php echo $selectedDate; ?>" class="btn btn-success">Mostrar Todas</a>
                <a href="/gestion/app/controller/ComprasController.php?action=showRegistroCompras&type=normales&date=<?php echo $selectedDate; ?>" class="btn btn-danger">Mostrar Compras Normales</a>
                <a href="/gestion/app/controller/ComprasController.php?action=showRegistroCompras&type=consumibles&date=<?php echo $selectedDate; ?>" class="btn btn-info">Mostrar Compras Consumibles</a>
            </div>

            <div class="table-responsive">
                <table id="comprasTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Costo Unitario</th>
                            <th>Total</th>
                            <th>Fecha de Compra</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($compras_normales)): ?>
                            <?php foreach ($compras_normales as $compra): ?>
                                <tr class="normales">
                                    <td><?php echo htmlspecialchars($compra['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($compra['cantidad']); ?></td>
                                    <td><?php echo htmlspecialchars($compra['costo_unitario']); ?></td>
                                    <td><?php echo htmlspecialchars($compra['total']); ?></td>
                                    <td><?php echo htmlspecialchars($compra['fecha']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (!empty($compras_consumibles)): ?>
                            <?php foreach ($compras_consumibles as $compra): ?>
                                <tr class="consumibles">
                                    <td><?php echo htmlspecialchars($compra['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($compra['cantidad']); ?></td>
                                    <td><?php echo htmlspecialchars($compra['costo_unitario']); ?></td>
                                    <td><?php echo htmlspecialchars($compra['total']); ?></td>
                                    <td><?php echo htmlspecialchars($compra['fecha']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (empty($compras_normales) && empty($compras_consumibles)): ?>
                            <tr>
                                <td colspan="5" class="text-center">No se encontraron registros.</td>
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
    </div>
</div>
<div class="col-sm-6">
    <h5 class="mb-0">Registro de Ventas - <?php echo date('d/m/Y', strtotime($selectedDate)); ?></h5>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-end">
        <li class="breadcrumb-item"><a href="/gestion/app/controller/DashboardController.php?action=showDashboard">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">
            Registros
        </li>
    </ol>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">

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

            <div class="mb-4">
                <form action="/gestion/app/controller/ArsenalController.php" method="get">
                    <input type="hidden" name="action" value="showVentasRegistradas">
                    <input type="date" name="date" value="<?php echo htmlspecialchars($selectedDate); ?>" class="form-control" onchange="this.form.submit()" style="color: black">
                </form>
            </div>

            <div class="card-body">
                <div class="table-responsive mt-8">
                    <table id="ventasTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Cantidad</th>
                                <th>Precio Total</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ventas)): ?>
                                <?php foreach ($ventas as $venta): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($venta['nombre_consumible']); ?></td>
                                        <td><?php echo htmlspecialchars($venta['categoria']); ?></td>
                                        <td><?php echo htmlspecialchars($venta['cantidad_total']); ?></td>
                                        <td><?php echo htmlspecialchars($venta['total']); ?></td>
                                        <td><?php echo htmlspecialchars($venta['fecha']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay ventas registradas.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: center;"></td> <!-- Celdas vacías para las otras columnas -->
                                <td id="totalSum" style="text-align: center;">Total: 0 Soles</td> <!-- Aquí aparecerá la suma -->
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                </div>

                <div class="row mt-4">
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="alert alert-info w-100">
                            <strong>Total del Día: </strong><span id="totalDia"><?php echo number_format($totalGanancia, 2); ?></span> Soles
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-3">
                                <div class="alert alert-primary w-100">
                                    <strong>Efectivo: </strong><span class="metodo-efectivo"><?php echo number_format($totalesPorMetodo['Efectivo'], 2); ?></span> Soles
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="alert alert-success w-100">
                                    <strong>Visa: </strong><span class="metodo-visa"><?php echo number_format($totalesPorMetodo['Visa'], 2); ?></span> Soles
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="alert alert-warning w-100">
                                    <strong>Yape: </strong><span class="metodo-yape"><?php echo number_format($totalesPorMetodo['Yape'], 2); ?></span> Soles
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="alert alert-info w-100">
                                    <strong>Plin: </strong><span class="metodo-plin"><?php echo number_format($totalesPorMetodo['Plin'], 2); ?></span> Soles
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
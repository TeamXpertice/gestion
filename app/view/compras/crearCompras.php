
<div class="col-sm-6">
    <h3 class="mb-0">Registrar Nueva Compra</h3>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-end">
        <li class="breadcrumb-item"><a href="/gestion/app/controller/DashboardController.php?action=showDashboard">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">
            Ventas
        </li>
    </ol>
</div>

<div class="app-content"> 
    <div class="container-fluid"> 
        <div class="row">

    <div class="mb-4">
        <button class="btn btn-primary" data-toggle="modal" data-target="#crearComprasComunesModal">Registrar una Compra</button>
    </div>

    <div class="modal fade" id="crearComprasComunesModal" tabindex="-1" aria-labelledby="crearComprasComunesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearComprasComunesModalLabel">Registrar Nueva Compra Común</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="compraComunForm">
                    <div class="form-group">
                        <label for="descripcion_compra">Descripción</label>
                        <input type="text" class="form-control" id="descripcion_compra" name="descripcion_compra" required>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" required min="1" step="1">
                    </div>
                    <div class="form-group">
                        <label for="costo_unitario">Costo Unitario</label>
                        <input type="number" step="0.01" class="form-control" id="costo_unitario" name="costo_unitario" required min="0.01">
                    </div>
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="number" step="0.01" class="form-control" id="total" name="total" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha de Compra</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required>
                    </div>
                    <div class="form-group">
                        <label for="proveedor">Proveedor</label>
                        <input type="text" class="form-control" id="proveedor" name="proveedor">
                    </div>
                    <div class="form-group">
                        <label for="metodo_pago">Método de Pago</label>
                        <select id="metodo_pago" name="metodo_pago" class="form-control">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Visa">Visa</option>
                            <option value="Yape">Yape</option>
                            <option value="Plin">Plin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="observacion">Observación</label>
                        <textarea class="form-control" id="observacion" name="observacion"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar Compra</button>
                </form>
            </div>
        </div>
    </div>
</div>



    <div class="row">
        <div class="col-md-7">
            <h3>Tipos de Material</h3>
            <div id="materialList" class="category-grid">
                <?php
                $colors = ['red', 'blue', 'green', 'orange', 'purple', 'teal', 'yellow'];

                if (!empty($categorias)) {
                    foreach ($categorias as $index => $categoria) {
                        $colorClass = $colors[$index % count($colors)];
                        ?>
                        <button type="button" class="category-button category-<?php echo $colorClass; ?>" onclick="mostrarConsumiblesPorCategoria(<?php echo $categoria['id']; ?>)">
                            <?php echo htmlspecialchars($categoria['nombre']); ?>
                        </button>
                        <?php
                    }
                } else {
                    echo "<p>No se encontraron categorías.</p>";
                }
                ?>
            </div>

            <div id="consumiblesList" class="mt-4"></div>
        </div>

        <div class="col-md-5">
            <h3>Previsualización de Compra</h3>
            <div id="compraPreview">
                <p>No hay productos seleccionados.</p>
            </div>
            <div id="totalCompra" class="mt-3"></div>
            <form id="compraConsumiblesForm" method="post">
                <input type="hidden" id="productosSeleccionados" name="productosSeleccionados">
                <div class="form-group">
                    <label for="metodoCompra">Método de Compra:</label>
                    <select class="form-control" id="metodoCompra" name="metodoCompra">
                        <option value="efectivo">Efectivo</option>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="transferencia">Transferencia</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Registrar Compra</button>
            </form>
        </div>
    </div>


</div>
</div>
</div>


    <style>
        .category-button {
            border-radius: 20px;
            margin-bottom: 5px;
            padding: 8px 15px;
            font-size: 14px;
            color: white;
            cursor: pointer;
            text-align: center;
            border: none;
            display: inline-block;
            width: 100%;
        }

        .category-button:hover {
            opacity: 0.8;
        }

        .category-red {
            background-color: #e74c3c;
        }

        .category-blue {
            background-color: #3498db;
        }

        .category-green {
            background-color: #2ecc71;
        }

        .category-orange {
            background-color: #e67e22;
        }

        .category-purple {
            background-color: #9b59b6;
        }

        .category-teal {
            background-color: #1abc9c;
        }

        .category-yellow {
            background-color: #f1c40f;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>

    <div class="container mt-1">
        <h2>Registrar Nueva Compra</h2>

        <div class="mb-4">
            <button class="btn btn-primary" data-toggle="modal" data-target="#createCompraModal">Registrar Nueva Compra Común</button>
        </div>

        <!-- Modal para Compra Normal -->
        <div class="modal fade" id="createCompraModal" tabindex="-1" aria-labelledby="createCompraModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCompraModalLabel">Registrar Nueva Compra Común</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="compraNormalForm" method="post">
                            <div class="form-group">
                                <label for="descripcion_compra">Descripción</label>
                                <input type="text" class="form-control" id="descripcion_compra" name="descripcion_compra" required>
                            </div>
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                            </div>
                            <div class="form-group">
                                <label for="costo_unitario">Costo Unitario</label>
                                <input type="number" step="0.01" class="form-control" id="costo_unitario" name="costo_unitario" required>
                            </div>
                            <div class="form-group">
                                <label for="total">Total</label>
                                <input type="number" step="0.01" class="form-control" id="total" name="total" required disabled>
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

        <!-- Interfaz de Categorías y Previsualización -->
        <div class="row">
            <div class="col-md-6">
                <h3>Tipos de Material</h3>
                <div class="row" id="materialList">
                    <?php
                    $colors = ['red', 'blue', 'green', 'orange', 'purple', 'teal', 'yellow'];
                    $numColumns = 7;
                    $colWidth = 12 / $numColumns;

                    if (!empty($categorias)) {
                        foreach ($categorias as $index => $categoria):
                            $colorClass = $colors[$index % count($colors)];
                            if ($index % $numColumns == 0 && $index != 0):
                                echo '</div><div class="row">';
                            endif;
                    ?>
                            <div class="col-<?php echo $colWidth; ?>">
                                <button type="button" class="category-button category-<?php echo $colorClass; ?>" onclick="mostrarConsumiblesPorCategoria(<?php echo $categoria['id']; ?>)">
                                    <?php echo htmlspecialchars($categoria['nombre']); ?>
                                </button>
                            </div>
                    <?php
                        endforeach;
                    } else {
                        echo "<p>No se encontraron categorías.</p>";
                    }
                    ?>
                </div>
                <div id="consumiblesList" class="mt-4"></div>
            </div>

            <div class="col-md-6">
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


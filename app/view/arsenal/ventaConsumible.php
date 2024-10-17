
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

        .category-red { background-color: #e74c3c; }
        .category-blue { background-color: #3498db; }
        .category-green { background-color: #2ecc71; }
        .category-orange { background-color: #e67e22; }
        .category-purple { background-color: #9b59b6; }
        .category-teal { background-color: #1abc9c; }
        .category-yellow { background-color: #f1c40f; }

        .disabled {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>

    <div class="container mt-1">
        <h2>Registrar Venta de Consumible</h2>
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
                <div id="consumiblesList" class="mt-4">
                </div>
            </div>

            <div class="col-md-6">
                <h3>Previsualización de Venta</h3>
                <div id="ventaPreview">
                    <p>No hay productos seleccionados.</p>
                </div>
                <div id="totalVenta" class="mt-3"></div>

                <form id="ventaForm" action="/gestion/app/controller/ArsenalController.php?action=createVentaConsumible" method="post" class="mt-4">
                    <input type="hidden" id="productosSeleccionados" name="productosSeleccionados">


                    <div class="form-group">
                        <label for="metodo_pago">Método de Pago</label>
                        <select id="metodo_pago" name="metodo_pago" class="form-control">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Visa">Visa</option>
                            <option value="Yape">Yape</option>
                            <option value="Plin">Plin</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Registrar Venta</button>
                </form>
            </div>
        </div>
    </div>



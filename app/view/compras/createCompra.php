<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Compras</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
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
</head>
<body>
    <div class="container mt-5">
        <div class="row">

            <div class="col-md-6">
                <h2>Reposición de Stock</h2>
                <h3>Categorías</h3>
                <?php if (!empty($categorias)): ?>
    <div class="row" id="materialList">
        <?php
        $colors = ['red', 'blue', 'green', 'orange', 'purple', 'teal', 'yellow'];
        $numColumns = 7;
        $colWidth = 12 / $numColumns;

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
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No se encontraron categorías.</p>
<?php endif; ?>

                <div id="consumiblesList" class="mt-4"></div>
            </div>


            <div class="col-md-6">
                <h2>Registrar Nueva Compra</h2>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createCompraModal">Registrar Nueva Compra</button>
            </div>
        </div>
    </div>


    <div class="modal fade" id="reponerStockModal" tabindex="-1" aria-labelledby="reponerStockModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reponerStockModalLabel">Reponer Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="reponerStockForm">
                        <input type="hidden" id="consumibleId" name="consumibleId">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                        </div>
                        <div class="form-group">
                            <label for="observacion">Observación</label>
                            <textarea class="form-control" id="observacion" name="observacion"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Reponer Stock</button>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="createCompraModal" tabindex="-1" aria-labelledby="createCompraModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCompraModalLabel">Registrar Nueva Compra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/gestion/app/controller/ComprasController.php?action=createCompra" method="post">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                        </div>
                        <div class="form-group">
                            <label for="costo_unitario">Costo Unitario</label>
                            <input type="text" class="form-control" id="costo_unitario" name="costo_unitario" required>
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function mostrarConsumiblesPorCategoria(categoriaId) {
            $.ajax({
                url: '/gestion/app/controller/ArsenalController.php',
                type: 'GET',
                data: {
                    action: 'getConsumiblesPorCategoria',
                    categoria_id: categoriaId
                },
                success: function(response) {
                    var consumibles = JSON.parse(response);
                    var html = '<table class="table table-bordered"><thead class="thead-dark"><tr><th>Nombre</th><th>Stock</th><th>Precio</th><th>Costo</th><th>Acción</th></tr></thead><tbody>';
                    consumibles.forEach(function(consumible) {
                        html += '<tr>';
                        html += '<td>' + consumible.nombre + '</td>';
                        html += '<td>' + consumible.stock + '</td>';
                        html += '<td>' + consumible.precio + '</td>';
                        html += '<td>' + consumible.costo + '</td>';
                        html += '<td><button class="btn btn-primary" onclick="abrirModalReponerStock(' + consumible.id + ', \'' + consumible.nombre + '\')">Reponer</button></td>';
                        html += '</tr>';
                    });
                    html += '</tbody></table>';
                    $('#consumiblesList').html(html);
                }
            });
        }

        function abrirModalReponerStock(consumibleId, nombreConsumible) {
            $('#consumibleId').val(consumibleId);
            $('#reponerStockModalLabel').text('Reponer Stock para ' + nombreConsumible);
            $('#reponerStockModal').modal('show');
        }

        $('#reponerStockForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '/gestion/app/controller/ComprasController.php',
                type: 'POST',
                data: $(this).serialize() + '&action=reponerStock',
                success: function(response) {
                    $('#reponerStockModal').modal('hide');
                    $('#consumiblesList').html(''); // Limpiar lista de consumibles
                    mostrarConsumiblesPorCategoria($('#categoriaId').val()); // Refrescar lista de consumibles
                }
            });
        });
    </script>
</body>
</html>

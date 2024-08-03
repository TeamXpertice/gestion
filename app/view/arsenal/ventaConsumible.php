<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta de Consumible</title>
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
    </style>
</head>
<body>
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
                    $columnIndex = 0;

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
                <form id="ventaForm" action="/gestion/app/controller/ArsenalController.php?action=createVentaConsumible" method="post" class="mt-4">
                    <input type="hidden" id="productosSeleccionados" name="productosSeleccionados">
                    <button type="submit" class="btn btn-primary">Registrar Venta</button>
                </form>
            </div>
        </div>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        var productosSeleccionados = [];

        function mostrarConsumibles(categoria) {
            $.ajax({
                url: '/gestion/app/controller/ArsenalController.php',
                type: 'GET',
                data: {
                    action: 'getConsumiblesPorTipo',
                    categoria: categoria
                },
                success: function(response) {
                    var consumibles = JSON.parse(response);
                    var html = '<table class="table table-bordered"><thead class="thead-dark"><tr><th>Nombre</th><th>Stock</th><th>Precio</th><th>Acción</th></tr></thead><tbody>';
                    consumibles.forEach(function(consumible) {
                        html += '<tr><td>' + consumible.nombre + '</td><td>' + consumible.stock + '</td><td>' + consumible.precio + '</td><td><button type="button" class="btn btn-success" onclick="agregarProducto(' + consumible.id + ', \'' + consumible.nombre + '\', ' + consumible.precio + ')">Agregar</button></td></tr>';
                    });
                    html += '</tbody></table>';
                    $('#consumiblesList').html(html);
                }
            });
        }

        function agregarProducto(id, nombre, precio) {
            productosSeleccionados.push({ id: id, nombre: nombre, precio: precio });
            actualizarPrevisualizacion();
        }

        function actualizarPrevisualizacion() {
            if (productosSeleccionados.length > 0) {
                var html = '<ul class="list-group">';
                productosSeleccionados.forEach(function(producto) {
                    html += '<li class="list-group-item d-flex justify-content-between align-items-center">' + producto.nombre + '<span class="badge badge-primary badge-pill">$' + producto.precio + '</span></li>';
                });
                html += '</ul>';
            } else {
                html = '<p>No hay productos seleccionados.</p>';
            }
            $('#ventaPreview').html(html);
            $('#productosSeleccionados').val(JSON.stringify(productosSeleccionados));
        }
        function mostrarConsumiblesPorCategoria(categoriaId) {
    $.ajax({
        url: '/gestion/app/controller/ArsenalController.php',
        type: 'GET',
        data: {
            action: 'getConsumiblesPorCategoria',
            categoria_id: categoriaId
        },
        success: function(response) {
            try {
                var consumibles = JSON.parse(response);
                var html = '<table class="table table-bordered"><thead class="thead-dark"><tr><th>Nombre</th><th>Stock</th><th>Precio</th><th>Acción</th></tr></thead><tbody>';
                consumibles.forEach(function(consumible) {
                    html += '<tr><td>' + consumible.nombre + '</td><td>' + consumible.stock + '</td><td>' + consumible.precio + '</td><td><button type="button" class="btn btn-success" onclick="agregarProducto(' + consumible.id + ', \'' + consumible.nombre + '\', ' + consumible.precio + ')">Agregar</button></td></tr>';
                });
                html += '</tbody></table>';
                $('#consumiblesList').html(html);
            } catch (e) {
                console.error('Error parsing JSON response:', e);
                $('#consumiblesList').html('<p>Error al cargar los consumibles.</p>');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            $('#consumiblesList').html('<p>Error al cargar los consumibles.</p>');
        }
    });
}


    </script>
    
</body>
</html>

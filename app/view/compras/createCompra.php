<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nueva Compra</title>
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
</head>

<body>
    <div class="container mt-1">
        <h2>Registrar Nueva Compra</h2>

        <!-- Botón para abrir el modal -->
        <div class="mb-4">
            <button class="btn btn-primary" data-toggle="modal" data-target="#createCompraModal">Registrar Nueva Compra Comun</button>
        </div>

        <!-- Modal de Registrar Nueva Compra -->
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

        <div class="row">
            <!-- Listado de Categorías -->
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
                    <!-- Aquí se mostrarán los consumibles al seleccionar una categoría -->
                </div>
            </div>

            <!-- Previsualización y Registro de la Compra -->
            <div class="col-md-6">
                <h3>Previsualización de Compra</h3>
                <div id="compraPreview">
                    <p>No hay productos seleccionados.</p>
                </div>
                <div id="totalCompra" class="mt-3">
                    <!-- Aquí se mostrará el total de la compra -->
                </div>
                <form id="compraForm" action="/gestion/app/controller/ComprasController.php?action=createCompra" method="post" class="mt-4">
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
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        var productosSeleccionados = [];

        $('#compraForm').on('submit', function(e) {
            e.preventDefault();

            if (productosSeleccionados.length === 0) {
                alert('Debes seleccionar al menos un producto para registrar la compra.');
                return;
            }

            $.ajax({
    url: '/gestion/app/controller/ComprasController.php?action=createCompra',
    type: 'POST',
    data: {
        descripcion: $('#descripcion').val(),
        cantidad: $('#cantidad').val(),
        costo_unitario: $('#costo_unitario').val(),
        fecha: $('#fecha').val(),
        proveedor: $('#proveedor').val(),
        metodo_pago: $('#metodo_pago').val(),
        observacion: $('#observacion').val()
    },
    success: function(response) {
        try {
            var json = JSON.parse(response);
            if (json.success) {
                // Manejar el éxito
                alert('Compra registrada exitosamente.');
            } else {
                // Manejar errores
                alert('Error: ' + json.error);
            }
        } catch (e) {
            console.error('Error al analizar JSON:', e);
        }
    },
    error: function(xhr, status, error) {
        console.error('Error en la solicitud AJAX:', status, error);
    }
});


        });

        function mostrarConsumiblesPorCategoria(categoriaId) {
            $('#categoriaActual').val(categoriaId); // Guardar la categoría seleccionada

            $.ajax({
                url: '/gestion/app/controller/ComprasController.php',
                type: 'GET',
                data: {
                    action: 'getConsumiblesPorCategoria',
                    categoria_id: categoriaId
                },
                success: function(response) {
                    console.log(response);
                    try {
                        var consumibles = JSON.parse(response);
                        var html = '';
                        // Convertir la respuesta en un objeto JSON
                        if (consumibles.length > 0) {
                            html += '<ul class="list-group">';
                            consumibles.forEach(function(consumible) {
                                var disabledClass = consumible.stock === 0 ? 'disabled' : '';
                                html += '<li class="list-group-item ' + disabledClass + '">' +
                                    '<strong>' + consumible.nombre + '</strong><br>' +
                                    'Stock: ' + consumible.stock + '<br>' +
                                    'Costo: $' + consumible.coste + '<br>' +
                                    '<button class="btn btn-sm btn-primary mt-2 ' + disabledClass + '" onclick="agregarProducto(' + consumible.id + ', \'' + consumible.nombre + '\', ' + consumible.coste + ', ' + consumible.stock + ')">Agregar</button>' +
                                    '</li>';
                            });
                            html += '</ul>';
                        } else {
                            html = '<p>No hay consumibles en esta categoría.</p>';
                        }

                        $('#consumiblesList').html(html);
                    } catch (e) {
                        console.error('Error al analizar JSON:', e);
                        alert('Ocurrió un error al cargar los consumibles.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                    alert('Ocurrió un error. Inténtelo de nuevo.');
                }
            });
        }

        function agregarProducto(id, nombre, coste, stock) {
            var productoExistente = productosSeleccionados.find(function(producto) {
                return producto.id === id;
            });

            if (productoExistente) {
                if (productoExistente.cantidad < stock) {
                    productoExistente.cantidad++;
                } else {
                    alert('No hay suficiente stock para agregar más unidades.');
                }
            } else {
                if (stock > 0) {
                    productosSeleccionados.push({
                        id: id,
                        nombre: nombre,
                        cantidad: 1,
                        coste: coste,
                        observacion: ''
                    });
                } else {
                    alert('Este producto no tiene stock disponible.');
                }
            }

            actualizarPrevisualizacion();
        }

        function actualizarPrevisualizacion() {
            var html = '';
            var total = 0;

            if (productosSeleccionados.length > 0) {
                html += '<ul class="list-group">';
                productosSeleccionados.forEach(function(producto, index) {
                    var subtotal = producto.cantidad * producto.coste;
                    total += subtotal;
                    html += '<li class="list-group-item">' +
                        '<strong>' + producto.nombre + '</strong><br>' +
                        'Cantidad: ' + producto.cantidad + '<br>' +
                        'Subtotal: $' + subtotal.toFixed(2) + '<br>' +
                        'Observación: ' + (producto.observacion ? producto.observacion : 'Ninguna') + '<br>' +
                        '<button class="btn btn-sm btn-secondary mt-2" onclick="incrementarCantidad(' + index + ')">+</button> ' +
                        '<button class="btn btn-sm btn-secondary mt-2" onclick="decrementarCantidad(' + index + ')">-</button> ' +
                        '<button class="btn btn-sm btn-warning mt-2" onclick="editarObservacion(' + index + ')">Editar Observación</button>' +
                        '</li>';
                });
                html += '</ul>';
                $('#compraPreview').html(html);
                $('#totalCompra').html('<h4>Total: $' + total.toFixed(2) + '</h4>');
                $('#productosSeleccionados').val(JSON.stringify(productosSeleccionados));
            } else {
                $('#compraPreview').html('<p>No hay productos seleccionados.</p>');
                $('#totalCompra').html('');
                $('#productosSeleccionados').val('');
            }
        }

        function incrementarCantidad(index) {
            productosSeleccionados[index].cantidad++;
            actualizarPrevisualizacion();
        }

        function decrementarCantidad(index) {
            if (productosSeleccionados[index].cantidad > 1) {
                productosSeleccionados[index].cantidad--;
            } else {
                productosSeleccionados.splice(index, 1);
            }
            actualizarPrevisualizacion();
        }

        function editarObservacion(index) {
            var nuevaObservacion = prompt('Ingrese la nueva observación:', productosSeleccionados[index].observacion);
            if (nuevaObservacion !== null) {
                productosSeleccionados[index].observacion = nuevaObservacion;
            }
            actualizarPrevisualizacion();
        }
    </script>
</body>

</html>
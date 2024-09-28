<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nueva Compra</title>
    <link href="/gestion/public/css/stackpathbootstrap4.5.2.css/bootstrap.min.css" rel="stylesheet">
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
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>

    <!-- Scripts de jQuery y Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script Personalizado -->
    <script>
        let productosSeleccionados = [];

        // Función para agregar producto a la previsualización
        function agregarProducto(id, nombre, costo, precio, fecha_vencimiento, stock) {
            let productoExistente = productosSeleccionados.find(producto => producto.id === id);

            if (productoExistente) {
                if (productoExistente.cantidad < stock) {
                    productoExistente.cantidad++;
                } else {
                    alert('No hay suficiente stock disponible.');
                    return;
                }
            } else {
                productosSeleccionados.push({
                    id: id,
                    nombre: nombre,
                    cantidad: 1,
                    costo: parseFloat(costo),
                    precio: parseFloat(precio),
                    fecha_vencimiento: fecha_vencimiento,
                    stock: stock
                });
            }

            actualizarPrevisualizacion();
        }

        // Función para actualizar la previsualización de la compra con campos editables
        function actualizarPrevisualizacion() {
            let html = '';
            let total = 0;

            if (productosSeleccionados.length > 0) {
                html += '<ul class="list-group">';
                productosSeleccionados.forEach(function(producto, index) {
                    let subtotal = producto.cantidad * producto.costo;
                    total += subtotal;
                    html += '<li class="list-group-item">' +
                        '<strong>' + producto.nombre + '</strong><br>' +
                        'Cantidad: <input type="number" value="' + producto.cantidad + '" min="1" max="' + producto.stock + '" onchange="actualizarCantidad(' + index + ', this.value)" style="width: 60px;"><br>' +
                        'Subtotal: <input type="text" value="' + subtotal.toFixed(2) + '" onchange="actualizarSubtotal(' + index + ', this.value)" style="width: 100px;"> S/.' + '<br>' +
                        'Precio de Venta: <input type="text" value="' + producto.precio.toFixed(2) + '" onchange="actualizarPrecio(' + index + ', this.value)" style="width: 100px;"> S/.' + '<br>' +
                        'Fecha de Compra: <input type="date" value="' + new Date().toISOString().split('T')[0] + '" onchange="actualizarFechaCompra(' + index + ', this.value)" style="width: 150px;"><br>' +
                        'Fecha de Vencimiento: <input type="date" value="' + producto.fecha_vencimiento + '" onchange="actualizarFechaVencimiento(' + index + ', this.value)" style="width: 150px;"><br>' +
                        '<button class="btn btn-sm btn-secondary mt-2" onclick="incrementarCantidad(' + index + ')">+</button> ' +
                        '<button class="btn btn-sm btn-secondary mt-2" onclick="decrementarCantidad(' + index + ')">-</button>' +
                        '</li>';
                });
                html += '</ul>';
                $('#compraPreview').html(html);
                $('#totalCompra').html('<h4>Total: S/.' + total.toFixed(2) + '</h4>');
                $('#productosSeleccionados').val(JSON.stringify(productosSeleccionados));
            } else {
                $('#compraPreview').html('<p>No hay productos seleccionados.</p>');
                $('#totalCompra').html('');
                $('#productosSeleccionados').val('');
            }
        }

        // Funciones para actualizar cada campo editable
        function actualizarCantidad(index, nuevaCantidad) {
            if (nuevaCantidad <= productosSeleccionados[index].stock) {
                productosSeleccionados[index].cantidad = parseInt(nuevaCantidad);
                actualizarPrevisualizacion();
            } else {
                alert('No hay suficiente stock disponible.');
            }
        }

        function actualizarSubtotal(index, nuevoSubtotal) {
            productosSeleccionados[index].costo = parseFloat(nuevoSubtotal) / productosSeleccionados[index].cantidad;
            actualizarPrevisualizacion();
        }

        function actualizarPrecio(index, nuevoPrecio) {
            productosSeleccionados[index].precio = parseFloat(nuevoPrecio);
            actualizarPrevisualizacion();
        }

        function actualizarFechaCompra(index, nuevaFecha) {
            productosSeleccionados[index].fecha_compra = nuevaFecha;
        }

        function actualizarFechaVencimiento(index, nuevaFecha) {
            productosSeleccionados[index].fecha_vencimiento = nuevaFecha;
        }

        function incrementarCantidad(id) {
            let producto = productosSeleccionados.find(p => p.id === id);
            if (producto && producto.cantidad < producto.stock) {
                producto.cantidad++;
                actualizarPrevisualizacion();
            } else {
                alert('No hay suficiente stock disponible.');
            }
        }

        function decrementarCantidad(id) {
            let producto = productosSeleccionados.find(p => p.id === id);
            if (producto) {
                if (producto.cantidad > 1) {
                    producto.cantidad--;
                } else {
                    productosSeleccionados = productosSeleccionados.filter(p => p.id !== id); // Eliminar producto si cantidad es 0
                }
                actualizarPrevisualizacion();
            }
        }


        // Función para calcular el total en compra normal
        function calcularCostoTotal() {
            const costoUnitario = parseFloat(document.getElementById('costo_unitario').value) || 0;
            const cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
            const total = document.getElementById('total');

            if (costoUnitario > 0 && cantidad > 0) {
                const costoTotal = costoUnitario * cantidad;
                total.value = costoTotal.toFixed(2);
            } else {
                total.value = '';
            }
        }

        // Event listeners para actualizar el total
        document.getElementById('cantidad').addEventListener('input', calcularCostoTotal);
        document.getElementById('costo_unitario').addEventListener('input', calcularCostoTotal);

        // Manejar el envío del formulario de compra normal
        $('#compraNormalForm').on('submit', function(e) {
            e.preventDefault();

            // Habilitar el campo total antes de enviar
            $('#total').prop('disabled', false);

            $.ajax({
                url: '/gestion/app/controller/ComprasController.php?action=createCompraNormal',
                type: 'POST',
                data: {
                    descripcion_compra: $('#descripcion_compra').val(),
                    cantidad: $('#cantidad').val(),
                    costo_unitario: $('#costo_unitario').val(),
                    total: $('#total').val(),
                    fecha: $('#fecha').val(),
                    proveedor: $('#proveedor').val(),
                    metodo_pago: $('#metodo_pago').val(),
                    observacion: $('#observacion').val()
                },
                success: function(response) {
                    try {
                        let json = JSON.parse(response);
                        if (json.success) {
                            alert('Compra normal registrada exitosamente.');
                            $('#createCompraModal').modal('hide');
                            $('#compraNormalForm')[0].reset();
                            calcularCostoTotal();
                        } else {
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

        // Manejar el envío del formulario de compra de consumibles
        $('#compraConsumiblesForm').on('submit', function(e) {
            e.preventDefault();

            if (productosSeleccionados.length === 0) {
                alert('Debes seleccionar al menos un producto para registrar la compra.');
                return;
            }

            // Validar que cada producto tenga fecha_vencimiento
            for (let producto of productosSeleccionados) {
                if (!producto.fecha_vencimiento) {
                    alert('Debes especificar la fecha de vencimiento para todos los productos.');
                    return;
                }
            }

            $.ajax({
                url: '/gestion/app/controller/ComprasController.php?action=createCompraConsumible',
                type: 'POST',
                data: {
                    productosSeleccionados: JSON.stringify(productosSeleccionados),
                    proveedor: $('#proveedor').val(),
                    metodo_pago: $('#metodo_pago').val()
                },
                success: function(response) {
                    try {
                        let json = JSON.parse(response);
                        if (json.success) {
                            alert('Compra de consumibles registrada exitosamente.');
                            $('#compraConsumiblesForm')[0].reset();
                            productosSeleccionados = [];
                            actualizarPrevisualizacion();
                        } else {
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

        

        // Función para mostrar productos por categorias
        function mostrarConsumiblesPorCategoria(categoriaId) {
            $.ajax({
                url: '/gestion/app/controller/ComprasController.php',
                type: 'GET',
                data: {
                    action: 'getConsumiblesPorCategoria',
                    categoria_id: categoriaId
                },
                success: function(response) {
                    try {
                        let consumibles = JSON.parse(response);
                        let html = '';
                        if (consumibles.length > 0) {
                            html += '<ul class="list-group">';
                            consumibles.forEach(function(consumible) {
                                // Definir valores por defecto, pero sin mostrar N/A si es null
                                const stock = consumible.stock !== null ? consumible.stock : 0;
                                const coste = consumible.coste !== null ? 'S/.' + consumible.coste : ''; // No mostrar si es null
                                const precio = consumible.precio !== null ? 'S/.' + consumible.precio : ''; // No mostrar si es null
                                const fechaVencimiento = consumible.fecha_vencimiento ? consumible.fecha_vencimiento : 'Sin fecha';

                                // Construir la visualización del producto
                                html += '<li class="list-group-item">' +
                                    '<strong>' + consumible.nombre + '</strong><br>' +
                                    'Stock: ' + stock + '<br>';

                                // Solo mostrar el coste si está definido
                                if (coste) {
                                    html += 'Costo Total: ' + coste + '<br>';
                                }

                                // Solo mostrar el precio si está definido
                                if (precio) {
                                    html += 'Precio de Venta: ' + precio + '<br>';
                                }

                                html += 'Fecha de Vencimiento: ' + fechaVencimiento + '<br>' +
                                    '<button class="btn btn-sm btn-primary mt-2" onclick="agregarProducto(' + consumible.id + ', \'' + consumible.nombre + '\', ' + consumible.coste + ', ' + consumible.precio + ', \'' + consumible.fecha_vencimiento + '\', ' + stock + ')">Agregar</button>' +
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


      




    </script>
</body>

</html>

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
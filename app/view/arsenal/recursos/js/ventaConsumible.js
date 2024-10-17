
var productosSeleccionados = [];

$('#ventaForm').on('submit', function(e) {
    e.preventDefault();

    if (productosSeleccionados.length === 0) {
        alert('Debes seleccionar al menos un producto para registrar la venta.');
        return;
    }

    $.ajax({
        url: '/gestion/app/controller/ArsenalController.php?action=createVentaConsumible',
        type: 'POST',
        data: {
            productosSeleccionados: JSON.stringify(productosSeleccionados),
            metodo_pago: $('#metodo_pago').val()  
        },
        success: function(response) {
            var result = JSON.parse(response);

            if (result.success) {
                alert(result.success);
                productosSeleccionados = [];
                actualizarPrevisualizacion();
                $('#ventaForm')[0].reset();
                mostrarConsumiblesPorCategoria($('#categoriaActual').val());
            } else if (result.error) {
                alert(result.error);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
            alert('Ocurrió un error. Inténtelo de nuevo.');
        }
    });
});

function mostrarConsumiblesPorCategoria(categoriaId) {
    $('#categoriaActual').val(categoriaId);

    $.ajax({
        url: '/gestion/app/controller/ArsenalController.php',
        type: 'GET',
        data: {
            action: 'getConsumiblesPorCategoria',
            categoria_id: categoriaId
        },
        success: function(response) {
            console.log(response);
            try {
                var consumibles = JSON.parse(response);
                var html = '<table class="table table-bordered"><thead class="thead-dark"><tr><th>Nombre</th><th>Stock</th><th>Precio</th><th>Acción</th></tr></thead><tbody>';
                consumibles.forEach(function(consumible) {
                    var precio = parseFloat(consumible.precio);
                    var stock = parseInt(consumible.stock);
                    var classDisabled = stock <= 0 ? 'disabled' : '';
                    html += '<tr class="' + classDisabled + '"><td>' + consumible.nombre + '</td><td>' + stock + '</td><td>' + precio.toFixed(2) + '</td><td><button type="button" class="btn btn-success" onclick="agregarProducto(' + consumible.id + ', \'' + consumible.nombre + '\', ' + precio.toFixed(2) + ', ' + stock + ')">Agregar</button></td></tr>';
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

function agregarProducto(id, nombre, precio, stock) {
    var productoExistente = productosSeleccionados.find(producto => producto.id === id);
    if (productoExistente) {
        if (productoExistente.cantidad < stock) {
            productoExistente.cantidad++;
        } else {
            alert('No puedes agregar más de este producto. Stock máximo alcanzado.');
        }
    } else {
        productosSeleccionados.push({
            id: id,
            nombre: nombre,
            precio: precio,
            cantidad: 1,
            stock: stock
        });
    }
    actualizarPrevisualizacion();
}

function actualizarPrevisualizacion() {
    var total = 0;
    if (productosSeleccionados.length > 0) {
        var html = '<ul class="list-group">';
        productosSeleccionados.forEach(function(producto, index) {
            var subtotal = producto.precio * producto.cantidad;
            total += subtotal;
            html += '<li class="list-group-item d-flex justify-content-between align-items-center">' + producto.nombre + ' - Cantidad: ' + producto.cantidad +
                '<span><button type="button" class="btn btn-sm btn-primary" onclick="incrementarCantidad(' + index + ')">+</button> ' +
                '<button type="button" class="btn btn-sm btn-danger" onclick="decrementarCantidad(' + index + ')">-</button></span>' +
                '<span class="badge badge-primary badge-pill">$' + subtotal.toFixed(2) + '</span></li>';
        });
        html += '</ul>';
    } else {
        html = '<p>No hay productos seleccionados.</p>';
    }
    $('#ventaPreview').html(html);
    $('#totalVenta').html('<h4>Total: $' + total.toFixed(2) + '</h4>');
    $('#productosSeleccionados').val(JSON.stringify(productosSeleccionados));
}

function incrementarCantidad(index) {
    if (productosSeleccionados[index].cantidad < productosSeleccionados[index].stock) {
        productosSeleccionados[index].cantidad++;
        actualizarPrevisualizacion();
    } else {
        alert('No puedes agregar más de este producto. Stock máximo alcanzado.');
    }
}

function decrementarCantidad(index) {
    if (productosSeleccionados[index].cantidad > 1) {
        productosSeleccionados[index].cantidad--;
        actualizarPrevisualizacion();
    } else {
        productosSeleccionados.splice(index, 1);
        actualizarPrevisualizacion();
    }
}
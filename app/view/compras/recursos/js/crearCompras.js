
var productosSeleccionados = [];
var ultimoProducto = null;



function agregarProducto(id, nombre, precio, cantidad) {

    if (!id) {
        console.error("ID de producto no especificado");
        return;
    }

    var productoExistente = productosSeleccionados.find(producto => producto.id === id);
    if (!productoExistente) {
        productosSeleccionados.push({
            id: id,
            nombre: nombre,
            cantidad: cantidad > 0 ? cantidad : 0,
            costo_total: 0,
            precio_unitario: precio,
            fecha_ingreso: '',
            fecha_vencimiento: '',
            sinStock: cantidad === 0
        });
    } else {
        if (!productoExistente.sinStock) {
            productoExistente.cantidad += cantidad;
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Producto sin stock',
                text: 'Este producto no tiene stock disponible.'
            });
        }
    }
    ultimoProducto = productosSeleccionados[productosSeleccionados.length - 1];
    actualizarVistaPrevia();
}

function actualizarVistaPrevia() {
    var total = 0;
    var html = '';

    if (productosSeleccionados.length > 0) {
        html = '<ul class="list-group">';
        productosSeleccionados.forEach(function (producto, index) {
            total += parseFloat(producto.costo_total || 0);
            html += `<li class="list-group-item">
                        <div><strong>${producto.nombre}</strong> ${producto.sinStock ? '<span class="text-danger">(Sin stock)</span>' : ''}</div>
                        <div class="form-group">
                            <label>Cantidad:</label>
                            <input type="number" min="1" class="form-control" value="${producto.cantidad}" 
                                   onchange="actualizarCantidad(${index}, this.value)" ${producto.sinStock ? '' : ''}>
                        </div>
                        <div class="form-group">
                            <label>Costo Total:</label>
                            <input type="number" step="0.01" class="form-control" value="${producto.costo_total}" 
                                   onchange="actualizarCostoTotal(${index}, this.value)">
                        </div>
                        <div class="form-group">
                            <label>Precio Unitario:</label>
                            <input type="number" step="0.01" class="form-control" value="${producto.precio_unitario}" 
                                   onchange="actualizarPrecioUnitario(${index}, this.value)">
                        </div>
                        <div class="form-group">
                            <label>Fecha de Ingreso:</label>
                            <input type="date" class="form-control" value="${producto.fecha_ingreso || ''}" 
                                   onchange="actualizarFechaIngreso(${index}, this.value)">
                        </div>
                        <div class="form-group">
                            <label>Fecha de Vencimiento:</label>
                            <input type="date" class="form-control" value="${producto.fecha_vencimiento || ''}" 
                                   onchange="actualizarFechaVencimiento(${index}, this.value)">
                        </div>
                     </li>`;
        });
        html += '</ul>';
    } else {
        html = '<p>No hay productos seleccionados.</p>';
    }

    $('#compraPreview').html(html);
    $('#totalCompra').html('<h4>Total: S/.' + total.toFixed(2) + '</h4>');
    $('#productosSeleccionados').val(JSON.stringify(productosSeleccionados));
}

function actualizarCantidad(index, nuevaCantidad) {
    productosSeleccionados[index].cantidad = parseInt(nuevaCantidad);
    actualizarVistaPrevia();
}

function actualizarCostoTotal(index, nuevoCostoTotal) {
    productosSeleccionados[index].costo_total = parseFloat(nuevoCostoTotal);
    actualizarVistaPrevia();
}

function actualizarPrecioUnitario(index, nuevoPrecioUnitario) {
    productosSeleccionados[index].precio_unitario = parseFloat(nuevoPrecioUnitario);
}

function actualizarFechaIngreso(index, nuevaFecha) {
    productosSeleccionados[index].fecha_ingreso = nuevaFecha;
}

function actualizarFechaVencimiento(index, nuevaFecha) {
    productosSeleccionados[index].fecha_vencimiento = nuevaFecha;
}
function mostrarConsumiblesPorCategoria(categoriaId) {
    $.ajax({
        url: '/gestion/app/controller/ComprasController.php',
        type: 'GET',
        dataType: 'json', 
        data: { action: 'obtenerConsumiblesPorCategoria', categoria_id: categoriaId },
        success: function (response) {
            try {
                var consumibles = response;
                var agrupados = {};
        
                consumibles.forEach(function (consumible) {
                    var nombreUpper = consumible.nombre.toUpperCase();
        
                    if (!agrupados[nombreUpper]) {
                        agrupados[nombreUpper] = {
                            id: consumible.id,
                            nombre: consumible.nombre,
                            detalles: []
                        };
                    }
        
                    if (consumible.stock > 0) {
                        agrupados[nombreUpper].detalles.push({
                            stock: consumible.stock,
                            precio: parseFloat(consumible.precio).toFixed(2),
                            fecha_vencimiento: consumible.fecha_vencimiento
                        });
                    }
                });
        
                var html = '<table class="table table-bordered"><thead><tr><th>Nombre</th><th>Detalles</th><th>Acción</th></tr></thead><tbody>';
        
                for (var key in agrupados) {
                    var item = agrupados[key];
        
                    if (item.detalles.length === 0) {
                        html += `<tr>
                                    <td>${item.nombre}</td>
                                    <td>Sin stock</td>
                                    <td><button type="button" class="btn btn-warning" onclick="agregarProducto(${item.id}, '${item.nombre}', 0, 0)">Agregar</button></td>
                                 </tr>`;
                    } else {
                        item.detalles.sort((a, b) => new Date(a.fecha_vencimiento) - new Date(b.fecha_vencimiento));
                        var detalles = item.detalles.map((detalle, index) =>
                            `${index + 1}° Cantidad: ${detalle.stock} | ${index + 1}° Precio de Venta: S/. ${detalle.precio} | Vence: ${detalle.fecha_vencimiento}`
                        ).join('<br>');
                        html += `<tr>
                                    <td>${item.nombre}</td>
                                    <td>${detalles}</td>
                                    <td><button type="button" class="btn btn-success" onclick="agregarProducto(${item.id}, '${item.nombre}', ${item.detalles[0].precio}, ${item.detalles[0].stock})">Agregar</button></td>
                                 </tr>`;
                    }
                }
        
                html += '</tbody></table>';
                $('#consumiblesList').html(html);
            } catch (e) {
                console.error('Error al analizar la respuesta JSON:', e);
                $('#consumiblesList').html('<p>Error al cargar los consumibles.</p>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', status, error);
            $('#consumiblesList').html('<p>Error al cargar los consumibles.</p>');
        }
    });
}


$('#compraConsumiblesForm').on('submit', function (e) {
    e.preventDefault();

    if (productosSeleccionados.length === 0) {
        Swal.fire({ icon: 'warning', title: '¡Atención!', text: 'Debes seleccionar al menos un producto para registrar la compra.' });
        return;
    }

    var metodoCompra = $('#metodoCompra').val();

    $.ajax({
        url: '/gestion/app/controller/ComprasController.php?action=registrarCompraConsumible',
        type: 'POST',
        data: {
            productosSeleccionados: JSON.stringify(productosSeleccionados),
            metodo_pago: metodoCompra
        },
        dataType: 'json', 
        success: function (response) {
            if (response.success) {
                Swal.fire({ icon: 'success', title: 'Compra registrada', text: response.message, showConfirmButton: false, timer: 2000 })
                    .then(() => { window.location.reload(); });
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: response.message });
            }
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', xhr.responseText);
            Swal.fire({ icon: 'error', title: 'Error', text: 'Ocurrió un error en la solicitud. Inténtalo de nuevo.' });
        }
    });
});


$('#compraComunForm').submit(function (e) {
    e.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
        url: '/gestion/app/controller/ComprasController.php?action=registrarCompraComun',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = '/gestion/app/controller/ComprasController.php?action=showCompras';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error en la solicitud. Inténtalo de nuevo.'
            });
        }
    });
});

    

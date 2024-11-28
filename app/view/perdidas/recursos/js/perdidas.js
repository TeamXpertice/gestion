var productosSeleccionados = [];

// Función para agregar producto a la pérdida
function agregarProducto(id, nombre, cantidad) {
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
            sinStock: cantidad === 0
        });
    } else {
        productoExistente.cantidad += cantidad;
    }

    actualizarVistaPrevia();
}

// Función para actualizar la vista previa de los productos seleccionados
function actualizarVistaPrevia() {
    var total = 0;
    var html = '';

    if (productosSeleccionados.length > 0) {
        html = '<ul class="list-group">';
        productosSeleccionados.forEach(function (producto) {
            total += producto.cantidad; // Sumar cantidad como total para previsualización
            html += `<li class="list-group-item">
                        <div><strong>${producto.nombre}</strong> ${producto.sinStock ? '<span class="text-danger">(Sin stock)</span>' : ''}</div>
                        <div><strong>Cantidad:</strong> ${producto.cantidad}</div>
                     </li>`;
        });
        html += '</ul>';
    } else {
        html = '<p>No hay productos seleccionados.</p>';
    }

    $('#perdidaPreview').html(html);
    $('#totalPerdida').html('<h4>Total: ' + total + ' unidades</h4>');
    $('#productosSeleccionados').val(JSON.stringify(productosSeleccionados));
}

// Función para obtener los consumibles por categoría
function mostrarConsumiblesPorCategoria(categoriaId) {
    $.ajax({
        url: '/gestion/app/controller/PerdidasController.php', // Asegúrate que la ruta es correcta
        type: 'GET',
        dataType: 'json', 
        data: { action: 'obtenerConsumiblesPorCategoria', categoria_id: categoriaId },
        success: function (response) {
            var consumibles = response;
            var html = '<table class="table table-bordered"><thead><tr><th>Nombre</th><th>Cantidad</th><th>Acción</th></tr></thead><tbody>';

            consumibles.forEach(function (consumible) {
                html += `<tr>
                            <td>${consumible.nombre}</td>
                            <td>${consumible.stock}</td>
                            <td><button type="button" class="btn btn-success" onclick="agregarProducto(${consumible.id}, '${consumible.nombre}', ${consumible.stock})">Agregar</button></td>
                         </tr>`;
            });

            html += '</tbody></table>';
            $('#consumiblesList').html(html);
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX:', status, error);
            $('#consumiblesList').html('<p>Error al cargar los consumibles.</p>');
        }
    });
}

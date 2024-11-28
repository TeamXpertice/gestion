var productosSeleccionados = []; // Array para almacenar los productos seleccionados

function actualizarVistaPrevia() {
    let total = 0;
    let html = '';

    if (productosSeleccionados.length > 0) {
        html = '<ul class="list-group">';

        productosSeleccionados.forEach((producto, index) => {
            const subtotal = producto.precio * producto.cantidad;
            total += subtotal;
            html += `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    ${producto.nombre} (Lote: ${producto.loteIndex + 1}) - Cantidad: ${producto.cantidad}
                    <span>
                        <button type="button" class="btn btn-sm btn-primary" onclick="incrementarCantidad(${index})">+</button> 
                        <button type="button" class="btn btn-sm btn-danger" onclick="reducirCantidad(${index})">-</button>
                    </span>
                    <span class="badge badge-primary badge-pill">S/. ${subtotal.toFixed(2)}</span>
                </li>`;
        });
        html += '</ul>';
    } else {
        html = '<p>No hay productos seleccionados.</p>';
    }

    $('#ventaPreview').html(html);
    $('#totalVenta').html(`<h4>Total: S/. ${total.toFixed(2)}</h4>`);
    $('#productosSeleccionados').val(JSON.stringify(productosSeleccionados));
}
function cargarConsumiblesPorCategoria(categoriaId) {
    $.ajax({
        url: '/gestion/app/controller/ArsenalVentaController.php',
        type: 'GET',
        data: { action: 'obtenerConsumiblesPorCategoria', categoria_id: categoriaId },
        success: function (response) {
            let consumibles;

            try {
                consumibles = JSON.parse(response);
            } catch (e) {
                console.error("Error al parsear la respuesta:", e);
                $('#consumiblesList').html('<p>Error al cargar los consumibles.</p>');
                return;
            }

            if (!Array.isArray(consumibles) || consumibles.length === 0) {
                $('#consumiblesList').html('<p>No se encontraron consumibles para esta categoría.</p>');
                return;
            }

            const agrupados = {};

            consumibles.forEach(consumible => {
                const nombreUpper = consumible.nombre.toUpperCase();

                if (!agrupados[nombreUpper]) {
                    agrupados[nombreUpper] = {
                        id: consumible.id,
                        nombre: consumible.nombre,
                        es_compuesto: consumible.es_compuesto,
                        cantidadMaxima: consumible.cantidad_maxima || 0,
                        detalles: []
                    };
                }

                if (consumible.es_compuesto) {
                    agrupados[nombreUpper].detalles.push({
                        precio: parseFloat(consumible.precio).toFixed(2),
                        cantidadMaxima: consumible.cantidad_maxima || 0
                    });
                } else {
                    agrupados[nombreUpper].detalles.push({
                        stock: consumible.stock || 'No disponible',
                        precio: parseFloat(consumible.precio).toFixed(2),
                        fecha_vencimiento: consumible.fecha_vencimiento || 'Fecha no disponible'
                    });
                }
            });

            // Generar HTML
            let html = '<table class="table table-bordered"><thead><tr><th>Nombre</th><th>Detalles</th><th>Acción</th></tr></thead><tbody>';
            for (let key in agrupados) {
                const item = agrupados[key];

                let detalles;
                if (item.es_compuesto) {
                    detalles = item.detalles.map((detalle, index) => {
                        return `Precio: <strong>S/. ${detalle.precio}</strong> | Cantidad Máxima: ${item.cantidadMaxima}`;
                    }).join('<br>');
                } else {
                    detalles = item.detalles.map((detalle, index) =>
                        `${index + 1}° Stock: ${detalle.stock} | Precio: <strong>S/. ${detalle.precio}</strong> | Vence: ${detalle.fecha_vencimiento}`
                    ).join('<br>');
                }
                html += `
                    <tr>
                        <td>${item.nombre}</td>
                        <td>${detalles}</td>
                        <td>
                            <button type="button" class="btn btn-success" onclick="agregarProducto('${item.nombre}', ${item.id}, '${encodeURIComponent(JSON.stringify(item.detalles))}', ${item.es_compuesto})">
                                Agregar
                            </button>
                        </td>
                    </tr>`;
            }
            html += '</tbody></table>';
            $('#consumiblesList').html(html);
        },
        error: function () {
            $('#consumiblesList').html('<p>Error al cargar los consumibles.</p>');
        }
    });
}
function agregarProducto(nombre, id, detallesEncoded, es_compuesto) {
    const detalles = JSON.parse(decodeURIComponent(detallesEncoded));

    if (es_compuesto) {
        const cantidadMaxima = detalles[0].cantidadMaxima;

        let productoExistente = productosSeleccionados.find(p => p.nombre === nombre);

        if (productoExistente) {
            if (productoExistente.cantidad < cantidadMaxima) {
                productoExistente.cantidad++;
            } else {
                alert(`No puedes agregar más de ${cantidadMaxima} unidades de este producto compuesto.`);
                return;
            }
        } else {
            productosSeleccionados.push({
                id,
                nombre,
                precio: parseFloat(detalles[0].precio),
                cantidad: 1,
                stock: detalles[0].cantidadMaxima,
                es_compuesto: true, // Agrega esta clave explícitamente
                loteIndex: 0
            });
        }
    } else {
        let productoExistente = productosSeleccionados.find(p => p.nombre === nombre);

        if (productoExistente) {
            if (productoExistente.cantidad < productoExistente.stock) {
                productoExistente.cantidad++;
            } else {
                alert('No puedes agregar más de este producto. Stock máximo alcanzado.');
                return;
            }
        } else {
            productosSeleccionados.push({
                id,
                nombre,
                precio: parseFloat(detalles[0].precio),
                cantidad: 1,
                stock: detalles[0].stock,
                es_compuesto: false, // Agrega esta clave explícitamente
                loteIndex: 0
            });
        }
    }

    actualizarVistaPrevia();
}




function incrementarCantidad(index) {
    const producto = productosSeleccionados[index];
    if (producto.cantidad < producto.stock) {
        producto.cantidad++;
        actualizarVistaPrevia();
    } else {
        alert('No puedes agregar más de este producto. Stock máximo alcanzado.');
    }
}

function reducirCantidad(index) {
    const producto = productosSeleccionados[index];
    if (producto.cantidad > 1) {
        producto.cantidad--;
    } else {
        productosSeleccionados.splice(index, 1);
    }
    actualizarVistaPrevia();
}

$('#ventaForm').on('submit', function (e) {
    e.preventDefault();

    // Validar que todos los productos tengan 'es_compuesto'
    let valid = true;
    productosSeleccionados.forEach(producto => {
        if (producto.es_compuesto === undefined) {
            console.error(`El producto ${producto.id} no tiene la clave 'es_compuesto'.`);
            valid = false;
        }
    });

    if (!valid) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Faltan datos en los productos seleccionados. Revisa la consola para más detalles.'
        });
        return;
    }

    const metodoPago = $('#metodo_pago').val();
    if (!metodoPago) {
        Swal.fire({
            icon: 'warning',
            title: '¡Atención!',
            text: 'Debes seleccionar un método de pago.'
        });
        return;
    }

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Estás por registrar esta venta, ¿deseas continuar?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, registrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/gestion/app/controller/ArsenalVentaController.php?action=crearVentaConsumible',
                type: 'POST',
                data: {
                    productosSeleccionados: JSON.stringify(productosSeleccionados),
                    metodo_pago: metodoPago
                },
                success: function (response) {
                    try {
                        const result = JSON.parse(response);
                        if (result.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Venta registrada!',
                                text: 'La venta se ha registrado exitosamente.',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                productosSeleccionados = [];
                                actualizarVistaPrevia();
                                location.reload(); 
                            });
                        } else if (result.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: result.error
                            });
                        }
                    } catch (error) {
                        console.error('Error al procesar la respuesta:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error inesperado al registrar la venta.'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al intentar registrar la venta. Inténtalo nuevamente.'
                    });
                }
            });
        }
    });
});


$(document).ready(function() {
    // Configuración de DataTables
    $('.table:not(.table-categorias)').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        },
        dom: 'Bfrtip',
        buttons: [{
                extend: 'excel',
                text: 'Excel',
                title: 'Bienes_Registrados'
            },
            {
                extend: 'pdf',
                text: 'PDF',
                title: 'Bienes_Registrados',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'print',
                text: 'Imprimir',
                title: 'Bienes Registrados',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ]
    });



    // Mostrar modal de creación de consumible con efectos de deslizamiento
    $('#modalCrearConsumibleSimple').on('show.bs.modal', function() {
        $(this).find('.modal-content').hide().slideDown(500);
    });

    $('#modalCrearConsumibleSimple').on('hide.bs.modal', function() {
        $(this).find('.modal-content').slideUp(500, function() {
            $(this).parent().modal('hide');
        });
        return false;
    });

    // Añadir nueva categoría
    $('#addCategoriaBtn').on('click', function() {
        const nuevaCategoria = $('#nuevaCategoria').val();

        if (nuevaCategoria) {
            fetch('/gestion/app/controller/ArsenalController.php?action=addCategoria', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `nombre=${encodeURIComponent(nuevaCategoria)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#categoria').append(new Option(nuevaCategoria, data.newId));

                        Swal.fire({
                            icon: 'success',
                            title: '¡Categoría agregada!',
                            text: 'La categoría se ha agregado exitosamente.',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#nuevaCategoria').val('');
                        $('#categoriaModal').modal('hide');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al agregar la categoría.'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema con la solicitud.'
                    });
                });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Campo vacío',
                text: 'Por favor, ingresa el nombre de la categoría.'
            });
        }
    });

    // Cálculo de ganancia en tiempo real
    $('#precio_sugerido').on('input', calcularGanancia);

    $('#stock, #coste, #precio_unitario').on('input', calcularGanancia);

    function calcularGanancia() {
        const stock = parseFloat($('#stock').val()) || 0;
        const costoTotal = parseMoneda($('#coste').val());
        const precioUnitario = parseMoneda($('#precio_unitario').val());
        const precioSugerido = parseMoneda($('#precio_sugerido').val());

        if (costoTotal > 0 && precioSugerido > 0 && stock > 0) {
            const ingresoTotal = precioUnitario * stock;
            const gananciaTotal = ingresoTotal - costoTotal;
            const porcentajeGanancia = ((gananciaTotal / costoTotal) * 100).toFixed(2);

            $('#gananciaProducto').text(`Ganancia del Producto: S/. ${gananciaTotal.toFixed(2)} (${porcentajeGanancia}%)`);
            $('#gananciaProductoCompuesto').text(`Ganancia del Producto: S/. ${gananciaTotal.toFixed(2)} (${porcentajeGanancia}%)`);
        } else {
            $('#gananciaProducto').text(`Ganancia del Producto: S/. 0.00 (0%)`);
            $('#gananciaProductoCompuesto').text(`Ganancia del Producto: S/. 0.00 (0%)`);
        }
    }

    function parseMoneda(valor) {
        return parseFloat(valor.replace(/[^\d.-]/g, '')) || 0;
    }

    // Mostrar consumibles por categoría
    function mostrarConsumiblesPorCategoria(categoriaId) {
        fetch(`/gestion/app/controller/ArsenalController.php?action=getConsumiblesByCategoria&id=${categoriaId}`)
            .then(response => response.json())
            .then(data => {
                const consumiblesList = $('#consumiblesList');
                consumiblesList.html('');

                if (data.consumibles.length > 0) {
                    data.consumibles.forEach(consumible => {
                        const consumibleDiv = `
                        <div class="consumible-item">
                            <p>${consumible.nombre} - Stock: ${consumible.stock} - Precio Sugerido: S/. ${consumible.precio_sugerido}</p>
                            <input type="checkbox" id="consumible_${consumible.id}" data-precio="${consumible.precio_sugerido}" data-stock="${consumible.stock}" onclick="seleccionarConsumible(${consumible.id})"> Seleccionar
                        </div>
                    `;
                        consumiblesList.append(consumibleDiv);
                    });
                } else {
                    consumiblesList.html('<p>No hay consumibles disponibles para esta categoría.</p>');
                }
            });
    }

    // Gestión de consumibles seleccionados y cálculo de totales
    let consumiblesSeleccionados = {};

    window.seleccionarConsumible = function(consumibleId) {
        const checkbox = $(`#consumible_${consumibleId}`);
        const precio = parseFloat(checkbox.attr('data-precio'));
        const stock = parseInt(checkbox.attr('data-stock'));

        if (checkbox.prop('checked')) {
            consumiblesSeleccionados[consumibleId] = {
                precio,
                stock
            };
        } else {
            delete consumiblesSeleccionados[consumibleId];
        }
        calcularTotales();
    };

    function calcularTotales() {
        let costoTotal = 0;
        let stockMinimo = Infinity;

        Object.values(consumiblesSeleccionados).forEach(consumible => {
            costoTotal += consumible.precio;
            stockMinimo = Math.min(stockMinimo, consumible.stock);
        });

        if (Object.keys(consumiblesSeleccionados).length === 0) {
            stockMinimo = 0;
        }

        $('#costo_total').val(`S/. ${costoTotal.toFixed(2)}`);
        $('#stock_total').val(stockMinimo);

        calcularGanancia();
    }
});
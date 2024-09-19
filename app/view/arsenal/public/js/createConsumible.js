
// CONTROL DEL CLICK QUE MANJE ALAS CATEGORIAS
document.getElementById('categoriasContainer').addEventListener('click', function (event) {
    if (event.target.classList.contains('categoria-btn')) {
        let categoriaId = event.target.getAttribute('data-id');
        let consumiblesContainer = document.getElementById('consumiblesContainer');

        // MENSAJE CARGAR CONSUMIBLES
        consumiblesContainer.innerHTML = '<p>Cargando consumibles...</p>';

        // SOLICITUD PARA TENER LOS CONSUMIBLES Y CATEGORIAS
        fetch(`/gestion/app/controller/ArsenalController.php?action=getConsumiblesByCategoria&id=${categoriaId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener los consumibles');
                }
                return response.json();
            })
            .then(data => {
                consumiblesContainer.innerHTML = ''; // Limpia el contenedor antes de agregar nuevos consumibles

                if (data.consumibles && data.consumibles.length > 0) {
                    data.consumibles.forEach(consumible => {
                        // Excluir consumibles con stock NULL
                        if (consumible.stock === null || consumible.stock === undefined) {
                            return;  // No mostrar ni permitir la selección de consumibles con stock NULL
                        }
                    
                        // Crear el contenedor para cada consumible
                        const consumibleItem = document.createElement('div');
                        consumibleItem.classList.add('consumible-item');
                    
                        // Crear el span que contiene el nombre y el stock del consumible
                        const consumibleSpan = document.createElement('span');
                        consumibleSpan.textContent = `${consumible.nombre} - Stock: ${consumible.stock}`;
                        consumibleItem.appendChild(consumibleSpan);
                    
                        // Crear el input para la cantidad
                        const cantidadInput = document.createElement('input');
                        cantidadInput.type = 'number';
                        cantidadInput.min = 0; // Establecer mínimo en 0
                        cantidadInput.value = 1; // Valor inicial siempre en 1
                        cantidadInput.id = `cantidad_${consumible.id}`;
                    
                        // Si hay stock, establecer el max; de lo contrario, no establecer
                        if (consumible.stock > 0) {
                            cantidadInput.max = consumible.stock; // Solo establecer max si hay stock
                        }
                    
                        consumibleItem.appendChild(cantidadInput);
                    
                        // Crear el botón de agregar consumible
                        const agregarButton = document.createElement('button');
                        agregarButton.type = 'button';
                        agregarButton.classList.add('btn', 'btn-success', 'agregar-consumible');
                        agregarButton.dataset.id = consumible.id;
                        agregarButton.dataset.nombre = consumible.nombre;
                        agregarButton.dataset.precio = consumible.precio;
                        agregarButton.dataset.stock = consumible.stock;
                        agregarButton.textContent = 'Agregar';
                        consumibleItem.appendChild(agregarButton);
                    
                        // Agregar el consumible al contenedor
                        consumiblesContainer.appendChild(consumibleItem);
                    });
                    
                } else {
                    // Si no hay consumibles, mostramos un mensaje
                    consumiblesContainer.innerHTML = '<p>No hay consumibles disponibles en esta categoría.</p>';
                }
            })
            .catch(error => {
                consumiblesContainer.innerHTML = `
        <div class="alert alert-danger">
            Error al cargar consumibles: ${error.message}. Por favor, intenta nuevamente.
        </div>
    `;
                console.error('Error al obtener los consumibles:', error);
            });
    }
});

// Asignar eventos para calcular la ganancia cuando cambien stock, coste o precio
document.getElementById('stock').addEventListener('input', calcularGanancia);
document.getElementById('coste').addEventListener('input', calcularGanancia);
document.getElementById('precio').addEventListener('input', calcularGanancia);

// Detectar si es un consumible compuesto o simple
function calcularGanancia() {
    const esCompuesto = document.getElementById('consumible_multiple').checked;
    if (esCompuesto) {
        calcularGananciaConsumibleCompuesto();
    } else {
        calcularGananciaConsumibleSimple();
    }
}

// Función para calcular ganancia de consumibles simples
function calcularGananciaConsumibleSimple() {
    const costoTotal = parseFloat(document.getElementById('coste').value.replace('S/. ', '')) || 0; // Costo total del producto
    const precioUnitario = parseFloat(document.getElementById('precio').value.replace('S/. ', '')) || 0; // Precio de venta por unidad
    const stock = parseFloat(document.getElementById('stock').value) || 0; // Stock total disponible

    if (costoTotal > 0 && precioUnitario > 0 && stock > 0) {
        const ingresoTotal = precioUnitario * stock; // Ingreso total
        const gananciaTotal = ingresoTotal - costoTotal; // Ganancia total
        const porcentajeGanancia = ((gananciaTotal / costoTotal) * 100).toFixed(2); // Margen de ganancia

        // Actualizamos el campo de ganancia
        document.getElementById('gananciaProducto').textContent = `Ganancia del Producto: S/. ${gananciaTotal.toFixed(2)} (${porcentajeGanancia}%)`;
    } else {
        document.getElementById('gananciaProducto').textContent = `Ganancia del Producto: S/. 0.00 (0%)`;
    }
}

// Función para calcular ganancia de consumibles compuestos
function calcularGananciaConsumibleCompuesto() {
    const costoTotal = parseFloat(document.getElementById('coste').value.replace('S/. ', '')) || 0; // Costo total del compuesto
    const precioUnitario = parseFloat(document.getElementById('precio').value.replace('S/. ', '')) || 0; // Precio de venta del compuesto

    if (costoTotal > 0 && precioUnitario > 0) {
        const gananciaPorUnidad = precioUnitario - costoTotal; // Ganancia por unidad
        const porcentajeGanancia = ((gananciaPorUnidad / costoTotal) * 100).toFixed(2); // Margen de ganancia por unidad

        // Actualizamos el campo de ganancia
        document.getElementById('gananciaProducto').textContent = `Ganancia por Unidad: S/. ${gananciaPorUnidad.toFixed(2)} (${porcentajeGanancia}%)`;
    } else {
        document.getElementById('gananciaProducto').textContent = `Ganancia del Producto: S/. 0.00 (0%)`;
    }
}

// Función para actualizar el stock del compuesto
function calcularStockCompuesto() {
    let stockMinimo = Infinity; // Iniciamos con un valor muy alto para encontrar el mínimo stock disponible

    // Recorremos los consumibles seleccionados
    document.querySelectorAll('#listaConsumiblesSeleccionados div').forEach(item => {
        const cantidadConsumible = parseFloat(item.querySelector('input[name^="componentes["]').value); // Cantidad seleccionada
        const stockDisponible = parseFloat(item.querySelector('input[name^="componentes["][name*="stock"]').value); // Stock disponible del consumible

        if (!isNaN(cantidadConsumible) && !isNaN(stockDisponible) && cantidadConsumible > 0) {
            const stockPosible = Math.floor(stockDisponible / cantidadConsumible); // Cuánto stock puede producir el compuesto
            stockMinimo = Math.min(stockMinimo, stockPosible); // Tomamos el menor stock posible
        }
    });

    // Si no se seleccionó ningún consumible, el stock debe ser 0
    stockMinimo = stockMinimo === Infinity ? 0 : stockMinimo;

    // Actualizamos el campo de stock con el valor mínimo calculado
    document.getElementById('stock').value = stockMinimo;
}

// Función para calcular el costo total de un consumible compuesto
function calcularCostoCompuesto() {
    let costoTotal = 0;

    // Recorremos los consumibles seleccionados
    document.querySelectorAll('#listaConsumiblesSeleccionados div').forEach(item => {
        const cantidad = parseFloat(item.querySelector('input[name^="componentes["]').value); // Cantidad seleccionada
        const precioUnitario = parseFloat(item.querySelector('input[name^="componentes["][name*="precio"]').value); // Precio del consumible

        if (!isNaN(cantidad) && !isNaN(precioUnitario)) {
            costoTotal += cantidad * precioUnitario; // Acumulamos el costo total
        }
    });

    // Actualizamos el campo de costo total
    document.getElementById('coste').value = 'S/. ' + costoTotal.toFixed(2);
}

// Manejar el cambio del checkbox para productos compuestos
document.getElementById('consumible_multiple').addEventListener('change', function () {
    const esCompuesto = this.checked;

    // Actualizamos la marca
    document.getElementById('marca').disabled = esCompuesto;
    document.getElementById('marca').value = esCompuesto ? 'Consumible de dos' : '';

    // Habilitar o deshabilitar el botón según si es compuesto
    document.getElementById('btnSeleccionarConsumibles').disabled = !esCompuesto;

    // Deshabilitar campos de costo y stock si es un consumible compuesto
    document.getElementById('coste').disabled = esCompuesto;
    document.getElementById('stock').disabled = esCompuesto;

    // Si es compuesto, calcular stock y costo en base a los componentes seleccionados
    if (esCompuesto) {
        calcularStockCompuesto();
        calcularCostoCompuesto();
        document.getElementById('gananciaProducto').textContent = 'Ganancia del Producto: S/. 0.00 (0%)';
    } else {
        document.getElementById('coste').value = 'S/. 0.00';
        document.getElementById('stock').value = '';
        calcularGanancia(); // Recalcular ganancia para productos individuales
    }
});

// Agregar consumible a la lista seleccionada
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('agregar-consumible')) {
        const consumibleId = event.target.getAttribute('data-id');
        const consumibleNombre = event.target.getAttribute('data-nombre');
        const cantidadSeleccionada = document.getElementById(`cantidad_${consumibleId}`).value;
        const stockDisponible = parseFloat(event.target.getAttribute('data-stock'));
        const precioUnitario = parseFloat(event.target.getAttribute('data-precio'));

        if (!document.getElementById(`consumible_${consumibleId}`)) {
            const itemHtml = `
                    <div id="consumible_${consumibleId}">
                        <span>${consumibleNombre} - Cantidad: ${cantidadSeleccionada}</span>
                        <input type="hidden" name="componentes[${consumibleId}][cantidad]" value="${cantidadSeleccionada}">
                        <input type="hidden" name="componentes[${consumibleId}][precio]" value="${precioUnitario}">
                        <input type="hidden" name="componentes[${consumibleId}][stock]" value="${stockDisponible}">
                        <button type="button" class="btn btn-danger remover-consumible" data-id="${consumibleId}">Eliminar</button>
                    </div>
                `;
            document.getElementById('listaConsumiblesSeleccionados').insertAdjacentHTML('beforeend', itemHtml);

            calcularStockCompuesto();
            calcularCostoCompuesto();
            calcularGanancia();
        } else {
            alert('Este consumible ya ha sido seleccionado.');
        }
    }

    // Remover consumible de la lista
    if (event.target.classList.contains('remover-consumible')) {
        const consumibleId = event.target.getAttribute('data-id');
        document.getElementById(`consumible_${consumibleId}`).remove();
        calcularStockCompuesto();
        calcularCostoCompuesto();
        calcularGanancia();
    }
});

// Limpiar y restaurar campos de coste y precio
document.getElementById('coste').addEventListener('focus', function () {
    if (this.value === 'S/. 0.00') {
        this.value = '';
    }
});
document.getElementById('precio').addEventListener('focus', function () {
    if (this.value === 'S/. 0.00') {
        this.value = '';
    }
});
document.getElementById('coste').addEventListener('blur', function () {
    if (this.value === '') {
        this.value = 'S/. 0.00';
    }
});
document.getElementById('precio').addEventListener('blur', function () {
    if (this.value === '') {
        this.value = 'S/. 0.00';
    }
});
$(document).ready(function () {
    // Aplicar DataTables solo a la tabla de consumibles
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

    // Sin DataTables para la tabla de categorías
    $('#addCategoriaBtn').on('click', function () {
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
                        $('#categoriaModal').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();

                        Swal.fire({
                            icon: 'success',
                            title: '¡Categoría agregada!',
                            text: 'La categoría se ha agregado exitosamente.',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#nuevaCategoria').val('');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al agregar la categoría.'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
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
});
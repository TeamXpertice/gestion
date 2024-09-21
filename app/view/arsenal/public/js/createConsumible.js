
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
                consumiblesContainer.innerHTML = ''; 

                if (data.consumibles && data.consumibles.length > 0) {
                    data.consumibles.forEach(consumible => {
                        if (consumible.stock === null || consumible.stock === undefined) {
                            return;  
                        }
                    
                        const consumibleItem = document.createElement('div');
                        consumibleItem.classList.add('consumible-item');
                    
                        const consumibleSpan = document.createElement('span');
                        consumibleSpan.textContent = `${consumible.nombre} - Stock: ${consumible.stock}`;
                        consumibleItem.appendChild(consumibleSpan);
                    
                        const cantidadInput = document.createElement('input');
                        cantidadInput.type = 'number';
                        cantidadInput.min = 0;
                        cantidadInput.value = 1; 
                        cantidadInput.id = `cantidad_${consumible.id}`;
                    
                        if (consumible.stock > 0) {
                            cantidadInput.max = consumible.stock; 
                        }
                    
                        consumibleItem.appendChild(cantidadInput);
                    
                        const agregarButton = document.createElement('button');
                        agregarButton.type = 'button';
                        agregarButton.classList.add('btn', 'btn-success', 'agregar-consumible');
                        agregarButton.dataset.id = consumible.id;
                        agregarButton.dataset.nombre = consumible.nombre;
                        agregarButton.dataset.precio = consumible.precio;
                        agregarButton.dataset.stock = consumible.stock;
                        agregarButton.textContent = 'Agregar';
                        consumibleItem.appendChild(agregarButton);
                    
                        consumiblesContainer.appendChild(consumibleItem);
                    });
                    
                } else {
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

document.getElementById('stock').addEventListener('input', calcularGanancia);
document.getElementById('coste').addEventListener('input', calcularGanancia);
document.getElementById('precio').addEventListener('input', calcularGanancia);

function calcularGanancia() {
    const esCompuesto = document.getElementById('consumible_multiple').checked;
    if (esCompuesto) {
        calcularGananciaConsumibleCompuesto();
    } else {
        calcularGananciaConsumibleSimple();
    }
}

function calcularGananciaConsumibleSimple() {
    const costoTotal = parseFloat(document.getElementById('coste').value.replace('S/. ', '')) || 0;
    const precioUnitario = parseFloat(document.getElementById('precio').value.replace('S/. ', '')) || 0; 
    const stock = parseFloat(document.getElementById('stock').value) || 0; 

    if (costoTotal > 0 && precioUnitario > 0 && stock > 0) {
        const ingresoTotal = precioUnitario * stock; 
        const gananciaTotal = ingresoTotal - costoTotal; 
        const porcentajeGanancia = ((gananciaTotal / costoTotal) * 100).toFixed(2); 

        document.getElementById('gananciaProducto').textContent = `Ganancia del Producto: S/. ${gananciaTotal.toFixed(2)} (${porcentajeGanancia}%)`;
    } else {
        document.getElementById('gananciaProducto').textContent = `Ganancia del Producto: S/. 0.00 (0%)`;
    }
}

function calcularGananciaConsumibleCompuesto() {
    const costoTotal = parseFloat(document.getElementById('coste').value.replace('S/. ', '')) || 0; 
    const precioUnitario = parseFloat(document.getElementById('precio').value.replace('S/. ', '')) || 0;

    if (costoTotal > 0 && precioUnitario > 0) {
        const gananciaPorUnidad = precioUnitario - costoTotal; 
        const porcentajeGanancia = ((gananciaPorUnidad / costoTotal) * 100).toFixed(2); 

        
        document.getElementById('gananciaProducto').textContent = `Ganancia por Unidad: S/. ${gananciaPorUnidad.toFixed(2)} (${porcentajeGanancia}%)`;
    } else {
        document.getElementById('gananciaProducto').textContent = `Ganancia del Producto: S/. 0.00 (0%)`;
    }
}

function calcularStockCompuesto() {
    let stockMinimo = Infinity; 

    document.querySelectorAll('#listaConsumiblesSeleccionados div').forEach(item => {
        const cantidadConsumible = parseFloat(item.querySelector('input[name^="componentes["]').value); 
        const stockDisponible = parseFloat(item.querySelector('input[name^="componentes["][name*="stock"]').value); 

        if (!isNaN(cantidadConsumible) && !isNaN(stockDisponible) && cantidadConsumible > 0) {
            const stockPosible = Math.floor(stockDisponible / cantidadConsumible);
            stockMinimo = Math.min(stockMinimo, stockPosible); 
        }
    });

    stockMinimo = stockMinimo === Infinity ? 0 : stockMinimo;
    document.getElementById('stock').value = stockMinimo;
}

function calcularCostoCompuesto() {
    let costoTotal = 0;

    document.querySelectorAll('#listaConsumiblesSeleccionados div').forEach(item => {
        const cantidad = parseFloat(item.querySelector('input[name^="componentes["]').value); 
        const precioUnitario = parseFloat(item.querySelector('input[name^="componentes["][name*="precio"]').value);

        if (!isNaN(cantidad) && !isNaN(precioUnitario)) {
            costoTotal += cantidad * precioUnitario; 
        }
    });

    document.getElementById('coste').value = 'S/. ' + costoTotal.toFixed(2);
}
document.getElementById('consumible_multiple').addEventListener('change', function () {
    const esCompuesto = this.checked;

    document.getElementById('marca').disabled = esCompuesto;
    document.getElementById('marca').value = esCompuesto ? 'Consumible de dos' : '';

    document.getElementById('btnSeleccionarConsumibles').disabled = !esCompuesto;

    document.getElementById('coste').disabled = esCompuesto;
    document.getElementById('stock').disabled = esCompuesto;

    if (esCompuesto) {
        calcularStockCompuesto();
        calcularCostoCompuesto();
        document.getElementById('gananciaProducto').textContent = 'Ganancia del Producto: S/. 0.00 (0%)';
    } else {
        document.getElementById('coste').value = 'S/. 0.00';
        document.getElementById('stock').value = '';
        calcularGanancia();
    }
});

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

    if (event.target.classList.contains('remover-consumible')) {
        const consumibleId = event.target.getAttribute('data-id');
        document.getElementById(`consumible_${consumibleId}`).remove();
        calcularStockCompuesto();
        calcularCostoCompuesto();
        calcularGanancia();
    }
});

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
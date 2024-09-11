<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Consumible</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Crear Consumible</h1>
        <form action="/gestion/app/controller/ArsenalController.php?action=createConsumible" method="post">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="consumible_multiple">Es un consumible compuesto:</label>
                    <input type="checkbox" id="consumible_multiple" name="consumible_multiple">
                </div>
                <div class="form-group col-md-4">
                    <label for="marca">Marca:</label>
                    <input type="text" id="marca" name="marca" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categorias[]" class="form-control" required>
                        <option value="" disabled selected>Selecciona una categoría</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo htmlspecialchars($categoria['id']); ?>">
                                <?php echo htmlspecialchars($categoria['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="unidad_medida">Unidad de Medida:</label>
                    <select id="unidad_medida" name="unidad_medida" class="form-control" required>
                        <option value="u">Unidad (u)</option>
                        <option value="g">Gramos (g)</option>
                        <option value="kg">Kilogramos (kg)</option>
                        <option value="L">Litro (L)</option>
                        <option value="ml">Mililitro (ml)</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="stock">Stock:</label>
                    <input type="number" id="stock" name="stock" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="coste">Costo Total del producto:</label>
                    <input type="text" id="coste" name="coste" class="form-control" value="S/. 0.00">
                </div>
                <div class="form-group col-md-2">
                    <label for="precio">Precio Unitario:</label>
                    <input type="text" id="precio" name="precio" class="form-control" value="S/. 0.00" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="descripcion_consumible">Descripción del producto:</label>
                    <textarea id="descripcion_consumible" name="descripcion_consumible" class="form-control" required></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="observacion">Observación del producto:</label>
                    <textarea id="observacion" name="observacion" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_compra">Fecha de Compra:</label>
                    <input type="date" id="fecha_compra" name="fecha_compra" class="form-control">
                </div>
            </div>


            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#categoriaModal" id="btnSeleccionarConsumibles" disabled>Seleccionar Consumibles</button>


            <div class="modal fade" id="categoriaModal" tabindex="-1" role="dialog" aria-labelledby="categoriaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="categoriaModalLabel">Selecciona una Categoría</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h6>Categorías</h6>
                            <div id="categoriasContainer" class="mb-3">
                                <?php foreach ($categorias as $categoria): ?>
                                    <button type="button" class="btn btn-secondary categoria-btn" data-id="<?php echo $categoria['id']; ?>">
                                        <?php echo htmlspecialchars($categoria['nombre']); ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            <h6>Consumibles</h6>
                            <div id="consumiblesContainer"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar Selección</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="listaConsumiblesSeleccionados"></div>

            <div class="mt-4">
                <h3>Ganancia</h3>
                <div id="gananciaContainer" class="alert alert-info">
                    <p id="gananciaProducto">Ganancia del Producto: S/. 0.00 (0%)</p>
                    <p id="gananciaCompuesto" class="d-none">Ganancia del Compuesto: S/. 0.00 (0%)</p>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

    <!-- Incluye jQuery desde un CDN o archivo local -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manejo del clic en el botón de categoría
            document.querySelectorAll('.categoria-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const categoriaId = this.getAttribute('data-id');

                    // Usar fetch para obtener los consumibles por categoría
                    fetch(`/gestion/app/controller/ArsenalController.php?action=getConsumiblesByCategoria&id=${categoriaId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Red no responde');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.consumibles && data.consumibles.length > 0) {
                                let consumiblesHtml = '';
                                data.consumibles.forEach(consumible => {
                                    consumiblesHtml += `
                    <div class="consumible-item">
                        <span>${consumible.nombre} - Stock: ${consumible.stock}</span>
                        <input type="number" min="1" max="${consumible.stock}" value="1" id="cantidad_${consumible.id}">
                        <button type="button" class="btn btn-success agregar-consumible" data-id="${consumible.id}" data-nombre="${consumible.nombre}" data-precio="${consumible.precio}">
                            Agregar
                        </button>
                    </div>
                `;
                                });
                                document.getElementById('consumiblesContainer').innerHTML = consumiblesHtml;
                            } else {
                                document.getElementById('consumiblesContainer').innerHTML = '<p>No hay consumibles disponibles en esta categoría.</p>';
                            }
                        })
                        .catch(error => {
                            console.error('Error al obtener los consumibles:', error);
                        });
                });
            });

            // Agregar y remover consumibles de la lista
            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('agregar-consumible')) {
                    const consumibleId = event.target.getAttribute('data-id');
                    const consumibleNombre = event.target.getAttribute('data-nombre');
                    const cantidadSeleccionada = document.getElementById(`cantidad_${consumibleId}`).value;
                    const precioUnitario = parseFloat(event.target.getAttribute('data-precio'));

                    if (!document.getElementById(`consumible_${consumibleId}`)) {
                        const itemHtml = `
                <div id="consumible_${consumibleId}">
                    <span>${consumibleNombre} - Cantidad: ${cantidadSeleccionada}</span>
                    <input type="hidden" name="componentes[${consumibleId}][cantidad]" value="${cantidadSeleccionada}">
                    <input type="hidden" name="componentes[${consumibleId}][id]" value="${consumibleId}">
                    <button type="button" class="btn btn-danger remover-consumible" data-id="${consumibleId}">Eliminar</button>
                </div>
            `;
                        document.getElementById('listaConsumiblesSeleccionados').insertAdjacentHTML('beforeend', itemHtml);
                        calcularCostoTotal(); // Actualiza el costo total
                        calcularGanancia(); // Actualiza la ganancia
                    } else {
                        alert('Este consumible ya ha sido seleccionado.');
                    }
                }

                // Remover consumible de la lista
                if (event.target.classList.contains('remover-consumible')) {
                    const consumibleId = event.target.getAttribute('data-id');
                    document.getElementById(`consumible_${consumibleId}`).remove();
                    calcularCostoTotal(); // Actualiza el costo total después de eliminar un consumible
                    calcularGanancia(); // Actualiza la ganancia
                }
            });

            // Función para calcular el costo total
            function calcularCostoTotal() {
                let total = 0;
                document.querySelectorAll('input[name^="componentes["]').forEach(input => {
                    const cantidad = parseFloat(input.value);
                    const precioUnitario = 10; // Ajusta según sea necesario
                    total += cantidad * precioUnitario;
                });
                document.getElementById('coste').value = 'S/. ' + total.toFixed(2);
                calcularGanancia(); // Actualiza la ganancia después de calcular el costo total
            }

            // Función para calcular la ganancia
            function calcularGanancia() {
                const costoTotal = parseFloat(document.getElementById('coste').value.replace('S/. ', '')) || 0;
                const precioUnitario = parseFloat(document.getElementById('precio').value.replace('S/. ', '')) || 0;
                const stock = parseFloat(document.getElementById('stock').value) || 0;

                if (precioUnitario > 0) {
                    const gananciaPorUnidad = precioUnitario - (costoTotal / stock);
                    const porcentajeGanancia = ((gananciaPorUnidad / (costoTotal / stock)) * 100).toFixed(2);

                    document.getElementById('gananciaProducto').textContent = `Ganancia del Producto: S/. ${gananciaPorUnidad.toFixed(2)} (${porcentajeGanancia}%)`;
                } else {
                    document.getElementById('gananciaProducto').textContent = `Ganancia del Producto: S/. 0.00 (0%)`;
                }

                // Calcular la ganancia para los consumibles compuestos
                const componentes = document.querySelectorAll('input[name^="componentes["]');
                let costoCompuesto = 0;
                componentes.forEach(input => {
                    const cantidad = parseFloat(input.value);
                    const precioUnitario = 10; // Ajusta según sea necesario
                    costoCompuesto += cantidad * precioUnitario;
                });

                if (precioUnitario > 0) {
                    const gananciaCompuesto = precioUnitario - (costoCompuesto / stock);
                    const porcentajeGananciaCompuesto = ((gananciaCompuesto / (costoCompuesto / stock)) * 100).toFixed(2);

                    document.getElementById('gananciaCompuesto').textContent = `Ganancia del Compuesto: S/. ${gananciaCompuesto.toFixed(2)} (${porcentajeGananciaCompuesto}%)`;
                } else {
                    document.getElementById('gananciaCompuesto').textContent = `Ganancia del Compuesto: S/. 0.00 (0%)`;
                }
            }

            // Manejo del checkbox de consumible múltiple
            document.getElementById('consumible_multiple').addEventListener('change', function() {
                let esMultiple = this.checked;
                document.getElementById('marca').disabled = esMultiple;
                document.getElementById('marca').value = esMultiple ? 'Compuesto' : '';
                document.getElementById('coste').disabled = esMultiple;
                document.getElementById('stock').disabled = esMultiple;

                if (esMultiple) {
                    document.getElementById('coste').value = 'S/. 0.00';
                    document.getElementById('stock').value = '';
                    document.getElementById('precio').value = 'S/. 0.00';
                }

                const btnSeleccionar = document.querySelector('button[data-target="#categoriaModal"]');
                btnSeleccionar.disabled = !esMultiple;

                // Mostrar u ocultar el elemento de ganancia compuesto
                document.getElementById('gananciaCompuesto').classList.toggle('d-none', !esMultiple);
                document.getElementById('gananciaProducto').classList.toggle('d-none', esMultiple);
            });

            // Habilitar el botónde guardar selección del modal 
            document.getElementById('guardarSeleccion').addEventListener('click', function() {
                let selectedConsumibles = [];
                document.querySelectorAll('#consumiblesContainer input[type="checkbox"]').forEach(function(checkbox) {
                    selectedConsumibles.push(checkbox.value);
                });
                if (selectedConsumibles.length > 0) {
                    let lista = document.getElementById('listaConsumiblesSeleccionados');
                    lista.innerHTML = 'Consumibles Seleccionados: <ul>';
                    selectedConsumibles.forEach(function(id) {
                        lista.innerHTML += '<li>Consumible ID: ' + id + '</li>';
                    });
                    lista.innerHTML += '</ul>';
                } else {
                    document.getElementById('listaConsumiblesSeleccionados').innerHTML = 'No se han seleccionado consumibles.';
                }

                $('#categoriaModal').modal('hide');
            });

            // Manejo de selección de categorías en el modal
            document.getElementById('categoriasContainer').addEventListener('click', function(event) {
                if (event.target.classList.contains('categoria-btn')) {
                    let categoriaId = event.target.getAttribute('data-id');
                    // Aquí debes hacer una solicitud AJAX para obtener los consumibles de la categoría seleccionada
                    fetch('/gestion/app/controller/ArsenalController.php?action=getConsumiblesByCategoria&categoria_id=' + categoriaId)
                        .then(response => response.json())
                        .then(data => {
                            let consumiblesContainer = document.getElementById('consumiblesContainer');
                            consumiblesContainer.innerHTML = '';
                            data.consumibles.forEach(consumible => {
                                let checkbox = document.createElement('input');
                                checkbox.type = 'checkbox';
                                checkbox.value = consumible.id;
                                checkbox.id = 'consumible_' + consumible.id;
                                let label = document.createElement('label');
                                label.htmlFor = checkbox.id;
                                label.innerText = consumible.nombre;
                                consumiblesContainer.appendChild(checkbox);
                                consumiblesContainer.appendChild(label);
                                consumiblesContainer.appendChild(document.createElement('br'));
                            });
                        });
                }
            });

            // Función para calcular la ganancia
            function calcularGanancia() {
                const costoTotal = parseFloat(document.getElementById('coste').value.replace('S/. ', '')) || 0;
                const precioUnitario = parseFloat(document.getElementById('precio').value.replace('S/. ', '')) || 0;
                const stock = parseFloat(document.getElementById('stock').value) || 0;

                if (precioUnitario > 0) {
                    // Calcular ganancia del producto
                    const gananciaProducto = (precioUnitario * stock) - costoTotal;
                    const porcentajeGanancia = (gananciaProducto / costoTotal * 100).toFixed(2);

                    document.getElementById('gananciaProducto').textContent = `Ganancia del Producto: S/. ${gananciaProducto.toFixed(2)} (${porcentajeGanancia}%)`;
                } else {
                    document.getElementById('gananciaProducto').textContent = `Ganancia del Producto: S/. 0.00 (0%)`;
                }

                // Calcular la ganancia para los consumibles compuestos
                const componentes = document.querySelectorAll('input[name^="componentes["]');
                let costoCompuesto = 0;
                componentes.forEach(input => {
                    const cantidad = parseFloat(input.value);
                    const precioUnitario = 10; // Ajusta según sea necesario
                    costoCompuesto += cantidad * precioUnitario;
                });

                if (precioUnitario > 0) {
                    const gananciaCompuesto = precioUnitario - (costoCompuesto / stock);
                    const porcentajeGananciaCompuesto = ((gananciaCompuesto / (costoCompuesto / stock)) * 100).toFixed(2);

                    document.getElementById('gananciaCompuesto').textContent = `Ganancia del Compuesto: S/. ${gananciaCompuesto.toFixed(2)} (${porcentajeGananciaCompuesto}%)`;
                } else {
                    document.getElementById('gananciaCompuesto').textContent = `Ganancia del Compuesto: S/. 0.00 (0%)`;
                }
            }


            // Llama a calcularGanancia cuando cambien los campos relacionados
            document.getElementById('coste').addEventListener('input', calcularGanancia);
            document.getElementById('precio').addEventListener('input', calcularGanancia);
            document.getElementById('stock').addEventListener('input', calcularGanancia);


            // Limpiar y restaurar campos de coste y precio
            document.getElementById('coste').addEventListener('focus', function() {
                if (this.value === 'S/. 0.00') {
                    this.value = '';
                }
            });
            document.getElementById('precio').addEventListener('focus', function() {
                if (this.value === 'S/. 0.00') {
                    this.value = '';
                }
            });
            document.getElementById('coste').addEventListener('blur', function() {
                if (this.value === '') {
                    this.value = 'S/. 0.00';
                }
            });
            document.getElementById('precio').addEventListener('blur', function() {
                if (this.value === '') {
                    this.value = 'S/. 0.00';
                }
            });
        });
    </script>
</body>

</html>
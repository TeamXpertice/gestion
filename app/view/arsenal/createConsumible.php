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
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

    <!-- Incluye jQuery desde un CDN o archivo local -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    

    <script>
        // Manejo de selección de categorías en el modal
document.getElementById('categoriasContainer').addEventListener('click', function(event) {
    if (event.target.classList.contains('categoria-btn')) {
        let categoriaId = event.target.getAttribute('data-id');
        let consumiblesContainer = document.getElementById('consumiblesContainer');

        // Mostrar un mensaje de "Cargando..." mientras se realiza la solicitud
        consumiblesContainer.innerHTML = '<p>Cargando consumibles...</p>';

        // Solicitud AJAX para obtener los consumibles por categoría
        fetch(`/gestion/app/controller/ArsenalController.php?action=getConsumiblesByCategoria&id=${categoriaId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener los consumibles');
                }
                return response.json();
            })
            .then(data => {
                consumiblesContainer.innerHTML = ''; // Limpiamos el contenedor antes de agregar nuevos consumibles

                if (data.consumibles && data.consumibles.length > 0) {
                    data.consumibles.forEach(consumible => {
                        const consumibleHtml = `
                            <div class="consumible-item">
                                <span>${consumible.nombre} - Stock: ${consumible.stock}</span>
                                <input type="number" min="1" max="${consumible.stock}" value="1" id="cantidad_${consumible.id}">
                                <button type="button" class="btn btn-success agregar-consumible" 
                                    data-id="${consumible.id}" 
                                    data-nombre="${consumible.nombre}" 
                                    data-precio="${consumible.precio}" 
                                    data-stock="${consumible.stock}">
                                    Agregar
                                </button>
                            </div>
                        `;
                        consumiblesContainer.insertAdjacentHTML('beforeend', consumibleHtml);
                    });
                } else {
                    consumiblesContainer.innerHTML = '<p>No hay consumibles disponibles en esta categoría.</p>';
                }
            })
            .catch(error => {
                consumiblesContainer.innerHTML = `<p>Error al cargar consumibles: ${error.message}</p>`;
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
        document.getElementById('consumible_multiple').addEventListener('change', function() {
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
        document.addEventListener('click', function(event) {
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
    </script>
<script>
        $(document).ready(function() {
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
    </script>
</body>

</html>
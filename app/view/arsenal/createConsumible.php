<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Consumible</title>
    <link href="/gestion/public/css/stackpathbootstrap4.5.2.css/bootstrap.min.css" rel="stylesheet">
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
            </div>
            <div class="form-row">
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
                <div class="form-group col-md-4">
                    <button type="button" class="btn btn-secondary mb-5" data-toggle="modal" data-target="#categoriaModal">Agregar Categoría</button>
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
                    <input type="text" id="stock" name="stock" class="form-control" required min="0" placeholder="0">
                </div>
                <div class="form-group col-md-3">
                    <label for="coste">Costo Total del producto:</label>
                    <input type="text" id="coste" name="coste" class="form-control" value="S/. 0.00" required>
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
                    <label for="fecha_compra">Fecha de Compra o Elaboración:</label>
                    <input type="date" id="fecha_compra" name="fecha_compra" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control" required>
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



            <!-- Modal para agregar categorías -->
            <div class="modal fade" id="categoriaModal" tabindex="-1" role="dialog" aria-labelledby="categoriaModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="categoriaModalLabel">Agregar Nueva Categoría</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="nuevaCategoria">Nueva Categoría:</label>
                                    <input type="text" id="nuevaCategoria" name="nuevaCategoria" class="form-control">
                                </div>
                            </div>

                            <button type="button" id="addCategoriaBtn" class="btn btn-primary">Agregar</button>
                            <hr>


                            <h5>Categorías Existentes</h5>
                            <table class="table table-bordered table-categorias">
                                <thead>
                                    <tr>
                                        <th>Todas las categorías</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($categorias)): ?>
                                        <?php
                                        $total = count($categorias);
                                        for ($i = 0; $i < $total; $i += 2):
                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($categorias[$i]['nombre']); ?></td>
                                                <td>
                                                    <?php if (isset($categorias[$i + 1])): ?>
                                                        <?php echo htmlspecialchars($categorias[$i + 1]['nombre']); ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endfor; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="2">No hay categorías disponibles.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="/gestion/public/js/code.jquery3.6.0/jquery-3.6.0.min.js"></script>
    <script src="/gestion/public/js/stackpath.bootstrap4.5.2/bootstrap.min.js"></script>
    <!-- <script src="/gestion/app/view/arsenal/public/js/createConsumible.min.js"></script> -->
    <script>
        $(document).ready(function() {
            $('#addCategoriaBtn').on('click', function() {
                const nuevaCategoria = $('#nuevaCategoria').val().trim().toUpperCase();

                // Comprobar si la categoría ya existe en la tabla
                let categoriaExistente = false;
                $('.table-categorias tbody tr').each(function() {
                    const categoriaNombre = $(this).find('td').first().text().trim().toUpperCase();
                    if (categoriaNombre === nuevaCategoria) {
                        categoriaExistente = true;
                        return false; // Rompe el bucle
                    }
                });

                if (categoriaExistente) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Categoría existente',
                        text: 'Esta categoría ya está en la lista.',
                    });
                } else if (nuevaCategoria) {
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
                                // Reiniciar el campo de nueva categoría
                                $('#nuevaCategoria').val('');

                                // Agregar la nueva categoría a la tabla de categorías existentes
                                $('.table-categorias tbody').append(`
                        <tr>
                            <td>${nuevaCategoria}</td>
                            <td></td>
                        </tr>
                    `);

                                // Agregar la nueva categoría al select
                                $('#categoria').append(`
                        <option value="${data.newId}">${nuevaCategoria}</option>
                    `);

                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Categoría agregada!',
                                    text: 'La categoría se ha agregado exitosamente.',
                                    timer: 1000,
                                    showConfirmButton: false
                                });
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
        $(document).ready(function() {
            $('#addCategoriaBtn').on('click', function() {
                const nuevaCategoria = $('#nuevaCategoria').val().trim().toUpperCase();

                let categoriaExistente = false;
                $('.table-categorias tbody tr').each(function() {
                    const categoriaNombre = $(this).find('td').first().text().trim().toUpperCase();
                    if (categoriaNombre === nuevaCategoria) {
                        categoriaExistente = true;
                        return false;
                    }
                });

                if (categoriaExistente) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Categoría existente',
                        text: 'Esta categoría ya está en la lista.',
                    });
                } else if (nuevaCategoria) {
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
                                $('#nuevaCategoria').val('');
                                $('.table-categorias tbody').append(`<tr><td>${nuevaCategoria}</td><td></td></tr>`);
                                $('#categoria').append(`<option value="${data.newId}">${nuevaCategoria}</option>`);

                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Categoría agregada!',
                                    text: 'La categoría se ha agregado exitosamente.',
                                    timer: 1000,
                                    showConfirmButton: false
                                });
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

            // Lógica para habilitar el formulario de lotes cuando se crea un consumible simple
            $('#guardarConsumible').on('click', function() {
                const esCompuesto = $('#consumible_multiple').is(':checked');

                // Solo mostrar la sección de lotes si es un consumible simple
                if (!esCompuesto) {
                    $('#loteSection').show();
                }
            });

            $('#guardarLote').on('click', function() {
                const cantidad = $('#cantidad').val();
                const costoTotal = $('#costo_total').val();
                const precioUnitario = $('#precio_unitario_lote').val();
                const fechaIngreso = $('#fecha_ingreso').val();
                const fechaVencimiento = $('#fecha_vencimiento_lote').val();

                // Validación y envío de datos del lote
                if (cantidad && costoTotal && precioUnitario && fechaIngreso && fechaVencimiento) {
                    fetch('/gestion/app/controller/ArsenalController.php?action=guardarLote', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `cantidad=${cantidad}&costo_total=${costoTotal}&precio_unitario=${precioUnitario}&fecha_ingreso=${fechaIngreso}&fecha_vencimiento=${fechaVencimiento}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Lote guardado!',
                                    text: 'El lote se ha guardado exitosamente.',
                                    timer: 1000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Hubo un problema al guardar el lote.'
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
                        title: 'Campos incompletos',
                        text: 'Por favor, llena todos los campos del lote.'
                    });
                }
            });
        });



        // CONTROL DEL CLICK QUE MANJE ALAS CATEGORIAS
        document.getElementById('categoriasContainer').addEventListener('click', function(event) {
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
        document.getElementById('consumible_multiple').addEventListener('change', function() {
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

            if (event.target.classList.contains('remover-consumible')) {
                const consumibleId = event.target.getAttribute('data-id');
                document.getElementById(`consumible_${consumibleId}`).remove();
                calcularStockCompuesto();
                calcularCostoCompuesto();
                calcularGanancia();
            }
        });

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
        $(document).ready(function() {
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


        });
    </script>
</body>

</html>
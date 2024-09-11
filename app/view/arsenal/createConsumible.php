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

    <!-- Botón para abrir el modal de selección de consumibles -->
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#categoriaModal">Seleccionar Consumibles</button>

<!-- Modal de selección de categorías y consumibles -->
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardarSeleccion">Guardar Selección</button>
            </div>
        </div>
    </div>
</div>

<!-- Lista de consumibles seleccionados -->
<div id="listaConsumiblesSeleccionados"></div>

<button type="submit" class="btn btn-primary">Guardar</button>
</form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
// Manejar la selección de categorías y mostrar consumibles
document.querySelectorAll('.categoria-btn').forEach(button => {
    button.addEventListener('click', function () {
        const categoriaId = this.getAttribute('data-id');
        
        // Hacer una solicitud para obtener los consumibles de la categoría seleccionada
        fetch(`/gestion/app/controller/ArsenalController.php?action=getConsumiblesByCategoria&id=${categoriaId}`)
            .then(response => response.json())
            .then(data => {
                if (data.consumibles.length > 0) {
                    let consumiblesHtml = '';
                    data.consumibles.forEach(consumible => {
                        consumiblesHtml += `
                            <div class="consumible-item">
                                <span>${consumible.nombre} - Stock: ${consumible.stock}</span>
                                <input type="number" min="1" max="${consumible.stock}" value="1" id="cantidad_${consumible.id}">
                                <button type="button" class="btn btn-success agregar-consumible" data-id="${consumible.id}" data-nombre="${consumible.nombre}">
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
            .catch(error => console.error('Error al obtener los consumibles:', error));
    });
});

// Agregar consumible seleccionado
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('agregar-consumible')) {
        const consumibleId = event.target.getAttribute('data-id');
        const consumibleNombre = event.target.getAttribute('data-nombre');
        const cantidadSeleccionada = document.getElementById(`cantidad_${consumibleId}`).value;

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
        } else {
            alert('Este consumible ya ha sido seleccionado.');
        }
    }
});

// Remover consumible de la lista
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('remover-consumible')) {
        const consumibleId = event.target.getAttribute('data-id');
        document.getElementById(`consumible_${consumibleId}`).remove();
    }
});
});
</script>

<script>
// Limpiar el campo de coste y precio al enfocarse, restaurar valor si queda vacío
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
</body>

</html>
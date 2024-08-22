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
                    <label for="unidad_medida">Unidad de Medida:</label>
                    <input type="text" id="unidad_medida" name="unidad_medida" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="stock">Stock:</label>
                    <input type="number" id="stock" name="stock" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="coste">Coste:</label>
                    <input type="number" id="coste" name="coste" class="form-control" step="0.01">
                </div>
                <div class="form-group col-md-4">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" class="form-control" step="0.01" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="descripcion_consumible">Descripción:</label>
                    <textarea id="descripcion_consumible" name="descripcion_consumible" class="form-control" required></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="observacion">Observación:</label>
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
                <div class="form-group col-md-4">
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria" class="form-control" required>
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


<div class="form-group col-md-4">
    <label for="nuevaCategoria">Nueva Categoría</label>
    <input type="text" id="nuevaCategoria" name="nuevaCategoria" class="form-control">
    <button type="button" id="addCategoriaBtn">Agregar</button>
</div>
</div>
<button type="submit" class="btn btn-primary">Guardar</button>
<script>
document.getElementById('addCategoriaBtn').addEventListener('click', function () {
    const nuevaCategoria = document.getElementById('nuevaCategoria').value;
    
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
                const select = document.getElementById('categoria');
                const option = document.createElement('option');
                option.value = data.id;
                option.text = data.nombre;
                select.add(option);
                select.value = data.id;
            } else {
                alert('Error al agregar la categoría.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});
</script>
</body>
</html>

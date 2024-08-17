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
                    <label for="nueva_categoria">Agregar nueva categoría:</label>
                    <input type="text" id="nueva_categoria" name="nueva_categoria" class="form-control">
                    <button type="button" id="agregar_categoria" class="btn btn-secondary mt-2">Agregar</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
        $(document).ready(function() {
            $('#agregar_categoria').click(function() {
                var nuevaCategoria = $('#nueva_categoria').val();
                if (nuevaCategoria.trim() === '') {
                    alert('Por favor ingrese una categoría.');
                    return;
                }

                $.post('/gestion/app/controller/ArsenalController.php?action=addCategoria', { nombre: nuevaCategoria }, function(response) {
                    if (response.success) {
                        $('#nueva_categoria').val('');
                        $('#categoria').append('<option value="' + response.id + '">' + response.nombre + '</option>');
                        alert('Categoría agregada con éxito.');
                    } else {
                        alert('Error al agregar categoría.');
                    }
                }, 'json');
            });
        });
</script>

</body>
</html>

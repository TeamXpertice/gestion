<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Consumible</title>
    <link href="/gestion/public/css/stackpathbootstrap4.5.2.css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Editar Consumible</h1>
        <form action="/gestion/app/controller/ArsenalController.php?action=editConsumible&id=<?php echo htmlspecialchars($consumible['id']); ?>" method="post">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($consumible['nombre']); ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria" class="form-control">
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo htmlspecialchars($categoria['id']); ?>" <?php echo ($selectedCategoria == $categoria['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categoria['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="marca">Marca:</label>
                    <input type="text" id="marca" name="marca" class="form-control" value="<?php echo htmlspecialchars($consumible['marca']); ?>">
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
            
                    <div class="form-group col-md-2 ">
                        <label for="stock">Stock:</label>
                        <input type="number" id="stock" name="stock" class="form-control" value="<?php echo htmlspecialchars($consumible['stock']); ?>" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="coste">Coste:</label>
                        <input type="number" id="coste" name="coste" class="form-control" step="0.01" value="<?php echo htmlspecialchars($consumible['coste']); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="precio">Precio:</label>
                        <input type="number" id="precio" name="precio" class="form-control" step="0.01" value="<?php echo htmlspecialchars($consumible['precio']); ?>" required>
                    </div>
               
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="descripcion_consumible">Descripción:</label>
                        <textarea id="descripcion_consumible" name="descripcion_consumible" class="form-control" required><?php echo htmlspecialchars($consumible['descripcion_consumible']); ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="observacion">Observación:</label>
                        <textarea id="observacion" name="observacion" class="form-control"><?php echo htmlspecialchars($consumible['observacion']); ?></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
                        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control" value="<?php echo htmlspecialchars($consumible['fecha_vencimiento']); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="fecha_compra">Fecha de Compra:</label>
                        <input type="date" id="fecha_compra" name="fecha_compra" class="form-control" value="<?php echo htmlspecialchars($consumible['fecha_compra']); ?>">
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>
</body>

</html>
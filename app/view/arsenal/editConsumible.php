<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Consumible</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Editar Consumible</h1>
        <form action="/gestion/app/controller/ArsenalController.php?action=editConsumible&id=<?php echo htmlspecialchars($consumible['id']); ?>" method="post">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($consumible['nombre']); ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="nombre_proveedor">Nombre del Proveedor:</label>
                    <input type="text" id="nombre_proveedor" name="nombre_proveedor" class="form-control" value="<?php echo htmlspecialchars($consumible['nombre_proveedor']); ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="modelo">Modelo:</label>
                    <input type="text" id="modelo" name="modelo" class="form-control" value="<?php echo htmlspecialchars($consumible['modelo']); ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="serie_codigo">Serie/Código:</label>
                    <input type="text" id="serie_codigo" name="serie_codigo" class="form-control" value="<?php echo htmlspecialchars($consumible['serie_codigo']); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="marca">Marca:</label>
                    <input type="text" id="marca" name="marca" class="form-control" value="<?php echo htmlspecialchars($consumible['marca']); ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="unidad_medida">Unidad de Medida:</label>
                    <input type="text" id="unidad_medida" name="unidad_medida" class="form-control" value="<?php echo htmlspecialchars($consumible['unidad_medida']); ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="tamano">Tamaño:</label>
                    <input type="text" id="tamano" name="tamano" class="form-control" value="<?php echo htmlspecialchars($consumible['tamano']); ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="color">Color:</label>
                    <input type="text" id="color" name="color" class="form-control" value="<?php echo htmlspecialchars($consumible['color']); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="tipo_material">Tipo de Material:</label>
                    <input type="text" id="tipo_material" name="tipo_material" class="form-control" value="<?php echo htmlspecialchars($consumible['tipo_material']); ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="estado_fisico_actual">Estado Físico Actual:</label>
                    <input type="text" id="estado_fisico_actual" name="estado_fisico_actual" class="form-control" value="<?php echo htmlspecialchars($consumible['estado_fisico_actual']); ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control" value="<?php echo htmlspecialchars($consumible['fecha_vencimiento']); ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="lote">Lote:</label>
                    <input type="text" id="lote" name="lote" class="form-control" value="<?php echo htmlspecialchars($consumible['lote']); ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="descripcion_consumible">Descripción:</label>
                <textarea id="descripcion_consumible" name="descripcion_consumible" class="form-control" required><?php echo htmlspecialchars($consumible['descripcion_consumible']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="observacion">Observación:</label>
                <textarea id="observacion" name="observacion" class="form-control" required><?php echo htmlspecialchars($consumible['observacion']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>
</body>
</html>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Bien</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Editar Bien</h1>
        <form action="/gestion/app/controller/ArsenalController.php?action=editBien&id=<?php echo htmlspecialchars($bien['id']); ?>" method="post">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="descripcion_bien">Descripción*:</label>
                    <input type="text" id="descripcion_bien" name="descripcion_bien" class="form-control" value="<?php echo htmlspecialchars($bien['descripcion_bien']); ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="nombre_proveedor">Nombre del Proveedor:</label>
                    <input type="text" id="nombre_proveedor" name="nombre_proveedor" class="form-control" value="<?php echo htmlspecialchars($bien['nombre_proveedor']); ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="modelo">Modelo:</label>
                    <input type="text" id="modelo" name="modelo" class="form-control" value="<?php echo htmlspecialchars($bien['modelo']); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="serie_codigo">Serie/Código:</label>
                    <input type="text" id="serie_codigo" name="serie_codigo" class="form-control" value="<?php echo htmlspecialchars($bien['serie_codigo']); ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="marca">Marca:</label>
                    <input type="text" id="marca" name="marca" class="form-control" value="<?php echo htmlspecialchars($bien['marca']); ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="estado">Estado*:</label>
                    <input type="text" id="estado" name="estado" class="form-control" value="<?php echo htmlspecialchars($bien['estado']); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="dimensiones">Dimensiones*:</label>
                    <input type="text" id="dimensiones" name="dimensiones" class="form-control" value="<?php echo htmlspecialchars($bien['dimensiones']); ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="color">Color*:</label>
                    <input type="text" id="color" name="color" class="form-control" value="<?php echo htmlspecialchars($bien['color']); ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="tipo_material">Tipo de Material*:</label>
                    <input type="text" id="tipo_material" name="tipo_material" class="form-control" value="<?php echo htmlspecialchars($bien['tipo_material']); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="estado_fisico_actual">Estado Físico Actual*:</label>
                    <input type="text" id="estado_fisico_actual" name="estado_fisico_actual" class="form-control" value="<?php echo htmlspecialchars($bien['estado_fisico_actual']); ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" class="form-control" value="<?php echo htmlspecialchars($bien['cantidad']); ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="coste">Coste*:</label>
                    <input type="number" id="coste" name="coste" class="form-control" step="0.01" value="<?php echo htmlspecialchars($bien['coste']); ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="descripcion_bien">Descripción:</label>
                <textarea id="descripcion_bien" name="descripcion_bien" class="form-control" required><?php echo htmlspecialchars($bien['descripcion_bien']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="observacion">Observación:</label>
                <textarea id="observacion" name="observacion" class="form-control"><?php echo htmlspecialchars($bien['observacion']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>
</body>

</html>

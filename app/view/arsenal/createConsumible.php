<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Consumible</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
    <style>
        .form-row .col-md-4 {
            margin-bottom: 1.5rem;
        }
        textarea.form-control {
            height: 100px;
        }
        textarea.form-control.observacion, textarea.form-control.descripcion_consumible {
            height: 200px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Agregar Consumible</h1>
        <form action="/gestion/app/controller/ArsenalController.php?action=createConsumible" method="post">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nombre">Nombre*:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="nombre_proveedor">Nombre del proveedor*:</label>
                    <input type="text" id="nombre_proveedor" name="nombre_proveedor" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="modelo">Modelo:</label>
                    <input type="text" id="modelo" name="modelo" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="serie_codigo">Serie/código:</label>
                    <input type="number" id="serie_codigo" name="serie_codigo" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="marca">Marca:</label>
                    <input type="text" id="marca" name="marca" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="unidad_medida">Unidad de medida*:</label>
                    <input type="text" id="unidad_medida" name="unidad_medida" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="tamano">tamano*:</label>
                    <input type="text" id="tamano" name="tamano" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="color">Color*:</label>
                    <input type="text" id="color" name="color" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="tipo_material">Tipo de material*:</label>
                    <input type="text" id="tipo_material" name="tipo_material" class="form-control" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="estado_fisico_actual">Estado físico del consumible*:</label>
                    <input type="text" id="estado_fisico_actual" name="estado_fisico_actual" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="descripcion_consumible">Descripción*:</label>
                    <textarea id="descripcion_consumible" name="descripcion_consumible" class="form-control descripcion_consumible" required></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="observacion">Observación:</label>
                    <textarea id="observacion" name="observacion" class="form-control observacion"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="fecha_vencimiento">Fecha de vencimiento:</label>
                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="lote">Lote:</label>
                    <input type="text" id="lote" name="lote" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Consumible</button>
        </form>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>
</body>

</html>

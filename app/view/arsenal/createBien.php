<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Bien</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
    <style>
        .form-row .col-md-4 {
            margin-bottom: 1.5rem;
        }
        textarea.form-control {
            height: 100px;
        }
        textarea.form-control.observacion, textarea.form-control.descripcion_bien {
            height: 200px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Agregar Bien</h1>
        <form action="/gestion/app/controller/ArsenalController.php?action=createBien" method="post">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="descripcion_bien">Descripción*:</label>
                    <input type="text" id="descripcion_bien" name="descripcion_bien" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="nombre_proveedor">Nombre del proveedor:</label>
                    <input type="text" id="nombre_proveedor" name="nombre_proveedor" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="modelo">Modelo:</label>
                    <input type="text" id="modelo" name="modelo" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="serie_codigo">Serie/Código:</label>
                    <input type="text" id="serie_codigo" name="serie_codigo" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="marca">Marca:</label>
                    <input type="text" id="marca" name="marca" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="estado">Estado*:</label>
                    <input type="text" id="estado" name="estado" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="dimensiones">Dimensiones*:</label>
                    <input type="text" id="dimensiones" name="dimensiones" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="color">Color*:</label>
                    <input type="text" id="color" name="color" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="tipo_material">Tipo de Material*:</label>
                    <input type="text" id="tipo_material" name="tipo_material" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="estado_fisico_actual">Estado Físico Actual*:</label>
                    <input type="text" id="estado_fisico_actual" name="estado_fisico_actual" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="coste">Coste por Unidad*:</label>
                    <input type="number" id="coste" name="coste" class="form-control" step="0.01" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="descripcion_bien">Descripción:</label>
                    <textarea id="descripcion_bien" name="descripcion_bien" class="form-control descripcion_bien" required></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="observacion">Observación:</label>
                    <textarea id="observacion" name="observacion" class="form-control observacion"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Bien</button>
        </form>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>
</body>

</html>

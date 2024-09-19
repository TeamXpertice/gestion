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

    <script src="/gestion/public/js/code.jquery3.6.0/jquery-3.6.0.min.js"></script>
    <script src="/gestion/public/js/stackpath.bootstrap4.5.2/bootstrap.min.js"></script>
    <script src="/gestion/app/view/arsenal/public/js/createConsumible.min.js"></script>

</body>

</html>https://code.jquery.com/jquery-3.5.1.min.js"
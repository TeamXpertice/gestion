
    <div class="container mt-1">
        <h2>Consumibles</h2>
        <a href="/gestion/app/controller/ArsenalController.php?action=createConsumible" class="btn btn-primary mb-3">Agregar boton prueba</a>
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalCrearConsumible">
            Agregar Consumible
        </button>

        <button type="button" class="btn btn-secondary mb-3" data-toggle="modal" data-target="#categoriaModal">
            Agregar Categoría
        </button>

        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Precio</th>
                    <!-- <th>Acciones</th> -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consumibles as $consumible): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($consumible['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($consumible['descripcion_consumible']); ?></td>
                        <td><?php echo htmlspecialchars($consumible['fecha_vencimiento']); ?></td>
                        <td><?php echo htmlspecialchars($consumible['precio_unitario']); ?></td>
                        <!-- <td>
                            <a href="/gestion/app/controller/ArsenalController.php?action=editConsumible&id=<?php echo $consumible['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="/gestion/app/controller/ArsenalController.php?action=deleteConsumible&id=<?php echo $consumible['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este consumible?');">Eliminar</a>
                        </td> -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

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

                    <!-- Tabla para mostrar categorías existentes -->
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

    <!-- Modal para crear consumibles simples y compuestos -->
    <div class="modal fade" id="modalCrearConsumible" tabindex="-1" role="dialog" aria-labelledby="modalCrearConsumibleLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearConsumibleLabel">Crear Consumible</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Pestañas para alternar entre simple y compuesto -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="simple-tab" data-toggle="tab" href="#simple" role="tab" aria-controls="simple" aria-selected="true">Consumible Simple</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="compuesto-tab" data-toggle="tab" href="#compuesto" role="tab" aria-controls="compuesto" aria-selected="false">Consumible Compuesto</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <!-- Formulario para Consumible Simple -->
                        <div class="tab-pane fade show active" id="simple" role="tabpanel" aria-labelledby="simple-tab">
                            <form action="/gestion/app/controller/ArsenalController.php?action=createConsumible" method="post">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="marca">Marca:</label>
                                        <input type="text" id="marca" name="marca" class="form-control">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="unidad_medida">Unidad de Medida</label>
                                        <select id="unidad_medida" name="unidad_medida" class="form-control" required>
                                            <option value="u">Unidad</option>
                                            <option value="g">Gramos</option>
                                            <option value="kg">Kilogramos</option>
                                            <option value="L">Litro</option>
                                        </select>
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
                                    <div class="form-group col-md-6">
                                        <label for="descripcion_consumible">Descripción del producto:</label>
                                        <textarea id="descripcion_consumible" name="descripcion_consumible" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="observacion">Observación del producto:</label>
                                        <textarea id="observacion" name="observacion" class="form-control"></textarea>
                                    </div>
                                </div>

                                <!-- Detalles del Lote -->
                                <div id="loteSectionSimple">
                                    <h5>Detalles</h5>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="stock">Stock:</label>
                                            <input type="number" id="stock" name="stock" class="form-control" min="1" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="coste">Costo Total del Producto:</label>
                                            <input type="text" id="coste" name="coste" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="precio_unitario">Precio Unitario:</label>
                                            <input type="text" id="precio_unitario" name="precio_unitario" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="fecha_ingreso">Fecha de Ingreso:</label>
                                            <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
                                            <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mostrar ganancia calculada -->
                                <div class="mt-4">
                                    <h5>Ganancia</h5>
                                    <div id="gananciaContainer" class="alert alert-info">
                                        <p id="gananciaProducto">Ganancia del Producto: S/. 0.00 (0%)</p>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Guardar Consumible</button>
                            </form>
                        </div>

                        <!-- Formulario para Consumible Compuesto -->
                        <div class="tab-pane fade" id="compuesto" role="tabpanel" aria-labelledby="compuesto-tab">
                            <form action="/gestion/app/controller/ArsenalController.php?action=createConsumibleCompuesto" method="post">
                                <h5>Formulario de Consumible Compuesto</h5>

                                <div class="row" id="materialList">
                                    <?php
                                    $colors = ['red', 'blue', 'green', 'orange', 'purple', 'teal', 'yellow'];
                                    foreach ($categorias as $index => $categoria):
                                        $colorClass = $colors[$index % count($colors)];
                                    ?>
                                        <div class="col-4">
                                            <button type="button" class="category-button category-<?php echo $colorClass; ?>" onclick="mostrarConsumiblesPorCategoria(<?php echo $categoria['id']; ?>)">
                                                <?php echo htmlspecialchars($categoria['nombre']); ?>
                                            </button>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div id="consumiblesList" class="mt-4">
                                    <!-- Aquí se mostrarán los consumibles de la categoría seleccionada -->
                                </div>

                                <!-- Lista de consumibles seleccionados -->
                                <div id="listaConsumiblesSeleccionados"></div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" id="nombre" name="nombre" class="form-control" required>
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
                                    <div class="form-group col-md-3">
                                        <label for="unidad_medida">Unidad de Medida</label>
                                        <select id="unidad_medida" name="unidad_medida" class="form-control" required>
                                            <option value="u">Unidad</option>
                                            <option value="g">Gramos</option>
                                            <option value="kg">Kilogramos</option>
                                            <option value="L">Litro</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="descripcion">Descripción</label>
                                        <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="precio_sugerido">Precio Sugerido</label>
                                        <input type="text" id="precio_sugerido" name="precio_sugerido" class="form-control" value="S/. 0.00">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Ganancia Calculada</label>
                                        <div id="gananciaContainer" class="alert alert-info">
                                            <p id="gananciaProductoCompuesto">Ganancia S/. 0.00 (0%)</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Costo Total (calculado)</label>
                                        <input type="text" id="costo_total" class="form-control" value="S/. 0.00" disabled>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Stock Total (calculado)</label>
                                        <input type="text" id="stock_total" class="form-control" value="0" disabled>
                                    </div>
                                </div>

                                <!-- Botón para guardar el consumible compuesto -->
                                <button type="submit" class="btn btn-primary">Guardar Consumible Compuesto</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

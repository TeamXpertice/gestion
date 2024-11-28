<style>
    #tablaConsumiblesSimples {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #dcdcdc;
        font-family: 'Arial', sans-serif;
        font-size: 14px;
        background-color: #64656a;
        border-radius: 8px;
        overflow: hidden;
    }

    #tablaConsumiblesSimples thead {
        background: #124072;
        color: #ffffff;
        text-transform: uppercase;
    }

    #tablaConsumiblesSimples thead th {
        padding: 10px 0px;
        text-align: center;
        font-weight: bold;
        border-bottom: 2px solid #dee2e6;
    }

    #tablaConsumiblesSimples tbody td {
        padding: 12px 10px;
        text-align: center;
        border-bottom: 1px solid #f1f1f1;
    }

    #tablaConsumiblesSimples tbody tr:nth-child(odd) {
        background-color: #f8f9fa;
    }

    #tablaConsumiblesSimples tbody tr:hover {
        background-color: #124072;
        color: #ffffff;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* --------------------------------*/

    #tablaCompuestos {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #dcdcdc;
        font-family: 'Arial', sans-serif;
        font-size: 14px;
        background-color: #64656a;
        border-radius: 8px;
        overflow: hidden;
    }

    #tablaCompuestos thead {
        background: #124072;
        color: #ffffff;
        text-transform: uppercase;
    }

    #tablaCompuestos thead th {
        padding: 10px 0px;
        text-align: center;
        font-weight: bold;
        border-bottom: 2px solid #dee2e6;
    }

    #tablaCompuestos tbody td {
        padding: 12px 10px;
        text-align: center;
        border-bottom: 1px solid #f1f1f1;
    }

    #tablaCompuestos tbody tr:nth-child(odd) {
        background-color: #f8f9fa;
    }

    #tablaCompuestos tbody tr:hover {
        background-color: #124072;
        color: #ffffff;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .dt-buttons .dt-button {
        background: #64656a;
        color: #fffefe;
        border: none;
        padding: 6px 15px;
        border-radius: 5px;
        transition: all 0.3s ease-in-out;
        cursor: pointer;
    }

    .dt-buttons .dt-button:hover {
        background-color: #124072;
        color: #000000;
        transition: all 0.3s ease-in-out;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background-color: #fff;
        color: #fff;
        border: none;
        padding: 6px 12px;
        margin: 2px;
        border-radius: 5px;
    }

    .modal,
    .modal-backdrop {
        opacity: 1;
    }

    #consumiblesList div {
        display: flex;
        align-items: center;
    }

    #consumiblesList input[type="number"] {
        width: 60px;
        margin-left: 10px;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #000000;
        border-radius: 4px;
        outline: none;
        padding: 4px;
        background-color: #f0f0f0;
        color: #333;
    }

    /* Estilos generales para los botones */
    .btn {

        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        opacity: 0.8;
        background-color: #dee2e6;
        color: black;
        border: 0.5px solid black;
    }

    .btn-red {
        background-color: #ff4d4d;
    }

    .btn-blue {
        background-color: #4d90fe;
    }

    .btn-green {
        background-color: #4CAF50;
    }

    .btn-orange {
        background-color: #ff9800;
    }

    .btn-purple {
        background-color: #9c27b0;
    }

    .btn-teal {
        background-color: #008080;
    }

    .btn-yellow {
        background-color: #ffeb3b;
    }

    .btn-excel i,
    .btn-print i {
        margin-right: 5px;
        font-size: 16px;
    }

    .btn-excel i {
        color: #4CAF50;
    }

    .btn-print i {
        color: #2196F3;
    }
</style>
<div class="col-sm-6">
    <h5 class="mb-5">Productos</h5>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-end">
        <li class="breadcrumb-item"><a href="/gestion/app/controller/DashboardController.php?action=showDashboard">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">
            Ver Productos
        </li>
    </ol>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="mb-0">

                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalCrearConsumible">
                    Agregar Consumible
                </button>
                <button type="button" class="btn btn-danger mb-3" data-toggle="modal" data-target="#categoriaModal">
                    Agregar Categoría
                </button>
                <button id="toggleCompuestos" class="btn btn-info mb-3">
                    Mostrar Compuestos
                </button>
            </div>

            <div class="row">

                <div class="col-md-12" id="cardSimples">
                    <h6>Productos Simples</h6>
                    <div class="table-responsive">
                        <table id="tablaConsumiblesSimples" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Fecha de Vencimiento</th>
                                    <th>Precio de Venta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($agrupadosSimples as $nombre => $lotes) {
                                    $lotesConStock = array_filter($lotes, fn($lote) => $lote['cantidad'] > 0);

                                    if (!empty($lotesConStock)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($nombre) . "</td>";

                                        echo "<td>";
                                        foreach ($lotesConStock as $index => $lote) {
                                            echo ($index + 1) . "° Stock: " . htmlspecialchars($lote['cantidad']) . "<br>";
                                        }
                                        echo "</td>";

                                        echo "<td>";
                                        foreach ($lotesConStock as $index => $lote) {
                                            echo ($index + 1) . "° Vence: " . htmlspecialchars($lote['fecha_vencimiento']) . "<br>";
                                        }
                                        echo "</td>";

                                        echo "<td>";
                                        foreach ($lotesConStock as $index => $lote) {
                                            echo ($index + 1) . "° Precio: S/. " . htmlspecialchars($lote['precio_unitario']) . "<br>";
                                        }
                                        echo "</td>";

                                        echo "</tr>";
                                    } else {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($nombre) . "</td>";
                                        echo "<td>No hay stock</td>";
                                        echo "<td>---</td>";
                                        echo "<td>---</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-4" id="cardCompuestos" style="display: none;">
                    <div class="table-responsive">
                        <h6>Productos Compuesto</h6>
                        <table id="tablaCompuestos" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Precio Sugerido</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($consumiblesCompuestos as $compuesto) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($compuesto['nombre']) . "</td>";
                                    echo "<td>S/. " . htmlspecialchars($compuesto['precio_sugerido']) . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="modal" id="categoriaModal" tabindex="-1" role="dialog" aria-labelledby="categoriaModalLabel" aria-hidden="true">
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

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Modal para crear consumibles -->
            <div class="modal" id="modalCrearConsumible" tabindex="-1" role="dialog" aria-labelledby="modalCrearConsumibleLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCrearConsumibleLabel">Crear Consumible</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="simple-tab" data-toggle="tab" href="#simple" role="tab" aria-controls="simple" aria-selected="true">Consumible Simple</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="compuesto-tab" data-toggle="tab" href="#compuesto" role="tab" aria-controls="compuesto" aria-selected="false">Consumible Compuesto</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <!-- Consumibles simples -->
                                <div class="tab-pane show active" id="simple" role="tabpanel" aria-labelledby="simple-tab">
                                    <form action="/gestion/app/controller/ArsenalController.php?action=CrearConsumibleSimple" method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="nombre">Nombre*:</label>
                                                <input type="text" id="nombre" name="nombre" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="marca">Marca:</label>
                                                <input type="text" id="marca" name="marca" class="form-control">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="unidad_medida">Unidad de Medida*</label>
                                                <select id="unidad_medida" name="unidad_medida" class="form-control" required>
                                                    <option value="u">Unidad</option>
                                                    <option value="g">Gramos</option>
                                                    <option value="kg">Kilogramos</option>
                                                    <option value="L">Litro</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="categoria">Seleccionar Categoría*:</label>
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
                                            <div class="form-group col-md-6">
                                                <label for="descripcion_consumible">Descripción del producto:</label>
                                                <textarea id="descripcion_consumible" name="descripcion_consumible" class="form-control"></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="observacion">Observación del producto:</label>
                                                <textarea id="observacion" name="observacion" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <!-- Lotes -->
                                        <div id="loteSectionSimple">
                                            <h5>Detalles</h5>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="stock">Stock*:</label>
                                                    <input type="number" id="stock" name="stock" class="form-control" min="1" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="coste">Costo Total del Producto*:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">S/.</span>
                                                        </div>
                                                        <input type="text" id="coste" name="coste" class="form-control" required pattern="^\d+(\.\d{1,2})?$" title="Solo se permiten números y hasta dos decimales">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="precio_unitario">Precio Unitario*:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">S/.</span>
                                                        </div>
                                                        <input type="text" id="precio_unitario" name="precio_unitario" class="form-control" required pattern="^\d+(\.\d{1,2})?$" title="Solo se permiten números y hasta dos decimales">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="fecha_ingreso">Fecha de Ingreso*:</label>
                                                    <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
                                                    <br>
                                                    <button type="button" class="btn btn-primary" onclick="agregarDias('fecha_ingreso', 1)">+1 Día</button>
                                                    <button type="button" class="btn btn-primary" onclick="agregarDias('fecha_ingreso', 3)">+3 Días</button>
                                                    <button type="button" class="btn btn-primary" onclick="agregarDias('fecha_ingreso', 5)">+5 Días</button>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="fecha_vencimiento">Fecha de Vencimiento*:</label>
                                                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control" required value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>">
                                                    <br>
                                                    <button type="button" class="btn btn-primary" onclick="agregarDias('fecha_vencimiento', 1)">+1 Día</button>
                                                    <button type="button" class="btn btn-primary" onclick="agregarDias('fecha_vencimiento', 3)">+3 Días</button>
                                                    <button type="button" class="btn btn-primary" onclick="agregarDias('fecha_vencimiento', 5)">+5 Días</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <h5>Ganancia Simple</h5>
                                            <div id="gananciaContainer" class="alert alert-info">
                                                <p id="gananciaProducto">Ganancia del Producto: S/. 0.00 (0%)</p>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            Guardar Consumible
                                        </button>
                                    </form>
                                </div>

                                <div class="tab-pane" id="compuesto" aria-labelledby="compuesto-tab">

                                    <form id="formConsumibleCompuesto" action="/gestion/app/controller/ArsenalController.php?action=CrearConsumibleCompuesto" method="post">
                                        <div class="row mt-3">
                                            <div class="form-group col-md-5">
                                                <label for="nombre">Nombre:*</label>
                                                <input type="text" id="nombre" name="nombre" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="precio_sugerido">Precio Sugerido*:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">S/.</span>
                                                    </div>
                                                    <input type="text" id="precio_sugerido" name="precio_sugerido" class="form-control" required pattern="^\d+(\.\d{1,2})?$" title="Solo se permiten números y hasta dos decimales">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="categoria">Seleccionar Categoría*:</label>
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
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary mb-3" id="btnAbrirConsumibles" data-toggle="modal" data-target="#modalConsumibles">
                                                Mostrar Consumibles
                                            </button>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="form-group col-md-8">
                                                <div id="vistaPreviaSeleccion" class="alert alert-info">
                                                    <p>No hay consumibles seleccionados.</p>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <button type="button" class="btn btn-danger" onclick="borrarConsumiblesSeleccionados()">Borrar Selección</button>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Guardar Consumible Compuesto</button>
                                    </form>
                                </div>

                                <div class="modal fade" id="modalConsumibles" tabindex="-1" role="dialog" aria-labelledby="modalConsumiblesLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalConsumiblesLabel">Consumibles</h5>
                                            </div>
                                            <div class="modal-body">
                                                <h6>Categorías</h6>
                                                <div id="materialList" class="mb-3">
                                                    <?php
                                                    $colors = ['red', 'blue', 'green', 'orange', 'purple', 'teal', 'yellow'];
                                                    if (!empty($categorias)) {
                                                        foreach ($categorias as $index => $categoria):
                                                            $colorClass = $colors[$index % count($colors)];
                                                    ?>
                                                            <button type="button" class="btn btn-<?= $colorClass; ?> category-button" onclick="cargarConsumiblesPorCategoria(<?php echo $categoria['id']; ?>)">
                                                                <?php echo htmlspecialchars($categoria['nombre']); ?>
                                                            </button>
                                                    <?php
                                                        endforeach;
                                                    } else {
                                                        echo "<p>No se encontraron categorías.</p>";
                                                    }
                                                    ?>
                                                </div>

                                                <h6>Consumibles</h6>
                                                <div id="listaConsumibles">
                                                    <p>Seleccione una categoría para ver los consumibles.</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" id="btnGuardarSeleccion" onclick="guardarConsumiblesSeleccionados()">Guardar Selección</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
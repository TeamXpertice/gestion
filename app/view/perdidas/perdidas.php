<div class="col-sm-6">
    <h3 class="mb-0">Registrar Nueva Pérdida</h3>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-end">
        <li class="breadcrumb-item"><a href="/gestion/app/controller/DashboardController.php?action=showDashboard">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">
            Registrar Pérdida
        </li>
    </ol>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">

            <!-- Botones de categorías -->
            <div class="col-md-7">
                <h3>Tipos de Material</h3>
                <div id="materialList" class="category-grid">
                    <?php
                    $colors = ['red', 'blue', 'green', 'orange', 'purple', 'teal', 'yellow'];

                    if (!empty($categorias)) {
                        foreach ($categorias as $index => $categoria) {
                            $colorClass = $colors[$index % count($colors)];
                            ?>
                            <button type="button" class="category-button category-<?php echo $colorClass; ?>" onclick="mostrarConsumiblesPorCategoria(<?php echo $categoria['id']; ?>)">
                                <?php echo htmlspecialchars($categoria['nombre']); ?>
                            </button>
                            <?php
                        }
                    } else {
                        echo "<p>No se encontraron categorías.</p>";
                    }
                    ?>
                </div>

                <div id="consumiblesList" class="mt-4"></div>
            </div>

            <!-- Previsualización de Pérdida -->
            <div class="col-md-5">
                <h3>Previsualización de Pérdida</h3>
                <div id="perdidaPreview">
                    <p>No hay productos seleccionados.</p>
                </div>
                <div id="totalPerdida" class="mt-3"></div>

                <form id="perdidaForm" method="post">
                    <input type="hidden" id="productosSeleccionados" name="productosSeleccionados">
                    <div class="form-group">
                        <label for="metodoPermanente">Método de Pérdida:</label>
                        <select class="form-control" id="metodoPermanente" name="metodoPermanente">
                            <option value="Caducidad">Caducidad</option>
                            <option value="Error de Cocina">Error de Cocina</option>
                            <option value="Robo">Robo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger">Registrar Pérdida</button>
                </form>
            </div>

        </div>
    </div>
</div>

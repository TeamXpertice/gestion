<style>
#consumiblesList {
    border-collapse: collapse;
    width: 100%;
    border: 1px solid #dcdcdc;
    font-family: 'Arial', sans-serif;
    font-size: 15px;
    color: #ffffff;
    background-color: #64656a;
    border-radius: 8px;
    overflow: hidden;
}

#consumiblesList thead {
    background: #007bff;
    color: #ffffff;
    text-transform: uppercase;
}

#consumiblesList thead th {
    padding: 2px 0px;
    text-align: center;
    font-weight: bold;
    border-bottom: 1px solid #dee2e6;
}

#consumiblesList tbody td {
    padding: 10px 10px;
    text-align: center;
    border-bottom: 1px solid #f1f1f1;
}

#consumiblesList tbody tr:nth-child(odd) {
    background-color: #f8f9fa;
}
.category-red {
        background-color: #e74c3c;
    }

    .category-blue {
        background-color: #3498db;
    }

    .category-green {
        background-color: #2ecc71;
    }

    .category-orange {
        background-color: #e67e22;
    }

    .category-purple {
        background-color: #9b59b6;
    }

    .category-teal {
        background-color: #1abc9c;
    }

    .category-yellow {
        background-color: #aa8800;
    }

    .disabled {
        pointer-events: none;
        opacity: 0.5;
    }

</style>
<div class="col-sm-6">
    <h5 class="mb-0">Ventas</h5>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-end">
        <li class="breadcrumb-item"><a href="/gestion/app/controller/DashboardController.php?action=showDashboard">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">
            Ventas
        </li>
    </ol>
</div>

<div class="app-content"> 
    <div class="container-fluid"> 
        <div class="row">


    <div class="row">
        <div class="col-md-7">
            <h3>Tipos de Material</h3>
            <div id="materialList">
                <?php
                $colors = ['red', 'blue', 'green', 'orange', 'purple', 'teal', 'yellow'];
                if (!empty($categorias)) {
                    foreach ($categorias as $index => $categoria):
                        $colorClass = $colors[$index % count($colors)];
                ?>
                        <button type="button" class="category-button category-<?php echo $colorClass; ?>" onclick="cargarConsumiblesPorCategoria(<?php echo $categoria['id']; ?>)">
                            <?php echo htmlspecialchars($categoria['nombre']); ?>
                        </button>
                <?php
                    endforeach;
                } else {
                    echo "<p>No se encontraron categorías.</p>";
                }
                ?>
            </div>
            <div id="consumiblesList" class="mt-4">
                
            </div>
        </div>

        <div class="col-md-5">
            <h3>Previsualización de Venta</h3>
            <div id="ventaPreview">
                <p>No hay productos seleccionados.</p>
            </div>
            <div id="totalVenta" class="mt-3"></div>
            <form id="ventaForm" action="/gestion/app/controller/ArsenalVentaController.php?action=crearVentaConsumible" method="post" class="mt-4">
                <input type="hidden" id="productosSeleccionados" name="productosSeleccionados">

                <div class="form-group">
                    <label for="metodo_pago">Método de Pago</label>
                    <select id="metodo_pago" name="metodo_pago" class="form-control">
                        <option value="Efectivo">Efectivo</option>
                        <option value="Visa">Visa</option>
                        <option value="Yape">Yape</option>
                        <option value="Plin">Plin</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Registrar Venta</button>
            </form>
        </div>
    </div>





    </div>
    </div>
</div>

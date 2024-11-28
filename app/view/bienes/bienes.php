<div class="col-sm-6">
    <h5 class="mb-5">Gestión de Bienes</h5>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-end">
        <li class="breadcrumb-item"><a href="/gestion/app/controller/DashboardController.php?action=showDashboard">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ver Bienes</li>
    </ol>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="mb-3">
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCrearBien">
                    Agregar Bien
                </button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalCrearCategoria">
                    Crear Nueva Categoría
                </button>
            </div>

            <div class="mb-0">
                <label>
                    <input type="checkbox" id="toggleColumnFilters" />
                    Mostrar Filtros
                </label>
            </div>

            <div id="columnFilters" class="filters-container" style="display: none;">
            </div>

            <div id="columnFilters" style="display: none;">
            </div>
            <div class="col-12">

                <div class="card-body">
                    <div class="table-responsive mt-8">
                        <table id="tablaBienes" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Proveedor</th>
                                    <th>Modelo</th>
                                    <th>Serie/Código</th>
                                    <th>Marca</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bienes as $bien): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($bien['descripcion_bien']) ?></td>
                                        <td><?= htmlspecialchars($bien['nombre_proveedor']) ?></td>
                                        <td><?= htmlspecialchars($bien['modelo']) ?></td>
                                        <td><?= htmlspecialchars($bien['serie_codigo']) ?></td>
                                        <td><?= htmlspecialchars($bien['marca']) ?></td>
                                        <td><?= htmlspecialchars($bien['estado']) ?></td>


                                        <td>
                                            <button
                                                class="btn btn-warning btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditarBien"
                                                data-id="<?= $bien['id'] ?>"
                                                data-descripcion="<?= htmlspecialchars($bien['descripcion_bien']) ?>"
                                                data-proveedor="<?= htmlspecialchars($bien['nombre_proveedor']) ?>"
                                                data-modelo="<?= htmlspecialchars($bien['modelo']) ?>"
                                                data-serie_codigo="<?= htmlspecialchars($bien['serie_codigo']) ?>"
                                                data-marca="<?= htmlspecialchars($bien['marca']) ?>"
                                                data-estado="<?= htmlspecialchars($bien['estado']) ?>"
                                                data-dimensiones="<?= htmlspecialchars($bien['dimensiones']) ?>"
                                                data-color="<?= htmlspecialchars($bien['color']) ?>"
                                                data-tipo_material="<?= htmlspecialchars($bien['tipo_material']) ?>"
                                                data-estado_fisico_actual="<?= htmlspecialchars($bien['estado_fisico_actual']) ?>"
                                                data-cantidad="<?= $bien['cantidad'] ?>"
                                                data-coste="<?= $bien['coste'] ?>"
                                                data-observacion="<?= htmlspecialchars($bien['observacion']) ?>"
                                                data-categoria_id="<?= $bien['categoria_bien_id'] ?>">
                                                Editar
                                            </button>


                                            <button class="btn btn-danger btn-sm" onclick="eliminarBien(<?= $bien['id'] ?>)">Eliminar</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal de Edición -->
<div class="modal fade" id="modalEditarBien" tabindex="-1" aria-labelledby="modalEditarBienLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarBienLabel">Editar Bien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form id="formEditarBien" action="/gestion/app/controller/BienController.php?action=editarBien" method="POST">
                <div class="modal-body"><!-- Campo oculto para el ID -->
                    <input type="hidden" id="bienId" name="id">

                    <!-- Campo de selección con buscador -->
<div class="form-group">
    <label for="categoria_bien_id">Categoría*</label>
    <select id="categoria_bien_id" name="categoria_bien_id" class="form-control" required>
        <option value="" disabled>Seleccione una categoría</option>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?= htmlspecialchars($categoria['id']) ?>">
                <?= htmlspecialchars($categoria['nombre']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>




                    <!-- Primera fila de campos -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="descripcion_bien">Descripción del Bien*</label>
                            <input type="text" id="descripcion_bien" name="descripcion_bien" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nombre_proveedor">Nombre del Proveedor</label>
                            <input type="text" id="nombre_proveedor" name="nombre_proveedor" class="form-control">
                        </div>
                    </div>

                    <!-- Segunda fila de campos -->
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="modelo">Modelo</label>
                            <input type="text" id="modelo" name="modelo" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="serie_codigo">Serie/Código</label>
                            <input type="text" id="serie_codigo" name="serie_codigo" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="marca">Marca</label>
                            <input type="text" id="marca" name="marca" class="form-control">
                        </div>
                    </div>

                    <!-- Tercera fila de campos -->
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="estado">Estado</label>
                            <input type="text" id="estado" name="estado" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dimensiones">Dimensiones</label>
                            <input type="text" id="dimensiones" name="dimensiones" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="color">Color</label>
                            <input type="text" id="color" name="color" class="form-control">
                        </div>
                    </div>

                    <!-- Cuarta fila de campos -->
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="tipo_material">Tipo de Material</label>
                            <input type="text" id="tipo_material" name="tipo_material" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="estado_fisico_actual">Estado Físico Actual</label>
                            <input type="text" id="estado_fisico_actual" name="estado_fisico_actual" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cantidad">Cantidad*</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" value="0" min="0" required>
                        </div>
                    </div>

                    <!-- Quinta fila de campos -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="coste">Coste por Unidad</label>
                            <input type="number" id="coste" name="coste" class="form-control" step="0.01">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="observacion">Observación</label>
                            <textarea id="observacion" name="observacion" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal para Crear Categoría -->
<div class="modal fade" id="modalCrearCategoria" tabindex="-1" aria-labelledby="modalCrearCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCrearCategoriaLabel">Crear Nueva Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCrearCategoria" action="/gestion/app/controller/CategoriaBienesController.php?action=crearCategoria" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de creación -->
<div class="modal fade" id="modalCrearBien" tabindex="-1" aria-labelledby="modalCrearBienLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCrearBienLabel">Agregar Bien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCrearBien" action="/gestion/app/controller/BienController.php?action=crearBien" method="POST">
                <div class="modal-body">
                    <!-- Selección de Categoría -->
                    <div class="form-group">
                        <label for="categoria_bien_id">Categoría*</label>
                        <select id="categoria_bien_id" name="categoria_bien_id" class="form-control" required>
                            <option value="" disabled selected>Seleccione una categoría</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= htmlspecialchars($categoria['id']) ?>">
                                    <?= htmlspecialchars($categoria['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <!-- Primera fila de campos -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="descripcion_bien">Descripción del Bien*</label>
                            <input type="text" id="descripcion_bien" name="descripcion_bien" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nombre_proveedor">Nombre del Proveedor</label>
                            <input type="text" id="nombre_proveedor" name="nombre_proveedor" class="form-control">
                        </div>
                    </div>

                    <!-- Segunda fila de campos -->
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="modelo">Modelo</label>
                            <input type="text" id="modelo" name="modelo" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="serie_codigo">Serie/Código</label>
                            <input type="text" id="serie_codigo" name="serie_codigo" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="marca">Marca</label>
                            <input type="text" id="marca" name="marca" class="form-control">
                        </div>
                    </div>

                    <!-- Tercera fila de campos -->
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="estado">Estado</label>
                            <input type="text" id="estado" name="estado" class="form-control" >
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dimensiones">Dimensiones</label>
                            <input type="text" id="dimensiones" name="dimensiones" class="form-control" >
                        </div>
                        <div class="form-group col-md-4">
                            <label for="color">Color</label>
                            <input type="text" id="color" name="color" class="form-control" >
                        </div>
                    </div>

                    <!-- Cuarta fila de campos -->
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="tipo_material">Tipo de Material</label>
                            <input type="text" id="tipo_material" name="tipo_material" class="form-control" >
                        </div>
                        <div class="form-group col-md-4">
                            <label for="estado_fisico_actual">Estado Físico Actual</label>
                            <input type="text" id="estado_fisico_actual" name="estado_fisico_actual" class="form-control" >
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cantidad">Cantidad*</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" value="0" min="0" required>
                        </div>
                    </div>

                    <!-- Quinta fila de campos -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="coste">Coste por Unidad</label>
                            <input type="number" id="coste" name="coste" class="form-control" step="0.01">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="observacion">Observación</label>
                            <textarea id="observacion" name="observacion" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
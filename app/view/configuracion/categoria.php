<div class="col-sm-6">
    <h5 class="mb-0">Gestión de Categorías</h5>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-end">
        <li class="breadcrumb-item"><a href="/gestion/app/controller/DashboardController.php?action=showDashboard">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Categorías</li>
    </ol>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Crear Nueva Categoría</h3>
                    </div>
                    <div class="card-body">
                        <form id="formCrearCategoria" action="/gestion/app/controller/CategoriaController.php?action=crearCategoria" method="POST">
                            <div class="form-group">
                                <label for="nombre">Nombre de la Categoría</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Crear Categoría</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Categorías</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categorias as $categoria): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($categoria['nombre']) ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"
                                                data-id="<?= $categoria['id'] ?>"
                                                data-nombre="<?= htmlspecialchars($categoria['nombre']) ?>">Editar</button>
                                            
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-id="<?= $categoria['id'] ?>"
                                                data-nombre="<?= htmlspecialchars($categoria['nombre']) ?>">Eliminar</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Categoría</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formEditCategoria" action="/gestion/app/controller/CategoriaController.php?action=editarCategoria" method="POST">
                            <div class="modal-body">
                                <input type="hidden" id="edit-id" name="id">
                                <div class="form-group">
                                    <label for="edit-nombre">Nombre de la Categoría</label>
                                    <input type="text" class="form-control" id="edit-nombre" name="nombre" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Eliminar Categoría</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formDeleteCategoria" action="/gestion/app/controller/CategoriaController.php?action=eliminarCategoria" method="POST">
                            <div class="modal-body">
                                <p id="deleteMessage"></p>
                                <input type="hidden" id="delete-id" name="id">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-sm-6">
    <h3 class="mb-0">Gestión de Administradores</h3>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-end">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Administradores</li>
    </ol>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Crear Nuevo Administrador</h3>
                    </div>
                    <div class="card-body">
                        <form id="formCrearAdministrador" action="/gestion/app/controller/AdministradorController.php?action=crearAdministrador" method="POST">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nombres">Nombres</label>
                                    <input type="text" class="form-control" id="nombres" name="nombres" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="apellidos">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="correo">Correo</label>
                                    <input type="email" class="form-control" id="correo" name="correo"
                                        pattern="[a-zA-Z0-9._%+-]+@(hotmail|outlook|gmail)\.com"
                                        title="Solo se permiten correos de hotmail, outlook o gmail" required>

                                    <small id="direccionHelp" class="form-text text-muted">Solo hotmail, outlook o gmail</small>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="contrasena">Contraseña</label>
                                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>

                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label for="dni">DNI</label>
                                        <input type="text" class="form-control" id="dni" name="dni" maxlength="8" pattern="\d{8}" title="Debe contener exactamente 8 dígitos" placeholder="88888888" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label for="celular">Celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular" maxlength="9" pattern="\d{9}" title="Debe contener exactamente 9 dígitos" placeholder="999666333" required>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="fecha_nacimiento">Fecha de Nac.</label>
                                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <textarea class="form-control" id="direccion" name="direccion" maxlength="200" rows="1" style="resize: vertical;" required></textarea>
                                <small id="direccionHelp" class="form-text text-muted">Máximo 100 caracteres.</small>
                            </div>

                            <div class="form-group">
                                <label for="ocupacion">Ocupación</label>
                                <input type="text" class="form-control" id="ocupacion" name="ocupacion" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Crear Administrador</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Administradores Habilitados</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Correo</th>
                                    <th>DNI</th>
                                    <th>Celular</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($administradores as $admin): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($admin['nombres']) ?></td>
                                        <td><?= htmlspecialchars($admin['apellidos']) ?></td>
                                        <td><?= htmlspecialchars($admin['correo']) ?></td>
                                        <td><?= htmlspecialchars($admin['dni']) ?></td>
                                        <td><?= htmlspecialchars($admin['celular']) ?></td>
                                        <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"
                                            data-id="<?= isset($admin['id']) ? $admin['id'] : '' ?>"
                                            data-nombres="<?= htmlspecialchars($admin['nombres']) ?>"
                                            data-apellidos="<?= htmlspecialchars($admin['apellidos']) ?>"
                                            data-correo="<?= htmlspecialchars($admin['correo']) ?>"
                                            data-dni="<?= htmlspecialchars($admin['dni']) ?>"
                                            data-celular="<?= htmlspecialchars($admin['celular']) ?>"
                                            data-ocupacion="<?= htmlspecialchars($admin['ocupacion']) ?>"
                                            data-direccion="<?= htmlspecialchars($admin['direccion']) ?>">Editar</button>
                                            <button class="btn btn-danger btn-sm" 
                                                data-id="<?= isset($admin['id']) ? $admin['id'] : '' ?>" 
                                                onclick="deshabilitarAdministrador(this)"
                                                <?= (isset($_SESSION['id']) && $_SESSION['id'] == $admin['id']) ? 'disabled' : '' ?>>
                                            Deshabilitar
                                        </button>

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

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Administrador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarAdministrador" action="/gestion/app/controller/AdministradorController.php?action=editarAdministrador" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="edit-nombres">Nombres</label>
                            <input type="text" class="form-control" id="edit-nombres" name="nombres" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="edit-apellidos">Apellidos</label>
                            <input type="text" class="form-control" id="edit-apellidos" name="apellidos" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit-correo">Correo</label>
                        <input type="email" class="form-control" id="edit-correo" name="correo" required>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="edit-dni">DNI</label>
                            <input type="text" class="form-control" id="edit-dni" name="dni" maxlength="8" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="edit-celular">Celular</label>
                            <input type="text" class="form-control" id="edit-celular" name="celular" maxlength="9" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit-direccion">Dirección</label>
                        <textarea class="form-control" id="edit-direccion" name="direccion" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-ocupacion">Ocupación</label>
                        <input type="text" class="form-control" id="edit-ocupacion" name="ocupacion" required>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="edit-password-old">Contraseña Actual</label>
                            <input type="password" class="form-control" id="edit-password-old" name="password_old">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="edit-password-new">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="edit-password-new" name="password_new">
                            <small class="form-text text-muted">Déjelo en blanco si no desea cambiar la contraseña.</small>
                        </div>
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
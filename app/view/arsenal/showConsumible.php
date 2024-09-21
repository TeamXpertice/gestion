<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsenal</title>
    <link href="/gestion/public/css/stackpathbootstrap4.5.2.css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
</head>

<body>
    <div class="container mt-1">
        <h2>Consumibles</h2>
        <a href="/gestion/app/controller/ArsenalController.php?action=createConsumible" class="btn btn-primary mb-3">Agregar Consumible</a>
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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consumibles as $consumible): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($consumible['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($consumible['descripcion_consumible']); ?></td>
                        <td><?php echo htmlspecialchars($consumible['fecha_vencimiento']); ?></td>
                        <td><?php echo htmlspecialchars($consumible['precio']); ?></td>
                        <td>
                            <a href="/gestion/app/controller/ArsenalController.php?action=editConsumible&id=<?php echo $consumible['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="/gestion/app/controller/ArsenalController.php?action=deleteConsumible&id=<?php echo $consumible['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este consumible?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar categorías -->
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
                    <table class="table table-bordered table-categorias"> <!-- Aquí agregamos la clase table-categorias -->
                        <thead>
                            <tr>
                                <th>Todas las categorias</th>
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

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gestion/app/view/templates/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function() {
            $('.table:not(.table-categorias)').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        text: 'Excel',
                        title: 'Bienes_Registrados'
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Bienes_Registrados',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        title: 'Bienes Registrados',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            });

            $('#addCategoriaBtn').on('click', function() {
                const nuevaCategoria = $('#nuevaCategoria').val();

                if (nuevaCategoria) {
                    fetch('/gestion/app/controller/ArsenalController.php?action=addCategoria', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `nombre=${encodeURIComponent(nuevaCategoria)}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                $('#categoriaModal').modal('hide');
                                $('body').removeClass('modal-open');
                                $('.modal-backdrop').remove();

                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Categoría agregada!',
                                    text: 'La categoría se ha agregado exitosamente.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                $('#nuevaCategoria').val('');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Hubo un problema al agregar la categoría.'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un problema con la solicitud.'
                            });
                        });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campo vacío',
                        text: 'Por favor, ingresa el nombre de la categoría.'
                    });
                }
            });
        });
    </script>
</body>

</html>
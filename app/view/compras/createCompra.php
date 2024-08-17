<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras Registradas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
</head>
<body>
    <div class="container mt-5">

        <div class="table-responsive">

        <h1>Compras Dasboard</h1>
        <p>Usuario: <strong><?php echo htmlspecialchars($_SESSION['nombres'] ?? 'Invitado'); ?></strong></p>
        <h6>Registrar nueva Compras</h6>

        <div class="mb-4">
            <button class="btn btn-primary" data-toggle="modal" data-target="#createCompraModal">Registrar Nueva Compra</button>
        </div>
        
        </div>
    </div>

    <div class="modal fade" id="createCompraModal" tabindex="-1" aria-labelledby="createCompraModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCompraModalLabel">Registrar Nueva Compra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container mt-5">
        <h1 class="mb-4">Realizar Compra</h1>
        <form action="/gestion/app/controller/ComprasController.php?action=createCompra" method="post">
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" required>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>
            <div class="form-group">
                <label for="costo_unitario">Costo Unitario</label>
                <input type="text" class="form-control" id="costo_unitario" name="costo_unitario" required>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha de Compra</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="proveedor">Proveedor</label>
                <input type="text" class="form-control" id="proveedor" name="proveedor">
            </div>
            <div class="form-group">
                <label for="metodo_pago">Método de Pago:</label>
                <select id="metodo_pago" name="metodo_pago" class="form-control">
                    <option value="Efectivo">Efectivo</option>
                    <option value="Visa">Visa</option>
                    <option value="Yape">Yape</option>
                    <option value="Plin">Plin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="observacion">Observación</label>
                <textarea class="form-control" id="observacion" name="observacion"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Compra</button>
        </form>
    </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#comprasTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Excel',
                        title: 'Compras_Registradas'
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Compras_Registradas'
                    },
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        title: 'Compras Registradas'
                    }
                ]
            });
        });
    </script>
</body>
</html>

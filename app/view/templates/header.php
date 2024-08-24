<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
    <!-- data table -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
</head>
<style>
    .sidebar {
        height: 100vh;
        position: fixed;
        width: 250px;
        background-color: #343a40;
        color: white;
        padding: 20px;
    }

    .sidebar .nav-item a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 10px 0;
    }

    .sidebar .nav-item a:hover {
        background-color: #495057;
        border-radius: 5px;
    }

    .user-info {
        margin-top: auto;
    }

    .content {
        margin-left: 250px;
        padding: 20px;
    }

    .dropdown .dropdown-menu {
        background: #333;
        color: #ffffff;
    }
</style>

<body>
    <div class="d-flex">
        <div class="sidebar d-flex flex-column">
            <div class="text-center mb-4">
                <img src="/gestion/public/img/logo.png" alt="Icono" class="img-fluid mb-3" style="width: 100px;">
                <h4>Bienvenido</h4>
                <p>Usuario: <strong><?php echo htmlspecialchars($_SESSION['nombres'] ?? 'Invitado'); ?></strong></p>
            </div>
            <nav class="nav flex-column">
                <div class="nav-item">
                    <a href="/gestion/app/controller/dashboardController.php?action=showDashboard">Dashboard</a>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="arsenalDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Arsenal</a>
                    <div class="dropdown-menu" aria-labelledby="arsenalDropdown">
                        <a class="dropdown-item" href="/gestion/app/controller/ArsenalController.php?action=showVentaConsumible">Vender</a>
                        <a class="dropdown-ietem" href="/gestion/app/controller/ArsenalController.php?action=showVentasRegistradas">Ver Registro del dia</a>
                        <a class="dropdown-item" href="/gestion/app/controller/ArsenalController.php?action=showConsumible">Productos</a>
                        <a class="dropdown-item" href="/gestion/app/controller/ArsenalController.php?action=showBien">Bienes</a>

                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="comprasDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Compras</a>
                    <div class="dropdown-menu" aria-labelledby="comprasDropdown">
                    <a class="dropdown-item" href="/gestion/app/controller/ComprasController.php?action=showCompras">Registrar Nueva Compra</a>

                        <a class="dropdown-item" href="/gestion/app/controller/ComprasController.php?action=showRegistroCompras">Registro de Compras</a>
                    </div>
                </div>
            </nav>
            <div class="user-info mt-auto text-center">
                <a href="/gestion/app/controller/logoutController.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>
        <div class="content flex-grow-1">
        </div>
    </div>

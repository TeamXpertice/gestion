<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistema' ?></title>
    <link href="/gestion/public/css/stackpathbootstrap4.5.2.css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/datatables1.10.21/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/gestion/public/css/datatablesbuttons1.6.2/buttons.dataTables.min.css">
    <!-- Estilos adicionales -->
    <?php if (!empty($additionalCss)) : ?>
        <?php foreach ($additionalCss as $cssFile) : ?>
            <link rel="stylesheet" href="<?= $cssFile ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<style>
    .sidebar {
        height: 100vh;
        background-color: #343a40;
        color: white;
    }

    .sidebar .nav-item a {
        color: white;
        text-decoration: none;
    }

    .sidebar .nav-item a:hover {
        background-color: #495057;
        border-radius: 5px;
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
                <p>Usuario: <strong><?= htmlspecialchars($_SESSION['nombres'] ?? 'Invitado') ?></strong></p>
            </div>
            <nav class="nav flex-column">
                <div class="nav-item">
                    <a href="/gestion/app/controller/dashboardController.php?action=showDashboard">Dashboard</a>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="arsenalDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Arsenal</a>
                    <div class="dropdown-menu" aria-labelledby="arsenalDropdown">
                        <a class="dropdown-item" href="/gestion/app/controller/ArsenalController.php?action=showVentaConsumible">Vender</a>
                        <a class="dropdown-item" href="/gestion/app/controller/ArsenalController.php?action=showVentasRegistradas">Ver Registro del día</a>
                        <a class="dropdown-item" href="/gestion/app/controller/ArsenalController.php?action=showConsumible">Productos</a>
                        <!-- <a class="dropdown-item" href="/gestion/app/controller/ArsenalController.php?action=showBien">Bienes</a> -->
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="comprasDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Compras</a>
                    <div class="dropdown-menu" aria-labelledby="comprasDropdown">
                        <a class="dropdown-item" href="/gestion/app/controller/ComprasController.php?action=showCompras">Nueva Compra</a>
                        <a class="dropdown-item" href="/gestion/app/controller/ComprasController.php?action=showRegistroCompras">Registro de Compras</a>
                    </div>
                </div>
            </nav>

            <div class="user-info mt-auto text-center">
                <a href="/gestion/app/controller/logoutController.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="content flex-grow-1">
            <?php include $viewPath; ?>
        </div>
    </div>


<!-- Scripts globales -->
<script src="/gestion/public/js/code.jquery3.6.0/jquery-3.6.0.min.js"></script>
<script src="/gestion/public/js/popper1.16.0/popper.min.js"></script> 
<script src="/gestion/public/js/stackpath.bootstrap4.5.2/bootstrap.min.js"></script>
<!-- Scripts data table -->
<script src="/gestion/public/js/datatables1.10.21/jquery.dataTables.min.js"></script>
<script src="/gestion/public/js/datatablesbuttons1.6.2/dataTables.buttons.min.js"></script>
<script src="/gestion/public/js/datatablesbuttonsflash1.6.2/buttons.flash.min.js"></script>
<script src="/gestion/public/js/cloudflare3.1.3/jszip.min.js"></script>
<script src="/gestion/public/js/datatablesbuttonshtml51.6.2/buttons.html5.min.js"></script>
<script src="/gestion/public/js/datatablesbuttonsprint1.6.2/buttons.print.min.js"></script>
<!-- Scripts sweetalert-->
<script src="/gestion/public/js/sweetalert2@10/sweetalert2@10.js"></script>
<!-- Scripts adicionales -->
<?php if (!empty($additionalJs)) : ?>
    <?php foreach ($additionalJs as $jsFile) : ?>
        <script src="<?= $jsFile ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>

</html>

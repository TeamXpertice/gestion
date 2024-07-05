<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion/public/css/style.css">
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
            margin-left: 250px; /* Esto asegura que el contenido no esté debajo de la barra lateral */
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar d-flex flex-column">
            <div class="text-center mb-4">
                <img src="/gestion/public/img/logo.png" alt="Icono" class="img-fluid mb-3" style="width: 100px;">
                <h4>Bienvenido</h4>
                <p>Usuario: <strong><?php echo isset($username) ? htmlspecialchars($username) : 'Invitado'; ?></strong></p>
            </div>
            <nav class="nav flex-column">
                <div class="nav-item">
                    <a href="/gestion/app/controller/dashboardController.php?action=showDashboard">Dashboard</a>
                </div>
                <div class="nav-item">
                    <a href="/gestion/app/controller/ArsenalController.php?action=showArsenal">Arsenal</a>
                </div>
                <!-- Agrega más enlaces aquí según sea necesario -->
            </nav>
            <div class="user-info mt-auto text-center">
                <a href="/gestion/app/controller/logoutController.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>
        <div class="content flex-grow-1">

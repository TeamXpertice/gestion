<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/gestion/public/css/style.css">
</head>
<body>
<div class="container mt-5">
    <h1>Arsenal</h1>
    <p>Usuario: <strong><?php echo htmlspecialchars($_SESSION['nombres'] ?? 'Invitado'); ?></strong></p>

</div>
</body>
</html>

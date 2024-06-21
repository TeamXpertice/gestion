<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go o no go</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td>Usuario</td>
                <td>Contraseña</td>
                <td>Nombre</td>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($usuarios as $user){
                    echo "<tr>";
                        echo "<td>".$user['id'] ."</td>";
                        echo "<td>".$user['contraseña'] ."</td>";
                        echo "<td>".$user['nombre'] ."</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>
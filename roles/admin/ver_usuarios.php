<?php

include ('header.php');


$sql = $con->prepare("SELECT * FROM usuario");
$sql->execute();
$fila = $sql->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Usuarios</title>
    <style>

    </style>
</head>
<body>

     <!-- Contenido principal -->
     <div class="main-content">
        <h2>Usuarios Registrados</h2>
        <?php if (!empty($fila)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fila as $usuario): ?>
                        <tr>
                            <td><?php echo $usuario['username']; ?></td>
                            <td><?php echo $usuario['correo']; ?></td>
                            <td><?php echo $usuario['Id_Estado']; ?></td>
                            <td><?php echo $usuario['Id_rol']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay usuarios registrados.</p>
        <?php endif; ?>
    </div>

</body>
</html>
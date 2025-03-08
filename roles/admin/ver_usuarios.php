<?php

include ('header.php');


$sql = $con->prepare("SELECT * FROM usuario");
$sql->execute();
$fila = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql1 = $con->prepare("SELECT * FROM estado WHERE Id_Estado < 3;");
$sql1->execute();
$fila1 = $sql1->fetchAll(PDO::FETCH_ASSOC);

$sql2 = $con->prepare("SELECT * FROM rol");
$sql2->execute();
$fila2 = $sql2->fetchAll(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Usuarios</title>
    <style>
        .botonGuardar {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .botonGuardar:hover {
            background-color: #0056b3;
        }

        .borrar{
            padding: 10px;
            background-color:rgb(226, 46, 46);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .borrar:hover{
            background-color: rgb(142, 11, 11);
        }

    </style>
</head>
<body>
<div class="main-content">
    <h2>Usuarios Registrados</h2>
    <?php if (!empty($fila)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                    <th>Eliminar</th> <!-- Nueva columna -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fila as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['username']; ?></td>
                        <td><?php echo $usuario['correo']; ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="correo" value="<?php echo $usuario['correo']; ?>">
                                <select name="estado">
                                    <?php foreach ($fila1 as $estado): ?>
                                        <option value="<?php echo $estado['Id_estado']; ?>"
                                            <?php echo ($estado['Id_estado'] == $usuario['Id_Estado']) ? 'selected' : ''; ?>>
                                            <?php echo $estado['Nom_estado']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                        </td>
                        <td>
                            <select name="rol">
                                <?php foreach ($fila2 as $rol): ?>
                                    <option value="<?php echo $rol['Id_rol']; ?>"
                                        <?php echo ($rol['Id_rol'] == $usuario['Id_rol']) ? 'selected' : ''; ?>>
                                        <?php echo $rol['Nom_rol']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <button type="submit" name="guardar" class="botonGuardar">Guardar</button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                <input type="hidden" name="correo" value="<?php echo $usuario['correo']; ?>">
                                <button type="submit" name="eliminar" class="borrar">Borrar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay usuarios registrados.</p>
    <?php endif; ?>
</div>

    <?php
    // ESCUCHAMOS EL BOTON ACTUALIZAR PARA REGISTRAR LOS CAMBIOS HECHOS EN EL FORMULARIO
if (isset($_POST['guardar'])){
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];
    $estado = $_POST['estado'];

    $update = $con -> prepare("UPDATE usuario SET Id_rol = '$rol', Id_Estado = '$estado' WHERE correo = '$correo'");
    $update -> execute();
    echo '<script>alert ("Se actualizaron los cambios correctamente!")</script>';
    echo '<script>window.location = "index.php" </script>';
}


?>


<?php
// ESCUCHAMOS EL BOTON ACTUALIZAR PARA REGISTRAR LOS CAMBIOS HECHOS EN EL FORMULARIO
if (isset($_POST['eliminar'])){
    $correo = $_POST['correo'];
    $delete = $con -> prepare("DELETE FROM usuario WHERE correo = '$correo'");
    $delete -> execute();
    echo '<script>alert ("Se elimino el usuario correctamente")</script>';
    echo '<script>window.location = "index.php" </script>';
}
?>


</div>
</body>
</html>
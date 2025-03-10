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

require '../../PHPMailer-master/src/Exception.php';
require '../../PHPMailer-master/src/PHPMailer.php';
require '../../PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

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

        @media (max-width: 768px) {
    table, thead, tbody, th, td, tr {
        display: block; /* Convertir la tabla en bloques */
    }

    thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px; /* Ocultar el header en móviles */
    }

    tr {
        margin-bottom: 15px;
        border: 1px solid #ddd;
    }

    td {
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%; /* Espacio para el data-label */
    }

    td:before {
        position: absolute;
        left: 10px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        content: attr(data-label); /* Mostrar el nombre de la columna */
        font-weight: bold;
    }

    .botonGuardar, .borrar {
        width: 100%;
        margin-top: 5px;
    }
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

    $sql_check = $con->prepare("SELECT Id_Estado FROM usuario WHERE correo = '$correo'");
    $sql_check->execute();
    $estado_anterior = $sql_check->fetchColumn();

    $update = $con -> prepare("UPDATE usuario SET Id_rol = '$rol', Id_Estado = '$estado' WHERE correo = '$correo'");
    $update -> execute();

    if ($estado == 1 && $estado_anterior != 1) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;    
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'warflexcodess@gmail.com';                     //SMTP username
            $mail->Password   = 'anvljetmpssuczkw';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
            $mail->Port       = 587;                                       //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        
            //Recipients
            $mail->setFrom('warflexcodess@gmail.com', 'WARFLEX');
            $mail->addAddress($correo);     //Add a recipient
        
        
            //Content
        
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Cuenta activa XARFLEX";
            $mail->Body    = "
            <p>Buen dia,</p>
            <p>Por medio de este correo te informamos que tu cuenta en WARFLEX ha sido activada nuevamente</p>
            <p><a href='http://localhost/WARFLEX2/index.php'>¡Juega ahora!</a></p>";
            
        
            $mail->send();
            exit();
        } catch (Exception $e) {
                error_log("Error al enviar el correo: " . $mail->ErrorInfo);
        }
    }

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
<?php

require_once('database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();



if(isset($_POST['submit'])){

    $username = $_POST['user'];
    $contra = $_POST['contra'];
    $correo = $_POST['correo'];
    $vida = 100;
    $puntos = 0;
    $avatar = 1;
    $rol = 1;
    $estado = 1;
    $contra_en = password_hash($contra, PASSWORD_DEFAULT);

    $sql = $con->prepare("SELECT * FROM usuario where username = '$username' or correo = '$correo'");
    $sql->execute();
    $fila = $sql->fetch(PDO::FETCH_ASSOC);

    if ($fila){

        echo"<script>alert('Ya se encuentra registrado un usuario con estas credenciales')</script>";
        echo "<script>window.location='index.php'</script>";
        exit();
    } 

    $insert = $con->prepare("INSERT INTO usuario (username, correo, Contraseña, vida, puntos, Id_avatar, Id_estado, Id_rol) values ('$username', '$correo', '$contra_en', '$vida', '$puntos','$avatar', '$estado', '$rol')");
    $insert->execute();
    
    header("location: index.php");
     exit(); 
}
?>

<!-- CUERPO HTML PARA EL REGISTRARSE -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Register!</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="login">
        <h1>REGISTRATE</h1>
        <form action="" method="POST" autocomplete="off" >
            <label for="user">Correo Electronico</label>
            <input type="email" id="correo" name="correo">
            <label for="user">Username</label>
            <input type="text" id="user" name="user">
            <label for="contra">Contraseña</label>
            <input type="password" id="contra" name="contra">
            <input type="submit" id="submit" name="submit" class="btn-submit" value="Registrarse">
            <p>¿Ya tienes cuenta? <a class="p_a_login" href="index.php">Iniciar Sesion</a></p>
        </form>
    </div>
    <video autoplay loop muted>
        <source src="video/video1.mp4" type="video/mp4">
    </video>
    <div class="capa"></div>
</body>
</html>
<!-- FIN CUERPO HTML PARA EL REGISTRARSE -->
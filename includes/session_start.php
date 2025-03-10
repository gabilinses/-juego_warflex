<?php

require_once(__DIR__.'/../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();



if (isset($_POST['submit'])) {

    $username = $_POST['user'];
    $passdes = htmlentities(addslashes($_POST['contra']));
    $sql = $con->prepare("SELECT * FROM usuario WHERE username = :username");
    $sql->bindParam(':username', $username, PDO::PARAM_STR); // Usar parámetros para evitar SQL injection
    $sql->execute();
    $fila = $sql->fetch(PDO::FETCH_ASSOC);

    if ($fila && password_verify($passdes, $fila['Contraseña'])) {
        // Guardar datos en la sesión
        $_SESSION['username'] = $fila['username'];
        $_SESSION['rol'] = $fila['Id_rol'];
        $_SESSION['Id_Estado'] = $fila['Id_Estado'];

        // Verificar si el usuario tiene Rol 1 y Estado 2
        if ($_SESSION['rol'] == 1 && $_SESSION['Id_Estado'] == 2) {
            echo "<script>alert('Tu cuenta está pendiente de activación por el administrador. Por favor, revisa tu correo.')</script>";
            echo "<script>window.location='../index.php'</script>";
            exit();
        }

        // Redireccionar según el rol
        if ($_SESSION['rol'] == 1) {
            header("location: ../roles/usuario/index.php");
            exit();
        } elseif ($_SESSION['rol'] == 2) {
            header("location: ../roles/admin/index.php");
            exit();
        }

    } else {
        echo "<script>alert('Credenciales incorrectas. Intenta de nuevo.')</script>";
        echo "<script>window.location='../index.php'</script>";
        exit();
    }
}
<?php

require_once('../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();



if (isset($_POST['submit'])){

    $username = $_POST['user'];
    $passdes = htmlentities(addslashes($_POST['contra']));
    $sql = $con->prepare("SELECT * FROM usuario where username = '$username'");
    $sql->execute();
    $fila = $sql->fetch(PDO::FETCH_ASSOC);

    if ($fila && password_verify($passdes, $fila['Contraseña'])) {
        $_SESSION['username'] = $fila['username'];
        $_SESSION['rol'] = $fila['Id_rol'];
        
        if($_SESSION['rol'] == 1){

            header("location: ../roles/usuario/index.php");
            exit(); 

        }elseif($_SESSION['rol'] == 2){
            
            header("location: ../roles/admin/index.php");
            exit();
        }

    } else {
        echo "<script>alert('Credenciales incorrectas. Intenta de nuevo.')</script>";
        echo "<script>window.location='../index.php'</script>";
        exit();
    }
    

}

?>
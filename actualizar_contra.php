<?php

require_once('database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();

// if (!isset($_SESSION['correo'])) {
//     echo "Inicio de sesion invalida";
//     exit();
// }

// $correo = $_SESSION['correo'];

// $sql = $con->prepare("UPDATE usuario SET Contraseña = $? WHERE correo = $correo");
// $sql->execute();

header("Location: includes/exit.php")


?>
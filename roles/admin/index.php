<?php


require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
include '../../includes/session_start.php';



if (!isset($_SESSION['username'])) {
    echo "Inicio de sesion invalida";
    exit();
}
$username = $_SESSION['username'];


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../../css/index_adm.css">
    
</head>
<body>
<?php include ('ver_usuarios.php'); ?>



</body>
</html>
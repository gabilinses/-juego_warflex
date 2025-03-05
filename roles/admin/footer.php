<?php

require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();


if (!isset($_SESSION['username'])) {
    echo "Inicio de sesion invalida";
    exit();
}

$username = $_SESSION['username'];


$sql = $con->prepare("SELECT u.username, u.puntos, n.nom_nivel, a.foto AS afoto, a.Nom_avatar, m.Nom_mundo, m.Foto AS mfoto FROM usuario u INNER JOIN niveles n ON u.puntos >= n.Puntos 
INNER JOIN avatar a ON u.Id_avatar = a.Id_avatar
INNER JOIN mundo m ON n.Id_nivel = m.nivel WHERE u.username = '$username' ORDER BY n.Puntos DESC");
$sql->execute();
$fila = $sql->fetch(PDO::FETCH_ASSOC);

$puntos = $fila['puntos'];
$nivel = $fila['nom_nivel'];
$avatar = "../../img/avatares/".$fila['afoto'];
$nom_avatar = $fila['Nom_avatar'];
$nom_mundo = $fila['Nom_mundo'];
$mundo = "../../img/mundos/".$fila['mfoto'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/index_adm.css">
</head>
<body>
        <!-- Pie de página -->
        <div class="footer">
        <p>&copy; 2023 Panel de Administración. Todos los derechos reservados.</p>
    </div>
</body>
</html>
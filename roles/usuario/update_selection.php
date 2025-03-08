<?php
header('Content-Type: application/json');
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();

if (!isset($_SESSION['username'])) {
    echo "Inicio de sesion invalida";
    exit();
} 



$sql = $con->prepare("SELECT u.username, u.puntos, n.nom_nivel, a.foto AS afoto, a.Nom_avatar, m.Nom_mundo, m.Foto AS mfoto FROM usuario u 
INNER JOIN niveles n ON u.puntos >= n.Puntos 
INNER JOIN avatar a ON u.Id_avatar = a.Id_avatar
INNER JOIN mundo m ON n.Id_nivel = m.nivel WHERE u.username = ? ORDER BY n.Puntos DESC");
$sql->execute([$username]);
$fila = $sql->fetch(PDO::FETCH_ASSOC);

$puntos = $fila['puntos'];
$nivel = $fila['nom_nivel'];
$avatar = "../../img/avatares/".$fila['afoto'];
$nom_avatar = $fila['Nom_avatar'];
$nom_mundo = $fila['Nom_mundo'];
$mundo = "../../img/mundos/".$fila['mfoto'];

$data = json_decode(file_get_contents('php://input'), true);

$avatarId = $data['avatarId'];
$mundoId = $data['mundoId'];
$username = $_SESSION['username'];

// Asume que tienes una tabla llamada `usuarios` y una columna `id` para identificar al usuario

$sql = "UPDATE usuarios SET Id_avatar = $avatarId, WHERE username = $username";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $avatarId, $username);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

?>
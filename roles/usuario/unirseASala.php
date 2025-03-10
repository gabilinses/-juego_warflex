<?php
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();

if (!isset($_POST['id_sala']) || !isset($_SESSION['username'])) {
    echo json_encode(["success" => false, "message" => "Error en los datos"]);
    exit;
}

$id_sala = $_POST['id_sala'];
$username = $_SESSION['username'];

// Verificar si el usuario ya está en la sala
$sqlCheckUser = $con->prepare("SELECT COUNT(*) FROM detalle_sala WHERE id_sala = ? AND username = ?");
$sqlCheckUser->execute([$id_sala, $username]);
if ($sqlCheckUser->fetchColumn() > 0) {
    echo json_encode(["success" => false, "message" => "Ya estás en esta sala"]);
    exit;
}

// Limpiar registros nulos o duplicados
$sqlCleanup = $con->prepare("DELETE FROM detalle_sala WHERE username IS NULL OR username = ''");
$sqlCleanup->execute();

$sqlCount = $con->prepare("SELECT COUNT(DISTINCT username) as total FROM detalle_sala WHERE id_sala = ? AND username IS NOT NULL");
$sqlCount->execute([$id_sala]);
$count = $sqlCount->fetch(PDO::FETCH_ASSOC)['total'];

if ($count < 5) {
    $sqlJoinSala = $con->prepare("INSERT INTO detalle_sala (id_sala, username) VALUES (?, ?)");
    $sqlJoinSala->execute([$id_sala, $username]);

    $redirect = "sala_espera.php?id_sala=" . $id_sala;
    echo json_encode(["success" => true, "redirect" => $redirect]);
} else {
    echo json_encode(["success" => false, "message" => "Sala llena"]);
}
?>

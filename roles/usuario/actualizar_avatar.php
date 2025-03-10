<?php
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();

if (!isset($_SESSION['username']) || !isset($_POST['id_avatar'])) {
    echo json_encode(['success' => false]);
    exit();
}

$username = $_SESSION['username'];
$id_avatar = $_POST['id_avatar'];

try {
    $sql = $con->prepare("UPDATE usuario SET Id_avatar = ? WHERE username = ?");
    $sql->execute([$id_avatar, $username]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>

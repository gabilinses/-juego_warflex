<?php
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();

if (!isset($_SESSION['username']) || !isset($_POST['id_mundo'])) {
    echo json_encode(['success' => false]);
    exit();
}

$username = $_SESSION['username'];
$id_mundo = $_POST['id_mundo'];


try {
    $_SESSION['Id_mundo'] = $id_mundo;
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

?>
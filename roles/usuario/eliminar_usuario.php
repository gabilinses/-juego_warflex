<?php
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();

if (!isset($_GET['id_sala']) || !isset($_SESSION['username'])) {
    exit;
}

$id_sala = $_GET['id_sala'];
$username = $_SESSION['username'];

// Eliminar usuario de la sala
$sqlEliminar = $con->prepare("DELETE FROM detalle_sala WHERE id_sala = ? AND username = ?");
$sqlEliminar->execute([$id_sala, $username]);
?>

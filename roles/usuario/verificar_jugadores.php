<?php
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();

$id_sala = $_GET['id_sala'];

// Obtener lista de jugadores
$sqlJugadores = $con->prepare("SELECT username FROM detalle_sala WHERE id_sala = ?");
$sqlJugadores->execute([$id_sala]);
$jugadores = $sqlJugadores->fetchAll(PDO::FETCH_COLUMN); // Devuelve solo los nombres

// Contar jugadores y verificar si el contador ya inició
$sql = $con->prepare("SELECT COUNT(*) as total, 
    (SELECT inicio_contador FROM sala WHERE id_sala = ?) as inicio_contador, 
    (SELECT Id_estado FROM sala WHERE id_sala = ?) as estado 
    FROM detalle_sala WHERE id_sala = ?");
$sql->execute([$id_sala, $id_sala, $id_sala]);
$result = $sql->fetch(PDO::FETCH_ASSOC);

$totalJugadores = $result['total'];
$inicioContador = $result['inicio_contador'];
$estado = $result['estado'];

if ($totalJugadores >= 2) {
    if (!$inicioContador) {
        $inicioContador = date("Y-m-d H:i:s");
        $sqlUpdate = $con->prepare("UPDATE sala SET inicio_contador = ? WHERE id_sala = ?");
        $sqlUpdate->execute([$inicioContador, $id_sala]);
    }
    $segundosTranscurridos = time() - strtotime($inicioContador);
    $segundosRestantes = max(20 - $segundosTranscurridos, 0);

    $redirigir = ($segundosRestantes == 0); // Redirigir si el tiempo se acabó

} else {
    $segundosRestantes = null;
    $redirigir = false;
}

// Enviar respuesta JSON
echo json_encode([
    "jugadores" => $jugadores,
    "total" => $totalJugadores,
    "segundos_restantes" => $segundosRestantes,
    "redirigir" => $redirigir
]);
?>

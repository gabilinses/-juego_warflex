<?php

require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();

header('Content-Type: application/json');

try {
    if (!isset($_SESSION['Id_mundo'])) {
        throw new Exception("El valor de 'mundo' no está definido en la sesión.");
    }
    elseif (!isset($_SESSION['username'])) {
        throw new Exception("El valor de 'username' no está definido en la sesión.");
    }

    $mundo = $_SESSION['Id_mundo'];
    $username = $_SESSION['username'];

    // 1. Verificar y terminar salas que han estado activas por más de 5 minutos
    $sql_terminar_salas = $con->prepare("UPDATE sala SET id_estado = 2 WHERE Id_mundo = $mundo AND id_estado = 1 AND fecha_ini < NOW() - INTERVAL 5 MINUTE");
    $sql_terminar_salas->execute();

    // 2. Crear nuevas salas si no hay suficientes
    $sql_contar_salas = $con->prepare("SELECT COUNT(*) FROM sala WHERE Id_mundo = $mundo AND id_estado = 1");
    $sql_contar_salas->execute();
    $num_salas = $sql_contar_salas->fetchColumn();

    if ($num_salas < 2) {
        // Crear una nueva sala
        $sql_crear_sala = $con->prepare("INSERT INTO sala (username, fecha_ini, Id_mundo, id_estado) VALUES ($username, NOW(), $mundo, 1)");
        $sql_crear_sala->execute();
    }

    // 3. Obtener las dos salas activas con el número de jugadores
    $sql_salas = $con->prepare("SELECT s.Id_sala, s.username, COUNT(d.username) AS num_jugadores FROM sala s LEFT JOIN detalle_sala d ON s.Id_sala = d.id_sala WHERE s.Id_mundo = $mundo AND s.id_estado = 1 GROUP BY s.Id_salaORDER BY s.fecha_ini LIMIT 2
    ");
    $sql_salas->bindParam(':mundo', $mundo, PDO::PARAM_INT);
    $sql_salas->execute();
    $salas = $sql_salas->fetchAll(PDO::FETCH_ASSOC);

    // Devolver las salas en formato JSON
    echo json_encode(["success" => true, "salas" => $salas]);
} catch (Exception $e) {
    // En caso de error, devolver un mensaje de error en JSON
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
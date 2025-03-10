<?php
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();
header('Content-Type: application/json');

try {
    $id_sala = $_GET['id_sala'];
    
    // Verificar tiempo de batalla
    $sql_tiempo = $con->prepare("
        SELECT TIMESTAMPDIFF(SECOND, fecha_ini, NOW()) >= 300 as tiempo_acabado
        FROM estadistica 
        WHERE id_sala = ? 
        LIMIT 1
    ");
    $sql_tiempo->execute([$id_sala]);
    $tiempo_acabado = $sql_tiempo->fetchColumn();

    // Verificar jugadores vivos
    $sql_jugadores = $con->prepare("
        SELECT COUNT(*) 
        FROM detalle_sala 
        WHERE id_sala = ?
    ");
    $sql_jugadores->execute([$id_sala]);
    $jugadores_restantes = $sql_jugadores->fetchColumn();

    // Verificar si hubo ataques
    $sql_ataques = $con->prepare("
    SELECT COUNT(*) 
    FROM estadistica 
    WHERE id_sala = ? AND usu_victima IS NOT NULL
    ");
    $sql_ataques->execute([$id_sala]);
    $hay_ataques = $sql_ataques->fetchColumn() > 0;

    $batalla_terminada = $tiempo_acabado || ($jugadores_restantes <= 1 && $hay_ataques);

   if ($batalla_terminada) {
    // Actualizar estado de la sala
        $sql_update_estado = $con->prepare("UPDATE sala SET Id_estado = 6 WHERE Id_sala = ?");
        $sql_update_estado->execute([$id_sala]);

        // Determinar ganador por mayor daño solo si hubo ataques
        $sql_ganador = $con->prepare("
            SELECT username 
            FROM estadistica 
            WHERE id_sala = ? AND usu_victima IS NOT NULL
            GROUP BY username 
            ORDER BY SUM(daño) DESC 
            LIMIT 1
        ");
        $sql_ganador->execute([$id_sala]);
        $ganador = $sql_ganador->fetchColumn();

        echo json_encode([
            "batalla_terminada" => true,
            "ganador" => $ganador,
            "por_tiempo" => $tiempo_acabado,
            "por_eliminacion" => ($jugadores_restantes <= 1 && $hay_ataques)
        ]);
    } else {
        echo json_encode([
            "batalla_terminada" => false
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        "error" => $e->getMessage()
    ]);
}
?>
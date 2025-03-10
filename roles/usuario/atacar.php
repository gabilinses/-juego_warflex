<?php
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();
header('Content-Type: application/json');
error_reporting(0);

try{
    // Obtener datos
    $atacante = $_POST['atacante'];
    $victima = $_POST['victima'];
    $id_arma = $_POST['arma'];
    $parte_cuerpo = $_POST['parte'];
    $id_sala = $_GET['id_sala'];

    // Obtener daño del arma
    $sql_arma = $con->prepare("
        SELECT t.daño 
        FROM armas a 
        INNER JOIN tipo_arma t ON a.Id_tipo_arma = t.Id_tipo_arma 
        WHERE a.Id_armas = ?
    ");
    $sql_arma->execute([$id_arma]);
    $daño = $sql_arma->fetchColumn();

    // Si es headshot, daño fijo de 75
    if ($parte_cuerpo === 'cabeza') {
        $daño = 75;
    }

    // Actualizar vida y puntos de la víctima
    $sql_update_victima = $con->prepare("
        UPDATE usuario 
        SET vida = GREATEST(0, vida - ?),
            puntos = GREATEST(0, puntos - ?) -- Ahora resta el daño completo
        WHERE username = ?
    ");
    $sql_update_victima->execute([$daño, $daño, $victima]);

    // Actualizar puntos del atacante
    $sql_update_atacante = $con->prepare("
        UPDATE usuario 
        SET puntos = puntos + ? + CASE 
            WHEN (SELECT vida FROM usuario WHERE username = ?) <= ? THEN 5 
            ELSE 0 
        END
        WHERE username = ?
    ");
    $sql_update_atacante->execute([$daño, $victima, $daño, $atacante]);

    // Actualizar estadística
    $sql_estadistica = $con->prepare("
        UPDATE estadistica 
        SET daño = daño + ?
        WHERE id_sala = ? AND username = ?
    ");
    $sql_estadistica->execute([$daño, $id_sala, $atacante]);

    // Obtener vida actualizada
    $sql_vida = $con->prepare("SELECT vida FROM usuario WHERE username = ?");
    $sql_vida->execute([$victima]);
    $nueva_vida = $sql_vida->fetchColumn();

    // Eliminar jugador si murió
    if ($nueva_vida <= 0) {
        $sql_eliminar = $con->prepare("DELETE FROM detalle_sala WHERE id_sala = ? AND username = ?");
        $sql_eliminar->execute([$id_sala, $victima]);

        // Regenerar vida del jugador eliminado
        $sql_regenerar = $con->prepare("UPDATE usuario SET vida = 100 WHERE username = ?");
        $sql_regenerar->execute([$victima]);

        // Verificar jugadores restantes
        $sql_check_players = $con->prepare("SELECT COUNT(*) FROM detalle_sala WHERE id_sala = ?");
        $sql_check_players->execute([$id_sala]);
        $jugadores_restantes = $sql_check_players->fetchColumn();

        if ($jugadores_restantes <= 1) {
            finalizarBatalla($con, $id_sala);
        }
    }

    // Verificar si el tiempo ha terminado
    $sql_tiempo = $con->prepare("
        SELECT TIMESTAMPDIFF(SECOND, fecha_ini, NOW()) >= 300 as tiempo_acabado
        FROM estadistica 
        WHERE id_sala = ? 
        LIMIT 1
    ");
    $sql_tiempo->execute([$id_sala]);
    $tiempo_acabado = $sql_tiempo->fetchColumn();

    if ($tiempo_acabado) {
        finalizarBatalla($con, $id_sala);
    }

    // Función para finalizar la batalla
    function finalizarBatalla($con, $id_sala) {
        // Actualizar estado de la sala
        $sql_update_sala = $con->prepare("UPDATE sala SET Id_estado = 6 WHERE Id_sala = ?");
        $sql_update_sala->execute([$id_sala]);

        // Registrar fecha de fin
        $sql_update_fin = $con->prepare("
            UPDATE estadistica 
            SET fecha_fin = NOW() 
            WHERE id_sala = ? AND fecha_fin IS NULL
        ");
        $sql_update_fin->execute([$id_sala]);
    }

    // Registrar el ataque
    $sql_registro = $con->prepare("
        INSERT INTO estadistica (id_sala, atacante, victima, id_arma, parte_cuerpo, daño) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $sql_registro->execute([$id_sala, $atacante, $victima, $id_arma, $parte_cuerpo, $daño]);

    echo json_encode([
        "success" => true,
        "nueva_vida" => $nueva_vida,
        "daño" => $daño,
        "parte" => $parte_cuerpo,
        "eliminado" => ($nueva_vida <= 0),
        "tiempo_acabado" => $tiempo_acabado,
        "ultimo_jugador" => isset($jugadores_restantes) && $jugadores_restantes === 1,
        "redirect" => ($nueva_vida <= 0 || $tiempo_acabado) ? "index.php" : null
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error en el servidor: " . $e->getMessage()
    ]);
}
?>

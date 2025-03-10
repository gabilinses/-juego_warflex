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

    // Registrar el ataque y actualizar el daño acumulado
    // Primero obtener el daño acumulado
    $sql_daño = $con->prepare("
        SELECT COALESCE(SUM(daño), 0) 
        FROM estadistica 
        WHERE id_sala = ? AND username = ?
    ");
    $sql_daño->execute([$id_sala, $atacante]);
    $daño_acumulado = $sql_daño->fetchColumn();

    // Luego registrar el nuevo ataque con solo el daño actual
    $sql_registro = $con->prepare("
        INSERT INTO estadistica (id_sala, username, usu_victima, Id_armas, parte_cuerpo, daño) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $sql_registro->execute([$id_sala, $atacante, $victima, $id_arma, $parte_cuerpo, $daño]);

   
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
    }
    
    echo json_encode([
        "success" => true,
        "nueva_vida" => $nueva_vida,
        "daño" => $daño,
        "parte" => $parte_cuerpo,
        "eliminado" => ($nueva_vida <= 0),
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error en el servidor: " . $e->getMessage()
    ]);
}
?>

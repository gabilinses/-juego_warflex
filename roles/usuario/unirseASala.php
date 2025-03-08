<?php
// unirseASala.php
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();

header('Content-Type: application/json'); // Asegúrate de que la respuesta sea JSON

try {
    $id_sala = $_POST['id_sala'];
    $username = $_POST['username'];

    // Verificar si hay espacio en la sala
    $sql_contar_jugadores = $con->prepare("
        SELECT COUNT(*) 
        FROM detalle_sala 
        WHERE id_sala = :id_sala
    ");
    $sql_contar_jugadores->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
    $sql_contar_jugadores->execute();
    $num_jugadores = $sql_contar_jugadores->fetchColumn();

    if ($num_jugadores < 5) {
        // Agregar al jugador a la sala
        $sql_unirse = $con->prepare("
            INSERT INTO detalle_sala (username, id_sala) 
            VALUES (:username, :id_sala)
        ");
        $sql_unirse->bindParam(':username', $username, PDO::PARAM_STR);
        $sql_unirse->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
        $sql_unirse->execute();

        echo json_encode(["success" => true, "message" => "Te has unido a la sala."]);
    } else {
        echo json_encode(["success" => false, "message" => "La sala está llena."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
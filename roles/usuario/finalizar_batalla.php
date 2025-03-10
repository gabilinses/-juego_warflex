<?php
session_start(); // Iniciar la sesión

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "warflexbd";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Obtener los datos enviados
$id_sala = $_POST['id_sala'];

// Eliminar los registros relacionados en detalle_sala
$sql = "DELETE FROM detalle_sala WHERE id_sala = $id_sala";
if ($conn->query($sql)) {
    // Eliminar la sala
    $sql = "DELETE FROM sala WHERE id_sala = $id_sala";
    if ($conn->query($sql)) {
        echo json_encode(["finalizada" => true]);
    } else {
        echo json_encode(["error" => "Error al eliminar la sala."]);
    }
} else {
    echo json_encode(["error" => "Error al eliminar los registros de detalle_sala."]);
}

$conn->close();
?>
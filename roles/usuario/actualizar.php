<?php
session_start(); // Iniciar sesión
require_once('../../database/conexion.php'); // Incluir la conexión a la base de datos

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados desde el frontend
    $data = json_decode(file_get_contents('php://input'), true);
    $avatar = $data['avatarId'];
    $mundo = $data['mundoId'];
    $username = $_SESSION['username']; // Obtener el nombre de usuario de la sesión

    // Verificar que los datos no estén vacíos
    if (empty($avatar) || empty($mundo) || empty($username)) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
        exit;
    }

    // Conectar a la base de datos
    $conex = new Database;
    $con = $conex->conectar();

    // Actualizar el avatar y el mundo del usuario
    try {
        $sql = "UPDATE usuario SET Id_avatar = :avatarId, Id_mundo = :mundoId WHERE username = :username";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':avatarId', $avatar);
        $stmt->bindParam(':mundoId', $mundo);
        $stmt->bindParam(':username', $username);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Cambios guardados correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar los cambios.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>
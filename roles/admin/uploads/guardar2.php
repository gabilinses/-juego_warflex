<?php
// Configuración de la conexión a MySQL
$host = 'localhost';
$dbname = 'warflex_2';
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validar y procesar los datos del formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $nombre = trim($_POST['nombre']);
        $nivel = trim($_POST['nivel']);

        // Validar la imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['imagen']['tmp_name'];
            $fileName = $_FILES['imagen']['name'];
            $fileSize = $_FILES['imagen']['size'];
            $fileType = $_FILES['imagen']['type'];

            // Verificar el tipo de archivo y el tamaño
            $allowedTypes = ['image/png'];
            if (!in_array($fileType, $allowedTypes)) {
                die(json_encode(['error' => 'Solo se permiten archivos JPG.']));
            }

            if ($fileSize > 777 * 1024) { // 200 KB
                die(json_encode(['error' => 'El archivo no debe superar los 200 KB.']));
            }

            // Guardar la imagen en una carpeta
            $uploadDir = '../../../img/mundos/';

            
            //si la carpeta uploads no existe la crea y le otorga todos los permisos con el 0777 true

            //uniqid() : Esta función genera un identificador único basado en la hora actual (microsegundos). Es útil para evitar conflictos de nombres de archivo.
            //Ejemplo de salida: '64b5f3e9c8f1a'

            
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $newFileName = uniqid() . '_' . $fileName;
            $destPath = $uploadDir . $newFileName;

            if (!move_uploaded_file($fileTmpPath, $destPath)) {
                die(json_encode(['error' => 'Error al subir la imagen.']));
            }

            $imagen = $destPath;

            // Insertar los datos en la base de datos
            $stmt = $pdo->prepare("INSERT INTO mundo (Nom_mundo, nivel,Foto) VALUES (?, ?, ?)");
            $stmt->execute([$nombre, $nivel, $imagen]);

            echo json_encode(['message' => 'Datos guardados correctamente.']);
        } else {
            echo json_encode(['error' => 'Error al subir la imagen.']);
        }
    } else {
        echo json_encode(['error' => 'Método no permitido.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
}
?>
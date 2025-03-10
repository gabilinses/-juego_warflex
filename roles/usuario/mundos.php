<?php
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit();
}

$username = $_SESSION['username'];

// Obtener nivel del usuario
$sql_nivel = $con->prepare("
    SELECT n.Id_nivel 
    FROM usuario u 
    INNER JOIN niveles n ON u.puntos >= n.Puntos 
    WHERE u.username = ? 
    ORDER BY n.Puntos DESC 
    LIMIT 1
");
$sql_nivel->execute([$username]);
$nivel_usuario = $sql_nivel->fetchColumn();

// Obtener mundos disponibles según el nivel
$sql_mundos = $con->prepare("SELECT * FROM mundo WHERE nivel = ?");
$sql_mundos->execute([$nivel_usuario]);
$mundos = $sql_mundos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Mundo</title>
    <link rel="stylesheet" href="../../css/mundos.css">
</head>
<body>
    <h1>Selecciona tu Mundo</h1>
    <div class="mundos-grid">
        <?php foreach ($mundos as $mundo): ?>
            <div class="mundo-card">
                <img src="../../img/mundos/<?php echo $mundo['Foto']; ?>" alt="<?php echo $mundo['Nom_mundo']; ?>">
                <h3><?php echo $mundo['Nom_mundo']; ?></h3>
                <p>Nivel requerido: <?php echo $mundo['nivel']; ?></p>
                <button class="seleccionar-btn" onclick="seleccionarMundo(<?php echo $mundo['Id_mundo']; ?>)">Seleccionar</button>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="index.php">
        <img src="../../img/regresar.png" alt="regresar" class="regresar">
    </a>

    <script>
        async function seleccionarMundo(id_mundo) {
            try{
                const response = await fetch('actualizar_mundo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id_mundo=' + id_mundo
                });
                const resu = await response.json();

                if (resu.success) {
                    alert('Mundo seleccionado correctamente');
                    window.location.href = 'index.php';
            
                } else {
                    alert('Error al actualizar el mundo');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error en la conexión');
            }
        }
    </script>
</body>
</html>
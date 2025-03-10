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

// Obtener avatares disponibles
$sql_avatares = $con->prepare("SELECT * FROM avatar");
$sql_avatares->execute();
$avatares = $sql_avatares->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Avatar</title>
    <link rel="stylesheet" href="../../css/avatares.css">
</head>
<body>
    <h1>Selecciona tu Avatar</h1>
    <div class="avatares-grid">
        <?php foreach ($avatares as $avatar): ?>
            <div class="avatar-card">
                <img src="../../img/avatares/<?php echo $avatar['Foto']; ?>" alt="<?php echo $avatar['Nom_avatar']; ?>">
                <h3><?php echo $avatar['Nom_avatar']; ?></h3>
                <button class="seleccionar-btn" onclick="seleccionarAvatar(<?php echo $avatar['Id_avatar']; ?>)">Seleccionar</button>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="index.php">
        <img src="../../img/regresar.png" alt="regresar" class="regresar">
    </a>

    <script>
        async function seleccionarAvatar(id_avatar) {
            try{
                const response = await fetch('actualizar_avatar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id_avatar=' + id_avatar
                })
                const data = await response.json();
                    if (data.success) {
                        alert('Avatar actualizado correctamente');
                        window.location.href = 'index.php';
                    } else {
                        alert('Error al actualizar el avatar');
                    }
            
            } catch (error) {
                console.error('Error:', error);
                alert('Error en la conexión');
            }
        }   
    </script>
</body>
</html>
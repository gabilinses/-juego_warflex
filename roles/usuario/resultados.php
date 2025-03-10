<?php
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();

// Obtener el jugador con más puntos
$sql = $con->prepare("SELECT username, MAX(daño_puntos) as puntos FROM estadistica WHERE id_batalla = :id_batalla GROUP BY username ORDER BY puntos DESC LIMIT 1");
$sql->execute(['id_batalla' => $_SESSION['id_batalla']]);
$ganador = $sql->fetch(PDO::FETCH_ASSOC);
?>

<h1>¡Batalla finalizada!</h1>
<p>Ganador: <strong><?php echo $ganador['username']; ?></strong> con <?php echo $ganador['puntos']; ?> puntos.</p>
<a href="index.php">Volver al inicio</a>

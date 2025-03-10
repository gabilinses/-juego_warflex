<?php
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();

$username = $_SESSION['username'];
$mundo = $_SESSION['Id_mundo'];
// Verificar si hay salas con estado 3 o 4
$sql_salas = $con->prepare("SELECT s.Id_sala, s.Id_mundo, s.Id_estado, (SELECT COUNT(*) FROM detalle_sala ds WHERE ds.id_sala = s.Id_sala) AS num_jugadores FROM sala s WHERE Id_mundo = $mundo AND Id_estado IN (3,4) LIMIT 2");
$sql_salas->execute();
$salas = $sql_salas->fetchAll(PDO::FETCH_ASSOC);

if (count($salas) < 2) {
    // Si hay menos de 2 salas, crear las necesarias con estado 4
    for ($i = count($salas); $i < 2; $i++) {
        $sql_crear_sala = $con->prepare("INSERT INTO sala (Id_mundo, Id_estado) VALUES ($mundo, 4)");
        $sql_crear_sala->execute();
        $id_nueva_sala = $con->lastInsertId();
        $salas[] = ['Id_sala' => $id_nueva_sala, 'Id_estado' => 4, 'num_jugadores' => 0];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salas de Batalla</title>
    <link rel="stylesheet" href="../../css/salas.css">
</head>
<body>
<div class="container">
    <h1 class="titulo">SALAS</h1>
    <div class="salas" id="salas">
        <?php foreach ($salas as $index => $sala){ ?>
            <div class="sala" id="sala<?php echo $sala['Id_sala']; ?>">
                <h2 class="tit_sala">Sala <?php echo ($index + 1); ?></h2>
                <p class="jugadores">Jugadores <span id="jugadores<?php echo $sala['Id_sala']; ?>"><?php echo $sala['num_jugadores']; ?></span>/5</p>
                <?php if ($sala['Id_estado'] == 3){ ?>
                    <p class="ocupado">Batalla en curso. No puedes unirte.</p>
                <?php }else{ ?>
                    <button class="btn" data-id="<?php echo $sala['Id_sala']; ?>" onclick="unirseASala(this)">UNIRSE</button>
                <?php }; ?>
            </div>
        <?php }; ?>
    </div>
</div>

<a href="index.php">
    <img src="../../img/regresar.png" alt="regresar" class="regresar">
</a>

<script>
    function unirseASala(button) {
        const id_sala = button.getAttribute('data-id');

        fetch("unirseASala.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id_sala=" + id_sala
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = "sala_espera.php?id_sala=" + id_sala;
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    }
</script>

</body>
</html>

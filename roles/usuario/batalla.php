<?php
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();

$username = $_SESSION['username'];
$id_sala = $_GET['id_sala'] ?? null;

if (!$id_sala) {
    header("Location: salas.php");
    exit;
}

// Verificar si el usuario pertenece a la sala y si la sala está en batalla
$sqlVerificar = $con->prepare("
    SELECT s.Id_estado, (
        SELECT COUNT(*) 
        FROM detalle_sala 
        WHERE id_sala = s.Id_sala
    ) as total_jugadores
    FROM detalle_sala ds
    JOIN sala s ON ds.id_sala = s.Id_sala
    WHERE ds.username = ? AND ds.id_sala = ?
");
$sqlVerificar->execute([$username, $id_sala]);
$resultado = $sqlVerificar->fetch(PDO::FETCH_ASSOC);

$sqlUpdateEstado = $con->prepare("UPDATE sala SET Id_estado = 5 WHERE id_sala = ?");
$sqlUpdateEstado->execute([$id_sala]);
    
if ($id_sala) {
    // Verificar si ya existe un registro
    $sql_check = $con->prepare("SELECT COUNT(*) FROM estadistica WHERE id_sala = ? AND username = ? AND fecha_ini IS NOT NULL");
    $sql_check->execute([$id_sala, $username]);
    
    if ($sql_check->fetchColumn() == 0) {
        // Solo insertar si no existe
        $hora_inicio = date("Y-m-d H:i:s");
        $sql_update = $con->prepare("INSERT INTO estadistica (id_sala, username, fecha_ini) VALUES (?, ?, ?)");
        $sql_update->execute([$id_sala, $username, $hora_inicio]);
    }
}

// Obtener jugadores en la sala
$sql_jugadores = $con->prepare("SELECT u.username, u.vida, CONCAT('../../img/avatares/', a.foto) AS avatar FROM detalle_sala ds INNER JOIN usuario u ON ds.username = u.username INNER JOIN avatar a ON u.Id_avatar = a.Id_avatar WHERE ds.id_sala = ?");
$sql_jugadores->execute([$id_sala]);
$jugadores = $sql_jugadores->fetchAll(PDO::FETCH_ASSOC);

// Primero obtener los puntos del usuario
// Obtener nivel del usuario
$sql_puntos = $con->prepare("
    SELECT n.Id_nivel 
    FROM usuario u 
    INNER JOIN niveles n ON u.puntos >= n.Puntos 
    WHERE u.username = ? 
    ORDER BY n.Puntos DESC 
    LIMIT 1
");
$sql_puntos->execute([$username]);
$nivel = $sql_puntos->fetchColumn();

// Obtener armas disponibles según el nivel del usuario
$sql_armas = $con->prepare("
    SELECT a.Id_armas, a.nom_arma, a.cant_balas, CONCAT('../../img/armas/', a.foto) AS foto, t.daño
    FROM armas a 
    INNER JOIN tipo_arma t ON a.Id_tipo_arma = t.Id_tipo_arma 
    WHERE t.nivel = ?
");
$sql_armas->execute([$nivel]);
$armas = $sql_armas->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batalla</title>
    <link rel="stylesheet" href="../../css/batalla.css">
</head>
<body>
    <h1>Batalla</h1>
    <h2>Jugadores en la batalla:</h2>
    <div class="jugadores">
        <?php foreach ($jugadores as $jugador){ ?>
            <div>
                <img src="<?php echo $jugador['avatar']; ?>" alt="Avatar" width="50">
                <p><?php echo $jugador['username']; ?> - Vida: <span id="vida_<?php echo $jugador['username']; ?>"><?php echo $jugador['vida']; ?></span></p>
                <?php if ($jugador['username'] !== $username){ ?>
                    <button onclick="atacar('<?php echo $jugador['username']; ?>', document.getElementById('arma').value, document.getElementById('parte_cuerpo').value)">Atacar a <?php echo $jugador['username']; ?></button>
                <?php }; ?>
            </div>
        <?php }; ?>
    </div>
    
    <h3>Selecciona tu arma y objetivo:</h3>
    <div class="controles-ataque">
        <select id="arma" name="arma" required>
            <option value="">Selecciona un arma</option>
            <?php foreach ($armas as $arma){ ?>
                <option value="<?php echo $arma['Id_armas'] ?>"><?php echo $arma['nom_arma'] ?>, Balas: <?php echo $arma['cant_balas'] ?>, Daño: <?php echo $arma['daño'] ?> </option>
            <?php }; ?>
        </select>

        <select id="parte_cuerpo" name="parte_cuerpo" required>
            <option value="">Selecciona donde atacar</option>
            <option value="cabeza">Cabeza</option>
            <option value="torso">Torso</option>
            <option value="brazos">Brazos</option>
            <option value="piernas">Piernas</option>
        </select>
    </div>
    
    <script>
        
        async function atacar(victima, arma, parte) {
            if (!arma || !parte) {
                alert('Selecciona un arma y una parte del cuerpo para atacar');
                return;
            }

            try {
                const response = await fetch('atacar.php?id_sala=<?php echo $id_sala; ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `atacante=<?php echo $username; ?>&victima=${victima}&arma=${arma}&parte=${parte}`
                });

                const data = await response.json();

                if (data.success) {
                    document.getElementById("vida_" + victima).innerText = data.nueva_vida;
                    if (data.nueva_vida <= 0) {
                        alert(victima + " ha sido eliminado");
                        if (victima === '<?php echo $username; ?>') {
                            alert("Has sido eliminado de la batalla");
                            window.location.href = "index.php";
                        }
                    }
                } else {
                    alert(data.message);
                }
            } catch(error) { console.error("Error en el ataque:", error);
            }
        }

        async function verificarEstadoBatalla() {
            try {
                const response = await fetch('verificar_batalla.php?id_sala=<?php echo $id_sala; ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `username=<?php echo $username; ?>`
                });

                const data = await response.json();
                if (data.batalla_terminada) {
                    if (data.ganador) {
                        if (data.ganador === '<?php echo $username; ?>') {
                            if (data.por_tiempo) {
                                alert("¡Felicidades! Has ganado la batalla por mayor daño causado");
                            } else if (data.por_eliminacion) {
                                alert("¡Felicidades! Has ganado la batalla por eliminar a todos los jugadores");
                            }
                        } else {
                            if (data.por_tiempo) {
                                alert("La batalla ha terminado. El ganador es " + data.ganador + " por mayor daño causado");
                            } else if (data.por_eliminacion) {
                                alert("La batalla ha terminado. El ganador es " + data.ganador + " por eliminar a todos los jugadores");
                            }
                        }
                    } else {
                        alert("La batalla ha terminado sin ganador porque no hubo suficientes ataques");
                    }
                    window.location.href = "index.php";
                }
            } catch(error) {
                console.error("Error al verificar estado:", error);
            }
        }

        setInterval(verificarEstadoBatalla, 2000);

        window.onload = function() {
            verificarEstadoBatalla();
        };
    
    </script>
</body>
</html>
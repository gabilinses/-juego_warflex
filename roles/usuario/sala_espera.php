<?php
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();


if (!isset($_GET['id_sala'])) {
    die("Error: No se recibió el ID de la sala.");
}

$id_sala = $_GET['id_sala'];
$username = $_SESSION['username']; // Obtenemos el usuario actual

// Verificar si el usuario ya está en la sala
$sql_check = $con->prepare("SELECT COUNT(*) FROM detalle_sala WHERE id_sala = ? AND username = ?");
$sql_check->execute([$id_sala, $username]);
$ya_esta = $sql_check->fetchColumn();

if ($ya_esta == 0) {
    // Si no está en la sala, lo agregamos
    $sqlJoin = $con->prepare("INSERT INTO detalle_sala (id_sala, username) VALUES (?, ?)");
    $sqlJoin->execute([$id_sala, $username]);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sala de Espera</title>
    <!-- <link rel="stylesheet" href="../../css/salas.css"> -->
    <style>
        body {
            background-color:green; 
        }
    </style>
</head> 
<body>
    <h1>Sala de Espera</h1>
    <p>Jugadores en la sala:</p>
    <ul id="lista-jugadores"></ul>

    <p id="contador">Esperando jugadores...</p>
    <a href="salas.php">
    <img  src="../../img/regresar.png" alt="regresar" class="regresar">
    </a>
    <script>
        let tiempoRestante = null;
        let contadorActivo = false;
        let intervalo = null;

        function actualizarListaJugadores() {
            fetch("verificar_jugadores.php?id_sala=<?php echo $id_sala; ?>")
            .then(response => response.json())
            .then(data => {
                document.getElementById("lista-jugadores").innerHTML = data.jugadores.map(j => `<li>${j}</li>`).join("");
        if (data.total >= 2 && data.segundos_restantes !== null) {
            if (!contadorActivo) {
                tiempoRestante = data.segundos_restantes;
                iniciarCuentaRegresiva();
            }
        } else {
            document.getElementById("contador").textContent = "Esperando jugadores...";
            contadorActivo = false;
            clearInterval(intervalo);
        }
        // Descomenta esta parte
        if (data.redirigir) {
            window.location.href = "batalla.php?id_sala=<?php echo $id_sala; ?>";
        }
        setTimeout(actualizarListaJugadores, 2000);
    })
    .catch(error => console.error("Error en actualización de jugadores:", error));
}

function iniciarCuentaRegresiva() {
    contadorActivo = true;
    let contadorElemento = document.getElementById("contador");

    if (intervalo) clearInterval(intervalo);

    intervalo = setInterval(() => {
        console.log("Tiempo restante:", tiempoRestante);
        if (tiempoRestante <= 0) {
            clearInterval(intervalo);
            console.log("Contador llegó a 0, actualizando estado..."); 
            
                        window.location.href = "batalla.php?id_sala=<?php echo $id_sala; ?>";
                  
        } else {
            contadorElemento.textContent = "La batalla inicia en: " + tiempoRestante + "s";
            tiempoRestante--;
        }
    }, 1000);
}

        function eliminarUsuario() {
            fetch("eliminar_usuario.php?id_sala=<?php echo $id_sala; ?>", { method: "GET" });
        }

        window.addEventListener("beforeunload", eliminarUsuario);
        actualizarListaJugadores();
    </script>
</body>
</html>
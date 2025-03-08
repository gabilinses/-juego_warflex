<?php
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();

$mundo = $_SESSION['Id_mundo'];

$sql = $con->prepare("SELECT Nom_mundo from mundo where Id_mundo = $mundo");
$sql->execute();
$resu = $sql->fetchColumn();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salas</title>
    <link rel="stylesheet" href="../../css/salas.css">
</head>
<body>
    <div class="container">
        <h1 class="titulo">SALAS</h1>
        <p class="mundo"> Mundo <?php echo $resu; ?></p>
        <div class="salas" id="salas">
            <!-- Sala 1 -->
            <div class="sala" id="sala1">
                <h2 class="tit_sala">Sala 1</h2>
                <p class="jugadores">Jugadores <span id="jugadores1">0</span>/5</p>
                <button class="btn" onclick="unirseASala(1)">UNIRSE</button>
            </div>

            <!-- Sala 2 -->
            <div class="sala" id="sala2">
                <h2 class="tit_sala">Sala 2</h2>
                <p class="jugadores">Jugadores <span id="jugadores2">0</span>/5</p>
                <button class="btn" onclick="unirseASala(2)">UNIRSE</button>
            </div>
        </div>
    </div>

    <script>

        // Función para obtener y actualizar las salas
        async function obtenerSalas() {
            try {
                const response = await fetch("obtenerSalas.php", {
                    method: "POST",
                });

                const resultado = await response.json();

                if (resultado.success) {
                    const salas = resultado.salas;

                    // Actualizar la información de las salas
                    salas.forEach((sala, index) => {
                        const salaId = index + 1; // Sala 1 o Sala 2
                        const tituloSala = document.querySelector(`#sala${salaId} .tit_sala`);
                        const jugadoresSala = document.querySelector(`#jugadores${salaId}`);

                        if (tituloSala && jugadoresSala) {
                            tituloSala.textContent = `Sala ${sala.Id_sala}`; // Actualizar el nombre de la sala
                            jugadoresSala.textContent = sala.num_jugadores || 0; // Actualizar el número de jugadores
                        }
                    });
                } else {
                    console.error("Error:", resultado.error);
                }
            } catch (error) {
                console.error("Error al obtener las salas:", error);
            }
        }

        // Función para unirse a una sala
        async function unirseASala(idSala) {
            try {
                const formData = new FormData();
                formData.append('id_sala', idSala);

                const response = await fetch("unirseASala.php", {
                    method: "POST",
                    body: formData
                });

                const resultado = await response.json();
                if (resultado.success) {
                    alert("Te has unido a la sala.");
                    obtenerSalas(); // Actualizar la lista de salas
                } else {
                    alert(resultado.message);
                }
            } catch (error) {
                console.error("Error al unirse a la sala:", error);
            }
        }

        // Cargar las salas al iniciar la página
        document.addEventListener("DOMContentLoaded", obtenerSalas);

        // Actualizar las salas cada 30 segundos
        setInterval(obtenerSalas, 30000);
    </script>
</body>
</html>
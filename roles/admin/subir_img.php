<?php

include ('header.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Categoría</title>
    <style>
        .caja {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 300px;
            height: 300px;
            margin: 20px;
            border: 2px solid #007bff;
            border-radius: 10px;
            background-color: #f8f9fa;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }

        .caja:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .caja img {
            width: 150px;
            height: 150px;
            margin-bottom: 20px;
        }

        .caja h3 {
            font-size: 24px;
            color: #007bff;
        }

        .container-cajas {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container-cajas">
        <!-- Caja de Armas -->
        <div class="caja" onclick="window.location.href='up_armas.php'">
            <img src="ruta/a/imagen_armas.png" alt="Armas">
            <h3>Armas</h3>
        </div>

        <!-- Caja de Avatares -->
        <div class="caja" onclick="window.location.href='up_avatares.php'">
            <img src="ruta/a/imagen_avatares.png" alt="Avatares">
            <h3>Avatares</h3>
        </div>

        <!-- Caja de Mundos -->
        <div class="caja" onclick="window.location.href='up_mundos.php'">
            <img src="ruta/a/imagen_mundos.png" alt="Mundos">
            <h3>Mundos</h3>
        </div>
    </div>
</body>
</html>

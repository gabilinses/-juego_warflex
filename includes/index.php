<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla Principal</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>

    <section class="perfil">
        <img src="../img/image.png <?php //echo $usuario['avatar']; ?>" alt="Avatar">
        <div>
            <h2><?php //echo strtoupper($usuario['nombre']); ?></h2>
            <p><span><?php //echo $usuario['puntos']; ?> PTS</span></p>
            <p>NIVEL <?php //echo $usuario['nivel']; ?></p>
        </div>
    </section>

    <section class="personaje">
        <img src="../img/image.png <?php //echo $usuario['avatar']; ?>" alt="Personaje">
    </section>

    <section class="opciones">
        <div class="contenedor-opciones">
            <div class="fila">
                <div class="opcion">
                    <p>AVATAR</p>
                    <img src="../img/image.png <?php //echo $usuario['avatar']; ?>" alt="Avatar">
                    <span>PEPITO</span>
                </div>
                <div class="linea-vertical"></div>
                <div class="opcion">
                    <p>MUNDO</p>
                    <img src="<?php //echo $usuario['mapa']; ?>" alt="Mapa">
                    <span>KHAOS</span>
                </div>
            </div>
            <div class="linea-horizontal"></div>
            <button class="boton-jugar">JUGAR</button>
        </div>
    </section>

</body>
</html>
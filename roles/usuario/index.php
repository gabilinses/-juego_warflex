<?php

require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();

if (!isset($_SESSION['username'])) {
    echo "Inicio de sesion invalida";
    exit();
}

$username = $_SESSION['username'];


$sql = $con->prepare("SELECT u.username, u.puntos, n.nom_nivel, a.foto AS afoto, a.Nom_avatar, m.Nom_mundo, m.Foto AS mfoto, m.Id_mundo FROM usuario u INNER JOIN niveles n ON u.puntos >= n.Puntos 
INNER JOIN avatar a ON u.Id_avatar = a.Id_avatar
INNER JOIN mundo m ON n.Id_nivel = m.nivel WHERE u.username = '$username' ORDER BY n.Puntos DESC");
$sql->execute();
$fila = $sql->fetch(PDO::FETCH_ASSOC);

$puntos = $fila['puntos'];
$nivel = $fila['nom_nivel'];
$avatar = "../../img/avatares/".$fila['afoto'];
$nom_avatar = $fila['Nom_avatar'];
$nom_mundo = $fila['Nom_mundo'];
$mundo = "../../img/mundos/".$fila['mfoto'];
$_SESSION['Id_mundo'] = $fila['Id_mundo'];
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla Principal</title>
    <link rel="stylesheet" href="../../css/index.css">
</head>
<body>

    <section class="perfil">
        <img src="<?php echo $avatar?>" alt="Avatar">
        <div>
            <h2><?php echo $username; ?></h2>
            <p><span><?php echo $puntos; ?> PTS</span></p>
            <p> <?php echo $nivel; ?></p>       
        </div>
    </section>

    <section class="personaje">
        <img src="<?php echo $avatar?>" alt="Personaje">
    </section>

    <section class="opciones">
        <div class="contenedor-opciones">
            <div class="fila">
                <div class="opcion" id="seleccion_avatara">
                        <a class="subrayado" href="avatares.php">
                            <p>AVATAR</p>
                            <img src="<?php echo $avatar?>" id="avatar_actual" alt="Avatar">
                            <span><?php echo $nom_avatar?></span>
                        </a>
                </div>  
                <div class="linea-vertical"></div>
                <div class="opcion" id="seleccion_mundo">
                        <a class="subrayado" href="mundos.php">
                                <p>MUNDO</p>
                                <img src="<?php echo $mundo?>" id="mundo_actual" alt="Mapa">
                                <span><?php echo $nom_mundo?></span>
                        </a>

                </div>
            </div>
            <div class="linea-horizontal"></div>
            <button class="boton-jugar" onclick="window.location.href='salas.php'">JUGAR</button>
        </div>
    </section>

    <section class="salir">
        <div class="cerrar-sesion">
            <button class="boton-salir"><a href="../../includes/exit.php">Cerrar Sesion</a></button>
        </div>
    </section>

</body>
</html>
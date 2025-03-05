<?php

require_once('../../database/conexion.php');
include ('header.php');

$conex = new Database;
$con = $conex->conectar();


if (!isset($_SESSION['username'])) {
    echo "Inicio de sesion invalida";
    exit();
}
$username = $_SESSION['username'];


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
</head>

    <!-- Contenido principal -->
    <div class="main-content">
        <h2>Bienvenido, <?php echo $username; ?></h2>
        <div class="cards">
            <div class="card">
                <h3>Menú</h3>
                <p>Apartado para descripciones sobre las opciones existentes</p>
            </div>
            <div class="card">
                <h3>Gestión de Usuarios</h3>
                <p>Administra los usuarios registrados en el sistema.</p>
            </div>
            <div class="card">
                <h3>Subir Imágenes</h3>
                <p>Sube y gestiona imágenes para el sistema.</p>
            </div>
            <div class="card">
                <h3>Configuración</h3>
                <p>Ajusta las configuraciones del sistema.</p>
            </div>
        </div>
    </div>
    <!-- Fin Contenido Principal -->

<?php
include ('footer.php');
?>

</body>
</html>
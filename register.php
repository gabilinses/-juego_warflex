<?php
require_once('database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();

// Obtener avatares desde la base de datos
$sql = $con->query("SELECT id_avatar, Nom_avatar, Foto FROM avatar");
$avatares = $sql->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {
    $username = $_POST['user'];
    $correo = $_POST['correo'];
    $contra = $_POST['contra'];
    $vida = 100;
    $puntos = 0;
    $rol = 1;
    $estado = 2;
    $id_avatar = $_POST['avatar']; // Avatar elegido por el usuario
    $contra_en = password_hash($contra, PASSWORD_DEFAULT);

    // Verificar si el usuario o correo ya existen
    $sql = $con->prepare("SELECT * FROM usuario WHERE username = ? OR correo = ?");
    $sql->execute([$username, $correo]);
    $fila = $sql->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
        echo "<script>alert('Ya existe un usuario con estas credenciales');</script>";
        echo "<script>window.location='index.php';</script>";
        exit();
    }

    // Insertar usuario con el avatar seleccionado
    $insert = $con->prepare("INSERT INTO usuario (username, correo, Contraseña, vida, puntos, Id_avatar, Id_estado, Id_rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert->execute([$username, $correo, $contra_en, $vida, $puntos, $id_avatar, $estado, $rol]);

    header("location: index.php");
    exit();
}
?>

<!-- CUERPO HTML PARA EL REGISTRO -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Regístrate!</title>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Estilos personalizados -->
     <link rel="stylesheet" href="css/index.css">
    <style>
      
        .select2-container .select2-selection--single {
            height: 38px;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
            color: #fff;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-container--default .select2-results__option--highlighted {
            background-color: #007bff;
            color: #fff;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #0056b3;
            color: #fff;
        }

        .avatar-option {
            display: flex;
            align-items: center;
        }

        .avatar-option img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="login">
        <h1>REGISTER</h1>
        <h2>¡Regístrate ahora!</h2>
        <form action="" method="POST" autocomplete="off">
            <label for="correo">Correo Electrónico</label>
            <input type="email" id="correo" name="correo" required>

            <label for="user">Username</label>
            <input type="text" id="user" name="user" required>

            <label for="contra">Contraseña</label>
            <input type="password" id="contra" name="contra" required>

            <!-- Selección de avatar con Select2 -->
            <label for="avatar">Selecciona tu Avatar:</label>
            <select id="avatar" name="avatar" class="js-example-basic-single" style="width: 100%;" required>
                <option value="">*** Seleccione ***</option>
                <?php foreach ($avatares as $avatar): ?>
                    <option value="<?= $avatar['id_avatar'] ?>" data-img="<?= $avatar['Foto'] ?>">
                        <?= $avatar['Nom_avatar'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" id="submit" name="submit" class="btn-submit" value="Registrarse">
            <p>¿Ya tienes cuenta? <a class="p_a_login" href="index.php">Iniciar Sesión</a></p>
        </form>
    </div>
    <video autoplay loop muted>
        <source src="video/video1.mp4" type="video/mp4">
    </video>
    <div class="capa"></div>

    <!-- jQuery (requerido por Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            // Inicializar Select2 con imágenes
            function formatAvatar(avatar) {
                if (!avatar.id) return avatar.text;

                const imgUrl = $(avatar.element).data('img');
                const $avatar = $(
                    `<div class="avatar-option"><img src="${imgUrl}" /> ${avatar.text}</div>`
                );
                return $avatar;
            }

            $('#avatar').select2({
                templateResult: formatAvatar,
                templateSelection: formatAvatar,
                escapeMarkup: function (m) {
                    return m;
                },
            });
        });
    </script>
</body>
</html>
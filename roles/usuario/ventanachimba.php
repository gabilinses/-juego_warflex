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

$sql = $con->prepare("SELECT u.username, u.puntos, n.nom_nivel, a.foto AS afoto, a.Nom_avatar, m.Nom_mundo, m.Foto AS mfoto FROM usuario u 
INNER JOIN niveles n ON u.puntos >= n.Puntos 
INNER JOIN avatar a ON u.Id_avatar = a.Id_avatar
INNER JOIN mundo m ON n.Id_nivel = m.nivel WHERE u.username = ? ORDER BY n.Puntos DESC");
$sql->execute([$username]);
$fila = $sql->fetch(PDO::FETCH_ASSOC);

$puntos = $fila['puntos'];
$nivel = $fila['nom_nivel'];
$avatar = "../../img/avatares/".$fila['afoto'];
$nom_avatar = $fila['Nom_avatar'];
$nom_mundo = $fila['Nom_mundo'];
$mundo = "../../img/mundos/".$fila['mfoto'];

// Obtener los avatares disponibles
$avatarQuery = $con->prepare("SELECT * FROM avatar");
$avatarQuery->execute();
$avatares = $avatarQuery->fetchAll(PDO::FETCH_ASSOC);
// Obtener lista de mundos
$queryMundos = $con->prepare("SELECT * FROM mundo");
$queryMundos->execute();
$mundos = $queryMundos->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Avatar y Mundo</title>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Estilos personalizados -->
     <link rel="stylesheet" href="../../css/avt_mun.css">
    <style>
        .avatar-img {
            width: 30px;
            height: 30px;
            margin-right: 10px;
            border-radius: 50%;
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <section class="perfil">
        <img src="<?php echo $avatar; ?>" id="perfil-avatar" alt="Avatar"> 
        <div>
            <h2><?php echo $username; ?></h2>
            <p><?php echo $puntos; ?> PTS</p>
            <p><?php echo $nivel; ?></p>
        </div>
    </section>

    <section class="opciones">
        <div class="opcion" id="seleccionar-avatar">
            <p>AVATAR</p>
            <img src="<?php echo $avatar; ?>" id="avatar-seleccionado" alt="Avatar"><br>
            <span id="nombre-avatar-seleccionado"><?php echo $nom_avatar; ?></span>
        </div>
        <div class="opcion" id="seleccionar-mundo">
            <p>MUNDO</p>
            <img src="<?php echo $mundo; ?>" id="mundo-seleccionado" alt="Mundo"><br>
            <span id="nombre-mundo-seleccionado"><?php echo $nom_mundo; ?></span>
        </div>
    </section>

    <!-- Modal para seleccionar avatar -->
    <div id="modal-avatar" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" id="cerrar-avatar">&times;</span>
            <h2>AVATARES DISPONIBLES</h2>
            <select id="select-avatar" class="js-example-basic-single">
                <?php foreach ($avatares as $avatar) { ?>
                    <option value="<?php echo $avatar['Id_avatar']; ?>" data-img="../../img/avatares/<?php echo $avatar['Foto']; ?>">
                        <?php echo $avatar['Nom_avatar']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <!-- Modal para seleccionar mundo -->
    <div id="modal-mundo" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" id="cerrar-mundo">&times;</span>
            <h2>MUNDOS DISPONIBLES</h2>
            <select id="select-mundo" class="js-example-basic-single">
                <?php foreach ($mundos as $mundo) { ?>
                    <option value="<?php echo $mundo['Id_mundo']; ?>" data-img="../../img/mundos/<?php echo $mundo['Foto']; ?>">
                        <?php echo $mundo['Nom_mundo']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <button id="submit" class="btn-submit">Guardar Cambios</button>

    <!-- jQuery (requerido por Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Inicializar Select2 para avatares
        $('#select-avatar').select2({
            templateResult: formatAvatar,
            templateSelection: formatAvatar,
            escapeMarkup: function (m) {
                return m;
            },
        });

        // Inicializar Select2 para mundos
        $('#select-mundo').select2({
            templateResult: formatAvatar,
            templateSelection: formatAvatar,
            escapeMarkup: function (m) {
                return m;
            },
        });

        // Función para formatear las opciones con imágenes
        function formatAvatar(avatar) {
            if (!avatar.id) return avatar.text;

            const imgUrl = $(avatar.element).data('img');
            const $avatar = $(
                `<span><img src="${imgUrl}" class="avatar-img" /> ${avatar.text}</span>`
            );
            return $avatar;
        }

        // Mostrar modal de avatar
        document.getElementById('seleccionar-avatar').addEventListener('click', () => {
            document.getElementById('modal-avatar').style.display = 'block';
        });

        // Mostrar modal de mundo
        document.getElementById('seleccionar-mundo').addEventListener('click', () => {
            document.getElementById('modal-mundo').style.display = 'block';
        });

        // Cerrar modales
        document.getElementById('cerrar-avatar').addEventListener('click', () => {
            document.getElementById('modal-avatar').style.display = 'none';
        });

        document.getElementById('cerrar-mundo').addEventListener('click', () => {
            document.getElementById('modal-mundo').style.display = 'none';
        });

        // Actualizar avatar seleccionado
        $('#select-avatar').on('change', function () {
            const selectedOption = $(this).find(':selected');
            const avatarImg = selectedOption.data('img');
            const avatarName = selectedOption.text();

            $('#avatar-seleccionado').attr('src', avatarImg);
            $('#nombre-avatar-seleccionado').text(avatarName);
            $('#modal-avatar').hide();
        });

        // Actualizar mundo seleccionado
        $('#select-mundo').on('change', function () {
            const selectedOption = $(this).find(':selected');
            const mundoImg = selectedOption.data('img');
            const mundoName = selectedOption.text();

            $('#mundo-seleccionado').attr('src', mundoImg);
            $('#nombre-mundo-seleccionado').text(mundoName);
            $('#modal-mundo').hide();
        });

        // Guardar cambios
        document.getElementById('submit').addEventListener('click', async () => {
            const avatarId = $('#select-avatar').val();
            const mundoId = $('#select-mundo').val();

            try {
                const response = await fetch('actualizar.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        avatarId: avatarId,
                        mundoId: mundoId,
                    }),
                });

                const result = await response.json();

                if (result.success) {
                    alert('Cambios guardados correctamente.');
                    window.location.href = 'index.php'; // Recargar la página
                } else {
                    alert('Error al guardar los cambios.');
                }
            } catch (error) {
                console.error(error);
                alert('Error al conectar con el servidor.');
            }
        });
        </script>
</body>
</html>
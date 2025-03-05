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
    <link rel="stylesheet" href="style.css">
        <style>
      body {
            font-family: 'Arial', sans-serif;
            background-color: #1A1A2E; /* Fondo oscuro azulado */
            color: #E0E0E0; /* Texto claro */
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .perfil {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background-color: #0F3460; /* Azul oscuro */
            border-bottom: 2px solid #16213E; /* Borde inferior */
            margin-bottom: 20px;
        }

        .perfil img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin-right: 15px;
            border: 2px solid #16213E; /* Borde para la imagen */
        }

        .perfil h2 {
            margin: 0;
            font-size: 1.5em;
            color: #FFFFFF; /* Texto blanco */
        }

        .perfil p {
            margin: 5px 0;
            color: #B0B0B0; /* Texto gris claro */
        }

        .opciones {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
        }

        .opcion {
            cursor: pointer;
            text-align: center;
            background-color: #16213E; /* Fondo azul oscuro */
            padding: 15px;
            border-radius: 10px;
            border: 2px solid #0F3460; /* Borde azul más oscuro */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .opcion:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .opcion img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            border: 2px solid #0F3460; /* Borde para la imagen */
        }

        .opcion p {
            margin-top: 10px;
            font-size: 1.1em;
            color: #E0E0E0; /* Texto claro */
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .modal-contenido {
            background: #16213E; /* Fondo azul oscuro */
            width: 80%;
            max-width: 500px;
            padding: 30px;
            margin-top: 150px;
            margin-left: 62vh;
            border-radius: 10px;
            border: 2px solid #0F3460; /* Borde azul más oscuro */
            text-align: center;
        }

        .cerrar {
            float: right;
            font-size: 24px;
            cursor: pointer;
            color: #B0B0B0; /* Color gris claro */
        }

        .cerrar:hover {
            color: #FFFFFF; /* Color blanco al pasar el mouse */
        }

        .opcion-lista {
            display: flex;
            align-items: center;
            background: #0F3460; /* Fondo azul oscuro */
            padding: 10px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #16213E; /* Borde azul más claro */
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .opcion-lista:hover {
            background: #1A1A2E; /* Fondo más oscuro al pasar el mouse */
        }

        .opcion-lista img {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            margin-right: 15px;
            border: 1px solid #16213E; /* Borde para la imagen */
        }

        .btn-submit {
            background-color: #0F3460; /* Fondo azul oscuro */
            color: #FFFFFF; /* Texto blanco */
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin-top: 20px;
            border: 2px solid #16213E; /* Borde azul más claro */
            transition: background 0.2s ease;
        }

        .btn-submit:hover {
            background-color: #16213E; /* Fondo más oscuro al pasar el mouse */
        }
    </style>
</head>
<body>
    <section class="perfil">
        <img src="<?php echo $avatar ?>" id="perfil-avatar" alt="Avatar"> 
        <div>
            <h2><?php echo $username; ?></h2>
            <p><?php echo $puntos; ?> PTS</p>
            <p><?php echo $nivel; ?></p>
        </div>
    </section>

    <section class="opciones">
        <div class="opcion" id="seleccionar-avatar">
            <p>AVATAR</p>
            <img src="<?php echo $avatar ?>" id="avatar-seleccionado" alt="Avatar"><br>
            <span><?php echo $nom_avatar ?></span>
        </div>
        <div class="opcion" id="seleccionar-mundo">
            <p>MUNDO</p>
            <img src="<?php echo $mundo ?>" id="mundo-seleccionado" alt="Mundo"><br>
            <span><?php echo $nom_mundo ?></span>
        </div>
    </section>

    <div id="modal-avatar" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" id="cerrar-avatar">&times;</span>
            <h2>AVATARES DISPONIBLES</h2>
            <?php foreach ($avatares as $avatar) { ?>
                <div class="opcion-lista" data-id="<?php echo $avatar['Id_avatar']; ?>" data-img="../../img/avatares/<?php echo $avatar['Foto']; ?>">
                    <img src="../../img/avatares/<?php echo $avatar['Foto']; ?>" alt="<?php echo $avatar['Nom_avatar']; ?>">
                    <span><?php echo $avatar['Nom_avatar']; ?></span>
                </div>
            <?php } ?>
        </div>
    </div>

    <div id="modal-mundo" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" id="cerrar-mundo">&times;</span>
            <h2>MUNDOS DISPONIBLES</h2>
            <?php foreach ($mundos as $mundo) { ?>
                <!-- LA ETIQUETA DATA-ID ASUME EL ID QUE POSEE CADA CAJITA CON EL AVATAR -->
                <div class="opcion-lista" data-id="<?php echo $mundo['Id_mundo']; ?>" data-img="../../img/mundos/<?php echo $mundo['Foto']; ?>">
                    <img src="../../img/mundos/<?php echo $mundo['Foto']; ?>" alt="<?php  ?>">
                    <span><?php echo $mundo['Nom_mundo']; ?></span>
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
document.addEventListener("DOMContentLoaded", function() {
    let selectedAvatarId = null;
    let selectedMundoId = null;

    function activarModal(boton, modal, cerrar, imgSeleccionada, isAvatar) {
        boton.addEventListener("click", function() { modal.style.display = "block"; });
        cerrar.addEventListener("click", function() { modal.style.display = "none"; });
        modal.querySelectorAll(".opcion-lista").forEach(item => {
            item.addEventListener("click", function() {
                imgSeleccionada.src = this.dataset.img;

                // Almacenar el ID del avatar o mundo seleccionado
                if (isAvatar) {
                    selectedAvatarId = this.dataset.id; // Asume que cada opción tiene un data-id con el ID del avatar
                } else {
                    selectedMundoId = this.dataset.id; // Asume que cada opción tiene un data-id con el ID del mundo
                }

                modal.style.display = "none";
            });
        });
    }

    activarModal(
        document.getElementById("seleccionar-avatar"),
        document.getElementById("modal-avatar"),
        document.getElementById("cerrar-avatar"),
        document.getElementById("avatar-seleccionado"),
        true // Indica que es el modal de avatares
    );

    activarModal(
        document.getElementById("seleccionar-mundo"),
        document.getElementById("modal-mundo"),
        document.getElementById("cerrar-mundo"),
        document.getElementById("mundo-seleccionado"),
        false // Indica que es el modal de mundos
    );

    // Manejar el clic en el botón "Guarda Cambios"
    document.getElementById("submit").addEventListener("click", function(event) {
        event.preventDefault(); // Evitar que el formulario se envíe de forma tradicional

        if (selectedAvatarId && selectedMundoId) {
            // Enviar los datos al servidor usando AJAX
            fetch('update_selection.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    avatarId: selectedAvatarId,
                    mundoId: selectedMundoId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Cambios guardados correctamente");
                } else {
                    alert("Error al guardar los cambios");
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        } else {
            alert("Por favor, selecciona un avatar y un mundo antes de guardar los cambios.");
        }
    });
});
    </script>

    <a href="index.php">
    <input type="submit" id="submit" name="submit" class="btn-submit" value="Guarda Cambios">
    <!-- FALTAAAAAA GUARDAR O EN ESTE CASO UPDATEAR LOS CAMPOSSSS -->
    </a>
</body>
</html>

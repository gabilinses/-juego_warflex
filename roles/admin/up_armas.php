<?php
include('header.php');
require_once('../../database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
$sql = $con->prepare("SELECT * FROM tipo_arma");
$sql->execute();
$fila = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Imagen</title>
    <style>
        .container {
            background-color: snow;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin-top: 10vh;
            margin-left: auto;
            margin-right: auto;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="file"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Formulario Para Subir Imagen De Armas</h1>
        <form id="registroFormArma" enctype="multipart/form-data" method="POST">

            <!-- Campo para el nombre de la imagen -->
            <label for="nombre">Nombre Imagen</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="tipo_arma">Tipo de Arma:</label>
                <select id="tipo_arma" name="tipo_arma" required>
                                    <?php foreach ($fila as $arma): ?>
                                        <option value="<?php echo $arma['Id_tipo_arma']; ?>"
                                            <?php echo ($arma['Id_tipo_arma']); ?>>
                                            <?php echo $arma['nom_tipo_arma']; ?>
                                        </option>
                                    <?php endforeach; ?>
                </select>

            <!-- Campo para subir imagen -->
            <label for="imagen">Subir Imagen (Solo PNG):</label>
            <input type="file" id="imagen" name="imagen" accept=".png" required>
            <div class="error-message" id="errorImagen"></div>

            <!-- Botón de guardar -->
            <input type="submit" value="guardarimg">
        </form>
    </div>

    <script>
        const form = document.getElementById('registroFormArma');
    
         //async function (event)) de JavaScript sirve para definir funciones asíncronas. Esto permite que un programa pueda iniciar una tarea larga y seguir respondiendo a otros eventos mientras esa tarea se ejecuta.  
        
        form.addEventListener('submit', async function (event) {
            event.preventDefault();
    
            const formData = new FormData();
            formData.append('nombre', document.getElementById('nombre').value);
            formData.append('tipo_arma', document.getElementById('tipo_arma').value);
            formData.append('imagen', document.getElementById('imagen').files[0]);
    
            try {
                const response = await fetch('uploads/guardar.php', {
                    method: 'POST',
                    body: formData,
                });
                
                //espera la respuesta que viene de guardar.php para mostrar el mensaje  
                const result = await response.json();

                // si recibe un msj por parte de echo enconde_json los muestra viene de guardar.php 

                if (result.message) {
                    alert(result.message); // Mostrar mensaje de éxito
                    limpiarFormulario();   // Limpiar el formulario
                } else if (result.error) {
                    alert(result.error);
                }
            } catch (error) {
                console.error(error);
                alert('Error al conectar con el servidor.');
            }

            // Función para limpiar el formulario
                function limpiarFormulario() {
                    document.getElementById('nombre').value = '';
                    document.getElementById('tipo_arma').value = '';
                    document.getElementById('imagen').value = ''; // Limpiar el campo de archivo
                }
        });
    </script>
</body>
</html>
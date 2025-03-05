<?php

include ('header.php');


$sql = $con->prepare("SELECT * FROM usuario");
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
    background-color:snow;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
    margin-top: 10vh;
    margin-left: 60vh;
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
        <h1>Formulario Para Subir Imagen</h1>
        <form id="registroForm" enctype="multipart/form-data">

            <!-- Campo de cédula -->
            <label for="cedula">Nombre Imagen</label>
            <input type="text" id="cedula" name="cedula" required>

            <!-- Campo para subir imagen -->
            <label for="imagen">Subir Imagen (Solo JPG, máximo 200 KB):</label>
            <input type="file" id="imagen" name="imagen" accept=".jpg" required>
            <div class="error-message" id="errorImagen"></div>

            <!-- Botón de guardar -->
            <input type="submit" value="Guardar">

        </form>
    </div>
</body>
</html>

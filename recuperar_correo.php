
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Recuperar</title>
</head>
<body>
    <div class="cajita">
        <div class="login">
            <h1>RECUPERAR CONTRASEÑA</h1>
                <form action="config/env-correo.php" method="POST" autocomplete="off" >
                <label for="user">Correo Electronico</label>
                <input type="text" id="correo_recupera" name="correo">
                <input type="submit" id="submit" name="submit" class="btn-submit" value="Enviar Correo">
                <p>¿ Volver Al Menu... ?<br><a href="index.php">¡Click Aqui!</a></p>
            </form>
        </div>
    </div>
    <video autoplay loop muted>
        <source src="video/video3.mp4" type="video/mp4">
    </video>
    <div class="capa"></div>
</body>
</html>
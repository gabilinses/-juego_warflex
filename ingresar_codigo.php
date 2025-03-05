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
                <form action="verificar_codigo.php" method="POST" autocomplete="off" >
                <label for="user">Ingresa El Codigo Enviado</label>
                <input type="text" id="codigo" name="codigo">
                <input type="submit" id="submit" name="submit" class="btn-submit" value="Enviar Codigo">
            </form>
        </div>
    </div>
    <video autoplay loop muted>
        <source src="video/video1.mp4" type="video/mp4">
    </video>
    <div class="capa"></div>
</body>
</html>
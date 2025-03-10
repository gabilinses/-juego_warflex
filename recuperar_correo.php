
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>Recuperar</title>
</head>
<style>

body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f0f0f0;
    overflow: hidden;
    position: relative;
}

video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -1;
}

.capa {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: -1;
}

.cajita {
    display: flex;

    align-items: center;
    width: 100%;
    height: 60%;
    z-index: 1;
}

    .login {
    width: 60vh;
    height: 50vh;
    padding: 30px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    background: transparent;
    color: #fff;
    border-radius: 5%;
    border: 2px solid rgba(255, 255, 255, .2);
    backdrop-filter: blur(8px);
    text-align: center;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    min-height: 30vh;
    position: relative;
    z-index: 3;
}

.login h1 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #ffffff;
}

.login form {
    display: flex;
    flex-direction: column;
}

.login label {
    margin-bottom: 5px;
    font-weight: bold;
    color: #ffffff;
}

.login input {
    margin-bottom: 12px;
    padding: 10px;
    border: 1px solid #ffffff;
    border-radius: 17px;
    font-size: 16px;
}

.login .btn-submit {
    margin-top: 30px;
    background-color: #007bff;
    color: white;
    padding: 8px 18px;
    border: none;
    border-radius: 17px;
    font-size: 16px;
    cursor: pointer;
    font-size: 14px;

}

.login .btn-submit:hover {
    background-color: #0056b3;
}

.login p {
    margin-top: 15px;
    font-size: 14px;
    color: #ffffff;
}

.login p a {
    color: #007bff;
    text-decoration: none;
}

.login p a:hover {
    text-decoration: underline;
}
</style>
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
     <?php
         if (isset($_GET['message'])) {
             $message = $_GET['message'];
             if ($message == 'ok') {
                 echo "<script>alert('El correo fue enviado correctamente.');</script>";
             } elseif ($message == 'error') {
                 echo "<script>alert('Hubo un error al enviar el correo.');</script>";
             }
        }
     ?>
    <video autoplay loop muted>
        <source src="video/video3.mp4" type="video/mp4">
    </video>
    <div class="capa"></div>
</body>
</html>
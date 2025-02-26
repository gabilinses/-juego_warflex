<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Login</title>
</head>
<body>
    <div class="login">
        <h1>WARFLEX</h1>
        <h2>Login</h2>
        <form action="" method="POST" autocomplete="off" >
            <label for="user">Username</label>
            <input type="text" id="user" name="user">
            <label for="contra">Contraseña</label>
            <input type="password" id="contra" name="contra">
            <input type="submit" id="submit" name="submit" class="btn-submit" value="Iniciar Sesion">
            <p>¿Has olvidado la contraseña?</p>
            <p>¿Aun no tienes una cuenta? <a href="registro.php">Registrate!</a></p>
        </form>
    </div>
</body>
</html>
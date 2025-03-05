<!-- APARTADO PARA DESTRUIR LA SESION DEL USUARIO -->
<?php

session_start();
unset($_SESSION['username']);
unset($_SESSION['correo']);
session_destroy();
session_write_close();
header("Location:../index.php");
?>
<!-- FIN APARTADO PARA DESTRUIR LA SESION DEL USUARIO -->
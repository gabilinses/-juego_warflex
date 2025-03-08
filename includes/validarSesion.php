<?php
if (!isset($_SESSION['username'])){
unset($_SESSION['Id_rol']);
$_SESSION = array();
session_destroy();
session_write_close();
echo "<script> alert ('¡Credenciales Caducadas!') </script>";
echo "<script> window.location = '../../index.php' </script>";
}

?>

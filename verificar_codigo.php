<?php

require_once('database/conexion.php');
$conex = new Database;
$con = $conex->conectar();
session_start();

header("Location: nueva_contra.php")
?>
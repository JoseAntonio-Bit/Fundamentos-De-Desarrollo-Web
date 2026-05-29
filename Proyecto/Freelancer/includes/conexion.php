<?php
$host     = "localhost";
$usuario  = "root";
$password = "";
$base     = "freelancer";

$conexion = new mysqli($host, $usuario, $password, $base);

if ($conexion->connect_error) {
    die("Error de conexion: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");
?>
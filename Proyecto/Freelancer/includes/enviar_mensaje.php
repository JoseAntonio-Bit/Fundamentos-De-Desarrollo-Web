<?php
header("Content-Type: application/json");
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["exito" => false, "mensaje" => "Metodo no permitido"]);
    exit;
}

$nombre   = trim($_POST["nombre"] ?? "");
$email    = trim($_POST["email"] ?? "");
$servicio = trim($_POST["servicio"] ?? "");
$mensaje  = trim($_POST["mensaje"] ?? "");

if (empty($nombre) || empty($email) || empty($mensaje)) {
    echo json_encode(["exito" => false, "mensaje" => "Completa los campos obligatorios"]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["exito" => false, "mensaje" => "Email no valido"]);
    exit;
}

$stmt = $conexion->prepare(
    "INSERT INTO mensaje (nombre, correo, asunto, mensaje) VALUES (?, ?, ?, ?)"
);

$stmt->bind_param("ssss", $nombre, $email, $servicio, $mensaje);

if ($stmt->execute()) {
    echo json_encode(["exito" => true, "mensaje" => "Mensaje enviado correctamente"]);
} else {
    echo json_encode(["exito" => false, "mensaje" => "Error al guardar"]);
}

$stmt->close();
$conexion->close();
?>
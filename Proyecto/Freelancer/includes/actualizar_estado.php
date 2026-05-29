<?php
require 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data['id']);
$estado = intval($data['estado']);

$sql = "UPDATE mensaje SET leido = $estado WHERE idMensaje = $id";
$res = $conexion->query($sql);

echo json_encode(['success' => $res]);
?>
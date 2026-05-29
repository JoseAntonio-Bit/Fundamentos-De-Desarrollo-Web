<?php
header("Content-Type: application/json");
require_once "conexion.php";

$id = intval($_GET["id"] ?? 0);

if ($id <= 0) {
    echo json_encode(["exito" => false, "mensaje" => "ID invalido"]);
    exit;
}

$stmt = $conexion->prepare(
    "SELECT 
        p.idProyecto,
        p.titulo,
        p.descripcion,
        p.imagen,
        p.creado,
        c.idCliente,
        c.nombreContacto
     FROM proyectos p
     LEFT JOIN clientes c ON p.idCliente = c.idCliente
     WHERE p.idProyecto = ? AND p.eliminado IS NULL
     LIMIT 1"
);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$proyecto  = $resultado->fetch_assoc();

if ($proyecto) {
    echo json_encode(["exito" => true, "proyecto" => $proyecto]);
} else {
    echo json_encode(["exito" => false, "mensaje" => "Proyecto no encontrado"]);
}

$stmt->close();
$conexion->close();
?>

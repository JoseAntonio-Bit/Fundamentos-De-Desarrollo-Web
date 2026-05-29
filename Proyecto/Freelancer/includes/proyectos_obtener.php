<?php
header("Content-Type: application/json");
require_once "conexion.php";

// Trae todos los proyectos activos con el nombre del cliente via JOIN
$sql = "SELECT 
            p.idProyecto,
            p.titulo,
            p.descripcion,
            p.imagen,
            p.creado,
            c.idCliente,
            c.nombreContacto
        FROM proyectos p
        LEFT JOIN clientes c ON p.idCliente = c.idCliente
        WHERE p.eliminado IS NULL
        ORDER BY p.creado DESC";

$resultado = $conexion->query($sql);

if (!$resultado) {
    echo json_encode(["exito" => false, "mensaje" => "Error al obtener proyectos"]);
    exit;
}

$proyectos = [];
while ($fila = $resultado->fetch_assoc()) {
    $proyectos[] = $fila;
}

echo json_encode(["exito" => true, "proyectos" => $proyectos]);
$conexion->close();
?>

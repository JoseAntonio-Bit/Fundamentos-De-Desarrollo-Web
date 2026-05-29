<?php
header("Content-Type: application/json");
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["exito" => false, "mensaje" => "Metodo no permitido"]);
    exit;
}

$id = intval($_POST["id"] ?? 0);

if ($id <= 0) {
    echo json_encode(["exito" => false, "mensaje" => "ID invalido"]);
    exit;
}

// Soft delete: solo marcamos eliminado = NOW(), no borramos el registro
// La imagen en disco se conserva (puedes agregar unlink si prefieres borrarla)
$stmt = $conexion->prepare(
    "UPDATE proyectos SET eliminado = NOW() 
     WHERE idProyecto = ? AND eliminado IS NULL"
);
$stmt->bind_param("i", $id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode(["exito" => true, "mensaje" => "Proyecto eliminado correctamente"]);
} else {
    echo json_encode(["exito" => false, "mensaje" => "No se pudo eliminar el proyecto"]);
}

$stmt->close();
$conexion->close();
?>

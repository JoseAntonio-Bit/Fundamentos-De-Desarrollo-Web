<?php
header("Content-Type: application/json");
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["exito" => false, "mensaje" => "Metodo no permitido"]);
    exit;
}

// ── Leer y validar campos ────────────────────────────
$id            = intval(trim($_POST["id"]          ?? 0));
$titulo        = trim($_POST["titulo"]             ?? "");
$descripcion   = trim($_POST["descripcion"]        ?? "");
$nombreCliente = trim($_POST["cliente"]            ?? "");

if ($id <= 0 || empty($titulo) || empty($descripcion) || empty($nombreCliente)) {
    echo json_encode(["exito" => false, "mensaje" => "Datos incompletos"]);
    exit;
}

// ── Obtener imagen y cliente actuales ────────────────
$stmtActual = $conexion->prepare(
    "SELECT imagen, idCliente FROM proyectos 
     WHERE idProyecto = ? AND eliminado IS NULL"
);
$stmtActual->bind_param("i", $id);
$stmtActual->execute();
$actual = $stmtActual->get_result()->fetch_assoc();
$stmtActual->close();

if (!$actual) {
    echo json_encode(["exito" => false, "mensaje" => "Proyecto no encontrado"]);
    exit;
}

$nombreImagen = $actual["imagen"]; // Conservar la imagen actual por defecto

// ── Procesar nueva imagen si se subió ────────────────
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {

    $tiposPermitidos = ["image/jpeg", "image/png", "image/webp"];
    $tipoReal        = mime_content_type($_FILES["imagen"]["tmp_name"]);

    if (!in_array($tipoReal, $tiposPermitidos)) {
        echo json_encode(["exito" => false, "mensaje" => "Tipo de imagen no permitido"]);
        exit;
    }

    if ($_FILES["imagen"]["size"] > 2 * 1024 * 1024) {
        echo json_encode(["exito" => false, "mensaje" => "La imagen no debe superar 2MB"]);
        exit;
    }

    // Borrar imagen anterior del disco
    if ($nombreImagen && file_exists("../img/" . $nombreImagen)) {
        unlink("../img/" . $nombreImagen);
    }

    $extension    = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
    $nombreImagen = uniqid("img_") . "." . $extension;
    $destino      = "../img/" . $nombreImagen;

    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino)) {
        echo json_encode(["exito" => false, "mensaje" => "Error al guardar la imagen"]);
        exit;
    }
}

// ── Buscar cliente o crear uno nuevo ────────────────
$stmtBuscar = $conexion->prepare(
    "SELECT idCliente FROM clientes 
     WHERE nombreContacto = ? AND eliminado IS NULL 
     LIMIT 1"
);
$stmtBuscar->bind_param("s", $nombreCliente);
$stmtBuscar->execute();
$resCliente = $stmtBuscar->get_result();
$stmtBuscar->close();

if ($resCliente->num_rows > 0) {
    $idCliente = $resCliente->fetch_assoc()["idCliente"];
} else {
    $stmtCliente = $conexion->prepare(
        "INSERT INTO clientes (nombreContacto, creado) VALUES (?, NOW())"
    );
    $stmtCliente->bind_param("s", $nombreCliente);
    $stmtCliente->execute();
    $idCliente = $conexion->insert_id;
    $stmtCliente->close();
}

// ── Actualizar proyecto ──────────────────────────────
$stmt = $conexion->prepare(
    "UPDATE proyectos 
     SET titulo = ?, descripcion = ?, imagen = ?, idCliente = ?, modificado = NOW()
     WHERE idProyecto = ? AND eliminado IS NULL"
);
$stmt->bind_param("sssii", $titulo, $descripcion, $nombreImagen, $idCliente, $id);

if ($stmt->execute()) {
    echo json_encode([
        "exito"   => true,
        "mensaje" => "Proyecto actualizado correctamente",
        "imagen"  => $nombreImagen
    ]);
} else {
    echo json_encode(["exito" => false, "mensaje" => "Error al actualizar el proyecto"]);
}

$stmt->close();
$conexion->close();
?>

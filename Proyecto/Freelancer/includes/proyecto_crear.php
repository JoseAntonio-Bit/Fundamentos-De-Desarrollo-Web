<?php
header("Content-Type: application/json");
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["exito" => false, "mensaje" => "Metodo no permitido"]);
    exit;
}

// ── Leer y validar campos ────────────────────────────
$titulo        = trim($_POST["titulo"]      ?? "");
$descripcion   = trim($_POST["descripcion"] ?? "");
$nombreCliente = trim($_POST["cliente"]     ?? "");

if (empty($titulo) || empty($descripcion) || empty($nombreCliente)) {
    echo json_encode(["exito" => false, "mensaje" => "Completa todos los campos obligatorios"]);
    exit;
}

// ── Manejar imagen ───────────────────────────────────
$nombreImagen = null;

if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {

    $tiposPermitidos = ["image/jpeg", "image/png", "image/webp"];
    $tipoReal        = mime_content_type($_FILES["imagen"]["tmp_name"]);

    if (!in_array($tipoReal, $tiposPermitidos)) {
        echo json_encode(["exito" => false, "mensaje" => "Tipo de imagen no permitido. Usa JPG, PNG o WEBP"]);
        exit;
    }

    if ($_FILES["imagen"]["size"] > 2 * 1024 * 1024) {
        echo json_encode(["exito" => false, "mensaje" => "La imagen no debe superar 2MB"]);
        exit;
    }

    // Nombre unico para evitar colisiones
    $extension    = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
    $nombreImagen = uniqid("img_") . "." . $extension;

    // Ruta relativa desde includes/ hacia img/
    $destino = "../img/" . $nombreImagen;

    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino)) {
        echo json_encode(["exito" => false, "mensaje" => "Error al guardar la imagen en el servidor"]);
        exit;
    }

} else if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] !== UPLOAD_ERR_NO_FILE) {
    // Error real de subida (distinto a "no se eligió archivo")
    echo json_encode(["exito" => false, "mensaje" => "Error al subir la imagen (codigo: " . $_FILES["imagen"]["error"] . ")"]);
    exit;
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
    // Cliente ya existe
    $idCliente = $resCliente->fetch_assoc()["idCliente"];
} else {
    // Crear nuevo cliente
    $stmtCliente = $conexion->prepare(
        "INSERT INTO clientes (nombreContacto, creado) VALUES (?, NOW())"
    );
    $stmtCliente->bind_param("s", $nombreCliente);
    $stmtCliente->execute();
    $idCliente = $conexion->insert_id;
    $stmtCliente->close();
}

// ── Insertar proyecto ────────────────────────────────
$stmt = $conexion->prepare(
    "INSERT INTO proyectos (titulo, descripcion, imagen, idCliente, creado) 
     VALUES (?, ?, ?, ?, NOW())"
);
$stmt->bind_param("sssi", $titulo, $descripcion, $nombreImagen, $idCliente);

if ($stmt->execute()) {
    echo json_encode([
        "exito"      => true,
        "mensaje"    => "Proyecto creado correctamente",
        "idProyecto" => $conexion->insert_id,
        "imagen"     => $nombreImagen
    ]);
} else {
    // Si hubo error al insertar, borrar la imagen que ya subimos
    if ($nombreImagen && file_exists("../img/" . $nombreImagen)) {
        unlink("../img/" . $nombreImagen);
    }
    echo json_encode(["exito" => false, "mensaje" => "Error al guardar el proyecto en la base de datos"]);
}

$stmt->close();
$conexion->close();
?>

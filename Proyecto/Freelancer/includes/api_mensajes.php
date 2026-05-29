<?php
header('Content-Type: application/json');
require 'conexion.php'; // Aquí usa tu variable $conexion

// 1. Obtener estadísticas
$stats = ['total' => 0, 'pendiente' => 0, 'leido' => 0, 'respondido' => 0];

// Usamos $conexion (tu variable)
$queryStats = "SELECT leido, COUNT(*) as cantidad FROM mensaje WHERE eliminado is NULL GROUP BY leido";
$resStats = $conexion->query($queryStats);

if ($resStats) {
    while ($row = $resStats->fetch_assoc()) {
        $stats['total'] += $row['cantidad'];
        if ($row['leido'] == 0) $stats['pendiente'] = $row['cantidad'];
        elseif ($row['leido'] == 1) $stats['leido'] = $row['cantidad'];
        elseif ($row['leido'] == 2) $stats['respondido'] = $row['cantidad'];
    }
}

// 2. Obtener mensajes
$filtro = $_GET['filtro'] ?? 'todos';
$busqueda = $conexion->real_escape_string($_GET['busqueda'] ?? '');

$sql = "SELECT * FROM mensaje WHERE eliminado is NULL";
if ($filtro !== 'todos') {
    $estado = ($filtro == 'pendiente') ? 0 : ($filtro == 'leido' ? 1 : 2);
    $sql .= " AND leido = $estado";
}
if (!empty($busqueda)) {
    $sql .= " AND (nombre LIKE '%$busqueda%' OR correo LIKE '%$busqueda%' OR mensaje LIKE '%$busqueda%')";
}

$result = $conexion->query($sql);
$mensajes = ($result) ? $result->fetch_all(MYSQLI_ASSOC) : [];

echo json_encode(['stats' => $stats, 'data' => $mensajes]);
?>
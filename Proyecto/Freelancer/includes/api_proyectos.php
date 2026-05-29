<?php
header('Content-Type: application/json');
require 'conexion.php';

// 1. Obtener totales
$resProyectos = $conexion->query("SELECT COUNT(*) as total FROM proyectos WHERE eliminado IS NULL");
$totalProyectos = $resProyectos->fetch_assoc()['total'];

$resClientes = $conexion->query("SELECT COUNT(*) as total FROM clientes WHERE eliminado IS NULL");
$totalClientes = $resClientes->fetch_assoc()['total'];

// 2. Obtener proyectos con datos del cliente (JOIN)
$sql = "SELECT p.*, c.nombreContacto 
        FROM proyectos p 
        LEFT JOIN clientes c ON p.idCliente = c.idCliente 
        WHERE p.eliminado IS NULL";
$result = $conexion->query($sql);
$proyectos = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

echo json_encode([
    'stats' => ['proyectos' => $totalProyectos, 'clientes' => $totalClientes],
    'data' => $proyectos
]);
?>
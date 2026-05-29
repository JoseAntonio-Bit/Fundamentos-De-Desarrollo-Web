<?php
session_start();
require 'conexion.php'; // Asegúrate de que la ruta sea correcta

// 1. Recibir datos del formulario
$correo = $_POST['correo'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($correo) || empty($password)) {
    die("Por favor completa todos los campos.");
}

// 2. Buscar al usuario y traer su rol con un JOIN
$sql = "SELECT u.idUsuario, u.nombre, u.password, r.nombre as nombre_rol 
        FROM usuarios u 
        JOIN roles r ON u.idRol = r.idRol 
        WHERE u.correo = ? AND u.eliminado IS NULL";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    // 3. Verificar la contraseña (usando password_verify)
    if ($password === $usuario['password']) {
        
        // 4. Iniciar sesión correctamente
        $_SESSION['usuario_id'] = $usuario['idUsuario'];
        $_SESSION['nombre_usuario'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['nombre_rol']; // Guarda 'administrador' o 'usuario'

        // 5. Redireccionar según el rol
        if ($_SESSION['rol'] === 'administrador') {
            header('Location: ../panelAdmin.php');
        } else {
            header('Location: ../index.php');
        }
        exit;
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}
?>
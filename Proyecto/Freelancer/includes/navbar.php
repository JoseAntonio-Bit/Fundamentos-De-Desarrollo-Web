<?php
// Si no hay sesión iniciada, el rol es 'invitado'
$rol = $_SESSION['rol'] ?? 'invitado';
?>

<nav class="navegacion-principal contenedor">
    <a href="index.php">Inicio</a>
    <a href="sobremi.php">Sobre mí</a>
    <a href="clientes.php">Clientes</a>
    <a href="contacto.php">Contacto</a>

    <?php if ($rol === 'administrador'): ?>
        <a href="admin_proyectos.php">Panel Proyectos</a>
        <a href="panelAdmin.php">Panel Mensajes</a>
        <a href="includes/logout.php">Cerrar Sesión (Admin)</a>
        
    <?php elseif ($rol === 'usuario'): ?>
        <a href="includes/logout.php">Cerrar Sesión</a>
        
    <?php else: ?>
        <a href="login.php">Iniciar Sesión</a>
    <?php endif; ?>
</nav>
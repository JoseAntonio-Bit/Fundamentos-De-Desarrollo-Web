<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión – Jose Antonio</title>
    <link rel="stylesheet" href="./css/loginStyles.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>

    <main class="login-container">
        <form class="login-form" action="includes/validar_login.php" method="POST">
            <div class="login-header">INGRESA TUS CREDENCIALES</div>
            
            <div class="input-group">
                <label>Correo electrónico</label>
                <div class="input-field">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="email" name="correo" placeholder="tu@correo.com" required>
                </div>
            </div>

            <div class="input-group">
                <label>Contraseña</label>
                <div class="input-field">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Tu contraseña" required>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesión
            </button>
        </form>
    </main>
</body>
</html>
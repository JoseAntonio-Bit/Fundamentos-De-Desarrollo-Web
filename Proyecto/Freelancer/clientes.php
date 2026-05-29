<?php
session_start();
// Esto es obligatorio para que el PHP sepa quién es el usuario
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes – Jose Antonio</title>
    <link rel="preload" href="./css/normalize.css" as="style">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krub:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="preload" href="./css/clientesStyles.css" as="style">
    <link rel="stylesheet" href="./css/clientesStyles.css">
</head>
<body>

    <!-- HEADER -->
    <header>
        <h1 class="titulo">Jose Antonio <span>Freelancer</span></h1>
    </header>

    <!-- NAV -->
    <div class="nav-bg">
        <?php include 'includes/navbar.php'; ?>
    </div>

    <!-- HERO BANNER -->
    <section class="hero-banner">
        <h2 class="hero-banner__titulo">Clientes y Proyectos</h2>
        <p class="hero-banner__subtitulo">Trabajos recientes</p>
    </section>

    <!-- ESTADÍSTICAS -->
    <section class="seccion contenedor">
        <div class="estadisticas">

                <div class="stat sombra">
                    <div class="stat__icono"><i class="fa-solid fa-circle-check"></i></div>
                    <p class="stat__numero" id="stat-proyectos">0</p> <p class="stat__label">Proyectos completados</p>
                </div>

                <div class="stat sombra">
                    <div class="stat__icono"><i class="fa-solid fa-users"></i></div>
                    <p class="stat__numero" id="stat-clientes">0</p> <p class="stat__label">Clientes satisfechos</p>
                </div>

            <div class="stat sombra">
                <div class="stat__icono"><i class="fa-solid fa-clock"></i></div>
                <p class="stat__numero">3+</p>
                <p class="stat__label">Años de experiencia</p>
            </div>

        </div>
    </section>



  <section class="seccion contenedor">
        <h2 class="seccion__titulo--izq">Proyectos Destacados</h2>
    
        <div class="proyectos" id="contenedor-proyectos">
        </div>
    </section>


    <!-- TESTIMONIOS -->
    <section class="seccion contenedor">
        <h2 class="seccion__titulo">Lo que dicen mis clientes</h2>
        <div class="testimonios">

            <div class="testimonio sombra">
                <div class="testimonio__estrellas">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <p class="testimonio__texto">"Excelente trabajo, Jose Antonio entendio perfectamente lo que necesitaba para mi tienda. Muy profesional y puntual."</p>
                <p class="testimonio__nombre">Maria Garcia</p>
                <p class="testimonio__empresa">ModaStyle</p>
            </div>

            <div class="testimonio sombra">
                <div class="testimonio__estrellas">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <p class="testimonio__texto">"Mi portfolio quedo increible. Recibo muchos mas clientes gracias al nuevo sitio web. Totalmente recomendado."</p>
                <p class="testimonio__nombre">Carlos Rodriguez</p>
                <p class="testimonio__empresa">Studio Photo</p>
            </div>

            <div class="testimonio sombra">
                <div class="testimonio__estrellas">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <p class="testimonio__texto">"El sistema de reservas ha mejorado mucho la organizacion de mi negocio. Muy satisfecha con el resultado."</p>
                <p class="testimonio__nombre">Ana Martinez</p>
                <p class="testimonio__empresa">Restaurante El Roble</p>
            </div>

        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <h2 class="cta__titulo">¿Quieres trabajar conmigo?</h2>
        <p class="cta__subtitulo">Estoy listo para ayudarte a llevar tu proyecto al siguiente nivel.</p>
        <a href="#" class="boton">Contactame</a>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer__redes">
            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
        </div>
        <p class="footer__copy">© 2026 Jose Antonio. Todos los derechos reservados.</p>
    </footer>

<script>
    async function cargarProyectos() {
    try {
        const res = await fetch('includes/api_proyectos.php');
        const json = await res.json();

        // Actualizar estadísticas
        document.getElementById('stat-proyectos').textContent = json.stats.proyectos + '+';
        document.getElementById('stat-clientes').textContent = json.stats.clientes + '+';

        // Renderizar proyectos
        const contenedor = document.getElementById('contenedor-proyectos');
        contenedor.innerHTML = ''; // Limpiar estáticos

json.data.forEach(p => {
    // Si en tu BD solo se guarda el nombre (ej: img_6a18964ddc638.jpeg)
    // concatenamos la carpeta 'img/' que es donde están físicamente
    const rutaImagen = 'img/' + p.imagen; 

    contenedor.innerHTML += `
        <div class="proyecto sombra">
            <div class="proyecto__imagen" style="background-image: url('${rutaImagen}'); background-size: cover; background-position: center;">
                ${!p.imagen ? 'Sin imagen' : ''}
            </div>
            <div class="proyecto__info">
                <h3 class="proyecto__nombre">${p.titulo}</h3>
                <p class="proyecto__desc">${p.descripcion}</p>
                <a href="#" class="proyecto__link">
                    Ver proyecto <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            </div>
        </div>
    `;
});
    } catch (err) {
        console.error("Error al cargar proyectos:", err);
    }
}

cargarProyectos();
</script>

</body>
</html>

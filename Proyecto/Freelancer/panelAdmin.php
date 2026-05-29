<?php
session_start();
// Esto es obligatorio para que el PHP sepa quién es el usuario
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin – Jose Antonio</title>
    <link rel="preload" href="./css/normalize.css" as="style">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krub:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="preload" href="./css/adminStyles.css" as="style">
    <link rel="stylesheet" href="./css/adminStyles.css">
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
        <h2 class="hero-banner__titulo">Panel de Administracion</h2>
        <p class="hero-banner__subtitulo">Gestiona los mensajes recibidos del formulario de contacto</p>
    </section>

    <!-- ESTADÍSTICAS -->
    <section class="seccion contenedor">
        <div class="stats-grid">

            <!-- Cada stat tendrá un data-tipo para que PHP/JS pueda inyectar el número -->
            <div class="stat-card sombra">
                <div class="stat-card__icono stat-card__icono--gris">
                    <i class="fa-regular fa-message"></i>
                </div>
                <!-- PHP: echo $total_mensajes -->
                <p class="stat-card__numero" id="stat-total">0</p>
                <p class="stat-card__label">Total Mensajes</p>
            </div>

            <div class="stat-card sombra">
                <div class="stat-card__icono stat-card__icono--amarillo">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <!-- PHP: echo $total_pendientes -->
                <p class="stat-card__numero" id="stat-pendientes">0</p>
                <p class="stat-card__label">Pendientes</p>
            </div>

            <div class="stat-card sombra">
                <div class="stat-card__icono stat-card__icono--teal">
                    <i class="fa-regular fa-eye"></i>
                </div>
                <!-- PHP: echo $total_leidos -->
                <p class="stat-card__numero" id="stat-leidos">0</p>
                <p class="stat-card__label">Leidos</p>
            </div>

            <div class="stat-card sombra">
                <div class="stat-card__icono stat-card__icono--verde">
                    <i class="fa-regular fa-circle-check"></i>
                </div>
                <!-- PHP: echo $total_respondidos -->
                <p class="stat-card__numero" id="stat-respondidos">0</p>
                <p class="stat-card__label">Respondidos</p>
            </div>

        </div>
    </section>

    <!-- TABLA DE MENSAJES -->
    <section class="seccion contenedor">
        <div class="tabla-card sombra">

            <!-- Cabecera: título + buscador + filtro -->
            <div class="tabla-header">
                <h3 class="tabla-header__titulo">MENSAJES RECIBIDOS</h3>
                <div class="tabla-header__controles">
                    <!--
                        BUSCADOR: al implementar la lógica conecta este input
                        con un fetch o con un submit de formulario PHP
                        id="buscador"
                    -->
                    <input
                        class="tabla-header__buscador"
                        type="text"
                        id="buscador"
                        placeholder="Buscar..."
                    >
                    <!--
                        FILTRO: al cambiar el value, filtra la tabla
                        Valores posibles: "todos" | "pendiente" | "leido" | "respondido"
                        id="filtro-estado"
                    -->
                    <select class="tabla-header__filtro" id="filtro-estado">
                        <option value="todos">&#9663; Todos</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="leido">Leido</option>
                        <option value="respondido">Respondido</option>
                    </select>
                </div>
            </div>

            <!-- Tabla -->
            <div class="tabla-wrap">
                <table class="tabla" id="tabla-mensajes">
                    <thead>
                        <tr>
                            <th><i class="fa-regular fa-user"></i> Nombre</th>
                            <th><i class="fa-regular fa-envelope"></i> Correo</th>
                            <th><i class="fa-regular fa-message"></i> Mensaje</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-mensajes">
                        
                    </tbody>
                </table>
            </div>
            <!-- Mensaje cuando no hay resultados -->
            <p class="tabla-vacia" id="tabla-vacia" style="display:none;">
                No se encontraron mensajes.
            </p>
        </div>
    </section>

    <!--
        MODAL VER MENSAJE
        Muestra el detalle completo de un mensaje al hacer clic en el ojo.
        Al implementar la lógica: abre este modal y rellena los campos
        con los datos de la fila seleccionada (o con una petición fetch).
    -->
    <div class="modal-overlay" id="modal-overlay" style="display:none;">
        <div class="modal sombra">
            <div class="modal__header">
                <h3 class="modal__titulo">Detalle del mensaje</h3>
                <button class="modal__cerrar" id="modal-cerrar">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal__body">
                <p><strong>Nombre:</strong> <span id="modal-nombre"></span></p>
                <p><strong>Correo:</strong> <span id="modal-correo"></span></p>
                <p><strong>Servicio:</strong> <span id="modal-servicio"></span></p>
                <p><strong>Fecha:</strong> <span id="modal-fecha"></span></p>
                <p><strong>Estado:</strong> <span id="modal-estado"></span></p>
                <hr class="modal__separador">
                <p class="modal__mensaje-label"><strong>Mensaje:</strong></p>
                <p class="modal__mensaje-texto" id="modal-mensaje"></p>
            </div>

            <div class="modal__acciones" style="margin-top: 20px; display: flex; gap: 10px;">
                <button class="badge badge--pendiente" onclick="cambiarEstado(0)">Pendiente</button>
                <button class="badge badge--leido" onclick="cambiarEstado(1)">Leído</button>
                <button class="badge badge--respondido" onclick="cambiarEstado(2)">Respondido</button>
            </div>
        </div>
    </div>

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

    <!--
        LÓGICA DE FILTRO Y BUSCADOR (solo UI, sin PHP todavía)
        Cuando conectes PHP, puedes mantener este script o reemplazarlo
        por un fetch que traiga los datos filtrados del servidor.
    -->
<script>
    let jsonGlobal = { data: [], stats: { total: 0, pendiente: 0, leido: 0, respondido: 0 } };
    let mensajeSeleccionadoId = null;

    async function cargarDatos() {
        const filtro = document.getElementById('filtro-estado').value;
        const busqueda = document.getElementById('buscador').value;

        try {
            const res = await fetch(`includes/api_mensajes.php?filtro=${filtro}&busqueda=${busqueda}`);
            jsonGlobal = await res.json(); // Ahora usamos jsonGlobal

            // 1. Actualizar contadores usando jsonGlobal
            document.getElementById('stat-total').textContent = jsonGlobal.stats.total;
            document.getElementById('stat-pendientes').textContent = jsonGlobal.stats.pendiente;
            document.getElementById('stat-leidos').textContent = jsonGlobal.stats.leido;
            document.getElementById('stat-respondidos').textContent = jsonGlobal.stats.respondido;

            // 2. Renderizar tabla
            const tbody = document.getElementById('tbody-mensajes');
            tbody.innerHTML = '';

            if (jsonGlobal.data.length === 0) {
                document.getElementById('tabla-vacia').style.display = 'block';
                return;
            }
            document.getElementById('tabla-vacia').style.display = 'none';

            jsonGlobal.data.forEach(m => {
                const estados = {0: 'pendiente', 1: 'leido', 2: 'respondido'};
                const labels = {0: 'Pendiente', 1: 'Leído', 2: 'Respondido'};
                
                tbody.innerHTML += `
                    <tr data-id="${m.idMensaje}">
                        <td>${m.nombre}</td>
                        <td>${m.correo}</td>
                        <td class="fila-mensaje">${m.mensaje.substring(0, 30)}...</td>
                        <td>
                            <span class="badge badge--${estados[m.leido]}">${labels[m.leido]}</span>
                        </td>
                        <td class="fila-acciones">
                            <button class="btn-accion btn-ver" onclick="abrirModal(${m.idMensaje})" title="Ver mensaje">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        } catch (err) {
            console.error("Error al cargar:", err);
        }
    }

    // Listeners
    document.getElementById('filtro-estado').addEventListener('change', cargarDatos);
    document.getElementById('buscador').addEventListener('input', cargarDatos);

    // Carga inicial
    cargarDatos();

    // Función para abrir el modal
    function abrirModal(id) {
        mensajeSeleccionadoId = id;
        const mensaje = jsonGlobal.data.find(m => m.idMensaje == id);
        
        if(mensaje) {
            document.getElementById('modal-nombre').textContent = mensaje.nombre;
            document.getElementById('modal-correo').textContent = mensaje.correo;
            document.getElementById('modal-mensaje').textContent = mensaje.mensaje;
            document.getElementById('modal-servicio').textContent = mensaje.asunto; // Corregido
            document.getElementById('modal-fecha').textContent = mensaje.creado;
            
            const labels = {0: 'Pendiente', 1: 'Leído', 2: 'Respondido'};
            document.getElementById('modal-estado').textContent = labels[mensaje.leido];

            document.getElementById('modal-overlay').style.display = 'flex';
        }
    }

    // Cerrar modal
    document.getElementById('modal-cerrar').addEventListener('click', () => {
        document.getElementById('modal-overlay').style.display = 'none';
    });

    // Función para cambiar estado en BD
    async function cambiarEstado(nuevoEstado) {
        const res = await fetch('includes/actualizar_estado.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: mensajeSeleccionadoId, estado: nuevoEstado })
        });

        const result = await res.json();
        if (result.success) {
            document.getElementById('modal-overlay').style.display = 'none';
            cargarDatos(); // Recarga la tabla
        }
    }
</script>

</body>
</html>
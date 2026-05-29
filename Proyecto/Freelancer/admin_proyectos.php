<?php
session_start();
// Esto es obligatorio para que el PHP sepa quién es el usuario
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Proyectos – Jose Antonio</title>
    <link rel="preload" href="./css/normalize.css" as="style">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krub:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="./css/adminProyectosStyles.css">
</head>
<body>

    <header>
        <h1 class="titulo">Jose Antonio <span>Freelancer</span></h1>
    </header>

    <div class="nav-bg">
        <?php include 'includes/navbar.php'; ?>
    </div>

    <section class="hero-banner">
        <h2 class="hero-banner__titulo">Administrar Proyectos</h2>
        <p class="hero-banner__subtitulo">Gestiona el portafolio de proyectos mostrados en tu sitio</p>
    </section>

    <section class="seccion contenedor">
        <div class="tabla-card sombra">
            <div class="tabla-header">
                <h3 class="tabla-header__titulo">PROYECTOS</h3>
                <div class="tabla-header__controles">
                    <input class="tabla-header__buscador" type="text"
                           id="buscador-proyectos" placeholder="Buscar proyecto...">
                    <button class="btn-nuevo" id="btn-nuevo-proyecto">
                        <i class="fa-solid fa-plus"></i> Nuevo proyecto
                    </button>
                </div>
            </div>

            <div class="tabla-wrap">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><i class="fa-solid fa-heading"></i> Titulo</th>
                            <th><i class="fa-regular fa-user"></i> Cliente</th>
                            <th><i class="fa-regular fa-file-lines"></i> Descripcion</th>
                            <th><i class="fa-regular fa-image"></i> Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-proyectos">
                        <tr>
                            <td colspan="6" class="tabla-vacia">
                                <i class="fa-solid fa-spinner fa-spin"></i> Cargando proyectos...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="tabla-vacia" id="tabla-vacia" style="display:none;">No se encontraron proyectos.</p>
        </div>
    </section>

    <!-- MODAL EDITAR -->
    <div class="modal-overlay" id="modal-editar-overlay" style="display:none;">
        <div class="modal sombra">
            <div class="modal__header">
                <h3 class="modal__titulo"><i class="fa-regular fa-pen-to-square"></i> Ver / Editar proyecto</h3>
                <button class="modal__cerrar" id="modal-editar-cerrar"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal__body">
                <input type="hidden" id="editar-id">
                <div class="campo">
                    <label class="campo__label" for="editar-titulo">Titulo del proyecto</label>
                    <input class="campo__input" type="text" id="editar-titulo" placeholder="Nombre del proyecto">
                </div>
                <div class="campo">
                    <label class="campo__label" for="editar-cliente">Cliente</label>
                    <input class="campo__input" type="text" id="editar-cliente" placeholder="Nombre del cliente">
                </div>
                <div class="campo">
                    <label class="campo__label" for="editar-descripcion">Descripcion</label>
                    <textarea class="campo__input campo__textarea" id="editar-descripcion" placeholder="Describe el proyecto..."></textarea>
                </div>
                <div class="campo">
                    <label class="campo__label">Imagen actual</label>
                    <div class="preview-wrap" id="editar-preview-wrap">
                        <div class="preview-placeholder" id="editar-preview-placeholder">
                            <i class="fa-regular fa-image"></i><span>Sin imagen</span>
                        </div>
                        <img id="editar-preview-img" src="" alt="preview" style="display:none;">
                    </div>
                </div>
                <div class="campo">
                    <label class="campo__label" for="editar-imagen">
                        Cambiar imagen <span class="campo__hint">(opcional)</span>
                    </label>
                    <input class="campo__input campo__file" type="file" id="editar-imagen"
                           accept="image/jpeg,image/png,image/webp">
                </div>
                <p class="modal__respuesta" id="editar-respuesta" style="display:none;"></p>
            </div>
            <div class="modal__footer">
                <button class="btn-modal btn-cancelar" id="modal-editar-cancelar">
                    <i class="fa-solid fa-xmark"></i> Cancelar
                </button>
                <button class="btn-modal btn-guardar" id="btn-guardar-editar">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar cambios
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL NUEVO -->
    <div class="modal-overlay" id="modal-nuevo-overlay" style="display:none;">
        <div class="modal sombra">
            <div class="modal__header">
                <h3 class="modal__titulo"><i class="fa-solid fa-plus"></i> Nuevo proyecto</h3>
                <button class="modal__cerrar" id="modal-nuevo-cerrar"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal__body">
                <div class="campo">
                    <label class="campo__label" for="nuevo-titulo">Titulo <span class="campo__req">*</span></label>
                    <input class="campo__input" type="text" id="nuevo-titulo" placeholder="Nombre del proyecto">
                </div>
                <div class="campo">
                    <label class="campo__label" for="nuevo-cliente">Cliente <span class="campo__req">*</span></label>
                    <input class="campo__input" type="text" id="nuevo-cliente" placeholder="Nombre del cliente">
                </div>
                <div class="campo">
                    <label class="campo__label" for="nuevo-descripcion">Descripcion <span class="campo__req">*</span></label>
                    <textarea class="campo__input campo__textarea" id="nuevo-descripcion" placeholder="Describe el proyecto..."></textarea>
                </div>
                <div class="campo">
                    <label class="campo__label" for="nuevo-imagen">
                        Imagen <span class="campo__hint">(JPG, PNG o WEBP – max 2MB)</span>
                    </label>
                    <input class="campo__input campo__file" type="file" id="nuevo-imagen"
                           accept="image/jpeg,image/png,image/webp">
                    <div class="preview-wrap preview-wrap--nuevo" id="nuevo-preview-wrap" style="display:none;">
                        <img id="nuevo-preview-img" src="" alt="preview">
                    </div>
                </div>
                <p class="modal__respuesta" id="nuevo-respuesta" style="display:none;"></p>
            </div>
            <div class="modal__footer">
                <button class="btn-modal btn-cancelar" id="modal-nuevo-cancelar">
                    <i class="fa-solid fa-xmark"></i> Cancelar
                </button>
                <button class="btn-modal btn-guardar" id="btn-guardar-nuevo">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar proyecto
                </button>
            </div>
        </div>
    </div>

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
const BASE = "./includes/";

/* ── Utilidades ─────────────────────────────────── */
function mostrarRespuesta(id, mensaje, exito) {
    const el = document.getElementById(id);
    el.textContent = mensaje;
    el.className = "modal__respuesta " + (exito ? "modal__respuesta--exito" : "modal__respuesta--error");
    el.style.display = "block";
}
function abrirModal(id)  { document.getElementById(id).style.display = "flex"; }
function cerrarModal(id) { document.getElementById(id).style.display = "none"; }

document.querySelectorAll(".modal-overlay").forEach(o => {
    o.addEventListener("click", e => { if (e.target === o) o.style.display = "none"; });
});

/* ── Renderizar tabla ───────────────────────────── */
function renderizarTabla(proyectos) {
    const tbody = document.getElementById("tbody-proyectos");
    tbody.innerHTML = "";

    if (!proyectos.length) {
        document.getElementById("tabla-vacia").style.display = "block";
        return;
    }
    document.getElementById("tabla-vacia").style.display = "none";

    proyectos.forEach(p => {
        const img = p.imagen
            ? `<img class="fila-thumb" src="./img/${p.imagen}" alt="${p.titulo}">`
            : `<div class="fila-thumb-placeholder"><i class="fa-regular fa-image"></i></div>`;

        const tr = document.createElement("tr");
        tr.dataset.id = p.idProyecto;
        tr.innerHTML = `
            <td>${p.idProyecto}</td>
            <td><span class="fila-titulo">${p.titulo}</span></td>
            <td class="fila-cliente">${p.nombreContacto ?? "—"}</td>
            <td class="fila-desc">${p.descripcion}</td>
            <td>${img}</td>
            <td class="fila-acciones">
                <button class="btn-accion btn-editar" data-id="${p.idProyecto}" title="Ver / Editar">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button class="btn-accion btn-borrar" data-id="${p.idProyecto}" title="Borrar">
                    <i class="fa-regular fa-trash-can"></i>
                </button>
            </td>`;
        tbody.appendChild(tr);
    });

    vincularFilas();
}

/* ── Cargar proyectos ───────────────────────────── */
function cargarProyectos() {
    fetch(BASE + "proyectos_obtener.php")
        .then(r => r.json())
        .then(d => {
            if (d.exito) renderizarTabla(d.proyectos);
            else document.getElementById("tbody-proyectos").innerHTML =
                `<tr><td colspan="6" class="tabla-vacia">Error: ${d.mensaje}</td></tr>`;
        })
        .catch(() => {
            document.getElementById("tbody-proyectos").innerHTML =
                `<tr><td colspan="6" class="tabla-vacia">No se pudo conectar al servidor.</td></tr>`;
        });
}
cargarProyectos();

/* ── Buscador ───────────────────────────────────── */
document.getElementById("buscador-proyectos").addEventListener("input", function () {
    const texto = this.value.toLowerCase();
    let visibles = 0;
    document.querySelectorAll("#tbody-proyectos tr").forEach(fila => {
        const ok = fila.textContent.toLowerCase().includes(texto);
        fila.style.display = ok ? "" : "none";
        if (ok) visibles++;
    });
    document.getElementById("tabla-vacia").style.display = visibles === 0 ? "block" : "none";
});

/* ── Preview imagen ─────────────────────────────── */
function activarPreview(inputId, imgId, wrapId, placeholderId) {
    document.getElementById(inputId).addEventListener("change", function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById(imgId);
            img.src = e.target.result;
            img.style.display = "block";
            if (wrapId) document.getElementById(wrapId).style.display = "block";
            if (placeholderId) document.getElementById(placeholderId).style.display = "none";
        };
        reader.readAsDataURL(file);
    });
}
activarPreview("editar-imagen", "editar-preview-img", null, "editar-preview-placeholder");
activarPreview("nuevo-imagen",  "nuevo-preview-img",  "nuevo-preview-wrap", null);

/* ── Modal editar: cerrar ───────────────────────── */
document.getElementById("modal-editar-cerrar").addEventListener("click",  () => cerrarModal("modal-editar-overlay"));
document.getElementById("modal-editar-cancelar").addEventListener("click", () => cerrarModal("modal-editar-overlay"));

/* ── Vincular eventos de filas ──────────────────── */
function vincularFilas() {

    // Editar
    document.querySelectorAll(".btn-editar").forEach(btn => {
        btn.addEventListener("click", function () {
            const id = this.dataset.id;
            document.getElementById("editar-respuesta").style.display = "none";
            document.getElementById("editar-imagen").value = "";
            document.getElementById("editar-preview-img").style.display = "none";
            document.getElementById("editar-preview-placeholder").style.display = "flex";

            fetch(`${BASE}proyecto_obtener.php?id=${id}`)
                .then(r => r.json())
                .then(d => {
                    if (!d.exito) { alert("Error: " + d.mensaje); return; }
                    const p = d.proyecto;
                    document.getElementById("editar-id").value          = p.idProyecto;
                    document.getElementById("editar-titulo").value      = p.titulo;
                    document.getElementById("editar-cliente").value     = p.nombreContacto ?? "";
                    document.getElementById("editar-descripcion").value = p.descripcion;
                    if (p.imagen) {
                        const imgEl = document.getElementById("editar-preview-img");
                        imgEl.src = `./img/${p.imagen}`;
                        imgEl.style.display = "block";
                        document.getElementById("editar-preview-placeholder").style.display = "none";
                    }
                    abrirModal("modal-editar-overlay");
                })
                .catch(() => alert("Error de conexion."));
        });
    });

    // Borrar
    document.querySelectorAll(".btn-borrar").forEach(btn => {
        btn.addEventListener("click", function () {
            const id     = this.dataset.id;
            const fila   = this.closest("tr");
            const titulo = fila.querySelector(".fila-titulo")?.textContent ?? "este proyecto";

            if (!confirm(`¿Eliminar "${titulo}"? Esta accion no se puede deshacer.`)) return;

            const datos = new FormData();
            datos.append("id", id);

            fetch(BASE + "proyecto_eliminar.php", { method: "POST", body: datos })
                .then(r => r.json())
                .then(d => {
                    if (d.exito) fila.remove();
                    else alert("Error: " + d.mensaje);
                })
                .catch(() => alert("Error de conexion."));
        });
    });
}

/* ── Guardar cambios (editar) ───────────────────── */
document.getElementById("btn-guardar-editar").addEventListener("click", function () {
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Guardando...';

    const datos = new FormData();
    datos.append("id",          document.getElementById("editar-id").value);
    datos.append("titulo",      document.getElementById("editar-titulo").value.trim());
    datos.append("cliente",     document.getElementById("editar-cliente").value.trim());
    datos.append("descripcion", document.getElementById("editar-descripcion").value.trim());
    const imgFile = document.getElementById("editar-imagen").files[0];
    if (imgFile) datos.append("imagen", imgFile);

    fetch(BASE + "proyecto_actualizar.php", { method: "POST", body: datos })
        .then(r => r.json())
        .then(d => {
            mostrarRespuesta("editar-respuesta", d.mensaje, d.exito);
            if (d.exito) setTimeout(() => { cerrarModal("modal-editar-overlay"); cargarProyectos(); }, 1200);
        })
        .catch(() => mostrarRespuesta("editar-respuesta", "Error de conexion.", false))
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Guardar cambios';
        });
});

/* ── Modal nuevo: abrir / cerrar ────────────────── */
document.getElementById("btn-nuevo-proyecto").addEventListener("click", () => {
    ["nuevo-titulo","nuevo-cliente","nuevo-descripcion"].forEach(id => document.getElementById(id).value = "");
    document.getElementById("nuevo-imagen").value = "";
    document.getElementById("nuevo-preview-wrap").style.display = "none";
    document.getElementById("nuevo-respuesta").style.display    = "none";
    abrirModal("modal-nuevo-overlay");
});
document.getElementById("modal-nuevo-cerrar").addEventListener("click",  () => cerrarModal("modal-nuevo-overlay"));
document.getElementById("modal-nuevo-cancelar").addEventListener("click", () => cerrarModal("modal-nuevo-overlay"));

/* ── Guardar nuevo proyecto ─────────────────────── */
document.getElementById("btn-guardar-nuevo").addEventListener("click", function () {
    const btn = this;
    const titulo      = document.getElementById("nuevo-titulo").value.trim();
    const cliente     = document.getElementById("nuevo-cliente").value.trim();
    const descripcion = document.getElementById("nuevo-descripcion").value.trim();
    const imgFile     = document.getElementById("nuevo-imagen").files[0];

    if (!titulo || !cliente || !descripcion) {
        mostrarRespuesta("nuevo-respuesta", "Completa todos los campos obligatorios.", false);
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Guardando...';

    const datos = new FormData();
    datos.append("titulo",      titulo);
    datos.append("cliente",     cliente);
    datos.append("descripcion", descripcion);
    if (imgFile) datos.append("imagen", imgFile);

    fetch(BASE + "proyecto_crear.php", { method: "POST", body: datos })
        .then(r => r.json())
        .then(d => {
            mostrarRespuesta("nuevo-respuesta", d.mensaje, d.exito);
            if (d.exito) setTimeout(() => { cerrarModal("modal-nuevo-overlay"); cargarProyectos(); }, 1200);
        })
        .catch(() => mostrarRespuesta("nuevo-respuesta", "Error de conexion.", false))
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Guardar proyecto';
        });
});
</script>
</body>
</html>
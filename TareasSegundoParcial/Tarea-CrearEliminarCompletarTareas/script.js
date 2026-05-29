const inputTarea  = document.getElementById("inputTarea");
const btnAgregar  = document.getElementById("btnAgregar");
const contenedor  = document.getElementById("contenedor");

btnAgregar.addEventListener("click", function() {

    const texto = inputTarea.value;

    if (texto.trim() === "") return;

    const divTarea = document.createElement("div");
    divTarea.classList.add("tarea");

    const span = document.createElement("span");
    span.textContent = texto;

    const btnCompletar = document.createElement("button");
    btnCompletar.textContent = "Completada";
    btnCompletar.addEventListener("click", function() {
        divTarea.classList.toggle("completada"); 
    });

    const btnBorrar = document.createElement("button");
    btnBorrar.textContent = "Borrar";
    btnBorrar.addEventListener("click", function() {
        divTarea.remove();
    });

    divTarea.appendChild(span);
    divTarea.appendChild(btnCompletar);
    divTarea.appendChild(btnBorrar);

    contenedor.appendChild(divTarea);

    inputTarea.value = "";
});
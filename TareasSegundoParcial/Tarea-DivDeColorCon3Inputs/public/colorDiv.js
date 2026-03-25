const caja    = document.getElementById("caja");
const inputR  = document.getElementById("inputR");
const inputG  = document.getElementById("inputG");
const inputB  = document.getElementById("inputB");
const boton   = document.getElementById("btnAceptar");

boton.addEventListener("click", function() {

    const r = Number(inputR.value);
    const g = Number(inputG.value);
    const b = Number(inputB.value);
    const color = `rgb(${r}, ${g}, ${b})`;
    caja.style.backgroundColor = color;
});
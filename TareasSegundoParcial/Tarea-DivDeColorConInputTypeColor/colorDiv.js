const caja = document.getElementById("caja");
const colorPicker = document.getElementById("colorPicker");
const boton = document.getElementById("btnAceptar");

boton.addEventListener("click", function() 
{
    const colorElegido = colorPicker.value;
    caja.style.backgroundColor = colorElegido;
});
import './bootstrap';


const boton = document.getElementById("botonLogin");
boton.addEventListener("click", () =>{
    const modalLogin = document.getElementById("modalLogin");
    modalLogin.classList.remove("hidden");

})

const btnCerrarModalLogin = document.getElementById("btnCerrarModalLogin");
btnCerrarModalLogin.addEventListener("click", () =>{
    const modalLogin = document.getElementById("modalLogin");
    modalLogin.classList.add("hidden");
})
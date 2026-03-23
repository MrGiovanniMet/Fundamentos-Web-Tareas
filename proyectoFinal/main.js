const menu = document.querySelector("nav");
function toggleMenu() {
    menu.classList.toggle("open");
    boton.textContent = menu.classList.contains("open") ? "✕" : "☰";
}

const submenu = document.getElementById("submenu-servicios");
const serv = document.getElementById("serv");

function toggleServicios() {
    submenu.classList.toggle("open");
    serv.textContent = submenu.classList.contains("open") ? "Servicios ▲" : "Servicios ▽";
}
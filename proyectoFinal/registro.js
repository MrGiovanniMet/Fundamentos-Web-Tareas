document.getElementById("btn-registro").addEventListener("click", function () {
    const nombre = document.getElementById("nombre").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const confirmar = document.getElementById("confirmar").value;

    if (!nombre || !email || !password || !confirmar) {
        mostrarError(1);
        return;
    }

    if (password !== confirmar) {
        mostrarError(2);
        return;
    }

    ocultarError();
    const nuevo = {
        id: Date.now(),
        nombre: nombre,
        email: email,
        password: password,
        rol: "cliente"
    };

    usuarios.push(nuevo);
    localStorage.setItem("vetUser", JSON.stringify(nuevo));
    window.location.href = "citas.html";
});

function ocultarError() {
    const msg = document.getElementById("msgError");
    msg.style.display = "none";
}

function mostrarError(num) {
    const opc = num;
    const msg = document.getElementById("msgError");
    if (opc == 1) {
        msg.textContent = "Porfavor rellena todos los campos";
        msg.style.display = "block";
        setTimeout(function () {
            msg.style.display = "none";
        }, 3000);
    }
    else {
        msg.textContent = "Las contraseñas no coinciden";
        msg.style.display = "block";
        setTimeout(function () {
            msg.style.display = "none";
        }, 3000);
    }
}
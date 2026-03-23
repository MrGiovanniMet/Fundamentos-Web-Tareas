function validarLogin(email, password) {
    const usuario = usuarios.find(function(u) {
        return u.email == email && u.password == password;
    });
    return usuario || null;
}

function redirigir(usuario) {
    localStorage.setItem("vetUser", JSON.stringify(usuario));
    if (usuario.rol == "admin") {
        window.location.href = "admin-citas.html";
    } else {
        window.location.href = "citas.html";
    }
}

function mostrarError() {
    const msg = document.getElementById("msgError");
    msg.textContent = "Error en los datos ";
    msg.style.display = "block";
    setTimeout(function () {
            msg.style.display = "none";
        }, 3000);
}



document.getElementById("btn-login").addEventListener("click", function() {
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    if (!email || !password) {
        mostrarError();
        return;
    }

    const usuario = validarLogin(email, password);

    if (!usuario) {
        mostrarError();
        return;
    }
    redirigir(usuario);
});
function renderProductos(lista) {
    const contenedor = document.getElementById("productos");
    contenedor.innerHTML = "";

    lista.forEach(function(p) {
        const div = document.createElement("div");
        div.className = "producto-card";
        div.innerHTML = `
            <img src="${p.imagen}" alt="${p.nombre}">
            <h3>${p.nombre}</h3>
            <p>Precio: $${p.precio}</p>
            <p>Dosis: ${p.dosis}</p>
            <p>Raza: ${p.raza}</p>
            <p>${p.disponible ? "Disponible" : "No disponible"}</p>
            <button ${!p.disponible ? "disabled" : ""}>Comprar</button>
        `;
        contenedor.appendChild(div);
    });
}

function filtrar(categoria) {
    if (categoria == "todas") {
        renderProductos(productos);
    } else {
        const filtrados = productos.filter(function(p) {
            return p.categoria == categoria;
        });
        renderProductos(filtrados);
    }
}

document.querySelectorAll(".filtro").forEach(function(btn) {
    btn.addEventListener("click", function() {
        document.querySelectorAll(".filtro").forEach(function(b) {
            b.classList.remove("activo");
        });
        btn.classList.add("activo");
        filtrar(btn.dataset.categoria);
    });
});

renderProductos(productos);
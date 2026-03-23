
Auth.requireLogin();

const user = Auth.getUser();
document.getElementById("bienvenida").textContent = "Hola, " + user.nombre;
document.getElementById("btnLogout").addEventListener("click", () => Auth.logout());


document.getElementById("fecha").min = new Date().toISOString().split("T")[0];


function renderCitas() {
  const contenedor = document.getElementById("listaCitas");
  const citas = CitasDB.getByUsuario(user.id);

  if (!citas.length) {
    contenedor.innerHTML = "<p>No tienes citas registradas.</p>";
    return;
  }

  contenedor.innerHTML = citas
    .sort((a, b) => new Date(b.fecha) - new Date(a.fecha))
    .map(c => `
      <div class="cita-card">
        <p><strong>${c.nombreMascota}</strong></p>
        <p>📅 ${c.fecha} · ⏰ ${c.hora}</p>
        <p>${c.motivo}</p>
        <p><span class="badge-${c.estado}">${c.estado}</span></p>
      </div>
    `).join("");
}

document.getElementById("formCita").addEventListener("submit", (e) => {
  e.preventDefault();

  const cita = {
    usuarioId:     user.id,
    nombreMascota: document.getElementById("nombreMascota").value.trim(),
    fecha:         document.getElementById("fecha").value,
    hora:          document.getElementById("hora").value,
    motivo:        document.getElementById("motivo").value.trim(),
  };

  CitasDB.agregar(cita);

  document.getElementById("formCita").reset();

  const msg = document.getElementById("msgOk");
  msg.classList.remove("oculto");
  setTimeout(() => msg.classList.add("oculto"), 3000);

  renderCitas();
});

renderCitas();

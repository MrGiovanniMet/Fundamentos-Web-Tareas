

Auth.requireAdmin();

const user = Auth.getUser();
document.getElementById("bienvenida").textContent = "Admin: " + user.nombre;
document.getElementById("btnLogout").addEventListener("click", () => Auth.logout());

let filtroActivo = "todas";

function renderStats(citas) {
  document.getElementById("statTotal").textContent      = citas.length;
  document.getElementById("statPendientes").textContent = citas.filter(c => c.estado === "pendiente").length;
  document.getElementById("statConfirmadas").textContent= citas.filter(c => c.estado === "confirmada").length;
  document.getElementById("statCanceladas").textContent = citas.filter(c => c.estado === "cancelada").length;
}

function renderTabla() {
  const todas    = CitasDB.getAll();
  renderStats(todas);

  const filtradas = filtroActivo === "todas"
    ? todas
    : todas.filter(c => c.estado === filtroActivo);

  const tbody = document.getElementById("tbodyCitas");

  if (!filtradas.length) {
    tbody.innerHTML = `<tr><td colspan="7">No hay citas en esta categoría.</td></tr>`;
    return;
  }

  tbody.innerHTML = filtradas
    .sort((a, b) => new Date(a.fecha) - new Date(b.fecha))
    .map(c => `
      <tr>
        <td>${c.nombreMascota}</td>
        <td>${c.usuarioId}</td>
        <td>${c.fecha}</td>
        <td>${c.hora}</td>
        <td>${c.motivo}</td>
        <td><span class="badge-${c.estado}">${c.estado}</span></td>
        <td>
          ${c.estado === "pendiente"  ? `<button class="confirmar" onclick="cambiar(${c.id},'confirmada')">Confirmar</button>` : ""}
          ${c.estado !== "cancelada"  ? `<button class="cancelar"  onclick="cambiar(${c.id},'cancelada')">Cancelar</button>`  : ""}
          <button class="eliminar" onclick="eliminar(${c.id})">Eliminar</button>
        </td>
      </tr>
    `).join("");
}

function cambiar(id, estado) {
  CitasDB.actualizarEstado(id, estado);
  renderTabla();
}

function eliminar(id) {
  if (confirm("¿Eliminar esta cita?")) {
    CitasDB.eliminar(id);
    renderTabla();
  }
}

document.querySelectorAll(".filtro").forEach(btn => {
  btn.addEventListener("click", () => {
    document.querySelectorAll(".filtro").forEach(b => b.classList.remove("activo"));
    btn.classList.add("activo");
    filtroActivo = btn.dataset.f;
    renderTabla();
  });
});

renderTabla();

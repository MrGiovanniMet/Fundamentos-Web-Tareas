// BD no hay 

const CitasDB = {
  _KEY: "vetCitas",

  _seed() {
    if (!localStorage.getItem(this._KEY)) {
      const ejemplo = [
        { id: 1, usuarioId: 1, nombreMascota: "Max",   fecha: "2025-04-10", hora: "10:00", motivo: "Vacunación",      estado: "confirmada" },
        { id: 2, usuarioId: 1, nombreMascota: "Luna",  fecha: "2025-04-15", hora: "11:30", motivo: "Revisión general", estado: "pendiente"  },
        { id: 3, usuarioId: 2, nombreMascota: "Rocky", fecha: "2025-04-12", hora: "09:00", motivo: "Corte de uñas",    estado: "pendiente"  },
      ];
      localStorage.setItem(this._KEY, JSON.stringify(ejemplo));
    }
  },

  getAll() {
    this._seed();
    return JSON.parse(localStorage.getItem(this._KEY)) || [];
  },

  getByUsuario(usuarioId) {
    return this.getAll().filter(c => c.usuarioId === usuarioId);
  },

  agregar(cita) {
    const todas = this.getAll();
    const nueva = { ...cita, id: Date.now(), estado: "pendiente" };
    todas.push(nueva);
    localStorage.setItem(this._KEY, JSON.stringify(todas));
    return nueva;
  },

  actualizarEstado(id, estado) {
    const todas = this.getAll();
    const idx = todas.findIndex(c => c.id === id);
    if (idx !== -1) {
      todas[idx].estado = estado;
      localStorage.setItem(this._KEY, JSON.stringify(todas));
    }
  },

  eliminar(id) {
    const filtradas = this.getAll().filter(c => c.id !== id);
    localStorage.setItem(this._KEY, JSON.stringify(filtradas));
  }
};


const Auth = {
  getUser() {
    const data = localStorage.getItem("vetUser");
    return data ? JSON.parse(data) : null;
  },

  isAdmin() {
    const u = this.getUser();
    return u && u.rol === "admin";
  },

  requireLogin(redirect = "login.html") {
    if (!this.getUser()) window.location.href = redirect;
  },

  requireAdmin(redirect = "index.html") {
    if (!this.isAdmin()) window.location.href = redirect;
  },

  logout(redirect = "login.html") {
    localStorage.removeItem("vetUser");
    window.location.href = redirect;
  }
};

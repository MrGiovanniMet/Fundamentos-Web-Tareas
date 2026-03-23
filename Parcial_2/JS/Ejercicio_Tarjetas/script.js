document.querySelector(".agregar").addEventListener("click", function () {
  const entrada = document.querySelector(".entrada");
  const texto = entrada.value;
  if (texto == '')
    return;
  else
    agregarTarjeta(texto);
  entrada.value = '';
});

let contador = 0;

function agregarTarjeta(texto) {
  const lista = document.querySelector(".lista");

  const id = `tarjeta-${contador}`;
  contador++;

  const tarjeta = document.createElement("div");
  tarjeta.id = id;

  const cuerpo = document.createElement("div");
  cuerpo.classList.add("textop");
  cuerpo.textContent = texto;

  const controles = document.createElement("div");
  controles.classList.add("controles");

  const selector = document.createElement("input");
  selector.type = "color";
  selector.value = "#510132";
  cuerpo.style.background = selector.value;
  selector.addEventListener("input", function () {
    cuerpo.style.background = selector.value;
  });

  const btnBorrar = document.createElement("button");
  btnBorrar.classList.add("borrar");
  btnBorrar.textContent = "Borrar";
  btnBorrar.addEventListener("click", function() {
  document.getElementById(id).remove();
});

  controles.appendChild(selector);
  controles.appendChild(btnBorrar);
  tarjeta.appendChild(cuerpo);
  tarjeta.appendChild(controles);
  lista.appendChild(tarjeta);
}




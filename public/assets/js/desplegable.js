//Crear menú dinámico de Soporte
const soporteBtn = document.getElementById("soporteLink");
soporteBtn.addEventListener("click", (event) => {
  event.preventDefault();

  // Si ya existe, elimínalo para evitar duplicados
  eliminarMenu();

  // Crear dinámicamente el menú de Soporte
  const menu = document.createElement("ul");
  menu.className = "selector-menu";
  menu.innerHTML = `
            <li><a href="./paginas/faq.html">FAQ</a></li>
            <li><a href="./paginas/manual.html">Manual de uso</a></li>
        `;
  soporteBtn.parentNode.appendChild(menu);

  // Mostrar el menú con una pequeña animación
  setTimeout(() => {
    menu.classList.add("active");
  }, 10);
});

//Crear menú dinámico de Idioma
const idiomaBtn = document.getElementById("languageLink");
idiomaBtn.addEventListener("click", (event) => {
  event.preventDefault();

  eliminarMenu();

  // Crear dinámicamente el menú de Idioma
  const menu = document.createElement("ul");
  menu.className = "selector-menu";
  menu.innerHTML = `
            <li><a href="#" onclick="cambiarIdioma('es')">Español</a></li>
            <li><a href="#" onclick="cambiarIdioma('en')">Inglés</a></li>
        `;
  idiomaBtn.parentNode.appendChild(menu);

  // Mostrar el menú con una pequeña animación
  setTimeout(() => {
    menu.classList.add("active");
  }, 10);
});

//Crear menú dinámico de soluciones
const solucionesBtn = document.getElementById("solucionesLink");
solucionesBtn.addEventListener("click", (event) => {
  event.preventDefault();

  eliminarMenu();

  // Crear dinámicamente el menú de soluciones
  const menu = document.createElement("ul");
  menu.className = "selector-menu";
  menu.innerHTML = `
                <li><a href="./paginas/mas_soluciones.html">Directorio de proveedores</a></li>
                <li><a href="./paginas/control_de_accesos.html">Control de accesos</a></li>
                <li><a href="./paginas/personal_sobre_el_terreno.html">Personal sobre el terreno</a></li>
            `;
  solucionesBtn.parentNode.appendChild(menu);

  // Mostrar el menú con una pequeña animación
  setTimeout(() => {
    menu.classList.add("active");
  }, 10);
});

//Eliminar los menús si haces clic fuera
document.addEventListener("click", (event) => {
  if (
    !soporteBtn.contains(event.target) &&
    !idiomaBtn.contains(event.target) &&
    !event.target.classList.contains("selector-menu")
  ) {
    eliminarMenu();
  }
});

function eliminarMenu() {
    const activeMenu = document.querySelector(".selector-menu");
    if (activeMenu) {
      activeMenu.classList.remove("active");
      setTimeout(() => {
        if (activeMenu.parentNode) {
          activeMenu.remove();
        }
      }, 200);
    }
  }
  

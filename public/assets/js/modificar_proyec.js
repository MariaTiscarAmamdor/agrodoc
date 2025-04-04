const tablaProyectos = document.getElementById("proyectosTabla");

tablaProyectos.addEventListener("click", (event) => {
  if (event.target.classList.contains("editar")) {
    let row = event.target.closest("tr");

    // ✅ Guardamos las fechas originales para compararlas después
    row.dataset.originalFechaInicio = row.querySelector("td:nth-child(5)").innerText;
    row.dataset.originalFechaFin = row.querySelector("td:nth-child(6)").innerText;

    // ✅ Convertimos directamente a input tipo date (no hay que cambiar formato)
    row.querySelector("td:nth-child(5)").innerHTML = `<input type="date" value="${row.dataset.originalFechaInicio}">`;
    row.querySelector("td:nth-child(6)").innerHTML = `<input type="date" value="${row.dataset.originalFechaFin}">`;

    row.querySelector(".editar").style.display = "none";
    row.querySelector(".guardar").style.display = "inline-block";
  }
});

tablaProyectos.addEventListener("click", (event) => {
  if (event.target.classList.contains("guardar")) {
    let row = event.target.closest("tr");
    let id = row.dataset.id;
    let fechaInicio = row.querySelector("td:nth-child(5) input").value;
    let fechaFin = row.querySelector("td:nth-child(6) input").value;

    // ✅ Si no hay cambios, cancelamos la operación
    if (
      fechaInicio === row.dataset.originalFechaInicio &&
      fechaFin === row.dataset.originalFechaFin
    ) {
      alert("No se realizaron cambios, los datos son los mismos.");

      // ✅ Restauramos los valores originales
      row.querySelector("td:nth-child(5)").innerText = row.dataset.originalFechaInicio;
      row.querySelector("td:nth-child(6)").innerText = row.dataset.originalFechaFin;

      row.querySelector(".editar").style.display = "inline-block";
      row.querySelector(".guardar").style.display = "none";
      return;
    }

    let datos = [
      id,
      fechaInicio,
      fechaFin
    ];

    console.log("Datos enviados para modificar:", datos);

    // ✅ Enviar por AJAX mediante fetch
    fetch("/controllers/ProyecController.php?action=modificarProyecto", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ datos: datos }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.mensaje) {
          alert(data.mensaje);

          // ✅ Actualizamos la tabla directamente con los nuevos valores
          row.querySelector("td:nth-child(5)").innerText = fechaInicio;
          row.querySelector("td:nth-child(6)").innerText = fechaFin;

          row.querySelector(".editar").style.display = "inline-block";
          row.querySelector(".guardar").style.display = "none";
        } else {
          alert(data.error);
        }
      })
      .catch((error) => {
        console.error("Error al modificar proyecto:", error);
        alert("Error en el servidor.");
      });
  }
});

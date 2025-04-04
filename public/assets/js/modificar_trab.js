const tablaTrabajadores = document.getElementById("trabajadoresTabla");

tablaTrabajadores.addEventListener("click", (event) => {
  if (event.target.classList.contains("editar")) {
    let row = event.target.closest("tr");

    
    row.dataset.originalNombre = row.querySelector("td:nth-child(2)").innerText;
    row.dataset.originalApellidos = row.querySelector("td:nth-child(3)").innerText;
    row.dataset.originalDni = row.querySelector("td:nth-child(4)").innerText;
    row.dataset.originalEmail = row.querySelector("td:nth-child(5)").innerText;
    row.dataset.originalTelefono = row.querySelector("td:nth-child(6)").innerText;
    row.dataset.originalDireccion = row.querySelector("td:nth-child(7)").innerText;
    row.dataset.originalDocumentos = row.querySelector("td:nth-child(8)").innerText === 'Sí' ? 1 : 0;

    row.querySelectorAll(".editable").forEach((cell) => {
      let valor = cell.innerText;
      cell.innerHTML = `<input type="text" value="${valor}">`;
    });

    row.querySelector(".editar").style.display = "none";
    row.querySelector(".guardar").style.display = "inline-block";
  }
});


tablaTrabajadores.addEventListener("click", (event) => {
  if (event.target.classList.contains("guardar")) {
    let row = event.target.closest("tr");
    let id = row.dataset.id;
    let nombre = row.querySelector("td:nth-child(2) input").value;
    let apellidos = row.querySelector("td:nth-child(3) input").value;
    let dni = row.querySelector("td:nth-child(4) input").value;
    let email = row.querySelector("td:nth-child(5) input").value;
    let telefono = row.querySelector("td:nth-child(6) input").value;
    let direccion = row.querySelector("td:nth-child(7) input").value;
    let documentos = row.querySelector("td:nth-child(8) input").value.toLowerCase() === 'sí' ? 1 : 0;

    //Comprobamos si los valores son iguales a los originales y si son iguales, no realizamos ningún cambio
    if (
      nombre === row.dataset.originalNombre &&
      apellidos === row.dataset.originalApellidos &&
      dni === row.dataset.originalDni &&
      email === row.dataset.originalEmail &&
      telefono === row.dataset.originalTelefono &&
      direccion === row.dataset.originalDireccion &&
      documentos === parseInt(row.dataset.originalDocumentos)
    ) {
      alert("No se realizaron cambios, los datos son los mismos.");

      //Volvermos a mostrar los valores originales si no hay cambios
      row.querySelector("td:nth-child(2)").innerText = row.dataset.originalNombre;
      row.querySelector("td:nth-child(3)").innerText = row.dataset.originalApellidos;
      row.querySelector("td:nth-child(4)").innerText = row.dataset.originalDni;
      row.querySelector("td:nth-child(5)").innerText = row.dataset.originalEmail;
      row.querySelector("td:nth-child(6)").innerText = row.dataset.originalTelefono;
      row.querySelector("td:nth-child(7)").innerText = row.dataset.originalDireccion;
      row.querySelector("td:nth-child(8)").innerText = row.dataset.originalDocumentos ? 'Sí' : 'No';
      
      row.querySelector(".editar").style.display = "inline-block";
      row.querySelector(".guardar").style.display = "none";
      return; 
    }

    let datos = [
      id,    
      nombre,
      apellidos,
      dni,
      email,
      telefono,
      direccion,
      documentos
    ];

    console.log("Datos enviados para modificar:", datos);

    
    fetch("/controllers/TrabController.php?action=modificarTrabajador", {
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

          //Actualizamos la tabla con los valores modificados
          row.querySelector("td:nth-child(2)").innerText = nombre;
          row.querySelector("td:nth-child(3)").innerText = apellidos;
          row.querySelector("td:nth-child(4)").innerText = dni;
          row.querySelector("td:nth-child(5)").innerText = email;
          row.querySelector("td:nth-child(6)").innerText = telefono;
          row.querySelector("td:nth-child(7)").innerText = direccion;
          row.querySelector("td:nth-child(8)").innerText = documentos === 1 ? 'Sí' : 'No';

          row.querySelector(".editar").style.display = "inline-block";
          row.querySelector(".guardar").style.display = "none";
        } else {
          alert(data.error);
        }
      })
      .catch((error) => {
        console.error("Error al modificar trabajador:", error);
        alert("Error en el servidor.");
      });
  }
});

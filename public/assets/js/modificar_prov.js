const tablaProveedores = document.getElementById("proveedoresTabla");

tablaProveedores.addEventListener("click", (event) => {
  if (event.target.classList.contains("editar")) {
    let row = event.target.closest("tr");

    
    row.dataset.originalNombre = row.querySelector("td:nth-child(2)").innerText;
    row.dataset.originalApellidos = row.querySelector("td:nth-child(3)").innerText;
    row.dataset.originalCif = row.querySelector("td:nth-child(4)").innerText;
    row.dataset.originalEmail = row.querySelector("td:nth-child(5)").innerText;
    row.dataset.originalTelefono = row.querySelector("td:nth-child(6)").innerText;
    row.dataset.originalDireccion = row.querySelector("td:nth-child(7)").innerText;
  

    row.querySelectorAll(".editable").forEach((cell) => {
      let valor = cell.innerText;
      cell.innerHTML = `<input type="text" value="${valor}">`;
    });

    row.querySelector(".editar").style.display = "none";
    row.querySelector(".guardar").style.display = "inline-block";
  }
});


tablaProveedores.addEventListener("click", (event) => {
  if (event.target.classList.contains("guardar")) {
    let row = event.target.closest("tr");
    let id = row.dataset.id;
    let nombre = row.querySelector("td:nth-child(2) input").value;
    let apellidos = row.querySelector("td:nth-child(3) input").value;
    let cif = row.querySelector("td:nth-child(4) input").value;
    let email = row.querySelector("td:nth-child(5) input").value;
    let telefono = row.querySelector("td:nth-child(6) input").value;
    let direccion = row.querySelector("td:nth-child(7) input").value;
   

    //Comprobamos si los valores son iguales a los originales y si son iguales, no realizamos ningún cambio
    if (
      nombre === row.dataset.originalNombre &&
      apellidos === row.dataset.originalApellidos &&
      cif === row.dataset.originalCif &&
      email === row.dataset.originalEmail &&
      telefono === row.dataset.originalTelefono &&
      direccion === row.dataset.originalDireccion
     
    ) {
      alert("No se realizaron cambios, los datos son los mismos.");

      //Volvermos a mostrar los valores originales si no hay cambios
      row.querySelector("td:nth-child(2)").innerText = row.dataset.originalNombre;
      row.querySelector("td:nth-child(3)").innerText = row.dataset.originalApellidos;
      row.querySelector("td:nth-child(4)").innerText = row.dataset.originalCif;
      row.querySelector("td:nth-child(5)").innerText = row.dataset.originalEmail;
      row.querySelector("td:nth-child(6)").innerText = row.dataset.originalTelefono;
      row.querySelector("td:nth-child(7)").innerText = row.dataset.originalDireccion;  
      
      row.querySelector(".editar").style.display = "inline-block";
      row.querySelector(".guardar").style.display = "none";
      return; 
    }

    let datos = [
      id,    
      nombre,
      apellidos,
      cif,
      email,
      telefono,
      direccion
   
    ];

    console.log("Datos enviados para modificar:", datos);

    
    fetch("/controllers/ProvController.php?action=modificarProveedor", {
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
          row.querySelector("td:nth-child(4)").innerText = cif;
          row.querySelector("td:nth-child(5)").innerText = email;
          row.querySelector("td:nth-child(6)").innerText = telefono;
          row.querySelector("td:nth-child(7)").innerText = direccion;      

          row.querySelector(".editar").style.display = "inline-block";
          row.querySelector(".guardar").style.display = "none";
        } else {
          alert(data.error);
        }
      })
      .catch((error) => {
        console.error("Error al modificar proveedor:", error);
        alert("Error en el servidor.");
      });
  }
});

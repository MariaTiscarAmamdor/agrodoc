console.log("trabadores.js cargado correctamente");

//Función para actualizar los datos después de eliminar o modificar
function cargarTrabajadores() {
    console.log("Intentando cargar trabajadores...");

    fetch('/controllers/TrabController.php?action=listarTrabajadores')
        .then(response => {
            console.log("Respuesta recibida:", response);
            return response.json();  
        })
        .then(data => {
            console.log("Datos recibidos para actualizar tabla:", data);

            let tabla = document.getElementById("trabajadoresTabla").querySelector('tbody');
            if (!tabla) {
                console.error("La tabla no está definida");
                return;
            }

            tabla.innerHTML = ""; 

            data.forEach(trabajador => {
               
                let row = `
                    <tr data-id="${trabajador.id_trab}">
                        <td>${trabajador.id_trab}</td>
                        <td class='editable'>${trabajador.nombre}</td>
                        <td class='editable'>${trabajador.apellidos}</td>
                        <td class='editable'>${trabajador.dni}</td>
                        <td class='editable'>${trabajador.email}</td>
                        <td class='editable'>${trabajador.telefono}</td>
                        <td class='editable'>${trabajador.direccion}</td>
                        <td class='editable'>${trabajador.documentos ? 'Sí' : 'No'}</td>
                        <td class='editable'>${trabajador.nombre_proveedor}</td>
                        <td>
                            <button onclick="editarTrabajador(${trabajador.id_trab})">Modificar</button>
                            <button style="display:none;" onclick="guardarTrabajador(${trabajador.id_trab})">Guardar</button>
                        </td>
                        <td>
                            <button onclick="eliminartrabajador(${trabajador.id_trab})">Eliminar</button>
                        </td>
                    </tr>
                `;
                tabla.innerHTML += row;
            });

            console.log("Tabla actualizada correctamente");
        })
        .catch(error => console.error("Error al cargar trabajadores:", error));
}

// Eliminar trabajador
function eliminarTrabajador(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este trabajador?")) {
        fetch(`/controllers/TrabController.php?action=eliminarTrabajador&id=${id}`)
        .then(response =>             
            response.json())           
        .then(data => {          
                alert(data.mensaje || data.error);
               
                // Obtener tipo de usuario y id del HTML
                const datosUsuario = document.getElementById('datosUsuario');
                const tipo = datosUsuario.dataset.tipo;
                const idProv = datosUsuario.dataset.idProv; 

                if (tipo === 'proveedor') {
                    cargar('#portada', `/views/vertrabajadores.php?id=${idProv}`);
                } else {
                    cargar('#portada', '/views/vertrabajadores.php');
                }
            
        })
        .catch(error => console.error("Error al eliminar trabajador:", error));
    }
}

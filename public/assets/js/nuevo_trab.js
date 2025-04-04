const idProvSelect = document.getElementById('id_prov');


// Función para cargar proveedores
function cargarProveedores() {
    fetch('/controllers/ProvController.php?action=listarProveedores')
        .then(response => response.json())
        .then(data => {
            idProvSelect.innerHTML = '<option value="">-- Seleccionar Proveedor --</option>';
            data.forEach(proveedor => {
                idProvSelect.innerHTML += `<option value="${proveedor.id_prov}">${proveedor.nombre}</option>`;
            });
        })
        .catch(error => console.error("Error al cargar proveedores:", error));
}

cargarProveedores();

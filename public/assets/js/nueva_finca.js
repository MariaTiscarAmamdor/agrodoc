const idContSelect = document.getElementById('id_cont');

// Función para cargar contratistas
function cargarContratistas() {
    fetch('/controllers/ContController.php?action=listarContratistas')
        .then(response => response.json())
        .then(data => {
            idContSelect.innerHTML = '<option value="">-- Seleccionar Contratista --</option>';
            data.forEach(contratista => {
                idContSelect.innerHTML += `<option value="${contratista.id_cont}">${contratista.nombre}</option>`;
            });
        })
        .catch(error => console.error("Error al cargar contratistas:", error));
}
cargarContratistas();

function getProyectosPorContratista(idContratista) {
    fetch(`/controllers/ProyecController.php?action=listarProyectosContratista&id_cont=${idContratista}`)
      .then(res => res.json())
      .then(data => {
        const hoy = new Date();
        let activas = 0, futuras = 0, finalizadas = 0;
  
        data.forEach(p => {
          const inicio = new Date(p.fecha_inicio);
          const fin = new Date(p.fecha_fin);
  
          if (hoy >= inicio && hoy <= fin) activas++;
          else if (hoy < inicio) futuras++;
          else if (hoy > fin) finalizadas++;
        });
  
        document.getElementById("activas").textContent = activas;
        document.getElementById("futuras").textContent = futuras;
        document.getElementById("finalizadas").textContent = finalizadas;
        document.getElementById("totalCampanas").textContent = data.length;
      })
      .catch(err => console.error("Error cargando proyectos:", err));
  }
  
  function getFincasPorContratista(idContratista) {
    fetch(`/controllers/FincasController.php?action=listarFincasPorContratista&id_cont=${idContratista}`)
      .then(res => res.json())
      .then(data => {
        let total = data.length;
        let hectareasTotales = 0;
        let maxHectarea = 0;
        let fincaMayor = "-";
        const cultivos = {};
  
        data.forEach(f => {
          const hect = parseFloat(f.hectarea) || 0;
          hectareasTotales += hect;
  
          if (hect > maxHectarea) {
            maxHectarea = hect;
            fincaMayor = f.localizacion || "Sin ubicación";
          }
  
          const cultivo = f.cultivo;
          if (cultivo) {
            cultivos[cultivo] = (cultivos[cultivo] || 0) + 1;
          }
        });
  
        // cultivo más común
        let cultivoComun = "-";
        let maxCultivo = 0;
        for (const [nombre, count] of Object.entries(cultivos)) {
          if (count > maxCultivo) {
            maxCultivo = count;
            cultivoComun = nombre;
          }
        }
  
        document.getElementById("totalFincas").textContent = total;
        document.getElementById("hectareasTotales").textContent = hectareasTotales.toFixed(2);
        document.getElementById("fincaMayor").textContent = fincaMayor;
        document.getElementById("cultivoComun").textContent = cultivoComun;
      })
      .catch(err => console.error("Error al cargar fincas:", err));
  }

  function getProveedoresPorContratista(idContratista) {
    fetch(`/controllers/ProyecController.php?action=listarProyectosContratista&id_cont=${idContratista}`)
      .then(res => res.json())
      .then(data => {
        const proveedorCount = {};
        let proveedorReciente = null;       
  
        data.forEach(p => {
          const nombre = p.nombre_proveedor;
          const fecha = new Date(p.fecha_inicio);
  
        //para saber el número de proveedores utilizados
          if (nombre) {
            proveedorCount[nombre] = (proveedorCount[nombre] || 0) + 1;
          }
  
          // comprobar el proveedor más reciente utilizado
          if (!proveedorReciente || fecha > new Date(proveedorReciente.fecha_inicio)) {
            proveedorReciente = {
              nombre_proveedor: nombre,
              fecha_inicio: p.fecha_inicio
            };
          }
        });
  
        // Calcular el proveedor más frecuente
        let proveedorFrecuente = "-";
        let maxCount = 0;
        for (const [nombre, count] of Object.entries(proveedorCount)) {
          if (count > maxCount) {
            maxCount = count;
            proveedorFrecuente = nombre;
          }
        }
  
        document.getElementById("totalProveedores").textContent = Object.keys(proveedorCount).length;
        document.getElementById("proveedorFrecuente").textContent = proveedorFrecuente;
        document.getElementById("proveedorReciente").textContent = proveedorReciente.nombre_proveedor || "-";
      })
      .catch(err => console.error("Error al cargar proveedores:", err));
  }
  
   
const userMeta = document.getElementById("userMeta");
const idContratista = userMeta?.dataset.idCont;

if (idContratista) {
  getProyectosPorContratista(idContratista);
  getFincasPorContratista(idContratista);
  getProveedoresPorContratista(idContratista);
}

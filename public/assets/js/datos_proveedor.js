function getProyectosPorProveedor(idProveedor) {
  fetch(
    `/controllers/ProyecController.php?action=listarProyectosPorProveedor&id_prov=${idProveedor}`
  )
    .then((res) => res.json())
    .then((data) => {
      const hoy = new Date();
      let activas = 0,
        futuras = 0,
        finalizadas = 0;

      data.forEach((p) => {
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
    .catch((err) => console.error("Error cargando proyectos:", err));
}
function getTrabajadoresPorProveedor(idProveedor) {
  fetch(
    `/controllers/TrabController.php?action=listarTrabajadoresPorProveedor&id_prov=${idProveedor}`
  )
    .then((res) => res.json())
    .then((data) => {
        
      const trabajadorCount = {};
      let sinDocumentacion = 0;

      data.forEach((t) => {
        const nombreCompleto = `${t.nombre} ${t.apellidos}`.trim();
     

        // contar cuántas veces aparece cada trabajador
        if (nombreCompleto) {
          trabajadorCount[nombreCompleto] = (trabajadorCount[nombreCompleto] || 0) + 1;
        }
        // Verificar si tiene documentación: 
        if (!t.documentos || parseInt(t.documentos) !== 1) {
           sinDocumentacion++;
         }
        
        
      });

      // trabajador con más campañas
      let trabajadorFrecuente = "-";
      let maxCount = 0;
      for (const [nombre, count] of Object.entries(trabajadorCount)) {
        if (count > maxCount) {
          maxCount = count;
          trabajadorFrecuente = nombre;
        }
      }

      document.getElementById("totalTrabajadores").textContent = Object.keys(trabajadorCount).length;
      document.getElementById("trabajadorFrecuente").textContent = trabajadorFrecuente;
     document.getElementById("trabajadoresSinDocs").textContent = sinDocumentacion;
    })
    .catch((err) => console.error("Error al cargar trabajadores:", err));
}
function getContratistasPorProveedor(idProveedor) {
    fetch(`/controllers/ContController.php?action=listarContratistasPorProveedor&id_prov=${idProveedor}`)
      .then(res => res.json())
      .then(data => {
        console.log("Contratistas recibidos:", data);
        const contratistaCount = {};
        let contratistaReciente = null;    
  
        data.forEach(c => {
          const nombre = c.nombre;         
          const fecha = new Date(c.fecha_inicio); 
  
          if (nombre) {
            contratistaCount[nombre] = (contratistaCount[nombre] || 0) + 1;
          }
  
          if (!contratistaReciente || fecha > new Date(contratistaReciente.fecha)) {
            contratistaReciente = {nombre, fecha: c.fecha_inicio };
          }
        });
  
        // Contratista más frecuente
        let contratistaFrecuente = "-";
        let maxCount = 0;
        for (const [nombre, count] of Object.entries(contratistaCount)) {
          if (count > maxCount) {
            maxCount = count;
            contratistaFrecuente = nombre;
          }
        }
  
        document.getElementById("contratistasActivos").textContent = Object.keys(contratistaCount).length;
        document.getElementById("contratistaFrecuente").textContent = contratistaFrecuente;
        document.getElementById("contratistaReciente").textContent = contratistaReciente?.nombre || "-";
      })
      .catch(err => console.error("Error al cargar contratistas:", err));
  }
  function getFincasPorProveedor(idProveedor) {
    fetch(`/controllers/FincasController.php?action=listarFincasPorProveedor&id_prov=${idProveedor}`)
      .then(res => res.json())
      .then(data => {
        console.log("Fincas recibidas:", data);
  
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
  
        // Cultivo más común
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
  
  
  const userMeta = document.getElementById("userMeta");
  const idProveedor = userMeta?.dataset.idProv;
  
  if (idProveedor) {
    getProyectosPorProveedor(idProveedor);
    getContratistasPorProveedor(idProveedor);
    getTrabajadoresPorProveedor(idProveedor);
    getFincasPorProveedor(idProveedor);
  }
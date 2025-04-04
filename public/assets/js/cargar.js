function cargar(contenedor, url) {
    console.log(`Cargando ${url} en ${contenedor}...`);

    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            $(contenedor).html(data);
            console.log(`Contenido cargado correctamente desde ${url}`);
        },
        error: function (xhr, status, error) {
            console.error(`Error al cargar ${url}:`, error);
        }
    });
}


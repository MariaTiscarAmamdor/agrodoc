// Mostrar el modal al hacer clic en el icono de información
$('.informacion a').on('click', function(event) {
    event.preventDefault();
    $('#infoModal').fadeIn();
});

// Cerrar el modal al hacer clic en la "X"
$('.close').on('click', function() {
    $('#infoModal').fadeOut();
});

// Cerrar el modal si el usuario hace clic fuera del contenido
$(window).on('click', function(event) {
    if ($(event.target).is('#infoModal')) {
        $('#infoModal').fadeOut();
    }
});
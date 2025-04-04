
//Animación de movimiento hacia arriba y abajo (más suave)
function animateBadge() {
    $('#newBadge').animate({ 
        top: '55%' 
    }, 500).animate({
        top: '50%'
    }, 500, animateBadge);
}

animateBadge();

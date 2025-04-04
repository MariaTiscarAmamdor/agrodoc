$(function() {
    //seleccionamos elemento con id flip y le agregamos el controlador de eventos de clic,
    //para que cuando le hagamos clic a ese elemento se ejecuta la función interna 
    $("#p01").click( function() {        
        $("#r01").slideToggle('slow'); 
    });
    $("#p02").click( function() {       
        $("#r02").slideToggle('slow'); 
    });
    $("#p03").click( function() {        
        $("#r03").slideToggle('slow'); 
    });
    $("#p04").click( function() {        
        $("#r04").slideToggle('slow'); 
    });
    $("#p05").click( function() {        
        $("#r05").slideToggle('slow'); 
    });
    $("#p06").click( function() {       
        $("#r06").slideToggle('slow'); 
    });
});
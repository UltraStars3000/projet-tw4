$(function () {
    // activation des boutons
    /*
    $('.btn').click(function () {
        $(this).toggleClass('active');
        if ($(this).attr('id') == "monument") {
            if (subs(($('.leaflet-marker-icon')).attr('src'), "monument")) {
                $(this).each(function () {
                    if (typeof $(this).attr('hidden') !== 'undefined') {
                        $(this).removeAttr('hidden');
                    }
                    else {
                        $(this).attr('hidden', 'hidden');
                    }
                });
            }
        }
    });
    */
    //gestions de tout les bouttons un par uns car sinon ca bug sur tel
    var bool1 = true;
    $("#monument").click(function(e){
        var b = bool1;
        bool1 = !b;
        $(this).toggleClass('active');
        var listePin = $('.leaflet-marker-icon');
        //console.log(listePin);
        for(var i=0; i<listePin.length; i++){
            if(subs(($(listePin[i])).attr('src'),"monument")){
                
                ($(listePin[i])).attr('hidden',b);
            }
        }  
    });

    var bool2 = true;
    $("#parc").click(function(e){
        var b = bool2;
        bool2 = !b;
        $(this).toggleClass('active');
        var listePin = $('.leaflet-marker-icon');
        //console.log(listePin);
        for(var i=0; i<listePin.length; i++){
            if(subs(($(listePin[i])).attr('src'),"jardin")){
                
                ($(listePin[i])).attr('hidden',b);
            }
        }  
    });

    var bool3 = true;
    $("#biblio").click(function(e){
        var b = bool3;
        bool3 = !b;
        $(this).toggleClass('active');
        var listePin = $('.leaflet-marker-icon');
        //console.log(listePin);
        for(var i=0; i<listePin.length; i++){
            if(subs(($(listePin[i])).attr('src'),"bibliotheque")){
                
                ($(listePin[i])).attr('hidden',b);
            }
        }  
    });

    var bool4 = true;
    $("#culture").click(function(e){
        var b = bool4;
        bool4 = !b;
        $(this).toggleClass('active');
        var listePin = $('.leaflet-marker-icon');
        //console.log(listePin);
        for(var i=0; i<listePin.length; i++){
            if(subs(($(listePin[i])).attr('src'),"culture")){
                
                ($(listePin[i])).attr('hidden',b);
            }
        }  
    });
    
    
    
    
    $('#expand').click(function () {
        $('#map').requestFullscreen();
        //compress icon
    });
    

    function subs(src, sub) {
        var index = src.indexOf(sub);
        if (index !== -1) {
            return true
        }
        else {
            return false
        }
    }

});
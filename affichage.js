$(function () {
    // affichage des lieux ou non
    $('.btn').click(function () {
        $(this).toggleClass('active');
        if ($(this).attr('id') == "monument") {
            if (subs(($('.leaflet-marker-icon')).attr('src'), "monument")) {
                $('.leaflet-marker-icon').each(function () {
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

    // affichage du menu itinéraire
    $('#close').click(function () {
        if ($(".leaflet-routing-container").get(0).style.visibility == "hidden") {
            $(".leaflet-routing-container").get(0).style.visibility = "visible";
        }
        else {
            $(".leaflet-routing-container").get(0).style.visibility = "hidden";
        }
    });
    
    // mode plein écran
    $('#expand').click(function () {
        $('#map').requestFullscreen();
        //compress icon
    });

    // fonction de découpage de chaîne de caractères
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
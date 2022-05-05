$(function () {
    // activation des boutons
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

    $('#close').click(function () {
        if ($(".leaflet-routing-container").get(0).style.visibility == "hidden") {
            $(".leaflet-routing-container").get(0).style.visibility = "visible";
        }
        else {
            $(".leaflet-routing-container").get(0).style.visibility = "hidden";
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
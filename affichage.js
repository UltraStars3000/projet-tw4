$(function () {
    // activation des boutons
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

    $('#close').click(function () {
        if ($(".leaflet-routing-container").get(0).style.visibility == "hidden") {
            $(".leaflet-routing-container").get(0).style.visibility = "visible";
        }
        else {
            $(".leaflet-routing-container").get(0).style.visibility = "hidden";
        }
    });
});
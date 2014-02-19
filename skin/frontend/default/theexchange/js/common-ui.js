jQuery(document).ready(function(){


    jQuery('.navbar-nav > li.parent').each(function(){
        jQuery(this).hover(
            function() {
                jQuery( this ).addClass( 'open' );
            }, function() {
                jQuery( this ).removeClass('open' );
            }
        )
    });

    ///////fixed header

    var nav = jQuery('.header-container');

//    jQuery(window).scroll(function () {
//
//
//        if (jQuery(this).scrollTop() > 250) {
//            console.log(nav);
//            if (!nav.hasClass('f-nav')) {
//                nav.addClass("f-nav");
//            }
//        } else {
//            if (nav.hasClass('f-nav')) {
//                nav.removeClass("f-nav");
//            }
//        }
//    });

    jQuery( "#search" ).focus(function() {
        searchOverlay();
    });

    jQuery( "#search" ).blur(function() {
        jQuery('#overlay').remove();
        jQuery('.search-box').removeClass('overlay');
    });


    function searchOverlay(){
        var overlay = jQuery('<div id="overlay"> </div>');
        overlay.appendTo(document.body)

        jQuery('.search-box').addClass('overlay');
    }


});
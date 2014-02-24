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

    jQuery(window).bind('scroll', function() {
        if (jQuery(window).scrollTop() > 155) {
            jQuery('.header-container').addClass('f-nav');
        }
        else {
            jQuery('.header-container').removeClass('f-nav');
        }
    });

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
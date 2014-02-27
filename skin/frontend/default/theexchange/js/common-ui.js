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

    jQuery(window).bind('scroll', function(event) {
        var top = jQuery(window).scrollTop();
        var header = jQuery('.header-container');
        if (top > 159) {
            if (top >= 691 ){
                event.preventDefault();
            }
            header.addClass('f-nav');
            header.find('.header').hide();
        }
        else {
            if (header.hasClass('f-nav')) {
                header.removeClass('f-nav');
                header.find('.header').show();
            }
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
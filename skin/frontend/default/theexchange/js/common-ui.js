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
        jQuery('.navbar-container').removeClass('f-nav-sub');
        if (top > 400) {
            if (top >= 691 ){
                event.preventDefault();
            }
            header.addClass('f-nav');
            // header.find('.header').hide();
            jQuery('.fixed-container').show();
        }
        else {
            if (header.hasClass('f-nav')) {
               header.removeClass('f-nav');
               //header.find('.header').show();
                jQuery('.fixed-container').hide();
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

    jQuery('.best-seller-slider').bxSlider({
        nextSelector: '#slider-next',
        prevSelector: '#slider-prev',
        nextText: '→',
        prevText: '←',
    adaptiveHeight: true,
    minSlides: 4,
    slideWidth: 129,
    slideMargin: 10
    });

    jQuery('.f-nav-menu-link').live('click', function() {
        if (jQuery(window).scrollTop() >= 500 ){
            jQuery('.navbar-container').toggleClass('f-nav-sub');
        }
    });

    ///////////////////////////////

    jQuery("#narrow-by-list dt .plus-minus").each(function(){
        jQuery(this).click(function(){
            if(jQuery(this).parent().next("dd").css('display') == 'none'){
                jQuery(this).parent().next("dd").show();
               // alert('hide');
                jQuery(this).addClass('minus');

            } else {
                jQuery(this).parent().next("dd").hide();
                jQuery(this).removeClass('minus');
                jQuery(this).addClass('plus');
            }
        })
    })
});
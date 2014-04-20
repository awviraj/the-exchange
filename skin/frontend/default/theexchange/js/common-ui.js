jQuery.fn.scrollTo = function( target, options, callback ){
    if(typeof options == 'function' && arguments.length == 2){ callback = options; options = target; }
    var settings = $.extend({
        scrollTarget  : target,
        offsetTop     : 50,
        duration      : 500,
        easing        : 'swing'
    }, options);
    return this.each(function(){
        var scrollPane = $(this);
        var scrollTarget = (typeof settings.scrollTarget == "number") ? settings.scrollTarget : $(settings.scrollTarget);
        var scrollY = (typeof scrollTarget == "number") ? scrollTarget : scrollTarget.offset().top + scrollPane.scrollTop() - parseInt(settings.offsetTop);
        scrollPane.animate({scrollTop : scrollY }, parseInt(settings.duration), settings.easing, function(){
            if (typeof callback == 'function') { callback.call(this); }
        });
    });
}

jQuery(document).ready(function(){


    ///////////newly added slider//////////////

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
        searchOverlay(this);
    });

    jQuery( "#search" ).blur(function() {
        removeOverlay(jQuery('.search-box'));
    });

    jQuery(".form-search .search-close").click(function(){
        jQuery(".search-box").slideUp();
    })
    jQuery(".fixed-container li.search a").click(function(){
        jQuery('html, body').animate({
            scrollTop: jQuery(".search-box").offset().top
        }, 400);
        //jQuery(".search-box").slideToggle();

    })


jQuery('.parentMenu').each(function(){
    jQuery(this).hover(
        function() {
            //bxcall();
        }, function() {
            //jQuery( this ).removeClass('open' );
        }
    )
})

    ///////////mobile menu
    jQuery( '#dl-menu' ).dlmenu({
        animationClasses : { classin : 'dl-animate-in-2', classout : 'dl-animate-out-2' }
    });

    var docHeight= jQuery('body').height();
    jQuery('.dl-menuwrapper ul').height(docHeight);

//    jQuery('.best-seller-slider').bxSlider({
//        nextSelector: '#slider-next',
//        prevSelector: '#slider-prev',
//        nextText: '→',
//        prevText: '←',
//        adaptiveHeight: true,
//        maxSlides: 3,
//        slideMargin: 15
//        // pager:false,
//    });

    //Product Media More views Thumbnail Slider
    if (jQuery(".more-views li").length > 3) {
        jQuery(".more-views ul").bxSlider({
            auto:false,
            pager:false,
            slideWidth: 99,
            minSlides: 3,
            maxSlides: 5,
            controls: true,
            slideMargin:12,
            moveSlides:1,
            nextSelector: '#more-views-next',
            prevSelector: '#more-views-prev'
        });
    }

    jQuery('.home-slider').bxSlider({
        auto: true,
        autoControls: false,
        pause: 3000,
        pager:false,
        controls: true,
        pager:true

    });

    jQuery( document ).on( "click", ".f-nav-menu-link", function() {
    //jQuery('.f-nav-menu-link').live('click', function() {
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

//Popup menu background shading
function searchOverlay(elm){
    var overlay = jQuery('<div id="overlay"> </div>');
    overlay.appendTo(document.body)

    jQuery('body').addClass('overlay');
}
//Popup menu background shading removal
function removeOverlay(elm){
    jQuery('#overlay').remove();
    jQuery('body').removeClass('overlay');
}

function showLoader(selector) {
    var parentElm = jQuery(selector);
    var wrapper = '<div class="ajax-submit-loader" >'
        + '<div class="loading-overlay" style="width:300px; height: 300px; background-color: red;">DILHAN</div>'
        + '<span class="loader"></span>';
    +'</div>';
    parentElm.append(wrapper);
}

function hideLoader(selector) {
    jQuery(selector).find('.ajax-submit-loader').remove();
}
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

///my account drop down

    jQuery(".quick-access .links li a.top-link-customer").not(".fixed-nav-links.quick-access .links li a.top-link-customer").click(function(event){
        jQuery('.account-drop-down').slideToggle(300);
        jQuery(this).toggleClass('clicked');
        event.preventDefault();
    })
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

    })

    ///////////mobile menu


    jQuery('.wrapper').addClass('canvas');
   createMobileMenu();
    if(jQuery(window).width() < 768){
        //createMobileMenu();
        console.log('11')
        if (jQuery('.m-menu-wrapper .navbar-container').length > 0){
            return;
        }
        else{
          createMobileMenu();
            console.log('11')
        }


    }

    jQuery(window).resize(function(){
        if(jQuery(window).width() < 768){
            if (jQuery('.m-menu-wrapper .navbar-container').length > 0){
               return;
            }
            else{
                createMobileMenu();
            }
        }
    })

    jQuery(".navbar-container").clone().prependTo(".m-menu-wrapper");
    jQuery(".menu-search-wrapper .cl-effect-21").clone().prependTo(".m-menu-wrapper");
    console.log('222')
    jQuery('<h2>Our products</h2>').prependTo("#custommenu");

    function createMobileMenu(){
//        jQuery(".navbar-container").clone().prependTo(".m-menu-wrapper");
//       jQuery(".cms-menu .cl-effect-21").clone().prependTo(".m-menu-wrapper");
//        console.log('222')
//        jQuery('<h2>Our products</h2>').prependTo("#custommenu");
    }
    function menuReset(){
       // jQuery(".navbar-container").prependTo(".page")
    }
    function closeMMenu(){

    }
    jQuery('.m-nav-menu-link').click(function() {
        // Calling a function in case you want to expand upon this.
        toggleNav();
    });
    jQuery('.m-close').click(function(){
        toggleNav();
    })

    function toggleNav() {

        if (jQuery('#site-wrapper').hasClass('show-nav')) {
            // Do things on Nav Close
            jQuery('#site-wrapper').removeClass('show-nav');
        } else {
            // Do things on Nav Open
            jQuery('#site-wrapper').addClass('show-nav');
        }

    }

//    jQuery( '#dl-menu' ).dlmenu({
//        animationClasses : { in : 'dl-animate-in-3', out : 'dl-animate-out-3' }
//    });

    var docHeight= jQuery('body').height();
    var bodyWidth= jQuery('.wrapper').width();
   // jQuery('.dl-menuwrapper ul').height(docHeight);
    jQuery('.dl-menuwrapper ul').width(bodyWidth - 45);


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

    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 100) {
            jQuery('.scrollup').fadeIn();
        } else {
            jQuery('.scrollup').fadeOut();
        }
    });

    jQuery('.scrollup').click(function () {
        jQuery("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
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
        + '<div class="loading-overlay"><span class="loader"></span></div>'
        + '</div>';
    parentElm.append(wrapper);
}

function hideLoader(selector) {
    jQuery(selector).find('.ajax-submit-loader').remove();
}
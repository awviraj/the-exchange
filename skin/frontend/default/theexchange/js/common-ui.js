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


});
/**
 * Created with JetBrains PhpStorm.
 * User: Dilhan
 * Date: 3/2/14
 * Time: 10:38 PM
 * To change this template use File | Settings | File Templates.
 */
jQuery(document).ready(function () {
//    jQuery('.products-grid li').mouseenter(function (){
//        jQuery(this).addClass('category-list-hover');
//    });

    jQuery('.products-grid li.item').hover(function (){
        jQuery(this).addClass('active');
    },
    function (){
        jQuery(this).removeClass('active');
    }
    );

//    jQuery('.products-grid li').mouseout(function (){
//        jQuery(this).removeClass('category-list-hover');
//    });

});
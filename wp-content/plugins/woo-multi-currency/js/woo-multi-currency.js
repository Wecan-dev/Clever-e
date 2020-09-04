'use strict';
jQuery(document).ready(function () {
    woocommerce_multi_currency.init();
});
var woocommerce_multi_currency = {
    init: function () {
        this.design();
    },
    design: function () {
        var windowsize = jQuery(window).width();
        if (windowsize <= 768) {
            jQuery('.woo-multi-currency.wmc-sidebar').on('click', function () {
                jQuery(this).toggleClass('wmc-hover');
                if (jQuery(this).hasClass('wmc-hover')) {
                    jQuery('html').css({'overflow': 'hidden'});
                } else {
                    jQuery('html').css({'overflow': 'visible'});
                }
            })
        } else {
            /*replace hover with mouseenter mouseleave in some cases to work correctly*/
            jQuery('.woo-multi-currency.wmc-sidebar').on('mouseenter mouseleave', function () {
                jQuery(this).toggleClass('wmc-hover');
            })
        }
    },

}
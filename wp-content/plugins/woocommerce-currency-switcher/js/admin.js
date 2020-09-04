(function ($, window) {

    'use strict';
    jQuery(function () {
        "use strict";
        jQuery('.form-table .forminp #woocommerce_currency').parents('tr').remove();
        jQuery('.form-table .forminp #woocommerce_currency_pos').parents('tr').remove();

    });
    $.fn.wfcTabs = function (options) {

        if (!this.length)
            return;

        return this.each(function () {

            var $this = $(this);

            ({
                init: function () {
                    this.tabsNav = $this.children('nav');
                    this.items = $this.children('.content-wrap').children('section');
                    this._show();
                    this._initEvents();
                },
                _initEvents: function () {
                    var self = this;
                    this.tabsNav.on('click', 'a', function (e) {
                        e.preventDefault();
                        self._show($(this));
                    });
                },
                _show: function (element) {

                    if (element == undefined) {
                        this.firsTab = this.tabsNav.find('li').first();
                        this.firstSection = this.items.first();

                        if (!this.firsTab.hasClass('tab-current')) {
                            this.firsTab.addClass('tab-current');
                        }

                        if (!this.firstSection.hasClass('content-current')) {
                            this.firstSection.addClass('content-current');
                        }
                    }

                    var $this = $(element),
                            $to = $($this.attr('href'));

                    if ($to.length) {
                        $this.parent('li').siblings().removeClass().end().addClass('tab-current');
                        $to.siblings().removeClass().end().addClass('content-current');
                    }

                }

            }).init();

        });
    };


})(jQuery, window);

jQuery(function ($) {

    jQuery.fn.life = function (types, data, fn) {
        jQuery(this.context).on(types, this.selector, data, fn);
        return this;
    };

    jQuery('body').append('<div id="woocs_buffer" style="display: none;"></div>');

});


function woocs_insert_html_in_buffer(html) {
    jQuery('#woocs_buffer').html(html);
}
function woocs_get_html_from_buffer() {
    return jQuery('#woocs_buffer').html();
}

function woocs_show_info_popup(text, delay) {
    jQuery(".info_popup").text(text);
    jQuery(".info_popup").fadeTo(400, 0.9);
    window.setTimeout(function () {
        jQuery(".info_popup").fadeOut(400);
    }, delay);
}

function woocs_show_stat_info_popup(text) {
    jQuery(".info_popup").text(text);
    jQuery(".info_popup").fadeTo(400, 0.9);
}


function woocs_hide_stat_info_popup() {
    window.setTimeout(function () {
        jQuery(".info_popup").fadeOut(400);
    }, 500);
}
function woocs_auto_hide_color() {
    if (jQuery('#woocs_is_auto_switcher').val() == 0) {
        jQuery('#woocs_auto_switcher_color').parents('tr').hide();
        jQuery('#woocs_auto_switcher_hover_color').parents('tr').hide();
    }
}
woocs_auto_hide_color();

function woocs_check_api_key_field() {
    var aggregator = jQuery("#woocs_currencies_aggregator").val();
    var is_api = ['free_converter', 'fixer', 'currencylayer', 'openexchangerates'];
    if (jQuery.inArray(aggregator, is_api) != -1) {
        jQuery("#woocs_aggregator_key").parents("tr").show();
    } else {
        jQuery("#woocs_aggregator_key").parents("tr").hide();
    }
}

woocs_check_api_key_field();
jQuery("#woocs_currencies_aggregator").change(function () {
    woocs_check_api_key_field();
});



function woocs_set_cookie(name, value, days = 365) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function woocs_get_cookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0)
            return c.substring(nameEQ.length, c.length);
    }
    return null;
}


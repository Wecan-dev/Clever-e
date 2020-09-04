'use strict';
jQuery(document).ready(function () {
	jQuery('.vi-ui.tabular.menu .item').vi_tab({
		history    : true,
		historyType: 'hash'
	});

	/*Setup tab*/
    var tabs,
        tabEvent = false,
        initialTab = 'general',
        navSelector = '.vi-ui.menu',
        navFilter = function (el) {
            // return jQuery(el).attr('href').replace(/^#/, '');
        },
        panelSelector = '.vi-ui.tab',
        panelFilter = function () {
            jQuery(panelSelector + ' a').filter(function () {
                return jQuery(navSelector + ' a[title=' + jQuery(this).attr('title') + ']').size() != 0;
            });
        };

    // Initializes plugin features
    jQuery.address.strict(false).wrap(true);

    if (jQuery.address.value() == '') {
        jQuery.address.history(false).value(initialTab).history(true);
    }

    // Address handler
    jQuery.address.init(function (event) {

        // Adds the ID in a lazy manner to prevent scrolling
        jQuery(panelSelector).attr('id', initialTab);

        panelFilter();

        // Tabs setup
        tabs = jQuery('.vi-ui.menu')
            .vi_tab({
                history: true,
                historyType: 'hash'
            })

        // Enables the plugin for all the tabs
        jQuery(navSelector + ' a').click(function (event) {
            tabEvent = true;
            // jQuery.address.value(navFilter(event.target));
            tabEvent = false;
            return true;
        });

    });


	/*Init JS input*/
	jQuery('.vi-ui.checkbox').checkbox();
	jQuery('select.vi-ui.dropdown').dropdown();
	jQuery('.select2').select2();
	/*Select all and Remove all countries in Currency by country*/
	jQuery('.wmc-select-all-countries').on('click', function () {
		var selectedItems = [];
		var allOptions = jQuery(this).closest('tr').find('select');
		allOptions.find('option').each(function () {
			jQuery(this).attr('selected', true);
		});
		allOptions.trigger("change");
	});

	jQuery('.wmc-remove-all-countries').on('click', function () {
		if (confirm("Would you want to remove all countries?")) {
			var selectedItems = [];
			var allOptions = jQuery(this).closest('tr').find('select');
			allOptions.find('option').each(function () {
				jQuery(this).removeAttr('selected', true);
			});
			allOptions.trigger("change");
		}
	});

	// jQuery("#IncludeFieldsMulti").select2("val", selectedItems);


	/*Save Submit button*/
	jQuery('.wmc-submit').one('click', function () {
		jQuery(this).addClass('loading');
	});
	jQuery('.select2-multiple').select2({
		width: '100%' // need to override the changed default
	});
	/*Color picker*/
	jQuery('.color-picker').iris({
		change: function (event, ui) {
			jQuery(this).parent().find('.color-picker').css({backgroundColor: ui.color.toString()});
			var ele = jQuery(this).data('ele');
			if (ele == 'highlight') {
				jQuery('#message-purchased').find('a').css({'color': ui.color.toString()});
			} else if (ele == 'textcolor') {
				jQuery('#message-purchased').css({'color': ui.color.toString()});
			} else {
				jQuery('#message-purchased').css({backgroundColor: ui.color.toString()});
			}
		},
		hide  : true,
		border: true
	}).click(function () {
		jQuery('.iris-picker').hide();
		jQuery(this).closest('td').find('.iris-picker').show();
	});

	jQuery('body').click(function () {
		jQuery('.iris-picker').hide();
	});
	jQuery('.color-picker').click(function (event) {
		event.stopPropagation();
	});
	/*Update all rates*/
	jQuery('.wmc-update-rates').on('click', function () {
		var original_currency = jQuery('.wmc-currency-data input[name="woo_multi_currency_params[currency_default]"]:checked').val();
		var other_currencies = [];
		jQuery('.wmc-currency-options').find('input[name="woo_multi_currency_params[currency_default]"]').each(function () {
			if (original_currency != jQuery(this).val()) {
				other_currencies.push(jQuery(this).val());
			}
		});
		jQuery(this).addClass('loading');
		exchange_rate(original_currency, other_currencies);
	});

	/*Process Currency Options*/
	remove_currency();

	function insert_currency() {
		jQuery('.vi-ui.checkbox').unbind();
		jQuery('.vi-ui.checkbox').checkbox();

		jQuery('.wmc-add-currency').unbind();
		jQuery('.wmc-add-currency').on('click', function () {
			if (jQuery('.wmc-currency-data').length >= 2) {
				alert('Please upgrade to Premium version');
				return;
			}
			jQuery('.wmc-currency-data').last().find('select.select2').select2('destroy');
			var new_row = jQuery('.wmc-currency-data').last().clone();
			jQuery('.wmc-currency-data').last().find('select.select2').select2();
			new_row.find('input[name="woo_multi_currency_params[currency_default]"]').attr('checked', false);
			jQuery(new_row).appendTo('.wmc-currency-options tbody');
			remove_currency();
			jQuery('.wmc-currency-data').last().find('select.select2').select2().change();

		});

		jQuery('select[name="woo_multi_currency_params[currency][]"]').on('change', function () {
			var val = jQuery(this).val();
			jQuery(this).closest('tr').find('input[name="woo_multi_currency_params[currency_default]"]').val(val);
			jQuery(this).closest('tr').removeAttr('class').addClass('wmc-currency-data ' + val + '-currency');
		});

		jQuery('.wmc-currency-options tbody').sortable();

		/*Change currency default*/
		jQuery('input[name="woo_multi_currency_params[currency_default]"]').unbind('change');
		jQuery('input[name="woo_multi_currency_params[currency_default]"]').on('change', function () {
			jQuery('.wmc-currency-options').find('input[name="woo_multi_currency_params[currency_rate][]"]').removeAttr('readonly');
			jQuery('.wmc-currency-options').find('input[name="woo_multi_currency_params[currency_rate_fee][]"]').removeAttr('readonly');
			jQuery(this).closest('tr').find('input[name="woo_multi_currency_params[currency_rate][]"]').val(1).attr('readonly', true);
			jQuery(this).closest('tr').find('input[name="woo_multi_currency_params[currency_rate_fee][]"]').val(0).attr('readonly', true);
			var original_currency = jQuery(this).val();
			var other_currencies = [];
			jQuery('.wmc-currency-options').find('input[name="woo_multi_currency_params[currency_default]"]').each(function () {
				if (original_currency != jQuery(this).val()) {
					other_currencies.push(jQuery(this).val());
				}
			});
			exchange_rate(original_currency, other_currencies);
		});

		/*Update single rate*/
		jQuery('.wmc-update-rate').on('click', function () {

			var original_currency = jQuery('.wmc-currency-data input[name="woo_multi_currency_params[currency_default]"]:checked').val();
			var other_currencies = jQuery(this).closest('tr').find('input[name="woo_multi_currency_params[currency_default]"]').val();

			if (original_currency != other_currencies) {
				jQuery(this).addClass('loading');
				exchange_rate(original_currency, other_currencies);
			}
		});

	}

	function remove_currency() {
		jQuery('.wmc-remove-currency').unbind();
		insert_currency();
		jQuery('.wmc-remove-currency').on('click', function () {
			if (confirm("Would you want to remove this currency?")) {
				if (jQuery('.wmc-currency-options tbody tr').length > 1) {
					var tr = jQuery(this).closest('tr').remove();
				}
			} else {

			}
		});
	}

	function exchange_rate(original_currency, other_currencies) {
		if (original_currency && other_currencies) {
			var str_data = 'original_price=' + original_currency + '&other_currencies=' + other_currencies;

			jQuery.ajax({
				type   : 'POST',
				data   : 'action=woomulticurrency_exchange&' + str_data,
				url    : ajaxurl,
				success: function (obj) {
					jQuery.each(obj, function (currency, rate) {
						if (jQuery('tr.' + currency + '-currency').length > 0) {
							jQuery('tr.' + currency + '-currency').find('input[name="woo_multi_currency_params[currency_rate][]"]').val(rate);
						}
						jQuery('.woo-multi-currency').find('.loading').removeClass('loading');
					});
				},
				error  : function (html) {
				}
			})
		} else {
			return false;
		}

	}


	/*Checkout currency*/
	jQuery('input[name="woo_multi_currency_params[checkout_currency]"]').on('change', function () {
		jQuery('select[name="woo_multi_currency_params[checkout_currency_args][]"]').removeAttr('disabled');
		jQuery(this).closest('tr').find('select[name="woo_multi_currency_params[checkout_currency_args][]"]').attr('disabled', 'disabled').find('option').removeAttr('selected').last().attr('selected', true);
	})
});
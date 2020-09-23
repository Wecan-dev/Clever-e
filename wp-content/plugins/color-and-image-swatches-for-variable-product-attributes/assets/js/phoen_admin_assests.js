jQuery(document).ready(function($) {
	
	jQuery('.field_form_mask').hide();
	
	jQuery(".phoen_show_bicolor").change(function(){
		
		if (jQuery(this).is(':checked')) {
				jQuery(".phoen_bicolor_add").show();
		}else{
			jQuery(".phoen_bicolor_add").hide();
		}
		
		
	});
	//console.log($('#_swatch_type').val() == 'pickers');
//console.log ($('#_swatch_type').val());
	
	/* var current_field_wrapper;

	window.send_to_editor_default = window.send_to_editor; */

	/* jQuery('#swatches').on('click', '.upload_image_button, .remove_image_button', function() {

	var post_id = jQuery(this).attr('rel');
	var parent = jQuery(this).parent();
	current_field_wrapper = parent;

	if (jQuery(this).is('.remove_image_button')) {

	jQuery('.upload_image_id', current_field_wrapper).val('');
	jQuery('img', current_field_wrapper).attr('src', '<?php echo woocommerce_placeholder_img_src(); ?>');
	jQuery(this).removeClass('remove');

	} else {
 
	window.send_to_editor = window.send_to_pidroduct;
	formfield = jQuery('.upload_image_id', parent).attr('name');
	tb_show('', 'media-upload.php?&amp;type=image&amp;TB_iframe=true');
	}

	return false;
	});  */

	/* window.send_to_pidroduct = function(html) {

	jQuery('body').append('<div id="temp_image">' + html + '</div>');

	var img = jQuery('#temp_image').find('img');

	imgurl 		= img.attr('src');
	imgclass 	= img.attr('class');
	imgid		= parseInt(imgclass.replace(/\D/g, ''), 10);

	jQuery('.upload_image_id', current_field_wrapper).val(imgid);
	jQuery('img', current_field_wrapper).attr('src', imgurl);
	var $preview = jQuery(current_field_wrapper).closest('div.sub_field').find('.swatch-wrapper');
	jQuery('img', $preview).attr('src', imgurl);
	tb_remove();
	jQuery('#temp_image').remove();

	window.send_to_editor = window.send_to_editor_default;
	} */
	
	jQuery('.woo-color').wpColorPicker();
	
	function jq(selector) {
		return selector.replace(/[!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~]/g, "\\\\$&");
	}


	if ($('#_swatch_type').val() == 'pickers') {
		$('#phoe_swatch_options').show();
	} else {
		$('#phoe_swatch_options').hide();
	}

	$("#_swatch_type").change(function() {
		if ($(this).val() == 'pickers') {
			$('#phoe_swatch_options').show();
		} else {
			$('#phoe_swatch_options').hide();
		}
	});



	// add edit button functionality
	$('#swatches a.wcsap_edit_field').click(function(event) {
		event.preventDefault();

		var field = $(this).closest('.field');

		if (field.hasClass('form_open'))
		{
			field.removeClass('form_open');
		}
		else
		{
			field.addClass('form_open');
		}

		field.children('.field_form_mask').animate({
			'height': 'toggle'
		}, 500);

		return false;

	});

	$('.wcsap_field_meta').click(function(event) {
		event.preventDefault();
		event.stopPropagation();

		var field = $(this).closest('.field');

		if (field.hasClass('form_open'))
		{
			field.removeClass('form_open');
		}
		else
		{
			field.addClass('form_open');
		}

		field.children('.field_form_mask').animate({
			'height': 'toggle'
		}, 500);

		return false;
	});


	$('.attribute_swatch_preview').delegate('a', 'click', function(event) {
		event.preventDefault();

		var field = $(this).closest('.field');

		if (field.hasClass('form_open'))
		{
			field.removeClass('form_open');
		}
		else
		{
			field.addClass('form_open');
		}

		field.children('.field_form_mask').animate({
			'height': 'toggle'
		}, 500);

		return false;

	})


	$('.section-color-swatch').each(function() {

		var option_id = $(this).find('.woo-color').attr('id');
		var color = $(this).find('.woo-color').val();
		var preview_id = option_id + '_preview_swatch';
		var picker_id = option_id += '_picker';
		
		
		
		/* $('#' + picker_id).children('div').css('backgroundColor', color);
		$('#' + picker_id).ColorPicker({
			color: color,
			onShow: function(colpkr) {
				jQuery(colpkr).fadeIn(200);
				return false;
			},
			onHide: function(colpkr) {
				jQuery(colpkr).fadeOut(200);
				return false;
			},
			onChange: function(hsb, hex, rgb) {
				$('#' + picker_id).children('div').css('backgroundColor', '#' + hex);
				$('#' + preview_id).css('backgroundColor', '#' + hex);
				$('#' + picker_id).next('input').attr('value', '#' + hex);

			}
		}); */
	});

	$('select.phoe_swatch_options_attribute_type').change(function() {
		var $parent = $(this).closest('table.wcsap_input');

		$parent.find('.field_option').hide();
		$parent.find('.field_option_' + $(this).val()).show();


		var $preview = $(this).closest('div.sub_field').find('.swatch-wrapper');
		// alert(JSON.stringify($preview));
		
		
		if ($(this).val() == 'icon') {
			jQuery(this).closest(".wcsap_input.widefat").find(".iconpicker-input").closest(".form-field").show();
		}else{
			jQuery(this).closest(".wcsap_input.widefat").find(".iconpicker-input").closest(".form-field").hide();
		}
		if ($(this).val() == 'image') {
			$('a.swatch', $preview).hide();
			$('a.image', $preview).show();
				// alert(5);
		} else {
			// alert(1);
			$('a.image', $preview).hide();
			$('a.swatch', $preview).show();

		}
	});

	$('select.phoe_swatch_options_type').change(function() {
		var $parent = $(this).closest('tbody', 'table.wcsap_input');

		$parent.children('.field_option').hide();
		$parent.find('.field_option_' + $(this).val()).show();

	});
	
	

});
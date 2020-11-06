jQuery(document).ready(function ($) {

    //FUNCTION AREA

     var  init_gallery  = function ( woocommerce_gallery ) {
            woocommerce_gallery.each( function () {
                var featured_index = $(this).index(),
                    video = null;


                if( $(this).hasClass('ywcfav_video_modal_container')){
                    video = $(this);
                }else {
                    video = $(this).find('.ywcfav-audio-content iframe,.ywcfav-video-content iframe,.ywcfav-video-content div.iframe,.ywcfav-video-content video, .ywcfav_video_embedded_iframe');
                }
                video = $(video[0]);


                var featured_gallery_thumbnail = $(ywcfav_params.thumbnail_gallery_class_element).get(featured_index),
                    video_id = video.attr('id');

                video_id = video_id.replace('_html5_api','');

                $(featured_gallery_thumbnail).addClass('yith_featured_thumbnail');
                $(featured_gallery_thumbnail).find('img').attr('id', video_id );
                $(document).trigger('yith_featured_gallery_single_item_initialized',[$(featured_gallery_thumbnail), $(this)] );

            });

            $(document).trigger('yith_featured_gallery_initialized',[woocommerce_gallery]);
        };



    var custom_content = $(document).find(ywcfav_params.img_class_container + '.yith_featured_content,'+ywcfav_params.img_class_container+'.ywcfav_video_modal_container');

    var flexslider_enabled = $(document).find(ywcfav_params.img_class_container).length > 1;


    init_gallery( custom_content);


    if( ywcfav_params.trigger_variation ) {

        $('.variations_form.cart').on('show_variation', function (e, variation) {


            setTimeout(function () {

                var video_id = typeof variation.variation_video !== 'undefined' ? variation.variation_video : false;

                if (video_id) {

                    var slide_To = $(ywcfav_params.thumbnail_gallery_class_element).find('img#' + video_id);

                    slide_To.trigger('click');

                } else {

                    var product_gallery = $(document).find(ywcfav_params.thumbnail_gallery_class_element),
                        slideToImage = product_gallery.find('img[src="' + variation.image.gallery_thumbnail_src + '"]');

                    var variable_featured_content = $(document).find(ywcfav_params.img_class_container).get(0);

                    if ($(variable_featured_content).length && ($(variable_featured_content).hasClass('yith_featured_content') || $(variable_featured_content).hasClass('ywcfav_video_modal_container'))) {

                        init_zoom_on_image($(variable_featured_content), variation);

                    }
                    $(window).trigger('resize');

                    slideToImage.trigger('click');

                }
            }, 101);
        }).on('reset_data', function (e) {

            setTimeout(function () {
                var current_content = $(document).find(ywcfav_params.img_class_container + ywcfav_args.current_slide_active_class),
                    current_index = current_content.index();
                if (0 == current_index && current_content.hasClass('yith_featured_content')) {

                    remove_zoom_on_image(current_content);
                }
                $(window).trigger('resize');
                current_content.trigger('woocommerce_gallery_init_zoom');
            }, 100);

        });

        var init_zoom_on_image = function (target, variation) {

                var div_to_hide = target.find('div[class^="ywcfav"]:eq(0)'),
                    a = $('<a>'),
                    img = $('<img>'),
                    gallery = $(ywcfav_params.thumbnail_gallery_class_element).get(0),
                    is_modal = false;

                if (!div_to_hide.length) {

                    div_to_hide = target.find('a.ywcfav_show_modal');
                    div_to_hide.parent().removeClass('ywcfav_video_modal_container');
                    is_modal = true;

                }
                $(ywcfav_args.product_gallery_trigger_class).show();
                div_to_hide.hide();
                $(gallery).removeClass('yith_featured_thumbnail');

                if (!flexslider_enabled && target.find('a.ywfav_zoom_image').length) {
                    target.find('a.ywfav_zoom_image').remove();
                }

                if (!target.find('a.ywfav_zoom_image').length) {
                    a.attr('href', variation.image.full_src);
                    a.addClass('ywfav_zoom_image');
                    img.attr('src', variation.image.src);
                    img.attr('height', variation.image.src_h);
                    img.attr('width', variation.image.src_w);
                    img.attr('srcset', variation.image.srcset);
                    img.attr('sizes', variation.image.sizes);
                    img.attr('title', variation.image.title);
                    img.attr('data-caption', variation.image.caption);
                    img.attr('alt', variation.image.alt);
                    img.attr('data-src', variation.image.full_src);
                    img.attr('data-large_image', variation.image.full_src);
                    img.attr('data-large_image_width', variation.image.full_src_w);
                    img.attr('data-large_image_height', variation.image.full_src_h);
                    img.addClass('ywfav_zoom_image');
                    a.append(img);


                    if (is_modal) {
                        a.insertBefore(target.find('a.ywcfav_show_modal'));
                    } else {
                        target.append(a);
                    }
                    if (typeof target.zoom !== 'undefined') {
                        target.trigger('zoom.destroy');

                        var zoom_options = $.extend({
                            touch: false,
                            url: variation.image.full_src
                        }, ywcfav_params.zoom_options);

                        if ('ontouchstart' in document.documentElement) {
                            zoom_options.on = 'click';
                        }

                        if (typeof zoom !== 'undefined') {
                            target.zoom(zoom_options);
                        }
                    }

                }
            },
            remove_zoom_on_image = function (target) {
                target.trigger('zoom.destroy');
                target.find('.ywfav_zoom_image').remove();

                var gallery = $(ywcfav_params.thumbnail_gallery_class_element).get(0),
                    div_to_show = target.find('div[class^="ywcfav"]:eq(0)');

                if (target.find('a.ywcfav_show_modal').length) {
                    target.find('a.ywcfav_show_modal').show();
                    target.addClass('ywcfav_video_modal_container');

                    var a = target.find('a.ywcfav_show_modal');
                    a.attr('href', a.data('o_href'));
                }
                $(gallery).addClass('yith_featured_thumbnail');
                div_to_show.show();
                $(ywcfav_args.product_gallery_trigger_class).hide();
                $(window).trigger('resize');
                $(target).trigger('woocommerce_gallery_init_zoom');
                div_to_show.trigger('woocommerce_gallery_init_zoom');
            };

        var flexslider = $('.woocommerce-product-gallery').data('flexslider');


        if (flexslider) {

            flexslider.vars.before = function (slider) {

                var current_index = slider.currentSlide,
                    img = $(ywcfav_params.thumbnail_gallery_class_element).find('img').get(current_index);

                if ($(img).parent('li').hasClass('yith_featured_thumbnail')) {

                    $(document).trigger('ywcfav_before_slide_show', $(img).attr('id'));
                }
            };

            var wc_after = flexslider.vars.after;

            flexslider.vars.after = function (slider) {

                wc_after(slider);
                var current_index = slider.currentSlide,
                    img = $(ywcfav_params.thumbnail_gallery_class_element).find('img').get(current_index),
                    video_id = typeof $(img).attr('id') !== 'undefined' ? $(img).attr('id') : false;

                $(document).trigger('ywcfav_after_slide_show', video_id);

                setTimeout(function () {
                    $(window).trigger('resize');
                }, 100);
            };

        }
    }

});
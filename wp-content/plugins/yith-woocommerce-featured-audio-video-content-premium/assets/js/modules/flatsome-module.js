jQuery(document).ready(function ($) {

    var slider = $(document).find('.' + ywcfav_flatsome_args.gallery_image_class),
        current_index = 0;

    slider.on('ready.flickity', function (e) {


        var featured_contents = slider.find(' .yith_featured_content,.ywcfav_video_modal_container');

        featured_contents.each(function () {
            var single_content = $(this),
                data_url = single_content.data('thumb'),
                video = '',
                video_id = '';


            if (single_content.parents('.ywcfav_slider_wrapper').length === 0) {
                if (single_content.hasClass('ywcfav_video_modal_container')) {
                    video = $(this);
                } else {
                    video = single_content.find('.ywcfav-audio-content iframe,.ywcfav-video-content iframe,.ywcfav-video-content div.iframe,.ywcfav-video-content video, .ywcfav_video_embedded_iframe');
                }
                video = $(video[0]);
                video_id = video.attr('id');


                if (!$(document).find('.col img#' + video_id).length) {
                    var img = $('<img>'),
                        a = $('<a>'),
                        div = $('<div>');
                    div.addClass('col');
                    div.addClass('yith_featured_thumbnail');

                    img.attr('src', data_url);
                    img.attr('id', video_id);
                    a.append(img);
                    div.append(a);

                    $('.product-thumbnails').append(div);
                }

                var video_gallery = $(document).find('.ywcfav_thumbnails_video_container'),
                    audio_gallery = $(document).find('.ywcfav_thumbnails_audio_container');

                if (video_gallery.length) {
                    video_gallery.appendTo($('.' + ywcfav_flatsome_args.gallery_container));
                }

                if (audio_gallery.length) {
                    audio_gallery.appendTo($('.' + ywcfav_flatsome_args.gallery_container));
                }
            }
        });

    });
    slider.on('change.flickity', function (event, index) {

        var prev_slider = $(document).find('.product-thumbnails .col').get(current_index),
            next_slider = $(document).find('.product-thumbnails .col').get(index),
            video_id = '';

        if ($(prev_slider).hasClass('yith_featured_thumbnail')) {
            video_id = $(prev_slider).find('img').attr('id');
        }
        $(document).trigger('ywcfav_before_slide_show', video_id);
        if ($(next_slider).hasClass('yith_featured_thumbnail')) {
            video_id = $(next_slider).find('img').attr('id');
        }
        $(document).trigger('ywcfav_after_slide_show', video_id);
        current_index = index;


    });

    $('.variations_form.cart').on('show_variation', function (e, variation) {

        var video_id = typeof variation.variation_video !== 'undefined' ? variation.variation_video : false;

        if (video_id) {

            var slide_To = $(ywcfav_params.thumbnail_gallery_class_element).find('img#' + video_id);

            slide_To = slide_To.closest('div.col').index();
            slider.flickity("select", slide_To);
        } else {
            slider.flickity("select", 0);
            setTimeout(function () {
                slider.flickity("resize" );
            }, 500 );


        }
    }).on('reset_data', function (e) {
        var featured_content = $( slider.find(' .yith_featured_content,.ywcfav_video_modal_container').get(0) );

        if( featured_content.length && 0 === featured_content.index() ){
            var img_src = featured_content.data('thumb'),
                thumbnail = $(ywcfav_params.thumbnail_gallery_class_element).get(0);
                img = $(thumbnail).find('img');

                img.attr('src',img_src);
        }
        slider.flickity("select", 0);
        setTimeout(function () {
            slider.flickity("resize" );
        }, 500 );

    });

});
jQuery(document).on('yith_featured_gallery_single_item_initialized', function (e, thumbnail, slider_item) {

    var img_src = slider_item.data('thumb');
    thumbnail.find('img').attr('src', img_src);
});

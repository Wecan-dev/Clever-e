jQuery(document).ready(function ($) {

    var current_variation = '',
        original_content = '',
        block_params = {
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            },
            ignoreIfBlocked: true
        },
        init_gallery = function (woocommerce_gallery) {
            woocommerce_gallery.each(function () {
                var featured_index = $(this).index(),
                    video = null;


                if ($(this).hasClass('ywcfav_video_modal_container')) {
                    video = $(this);
                } else {
                    video = $(this).find('.ywcfav-audio-content iframe,.ywcfav-video-content iframe,.ywcfav-video-content div.iframe,.ywcfav-video-content video, .ywcfav_video_embedded_iframe');
                }
                video = $(video[0]);


                var featured_gallery_thumbnail = $(ywcfav_zoom_params.thumbnail_gallery_class_element).get(featured_index),
                    video_id = video.attr('id');


                if (0 === featured_index) {
                    original_content = video;
                }
                video_id = video_id.replace('_html5_api', '');

                $(featured_gallery_thumbnail).addClass('yith_featured_thumbnail');
                $(featured_gallery_thumbnail).find('img').attr('id', video_id);
            });
        },
        remove_variation_content = function () {
            var variation_content = $(document).find('.ywcfav_variation_content');

            if (variation_content.find('.host').length) {
                var video = variation_content.find('video'),
                    video_js = videojs(video.attr('id'));

                video_js.dispose();
            }
            variation_content.find('div:first-child').remove();

        },
        show_original_content = function () {
            if (original_content !== '') {
                if (original_content.hasClass('ywcfav_video_modal_container')) {
                    original_content.show();
                    var a = original_content.find('a.ywcfav_show_modal');
                    a.attr('href', a.data('o_href'));
                } else {
                    original_content.parents('.yith_featured_content').show();
                }
            }else{
                $('.images > div:eq(0)').show();
            }
        },
        hide_original_content = function () {

            if (original_content !== '') {
                if (original_content.hasClass('ywcfav_video_modal_container')) {
                    original_content.hide();


                } else {
                    original_content.parents('.yith_featured_content').hide();
                }
            }else{
                $('.images > div:eq(0)').hide();
            }
        },
        replace_content = function (response) {

        var variation_content,
            general_content = $(document).find('.images');

        if (!general_content.find('div.ywcfav_variation_content').length) {
            variation_content = $('<div>');
            variation_content.addClass('ywcfav_variation_content');

            var insert_after ;
            if($(general_content).find('.ywcfav_hide').length  ){
                insert_after = $(general_content).find('.ywcfav_hide');
            }else{
                insert_after = $(general_content).find('div:eq(0)');
            }
            variation_content.insertAfter( insert_after );
        } else {
            variation_content = general_content.find('div.ywcfav_variation_content');
        }

        variation_content.html(response);
        $(document).trigger('ywcfav_after_init_zoom');
        $(general_content).find('.ywcfav_hide').hide();
        hide_original_content();

    };


    var featured_content = $(ywcfav_zoom_params.img_class_container + '.yith_featured_content,' + ywcfav_zoom_params.img_class_container + '.ywcfav_video_modal_container');

    init_gallery(featured_content);

    $(document).on('click', '.yith_magnifier_gallery li', function (e) {

        current_variation = '';
        if( original_content!='' ) {
            if (!$(this).hasClass('yith_featured_thumbnail')) {
                $(document).find('.ywcfav_hide').show();
                hide_original_content();

            } else {
                $(document).find('.ywcfav_hide').hide();
                show_original_content();
            }
        }else{
            show_original_content();
        }
    });

    $('.variations_form.cart').on('found_variation', function (e, variation) {

        if (typeof variation.variation_video !== 'undefined') {
            current_variation = variation;
        } else {
            /*remove old content*/
            current_variation = '';

            if( original_content!='' ) {
                $(document).find('.ywcfav_hide').show();
                $(document).find('.yith_featured_content').hide();
            }else{
                show_original_content();
            }

        }

        if (original_content !== '') {

            $(document).trigger('ywcfav_before_slide_show', $(original_content).attr('id'));

        }


    }).on('reset_data', function (e) {

        current_variation = '';
        $(document).find('.ywcfav_hide').hide();
        show_original_content();
    });


    $(document).on('yith_magnifier_after_init_zoom', function (e) {
        remove_variation_content();
        if (typeof current_variation !== 'undefined' && current_variation !== '') {

            var data = {
                'variation_id': current_variation.variation_id,
                'content_id': current_variation.variation_video,
                'action': ywcfav_zoom_params.actions.get_variation_content
            };

            $.ajax({
                type: 'POST',
                data: data,
                url: ywcfav_zoom_params.admin_url,
                dataType: 'json',
                beforeSend: function () {
                    $(document).find('.yith_magnifier_zoom_wrap').block(block_params);
                },
                success: function (response) {
                    replace_content(response);
                },
                complete: function () {
                    $(document).find('.yith_magnifier_zoom_wrap').unblock();
                }
            });
        }
    });

    $(document).on('click', '.ywcfav_thumbnails_video_container a.ywcfav_video_as_zoom,.ywcfav_thumbnails_audio_container a.ywcfav_audio_as_zoom', function (e) {
        e.preventDefault();

        var type = $(this).hasClass('ywcfav_video_as_zoom') ? 'video' : 'audio',
            current_item = $(this),
            data = {
                product_id: current_item.data('product_id'),
                content_id: current_item.data('content_id'),
                content_type: type,
                action: ywcfav_zoom_params.actions.get_gallery_content
            };
        current_variation = '';
        $.ajax({
            type: 'POST',
            data: data,
            url: ywcfav_zoom_params.admin_url,
            dataType: 'json',
            success: function (response) {
                remove_variation_content();
                replace_content(response);
            }
        });


    });

});
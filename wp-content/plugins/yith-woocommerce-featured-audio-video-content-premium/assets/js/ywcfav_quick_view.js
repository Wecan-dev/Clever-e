jQuery(document).ready(function ($) {

    var quick_view_image_gallery = '.yith-quick-view-content .images > a',
        current_variation = '',
        original_content ='',
        get_featured_content = function(){

            var data ={
                'product_id' :$(document).find('#yith_wcqv_product_id').val(),
                'action':ywcfav_quick_params.actions.get_featured_content
            };

            $.ajax({
                type: 'POST',
                data: data,
                url: ywcfav_quick_params.admin_url,
                dataType: 'json',
                success: function (response) {

                   if( typeof  response !== 'undefined'){

                       original_content = $(response);

                       original_content.insertBefore( $(document).find(quick_view_image_gallery));
                       $(document).find(quick_view_image_gallery).hide();
                       $(document).find('.yith-quick-view-thumbs div:eq(0)').addClass('yith_featured_thumbnail');
                   }
                }
            });
        },
        get_variation_content = function(){
            if (typeof current_variation !== 'undefined' && current_variation !== '') {

                var data = {
                    'variation_id': current_variation.variation_id,
                    'content_id': current_variation.variation_video,
                    'action': ywcfav_quick_params.actions.get_variation_content
                };

                $.ajax({
                    type: 'POST',
                    data: data,
                    url: ywcfav_quick_params.admin_url,
                    dataType: 'json',
                    success: function (response) {
                        replace_content(response);
                        toggle_content('hide');
                    }
                });
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

        },
        toggle_content = function( show_or_hide ){

        var images = $(document).find('.images'),
            content ;

        if( images.find('> .yith_featured_content').length ){
            content = images.find('>.yith_featured_content');
        }else{
            content = images.find('>a');
        }

        if( 'hide' == show_or_hide ){
            content.hide();
        }else{
            content.show();
        }
        },
        check_featured_content =false;


    $(document).on('qv_loader_stop', function () {

        if (!check_featured_content) {
            get_featured_content();
            check_featured_content = true;
        }


        $(document).on('found_variation', 'form.variations_form', function (e, variation) {

            $(document).find('.images .ywcfav_variation_content').remove();
            if (typeof variation.variation_video !== 'undefined') {
                current_variation = variation;
                get_variation_content();

                $(document).find('.images >a').hide();
            } else {
                /*remove old content*/
                current_variation = '';
                $(document).find('.images .yith_featured_content').hide();
                $(document).find('.images >a').show();
            }

            if (original_content !== '') {

                $(document).trigger('ywcfav_before_slide_show', $(original_content).attr('id'));

            }


        }).on('reset_data', function (e) {
            $(document).find('.images .ywcfav_variation_content').remove();
            $(document).find('.images >a').hide();
            toggle_content('show');
        });
    });

$(document).on('click', '.yith-quick-view-thumbs div.yith-quick-view-single-thumb',function(e){
    var element = $(this);
    $(document).find('.images .ywcfav_variation_content').remove();
    if(element.hasClass('yith_featured_thumbnail')){
        $(document).find('.images >a').hide();
        toggle_content('show');
    }else{
        $(document).find('.images >a').show();
        toggle_content('hide');
    }
});
});
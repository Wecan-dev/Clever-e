jQuery(document).ready(function($){

    var  block_params = {
        message: null,
        overlayCSS: {
            background: '#000',
            opacity: 0.6
        },
        ignoreIfBlocked: true
        },
        video_file_frame,image_file_frame;

   /** START VIDEO */
    var  init_form_video_field = function(){

        var select_add_video_by = $( '#ywcfav_video_add_by'),
            button_add_video = $('.ywfav_add_video'),
            button_remove_video = $('.ywcfav_delete' );

        select_add_video_by.on('change', function(e){
            var t = $(this),
                selected = t.val(),
                container = t.parents('#ywcfav_form_container'),
                video_id = container.find('.video_add_by_id'),
                video_url = container.find('.video_add_by_url'),
                video_emb = container.find('.video_add_by_embedded'),
                video_up = container.find('.video_add_by_upload'),
                video_host = container.find('.video_type_host'),
                video_name = container.find( '.video_name'),
                button = container.find('.ywfav_add_video');

            if (t.hasClass('error_field'))
                t.removeClass('error_field');

            video_name.show();
            switch( selected ) {

                case 'id' :
                    video_id.show();
                    video_url.hide();
                    video_emb.hide();
                    video_up.hide();
                    video_host.show();
                    button.show();
                    break;
                case 'url':
                    video_id.hide();
                    video_url.show();
                    video_emb.hide();
                    video_up.hide();
                    video_host.show();
                    button.show();
                    break;
                case 'embd':
                    video_id.hide();
                    video_url.hide();
                    video_emb.show();
                    video_up.hide();
                    video_host.hide();
                    button.show();
                    break;
                case 'upload':
                    video_id.hide();
                    video_url.hide();
                    video_emb.hide();
                    video_up.show();
                    video_host.hide();
                    button.hide();
                    break;
                default :
                    video_id.hide();
                    video_url.hide();
                    video_emb.hide();
                    video_up.hide();
                    video_host.hide();
                    video_name.hide();
                    button.hide();
                    break;
            }
        });
        button_add_video.on('click',function(e){

            var video_by = select_add_video_by.val(),
                form_field = '',
                form_value = '',
                is_error = false,
                form_name_field = $('#ywcfav_video_name'),
                form_name_value = form_name_field.val();


            if( video_by == '' ){
                select_add_video_by.addClass('error_field');
                e.preventDefault();
                return;
            }

            if( form_name_value == '' ){

                form_name_field.addClass('error_field');
                e.preventDefault();
                return;
            }




            switch( video_by ){

                case 'id' :
                    form_field = $('#ywcfav_video_add_by_id');
                    form_value = form_field.val();
                    if( '' == form_value )
                        is_error = true;
                        break;
                case 'url':
                    form_field = $('#ywcfav_video_add_by_url');
                    form_value = form_field.val();
                    if( '' == form_value )
                        is_error = true;
                    break;
                case 'embd':
                    form_field = $('#ywcfav_video_add_by_embedded');
                    form_value = form_field.val();
                    if( '' == form_value )
                        is_error = true;
                    break;
                case 'upload':
                    form_field = $('#ywcfav_video_id_up');
                    form_value = form_field.val();
                    if( '' == form_value )
                        is_error = true;
                    break;

            }


            if( is_error ){

                form_field.parent().addClass( 'error_field' );
                e.preventDefault();
            }
            else{

                var thumbn_id = ywcfav.video_placeholder_img_id,
                    video_type = '',
                    video_container = $( '#ywcfav_video_data');

                video_container.block(block_params);
                if( video_by == 'upload' ){

                    add_video_row( video_by, 'host', thumbn_id, form_name_value, form_value );
                    setTimeout( function(){  video_container.unblock();}, 500 );

                }else if( video_by == 'embd' ){

                    add_video_row( video_by, 'embedded', thumbn_id, form_name_value, encodeURI( form_value ) );
                    setTimeout( function(){  video_container.unblock();}, 500 );

                }else{

                   var video_host = $('#ywcfav_video_type_host').val(),
                       video_id = '';
                    switch( video_by ){

                        case 'id' :
                          video_id = form_value;
                            break;
                        case 'url' :

                            if (video_host == 'vimeo')
                                video_id = parseVimeoSrc(form_value);
                            else
                                video_id = parseYoutubeSrc(form_value);
                            break;
                    }

                    var data = {
                        ywcfav_id:   video_id ,
                        ywcfav_host: video_host,
                        ywcfav_name: form_name_value,
                        action: ywcfav.actions.save_thumbnail_video
                    };


                    $.ajax({
                        type: 'POST',
                        url: ywcfav.admin_url,
                        data: data,
                        dataType: 'json',
                        success: function (response) {

                            if( response.result == 'ok'  )
                                thumbn_id = response.id_img;

                            else
                                thumbn_id =   ywcfav.video_placeholder_img_id;

                            add_video_row( video_by, video_host, thumbn_id, form_name_value, encodeURI( form_value ) );
                            video_container.unblock();
                        }
                    });

                }

                $('body').trigger('ywcfav_row_insert');

            }
        });
        //delete a video
         $( document).on( 'click', '.ywcfav_delete', function (e) {
            e.preventDefault();
            var t = $(this),
                    row = t.parent().parent(),
                video_id = row.find('.ywcfav_video_id').val();

             row.remove();

             $('body').trigger('ywcfav_remove_content',[video_id])
            });


        },
         parseYoutubeSrc =   function( src ){
            // Regex to parse the video ID
            var regId = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            var match = src.match(regId);

            var videoId;
            if(match && match[2].length === 11) {
                videoId = match[2];
            } else {
                videoId = null;
            }

            return videoId;
         },
         parseVimeoSrc   =   function( src ){

            // Regex that parse the video ID for any Vimeo URL
            var regExp = /^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/;
            var match = src.match(regExp);
            var videoId;
            if (match){
                videoId = match[5];
            }
            return videoId;
         },
         create_uniqueId = function() {
            return 'id-' + Math.random().toString(36).substr(2, 16);
         },
        add_video_row = function( video_type, video_host, thumbnail_id, video_name, content ){

            var all_video_content = $( '.product_video .ywcfav_woocommerce_video'),
                content_id = 'ywcfav_video_'+create_uniqueId(),
                size = all_video_content.size(),
                data = {
                    video_type : video_type,
                    video_name : video_name,
                    video_content : content,
                    video_img : thumbnail_id,
                    video_id: content_id,
                    video_host: video_host,
                    product_id :woocommerce_admin_meta_boxes.post_id,
                    loop : size,
                    action: ywcfav.actions.add_new_video_row
                };

            $.ajax({
                type: 'POST',
                url: ywcfav.admin_url,
                data: data,
                dataType: 'json',
                success: function (response) {

                    $( '.product_video' ).append(response.result);
                    $('body').trigger('ywcfav_new_content_insert',[content_id, video_name]);
                    $('body').trigger('ywcfav_featured_insert');
                }
            });

        };



    //when a new row video is addedd, clear form
    $(document).on('ywcfav_row_insert', function (ev) {

        $('#ywcfav_video_add_by').val('').change();
        $('#ywcfav_video_add_by_id').val('');
        $('#ywcfav_video_add_by_url').val('');
        $('#ywcfav_video_add_by_embedded').val('');
        $('#ywcfav_video_name').val('');
        $('#ywcfav_video_url_up').val('');
        $('#ywcfav_video_id_up').val('');
    });

    $(document).on('ywcfav_featured_insert',function(ev){

        $('input').removeClass('error_field');
        $('select').removeClass('error_field');
        $('textarea').removeClass('erorr_field');

    } );
    $(document).on('ywcfav_new_content_insert', function(ev,content_id,content_name ) {

        var select_metaboxes = $('.ywcfav_select_featured_content'),
            select_field = $('.select_featured');

        select_metaboxes.block(block_params);

        select_field.append('<option value="'+content_id+'">'+content_name+'</option>');

        setTimeout( function(){  select_metaboxes.unblock();}, 500 );
    });
    $(document).on('ywcfav_remove_content', function(ev, content_id){
        var select_metaboxes = $('.ywcfav_select_featured_content'),
            select_field = $('.select_featured');

        select_metaboxes.block(block_params);

        select_field.find('option[value="'+content_id+'"]').remove();
        setTimeout( function(){  select_metaboxes.unblock();}, 500 );
    });
    //Open MediaLibray for add a Video in product
    $('#ywcfav_video_add_by_upload').on('click', function (e) {
        var t = $(this),
            button = $('.ywfav_add_video');

        e.preventDefault();
        // If the media frame already exists, reopen it.
        if (video_file_frame) {
            video_file_frame.open();
            return;
        }

        var downloadable_file_states = [
            // Main states.
            new wp.media.controller.Library({
                library: wp.media.query({type: 'video'}),
                multiple: false,
                title: t.data('choose'),
                priority: 20,
                filterable: 'uploaded'
            })
        ];

        // Create the media frame.
        video_file_frame = wp.media.frames.downloadable_file = wp.media({
            // Set the title of the modal.
            title: t.data('choose'),
            library: {
                type: 'video'
            },
            button: {
                text: t.data('choose')
            },
            multiple: false,
            states: downloadable_file_states
        });

        // When an image is selected, run a callback.
        video_file_frame.on('select', function () {

            var file_path = '',
                file_id = '',
                selection = video_file_frame.state().get('selection');

            selection.map(function (attachment) {

                attachment = attachment.toJSON();

                if( attachment.type!='video' ){

                    alert(ywcfav.error_video);
                    return;
                }

                if (attachment.url) {
                    file_path = attachment.url;
                    file_id = attachment.id;
                }

            });

            var video_path_field = $(document).find('#ywcfav_video_url_up'),
                video_id_field = $(document).find('#ywcfav_video_id_up');


            video_id_field.val(file_id);
            video_path_field.val(file_path);
            button.click();

        });

        // Finally, open the modal.
        video_file_frame.open();

    });
    //upload video image
    $(document).on('click','.ywcfav_upload_image_button', function (e) {

        var t = $(this);
        e.preventDefault();

        // If the media frame already exists, reopen it.
     /*   if (image_file_frame) {
            image_file_frame.open();
            return;
        }*/

        var downloadable_file_states = [
            // Main states.
            new wp.media.controller.Library({
                library: wp.media.query({type: 'image'}),
                multiple: false,
                title: t.data('choose'),
                priority: 20,
                filterable: 'all'
            })
        ];

        // Create the media frame.
        image_file_frame = wp.media.frames.downloadable_file = wp.media({
            // Set the title of the modal.
            title: t.data('choose'),
            library: {
                type: 'image'
            },
            button: {
                text: t.data('choose')
            },
            multiple: false,
            states: downloadable_file_states
        });

        // When an image is selected, run a callback.
        image_file_frame.on('select', function () {

            var file_path = '',file_id='',
                selection = image_file_frame.state().get('selection');

            selection.map(function (attachment) {

                attachment = attachment.toJSON();

                if (attachment.url) {
                    file_path = attachment.url;
                    file_id = attachment.id;

                    t.parent().find('.thumbn_id').val(file_id);
                    t.find('.ywcfav_thumbn').attr('src', file_path);
                }

            });


        });

        // Finally, open the modal.
        image_file_frame.open();
    });

    /**END VIDEO*/

    /**START AUDIO*/

    var init_form_audio_field = function(){

        $('.ywcfav_insert_track').on('click', function(){

            var audio_container = $('#ywcfav_audio_data'),
                track_title_field = $('#ywcfav_audio_name'),
                track_url_field   = $('#ywcfav_audio_url'),
                track_title = track_title_field.val(),
                track_url = track_url_field.val(),
                is_error= false;

            if( track_title == '' ){
               track_title_field.addClass('error_field');
                is_error = true;
            }

            if( track_url == '' ){

                track_url_field.addClass('error_field');
                is_error = true
            }

            if( !is_error ){

                audio_container.block( block_params );
                var all_audio_content = $( '.product_audio .ywcfav_woocommerce_audio_data'),
                    content_id = 'ywcfav_audio_'+create_uniqueId(),
                    size = all_audio_content.size(),
                    data = {

                        audio_name : track_title,
                        audio_content : encodeURI( track_url ),
                        audio_img : ywcfav.audio_placeholder_img_id,
                        audio_id: content_id,
                        product_id :woocommerce_admin_meta_boxes.post_id,
                        loop : size,
                        action: ywcfav.actions.add_new_audio_row
                    };

                $.ajax({
                    type: 'POST',
                    url: ywcfav.admin_url,
                    data: data,
                    dataType: 'json',
                    success: function (response) {

                        $( '.product_audio' ).append(response.result);
                        audio_container.unblock();
                        track_title_field.val('');
                        track_url_field.val('');
                        $('body').trigger('ywcfav_new_content_insert',[content_id, track_title]);
                        $('body').trigger('ywcfav_featured_insert');

                    }
                });

            }


        });
        $(document).on('click','.ywcfav_delete_audio', function(e){

            e.preventDefault();
            var t = $(this),
                row = t.parent().parent(),
                audio_id = row.find('.ywcfav_audio_id').val();

            row.remove();

            $('body').trigger('ywcfav_remove_content',[audio_id])
        });

    };
/*END AUDIO*/
    /*START VIDEO IN PRODUCT VARIATION*/
    
    var add_video_variation = function( container, video_type, video_host, thumbnail_url, video_title, video_content ){
    	
    	var container_to_add = container.find('.ywcfav_variable_video_container'),
    		loop = container_to_add.data('loop'),
    		product_id = container.find('input:hidden[name^="variable_post_id"]').val(),
    		data ={
    			video_id : 'ywcfav_video_'+create_uniqueId(),
    			video_type : video_type,
    			video_name : video_title,
    			video_content: video_content,
    			video_host: video_host,
    			video_img : thumbnail_url,
    			product_id : product_id,
    			 loop : loop,
                 action: ywcfav.actions.add_new_video_variation
             };

         $.ajax({
             type: 'POST',
             url: ywcfav.admin_url,
             data: data,
             dataType: 'json',
             success: function (response) {

            	 container_to_add.html(response.result);
                 container.find('.ywcfav_variable_video_add_container').hide();
                 $('body').trigger('ywcfav_featured_insert');
             }
         });
    }
    
    //add custom video in product variation
    $(document).on('woocommerce_variations_loaded woocommerce_variations_added', function(){

        $(document).on('change', '.ywcfav_variation_video_add_by', function (e) {


            var t = $(this),
                selected = t.val(),
                container = $(this).closest('.woocommerce_variation').find('.ywcfav_variable_video'),
                video_id = container.find('.variation_video_add_by_id'),
                video_url = container.find('.variation_video_add_by_url'),
                video_emb = container.find('.variation_video_add_by_embedded'),
                video_up = container.find('.variation_video_add_by_upload'),
                video_host = container.find('.variation_video_type'),
                video_title = container.find('.variation_video_title'),
                button = container.find('.variation_video_button_add');

            if (t.hasClass('error_field'))
                t.removeClass('error_field');

            switch (selected) {

                case 'id' :
                	video_title.show();
                    video_id.show();
                    video_url.hide();
                    video_emb.hide();
                    video_up.hide();
                    video_host.show();
                    button.show();
                    break;
                case 'url':
                	video_title.show();
                    video_id.hide();
                    video_url.show();
                    video_emb.hide();
                    video_up.hide();
                    video_host.show();
                    button.show();
                    break;
                case 'embd':
                	video_title.show();
                    video_id.hide();
                    video_url.hide();
                    video_emb.show();
                    video_up.hide();
                    video_host.hide();
                    button.show();
                    break;
                case 'upload':
                	video_title.show();
                    video_id.hide();
                    video_url.hide();
                    video_emb.hide();
                    video_up.show();
                    video_host.hide();
                    button.hide();
                    break;
                default :
                	video_title.hide();
                    video_id.hide();
                    video_url.hide();
                    video_emb.hide();
                    video_up.hide();
                    video_host.hide();
                    button.hide();
                    break;
            }
        });
        
        $(document).on('click', '.ywcfav_add_variable_video', function (e) {
            var t = $(this),
                container = t.parents('.woocommerce_variation'),
                type_select = container.find('.ywcfav_variation_video_add_by').val(),
                form_field = '',
                form_value = '',
                form_field_title = container.find('.ywcfav_variation_video_title'),
                form_field_title_value =form_field_title.val(),
                is_error =false;


            
            if( form_field_title_value == '' ){
            	is_error = true;
            	
            	form_field_title.addClass('error_field');
            }
            
            switch( type_select ){

            case 'id' :
                form_field = container.find('.ywcfav_variation_video_add_by_id');
                form_value = form_field.val();
                if( '' == form_value )
                    is_error = true;
                    break;
            case 'url':
                form_field = container.find('.ywcfav_variation_video_add_by_url');
                form_value = form_field.val();
                if( '' == form_value )
                    is_error = true;
                break;
            case 'embd':
                form_field = container.find('.ywcfav_variation_video_add_by_embedded');
                form_value = form_field.val();
                if( '' == form_value )
                    is_error = true;
                break;
            case 'upload':
                form_field = container.find('.ywcfav_variation_video_id');
                form_value = form_field.val();
                if( '' == form_value )
                    is_error = true;
                break;

        }

        if( is_error ){

            form_field.parent().addClass( 'error_field' );
            e.preventDefault();
        } else{

            var thumbn_url = ywcfav.video_placeholder_img_id,
                video_type = '';
               

            container.block(block_params);
            if( type_select == 'upload' ){


                add_video_variation( container, type_select, 'host', thumbn_url, form_field_title_value, form_value );
                setTimeout( function(){  container.unblock();}, 500 );

            }else if( type_select == 'embd' ){

                add_video_variation( container, type_select, 'embedded', thumbn_url, form_field_title_value, encodeURI( form_value ) );
                setTimeout( function(){  container.unblock();}, 500 );

            }else{

               var video_host = container.find('.ywcfav_variation_video_type_host').val(),
                   video_id = '';
                switch( type_select ){

                    case 'id' :
                      video_id = form_value;
                        break;
                    case 'url' :

                        if (video_host == 'vimeo')
                            video_id = parseVimeoSrc(form_value);
                        else
                            video_id = parseYoutubeSrc(form_value);
                        break;
                }
                var data = {
                    ywcfav_id:   video_id ,
                    ywcfav_host: video_host,
                    ywcfav_name: form_field_title_value,
                    action: ywcfav.actions.save_thumbnail_video
                };
                $.ajax({
                    type: 'POST',
                    url: ywcfav.admin_url,
                    data: data,
                    dataType: 'json',
                    success: function (response) {

                      
                        if( response.result == 'ok'  )
                            thumbn_url = response.id_img;

                        else
                            thumbn_url =   ywcfav.video_placeholder_img_id;

                        add_video_variation( container,type_select, video_host, thumbn_url, form_field_title_value, encodeURI( form_value ) );
                        container.unblock();
                        container.addClass('variation-needs-update');

                    }
                });

            }

        }

    });
        $(document).on('click', '.remove_video', function (e) {
            var t = $(this),
            woocommerce_wrapper = t.closest('.woocommerce_variation'),
                video_container_to_remove = woocommerce_wrapper.find('.ywcfav_variable_video_container'),
                form_add_field = woocommerce_wrapper.find('.ywcfav_variable_video_add_container');

            woocommerce_wrapper.block( block_params );
            setTimeout( function(){
            	
            	 video_container_to_remove.html('')
                 woocommerce_wrapper.unblock();
            	 woocommerce_wrapper.addClass('variation-needs-update');
            	 
                 form_add_field.find('input').val('');
                 form_add_field.find('select').val('');
                 form_add_field.show();
            }, 500 );
           
         }); 
        
        $(document).on('click', '.ywcfav_variation_upload_image_button', function(e){

            var t = $(this);
            e.preventDefault();

            // If the media frame already exists, reopen it.
         /*   if (image_file_frame) {
                image_file_frame.open();
                return;
            }*/

            var downloadable_file_states = [
                // Main states.
                new wp.media.controller.Library({
                    library: wp.media.query({type: 'image'}),
                    multiple: false,
                    title: t.data('choose'),
                    priority: 20,
                    filterable: 'all'
                })
            ];

            // Create the media frame.
            image_file_frame = wp.media.frames.downloadable_file = wp.media({
                // Set the title of the modal.
                title: t.data('choose'),
                library: {
                    type: 'image'
                },
                button: {
                    text: t.data('choose')
                },
                multiple: false,
                states: downloadable_file_states
            });

            // When an image is selected, run a callback.
            image_file_frame.on('select', function () {

                var file_path = '',
                    file_id = '',
                    selection = image_file_frame.state().get('selection');

                selection.map(function (attachment) {

                    attachment = attachment.toJSON();

                    if (attachment.url) {
                        file_path = attachment.url;
                        file_id = attachment.id;

                            t.closest('.woocommerce_variation').find('.thumbn_id').val(file_id);
                            t.closest('.woocommerce_variation').find('.ywcfav_variation_thumbn').attr('src', file_path);
                            t.closest('.woocommerce_variation').addClass('variation-needs-update');

                    }
                });


            });

            // Finally, open the modal.
            image_file_frame.open();
        });
        $(document).on('click', '.ywcfav_variation_video_add_by_upload', function (e) {

            var t = $(this),
                container = t.parent().parent(),
                video_id = container.find('.ywcfav_variation_video_id'),
                button = container.find('.ywcfav_add_variable_video');


            e.preventDefault();


            var downloadable_file_states = [
                // Main states.
                new wp.media.controller.Library({
                    library: wp.media.query({type: 'video'}),
                    multiple: false,
                    title: t.data('choose'),
                    priority: 20,
                    filterable: 'uploaded'
                })
            ];

            // Create the media frame.
            video_file_frame = wp.media.frames.downloadable_file = wp.media({
                // Set the title of the modal.
                title: t.data('choose'),
                library: {
                    type: 'video'
                },
                button: {
                    text: t.data('choose')
                },
                multiple: false,
                states: downloadable_file_states
            });

            // When an image is selected, run a callback.
            video_file_frame.on('select', function () {

                var file_id = '',
                    selection = video_file_frame.state().get('selection');

                selection.map(function (attachment) {


                    attachment = attachment.toJSON();

                    if( attachment.type!='video' ){

                        alert(ywcfav.error_video);
                        return;
                    }

                    if (attachment.id) {
                        file_id = attachment.id;
                    }

                });
                video_id.val(file_id);
                button.click();
            });

            // Finally, open the modal.
            video_file_frame.open();

        });

        
        
    });
    
    $('body').on('ywcfav_admin_field_init', function(){
        init_form_video_field();
        init_form_audio_field();
    }).trigger( 'ywcfav_admin_field_init' );
    
    
    if( $('#ywcfav_copy_section').length ){

        $('#ywcfav_copy_content').on('click',function(e){
           e.preventDefault();
            
            var t = $(this),
                product_id = t.data( 'product_id' ),
                original_id = t.data( 'original_product_id' ),
                data  = {
                    product_id : product_id,
                    original_id: original_id,
                    action: 'ywcfav_copy_content_from_original'
                };


            $.ajax({
                type: 'POST',
                url: ywcfav.admin_url,
                data: data,
                dataType: 'json',
                beforeSend: function(){
                    t.siblings( '.ajax-loading' ).css( 'visibility', 'visible' );
                },
                complete: function(){
                    t.siblings( '.ajax-loading' ).css( 'visibility', 'hidden' );
                },
                success: function (response ) {

                    location.reload();
                    
                }
            });
        });
    }
});
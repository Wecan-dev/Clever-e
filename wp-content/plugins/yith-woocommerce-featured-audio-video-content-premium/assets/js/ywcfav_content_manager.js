//GLOBAL VARIABLES
var players = [];

//FUNCTIONS
var hide_gallery_trigger_and_onsale_icon = function (e) {
        jQuery('.woocommerce span.onsale:first, .woocommerce-page span.onsale:first').hide();

    },
    show_gallery_trigger_and_onsale_icon = function (e) {
        jQuery('.woocommerce span.onsale:first, .woocommerce-page span.onsale:first').show();

    },
    hide_or_show_trigger_icon = function( current_slide ){

        if( current_slide.hasClass('ywcfav_video_modal_container')|| current_slide.hasClass('yith_featured_content') ){
            jQuery(ywcfav_args.product_gallery_trigger_class).hide();
        }else{
            jQuery(ywcfav_args.product_gallery_trigger_class).show();
        }
    },
    init_modal = function( modal_content ){

        modal_content.each(function(){
            var current =jQuery(this),
                a = current.find('a.ywcfav_show_modal');


            a.venobox();
        });


    };

jQuery(document).on('ywfav_custom_content_created',function(e, player , iframe){

    var iframe_id =  jQuery(iframe).attr('id');
        iframe_id = iframe_id.replace('_html5_api','');

        if( players.indexOf(iframe_id) === -1 ){
            players[iframe_id] = player;

        }
});

jQuery(document).on( 'ywcfav_before_slide_show', function(e,video_id){


   if( typeof  players[video_id]!== 'undefined'){

       var content = jQuery(document).find('iframe#'+video_id+', div#'+video_id );
       // the content can be a youtube or vimeo video or soundcloud audio
       if( content.length ){

           var parent = content.parent();

           if( parent.hasClass('youtube')){
               players[video_id].pauseVideo();
           }else if( parent.hasClass('vimeo')){

               players[video_id].pause();
           }else{
               players[video_id].pause();
           }
       }else{
           //can be a host video
           content = jQuery(document).find('video#'+video_id);

           if( content.length){
               players[video_id].pause();
           }
       }

   }
});
jQuery(document).on( 'ywcfav_after_slide_show', function (e, video_id ) {


    if( typeof  players[video_id]!== 'undefined' && ywcfav_args.autoplay !== 'no'){

        var content = jQuery(document).find('iframe#'+video_id+', div#'+video_id );
        // the content can be a youtube or vimeo video or soundcloud audio
        if( content.length ){

            var parent = content.parent();

            if( parent.hasClass('youtube')) {

                players[video_id].mute();
                players[video_id].playVideo();

            }else if( parent.hasClass('vimeo')){
                players[video_id].play();
            }else{
                players[video_id].play();
            }
        }else{
            //can be a host video

            content = jQuery(document).find('video#'+video_id);
            if( content.length){

                players[video_id].autoplay('muted');
            }
        }

    }
    var current_slide = jQuery(document).find(ywcfav_args.current_slide_active_class);

    hide_or_show_trigger_icon( current_slide );
});

var modal_content = jQuery(document).find('.ywcfav_video_modal_container');

init_modal( modal_content);

jQuery(document).on('ywcfav_after_init_zoom',function(e) {

    var modal_content = jQuery(document).find('.ywcfav_video_modal_container');

    init_modal( modal_content);

});

jQuery(document).ready(function($) {
    var product_gallery = $(document).find('.woocommerce-product-gallery, .images'),
        video_gallery = $(document).find('.ywcfav_thumbnails_video_container'),
        audio_gallery = $(document).find('.ywcfav_thumbnails_audio_container');
    if (video_gallery.length) {

        video_gallery.appendTo(product_gallery);

    }

    if (audio_gallery.length) {
        audio_gallery.appendTo(product_gallery);
    }

    var selected_item = $(document).find('.yith_featured_content'),
        flex_active_slide = ywcfav_args.current_slide_active_class.replace('.','' );

    if( $(document).find('figure > div').length >0 || selected_item.hasClass(flex_active_slide) ){

        jQuery(ywcfav_args.product_gallery_trigger_class).hide();
    }
});
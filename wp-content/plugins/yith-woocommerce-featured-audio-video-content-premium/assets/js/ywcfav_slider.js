/**
 * Created by Your Inspiration on 29/12/2015.
 */

jQuery(document).ready(function($){

    var video_carousel = $('.ywcfav_slider_video'),
        audio_carousel = $('.ywcfav_slider_audio'),
        columns_video = video_carousel.data('n_columns'),
        columns_audio = audio_carousel.data('n_columns');


    video_carousel.owlCarousel({
        margin:10,
        loop:false,
        dots: false,
        nav:false,
        autoWidth:false,
        items: columns_video,
        onInitialize: hideImage,
        onInitialized : showImage
    });

    audio_carousel.owlCarousel({
        margin:10,
        loop:false,
        dots: false,
        nav:false,
        autoWidth:false,
        items: columns_audio,
        onInitialize: hideImage,
        onInitialized : showImage
    });

    var prev_btn = $('.ywcfav_left'),
        next_btn = $('.ywcfav_right');


    prev_btn.on('click', function(){

        var container = $(this).parent().parent().parent();

        if( container.hasClass('ywcfav_thumbnails_video_container' ) )
            video_carousel.trigger('prev.owl.carousel');
        else
            audio_carousel.trigger('prev.owl.carousel');
    });

    next_btn.on('click', function(){

        var container = $(this).parent().parent().parent();
        if( container.hasClass('ywcfav_thumbnails_video_container' ) )
            video_carousel.trigger('next.owl.carousel');
        else
            audio_carousel.trigger('next.owl.carousel');
    });
    function showImage(event){

        $('.ywcfav_slider_video').find('a.video_modal' ).show();
        $('.ywcfav_slider_audio').find('a.audio_modal' ).show();
    }

    function hideImage(event){
        $('.ywcfav_video_slider').find('a.video_modal' ).hide();
        $('.ywcfav_audio_slider').find('a.audio_modal' ).hide();
    }
});
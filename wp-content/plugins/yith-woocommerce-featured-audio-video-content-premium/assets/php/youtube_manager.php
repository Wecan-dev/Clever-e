<?php
if( !defined('ABSPATH')){
	exit;
}


?>
<script type="text/javascript">

    var iframe_id = '<?php echo $id;?>',
        iframe = jQuery(document).find('#'+iframe_id),
        ytb_data = iframe.data('ytb'),
        global_args = iframe.data('video'),
        force_stop = false,
        player = null;
    // 3. This function creates an <iframe> (and YouTube player)
    //    after the API code downloads.


    function onYouTubeIframeAPIReady() {

        player = new YT.Player(iframe_id, {
            videoId: ytb_data.videoId,
            playerVars: ytb_data,
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });


    }

    function onPlayerReady(event) {

        var volume = global_args.volume * 100;
        event.target.setVolume(volume);
        if( ytb_data.autoplay == 1) {
            <?php if ( apply_filters( 'ywfav_mute_video_on_autoplay', true ) ) : ?>
            event.target.mute();
            <?php endif; ?>
            event.target.playVideo();
        }


        jQuery(document).trigger('ywfav_custom_content_created', [event.target,event.target.a]);
    }

    function onPlayerStateChange(event) {

        if (event.data === YT.PlayerState.PAUSED) {

            var can_stop_video = global_args.is_stoppable;

            if ('no' === can_stop_video && !force_stop) {
                event.target.playVideo();
                force_stop = false;
            }
            var iframe = player.a;
            jQuery(iframe).toggleClass('ywfav_playing');
            show_gallery_trigger_and_onsale_icon(event);

        } else if (event.data === YT.PlayerState.ENDED) {
            var iframe = player.a;
            jQuery(iframe).toggleClass('ywfav_playing');
            show_gallery_trigger_and_onsale_icon(event);

        } else if (event.data === YT.PlayerState.PLAYING) {

            var iframe = player.a;
               jQuery(iframe).toggleClass('ywfav_playing');
            hide_gallery_trigger_and_onsale_icon(event);
        }
    }
</script>

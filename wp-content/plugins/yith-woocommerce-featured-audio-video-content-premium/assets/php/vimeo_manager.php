<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        var iframe_id = '<?php echo $id;?>',
            iframe = $(document).find('#'+iframe_id),
            global_args = iframe.data('video'),
            vimeo_data = iframe.data('vimeo'),
            volume = global_args.volume,
            player = new Vimeo.Player(iframe_id, vimeo_data),
            force_stop= false;


        player.setVolume(volume);
        player.on('play', function () {
            hide_gallery_trigger_and_onsale_icon();

        });
        player.on('pause', function () {
            var is_stoppable = 'yes' == global_args.is_stoppable;
            if (!is_stoppable && !force_stop) {
                player.play();
                force_stop = false;
            }
            show_gallery_trigger_and_onsale_icon();

        });


        jQuery(document).trigger('ywfav_custom_content_created', [player,iframe]);

    });

</script>

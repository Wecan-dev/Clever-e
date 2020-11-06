<?php
if( !defined( 'ABSPATH')){
	exit;
}
?>
<script type="text/javascript">
	jQuery(document).ready(function($){

	   var iframe_id = '<?php echo $id;?>',
            iframe = $(document).find('#'+iframe_id),
            audio_args = iframe.data('audio');

        if (typeof SC !== 'undefined') {

          var  player = SC.Widget(iframe_id);

            player.bind(SC.Widget.Events.READY, function () {

                iframe.css({'width': '100%'});
                player.setVolume(audio_args.volume);

                jQuery(document).trigger('ywfav_custom_content_created', [player,iframe]);
            });

            player.bind(SC.Widget.Events.PLAY, function () {

                hide_gallery_trigger_and_onsale_icon(false);

            });
            player.bind(SC.Widget.Events.FINISH, function () {

                show_gallery_trigger_and_onsale_icon(false);
            });
            player.bind(SC.Widget.Events.PAUSE, function () {

                show_gallery_trigger_and_onsale_icon(false);
            });
        }
	});
</script>

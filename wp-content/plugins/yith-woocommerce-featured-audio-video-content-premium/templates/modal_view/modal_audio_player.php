<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$query_args = array(
	'url'          => $audio_url,
	'auto_play'    => 'yes' == $autoplay ? 'true' : 'false',
	'show_artwork' => 'yes' == $show_artwork ? 'true' : 'false',
	'sharing'      => 'yes' == $show_sharing ? 'true' : 'false',
	'color'        => str_replace( '#', '', $color ),


);

$audio_args = array(
	'volume' => $volume * 100
);

$id         = $id . '_modal';
$audio_args = htmlspecialchars( wp_json_encode( $audio_args ) );
$url        = add_query_arg( $query_args, "https://w.soundcloud.com/player/" );
?>
<div class="ywcfav-audio-content">
    <iframe id="<?php echo $id; ?>" src="<?php echo $url; ?>" frameborder="no" scrolling="no"
            data-audio="<?php echo $audio_args; ?>"></iframe>
	<?php
	include_once( YWCFAV_DIR . 'assets/php/audio_manager.php' );
	?>
</div>

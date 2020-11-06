<?php

$poster_image = wp_get_attachment_image_src( $thumbnail_id, 'full' );
$poster_image = isset( $poster_image[0] ) ? $poster_image[0] : '';

$query_args['poster'] = $poster_image;
$query_args['fluid'] =  true;

$query_args['preload'] = 'auto';
$query_args['controlBar'] = array( 'fullscreenToggle' => false );
$data                 = htmlspecialchars( wp_json_encode( $query_args ) );
$src                  = wp_get_attachment_url( $video_id );
$format               = '';

if ( $src != '' ) {
	$index  = strlen( $src ) - strrpos( $src, '.' );
	$format = substr( $src, - ( $index - 1 ) );
	if ( $format == 'ogv' ) {
		$format = 'ogg';
	}
}
ob_start();
ywcfav_get_custom_player_style();
$style = ob_get_contents();
ob_end_clean();
echo $style;
?>
<video id="<?php echo $id;?>" data-setup="<?php echo $data; ?>" class="video-js vjs-default-skin vjs-default-skin vjs-big-play-centered" muted="muted">
	<?php if ( ! empty( $src ) ) : ?>
        <source src="<?php echo $src; ?>" type="video/<?php echo $format; ?>"/>
	<?php endif; ?>

</video>
<?php
include ( YWCFAV_DIR.'assets/php/host_manager.php');
?>


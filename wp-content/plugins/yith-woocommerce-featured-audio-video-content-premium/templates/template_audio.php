<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $id ) && isset( $volume ) && isset( $thumbnail_id ) && isset( $audio_url ) && isset( $featured_content_selected ) && isset( $autoplay ) && isset( $show_sharing ) && isset( $show_artwork ) ) {
	$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );

	$thumbnail_size = apply_filters( 'woocommerce_gallery_thumbnail_size', array(
		$gallery_thumbnail['width'],
		$gallery_thumbnail['height']
	) );
	$thumbnail_url  = wp_get_attachment_image_src( $thumbnail_id, $thumbnail_size );

	$thumbnail_url = isset( $thumbnail_url[0] ) ? $thumbnail_url[0] : '';

	$gallery_item_class = ywcfav_get_gallery_item_class();

	$query_args = array(
		'url'          => $audio_url,
		'auto_play'    => 'yes' == $autoplay && $featured_content_selected ? 'true' : 'false',
		'show_artwork' => 'yes' == $show_artwork ? 'true' : 'false',
		'sharing'      => 'yes' == $show_sharing ? 'true' : 'false',
		'color'        => str_replace( '#', '', $color ),


	);

	$audio_args = array(
		'volume' => $volume * 100
	);

	$audio_args = htmlspecialchars( wp_json_encode( $audio_args ) );
	$url        = add_query_arg( $query_args, "https://w.soundcloud.com/player/" );

	?>
    <div class="<?php echo $gallery_item_class; ?> yith_featured_content"
         data-thumb="<?php echo $thumbnail_url; ?>">
        <div class="ywcfav-audio-content">
            <iframe id="<?php echo $id; ?>" src="<?php echo $url; ?>" frameborder="no" scrolling="no"
                    data-audio="<?php echo $audio_args; ?>"></iframe>

        </div>

		<?php
		include( YWCFAV_DIR . 'assets/php/audio_manager.php' );
		?>
    </div>
	<?php
}
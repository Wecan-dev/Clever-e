<?php
/**
 * Single Product Thumbnails
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


global $product;

$show_gallery_in_sidebar = 'yes' == get_option( 'ywcfav_show_gallery_in_sidebar' );

if ( $show_gallery_in_sidebar ) {
	$columns = 1;

} else {
	$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

}
$type_link = ywcfav_check_is_zoom_magnifier_is_active() && 'yes' == get_option( 'ywcfav_zoom_magnifer_option' ) ? 'zoom_mode' : 'modal_mode';

if ( ! empty( $all_audio ) ):?>

    <div class="ywcfav_thumbnails_audio_container">
        <div class="ywcfav_slider_info">
            <div class="ywcfav_slider_name"><?php _e( 'Featured Audios', 'yith-woocommerce-featured-video' ); ?></div>
            <div class="ywcfav_slider_control">
                <div class="ywcfav_left"></div>
                <div class="ywcfav_right"></div>
            </div>
        </div>
        <div class="ywcfav_slider_wrapper">
            <div class="ywcfav_slider">
                <div class="ywcfav_slider_audio" data-n_columns="<?php echo $columns; ?>"><?php

					$i = 0;
	                $gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );

	                $thumbnail_size = apply_filters( 'woocommerce_gallery_thumbnail_size', array(
		                $gallery_thumbnail['width'],
		                $gallery_thumbnail['height']
	                ) );
					foreach ( $all_audio as $audio ) {

						$args_url = array(
							'action'     => 'print_modal',
							'product_id' => $product->get_id(),
							'content_id' => $audio['id']
						);

						$terms_url     = esc_url( add_query_arg( $args_url, admin_url( 'admin-ajax.php' ) ) );
						$thumbnail_id  = $audio['thumbn'];
						$thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, $thumbnail_size );
						$thumbnail_url = isset( $thumbnail_url[0] ) ? $thumbnail_url[0] : '';

						$a = sprintf( '<a href="%s" class="%s" data-type="ajax" rel="nofollow" title="%s"><img src="%s" alt="%s"></a>',
							$terms_url,
							'ywcfav_show_modal',
							$audio['name'],
							$thumbnail_url,
							$audio['name']
						);

						$a = apply_filters('ywcfav_gallery_modal_link', $a, 'audio', $terms_url, $audio,$thumbnail_url, $product );
						?>
                        <div id="<?php echo $audio['id']; ?>" class=" ywcfav_video_modal_container">
                            <?php echo $a;?>
                        </div>
						<?php
					}

					?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


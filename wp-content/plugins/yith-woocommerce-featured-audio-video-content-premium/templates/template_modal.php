<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$args_url = array(
    'action' => 'print_modal',
    'product_id' => $args['product_id'],
    'content_id' => $args['id']
);


$terms_url          = esc_url( add_query_arg( $args_url, admin_url( 'admin-ajax.php' ) ) );
$gallery_item_class = ywcfav_get_gallery_item_class();

$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );

$thumbnail_size = apply_filters( 'woocommerce_gallery_thumbnail_size', array(
	$gallery_thumbnail['width'],
	$gallery_thumbnail['height']
) );

$thumbnail_id = $args['thumbnail_id'];

$thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, $thumbnail_size );

$thumbnail_url = isset( $thumbnail_url[0] ) ? $thumbnail_url[0] : '';
$image_size    = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );


$image         = wp_get_attachment_image( $thumbnail_id, $image_size, false, array(
	'title'        => get_post_field( 'post_title', $thumbnail_id ),
	'data-caption' => get_post_field( 'post_excerpt', $thumbnail_id ),
) );

$data = htmlspecialchars( wp_json_encode( $args ) );
?>

<div id="<?php echo $args['id'];?>" class="yith_featured_content ywcfav_video_modal_container <?php echo $gallery_item_class; ?>" data-thumb="<?php echo $thumbnail_url; ?>">
    <a class="ywcfav_show_modal" data-type="ajax" rel="nofollow" href="<?php echo $terms_url;?>">
		<?php echo $image; ?>
    </a>
</div>
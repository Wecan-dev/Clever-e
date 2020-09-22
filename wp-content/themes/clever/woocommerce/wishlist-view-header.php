

<?php
/**
 * Wishlist header
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 3.0.0
 */

/**
 * Template variables:
 *
 * @var $wishlist \YITH_WCWL_Wishlist Current wishlist
 * @var $is_custom_list bool Whether current wishlist is custom
 * @var $can_user_edit_title bool Whether current user can edit title
 * @var $form_action string Action for the wishlist form
 * @var $page_title string Page title
 * @var $fragment_options array Array of items to use for fragment generation
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly
?>

<?php do_action( 'yith_wcwl_before_wishlist_form', $wishlist ); ?>

<form id="yith-wcwl-form" action="<?php echo esc_attr( $form_action ); ?>" method="post" class="woocommerce yith-wcwl-form wishlist-fragment" data-fragment-options="<?php echo esc_attr( json_encode( $fragment_options ) ); ?>">

	<!-- TITLE -->
	<?php


	do_action( 'yith_wcwl_before_wishlist', $wishlist );
	?>

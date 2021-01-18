<?php
/**
 * Templates functions
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

use WP_Grid_Builder\FrontEnd\Styles;
use WP_Grid_Builder\FrontEnd\Scripts;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Get Scripts instance
 *
 * @since 1.2.1
 *
 * @return Scripts WP_Grid_Builder\FrontEnd\Scripts instance.
 */
function wpgb_scripts() {

	return Scripts::get_instance();

}

/**
 * Get styles instance
 *
 * @since 1.2.1
 *
 * @return Styles WP_Grid_Builder\FrontEnd\Styles instance.
 */
function wpgb_styles() {

	return Styles::get_instance();

}

/**
 * Register core plugin script
 *
 * @since 1.2.1
 *
 * @param string $handle Script handle name.
 */
function wpgb_register_script( $handle ) {

	$instance = wpgb_scripts();
	$instance->register_script( $handle );

}

/**
 * Register core plugin style
 *
 * @since 1.2.1
 *
 * @param string $handle Style handle name.
 */
function wpgb_register_style( $handle ) {

	$instance = wpgb_styles();
	$instance->register_style( $handle );

}

/**
 * Deregister core plugin script
 *
 * @since 1.2.1
 *
 * @param string $handle Script handle name.
 */
function wpgb_deregister_script( $handle ) {

	$instance = wpgb_scripts();
	$instance->deregister_script( $handle );

}

/**
 * Deregister core plugin style
 *
 * @since 1.2.1
 *
 * @param string $handle Style handle name.
 */
function wpgb_deregister_style( $handle ) {

	$instance = wpgb_styles();
	$instance->deregister_style( $handle );

}

/**
 * Enqueue all registered scripts
 *
 * @since 1.2.1
 */
function wpgb_enqueue_scripts() {

	$instance = wpgb_scripts();
	$instance->enqueue();

}

/**
 * Enqueue all registered styles
 *
 * @since 1.2.1
 */
function wpgb_enqueue_styles() {

	$instance = wpgb_styles();
	$instance->enqueue();

}

/**
 * Get registered scripts
 *
 * @since 1.2.1
 *
 * @return array
 */
function wpgb_get_scripts() {

	$instance = wpgb_scripts();
	return $instance->get_scripts();

}

/**
 * Get registered styles
 *
 * @since 1.2.1
 *
 * @return array
 */
function wpgb_get_styles() {

	$instance = wpgb_styles();
	return $instance->get_styles();

}

/**
 * Get core scripts
 *
 * @since 1.2.1
 *
 * @return array
 */
function wpgb_get_core_scripts() {

	$instance = wpgb_scripts();
	return $instance->core_scripts;

}

/**
 * Get core styles
 *
 * @since 1.2.1
 *
 * @return array
 */
function wpgb_get_core_styles() {

	$instance = wpgb_styles();
	return $instance->core_styles;

}

/**
 * Prevent to defer/async polyfills script
 * Polyfills must be loaded before all other plugin/add-on scripts to prevent any error.
 *
 * @since 1.2.1
 *
 * @param string $tag    The `<script>` tag for the enqueued script.
 * @param string $handle The script's registered handle.
 * @param string $src    The script's source URL.
 * @return string Script tag
 */
function wpgb_polyfill_script_tag( $tag, $handle, $src ) {

	if ( 'wpgb-polyfills' === $handle ) {
		$tag = '<script src="' . esc_url( $src ) . '"></script>'; // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript
	}

	return $tag;

}
add_filter( 'script_loader_tag', 'wpgb_polyfill_script_tag', PHP_INT_MAX, 3 );

<?php
/**
 * Templates functions
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

use WP_Grid_Builder\FrontEnd\Template;
use WP_Grid_Builder\Includes\Helpers;
use WP_Grid_Builder\Includes\Container;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render template
 *
 * @since 1.0.0
 *
 * @param array  $args     Template paramters.
 * @param string $abstract Abstract class method to call.
 */
function wpgb_render_template( $args, $abstract = 'render' ) {

	$template = new Template( $args );

	if ( 'render' === $abstract ) {
		$template->render();
	} else {
		$template->query();
	}

}

/**
 * Refresh template asynchronously
 *
 * @since 1.0.0
 *
 * @param array $args Template paramters.
 */
function wpgb_refresh_template( $args ) {

	ob_start();

	$template = new Template( $args );
	$template->refresh();

	return ob_get_clean();

}

/**
 * Do loop
 *
 * @since 1.0.0
 */
function wpgb_template_do_loop() {

	Container::instance( 'Container/Grid' )->get( 'Loop' )->run();

}
add_action( 'wp_grid_builder/layout/do_loop', 'wpgb_template_do_loop' );

/**
 * Render layout area
 *
 * @since 1.0.0
 *
 * @param string $name Area name.
 */
function wpgb_template_do_area( $name ) {

	$areas = wpgb_get_grid_settings( 'grid_layout' );

	foreach ( $areas as $area => $args ) {

		if ( false === strpos( $area, $name ) || empty( $args['facets'] ) ) {
			continue;
		}

		Helpers::get_template( 'layout/area', $area );

	}

}
add_action( 'wp_grid_builder/layout/do_area', 'wpgb_template_do_area' );

/**
 * Render sidebar
 *
 * @since 1.0.0
 *
 * @param string $name Sidebar name.
 */
function wpgb_template_do_sidebar( $name ) {

	$sidebars = wpgb_get_grid_settings( 'grid_layout' );

	if ( empty( $sidebars[ $name ]['facets'] ) ) {
		return;
	}

	Helpers::get_template( 'layout/sidebar', $name );

}
add_action( 'wp_grid_builder/layout/do_sidebar', 'wpgb_template_do_sidebar' );

/**
 * Render facet
 *
 * @since 1.0.0
 *
 * @param string $name Area name.
 */
function wpgb_template_do_facets( $name ) {

	$settings = wpgb_get_grid_settings();
	$areas = $settings->grid_layout;

	if ( empty( $areas[ $name ]['facets'] ) ) {
		return;
	}

	foreach ( $areas[ $name ]['facets'] as $facet ) {

		// Handle carousel "facets".
		if ( 'prev-button' === $facet || 'next-button' === $facet || 'page-dots' === $facet ) {
			Helpers::get_template( 'carousel/' . $facet );
		} else {

			wpgb_render_facet(
				[
					'id'      => $facet,
					'grid'    => $settings->id,
					'preview' => 'preview' === $settings->id && $settings->is_preview,
				]
			);

		}
	}
}
add_action( 'wp_grid_builder/layout/do_facets', 'wpgb_template_do_facets' );

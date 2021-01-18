<?php
/**
 * Init
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\FrontEnd;

use WP_Grid_Builder\Includes\I18n;
use WP_Grid_Builder\Includes\Helpers;
use WP_Grid_Builder\Includes\Container;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Frontend init class
 *
 * @class WP_Grid_Builder\FrontEnd\Init
 * @since 1.0.0
 */
final class Init extends Async {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		parent::__construct();
		$this->includes();
		$this->hooks();

	}

	/**
	 * Register plugin functions
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function includes() {

		// Include helper functions.
		require_once WPGB_PATH . 'frontend/functions/grids.php';
		require_once WPGB_PATH . 'frontend/functions/facets.php';
		require_once WPGB_PATH . 'frontend/functions/assets.php';
		require_once WPGB_PATH . 'frontend/functions/sources.php';
		require_once WPGB_PATH . 'frontend/functions/templates.php';
		require_once WPGB_PATH . 'frontend/functions/deprecated.php';

		// Include card blocks.
		require_once WPGB_PATH . 'frontend/blocks/base.php';
		require_once WPGB_PATH . 'frontend/blocks/post.php';
		require_once WPGB_PATH . 'frontend/blocks/user.php';
		require_once WPGB_PATH . 'frontend/blocks/term.php';
		require_once WPGB_PATH . 'frontend/blocks/product.php';

	}

	/**
	 * Init hooks
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function hooks() {

		add_action( 'wp_grid_builder/facet/render', [ $this, 'register_facet_assets' ] );
		add_action( 'wp_grid_builder/grid/render', [ $this, 'register_grid_assets' ] );

	}

	/**
	 * Register facet script & style
	 *
	 * @since 1.2.1
	 * @access public
	 */
	public function register_facet_assets() {

		$settings = wpgb_get_global_settings();

		wpgb_register_style( WPGB_SLUG . '-facets' );
		wpgb_register_script( WPGB_SLUG . '-facets' );

		if ( ! empty( $settings['load_polyfills'] ) ) {
			wpgb_register_script( WPGB_SLUG . '-polyfills' );
		}

	}

	/**
	 * Register grid scripts & style
	 *
	 * @since 1.2.1
	 * @access public
	 */
	public function register_grid_assets() {

		$settings = wpgb_get_global_settings();

		wpgb_register_style( WPGB_SLUG . '-style' );
		wpgb_register_script( WPGB_SLUG . '-layout' );

		if ( ! empty( $settings['load_polyfills'] ) ) {
			wpgb_register_script( WPGB_SLUG . '-polyfills' );
		}

		if ( 'wp_grid_builder' === $settings['lightbox_plugin'] ) {
			wpgb_register_script( WPGB_SLUG . '-lightbox' );
		}

	}

	/**
	 * Refresh facets on first load
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @param array $atts Grid/Template/Facets attributes.
	 */
	public function render( $atts ) {

		do_action( 'wp_grid_builder/async/render', $atts );

		if ( ! empty( $atts['is_template'] ) ) {
			wpgb_render_template( $atts, 'Query' );
		} else {
			wpgb_render_grid( $atts, 'Query' );
		}

		$response = [ 'facets' => wpgb_refresh_facets( $atts ) ];
		$response = apply_filters( 'wp_grid_builder/async/render_response', $response, $atts );

		wp_send_json( $response );

	}

	/**
	 * Refresh grid or template
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $atts Grid/Template/Facets attributes.
	 */
	public function refresh( $atts ) {

		$response = [];

		do_action( 'wp_grid_builder/async/refresh', $atts );

		if ( ! empty( $atts['is_template'] ) ) {
			$response['posts'] = wpgb_refresh_template( $atts );
		} else {
			$response['posts'] = wpgb_refresh_grid( $atts );
		}

		$response['facets'] = wpgb_refresh_facets( $atts );
		$response = apply_filters( 'wp_grid_builder/async/refresh_response', $response, $atts );

		wp_send_json( $response );

	}

	/**
	 * Search for facet values/names
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $atts Grid/Template/Facets attributes.
	 */
	public function search( $atts ) {

		do_action( 'wp_grid_builder/async/search', $atts );

		if ( ! empty( $atts['is_template'] ) ) {
			wpgb_render_template( $atts, 'Query' );
		} else {
			wpgb_render_grid( $atts, 'Query' );
		}

		$response = wpgb_refresh_facets( $atts, 'search' );
		$response = apply_filters( 'wp_grid_builder/async/search_response', $response, $atts );

		wp_send_json( $response );

	}
}

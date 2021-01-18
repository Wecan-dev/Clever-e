<?php
/**
 * Gutenberg
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\Includes;

use WP_Grid_Builder\FrontEnd\Async;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Gutenberg block
 *
 * @class WP_Grid_Builder\Includes\Gutenberg
 * @since 1.0.0
 */
class Gutenberg {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'register_block' ] );
		add_filter( 'block_categories', [ $this, 'block_category' ], 10, 2 );
		add_action( 'enqueue_block_editor_assets', [ $this, 'editor_assets' ] );

	}

	/**
	 * Register blocks
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_block() {

		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		register_block_type(
			'wp-grid-builder/grid',
			[
				'editor_script'   => WPGB_SLUG . '-editor',
				'render_callback' => [ $this, 'render_grid' ],
				'attributes'      => [
					'is_gutenberg' => [
						'type'    => 'boolean',
						'default' => is_admin(),
					],
					'className' => [
						'type'    => 'string',
						'default' => '',
					],
					'align'     => [
						'type'    => 'string',
						'default' => 'none',
					],
					'id'        => [
						'type'    => 'number',
						'default' => '',
					],
				],
			]
		);

		register_block_type(
			'wp-grid-builder/facet',
			[
				'editor_script'   => WPGB_SLUG . '-editor',
				'render_callback' => [ $this, 'render_facet' ],
				'attributes'      => [
					'className' => [
						'type'    => 'string',
						'default' => '',
					],
					'align'     => [
						'type'    => 'string',
						'default' => 'none',
					],
					'grid'        => [
						'type'    => 'number',
						'default' => '',
					],
					'id'        => [
						'type'    => 'number',
						'default' => '',
					],
				],
			]
		);

	}

	/**
	 * Add custom category for blocks
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array  $categories Holds Gutenberg categories.
	 * @param object $post Holds post object.
	 * @return array
	 */
	public function block_category( $categories, $post ) {

		return array_merge(
			$categories,
			[
				[
					'slug'  => 'wp_grid_builder',
					'title' => WPGB_NAME,
				],
			]
		);

	}

	/**
	 * Enqueue Gutenberg block assets
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function editor_assets() {

		wp_enqueue_script(
			WPGB_SLUG . '-editor',
			WPGB_URL . 'admin/assets/js/gutenberg.js',
			[ 'wp-api-fetch', 'wp-blocks', 'wp-components', 'wp-data', 'wp-editor', 'wp-element', 'wp-i18n', 'wp-url' ],
			WPGB_VERSION
		);

		wp_enqueue_style(
			WPGB_SLUG . '-editor',
			WPGB_URL . 'admin/assets/css/gutenberg.css',
			[ 'wp-edit-blocks' ],
			WPGB_VERSION
		);

		$this->localize_script();
		$this->set_translations();

	}

	/**
	 * Localize script
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function localize_script() {

		$settings = wpgb_get_global_settings();

		$data = array_merge(
			apply_filters( 'wp_grid_builder/frontend/localize_script', [] ),
			[
				'adminUrl'     => admin_url( 'admin.php' ),
				'frontStyles'  => wpgb_get_styles(),
				'frontScripts' => wpgb_get_scripts(),
				'renderBlocks' => ! empty( $settings['render_blocks'] ),
				'hasGrids'     => 1,
				'hasFacets'    => 1,
				'hasLightbox'  => 1,
			]
		);

		wp_localize_script( 'wp-blocks', WPGB_SLUG . '_settings', $data );

	}

	/**
	 * Set block script translations
	 *
	 * @since 1.0.0
	 */
	public function set_translations() {

		if ( ! function_exists( 'wp_set_script_translations' ) ) {
			return;
		}

		wp_set_script_translations( WPGB_SLUG . '-editor', 'wp-grid-builder', WPGB_PATH . 'languages' );

	}

	/**
	 * Render grid block
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $attributes Holds block attributes.
	 * @return string
	 */
	public function render_grid( $attributes ) {

		ob_start();
		wpgb_render_grid( $attributes );
		$this->enqueue_styles( $attributes );
		return ob_get_clean();

	}

	/**
	 * Render grid block
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $attributes Holds block attributes.
	 * @return string
	 */
	public function render_facet( $attributes ) {

		ob_start();
		wpgb_render_facet( $attributes );
		return ob_get_clean();

	}

	/**
	 * Enqueue block styles in Gutenberg editor
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $attributes Holds block attributes.
	 */
	public function enqueue_styles( $attributes ) {

		// Make sure we are rendering Gutenberg block.
		if ( empty( $attributes['is_gutenberg'] ) ) {
			return;
		}

		// Make sure we are editing in Gutenberg (ServerSideRender component).
		// It prevents to render styles on load if there are grids/facets in content.
		if ( empty( $_GET['context'] ) || 'edit' !== $_GET['context'] ) {
			return;
		}

		// Enqueue plugin styles.
		wpgb_enqueue_styles();

		// Add inline styles generated by a grid only.
		$styles = wp_styles();
		$styles->print_inline_style( WPGB_SLUG . '-style' );
		$styles->do_item( WPGB_SLUG . '-grids' );
		$styles->do_item( WPGB_SLUG . '-fonts' );

	}
}

<?php
/**
 * Scripts
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\FrontEnd;

use WP_Grid_Builder\Includes\I18n;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Localize plugin data
 *
 * @class WP_Grid_Builder\FrontEnd\Localize
 * @since 1.1.5
 */
final class Localize {

	/**
	 * Constructor
	 *
	 * @since 1.1.5
	 * @access public
	 */
	public function __construct() {

		add_filter( 'wp_grid_builder/frontend/localize_script', [ $this, 'localize_data' ] );

	}

	/**
	 * Localize data
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @param array $data Holds data to localize.
	 * @return array
	 */
	public function localize_data( $data ) {

		return array_merge(
			$data,
			$this->globals(),
			$this->helpers(),
			$this->lightbox(),
			$this->combobox(),
			$this->vendors()
		);

	}

	/**
	 * Localize globals
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @return array
	 */
	public function globals() {

		$settings = wpgb_get_global_settings();

		return [
			'lang'      => I18n::current_lang(),
			'ajaxUrl'   => Async::get_endpoint(),
			'history'   => (bool) $settings['history'],
			'mainQuery' => wpgb_get_main_query_vars(),
			'permalink' => preg_replace( '/\?.*/', '', get_pagenum_link() ),
		];

	}

	/**
	 * Checks loaded scripts (mainly to for async/defer scripts)
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @return array
	 */
	public function helpers() {

		$scripts = wpgb_scripts()->scripts;

		return [
			'hasGrids'    => ! empty( $scripts['wpgb-layout'] ),
			'hasFacets'   => ! empty( $scripts['wpgb-facets'] ),
			'hasLightbox' => ! empty( $scripts['wpgb-lightbox'] ),
		];

	}

	/**
	 * Localize lightbox strings
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @return array
	 */
	public function lightbox() {

		$settings = wpgb_get_global_settings();

		return [
			'lightbox' => [
				'plugin'     => $settings['lightbox_plugin'],
				'counterMsg' => esc_html( $settings['lightbox_counter_message'] ),
				'errorMsg'   => esc_html( $settings['lightbox_error_message'] ),
				'prevLabel'  => esc_html( $settings['lightbox_previous_label'] ),
				'nextLabel'  => esc_html( $settings['lightbox_next_label'] ),
				'closeLabel' => esc_html( $settings['lightbox_close_label'] ),
			],
		];

	}

	/**
	 * Localize combobox strings
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @return array
	 */
	public function combobox() {

		return [
			'combobox' => [
				'search'     => esc_html__( 'Please enter 1 or more characters.', 'wp-grid-builder' ),
				'loading'    => esc_html__( 'Loading...', 'wp-grid-builder' ),
				'cleared'    => esc_html__( 'options cleared.', 'wp-grid-builder' ),
				'expanded'   => esc_html__( 'Use Up and Down to choose options, press Enter to select the currently focused option, press Escape to collapse the list.', 'wp-grid-builder' ),
				'noResults'  => esc_html__( 'No Results Found.', 'wp-grid-builder' ),
				'collapsed'  => esc_html__( 'Press Enter or Space to expand the list.', 'wp-grid-builder' ),
				/* translators: %s: Selected option name */
				'selected'   => esc_html__( 'option %s, selected.', 'wp-grid-builder' ),
				/* translators: %s: Deselected option name */
				'deselected' => esc_html__( 'option %s, deselected.', 'wp-grid-builder' ),
			],
		];

	}

	/**
	 * Localize vendors
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @return array
	 */
	public function vendors() {

		return [
			'vendors' => [
				[
					'type'    => 'js',
					'handle'  => WPGB_SLUG . '-date',
					'source'  => WPGB_URL . 'frontend/assets/js/vendors/date.js',
					'version' => filemtime( WPGB_PATH . 'frontend/assets/js/vendors/date.js' ),
				],
				[
					'type'    => 'css',
					'handle'  => WPGB_SLUG . '-date-css',
					'source'  => WPGB_URL . 'frontend/assets/css/vendors/date.css',
					'version' => filemtime( WPGB_PATH . 'frontend/assets/css/vendors/date.css' ),
				],
				[
					'type'    => 'js',
					'handle'  => WPGB_SLUG . '-range',
					'source'  => WPGB_URL . 'frontend/assets/js/vendors/range.js',
					'version' => filemtime( WPGB_PATH . 'frontend/assets/js/vendors/range.js' ),
				],
				[
					'type'    => 'js',
					'handle'  => WPGB_SLUG . '-select',
					'source'  => WPGB_URL . 'frontend/assets/js/vendors/select.js',
					'version' => filemtime( WPGB_PATH . 'frontend/assets/js/vendors/select.js' ),
				],
			],
		];

	}
}

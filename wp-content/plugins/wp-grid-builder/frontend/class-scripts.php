<?php
/**
 * Scripts
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\FrontEnd;

use WP_Grid_Builder\Includes\Singleton;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle global CSS & JS scripts
 *
 * @class WP_Grid_Builder\FrontEnd\Scripts
 * @since 1.1.5
 */
final class Scripts {

	use Singleton;

	/**
	 * Holds all scripts
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @var array
	 */
	public $scripts = [];

	/**
	 * Holds core scripts
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @var array
	 */
	public $core_scripts = [
		[
			'handle'  => WPGB_SLUG . '-polyfills',
			'source'  => WPGB_URL . 'frontend/assets/js/polyfills.js',
			'version' => WPGB_VERSION,
		],
		[
			'handle'  => WPGB_SLUG . '-facets',
			'source'  => WPGB_URL . 'frontend/assets/js/facets.js',
			'version' => WPGB_VERSION,
		],
		[
			'handle'  => WPGB_SLUG . '-lightbox',
			'source'  => WPGB_URL . 'frontend/assets/js/lightbox.js',
			'version' => WPGB_VERSION,
		],
		[
			'handle'  => WPGB_SLUG . '-layout',
			'source'  => WPGB_URL . 'frontend/assets/js/layout.js',
			'version' => WPGB_VERSION,
		],
	];

	/**
	 * Constructor
	 *
	 * @since 1.1.5
	 * @access public
	 */
	public function __construct() {

		add_action( 'wp_footer', [ $this, 'enqueue' ] );

	}

	/**
	 * Register core script
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @param string $handle Name of the script. Should be unique.
	 */
	public function register_script( $handle ) {

		$exists = array_search( $handle, array_column( $this->scripts, 'handle' ) );

		if ( false !== $exists ) {
			return;
		}

		$key = array_search( $handle, array_column( $this->core_scripts, 'handle' ) );

		if ( false === $key ) {
			return;
		}

		$this->scripts[] = $this->core_scripts[ $key ];

	}

	/**
	 * Deregister core script
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @param string $handle Name of the script.
	 */
	public function deregister_script( $handle ) {

		$key = array_search( $handle, array_column( $this->scripts, 'handle' ) );

		if ( false === $key ) {
			return;
		}

		unset( $this->scripts[ $key ] );

	}

	/**
	 * Get Register scripts
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @return array
	 */
	public function get_scripts() {

		return apply_filters( 'wp_grid_builder/frontend/register_scripts', $this->core_scripts );

	}

	/**
	 * Enqueue plugin scripts
	 *
	 * @since 1.2.1
	 * @access public
	 */
	public function enqueue() {

		if ( empty( $this->scripts ) ) {
			return;
		}

		$this->register_scripts();
		$this->enqueue_scripts();
		$this->add_inline_script();

	}

	/**
	 * Register scripts
	 *
	 * @since 1.1.5
	 * @access public
	 */
	public function register_scripts() {

		// Register alias script for dependencies.
		wp_register_script( WPGB_SLUG, false, [], WPGB_VERSION );

		$this->scripts = apply_filters( 'wp_grid_builder/frontend/register_scripts', $this->scripts );
		$this->scripts = array_filter( $this->scripts );
		$this->scripts = array_map(
			function( $script ) {

				wp_register_script( $script['handle'], $script['source'], [ WPGB_SLUG ], $script['version'], true );
				return $script['handle'];

			},
			$this->scripts
		);

	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.1.5
	 * @access public
	 */
	public function enqueue_scripts() {

		$this->scripts = array_fill_keys( $this->scripts, true );
		$this->scripts = apply_filters( 'wp_grid_builder/frontend/enqueue_scripts', $this->scripts );
		$this->scripts = $this->sort_scripts();

		foreach ( $this->scripts as $handle => $enqueue ) {
			$enqueue && wp_enqueue_script( $handle );
		}

		$data = apply_filters( 'wp_grid_builder/frontend/localize_script', [] );
		wp_localize_script( WPGB_SLUG, WPGB_SLUG . '_settings', $data );

	}

	/**
	 * Sort scripts by priority (as stated in $core_scripts).
	 *
	 * @since 1.2.1
	 * @access public
	 */
	public function sort_scripts() {

		$handles = array_flip( array_column( $this->core_scripts, 'handle' ) );
		$handles = array_intersect_key( $handles, $this->scripts );

		return array_merge( $handles, $this->scripts );

	}

	/**
	 * Inline script
	 *
	 * @since 1.2.1
	 * @access public
	 */
	public function add_inline_script() {

		$inline_script = apply_filters( 'wp_grid_builder/frontend/add_inline_script', '' );
		wp_add_inline_script( WPGB_SLUG, $inline_script, 'before' );

	}
}

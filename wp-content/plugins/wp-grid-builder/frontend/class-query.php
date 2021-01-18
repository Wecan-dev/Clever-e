<?php
/**
 * Query
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\FrontEnd;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Query posts in grid
 *
 * @class WP_Grid_Builder\FrontEnd\Query
 * @since 1.0.0
 */
class Query implements Models\Query_Interface {

	/**
	 * Holds grid settings
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array
	 */
	protected $settings = [];

	/**
	 * Source class name
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var string
	 */
	private $source = [];

	/**
	 * Holds queried posts
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var array
	 */
	public $posts = [];

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param object Settings $settings Settings class instance.
	 */
	public function __construct( Settings $settings ) {

		$this->settings = $settings;

	}

	/**
	 * Check source class
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @throws \Exception If no post found.
	 */
	public function check() {

		$source  = $this->settings->source;
		$sources = apply_filters( 'wp_grid_builder/sources', [] );

		$this->source = isset( $sources[ $source ] ) ? $sources[ $source ] : false;

		if ( class_exists( $this->source ) ) {
			return;
		}

		/* translators: %s: grid source type */
		$error_msg = sprintf( __( 'The source "%s" does not exist.', 'wp-grid-builder' ), esc_html( $this->settings->source ) );
		throw new \Exception( $error_msg );

	}

	/**
	 * Query posts from source
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_posts() {

		$this->check();

		$query = new $this->source( $this->settings );

		if ( empty( $query->posts ) ) {

			$this->set_error();
			return $this;

		}

		$this->posts = $query->posts;

		return $this;

	}

	/**
	 * Set error message to display
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function set_error() {

		// If no selected facets (intial load).
		if ( ! wpgb_has_selected_facets() ) {

			$message = __( 'Sorry, no content found.', 'wp-grid-builder' );
			$message = $this->settings->no_posts_msg ?: $message;
			$message = apply_filters( 'wp_grid_builder/grid/no_posts_msg', $message, $this->settings );

		} else {

			$message = __( 'Sorry, no results match your search criteria.', 'wp-grid-builder' );
			$message = $this->settings->no_results_msg ?: $message;
			$message = apply_filters( 'wp_grid_builder/grid/no_results_msg', $message, $this->settings );

		}

		$this->settings->error = new \WP_Error( 'no_results', $message );

	}
}

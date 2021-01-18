<?php
/**
 * Async
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
 * Handle asynchronous requets
 *
 * @class WP_Grid_Builder\FrontEnd\Async
 * @since 1.0.0
 */
abstract class Async {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'define_ajax' ], 0 );
		add_action( 'template_redirect', [ $this, 'intercept_request' ], 0 );

	}

	/**
	 * Get custom async endpoint
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param  string $request Optional.
	 * @return string
	 */
	public static function get_endpoint( $request = 'wpgb_front' ) {

		$home_url = home_url( '/', 'relative' );
		$endpoint = add_query_arg( 'wpgb-ajax', $request, $home_url );
		$endpoint = apply_filters( 'wp_grid_builder/async/get_endpoint', $endpoint );

		return esc_url_raw( $endpoint );

	}


	/**
	 * Set Ajax constant and headers
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function define_ajax() {

		if ( empty( $_GET['wpgb-ajax'] ) ) {
			return;
		}

		if ( ! defined( 'DOING_AJAX' ) ) {
			define( 'DOING_AJAX', true );
		}

		// Turn off display_errors to prevent malformed JSON.
		if ( ! WP_DEBUG || ( WP_DEBUG && ! WP_DEBUG_DISPLAY ) ) {
			// phpcs:disable
			@ini_set( 'display_errors', 0 );
			// phpcs:enabled
		}

		$GLOBALS['wpdb']->hide_errors();

	}

	/**
	 * Send headers for async request
	 *
	 * @since 1.0.0
	 * @access public
	 */
	private function ajax_headers() {

		send_origin_headers();
		send_nosniff_header();
		$this->nocache_headers();
		@header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );
		@header( 'X-Robots-Tag: noindex' );
		status_header( 200 );

	}

	/**
	 * Set nocache_headers to disable page caching.
	 * Set constants to prevent caching by some plugins.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	private function nocache_headers() {

		nocache_headers();

		if ( ! defined( 'DONOTCACHEPAGE' ) ) {
			define( 'DONOTCACHEPAGE', true );
		}

		if ( ! defined( 'DONOTCACHEOBJECT' ) ) {
			define( 'DONOTCACHEOBJECT', true );
		}

		if ( ! defined( 'DONOTCACHEDB' ) ) {
			define( 'DONOTCACHEDB', true );
		}

	}

	/**
	 * Intercept async request.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function intercept_request() {

		global $wp_query;

		if ( empty( $_GET['wpgb-ajax'] ) ) {
			return;
		}

		$wp_query->set( 'wpgb-ajax', sanitize_text_field( wp_unslash( $_GET['wpgb-ajax'] ) ) );

		if ( ! $wp_query->get( 'wpgb-ajax' ) ) {
			return;
		}

		$this->ajax_headers();
		$this->maybe_handle();

		wp_die();

	}

	/**
	 * Check ajax request method
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function maybe_handle() {

		if ( empty( $_GET['action'] ) ) {
			return;
		}

		$action  = sanitize_title( wp_unslash( $_GET['action'] ) );
		$allowed = [ 'render', 'refresh', 'search' ];

		// Make sure only allowed actions can be ran.
		if ( ! in_array( $action, $allowed, true ) ) {
			$this->unknown_error();
		}

		$this->$action( $this->get_request() );

	}

	/**
	 * Get requested data
	 *
	 * Nonce is not necessary in our case and does not improve security at this stage.
	 * Logged out users all have the same nonce and it simply not improves security in our case.
	 * Not testing against a nonce for logged out users also prevents caching issue due to nonce lifetime.
	 * Anyone can filter and query grid content, so there isn't any user capability check.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return array
	 */
	protected function get_request() {

		if ( empty( $_REQUEST[ WPGB_SLUG ] ) ) {
			$this->unknown_error();
		}

		$request = wp_unslash( $_REQUEST[ WPGB_SLUG ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$request = json_decode( $request, true );

		return $request;

	}

	/**
	 * Handle unknown errors
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function unknown_error() {

		wp_send_json(
			[
				'success' => false,
				'message' => esc_html__( 'Sorry, an unknown error occurred.', 'wp-grid-builder' ),
			]
		);

	}

	/**
	 * Handle render action
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @param array $request Holds requested data.
	 */
	abstract protected function render( $request );

	/**
	 * Handle refresh action
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @param array $request Holds requested data.
	 */
	abstract protected function refresh( $request );

	/**
	 * Handle search action
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @param array $request Holds requested data.
	 */
	abstract protected function search( $request );
}

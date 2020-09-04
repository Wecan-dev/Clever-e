<?php

/**
 * Class WOOMULTI_CURRENCY_F_Frontend_Update
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOOMULTI_CURRENCY_F_Frontend_Cache {
	protected $settings;

	public function __construct() {

		$this->settings = WOOMULTI_CURRENCY_F_Data::get_ins();
		if ( $this->settings->get_enable() ) {
//			add_action( 'wp_loaded', array( $this, 'wp_loaded' ) );
			add_action( 'init', array( $this, 'clear_browser_cache' ) );
		}
	}

	/**
	 * Clear cache browser
	 */
	public function clear_browser_cache() {
		if ( isset( $_GET['wmc-currency'] ) ) {
			header( "Cache-Control: no-cache, must-revalidate" );
			header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
			header( "Content-Type: application/xml; charset=utf-8" );
		}
	}

	/**
	 * Clear cache
	 *
	 * @param $cart
	 */
	public function wp_loaded() {
		/*Clear cache with W3 total cache*/
		if ( is_plugin_active( 'w3-total-cache/w3-total-cache.php' ) && isset( $_GET['wmc-currency'] ) ) {
			w3tc_flush_all();
		}

		/*Clear WP Rocket*/
		if ( is_plugin_active( 'wp-rocket/wp-rocket.php' ) && isset( $_GET['wmc-currency'] ) ) {
			set_transient( 'rocket_clear_cache', 'all', HOUR_IN_SECONDS );
			// Remove all cache files.
			$lang = isset( $_GET['lang'] ) && 'all' !== $_GET['lang'] ? sanitize_key( $_GET['lang'] ) : '';
			// Remove all cache files.
			rocket_clean_domain( $lang );

			// Remove all minify cache files.
			rocket_clean_minify();

			// Remove cache busting files.
			rocket_clean_cache_busting();

			// Generate a new random key for minify cache file.
			$options                   = get_option( WP_ROCKET_SLUG );
			$options['minify_css_key'] = create_rocket_uniqid();
			$options['minify_js_key']  = create_rocket_uniqid();
			remove_all_filters( 'update_option_' . WP_ROCKET_SLUG );
			update_option( WP_ROCKET_SLUG, $options );

			//			rocket_dismiss_box( 'rocket_warning_plugin_modification' );

		}
	}

}
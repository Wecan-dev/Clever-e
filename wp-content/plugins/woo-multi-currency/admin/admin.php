<?php

/*
Class Name: WOOMULTI_CURRENCY_F_Admin_Admin
Author: Andy Ha (support@villatheme.com)
Author URI: http://villatheme.com
Copyright 2015 villatheme.com. All rights reserved.
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOOMULTI_CURRENCY_F_Admin_Admin {
	protected $settings;

	function __construct() {
		$this->settings = WOOMULTI_CURRENCY_F_Data::get_ins();
		add_filter(
			'plugin_action_links_woo-multi-currency/woo-multi-currency.php', array(
				$this,
				'settings_link'
			)
		);
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_notices', array( $this, 'cache_plugins_note' ) );
		add_action( 'admin_menu', array( $this, 'menu_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 99 );
		add_filter( 'woocommerce_general_settings', array( $this, 'woocommerce_general_settings' ) );
	}

	public function cache_plugins_note() {
		$page = isset( $_GET['page'] ) ? wp_unslash( $_GET['page'] ) : '';
		if ( $page != 'woo-multi-currency' ) {
			return;
		}
		if ( is_plugin_active( 'wp-super-cache/wp-cache.php' ) && ! is_plugin_active( 'country-caching-extension-for-wp-super-cache/cc_wpsc_init.php' ) ) { ?>
            <div class="notice notice-warning">

                <div class="villatheme-content">
                    <p>
			            <?php echo __( 'You are using <strong>WP Super Cache</strong>. Please install and active <strong>Country Caching For WP Super Cache</strong> that helps <strong>Multi Currency for WooCommerce</strong> is working fine with WP Super Cache.', 'woo-multi-currency' ) ?>
                    </p>
                </div>

            </div>
		<?php }

		if ( is_plugin_active( 'wp-fastest-cache/wpFastestCache.php' ) ) {
			if ( defined( 'WPFC_CACHE_QUERYSTRING' ) && WPFC_CACHE_QUERYSTRING ) {
				return;
			}
			?>

            <div class="notice notice-warning">
                <div class="villatheme-content">
                    <p>
						<?php echo __( 'You are using <strong>WP Fastest Cache</strong>. Please make follow these steps to help <strong>Multi Currency for WooCommerce</strong> work fine with WP Fastest Cache.', 'woo-multi-currency' ) ?>
                    </p>
                    <ul>
                        <li><?php echo __( '1. In <strong>WooCommerce → Settings → General → Default customer location</strong> make sure you have selected: <strong>Geolocate with page caching support</strong>', 'woo-multi-currency' ) ?></li>
                        <li><?php echo __( '2. Open wp-config.php file via FTP then insert <strong>define(\'WPFC_CACHE_QUERYSTRING\', true);</strong>', 'woo-multi-currency' ) ?></li>
                    </ul>
                </div>
            </div>
		<?php }
	}

	/**
	 * Remove currency, decimal, posistion, setting in backend
	 *
	 * @param $datas
	 *
	 * @return mixed
	 */
	public function woocommerce_general_settings( $datas ) {
		foreach ( $datas as $k => $data ) {
			if ( isset( $data['id'] ) ) {
				if ( $data['id'] == 'woocommerce_currency' || $data['id'] == 'woocommerce_price_num_decimals' || $data['id'] == 'woocommerce_currency_pos' ) {
					unset( $datas[ $k ] );
				}
				if ( $data['id'] == 'pricing_options' ) {
					$datas[ $k ]['desc'] = esc_html__( 'The following options affect how prices are displayed on the frontend. Multi Currency for WooCommerce is working. Please go to ', 'woo-multi-currency' ) . '<a href="' . admin_url( '?page=woo-multi-currency' ) . '">' . esc_html__( 'Multi Currency for WooCommerce setting page', 'woo-multi-currency' ) . '</a>' . esc_html__( ' to set default currency.', 'woo-multi-currency' );
				}
			}
		}

		return $datas;
	}

	/*Check Auto update*/
	public function admin_init() {

		$old_data = get_option( 'wmc_selected_currencies', array() );
		if ( count( $old_data ) ) {
			$currency         = $currency_rate = $currency_decimals = $currency_custom = $currency_pos = array();
			$currency_default = '';
			$by_countries     = json_decode( get_option( 'wmc_currency_by_country', array() ), true );

			/*Move Data Currency*/

			foreach ( $old_data as $k => $data ) {
				if ( $data['is_main'] == 1 ) {
					$currency_default = $k;
				}
				$currency[]          = $k;
				$currency_rate[]     = $data['rate'];
				$currency_decimals[] = $data['num_of_dec'];
				$currency_pos[]      = $data['pos'];
				if ( strpos( $data['custom_symbol'], '#PRICE#' ) === false ) {
					$currency_custom[] = '';
				} else {
					$currency_custom[] = $data['custom_symbol'];
				}
			}
			$by_country_args = array();
			/*Move Data Currency By Country*/
			foreach ( $by_countries as $code => $by_country ) {
				$by_country_args[ $code . '_by_country' ] = $by_country;
			}
			/*Move Key data*/
			if ( get_option( 'wmc_oder_id' ) && get_option( 'wmc_email' ) ) {
				$key = trim( get_option( 'wmc_oder_id' ) ) . ',' . trim( get_option( 'wmc_email' ) );
			} else {
				$key = '';
			}

			$args = array(
				'enable'                     => 1,
				'enable_fixed_price'         => 0,
				'currency_default'           => $currency_default,
				'currency'                   => $currency,
				'currency_rate'              => $currency_rate,
				'currency_decimals'          => $currency_decimals,
				'currency_custom'            => array(),
				'currency_pos'               => $currency_pos,
				'auto_detect'                => get_option( 'wmc_enable_approxi' ) ? get_option( 'wmc_enable_approxi' ) : 0,
				'enable_currency_by_country' => get_option( 'wmc_price_by_currency' ) == 'yes' ? 1 : 0,
				'enable_multi_payment'       => get_option( 'wmc_allow_multi' ) == 'yes' ? 1 : 0,
				'key'                        => $key,
				'update_exchange_rate'       => get_option( 'wmc_price_by_currency' ) == 'yes' ? 2 : 0,
				'enable_design'              => 0,
				'title'                      => '',
				'design_position'            => 0,
				'text_color'                 => '#fff',
				'background_color'           => '#212121',
				'main_color'                 => '#f78080',
				'flag_custom'                => ''
			);

			$args = array_merge( $args, $by_country_args );
			update_option( 'woo_multi_currency_params', $args );
			update_option( 'woo_multi_currency_old_version', 1 );
			delete_option( 'wmc_selected_currencies' );
		}
		/*Set currency again in backend*/
		if ( ! is_ajax() ) {
			$current_currency = get_option( 'woocommerce_currency' );
			$this->settings->set_current_currency( $current_currency );
		}
	}


	/**
	 * Init Script in Admin
	 */
	public function admin_enqueue_scripts() {
		$page = isset( $_REQUEST['page'] ) ? wp_unslash( $_REQUEST['page'] ) : '';
		if ( $page == 'woo-multi-currency' ) {
			global $wp_scripts;
			$scripts = $wp_scripts->registered;
			foreach ( $scripts as $k => $script ) {
				preg_match( '/^\/wp-/i', $script->src, $result );
				if ( count( array_filter( $result ) ) < 1 ) {
					if ( $script->handle == 'query-monitor' ) {
						continue;
					}
					wp_dequeue_script( $script->handle );
				}
			}

			/*Stylesheet*/
			wp_enqueue_style( 'woo-multi-currency-button', WOOMULTI_CURRENCY_F_CSS . 'button.min.css' );
			wp_enqueue_style( 'woo-multi-currency-table', WOOMULTI_CURRENCY_F_CSS . 'table.min.css' );
			wp_enqueue_style( 'woo-multi-currency-transition', WOOMULTI_CURRENCY_F_CSS . 'transition.min.css' );
			wp_enqueue_style( 'woo-multi-currency-form', WOOMULTI_CURRENCY_F_CSS . 'form.min.css' );
			wp_enqueue_style( 'woo-multi-currency-icon', WOOMULTI_CURRENCY_F_CSS . 'icon.min.css' );
			wp_enqueue_style( 'woo-multi-currency-dropdown', WOOMULTI_CURRENCY_F_CSS . 'dropdown.min.css' );
			wp_enqueue_style( 'woo-multi-currency-checkbox', WOOMULTI_CURRENCY_F_CSS . 'checkbox.min.css' );
			wp_enqueue_style( 'woo-multi-currency-segment', WOOMULTI_CURRENCY_F_CSS . 'segment.min.css' );
			wp_enqueue_style( 'woo-multi-currency-menu', WOOMULTI_CURRENCY_F_CSS . 'menu.min.css' );
			wp_enqueue_style( 'woo-multi-currency-tab', WOOMULTI_CURRENCY_F_CSS . 'tab.css' );
			wp_enqueue_style( 'woo-multi-currency-input', WOOMULTI_CURRENCY_F_CSS . 'input.min.css' );
			wp_enqueue_style( 'woo-multi-currency-popup', WOOMULTI_CURRENCY_F_CSS . 'popup.min.css' );
			wp_enqueue_style( 'woo-multi-currency-message', WOOMULTI_CURRENCY_F_CSS . 'message.min.css' );
			wp_enqueue_style( 'woo-multi-currency', WOOMULTI_CURRENCY_F_CSS . 'woo-multi-currency-admin.css' );
			wp_enqueue_style( 'select2', WOOMULTI_CURRENCY_F_CSS . 'select2.min.css' );

			wp_enqueue_script( 'select2' );
			wp_enqueue_script( 'woo-multi-currency-transition', WOOMULTI_CURRENCY_F_JS . 'transition.min.js', array( 'jquery' ) );
			wp_enqueue_script( 'woo-multi-currency-dropdown', WOOMULTI_CURRENCY_F_JS . 'dropdown.js', array( 'jquery' ) );
			wp_enqueue_script( 'woo-multi-currency-checkbox', WOOMULTI_CURRENCY_F_JS . 'checkbox.js', array( 'jquery' ) );
			wp_enqueue_script( 'woo-multi-currency-tab', WOOMULTI_CURRENCY_F_JS . 'tab.js', array( 'jquery' ) );
			wp_enqueue_script( 'woo-multi-currency-address', WOOMULTI_CURRENCY_F_JS . 'jquery.address-1.6.min.js', array( 'jquery' ) );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'woo-multi-currency', WOOMULTI_CURRENCY_F_JS . 'woo-multi-currency-admin.js', array( 'jquery' ), WOOMULTI_CURRENCY_F_VERSION );
			/*Color picker*/
			wp_enqueue_script(
				'iris', admin_url( 'js/iris.min.js' ), array(
				'jquery-ui-draggable',
				'jquery-ui-slider',
				'jquery-touch-punch'
			), false, 1
			);

		}

	}

	/**
	 * Link to Settings
	 *
	 * @param $links
	 *
	 * @return mixed
	 */
	public function settings_link( $links ) {
		$settings_link = '<a href="admin.php?page=woo-multi-currency" title="' . __( 'Settings', 'woo-multi-currency' ) . '">' . __( 'Settings', 'woo-multi-currency' ) . '</a>';
		array_unshift( $links, $settings_link );

		return $links;
	}


	/**
	 * Function init when run plugin+
	 */
	function init() {
		/*Register post type*/

		load_plugin_textdomain( 'woo-multi-currency' );
		$this->load_plugin_textdomain();
	}


	/**
	 * load Language translate
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woo-multi-currency' );
		// Global + Frontend Locale
		load_textdomain( 'woo-multi-currency', WOOMULTI_CURRENCY_F_LANGUAGES . "woo-multi-currency-$locale.mo" );
		load_plugin_textdomain( 'woo-multi-currency', false, WOOMULTI_CURRENCY_F_LANGUAGES );
	}

	/**
	 * Register a custom menu page.
	 */
	public function menu_page() {
		add_menu_page(
			esc_html__( 'Multi Currency for WooCommerce', 'woo-multi-currency' ), esc_html__( 'Multi Currency', 'woo-multi-currency' ), 'manage_woocommerce', 'woo-multi-currency', array(
			'WOOMULTI_CURRENCY_F_Admin_Settings',
			'page_callback'
		), WOOMULTI_CURRENCY_F_IMAGES . 'icon.svg', 2
		);

	}

}

?>
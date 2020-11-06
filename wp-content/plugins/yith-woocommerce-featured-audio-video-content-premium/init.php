<?php
/**
 * Plugin Name: YITH WooCommerce Featured Audio and Video Content Premium
 * Plugin URI: https://yithemes.com/themes/plugins/yith-woocommerce-featured-audio-video-content/
 * Description: <code><strong>YITH WooCommerce Featured Audio and Video Content</strong></code> allows you to set a video or audio instead of the featured image on the single product page. Also, you can add video or audio to a different gallery under the featured content. <a href="https://yithemes.com">Get more plugins for your e-commerce shop on <strong>YITH</strong></a>.
 * Version: 1.3.4
 * Author: YITH
 * Author URI: https://yithemes.com/
 * Text Domain: yith-woocommerce-featured-video
 * Domain Path: /languages/
 * WC requires at least: 3.3
 * WC tested up to: 4.2
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Featured Audio and Video Content
 * @version 1.3.4
 */

/*  Copyright 2013  Your Inspiration Themes  (email : plugins@yithemes.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

function yith_ywcfav_premium_install_woocommerce_admin_notice() {
	?>
    <div class="error">
        <p><?php _e( 'YITH WooCommerce Featured Audio and Video Content Premium is enabled but not effective. It requires WooCommerce in order to work.', 'yith-woocommerce-featured-video' ); ?></p>
    </div>
	<?php
}

if ( ! function_exists( 'yit_deactive_free_version' ) ) {
	require_once 'plugin-fw/yit-deactive-plugin.php';
}
yit_deactive_free_version( 'YWCFAV_FREE_INIT', plugin_basename( __FILE__ ) );


if ( ! defined( 'YWCFAV_VERSION' ) ) {

	define( 'YWCFAV_VERSION', '1.3.4' );

}

if ( ! defined( 'YWCFAV_DB_VERSION' ) ) {
	define( 'YWCFAV_DB_VERSION', '1.0.0' );
}

if ( ! defined( 'YWCFAV_PREMIUM' ) ) {
	define( 'YWCFAV_PREMIUM', '1' );
}

if ( ! defined( 'YWCFAV_INIT' ) ) {
	define( 'YWCFAV_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YWCFAV_FILE' ) ) {
	define( 'YWCFAV_FILE', __FILE__ );
}

if ( ! defined( 'YWCFAV_DIR' ) ) {
	define( 'YWCFAV_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'YWCFAV_URL' ) ) {
	define( 'YWCFAV_URL', plugins_url( '/', __FILE__ ) );
}

if ( ! defined( 'YWCFAV_ASSETS_URL' ) ) {
	define( 'YWCFAV_ASSETS_URL', YWCFAV_URL . 'assets/' );
}

if ( ! defined( 'YWCFAV_TEMPLATE_PATH' ) ) {
	define( 'YWCFAV_TEMPLATE_PATH', YWCFAV_DIR . 'templates/' );
}

if ( ! defined( 'YWCFAV_INC' ) ) {
	define( 'YWCFAV_INC', YWCFAV_DIR . 'includes/' );
}

if ( ! defined( 'YWCFAV_SLUG' ) ) {
	define( 'YWCFAV_SLUG', 'yith-woocommerce-featured-video' );
}

if ( ! defined( 'YWCFAV_SECRET_KEY' ) ) {

	define( 'YWCFAV_SECRET_KEY', '93FEoHyjFMjQYXJWm5Jt' );
}


if ( ! function_exists( 'yith_plugin_registration_hook' ) ) {
	require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );

/* Plugin Framework Version Check */
if ( ! function_exists( 'yit_maybe_plugin_fw_loader' ) && file_exists( YWCFAV_DIR . 'plugin-fw/init.php' ) ) {
	require_once( YWCFAV_DIR . 'plugin-fw/init.php' );
}

yit_maybe_plugin_fw_loader( YWCFAV_DIR );

if ( ! function_exists( 'YITH_Featured_Audio_Video_Premium_Init' ) ) {
	/**
	 * Unique access to instance of YITH_WC_Audio_Video_Premium class
	 *
	 *
	 * @since 1.0.2
	 */
	function YITH_Featured_Audio_Video_Premium_Init() {

		load_plugin_textdomain( 'yith-woocommerce-featured-video', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		require_once( YWCFAV_INC . 'classes/widgets/class.yith-favc-slider-widget.php' );
		require_once( YWCFAV_INC . 'classes/class.ywcfav-theme-integrations.php' );
		require_once( YWCFAV_INC . 'functions.yith-wc-featured-audio-video.php' );
		require_once( YWCFAV_INC . 'classes/class.ywcfav-manager.php' );
		require_once( YWCFAV_INC . 'classes/class.ywcfav-manager-premium.php' );
		require_once( YWCFAV_INC . 'classes/class.ywcfav-admin.php' );
		require_once( YWCFAV_INC . 'classes/class.ywcfav-admin-premium.php' );
		require_once( YWCFAV_INC . 'classes/class.ywcfav-frontend.php' );
		require_once( YWCFAV_INC . 'classes/class.ywcfav-frontend-premium.php' );
		require_once( YWCFAV_INC . 'classes/class.ywcfav-zoom-magnifier.php' );
		require_once( YWCFAV_INC . 'classes/modules/class.yith-quick-view-module.php' );
		require_once( YWCFAV_INC . 'classes/class.yith-woocommerce-audio-video-content.php' );

		global $YITH_Featured_Audio_Video;
		$YITH_Featured_Audio_Video = YITH_Featured_Video();
	}
}

add_action( 'yith_wc_featured_audio_video_premium_init', 'YITH_Featured_Audio_Video_Premium_Init' );

if ( ! function_exists( 'yith_featured_audio_video_premium_install' ) ) {
	/**
	 * install featured audio video content
	 * @author YIThemes
	 * @since 1.0.2
	 */
	function yith_featured_audio_video_premium_install() {

		if ( ! function_exists( 'WC' ) ) {
			add_action( 'admin_notices', 'yith_ywcfav_install_woocommerce_admin_notice' );
		} else {
			do_action( 'yith_wc_featured_audio_video_premium_init' );
		}

	}
}

add_action( 'plugins_loaded', 'yith_featured_audio_video_premium_install', 11 );

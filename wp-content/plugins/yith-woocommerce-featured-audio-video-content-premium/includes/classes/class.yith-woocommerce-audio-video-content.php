<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'YITH_WC_Audio_Video' ) ) {

	class YITH_WC_Audio_Video {

		protected static $_instance;


		public function __construct() {

			// Load Plugin Framework
			add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 15 );
			add_action( 'wp_enqueue_scripts', array( $this, 'include_video_scripts' ), 20 );
			YITH_Featured_Video_Manager();
			add_action( 'init', 'YITH_FAV_Load_Themes_Integration' , 20 );
			if( !is_admin() || defined( 'DOING_AJAX' ) ) {

				if ( ( ywcfav_check_is_zoom_magnifier_is_active() && ! ywcfav_check_is_product_is_exclude_from_zoom() ) ) {

					YITH_Featured_Audio_Video_Zoom_Magnifier();
				}  else {
					YITH_Featured_Audio_Video_Frontend();
				}
				if ( defined( 'YITH_WCQV_PREMIUM' ) ) {

					YITH_FAV_Quick_View_Module();
				}
			}

			if( is_admin() ) {
				YITH_Featured_Audio_Video_Admin();
			}

		}


		public function load_right_class(){

		}

		/** return single instance of class
		 * @author YITHEMES
		 * @since 2.0.0
		 * @return YITH_WC_Audio_Video
		 */
		public static function get_instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function plugin_fw_loader() {
			if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
				global $plugin_fw_data;
				if ( ! empty( $plugin_fw_data ) ) {
					$plugin_fw_file = array_shift( $plugin_fw_data );
					require_once( $plugin_fw_file );
				}
			}
		}

		public function include_video_scripts() {


			if ( is_product()  || defined( 'YITH_WCQV_PREMIUM' )  ) {


				wp_enqueue_style( 'videojs', YWCFAV_ASSETS_URL . 'css/videojs/video-js.min.css', array(), YWCFAV_VERSION );
				wp_enqueue_style( 'venobox_style', YWCFAV_ASSETS_URL . '/css/venobox.css' );

				wp_enqueue_script( 'venobox_api', YWCFAV_ASSETS_URL . 'js/lib/jquery.venobox.js', array( 'jquery' ), false, true );
				wp_enqueue_script( 'vimeo-api', YWCFAV_ASSETS_URL . 'js/lib/vimeo_player.js', array(), YWCFAV_VERSION, true );
				wp_enqueue_script( 'youtube-api', YWCFAV_ASSETS_URL . 'js/lib/youtube_api.js', array( 'jquery' ), YWCFAV_VERSION, true );
				wp_register_script( 'videojs', YWCFAV_ASSETS_URL . 'js/lib/video.js', array( 'jquery' ), YWCFAV_VERSION, true );
				wp_enqueue_script( 'soundcloud', YWCFAV_ASSETS_URL . 'js/lib/soundcloud.js', array(), YWCFAV_VERSION, true );

				wp_enqueue_style( 'ywcfav_style', YWCFAV_ASSETS_URL . 'css/ywcfav_frontend.css', array(), YWCFAV_VERSION );

				wp_enqueue_script( 'ywcfav_content_manager', YWCFAV_ASSETS_URL . 'js/' . yit_load_js_file( 'ywcfav_content_manager.js' ), array(
					'jquery',
					'videojs',
					'youtube-api',
					'vimeo-api'
				), YWCFAV_VERSION, true );

				$script_args = array(
					'product_gallery_trigger_class' => '.' . ywcfav_get_product_gallery_trigger(),
					'current_slide_active_class'                  => '.'.ywcfav_get_current_slider_class(),
					'autoplay'                      => get_option( 'ywcfav_autoplay', 'no' )
				);

				wp_localize_script( 'ywcfav_content_manager', 'ywcfav_args', $script_args );

				wp_enqueue_script( 'ywcfav_owl_carousel', YWCFAV_ASSETS_URL . '/js/lib/owl.carousel.min.js', array( 'jquery' ), false, true );
				wp_enqueue_style( 'ywcfav_owl_carousel_style', YWCFAV_ASSETS_URL . '/css/owl-carousel/owl.carousel.css' );

				wp_enqueue_script( 'ywcfav_slider', YWCFAV_ASSETS_URL . 'js/' . yit_load_js_file( 'ywcfav_slider.js' ), array(
					'jquery',
					'venobox_api'
				), YWCFAV_VERSION, true );


				$effect = get_option( 'ywcfav_modal_effect' );

				if ( $effect > 0 ) {
					wp_enqueue_style( 'venobox_effects', YWCFAV_ASSETS_URL . 'css/effects/effect-' . $effect . '.css', array(), YWCFAV_VERSION );
				}
			}
		}

		/**
		 *this method is deprecated, valid for old custom codes
		 * @author Salvatore Strano
		 *
		 * @deprecated since 1.2.0 Use YITH_Featured_Video_Manager()->woocommerce_show_product_video_thumbnails
		 */
		public function woocommerce_show_product_video_thumbnails(){
			_deprecated_function( __METHOD__, '1.2.0', 'YITH_Featured_Video_Manager()->woocommerce_show_product_video_thumbnails()' );
			YITH_Featured_Video_Manager()->woocommerce_show_product_video_thumbnails();
		}

		/**
		 *this method is deprecated, valid for old custom codes
		 * @author Salvatore Strano
		 *
		 * @deprecated since 1.2.0 Use YITH_Featured_Video_Manager()->woocommerce_show_product_audio_thumbnails
		 */
		public function woocommerce_show_product_audio_thumbnails(){
			_deprecated_function( __METHOD__, '1.2.0', 'YITH_Featured_Video_Manager()->woocommerce_show_product_audio_thumbnails()' );
			YITH_Featured_Video_Manager()->woocommerce_show_product_audio_thumbnails();
		}

	}

}


if ( ! function_exists( 'YITH_Featured_Video' ) ) {
	function YITH_Featured_Video() {
		return YITH_WC_Audio_Video::get_instance();
	}
}
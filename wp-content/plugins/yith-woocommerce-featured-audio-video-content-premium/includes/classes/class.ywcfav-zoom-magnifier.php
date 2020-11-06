<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'YITH_Featured_Audio_Video_Zoom_Magnifier' ) ) {

	class YITH_Featured_Audio_Video_Zoom_Magnifier {


		protected static $instance;

		public function __construct() {

			add_filter( 'ywcfav_get_gallery_item_class', array( $this, 'change_gallery_item_class' ), 10, 1 );
			add_filter( 'ywcfav_get_thumbnail_gallery_item', array( $this, 'change_thumbnail_gallery_item' ), 10, 1 );

			add_filter( 'woocommerce_single_product_image_html', array( $this, 'show_featured_content' ), 10, 2 );
			add_filter( 'yith_wcmg_get_post_thumbnail_id', array( $this, 'get_featured_thumbnail_id' ), 10, 2 );

			add_action( 'wp_enqueue_scripts', array( $this, 'include_scripts' ), 30 );

			remove_action( 'woocommerce_product_thumbnails', array(
				YITH_Featured_Video_Manager(),
				'add_variation_content'
			), 99 );
			remove_filter( 'woocommerce_available_variation', array(
				YITH_Featured_Video_Manager(),
				'add_variation_data'
			), 10 );

			add_filter( 'woocommerce_available_variation', array( $this, 'add_variation_data' ), 10, 3 );
			add_action( 'wp_ajax_get_variation_content', array( $this, 'get_variation_content' ) );
			add_action( 'wp_ajax_nopriv_get_variation_content', array( $this, 'get_variation_content' ) );

			add_action( 'wp_ajax_get_gallery_content', array( $this, 'get_gallery_content' ) );
			add_action( 'wp_ajax_nopriv_get_gallery_content', array( $this, 'get_gallery_content' ) );

			add_filter( 'ywcfav_gallery_modal_link', array( $this, 'change_gallery_link' ), 10, 6 );

		}

		/** return single instance of class
		 * @author YITH
		 * @since 2.0.0
		 * @return YITH_Featured_Audio_Video_Zoom_Magnifier
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function change_gallery_item_class( $class ) {

			return $class;
		}

		public function change_thumbnail_gallery_item( $class ) {

			return 'yith_magnifier_gallery li';
		}


		public function show_featured_content( $html, $product_id ) {

			$product    = wc_get_product( $product_id );
			$video_args = YITH_Featured_Video_Manager()->get_featured_args( $product );

			if ( ! empty( $video_args ) ) {


				$new_html = YITH_Featured_Video_Manager()->get_featured_template( $video_args );
				$html     = $new_html . '<div id="ywcfav_zoom_content" class="ywcfav_hide">' . $html . '</div>';
			}

			return $html;
		}

		public function get_featured_thumbnail_id( $thumbnail_id, $product_id ) {
			$product    = wc_get_product( $product_id );
			$video_args = YITH_Featured_Video_Manager()->get_featured_args( $product );

			if ( ! empty( $video_args ) ) {

				$thumbnail_id = $video_args['thumbnail_id'];
			}

			return $thumbnail_id;
		}

		public function include_scripts() {

			wp_register_script( 'ywcfav_zoom_magnifier', YWCFAV_ASSETS_URL . 'js/' . yit_load_js_file( 'ywfav_zoom_magnifier.js' ), array(
				'jquery',
				'ywcfav_content_manager',
				'venobox_api',
				'videojs'
			), YWCFAV_VERSION, true );
			$script_args = array(

				'img_class_container'             => '.' . ywcfav_get_gallery_item_class(),
				'thumbnail_gallery_class_element' => '.' . ywcfav_get_thumbnail_gallery_item(),
				'admin_url'                       => admin_url( 'admin-ajax.php', is_ssl() ? 'https' : 'http' ),
				'actions'                         => array(
					'get_variation_content' => 'get_variation_content',
					'get_gallery_content'   => 'get_gallery_content'
				)
			);

			wp_register_style( 'ywcfav_zoom_magnifier', YWCFAV_ASSETS_URL . 'css/ywcfav_zoom_style.css', array(), YWCFAV_VERSION );
			if ( is_product() ) {
				wp_localize_script( 'ywcfav_zoom_magnifier', 'ywcfav_zoom_params', $script_args );
				wp_enqueue_script( 'ywcfav_zoom_magnifier' );
				wp_enqueue_style( 'ywcfav_zoom_magnifier' );
			}
		}

		/**
		 * @param array $variation_data
		 * @param WC_Product_Variable $variable_product
		 * @param WC_Product_Variation $variation_product
		 *
		 * @return array
		 */
		public function add_variation_data( $variation_data, $variable_product, $variation_product ) {

			$video = $variation_product->get_meta( '_ywcfav_variation_video', true );

			if ( ! empty( $video ) ) {

				$variation_data['variation_video'] = $video['id'];
			}

			return $variation_data;
		}

		public function get_variation_content() {

			if ( isset( $_REQUEST['variation_id'] ) && isset( $_REQUEST['content_id'] ) ) {

				$product    = wc_get_product( $_REQUEST['variation_id'] );
				$content_id = $_REQUEST['content_id'];
				$content    = YITH_Featured_Video_Manager()->find_featured_video( $product, $content_id );
				if ( ! empty( $content ) ) {
					if ( 'url' == $content['type'] ) {
						list( $host, $video_id ) = explode( ':', ywcfav_video_type_by_url( $content['content'] ) );

					} else {
						$video_id = $content['content'];
					}

					$video_args = array(
						'id'                        => $content['id'],
						'video_id'                  => $video_id,
						'host'                      => $content['host'],
						'thumbnail_id'              => $content['thumbn'],
						'featured_content_selected' => true,
						'product_id'                => $_REQUEST['variation_id']

					);
					$args       = YITH_Featured_Video_Manager()->get_featured_video_args( $product, $content );
					$args       = array_merge( $video_args, $args );

					$html = YITH_Featured_Video_Manager()->get_featured_template( $args );

					wp_send_json( $html );
				}
			}
		}

		/**
		 * show the a custom content in the video or audio gallery in the featured place
		 *
		 */
		public function get_gallery_content() {

			if ( isset( $_REQUEST['product_id'] ) && isset( $_REQUEST['content_id'] ) && isset( $_REQUEST['content_type'] ) ) {

				$type       = $_REQUEST['content_type'];
				$product_id = $_REQUEST['product_id'];
				$content_id = $_REQUEST['content_id'];
				$args  = array();

				$featured_args = array(
					'id' => $content_id,
					'type' => $type
				);
				$product = wc_get_product( $product_id );
				$args = YITH_Featured_Video_Manager()->get_featured_args( $product, $featured_args );
				$args['featured_content_selected'] = true;

				if( !empty( $args ) ){

					if( 'video' == $type ){
						$template_name = 'template_video.php';
					}else{
						$template_name = 'template_audio.php';
					}

					ob_start();
					wc_get_template( $template_name, $args, YWCFAV_TEMPLATE_PATH, YWCFAV_TEMPLATE_PATH );
					$html = ob_get_contents();
					ob_end_clean();

					wp_send_json( $html );
				}

			}
		}

		/**
		 * @param string $html
		 * @param string $type
		 * @param string $terms_url
		 * @param array $content
		 * @param string $thumbnail_url
		 * @param WC_Product $product
		 *
		 * @return string
		 */
		public function change_gallery_link( $html, $type, $terms_url, $content, $thumbnail_url, $product ) {

			$show_content_gallery_in_featured_place = get_option( 'ywcfav_zoom_magnifer_option', 'no' );

			if ( 'yes' == $show_content_gallery_in_featured_place ) {

				$class= 'video' == $type ? 'ywcfav_video_as_zoom' : 'ywcfav_audio_as_zoom';
				$html = '<a href="" rel="nofollow" class="%s" data-product_id="%s" data-content_id="%s"  title="%s"><img src="%s" alt="%s"></a>';

				$html = sprintf( $html, $class,$product->get_id(), $content['id'], $content['name'], $thumbnail_url, $content['name'] );
			}

			return $html;
		}
	}
}


if ( ! function_exists( 'YITH_Featured_Audio_Video_Zoom_Magnifier' ) ) {

	function YITH_Featured_Audio_Video_Zoom_Magnifier() {

		return YITH_Featured_Audio_Video_Zoom_Magnifier::get_instance();

	}
}
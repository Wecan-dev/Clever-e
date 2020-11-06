<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'YITH_Featured_Audio_Video_Admin_Premium' ) ) {

	class YITH_Featured_Audio_Video_Admin_Premium extends YITH_Featured_Audio_Video_Admin {

		protected static $instance;

		public function __construct() {
			parent::__construct();

			remove_action( 'woocommerce_product_options_general_product_data', array( $this, 'add_video_field' ) );
			add_action( 'admin_init', array( $this, 'save_audio_placeholder' ), 20 );
			add_filter( 'ywcfav_add_premium_tab', array( $this, 'add_premium_tab' ) );
			add_filter( 'woocommerce_product_write_panel_tabs', array(
				$this,
				'print_audio_video_product_panels'
			), 98 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_premium_style_script' ) );

			//AJAX ACTION to add video and audio row
			//Save thumbn for video embedded via ajax
			add_action( 'wp_ajax_save_thumbnail_video', array( $this, 'ajax_save_thumbnail_video' ) );
			//add new video row
			add_action( 'wp_ajax_add_new_video_row', array( $this, 'add_new_video_row' ) );
			//add new audio row
			add_action( 'wp_ajax_add_new_audio_row', array( $this, 'add_new_audio_row' ) );

			//add new video row on variation
			add_action( 'wp_ajax_add_new_video_variation', array( $this, 'add_new_video_variation' ) );

			//add metaboxes in woocommerce product
			add_action( 'add_meta_boxes', array( $this, 'add_product_select_featured_content_meta_boxes' ) );

			add_action( 'wp_loaded', array( $this, 'register_plugin_for_activation' ), 99 );
			add_action( 'admin_init', array( $this, 'register_plugin_for_updates' ) );

			add_action( 'woocommerce_product_after_variable_attributes', array(
				$this,
				'print_variable_video_product'
			), 20, 3 );

			add_action( 'woocommerce_save_product_variation', array( $this, 'save_product_variation_meta' ), 10, 2 );
		}

		/** return single instance of class
		 * @author YITH
		 * @since 2.0.0
		 * @return YITH_Featured_Audio_Video_Admin_Premium
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/* Register plugins for activation tab
	   *
	   * @return void
	   * @since    1.0.0
	   * @author   Andrea Grillo <andrea.grillo@yithemes.com>
	   */
		public function register_plugin_for_activation() {
			if ( ! class_exists( 'YIT_Plugin_Licence' ) ) {
				require_once YWCFAV_DIR . 'plugin-fw/licence/lib/yit-licence.php';
				require_once YWCFAV_DIR . 'plugin-fw/licence/lib/yit-plugin-licence.php';
			}
			YIT_Plugin_Licence()->register( YWCFAV_INIT, YWCFAV_SECRET_KEY, YWCFAV_SLUG );
		}

		/**
		 * Register plugins for update tab
		 *
		 * @return void
		 * @since    1.0.0
		 * @author   Andrea Grillo <andrea.grillo@yithemes.com>
		 */
		public function register_plugin_for_updates() {
			if ( ! class_exists( 'YIT_Upgrade' ) ) {
				require_once( YWCFAV_DIR . 'plugin-fw/lib/yit-upgrade.php' );
			}
			YIT_Upgrade()->register( YWCFAV_SLUG, YWCFAV_INIT );
		}


		/**
		 * save the audio placeholder
		 * @author Salvatore Strano
		 * @author 2.0
		 */
		public function save_audio_placeholder() {

			$audio_id  = get_option( 'ywcfav_audio_placeholder_id', false );
			$audio_src = false;


			if ( $audio_id ) {
				$audio_src = wp_get_attachment_image_src( $audio_id );
			}

			if ( false == $audio_src ) {

				$audio_id = ywcfav_save_remote_image( YWCFAV_ASSETS_URL . 'images/audioplaceholder.jpg', 'audioplaceholder' );

				update_option( 'ywcfav_audio_placeholder_id', $audio_id );
			}
		}

		/**
		 * @param array $tabs
		 *
		 * @return array
		 */
		public function add_premium_tab( $tabs ) {

			unset( $tabs['premium'] );
			$tabs['video-settings']   = __( 'Video Settings', 'yith-woocommerce-featured-video' );
			$tabs['audio-settings']   = __( 'Audio Settings', 'yith-woocommerce-featured-video' );
			$tabs['general-settings'] = __( 'Modal Settings', 'yith-woocommerce-featured-video' );
			$tabs['addon-settings']   = __( 'Gallery Settings', 'yith-woocommerce-featured-video' );


			return $tabs;
		}

		public function print_audio_video_product_panels() {
			?>
            <style type="text/css">
                #woocommerce-product-data ul.wc-tabs .ywcfav_video_data_tab a:before, #woocommerce-product-data ul.wc-tabs .ywcfav_audio_data_tab a:before {
                    content: '';
                    display: none;
                }

            </style>
            <li class="ywcfav_video_data_tab">
                <a href="#ywcfav_video_data">
                    <i class="dashicons dashicons-video-alt2"></i>&nbsp;&nbsp;<?php _e( 'Video', 'yith-woocommerce-featured-video' ); ?>
                </a>
            </li>
            <li class="ywcfav_audio_data_tab">
                <a href="#ywcfav_audio_data">
                    <i class="dashicons dashicons-format-audio"></i>&nbsp;&nbsp;<?php _e( 'Audio', 'yith-woocommerce-featured-video' ); ?>
                </a>
            </li>

			<?php
			add_action( 'woocommerce_product_data_panels', array( $this, 'write_audio_video_product_panels' ) );
		}

		public function write_audio_video_product_panels() {

			include_once( YWCFAV_TEMPLATE_PATH . 'metaboxes/yith-wcfav-video-metabox.php' );
			include_once( YWCFAV_TEMPLATE_PATH . 'metaboxes/yith-wcfav-audio-metabox.php' );
		}

		/**
		 * @author Salvatore Strano<salvatore.strano@yourinspiration.it>
		 * enqueue admin script
		 *
		 */
		public function enqueue_premium_style_script() {
			global $post;

			wp_register_script( 'ywcfav_script', YWCFAV_ASSETS_URL . 'js/' . yit_load_js_file( 'ywcfav_admin.js' ), array( 'jquery' ), time(), true );

			$video_placeholder_id = get_option( 'ywcfav_video_placeholder_id' );
			$audio_placeholder_id = get_option( 'ywcfav_audio_placeholder_id' );

			$ywcfav = array(
				'admin_url'                 => admin_url( 'admin-ajax.php', is_ssl() ? 'https' : 'http' ),
				'video_placeholder_img_src' => YWCFAV_ASSETS_URL . 'images/videoplaceholder.jpg',
				'audio_placeholder_img_src' => YWCFAV_ASSETS_URL . 'images/audioplaceholder.jpg',
				'video_placeholder_img_id'  => $video_placeholder_id,
				'audio_placeholder_img_id'  => $audio_placeholder_id,
				'error_video'               => __( 'Please select a Video', 'yith-woocommerce-featured-video' ),
				'actions'                   => array(
					'save_thumbnail_video'    => 'save_thumbnail_video',
					'add_new_video_row'       => 'add_new_video_row',
					'add_new_audio_row'       => 'add_new_audio_row',
					'add_new_video_variation' => 'add_new_video_variation'
				)
			);

			wp_localize_script( 'ywcfav_script', 'ywcfav', $ywcfav );

			wp_register_style( 'ywcfav_admin_style', YWCFAV_ASSETS_URL . 'css/ywcfav_admin.css', array(), YWCFAV_VERSION );

			if ( ( isset( $_GET['page'] ) && 'yith_wc_featured_audio_video' == $_GET['page'] ) ||
			     ( isset( $post ) && 'product' == get_post_type( $post ) )
			) {
				wp_enqueue_script( 'ywcfav_script' );

				wp_enqueue_style( 'ywcfav_admin_style' );
			}
		}

		/**
		 * plugin_row_meta
		 *
		 * add the action links to plugin admin page
		 *
		 * @param $new_row_meta_args
		 * @param $plugin_file
		 * @param $plugin_data
		 * @param $status
		 * @param $init_file
		 *
		 * @return   array
		 * @since    1.0
		 * @author   Andrea Grillo <andrea.grillo@yithemes.com>
		 * @use plugin_row_meta
		 */
		public function plugin_row_meta( $new_row_meta_args, $plugin_meta, $plugin_file, $plugin_data, $status, $init_file = 'YWCFAV_INIT' ) {

			$new_row_meta_args = parent::plugin_row_meta( $new_row_meta_args, $plugin_meta, $plugin_file, $plugin_data, $status, $init_file );
			if ( defined( $init_file ) && constant( $init_file ) == $plugin_file ) {
				$new_row_meta_args['is_premium'] = true;
			}

			return $new_row_meta_args;
		}

		/**
		 * add new video row in single product
		 * @author Salvatore Strano
		 * @author YITH
		 * @since 2.0.0
		 */
		public function add_new_video_row() {

			if ( isset( $_POST['video_id'] ) ) {


				$video = array(
					'name'     => $_POST['video_name'],
					'thumbn'   => $_POST['video_img'],
					'featured' => 'no',
					'id'       => $_POST['video_id'],
					'host'     => $_POST['video_host'],
					'content'  => $_POST['video_content'],
					'type'     => $_POST['video_type'],

				);

				$video_params = array(
					'video_params' => $video,
					'loop'         => $_POST['loop'],
					'product_id'   => $_POST['product_id']
				);

				ob_start();
				wc_get_template( 'metaboxes/views/html-product-video.php', $video_params, '', YWCFAV_TEMPLATE_PATH );
				$template = ob_get_contents();
				ob_end_clean();

				wp_send_json( array( 'result' => $template ) );
				die;

			}
		}

		/**
		 * add new audio row in single product
		 * @author YITH
		 * @since 1.2.0
		 */
		public function add_new_audio_row() {

			if ( isset( $_POST['audio_id'] ) ) {

				$audio = array(
					'name'     => $_POST['audio_name'],
					'thumbn'   => $_POST['audio_img'],
					'featured' => 'no',
					'id'       => $_POST['audio_id'],
					'url'      => $_POST['audio_content'],

				);

				$audio_params = array(
					'audio_params' => $audio,
					'loop'         => $_POST['loop'],
					'product_id'   => $_POST['product_id']
				);

				ob_start();
				wc_get_template( 'metaboxes/views/html-product-audio.php', $audio_params, '', YWCFAV_TEMPLATE_PATH );
				$template = ob_get_contents();
				ob_end_clean();

				wp_send_json( array( 'result' => $template ) );
				die;

			}

		}

		/**call ajax for save thumbnail video
		 * @author YITH
		 *
		 * @since 1.2.0
		 * @use wp_ajax_save_thumbnail_video
		 *
		 */
		public function ajax_save_thumbnail_video() {

			if ( isset( $_POST['ywcfav_host'] ) && isset( $_POST['ywcfav_id'] ) ) {

				$host       = $_POST['ywcfav_host'];
				$video_id   = $_POST['ywcfav_id'];
				$name       = $_POST['ywcfav_name'];
				$video_info = array(
					'name' => $name,
					'id'   => $video_id,
					'host' => $host
				);

				$image_id = $this->save_video_thumbnail( $video_info );

				$result = 'no';

				if ( $image_id !== '' ) {
					$result = 'ok';

				}

				wp_send_json( array( 'result' => $result, 'id_img' => $image_id ) );
			}
		}

		/**
		 * @param WC_Product $product
		 *
		 * @author YITH
		 * @since 1.2.0
		 */
		public function set_custom_product_meta( $product ) {

			if ( isset( $_POST['ywcfav_video'] ) ) {

				$product->update_meta_data( '_ywcfav_video', $_POST['ywcfav_video'] );
			} else {

				$product->delete_meta_data( '_ywcfav_video' );
			}

			if ( isset( $_POST['ywcfav_audio'] ) ) {
				$product->update_meta_data( '_ywcfav_audio', $_POST['ywcfav_audio'] );

			} else {
				$product->delete_meta_data( '_ywcfav_audio' );
			}

			if ( isset( $_POST['ywcfav_select_featured'] ) && ! empty( $_POST['ywcfav_select_featured'] ) ) {
				$content = $_POST['ywcfav_select_featured'];

				$type = ( strpos( $content, 'ywcfav_video' ) === false ) ? 'audio' : 'video';

				$args = array( 'id' => $content, 'type' => $type );

				$product->update_meta_data( '_ywcfav_featured_content', $args );
			} else {
				$product->delete_meta_data( '_ywcfav_featured_content' );
			}

		}

		/**
		 * add product metabox
		 * @author YITH
		 * @since 1.2.0
		 */
		public function add_product_select_featured_content_meta_boxes() {

			add_meta_box( 'yith-ywcfav-metabox', __( 'Featured Video or Audio', 'yith-woocommerce-featured-video' ), array(
				$this,
				'featured_audio_video_meta_box_content'
			), 'product', 'side', 'core' );
		}

		/**
		 * print product metabox
		 * @author YITH
		 * @since 1.2.0
		 */
		public function featured_audio_video_meta_box_content() {

			wc_get_template( 'metaboxes/yith-wcfav-select-video-featured-metabox.php', array(), YWCFAV_TEMPLATE_PATH, YWCFAV_TEMPLATE_PATH );
		}

		/**
		 * @param int $loop
		 * @param array $variation_data
		 * @param WC_Product_Variation $variation
		 */
		public function print_variable_video_product( $loop, $variation_data, $variation ) {

			$args                    = array(
				'loop'           => $loop,
				'variation_data' => $variation_data,
				'variation'      => $variation
			);
			$args['video_variation'] = $args;

			wc_get_template( 'metaboxes/yith-wcfav-video-product-variations.php', $args, YWCFAV_TEMPLATE_PATH, YWCFAV_TEMPLATE_PATH );

		}

		/**
		 * Save variation meta
		 * @author Salvatore Strano<salvatore.strano@yourinspiration.it>
		 *
		 * @param int $variation_id
		 * @param int $i
		 */
		public function save_product_variation_meta( $variation_id, $i ) {
			$product = wc_get_product( $variation_id );


			if ( isset( $_POST['video_info'][ $i ] ) ) {

				$product->update_meta_data( '_ywcfav_variation_video', $_POST['video_info'][ $i ] );

			} else {
				$product->delete_meta_data( '_ywcfav_variation_video' );
			}
			$product->save();
		}

		public function add_new_video_variation() {

			if ( isset( $_POST['video_id'] ) ) {


				$video = array(
					'name'     => $_POST['video_name'],
					'thumbn'   => $_POST['video_img'],
					'featured' => 'no',
					'id'       => $_POST['video_id'],
					'host'     => $_POST['video_host'],
					'content'  => $_POST['video_content'],
					'type'     => $_POST['video_type'],

				);

				$video_params = array(
					'video_params' => $video,
					'loop'         => $_POST['loop'],
					'product_id'   => $_POST['product_id']
				);

				ob_start();
				wc_get_template( 'metaboxes/views/html-product-variation-video.php', $video_params, '', YWCFAV_TEMPLATE_PATH );
				$template = ob_get_contents();
				ob_end_clean();

				wp_send_json( array( 'result' => $template ) );
				die;
			}
		}
	}
}
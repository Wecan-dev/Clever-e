<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'YITH_Featured_Video_Manager_Premium' ) ) {

	class YITH_Featured_Video_Manager_Premium extends YITH_Featured_Video_Manager {

		protected static $instance;
		protected static $found_hidden_content = false;

		public function __construct() {

			add_filter( 'woocommerce_available_variation', array( $this, 'add_variation_data' ), 10, 3 );
			add_action( 'woocommerce_product_thumbnails', array( $this, 'add_variation_content' ), 99 );

			add_action( 'wp_ajax_print_modal', array( $this, 'print_modal' ) );
			add_action( 'wp_ajax_nopriv_print_modal', array( $this, 'print_modal' ) );

			if ( 'no' == get_option( 'ywcfav_show_gallery_in_sidebar', 'no' ) ) {

				$how_show = get_option( 'ywcfav_gallery_mode', 'plugin_gallery' );

				if( 'plugin_gallery' === $how_show ) {
					add_action( 'woocommerce_after_single_product_summary', array(
						$this,
						'woocommerce_show_product_video_thumbnails'
					), 5 );
					add_action( 'woocommerce_after_single_product_summary', array(
						$this,
						'woocommerce_show_product_audio_thumbnails'
					), 6 );
				}else{
					add_action( 'woocommerce_product_thumbnails', array( $this, 'add_video_audio_content_in_woocommerce_gallery' ), 99 );
				}
			} else {
				add_action( 'widgets_init', 'ywcfav_register_widget' );
			}

		}

		/** return single instance of class
		 * @author YITH
		 * @since 2.0.0
		 * @return YITH_Featured_Video_Manager
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}


		/**
		 * @param WC_Product $product
		 *
		 * @return array
		 */
		public function get_featured_args( $product, $featured_info = array() ) {

			if ( empty( $featured_info ) ) {
				$featured_info = $product->get_meta( '_ywcfav_featured_content', true );
			}
			$args = array();

			if ( ! empty( $featured_info ) ) {


				if ( 'video' == $featured_info['type'] ) {
					$video = $this->find_featured_video( $product, $featured_info['id'] );
					$url = false;
					if ( 'url' == $video['type'] ) {
						list( $host, $video_id ) = explode( ':', ywcfav_video_type_by_url( $video['content'] ) );
						$url = $video['content'];
					} else if ( 'embd' == $video['type'] ) {
						$video_id = $video['content'];
					} else {
						$video_id = $video['content'];
					}

					$video_args = array(
						'id'           => $featured_info['id'],
						'video_id'     => $video_id,
						'host'         => $video['host'],
						'url' => $url,
						'thumbnail_id' => $video['thumbn']
					);
					$args       = $this->get_featured_video_args( $product, $video );

					$args = array_merge( $video_args, $args );

				} else {

					$audio = $this->find_featured_audio( $product, $featured_info['id'] );

					$audio_args = array(
						'id'           => $featured_info['id'],
						'audio_url'    => $audio['url'],
						'thumbnail_id' => $audio['thumbn'],
						'host'         => 'audio'
					);

					$args = $this->get_general_audio_args();

					$args = array_merge( $audio_args, $args );

				}

				if ( $product->is_type( 'variable' ) ) {
					$default_attributes                = $product->get_default_attributes();
					$args['featured_content_selected'] = empty( $default_attributes );

				} else {
					$args['featured_content_selected'] = true;
				}

				$args['product_id'] = $product->get_id();
			}

			return $args;
		}

		/**
		 * @param WC_Product $product
		 * @param array $video
		 *
		 * @return array
		 */
		public function get_featured_video_args( $product, $video = array() ) {


			$video_args = array();

			if ( ! empty( $video['host'] ) ) {

				if ( 'youtube' == $video['host'] ) {
					$video_args = $this->get_youtube_args();
				} elseif ( 'vimeo' == $video['host'] ) {
					$video_args = $this->get_vimeo_args();
				}
			}

			$video_args = array_merge( $video_args, $this->get_general_video_args() );

			return $video_args;
		}


		/**
		 * @param WC_Product $product
		 * @param $video_id
		 *
		 * @return array
		 */
		public function find_featured_video( $product, $video_id ) {

			$featured_video = array();

			if ( $product->is_type( 'variation' ) ) {
				$video = $product->get_meta( '_ywcfav_variation_video', true );

				if ( ! empty( $video ) && $video_id == $video['id'] ) {
					$featured_video = $video;
				}

				return $featured_video;
			} else {
				$videos = $product->get_meta( '_ywcfav_video', true );

				if ( $videos ) {
					foreach ( $videos as $video ) {

						if ( $video['id'] == $video_id ) {
							$featured_video = $video;

							return $featured_video;
						}
					}
				}
			}

			return $featured_video;
		}

		/**
		 * @param WC_Product $product
		 * @param $audio_id
		 *
		 * @return array
		 */
		public function find_featured_audio( $product, $audio_id ) {

			$featured_audio = array();

			$audios = $product->get_meta( '_ywcfav_audio', true );

			if ( $audios ) {

				foreach ( $audios as $audio ) {
					if ( $audio_id == $audio['id'] ) {
						$featured_audio = $audio;

						return $featured_audio;
					}
				}
			}

			return $featured_audio;
		}

		/**
		 * get the video thumbnail attachment id
		 * @author Salvatore Strano
		 * @since 2.0.0
		 *
		 * @param WC_Product $product
		 * @param string $video_id ,
		 * @param string $host
		 *
		 * @return int
		 */
		public function get_featured_image_id( $product, $video_id, $host ) {

			$thumbnail_id = $product->get_meta( '_video_image_url' );

			return $thumbnail_id;
		}

		/**
		 * get the general video args
		 * @return array
		 */
		public function get_general_video_args() {

			$aspect_ratio = get_option( 'ywcfav_aspectratio', '4_3' );

			if( 'custom' == $aspect_ratio ){
				$aspect_ratio = str_replace(':','_',get_option('ywcfav_aspectratio_custom','') );
			}
			$extra_args = array(
				'aspect_ratio'  => $aspect_ratio,
				'show_controls' => get_option( 'ywcfav_show_controls', 'yes' ),
				'autoplay'      => get_option( 'ywcfav_autoplay', 'no' ),
				'loop'          => get_option( 'ywcfav_loop', 'no' ),
				'volume'        => get_option( 'ywcfav_volume', 0.5 ),
				'is_stoppable'  => get_option( 'ywcfav_video_stoppable', 'yes' ),
				'browser'       => ''

			);

			$browser = $this->detect_browser();

			if ( $browser ) {
				$extra_args['browser'] = $browser;
			}
			$function_name = 'get_' . $browser . '_args';

			if ( is_callable( array( $this, $function_name ) ) ) {
				$extra_args = $this->$function_name( $extra_args );
			}

			return $extra_args;
		}

		/**
		 * get the general audio args
		 * @return array
		 */
		public function get_general_audio_args() {

			$args = array(
				'autoplay'     => get_option( 'ywcfav_soundcloud_auto_play', 'no' ),
				'show_artwork' => get_option( 'ywcfav_soundcloud_show_artwork', 'no' ),
				'volume'       => get_option( 'ywcfav_soundcloud_volume', 0.5 ),
				'show_comment' => get_option( 'ywcfav_soundcloud_show_comment', 'no' ),
				'show_sharing' => get_option( 'ywcfav_soundcloud_show_sharing', 'no' ),
				'color'        => get_option( 'ywcfav_soundcloud_color', '#ff7700' ),

			);

			return $args;
		}

		/**
		 * detect the current browser
		 * @return bool|string
		 */
		public function detect_browser() {

			global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone, $is_edge;

			$browser = false;

			if ( $is_lynx ) {
				$browser = 'lynx';
			} elseif ( $is_gecko ) {
				$browser = 'gecko';
			} elseif ( $is_opera ) {
				$browser = 'opera';
			} elseif ( $is_NS4 ) {
				$browser = 'ns4';
			} elseif ( $is_safari ) {
				$browser = 'safari';
			} elseif ( $is_chrome ) {
				$browser = 'chrome';
			} elseif ( $is_IE ) {

				$browser = 'ie';
			} elseif ( $is_edge ) {
				$browser = 'edge';
			} elseif ( $is_iphone ) {
				$browser = 'iphone';
			}

			return $browser;

		}

		/**
		 * set the right video args for chrome browser
		 *
		 * @param array $args
		 *
		 * @return array
		 */
		public function get_chrome_args( $args ) {

			if ( 'yes' == $args['autoplay'] ) {

				if ( 0 < $args['volume'] && wp_is_mobile() ) {
					$args['force_muted'] = true;
				}
			}

			return $args;
		}

		/**
		 * return the youtube video options
		 * @return array
		 */
		public function get_youtube_args() {
			$args = array(

				'show_rel' => get_option( 'ywcfav_youtube_rel', 'yes' ),
				'theme'    => get_option( 'ywcfav_youtube_theme', 'dark' ),
				'color'    => get_option( 'ywcfav_youtube_color', 'red' )
			);

			return $args;
		}

		/**
		 * return the vimeo video options
		 * @return array
		 */
		public function get_vimeo_args() {
			$args = array(
				'show_info' => get_option( 'ywcfav_vimeo_show_title', 'yes' ),
				'color'     => get_option( 'ywcfav_vimeo_color', '#00adef' )
			);

			return $args;
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
				unset( $variation_data['image'] );

			}

			return $variation_data;
		}

		public function add_variation_content() {

			/**
			 * @var WC_Product_Variable $product
			 */
			global $product;

			if ( 'variable' == $product->get_type() ) {
				$variations = $product->get_children();
				$html       = '';

				foreach ( $variations as $variation_id ) {
					$variation = wc_get_product( $variation_id );

					$video = $variation->get_meta( '_ywcfav_variation_video', true );

					if ( ! empty( $video ) ) {
						if ( 'url' == $video['type'] ) {
							list( $host, $video_id ) = explode( ':', ywcfav_video_type_by_url( $video['content'] ) );

						} else {
							$video_id = $video['content'];
						}

						$video_args = array(
							'id'                        => $video['id'],
							'video_id'                  => $video_id,
							'host'                      => $video['host'],
							'thumbnail_id'              => $video['thumbn'],
							'featured_content_selected' => false,
							'product_id'                => $variation_id
						);
						$args       = $this->get_featured_video_args( $variation, $video );

						$args = array_merge( $video_args, $args );

						$found = $this->check_if_default_variation( $product, $variation );

						if ( $found ) {
							$args['featured_content_selected'] = true;
						}


						$html .= $this->get_featured_template( $args );

					}
				}
				echo $html;
			}
		}

		/**
		 * @param array $args
		 *
		 * @return string
		 */
		public function get_featured_template( $args ) {

			if ( isset( $args['host'] ) && 'audio' !== $args['host'] ) {
				$is_modal = get_option( 'ywcfav_video_in_modal', 'no' );
				if ( 'yes' !== $is_modal ) {
					$template_name = 'template_video.php';
				} else {
					$template_name = 'template_modal.php';
					$args['args']  = $args;
				}
			} else {
				$is_modal = get_option( 'ywcfav_soundcloud_in_modal', 'no' );
				if ( 'yes' !== $is_modal ) {
					$template_name = 'template_audio.php';
				} else {
					$template_name = 'template_modal.php';
					$args['args']  = $args;
				}
			}
			ob_start();
			wc_get_template( $template_name, $args, YWCFAV_TEMPLATE_PATH, YWCFAV_TEMPLATE_PATH );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;

		}

		/**
		 * @param WC_Product_Variable $variable
		 * @param WC_Product_Variation $variation
		 */
		public function check_if_default_variation( $variable, $variation ) {

			$default_attributes = $variable->get_default_attributes();
			$data_store         = WC_Data_Store::load( 'product' );

			$default_attributes_tmp = array();

			foreach ( $default_attributes as $key => $attribute ) {
				$default_attributes_tmp[ 'attribute_' . $key ] = $attribute;
			}
			$variation_id = $data_store->find_matching_product_variation( $variable, $default_attributes_tmp );

			$current_id = $variation->get_id();

			return $current_id == $variation_id;
		}

		public function print_modal() {

			if ( isset( $_GET['content_id'] ) ) {

				$content_id = $_GET['content_id'];
				$product_id = $_GET['product_id'];

				$product = wc_get_product( $product_id );

				$content = array();
				$args    = array();
				if ( !$product->is_type( 'variation' ) ) {

					$content = $this->find_featured_audio( $product, $content_id );
					if ( ! empty( $content ) ) {
						$audio_args = array(
							'id'           => $content['id'],
							'audio_url'    => $content['url'],
							'thumbnail_id' => $content['thumbn'],
							'host'         => 'audio'
						);

						$args = $this->get_general_audio_args();

						$args     = array_merge( $audio_args, $args );
						$template = 'modal_audio_player.php';
					}
				}

				if ( empty( $content ) ) {
					$content = $this->find_featured_video( $product, $content_id );
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
						'featured_content_selected' => false,


					);


					$args       = $this->get_featured_video_args( $product, $content );
					$args       = array_merge( $video_args, $args );

					$template   = 'modal_video_player.php';
				}

				wc_get_template( $template, $args, YWCFAV_TEMPLATE_PATH . '/modal_view/', YWCFAV_TEMPLATE_PATH . '/modal_view/' );
				die();
			}

		}


		public function woocommerce_show_product_video_thumbnails() {

			global $post, $product;

			if( !$product instanceof  WC_Product ) {
				$product = wc_get_product( $post->ID );
			}

			$all_video['all_video'] = $this->get_other_video( $product );

			wc_get_template( 'woocommerce/single-product/product-video-thumbnails.php', $all_video, '', YWCFAV_TEMPLATE_PATH );

		}

		public function woocommerce_show_product_audio_thumbnails() {

			global $post, $product;

			$all_audio['all_audio'] = $this->get_other_audio( $product );

			wc_get_template( 'woocommerce/single-product/product-audio-thumbnails.php', $all_audio, YWCFAV_TEMPLATE_PATH, YWCFAV_TEMPLATE_PATH );

		}

		/**
		 * @param WC_Product $product
		 *
		 * @return array
		 */
		public function get_other_video( $product ) {

			$featured_content =  $product->get_meta( '_ywcfav_featured_content' );
			$all_video        = $product->get_meta(  '_ywcfav_video' );
			$all_video        = empty( $all_video ) ? array() : $all_video;

			if ( ! empty( $featured_content ) ) {

				$type = $featured_content['type'];
				$id   = $featured_content['id'];

				if ( $type === 'video' ) {
					$all_video = ywcfav_removeElementWithValue( $all_video, 'id', $id );
				}
			}

			return $all_video;
		}

		/**
		 * @param WC_Product $product
		 *
		 * @return array
		 */
		public function get_other_audio( $product ) {

			$featured_content =  $product->get_meta( '_ywcfav_featured_content' );
			$all_audio        = $product->get_meta(  '_ywcfav_audio' );
			$all_audio        = empty( $all_audio ) ? array() : $all_audio;

			if ( ! empty( $featured_content ) ) {

				$type = $featured_content['type'];
				$id   = $featured_content['id'];

				if ( $type === 'audio' ) {
					$all_audio = ywcfav_removeElementWithValue( $all_audio, 'id', $id );
				}
			}

			return $all_audio;
		}
		/**
		 * show the video after all images
		 */
		public function add_video_audio_content_in_woocommerce_gallery( ){

			global $product;

			if( !is_null( $product ) ){
					$html = '';
					$video = $this->get_other_video( $product );
					$audio = $this->get_other_audio( $product );

					foreach ( $video as $single_video ) {

						$args = $this->get_featured_args( $product, array( 'id'   => $single_video['id'],
						                                                   'type' => 'video'
						) );
						$args['autoplay'] = 'no';
						$html .= $this->get_featured_template( $args );
					}

					foreach ( $audio as $single_audio ) {

						$args = $this->get_featured_args( $product, array( 'id'   => $single_audio['id'],
						                                                   'type' => 'audio'
						) );

						$html .= $this->get_featured_template( $args );
					}
				}

			echo $html;
		}

	}
}
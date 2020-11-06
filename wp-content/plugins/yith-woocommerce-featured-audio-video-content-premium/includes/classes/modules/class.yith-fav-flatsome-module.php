<?php
if( !defined('ABSPATH')){
	exit;
}
if( !class_exists('YITH_FAV_Flatsome_Module')){

	class YITH_FAV_Flatsome_Module{

		protected $manager ;
		public function __construct() {

			add_action( 'wp_enqueue_scripts', array($this, 'enqueue_module_scripts' ),30 );
			add_filter( 'ywcfav_get_thumbnail_gallery_item', array( $this, 'get_flatsome_gallery_item' ) , 20 );
			add_filter( 'ywcfav_get_product_gallery_trigger', array( $this, 'get_flatsome_gallery_trigger' ) , 20 );
			add_filter( 'ywcfav_get_current_slider_class', array( $this, 'get_flatsome_current_slider_class' ) , 20 );
			add_filter( 'ywcfav_trigger_variation_event', '__return_false', 20 );

			$how_show = get_option( 'ywcfav_gallery_mode', 'plugin_gallery' );

			if( 'plugin_gallery' === $how_show ) {
				$this->manager = YITH_Featured_Video_Manager();
				//remove all action for additional video/audio in the slider
				remove_action( 'woocommerce_after_single_product_summary', array(
					$this->manager,
					'woocommerce_show_product_video_thumbnails'
				), 5 );
				remove_action( 'woocommerce_after_single_product_summary', array(
					$this->manager,
					'woocommerce_show_product_audio_thumbnails'
				), 6 );

				add_action( 'flatsome_after_product_images', array(
					$this->manager,
					'woocommerce_show_product_video_thumbnails'
				), 5 );

				add_action( 'woocommerce_after_single_product_summary', array(
					$this->manager,
					'woocommerce_show_product_audio_thumbnails'
				), 6 );
			}
		}


		public function enqueue_module_scripts(){

			wp_register_script('ywcfav_frontend_flatsome', YWCFAV_ASSETS_URL.'js/modules/'.yit_load_js_file('flatsome-module.js'), array('jquery','ywcfav_frontend'), YWCFAV_VERSION  );

			$args = array(
				'gallery_image_class' => 'product-gallery-slider',
				'is_vertical_mode' => false,
				'gallery_container' => 'product-gallery'
			);

			if(get_theme_mod('product_image_style') == 'vertical'){
				$args['gallery_image_class'] = 'product-gallery-slider';
				$args['is_vertical_mode'] = true;
			}

			wp_localize_script( 'ywcfav_frontend_flatsome','ywcfav_flatsome_args', $args );
			if( is_product() ){
				wp_enqueue_script('ywcfav_frontend_flatsome');
			}
		}

		/**
		 * @return string
		 */
		public function get_flatsome_gallery_item(){

			$flatsome_gallery_class = 'product-thumbnails .col';

			return $flatsome_gallery_class;
		}

		public function get_flatsome_gallery_trigger(){

			return 'image-tools .zoom-button';
		}

		public function get_flatsome_current_slider_class(){

			return 'is-selected';
		}


	}
}

return new YITH_FAV_Flatsome_Module();
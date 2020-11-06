<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'YITH_Featured_Audio_Video_Frontend_Premium' ) ) {

	class YITH_Featured_Audio_Video_Frontend_Premium extends YITH_Featured_Audio_Video_Frontend {

		protected static $instance;
		protected $counter;

		public function __construct() {

			parent::__construct();

		}


		/** return single instance of class
		 * @author YITH
		 * @since 2.0.0
		 * @return YITH_Featured_Audio_Video_Frontend_Premium
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * @author Salvatore Strano
		 * @since 2.0.0
		 *
		 * @param string $html
		 * @param int $post_thumbnail_id
		 *
		 * @return string
		 */
		public function get_video_audio_content( $html, $post_thumbnail_id ) {

			global $product;

			if ( 0 == $this->counter && $post_thumbnail_id == $product->get_image_id() ) {


				$video_args = YITH_Featured_Video_Manager()->get_featured_args( $product );

				if ( ! empty( $video_args )  ) {

					$html = YITH_Featured_Video_Manager()->get_featured_template( $video_args );
					$this->counter ++;

				}
			}

			return $html;
		}

	}
}
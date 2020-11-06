<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'YITH_Featured_Video_Manager' ) ) {

	class YITH_Featured_Video_Manager {

		protected static $instance;


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
		 * @param array $video
		 * @return array
		 */
		public function get_featured_video_args( $product, $video = array() ) {

			$video_url  = $product->get_meta( '_video_url' );
			$video_args = array();

			if ( ! empty( $video_url ) ) {


				list( $host, $video_id ) = explode( ':', ywcfav_video_type_by_url( $video_url ) );


				$video_args = array(
					'video_id'           => $video_id,
					'host'          => $host,
					'thumbnail_id' => $this->get_featured_image_id( $product, $video_id, $host )
				);
			}

			return $video_args;
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
	}
}
if ( ! function_exists( 'YITH_Featured_Video_Manager' ) ) {
	/**
	 * @return YITH_Featured_Video_Manager|YITH_Featured_Video_Manager_Premium
	 */
	function YITH_Featured_Video_Manager() {

		if ( class_exists( 'YITH_Featured_Video_Manager_Premium' ) ) {
			return YITH_Featured_Video_Manager_Premium::get_instance();
		} else {
			return YITH_Featured_Video_Manager::get_instance();
		}
	}
}

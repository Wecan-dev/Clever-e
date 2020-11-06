<?php
if( !defined( 'ABSPATH') ){
	exit;
}

if( !class_exists( 'YITH_Featured_Audio_Video_Slider_Widget' ) ){

	class YITH_Featured_Audio_Video_Slider_Widget extends WP_Widget{


		public function __construct()
		{
			parent::__construct(
				'yith_wc_featured_audio_video',
				__('YITH WooCommerce Featured Audio Video - Slider Video', 'yith-woocommerce-featured-video'),
				array(   'description'   =>  __('Show your video or audio content in sidebar!', 'yith-woocommerce-featured-video' ) )
			);
		}

		/**
		 * show the widget form
		 * @author Salvatore Strano <salvostrano@msn.com>
		 * @param array $instance
		 */
		public function form( $instance ) {

			$default = array(
				'title' => isset( $instance['title'] ) ? $instance['title']  : '',
				'ywcfav_how_show' => isset( $instance['ywcfav_how_show'] ) ? $instance['ywcfav_how_show'] : 'video'
			);

			$instance = wp_parse_args( $instance, $default ) ;
			?>

			<div class="ywcfav_widget_content">
				<p>
					<label for="<?php echo $this->get_field_id('title');?>"><?php _e( 'Title', 'yith-woocommerce-featured-video' );?></label>
					<input type="text" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" value="<?php esc_attr_e( $instance['title'] );?>"/>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('ywcfav_how_show');?>"><?php _e( 'Choose a content to show','yith-woocommerce-featured-video' );?></label>
					<select id="<?php echo $this->get_field_id('ywcfav_how_show');?>" name="<?php echo $this->get_field_name('ywcfav_how_show');?>">
						<option value="video" <?php selected( 'video', $instance['ywcfav_how_show'] );?>> <?php _e( 'Video', 'yith-woocommerce-featured-video' );?></option>
						<option value="audio" <?php selected( 'audio', $instance['ywcfav_how_show'] );?>> <?php _e( 'Audio', 'yith-woocommerce-featured-video' );?></option>
					</select>
				</p>
			</div>

<?php
		}

		/**
		 * update the widget option
		 * @author Salvatore Strano <salvostrano@msn.com>
		 *
		 * @param array $new_instance
		 * @param array $old_instance
		 * @return array
		 */
		public function update( $new_instance, $old_instance ) {

			$instance = array();

			$instance['title'] = isset( $new_instance['title'] ) ?  $new_instance['title'] : '';
			$instance['ywcfav_how_show'] = isset( $new_instance['ywcfav_how_show'] ) ? : 'video';

			return $instance;
		}

		/**
		 * show the widget in frontend
		 * @author Salvatore Strano <salvostrano@msn.com>
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {


			if( is_product() ){

				$widget_title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Videos' ) : $instance['title'], $instance, $this->id_base );
				$how_show = $instance['ywcfav_how_show'];

				/**
				 * @var YITH_WC_Audio_Video_Premium $YITH_Featured_Audio_Video
				 */

				$template = '';
			if( function_exists('YITH_Featured_Video_Manager') ) {
				if ( 'video' == $how_show ) {

					ob_start();
					YITH_Featured_Video_Manager()->woocommerce_show_product_video_thumbnails();
					$template = ob_get_contents();
					ob_end_clean();
				} else {

					ob_start();
					YITH_Featured_Video_Manager()->woocommerce_show_product_audio_thumbnails();
					$template = ob_get_contents();
					ob_end_clean();
				}

				echo $args['before_widget'];
				echo $args['before_title'];
				echo $widget_title;
				echo $args['after_title'];
				echo $template;
				echo $args['after_widget'];
			    }
			}

		}
	}
}

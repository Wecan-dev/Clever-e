<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'ywcfav_video_type_by_url' ) ) {
	/**
	 * Retrieve the type of video, by url
	 *
	 * @param string $url The video's url
	 *
	 * @return mixed A string format like this: "type:ID". Return FALSE, if the url isn't a valid video url.
	 *
	 * @since 1.1.0
	 */
	function ywcfav_video_type_by_url( $url ) {

		$parsed = parse_url( esc_url( $url ) );

		switch ( $parsed['host'] ) {

			case 'www.youtube.com' :
			case    'youtu.be':
				$id = ywcfav_get_yt_video_id( $url );

				return "youtube:$id";

			case 'vimeo.com' :
			case 'player.vimeo.com' :
				preg_match( '/.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/', $url, $matches );
				$id = $matches[5];

				return "vimeo:$id";

			default :
				return apply_filters( 'yith_woocommerce_featured_video_type', false, $url );

		}
	}
}
if ( ! function_exists( 'ywcfav_get_yt_video_id' ) ) {
	/**
	 * Retrieve the id video from youtube url
	 *
	 * @param string $url The video's url
	 *
	 * @return string The youtube id video
	 *
	 * @since 1.1.0
	 */
	function ywcfav_get_yt_video_id( $url ) {

		$pattern =
			'%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x';
		$result  = preg_match( $pattern, $url, $matches );
		if ( false !== $result ) {
			return isset( $matches[1] ) ? $matches[1] : false;
		}

		return false;
	}
}

if ( ! function_exists( 'ywcfav_save_remote_image' ) ) {

	function ywcfav_save_remote_image( $url, $newfile_name = '' ) {

		$url = str_replace( 'https', 'http', $url );
		$tmp = download_url( (string) $url );

		$file_array = array();
		preg_match( '/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', (string) $url, $matches );
		$file_name = basename( $matches[0] );
		if ( '' !== $newfile_name ) {
			$file_name_info = explode( '.', $file_name );
			$file_name      = $newfile_name . '.' . $file_name_info[1];
		}


		if ( ! function_exists( 'remove_accents' ) ) {
			require_once( ABSPATH . 'wp-includes/formatting.php' );
		}
		$file_name = sanitize_file_name( remove_accents( $file_name ) );
		$file_name = str_replace( '-', '_', $file_name );

		$file_array['name']     = $file_name;
		$file_array['tmp_name'] = $tmp;

		// If error storing temporarily, unlink
		if ( is_wp_error( $tmp ) ) {
			@unlink( $file_array['tmp_name'] );
			$file_array['tmp_name'] = '';

		}

		// do the validation and storage stuff
		return media_handle_sideload( $file_array, 0 );
	}

}

if ( ! function_exists( 'ywcfav_get_gallery_item_class' ) ) {
	/**
	 * @author Salvatore Strano
	 * @since 2.0.0
	 * return the woocommerce product gallery image
	 * @return string
	 */
	function ywcfav_get_gallery_item_class() {

		return apply_filters( 'ywcfav_get_gallery_item_class', "woocommerce-product-gallery__image" );
	}
}

if ( ! function_exists( 'ywcfav_get_thumbnail_gallery_item' ) ) {
	/**
	 * @author Salvatore Strano
	 * @since 2.0.0
	 * get the class of thumbnail gallery
	 * @return string
	 */
	function ywcfav_get_thumbnail_gallery_item() {

		return apply_filters( 'ywcfav_get_thumbnail_gallery_item', 'flex-control-nav.flex-control-thumbs li' );
	}
}

if ( ! function_exists( 'ywcfav_get_product_gallery_trigger' ) ) {
	/**
	 * @author Salvatore Strano
	 * @since 2.0.0
	 * get the product gallery trigger class
	 * @return string
	 */
	function ywcfav_get_product_gallery_trigger() {

		return apply_filters( 'ywcfav_get_product_gallery_trigger', 'woocommerce-product-gallery__trigger' );
	}
}


if( !function_exists('ywcfav_get_current_slider_class')){

    function ywcfav_get_current_slider_class(){

        return apply_filters( 'ywcfav_get_current_slider_class', 'flex-active-slide' );
    }
}



if ( ! function_exists( 'ywcfav_check_is_zoom_magnifier_is_active' ) ) {

	/**
	 * @return bool
	 */
	function ywcfav_check_is_zoom_magnifier_is_active() {

		if ( defined( 'YITH_YWZM_FREE_INIT' ) || defined( 'YITH_YWZM_PREMIUM' ) ) {
			if ( wp_is_mobile() ) {
				return ( 'yes' == get_option( 'yith_wcmg_enable_mobile' ) );
			}

			return get_option( 'yith_wcmg_enable_plugin' ) == 'yes';
		}

		return false;
	}
}

if ( ! function_exists( 'ywcfav_check_is_product_is_exclude_from_zoom' ) ) {

	function ywcfav_check_is_product_is_exclude_from_zoom() {
		/**
		 * @var YITH_WooCommerce_Zoom_Magnifier_Premium $yith_wcmg ;
		 */
		global $yith_wcmg;

		return is_callable( array( $yith_wcmg, 'is_product_excluded' ) ) && $yith_wcmg->is_product_excluded();
	}
}

if ( ! function_exists( 'ywcfav_get_custom_player_style' ) ) {
	function ywcfav_get_custom_player_style() {

		$custom_player = get_option( 'ywcfav_player_type_style' );

		if ( $custom_player == 'custom' ) {

			$main_font_color        = get_option( 'ywcfav_main_font_colors' );
			$control_bg_color       = get_option( 'ywcfav_control_bga_color', '' );

			if( empty( $control_bg_color ) ){

			    $control_bg_color = sprintf('rgba( %s, %s )', implode(',', yith_Hex2RGB( get_option('ywcfav_control_bg_color','#07141E') ) ), get_option('ywcfav_control_bg_color_alpha',0.7) );
            }

			$slider_color_settings = get_option('ywcfav_slider_color_settings', '' );

			if( empty( $slider_color_settings ) ){
				$slider_bg_color = sprintf('rgba( %s, %s )', implode(',', yith_Hex2RGB( get_option( 'ywcfav_slider_bg_color', '#333333' ) ) ), get_option('ywcfav_slider_bg_color_alpha',0.9) );
				$slider_color = get_option( 'ywcfav_slider_color', '#66A8CC' );
            }else{
			    $slider_bg_color = $slider_color_settings['slider_back_ground_color'];
			    $slider_color = $slider_color_settings['slider_color'];
            }

			$big_play_border_color  = get_option( 'ywcfav_big_play_border_color' );
			?>
            <style type="text/css">

                .vjs-default-skin {
                    color: <?php echo $main_font_color;?>;
                }

                .vjs-default-skin .vjs-control-bar, .vjs-default-skin .vjs-menu-button .vjs-menu .vjs-menu-content {

                    background-color: <?php echo $control_bg_color;?>
                }

                .vjs-default-skin .vjs-volume-level, .vjs-default-skin .vjs-play-progress {

                    background-color: <?php echo $slider_color;?>;
                }

                .vjs-default-skin .vjs-slider {

                    background-color: <?php echo $slider_bg_color;?>
                }

                .vjs-default-skin .vjs-big-play-button {

                    background-color: <?php echo $control_bg_color;?>
                    border-color: <?php echo $big_play_border_color;?>;
                }

                .ywcfav_video_container .ywcfav_placeholder_container span:before, .ywcfav_video_modal_container .ywcfav_placeholder_modal_container span:before, .ywcfav_video_embd_container .ywcfav_video_embd_placeholder span:before,
                .ywcfav_audio_modal_container .ywcfav_audio_placeholder_modal_container span:before, .ywcfav_audio_container .ywcfav_audio_placeholder_container span:before {
                    color: <?php echo $control_bg_color;?>
                }

                .ywcfav_play {
                    background-color: <?php echo $control_bg_color;?>
                    border-color: <?php echo $big_play_border_color;?>;

                }

                .ywcfav_play:before {
                    color: <?php echo $main_font_color;?> !important;
                }

                .ywcfav_video_container .ywcfav_placeholder_container:hover .ywcfav_play, .ywcfav_video_modal_container .ywcfav_placeholder_modal_container:hover .ywcfav_play, .ywcfav_video_embd_container .ywcfav_video_embd_placeholder:hover .ywcfav_play, .ywcfav_audio_modal_container .ywcfav_audio_placeholder_modal_container:hover .ywcfav_play, .ywcfav_audio_container .ywcfav_audio_placeholder_container:hover .ywcfav_play,
                .vjs-default-skin:hover .vjs-big-play-button {
                    border-color: <?php echo $big_play_border_color;?>;
                    background-color: <?php echo $control_bg_color;?>
                }

            </style>
			<?php
		}
	}
}

add_action( 'wpml_post_edit_languages', 'ywcfav_render_copy_featured_content', 20, 1 );

/**
 * @param WP_Post $post
 */
function ywcfav_render_copy_featured_content( $post ) {


	if ( $post && $post->post_type == 'product' ) {

		$product_id = $post->ID;
		$object_id  = yit_wpml_object_id( $product_id, 'product', true, wpml_get_default_language() );


		if ( $product_id != $object_id ) {

			global $sitepress, $YITH_Featured_Audio_Video, $pagenow;

			$product          = wc_get_product( $product_id );
			$is_copied        = yit_get_prop( $product, 'ywcfav_wpml_copied' );
			$_lang_details    = $sitepress->get_language_details( wpml_get_default_language() );
			$source_lang_name = $_lang_details['display_name'];
			$disable_button   = ( $is_copied || ywcfav_product_has_featured_content($product) || 'post-new.php' == $pagenow ) ? 'disabled' : '';
			$button_text      = sprintf( __( 'Copy Featured content from %s', 'yith-woocommerce-featured-video' ), $source_lang_name );
			$div              = sprintf( '<div id="%s"><input type="%s" data-product_id="%s" data-original_product_id="%s" id="%s" class="%s" value="%s" %s />',
				'ywcfav_copy_section',
				'button', $product_id, $object_id, 'ywcfav_copy_content', 'button button-secondary', $button_text, $disable_button
			);
			$div              .= sprintf( '<img src="%s" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden" /></div>',
				YWCFAV_ASSETS_URL . '/images/icon-loading.gif'
			);


			echo $div;
		}
	}
}

add_action( 'wp_ajax_ywcfav_copy_content_from_original', 'ywcfav_copy_content_from_original' );

function ywcfav_copy_content_from_original() {


	if ( ! empty( $_REQUEST['product_id'] ) && ! empty( $_REQUEST['original_id'] ) ) {

		$product_id = $_REQUEST['product_id'];
		$object_id  = $_REQUEST['original_id'];

		$product = wc_get_product( $product_id );
		$object  = wc_get_product( $object_id );

		$content_video = yit_get_prop( $object, '_ywcfav_video', true );
		$content_audio = yit_get_prop( $object, '_ywcfav_audio', true );

		$selected_content = yit_get_prop( $object, '_ywcfav_featured_content', true );
		yit_save_prop( $product, '_ywcfav_video', $content_video );
		yit_save_prop( $product, '_ywcfav_audio', $content_audio );
		yit_save_prop( $product, '_ywcfav_featured_content', $selected_content );

		if ( $product->is_type( 'variable' ) ) {

			$children = $product->get_children();

			foreach ( $children as $child_id ) {


				$product_variation   = wc_get_product( $child_id );
				$object_variation_id = yit_wpml_object_id( $child_id, 'product', true, wpml_get_default_language() );

				if ( $child_id != $object_variation_id ) {

					$object_variation = wc_get_product( $object_variation_id );

					$variation_content = yit_get_prop( $object_variation, '_ywcfav_variation_video', true );

					yit_save_prop( $product_variation, '_ywcfav_variation_video', $variation_content );
				}

			}
		}

		yit_save_prop( $product, 'ywcfav_wpml_copied', true );

		wp_send_json( array( 'result' => true ) );

	}

}

if( !function_exists( 'yith_Hex2RGB' ) ){

	function yith_Hex2RGB( $color ){
		$color = str_replace( '#', '', $color );
		if ( strlen( $color ) != 6){ return array( 0,0,0 ); }
		$rgb = array();
		for ( $x=0;$x<3;$x++ ){
			$rgb[$x] = hexdec( substr( $color,( 2*$x ),2 ) );
		}
		return $rgb;
	}

}
if( !function_exists( 'ywcfav_removeElementWithValue' ) ){

	function ywcfav_removeElementWithValue( $array, $key, $value ){
		foreach( $array as $subKey => $subArray ){
			if($subArray[$key] == $value){
				unset( $array[$subKey] );
			}
		}
		return $array;
	}
}

if( !function_exists( 'ywcfav_register_widget' )) {
    function ywcfav_register_widget(){
	    register_widget( 'YITH_Featured_Audio_Video_Slider_Widget' );
    }
}

if( !function_exists('ywcfav_product_has_featured_content')){
	/**
	 * @param WC_Product $product
     * @return bool
	 */
    function ywcfav_product_has_featured_content( $product ){
	    $all_video        = $product->get_meta( '_ywcfav_video' );
	    $all_audio        = $product->get_meta( '_ywcfav_audio' );

	    return ! empty( $all_audio )  || ! empty( $all_video );
    }
}
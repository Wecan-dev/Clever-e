<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$video_settings = array(

	'video-settings' => array(

		'video-general_setting_section_start' => array(
			'name' => __( 'General Settings', 'yith-woocommerce-featured-video' ),
			'type' => 'title',
			'id'   => 'ywcfav_video-general_setting_section_start'
		),

		'aspectratio'   => array(
			'name'      => __( 'Aspect Ratio', 'yith-woocommerce-featured-video' ),
			'type'      => 'yith-field',
			'yith-type' => 'select',
			'class' => 'wc-enhanced-select',
			'options'   => array( '16_9' => '16:9', '4_3' => '4:3', 'custom' => __('Custom Aspect Ratio', 'yith-woocommerce-featured-video') ),
			'desc'      => __( 'Choose the aspect ratio for your video', 'yith-woocommerce-featured-video' ),
			'default'   => '16_9',
			'id'        => 'ywcfav_aspectratio'
		),
		'aspectratio_custom' => array(
			'name' => __('Custom Aspect Ratio', 'yith-woocommerce-featured-video'),
			'type' => 'yith-field',
			'yith-type' => 'text',
			'desc' => __('Set your custom aspect ratio for your video. Example: 3:2,21:9 ','yith-woocommerce-featured-video'),
			'deps' => array(
				'id' => 'ywcfav_aspectratio',
				'value' => 'custom',
				'type' => 'show'
			),
			'default' => '',
			'id' => 'ywcfav_aspectratio_custom',
			'custom_attributes' =>sprintf( 'pattern ="%s" title="%s"',"\d*:\d*", __('Enter two values separated by :','yith-woocommerce-featued-video'))
		),
		'show_controls' => array(
			'name'      => __( 'Player Controls', 'yith-woocommerce-featured-video' ),
			'desc'      => __( 'This option sets whether the player has usable controls by users. ( Only on Youtube and Video uploaded ).', 'yith-woocommerce-featured-video' ),
			'type'      => 'yith-field',
			'yith-type' => 'onoff',
			'default'   => 'yes',
			'id'        => 'ywcfav_show_controls'
		),

		'autoplay' => array(
			'name'      => __( 'AutoPlay', 'yith-woocommerce-featured-video' ),
			'desc'      => __( 'If checked, the video will start playing as soon as page is loaded', 'yith-woocommerce-featured-video' ),
			'type'      => 'yith-field',
			'yith-type' => 'onoff',
			'default'   => 'no',
			'id'        => 'ywcfav_autoplay'
		),

		'loop'   => array(
			'name'      => __( 'Loop', 'yith-woocommerce-featured-video' ),
			'desc'      => __( 'The loop attribute causes the video to start over as soon as it ends', 'yith-woocommerce-featured-video' ),
			'type'      => 'yith-field',
			'yith-type' => 'onoff',
			'default'   => 'no',
			'id'        => 'ywcfav_loop'
		),
		'volume' => array(
			'name'      => __( 'Volume', 'yith-woocommerce-featured-video' ),
			'desc'      => __( 'Set volume, 0 mute , 1 high volume', 'yith-woocommerce-featured-video' ),
			'type'      => 'yith-field',
			'yith-type' => 'slider',
			'option'    => array(
				'min' => 0,
				'max' => 1,
			),
			'step'      => 0.1,
			'default'   => 0.5,
			'id'        => 'ywcfav_volume'
		),

		'video_stoppable' => array(
			'name'      => __( 'Stoppable videos', 'yith-woocommerce-featured-video' ),
			'desc'      => __( 'Allow users to pause videos', 'yith-woocommerce-featured-video' ),
			'type'      => 'yith-field',
			'yith-type' => 'onoff',
			'id'        => 'ywcfav_video_stoppable',
			'default'   => 'yes'
		),

		'video_general_setting_section_end' => array(
			'type' => 'sectionend',
			'id'   => 'ywcfav_video_general_setting_section_end'
		),

		'youtube_settings_section_start' => array(
			'type' => 'title',
			'name' => __( 'Youtube Settings', 'yith-woocommerce-featured-video' ),
			'id'   => 'ywcvaf_youtube_section_start'
		),

		'youtube_show_rel'               => array(
			'name'      => __( 'Show Related', 'yith-woocommerce-featured-video' ),
			'type'      => 'yith-field',
			'yith-type' => 'onoff',
			'default'   => 'yes',
			'desc'      => __( 'If unchecked the related videos will come from the same channel as the video that was just played.', 'yith-woocommerce-featured-video' ),
			'id'        => 'ywcfav_youtube_rel'
		),
		'youtube_theme'                  => array(
			'name'      => __( 'Theme', 'yith-woocommerce-featured-video' ),
			'type'      => 'yith-field',
			'yith-type' => 'radio',
			'options'   => array(
				'dark'  => __( 'Dark', 'yith-woocommerce-featured-video' ),
				'light' => __( 'Light', 'yith-woocommerce-featured-video' )
			),
			'default'   => 'dark',
			'id'        => 'ywcfav_youtube_theme',
			'desc' => __( 'Set the Youtube player style', 'yith-woocommerce-featured-video'), /** for translation team, string added since 1.3.0  */
		),
		'youtube_color'                  => array(
			'name'      => __( 'Color', 'yith-woocommerce-featured-video' ),
			'type'      => 'yith-field',
			'yith-type' => 'radio',
			'options'   => array(
				'red'   => __( 'Red', 'yith-woocommerce-featured-video' ),
				'white' => __( 'White', 'yith-woocommerce-featured-video' )
			),
			'default'   => 'red',
			'desc'      => __( 'Sets the color used in the player progress bar', 'yith-woocommerce-featured-video' ),
			'id'        => 'ywcfav_youtube_color'

		),
		'youtube_settings_section_end'   => array(
			'type' => 'sectionend',
			'id'   => 'ywcvaf_youtube_section_end'
		),

		'vimeo_settings_section_start' => array(
			'type' => 'title',
			'name' => __( 'Vimeo Settings', 'yith-woocommerce-featured-video' ),
			'id'   => 'ywcvaf_vimeo_section_start'
		),
		'vimeo_show_title'             => array(
			'name'      => __( 'Show Video Title', 'yith-woocommerce-featured-video' ),
			'type'      => 'yith-field',
			'yith-type' => 'onoff',
			'default'   => 'yes',
			'id'        => 'ywcfav_vimeo_show_title',
			'desc' => __( 'Choose whether to show the video title in the Vimeo player or not', 'yith-woocommerce-featured-video') /** for translation team, string added since 1.3.0  */
		),
		'vimeo_color'                  => array(
			'name'      => __( 'Color', 'yith-woocommerce-featured-video' ),
			'type'      => 'yith-field',
			'yith-type' => 'colorpicker',
			'default'   => '#00adef',
			'id'        => 'ywcfav_vimeo_color',
			'desc' => __('Set the playback controls color for the Vimeo player', 'yith-woocommerce-featured-video') /** for translation team, string added since 1.3.0  */

		),
		'vimeo_settings_section_end'   => array(
			'type' => 'sectionend',

			'id' => 'ywcvaf_vimeo_section_end'
		),

		'player_style_section_start' => array(
			'name' => __( 'VideoJS Player Style', 'yith-woocommerce-featured-video' ),
			'type' => 'title',
			'id'   => 'ywcfav_player_style_section_start'
		),


		'player_type_style' => array(
			'name'      => __( 'Style', 'yith-woocommerce-featured-video' ),
			'type'      => 'yith-field',
			'yith-type' => 'radio',
			'options'   => array(
				'default' => __( 'Default', 'yith-woocommerce-featured-video' ),
				'custom'  => __( 'Custom', 'yith-woocommerce-featured-video' )
			),
			'default'   => 'default',
			'id'        => 'ywcfav_player_type_style',
			'desc' => __('Set the default style or customize with different colors', 'yith-woocommerce-featured-video') /** for translation team, string added since 1.3.0  */
		),

		'main_font_colors' => array(
			'name'      => __( 'Main Font Colors', 'yith-woocommerce-featured-video' ),
			'desc'      => __( 'The colors of text the icons (icon font)', 'yith-woocommerce-featured-video' ),
			'type'      => 'yith-field',
			'yith-type' => 'colorpicker',
			'id'        => 'ywcfav_main_font_colors',
			'default'   => '#cccccc',
			'deps'      => array(
				'id'    => 'ywcfav_player_type_style',
				'value' => 'custom',
				'type'  => 'show'
			)
		),

		'control_bg_color'      => array(
			'name'      => __( 'Control background color', 'yith-woocommerce-featured-video' ),
			'desc'      => __( 'The default background color of the controls is black, with a little bit of blue so it can still be seen on all black video frames, which are common.', 'yith-woocommerce-featured-video' ),
			'type'      => 'yith-field',
			'yith-type' => 'colorpicker',
			'id'        => 'ywcfav_control_bga_color',
			'default'   => sprintf( 'rgba( %s, %s )', implode( ',', yith_Hex2RGB( get_option( 'ywcfav_control_bg_color', '#07141E' ) ) ), get_option( 'ywcfav_control_bg_color_alpha', 0.7 ) ),
			'deps'      => array(
				'id'    => 'ywcfav_player_type_style',
				'value' => 'custom',
				'type'  => 'show'
			)

		),
		'slider_color_settings' => array(
			'name'         => __( 'Slider Color', 'yith-woocommerce-featured-video' ),
			'type'         => 'yith-field',
			'yith-type'    => 'multi-colorpicker',
			'desc'         => __( 'Set the color for progress and volume bars and for the background', 'yith-woocommerce-featured-video' ),/** for translation team, string added since 1.3.0  */
			'id'           => 'ywcfav_slider_color_settings',
			'colorpickers' => array(
				array(
					'name'    => __( 'Color', 'yith-woocommerce-featured-video' ),
					'id'      => 'slider_color',
					'default' => get_option( 'ywcfav_slider_color', '#66A8CC' )
				),
				array(
					'name'    => __( 'Background Color', 'yith-woocommerce-featured-video' ),
					'id'      => 'slider_back_ground_color',
					'default' => sprintf( 'rgba( %s, %s )', implode( ',', yith_Hex2RGB( get_option( 'ywcfav_slider_bg_color', '#333333' ) ) ), get_option( 'ywcfav_slider_bg_color_alpha', 0.9 ) )
				)

			),
			'deps'         => array(
				'id'    => 'ywcfav_player_type_style',
				'value' => 'custom',
				'type'  => 'show'
			)
		),

		'big_play_border_color' => array(
			'name'      => __( 'Big Play Button Border Color', 'yith-woocommerce-featured-video' ),
			'type'      => 'yith-field',
			'desc'      => __( 'Set the border color of the big Play button', 'yith-woocommerce-featured-video' ),/** for translation team, string added since 1.3.0  */
			'yith-type' => 'colorpicker',
			'default'   => '#3b4249',
			'id'        => 'ywcfav_big_play_border_color',
			'deps'      => array(
				'id'    => 'ywcfav_player_type_style',
				'value' => 'custom',
				'type'  => 'show'
			)
		),

		'player_style_section_end' => array(
			'type' => 'sectionend',
			'id'   => 'ywcfav_player_style_section_end'
		)
	)

);

return apply_filters( 'ywcfav_video_settings', $video_settings );
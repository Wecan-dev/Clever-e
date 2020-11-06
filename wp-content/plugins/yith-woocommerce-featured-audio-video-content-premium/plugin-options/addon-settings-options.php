<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$zoom_active = ywcfav_check_is_zoom_magnifier_is_active() ? '' : 'yith-disabled';
$addon       = array(

	'addon-settings' => array(

		'addon_section_start'  => array(
			'name' => __( 'General Settings', 'yith-woocommerce-featured-video' ),
			'id'   => 'ywcfav_addon_start',
			'type' => 'title'
		),
		'addon_gallery_mode'   => array(
			'name'      => __( 'Video and Audio gallery mode', 'yith-woocommerce-featured-video' ),
			'id'        => 'ywcfav_gallery_mode',
			'type'      => 'yith-field',
			'yith-type' => 'radio',
			'options'   => array(
				'woocommerce_gallery' => __( 'WooCommerce Gallery', 'yith-woocommerce-featured-video' ),
				'plugin_gallery'      => __( 'Plugin gallery', 'yith-woocommerce-featured-video' )
			),
			'default'   => 'plugin_gallery',
			'desc'      => __( 'By choosing WooCommerce Gallery, videos and audio files (featured ones excluded) will show in WooCommerce gallery. By choosing Plugin Gallery, videos and audio (featured ones excluded) will show in the related gallery', 'yith-woocommerce-featured-video' )
		),
		'addon_zoom_magnifier' => array(
			'name'              => __( 'Video and Audio in the slider', 'yith-woocommerce-featured-video' ),
			'desc'              => __( 'It shows audios and videos in slider, replacing the featured image. This option is possible only if YITH WooCommerce Zoom Magnifier is enabled.', 'yith-woocommerce-featured-video' ),
			'id'                => 'ywcfav_zoom_magnifer_option',
			'type'              => 'yith-field',
			'class' => $zoom_active,
			'yith-type'         => 'onoff',
			'default'           => 'no',
		),
		'addon_slider_widget'  => array(
			'name'      => __( 'Video and Audio in sidebar', 'yith-woocommerce-featured-video' ),
			'desc'      => __( 'Show the audio and video sliders in a sidebar instead of under the product image gallery', 'yith-woocommerce-featured-video' ),
			'id'        => 'ywcfav_show_gallery_in_sidebar',
			'type'      => 'yith-field',
			'yith-type' => 'onoff',
			'default'   => 'no'
		),
		'addon_section_end'    => array(
			'type' => 'sectionend'
		),
	)
);

return apply_filters( 'ywcfav_addons_option', $addon );


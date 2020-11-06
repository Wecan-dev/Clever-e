<?php
if( !defined( 'ABSPATH' ) )
    exit;

$soundcloud =   array(

    'audio-settings'    =>  array(

        'soundcloud_section_start'  =>  array(
            'name'  => __( 'SoundCloud Settings', 'yith-woocommerce-featured-video'),
            'id'    =>  'ywcfav_soundcloud_section_start',
            'type'  =>  'title'
        ),
        'soundcloud_show_artwork'   =>  array(
            'name'  =>  __('Show Artwork', 'yith-woocommerce-featured-video' ),
            'id'    =>  'ywcfav_soundcloud_show_artwork',
            'type'  => 'yith-field',
            'yith-type'  => 'onoff',
            'default'   =>  'no',
	        'desc' => __( 'Show or hide the item\'s artwork', 'yith-woocommerce-featured-video')/** for translation team, string added since 1.3.0  */
        ),
        'soundcloud_auto_play'  =>  array(
            'name'  =>  __( 'AutoPlay', 'yith-woocommerce-featured-video'),
            'id'    =>  'ywcfav_soundcloud_auto_play',
            'type'  => 'yith-field',
            'yith-type'  => 'onoff',
            'default'   =>  'no',
	        'desc' => __( 'If the browser support it, the audio will be autoplayed', 'yith-woocommerce-featured-video')
        ),

        'soundcloud_volume'    =>  array(
            'name'  =>  __( 'Volume', 'yith-woocommerce-featured-video' ),
            'desc'  =>  __( 'Set volume, 0 mute , 1 high volume', 'yith-woocommerce-featured-video' ),
            'type'  => 'yith-field',
            'yith-type'  => 'slider',
            'option' =>  array(
                'min'   =>  0,
                'max'   =>  1
            ),
            'step'  =>  0.1,
            'default'   => 0.5,
            'id'    =>  'ywcfav_soundcloud_volume'
        ),
        'soundcloud_show_comment'   =>  array(
            'name'  =>  __('Show Comments', 'yith-woocommerce-featured-video'),
            'desc'  =>  __('Hide/Show comments', 'yith-woocommerce-featured-video'),
            'type'  => 'yith-field',
            'yith-type'  => 'onoff',
            'default'   =>  'no',
            'id'    =>  'ywcfav_soundcloud_show_comment',

        ),

        'soundcloud_show_sharing'   =>  array(
            'name'  =>  __( 'Show sharing button', 'yith-woocommerce-featured-video' ),
            'type'  => 'yith-field',
            'yith-type'  => 'onoff',
            'id'    =>  'ywcfav_soundcloud_show_sharing',
            'default'   =>  'no',
            'desc'  =>  __('Show or hide share buttons', 'yith-woocommerce-featured-video'),/** for translation team, string added since 1.3.0  */
        ),

        'soundcloud_color'  =>  array(
            'name'  =>  __('Color', 'yith-woocommerce-featured-video'),
            'type'  => 'yith-field',
            'yith-type'  => 'colorpicker',
            'id'    =>  'ywcfav_soundcloud_color',
            'default'   =>  '#ff7700',
	        'desc' => __('Set the color for the player button and other options', 'yith-woocommerce-featured-video')/** for translation team, string added since 1.3.0  */
        ),

        'soundcloud_section_end'    =>  array(
            'id'    =>  'ywcfav_soundcloud_section_end',
            'type'  =>  'sectionend'
        )
    )
);

return apply_filters( 'ywcfav_soundcloud_settings', $soundcloud );
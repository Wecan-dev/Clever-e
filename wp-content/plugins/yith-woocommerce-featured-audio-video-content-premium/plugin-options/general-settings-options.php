<?php
if( !defined( 'ABSPATH' ) )
    exit;

$general_settings   =   array(

    'general-settings'  =>  array(

        'general_setting_section_start' =>  array(
            'name'  =>  __('Modal Settings', 'yith-woocommerce-featured-video' ),
            'type'  =>  'title',
            'id'    =>  'ywcfav_general_setting_section_start'
        ),

        'video_in_modal'    =>  array(
            'name'  =>  __( 'Video in modal', 'yith-woocommerce-featured-video'),
            'desc'  =>  __( 'Show featured video in a modal window', 'yith-woocommerce-featured-video'),
            'type'  =>  'yith-field',
            'yith-type' => 'onoff',
            'id'    =>  'ywcfav_video_in_modal',
            'default'   =>  'no'
        ),

        'soundcloud_in_modal'   =>  array(
            'name' => __( 'Audio in modal', 'yith-woocommerce-featured-video'),
            'desc'  =>  __( 'Show featured audio in a modal window', 'yith-woocommerce-featured-video'),
            'id'    =>  'ywcfav_soundcloud_in_modal',
            'type'  =>  'yith-field',
            'yith-type' => 'onoff',
            'default'   =>  'no'
        ),

        'video_popup-effect' => array(
            'id'      => 'ywcfav_modal_effect',
            'name'    => __( 'Modal displaying effect', 'yith-woocommerce-featured-video' ),
            'type'  =>  'yith-field',
            'yith-type' => 'select',
            'options' => array(
                '0' => __( 'None', 'yith-woocommerce-featured-video' ),
                '1' => __( 'Huge Inc', 'yith-woocommerce-featured-video' ),
                '2' => __( 'Corner', 'yith-woocommerce-featured-video' ),
                '3' => __( 'Slide down', 'yith-woocommerce-featured-video' ),
                '4' => __( 'Scale', 'yith-woocommerce-featured-video' ),
                '5' => __( 'Little genie', 'yith-woocommerce-featured-video' ),
            ),
            'class' => 'wc-enhanced-select',
            'default' => 0
        ),

        'general_setting_section_end'   =>  array(
            'type'  =>  'sectionend',
            'id'    =>  'ywcfav_general_setting_section_end'
        ),

    )
);


return apply_filters( 'ywcfav_general_settings', $general_settings );
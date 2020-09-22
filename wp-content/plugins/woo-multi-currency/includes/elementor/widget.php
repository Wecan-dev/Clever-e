<?php

use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class WOOMULTI_CURRENCY_Elementor_Widget extends Widget_Base {

	public static $slug = 'wmc-multi-currency-elementor-widget';

	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );
		add_action( 'elementor/editor/before_enqueue_styles', array( $this, 'enqueue' ) );
	}

	public function enqueue() {
		wp_register_style( 'wmc-elementor-style', false );
		wp_enqueue_style( 'wmc-elementor-style' );
		$css = ".wmc-multi-currency-icon{
				display:block;height:28px;background-image: url('" . WOOMULTI_CURRENCY_F_IMAGES . "icon_elementor.svg');
				background-position: center; background-repeat: no-repeat;background-size: contain;}";
		wp_add_inline_style( 'wmc-elementor-style', $css );
	}

	public function get_name() {
		return 'woocommerce-multi-currency';
	}

	public function get_title() {
		return __( 'Multi Currency', 'woocommerce-multi-currency' );
	}

	public function get_icon() {
		return "wmc-multi-currency-icon";
	}

	public function get_categories() {
		return [ 'woocommerce-elements' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'general',
			[
				'label' => __( 'General', 'woocommerce-multi-currency' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout',
			[
				'label'       => __( 'Select switcher layout', 'woocommerce-photo-reviews' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => [
					''                 => esc_html__( 'Default', 'woocommerce-multi-currency' ),
					'plain_horizontal' => esc_html__( 'Plain Horizontal', 'woocommerce-multi-currency' ),
					'plain_vertical'   => esc_html__( 'Plain Vertical', 'woocommerce-multi-currency' ),
					'plain_vertical_2' => esc_html__( 'Listbox currency code', 'woocommerce-multi-currency' ),
					'layout3'          => esc_html__( 'List Flag Horizontal', 'woocommerce-multi-currency' ),
					'layout4'          => esc_html__( 'List Flag Vertical', 'woocommerce-multi-currency' ),
					'layout5'          => esc_html__( 'List Flag + Currency Code', 'woocommerce-multi-currency' ),
					'layout6'          => esc_html__( 'Horizontal Currency Symbols', 'woocommerce-multi-currency' ),
					'layout9'          => esc_html__( 'Horizontal Currency Slide', 'woocommerce-multi-currency' ),
					'layout7'          => esc_html__( 'Vertical Currency Symbols', 'woocommerce-multi-currency' ),
					'layout8'          => esc_html__( 'Vertical Currency Symbols (circle)', 'woocommerce-multi-currency' ),
				],
			]
		);

		$this->add_control(
			'flag_size',
			[
				'label'     => __( 'Flag size', 'woocommerce-multi-currency' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 1,
				'step'      => 0.1,
				'default'   => 0.6,
				'condition' => [
					'layout' => [ 'layout3', 'layout4', 'layout5', ]
				]
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$layout    = $settings['layout'] ? '_' . $settings['layout'] : '';
		$flag_size = $settings['flag_size'] ? 'flag_size=' . $settings['flag_size'] : '';
		echo do_shortcode( "[woo_multi_currency{$layout} $flag_size]" );
	}

	public function render_plain_content() {
		$settings  = $this->get_settings_for_display();
		$layout    = $settings['layout'] ? '_' . $settings['layout'] : '';
		$flag_size = $settings['flag_size'] ? 'flag_size=' . $settings['flag_size'] : '';
		$shortcode = "[woo_multi_currency{$layout} $flag_size]";
		echo $shortcode;
	}
}
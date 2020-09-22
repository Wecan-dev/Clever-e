<?php

/**
 * Class WOOMULTI_CURRENCY_F_Plugin_LearnPress
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOOMULTI_CURRENCY_F_Plugin_LearnPress {
	protected $settings;

	public function __construct() {

		$this->settings = WOOMULTI_CURRENCY_F_Data::get_ins();
		if ( $this->settings->get_enable() ) {
			add_filter( 'learn-press/course-price', array( $this, 'learn_press_course_price' ), 99, 2 );
			add_filter( 'learn_press_course_price_html', array( $this, 'learn_press_course_price_html' ), 99, 2 );
			add_filter( 'learn_press_course_origin_price_html', array(
				$this,
				'learn_press_course_origin_price_html'
			), 99, 2 );
		}
	}

	public function learn_press_course_price( $price, $product_id ) {
		return wmc_get_price( $price );
	}

	public function learn_press_course_price_html( $price, $course ) {
		return $this->wc_price($course->get_price());
	}


	public function learn_press_course_origin_price_html( $sale_price, $course ) {
		if ( $course->has_sale_price() ) {
			return $this->wc_price( wmc_get_price( $course->get_origin_price() ) );
		} else {
			return '';
		}
	}
	public function wc_price( $price, $args = array() ) {
		extract(
			apply_filters(
				'wc_price_args', wp_parse_args(
					$args, array(
						'ex_tax_label'       => false,
						'currency'           => get_woocommerce_currency_symbol(),
						'decimal_separator'  => wc_get_price_decimal_separator(),
						'thousand_separator' => wc_get_price_thousand_separator(),
						'decimals'           => wc_get_price_decimals(),
						'price_format'       => get_woocommerce_price_format(),
					)
				)
			)
		);

		$negative = $price < 0;
		$price    = apply_filters( 'raw_woocommerce_price', floatval( $negative ? $price * - 1 : $price ) );
		$price    = apply_filters( 'formatted_woocommerce_price', number_format( $price, $decimals, $decimal_separator, $thousand_separator ), $price, $decimals, $decimal_separator, $thousand_separator );

		if ( apply_filters( 'woocommerce_price_trim_zeros', false ) && $decimals > 0 ) {
			$price = wc_trim_zeros( $price );
		}
		$formatted_price = ( $negative ? '-' : '' ) . sprintf( $price_format, $currency, $price );

		return $formatted_price;
	}
}
<?php

/**
 * Class WOOMULTI_CURRENCY_F_Plugin_WooCommerce_Bookings
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOOMULTI_CURRENCY_F_Plugin_WooCommerce_Bookings {
	protected $settings;

	public function __construct() {

		$this->settings = WOOMULTI_CURRENCY_F_Data::get_ins();
		if ( $this->settings->get_enable() ) {
			add_filter( 'woocommerce_bookings_calculated_booking_cost_success_output', array(
				$this,
				'woocommerce_bookings_calculated_booking_cost_success_output'
			), 12, 3 );
		}
	}

	/**
	 * @param $output
	 * @param $display_price
	 * @param $product
	 *
	 * @return mixed
	 */
	public function woocommerce_bookings_calculated_booking_cost_success_output( $output, $display_price, $product ) {
		$posted = array();
//		parse_str( sanitize_text_field( $_POST['form'] ), $posted );
		parse_str( $_POST['form'], $posted );
//		$booking_form = new WC_Booking_Form( $product );
//		$cost         = $booking_form->calculate_booking_cost( $posted );
		$data = wc_bookings_get_posted_data( $posted, $product );
		$cost = WC_Bookings_Cost_Calculation::calculate_booking_cost( $data, $product );

		if ( is_wp_error( $cost ) ) {
			wp_send_json( array(
				'result' => 'ERROR',
//				'html'   => apply_filters( 'woocommerce_bookings_calculated_booking_cost_success_output', '<span class="booking-error">' . $cost->get_error_message() . '</span>', $cost, $product ),
			) );
		}
		if ( version_compare( WC_VERSION, '2.4.0', '>=' ) ) {
			$price_suffix = $product->get_price_suffix( $cost, 1 );
		} else {
			$price_suffix = $product->get_price_suffix();
		}
		$price_arg        = array();
		$current_currency = $this->settings->get_current_currency();
		$currencies       = $this->settings->get_list_currencies();
		switch ( $currencies[ $current_currency ]['pos'] ) {
			case 'left' :
				$format = '%1$s%2$s';
				break;
			case 'right' :
				$format = '%2$s%1$s';
				break;
			case 'left_space' :
				$format = '%1$s&nbsp;%2$s';
				break;
			case 'right_space' :
				$format = '%2$s&nbsp;%1$s';
				break;
		}
		$price_arg = array(
			'currency'     => $this->settings->get_current_currency(),
			'decimals'     => $currencies[ $current_currency ]['decimals'],
			'price_format' => $format,
		);
// Build the output
		$display_price = wmc_get_price( $display_price );
		$output        = apply_filters( 'woocommerce_bookings_booking_cost_string', __( 'Booking cost', 'woocommerce-bookings' ), $product ) . ': <strong>' . wc_price( $display_price, $price_arg ) . $price_suffix . '</strong>';

		return $output;
	}


}
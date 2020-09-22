<?php

/**
 * Class WOOMULTI_CURRENCY_F_Plugin_Subscription
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOOMULTI_CURRENCY_F_Plugin_Subscription {
	protected $settings;

	public function __construct() {

		$this->settings = WOOMULTI_CURRENCY_F_Data::get_ins();
		if ( $this->settings->get_enable() ) {
			add_filter( 'wc_epo_price', array( $this, 'get_price' ) );
			add_filter( 'woocommerce_subscriptions_product_price', array( $this, 'get_price' ) );
			add_filter( 'woocommerce_tm_epo_price_on_cart', array( $this, 'get_price' ) );
		}
	}

	/**
	 * WooCommerce Subscription
	 *
	 * @param $data
	 *
	 * @return mixed
	 */

	public function get_price( $price ) {

		return wmc_get_price( $price );
	}
}
<?php

class WOOMULTI_CURRENCY_Plugin_Change_Price_3rd_Plugin {
	function __construct() {
		add_filter( 'woocommerce_product_addons_option_price_raw', array( $this, 'change_price' ) );
		add_filter( 'wmc_change_3rd_plugin_price', array( $this, 'change_price' ) );
		add_filter( 'wmc_change_raw_price', array( $this, 'change_price' ) );

		// Compatible with WC Name Your Price
		add_filter( 'woocommerce_raw_minimum_variation_price', array( $this, 'change_price' ) );
		add_filter( 'woocommerce_raw_minimum_price', array( $this, 'change_price' ) );
		add_filter( 'woocommerce_raw_suggested_price', array( $this, 'change_price' ) );
		add_filter( 'woocommerce_raw_maximum_price', array( $this, 'change_price' ) );

		// TM extra product option
		add_filter( 'wc_epo_get_current_currency_price', array( $this, 'tm_epo_change_price' ), 10, 2 );

		// Table Rate shipping
		add_filter( 'betrs_condition_tertiary_subtotal', array( $this, 'change_price' ) );

		// Advanced shipping
		add_filter( 'wcml_shipping_price_amount', array( $this, 'change_price' ), 10 );
		add_filter( 'wcml_shipping_price_amount', array( $this, 'number_format' ), 11 );

		// Discussion on RnB - WooCommerce Booking & Rental Plugin
		add_filter( 'redq_pickup_locations', array( $this, 'redq_change_price' ) );
		add_filter( 'redq_dropoff_locations', array( $this, 'redq_change_price' ) );
		add_filter( 'redq_payable_resources', array( $this, 'redq_change_price' ) );
		add_filter( 'redq_payable_security_deposite', array( $this, 'redq_change_price' ) );
		add_filter( 'redq_rnb_cat_categories', array( $this, 'redq_change_price' ) );
		add_filter( 'redq_payable_person', array( $this, 'redq_person_change_price' ) );
		add_filter( 'wmc_product_get_price_condition', array( $this, 'rnb_plugin_condition' ), 10, 3 );

		// WooCommerce PDF Vouchers - WordPress Plugin
		add_filter( 'woo_vou_get_product_price', array( $this, 'woo_vou_reverse_price' ), 10, 2 );

	}

	public function rnb_plugin_condition( $condition, $price, $product ) {
		if ( is_a( $product, 'WC_Product_Redq_Rental' ) ) {
			$condition = false;
		}

		return $condition;
	}

	public function change_price( $price_raw ) {
		return wmc_get_price( $price_raw );
	}

	public function number_format( $price ) {
		$data             = WOOMULTI_CURRENCY_Data::get_ins();
		$current_currency = $data->get_current_currency();
		$currencies_list  = $data->get_list_currencies();

		return number_format( $price, $currencies_list[ $current_currency ]['decimals'] );
	}

	public function tm_epo_change_price( $price, $type ) {
		if ( ! in_array( $type, array( 'percent', 'percentcurrenttotal' ) ) ) {
			$price = wmc_get_price( $price );
		}

		return $price;
	}

	public function redq_person_change_price( $data ) {
		$new_data = $data;
		if ( is_array( $data ) && count( $data ) ) {
			foreach ( $data as $key => $value ) {
				$new_data[ $key ] = $this->redq_change_price( $value );
			}
		}

		return $new_data;
	}

	public function redq_change_price( $data ) {
		$new_data = $data;

		if ( is_array( $data ) && count( $data ) ) {
			foreach ( $data as $el_key => $element ) {
				if ( is_array( $element ) && count( $element ) ) {
					foreach ( $element as $key => $value ) {
						if ( substr( $key, - 4 ) == 'cost' && is_numeric( $value ) ) {
							$new_data[ $el_key ][ $key ] = $this->change_price( $value );
						}
					}
				}
			}
		}

		return $new_data;
	}

	public function woo_vou_reverse_price( $subtotal, $order_id ) {
		$order          = wc_get_order( $order_id );
		$wmc_order_info = get_post_meta( $order_id, 'wmc_order_info', true );
		$order_currency = $order->get_currency();
		$rate           = ! empty( $wmc_order_info[ $order_currency ]['rate'] ) ? $wmc_order_info[ $order_currency ]['rate'] : '';
		$decimals       = ! empty( $wmc_order_info[ $order_currency ]['decimals'] ) ? $wmc_order_info[ $order_currency ]['decimals'] : '';

		$subtotal = $rate ? $subtotal / $rate : $subtotal;
		$subtotal = $decimals ? number_format( $subtotal, $decimals ) : $subtotal;

		return $subtotal;
	}
}

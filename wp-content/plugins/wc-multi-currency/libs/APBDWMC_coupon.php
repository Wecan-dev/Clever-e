<?php
	/**
	 * @since: 06/10/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	
	class APBDWMC_coupon {
		/** @var APBDWMC_general $core */
		public $core;
		function __construct() {
			$this->core=APBDWMC_general::GetModuleInstance();
			// Coupon
			add_filter( 'woocommerce_coupon_get_amount', [$this, '_wc_coupon_get_amount'], 10, 2 );
			add_filter( 'woocommerce_coupon_get_minimum_amount', [$this, '_wc_coupon_get_minimum_amount' ] );
			add_filter( 'woocommerce_coupon_get_maximum_amount', [$this, '_wc_coupon_get_maximum_amount'] );
			
			//3rd party plugins
			add_filter( 'woocommerce_boost_sales_coupon_amount_price', [$this, '_wc_coupon_boost_sales_coupon_amount_price'] );
		}
		public function _wc_coupon_get_amount( $price, $coupon_object ) {
			if ( $coupon_object->is_type( array( 'percent' ) ) ) {
				return $price;
			}
			
			return $this->core->getCalculatedPrice($price,$coupon_object);
		}
		
		public function _wc_coupon_get_minimum_amount( $price ) {
			
			return $this->core->getCalculatedPrice($price);
		}
		
		public function _wc_coupon_get_maximum_amount( $price ) {
			return $this->core->getCalculatedPrice($price);
		}
		public function _wc_coupon_boost_sales_coupon_amount_price( $price ) {
			return $this->core->getCalculatedPrice($price);
		}
	}
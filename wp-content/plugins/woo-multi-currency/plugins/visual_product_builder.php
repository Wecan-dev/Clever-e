<?php

/**
 * Class WOOMULTI_CURRENCY_F_Plugin_Visual_Product_Builder
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOOMULTI_CURRENCY_F_Plugin_Visual_Product_Builder {
	protected $settings;

	public function __construct() {

		$this->settings = WOOMULTI_CURRENCY_F_Data::get_ins();
		if ( $this->settings->get_enable() ) {
			if ( class_exists( 'Vpc' ) ) {
				add_filter( 'vpc_options_price', array( $this, 'vpc_options_price' ) );
				global $wp_filter;

				if ( isset( $wp_filter['woocommerce_before_calculate_totals']->callbacks[10] ) ) {
					$hooks = $wp_filter['woocommerce_before_calculate_totals']->callbacks[10];
					foreach ( $hooks as $k => $hook ) {
						if ( strpos( $k, 'get_cart_item_price' ) === false ) {

						} else {
							if ( isset( $hook['function'][0] ) && is_object( $hook['function'][0] ) ) {
								$class_name = get_class( $hook['function'][0] );
								if ( strtoupper( 'VPC_Public' ) == strtoupper( $class_name ) ) {
									unset( $wp_filter['woocommerce_before_calculate_totals']->callbacks[10][$k] );
									break;
								}
							}
						}
					}
				}

				add_action( 'woocommerce_before_calculate_totals', array( $this, 'get_cart_item_price' ) );
			}
		}
	}

	function get_cart_item_price( $cart ) {

		global $vpc_settings;
		$hide_secondary_product_in_cart = get_proper_value( $vpc_settings, "hide-wc-secondary-product-in-cart", "Yes" );
		if ( $_SESSION["vpc_calculated_totals"] == true ) {
			return;
		}

		foreach ( $cart->cart_contents as $cart_item_key => $cart_item ) {
			if ( $cart_item["variation_id"] ) {
				$product_id = $cart_item["variation_id"];
			} else {
				$product_id = $cart_item["product_id"];
			}

			$recap = get_recap_from_cart_item( $cart_item );
			if ( isset( $cart_item['vpc-is-secondary-product'] ) && $cart_item['vpc-is-secondary-product'] && $hide_secondary_product_in_cart == "Yes" ) {
				if ( vpc_woocommerce_version_check() ) {
					$cart_item['data']->price = 0;
				} else {
					$cart_item['data']->set_price( 0 );
				}
			}
			if ( ! empty( $recap ) ) {
				$a_price = $this->get_config_price( $product_id, $recap, $cart_item );
				if ( vpc_woocommerce_version_check() ) {
					$cart_item['data']->price += $a_price;
				} else {
					$data  = $cart_item['data']->get_data();
					$total = $data['price'] + $a_price;

					$cart_item['data']->set_price( $total );
				}
			}
		}
		$_SESSION["vpc_calculated_totals"] = true;
	}

	private function get_config_price( $product_id, $config, $cart_item ) {
		$original_config = get_product_config( $product_id );
		$total_price     = 0;
		//        foreach ($config as $recap) {
		foreach ( $config as $component => $raw_options ) {
			$options_arr = $raw_options;
			if ( ! is_array( $raw_options ) ) {
				$options_arr = array( $raw_options );
			}
			foreach ( $options_arr as $option ) {
				$linked_product = $this->extract_option_field_from_config( $option, $component, $original_config->settings, "product" );
				$option_price   = $this->extract_option_field_from_config( $option, $component, $original_config->settings, "price" );

				if ( strpos( $option_price, ',' ) ) {
					$option_price = floatval( str_replace( ',', '.', $option_price ) );
				}
				//We ignore the linked products prices since they're already added in the cart
				if ( $linked_product ) {
					$option_price = $this->get_product_linked_price( $linked_product );
				}

				//We make sure we're not handling any empty priced option
				if ( empty( $option_price ) ) {
					$option_price = 0;
				}

				$total_price += $option_price;
			}
		}

		return apply_filters( "vpc_config_price", $total_price, $product_id, $config, $cart_item );
	}

	private function get_product_linked_price( $linked_product ) {
		global $vpc_settings;
		$hide_secondary_product_in_cart = get_proper_value( $vpc_settings, "hide-wc-secondary-product-in-cart", "Yes" );
		if ( $hide_secondary_product_in_cart == "Yes" ) {
			$_product = wc_get_product( $linked_product );
			if ( function_exists( "wad_get_product_price" ) ) {
				$option_price = wad_get_product_price( $_product );
			} else {
				$option_price = $_product->get_price();
				if ( strpos( $option_price, ',' ) ) {
					$option_price = floatval( str_replace( ',', '.', $option_price ) );
				}
			}
		} else {
			$option_price = 0;
		}

		return $option_price;
	}

	public function extract_option_field_from_config( $searched_option, $searched_component, $config, $field = "icon" ) {
		$unslashed_searched_option    = stripslashes( $searched_option );
		$unslashed_searched_component = stripslashes( $searched_component );
		$field                        = apply_filters( "extracted_option_field_from_config", $field );
		if ( ! is_array( $config ) ) {
			$config = unserialize( $config );
		}
		foreach ( $config["components"] as $i => $component ) {
			if ( stripslashes( $component["cname"] ) == $unslashed_searched_component ) {
				foreach ( $component["options"] as $component_option ) {
					if ( stripslashes( $component_option["name"] ) == $unslashed_searched_option ) {
						if ( isset( $component_option[$field] ) ) {
							return $component_option[$field];
						}
					}
				}
			}
		}

		return false;
	}

	/**
	 * Change price in Build page
	 *
	 * @param $data
	 *
	 * @return mixed
	 */

	public function vpc_options_price( $data ) {

		return wmc_get_price( $data );
	}

}
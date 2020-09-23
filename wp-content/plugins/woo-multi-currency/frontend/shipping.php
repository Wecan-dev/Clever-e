<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WOOMULTI_CURRENCY_F_Frontend_Shipping
 */
class WOOMULTI_CURRENCY_F_Frontend_Shipping {
	protected $cache = array();

	function __construct() {

		$this->settings = WOOMULTI_CURRENCY_F_Data::get_ins();
		if ( $this->settings->get_enable() ) {

			global $wpdb;

			$raw_methods_sql = "SELECT method_id, method_order, instance_id, is_enabled FROM {$wpdb->prefix}woocommerce_shipping_zone_methods WHERE is_enabled = 1 order by instance_id ASC;";
			$raw_methods     = $wpdb->get_results( $raw_methods_sql );
			if ( count( $raw_methods ) ) {
				foreach ( $raw_methods as $method ) {
					/*Free Shipping and Flat rate of WooCommerce Core*/
					if ( $method->method_id == 'free_shipping' ) {
						add_filter(
							'option_woocommerce_' . trim( $method->method_id ) . '_' . intval( $method->instance_id ) . '_settings', array(
								$this,
								'free_cost'
							)
						);
					} elseif ( $method->method_id == 'betrs_shipping' ) {
						/*Compatible with WooCommerce Table Rate Shipping*/
						add_filter(
							'option_betrs_shipping_options-' . intval( $method->instance_id ), array(
								$this,
								'table_rate_shipping'
							)
						);
					}

				}
			}
			add_filter( 'woocommerce_package_rates', array( $this, 'woocommerce_package_rates' ), 10, 2 );
		}

	}

	public function table_rate_shipping( $options ) {
		$new_options = $options;
		if ( ! empty( $new_options ) ) {
			// step through each table rate row
			foreach ( $new_options['settings'] as $o_key => $option ) {

				foreach ( $option['rows'] as $r_key => $row ) {
					$costs = $row['costs'];
					if ( is_array( $costs ) ) {
						foreach ( $costs as $k => $cost ) {
							switch ( $cost['cost_type'] ) {
								case '%':
									break;
								default:
									$options['settings'][ $o_key ]['rows'][ $r_key ]['costs'][ $k ]['cost_value'] = wmc_get_price( $cost['cost_value'] );
							}
						}
					}
				}

			}
		}

		return $options;
	}

	/**
	 * Shipping cost
	 *
	 * @param $methods
	 *
	 * @return mixed
	 */
	public function woocommerce_package_rates( $methods, $package ) {
		if ( count( array_filter( $methods ) ) ) {
			foreach ( $methods as $k => $method ) {
				if ( $method->method_id == 'betrs_shipping' || $method->method_id == 'printful_shipping'|| $method->method_id == 'easyship' ) {
					continue;
				}
				if ( $method->method_id == 'flat_rate' ) {
					$shipping = new WC_Shipping_Flat_Rate( $method->instance_id );
					// Calculate the costs.
					$has_costs = false; // True when a cost is set. False if all costs are blank strings.
					$cost      = $shipping->get_option( 'cost' );

					if ( '' !== $cost ) {
						$has_costs    = true;
						$rate['cost'] = $this->evaluate_cost(
							$cost, array(
							'qty'  => $shipping->get_package_item_qty( $package ),
							'cost' => $package['contents_cost'],
						), $shipping
						);
					}

					// Add shipping class costs.
					$shipping_classes = WC()->shipping->get_shipping_classes();

					if ( ! empty( $shipping_classes ) ) {
						$found_shipping_classes = $shipping->find_shipping_classes( $package );
						$highest_class_cost     = 0;

						foreach ( $found_shipping_classes as $shipping_class => $products ) {
							// Also handles BW compatibility when slugs were used instead of ids.
							$shipping_class_term = get_term_by( 'slug', $shipping_class, 'product_shipping_class' );
							$class_cost_string   = $shipping_class_term && $shipping_class_term->term_id ? $shipping->get_option( 'class_cost_' . $shipping_class_term->term_id, $shipping->get_option( 'class_cost_' . $shipping_class, '' ) ) : $shipping->get_option( 'no_class_cost', '' );

							if ( '' === $class_cost_string ) {
								continue;
							}

							$has_costs  = true;
							$class_cost = $this->evaluate_cost(
								$class_cost_string, array(
								'qty'  => array_sum( wp_list_pluck( $products, 'quantity' ) ),
								'cost' => array_sum( wp_list_pluck( $products, 'line_total' ) ),
							), $shipping
							);

							if ( 'class' === $shipping->type ) {
								$rate['cost'] += $class_cost;
							} else {
								$highest_class_cost = $class_cost > $highest_class_cost ? $class_cost : $highest_class_cost;
							}
						}

						if ( 'order' === $shipping->type && $highest_class_cost ) {
							$rate['cost'] += $highest_class_cost;
						}
					}
					if ( $has_costs ) {
						$cost = wmc_get_price( $rate['cost'] );
						$method->set_cost( $cost );
						$this->cache[ $k ] = $cost;
					}
				} else {
					if ( isset( $this->cache[ $k ] ) && $this->cache[ $k ] && $k ) {
						$method->set_cost( $this->cache[ $k ] );
					} else {
						$data = get_option( 'woocommerce_' . $method->method_id . '_' . $method->instance_id . '_settings' );
						$cost = isset( $data['cost'] ) ? wmc_get_price( $data['cost'] ) : wmc_get_price( $method->get_cost() );
						$method->set_cost( $cost );
						$this->cache[ $k ] = $cost;
					}
				}
				if ( count( $method->get_taxes() ) ) {
					$new_tax = array();
					foreach ( $method->get_taxes() as $k => $tax ) {
						$new_tax[ $k ] = wmc_get_price( $tax );
					}
					$method->set_taxes( $new_tax );
				}
			}
		}

		return $methods;
	}

	protected function evaluate_cost( $sum, $args = array(), $shipping ) {
		include_once WC()->plugin_path() . '/includes/libraries/class-wc-eval-math.php';

		// Allow 3rd parties to process shipping cost arguments.
		$args     = apply_filters( 'woocommerce_evaluate_shipping_cost_args', $args, $sum, $shipping );
		$locale   = localeconv();
		$decimals = array(
			wc_get_price_decimal_separator(),
			$locale['decimal_point'],
			$locale['mon_decimal_point'],
			','
		);

		// Expand shortcodes.
		add_shortcode( 'fee', array( $shipping, 'fee' ) );

		$sum = do_shortcode(
			str_replace(
				array(
					'[qty]',
					'[cost]',
				),
				array(
					$args['qty'],
					$args['cost'],
				),
				$sum
			)
		);

		remove_shortcode( 'fee', array( $shipping, 'fee' ) );

		// Remove whitespace from string.
		$sum = preg_replace( '/\s+/', '', $sum );

		// Remove locale from string.
		$sum = str_replace( $decimals, '.', $sum );

		// Trim invalid start/end characters.
		$sum = rtrim( ltrim( $sum, "\t\n\r\0\x0B+*/" ), "\t\n\r\0\x0B+-*/" );

		// Do the math.
		return $sum ? WC_Eval_Math::evaluate( $sum ) : 0;
	}

	/**
	 * Tax on free ship
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function free_cost( $data ) {
		if ( ! $this->settings->get_default_currency() ) {
			return $data;
		}

		if ( isset( $data['min_amount'] ) ) {
			$data['min_amount'] = wmc_get_price( $data['min_amount'] );
		}

		return $data;
	}

}
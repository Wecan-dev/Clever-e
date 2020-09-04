<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WOOMULTI_CURRENCY_F_Frontend_Filter_Price
 */
class WOOMULTI_CURRENCY_F_Frontend_Filter_Price {
	protected $settings;
	public $min_price;
	public $max_price;

	function __construct() {
//		$this->settings = new WOOMULTI_CURRENCY_Data();
		$this->settings = WOOMULTI_CURRENCY_F_Data::get_ins();
		if ( $this->settings->get_enable() ) {

			add_filter( 'woocommerce_price_filter_results', array( $this, 'woocommerce_price_filter_results' ), 10, 3 );

			add_filter( 'woocommerce_product_query_meta_query', array( $this, 'woocommerce_product_query_meta_query' ) );
			add_filter( 'woocommerce_price_filter_widget_min_amount', array( $this, 'wmc_woocommerce_get_max_min_price' ) );
			add_filter( 'woocommerce_price_filter_widget_max_amount', array( $this, 'wmc_woocommerce_get_max_min_price' ) );

			add_filter( 'posts_clauses', array( $this, 'reset_price' ), 9, 2 );
			add_filter( 'posts_clauses', array( $this, 'return_price' ), 11, 2 );
		}
	}

	/**
	 * Coverted min price
	 *
	 * @param $raw_price
	 *
	 * @return mixed
	 */
	public function wmc_woocommerce_get_max_min_price( $raw_price ) {


		return wmc_get_price( $raw_price );
	}

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function woocommerce_product_query_meta_query( $query ) {

		$current_currency    = $this->settings->get_current_currency();
		$selected_currencies = $this->settings->get_list_currencies();

		if ( isset( $query['price_filter'] ) ) {
			if ( isset( $query['price_filter']['value'][0] ) ) {
				$query['price_filter']['value'][0] = intval( $query['price_filter']['value'][0] / $selected_currencies[ $current_currency ]['rate'] );
			}
			if ( isset( $query['price_filter']['value'][1] ) ) {
				$query['price_filter']['value'][1] = intval( $query['price_filter']['value'][1] / $selected_currencies[ $current_currency ]['rate'] );
			}
		}


		return $query;
	}

	public function reset_price( $args, $wp_query ) {

		if ( ! $wp_query->is_main_query() || ( ! isset( $_GET['max_price'] ) && ! isset( $_GET['min_price'] ) ) ) {
			return $args;
		}
		$this->min_price  = floatval( wp_unslash( $_GET['min_price'] ) );
		$this->max_price  = floatval( wp_unslash( $_GET['max_price'] ) );
		$current_currency = $this->settings->get_current_currency();
		$rate             = wmc_get_price( 1, $current_currency ) ? wmc_get_price( 1, $current_currency ) : '';

		if ( $rate ) {
			$_GET['min_price'] = $this->min_price / $rate;
			$_GET['max_price'] = $this->max_price / $rate;
		}

		return $args;
	}

	public function return_price( $args, $wp_query ) {

		if ( ! $wp_query->is_main_query() || ( ! isset( $_GET['max_price'] ) && ! isset( $_GET['min_price'] ) ) ) {
			return $args;
		}

		$_GET['min_price'] = $this->min_price;
		$_GET['max_price'] = $this->max_price;

		return $args;
	}

	/**
	 * Override filter price
	 *
	 * @param $data_query
	 * @param $min_class
	 * @param $max_class
	 *
	 * @return array|null|object
	 */
	public function woocommerce_price_filter_results( $data_query, $min_class, $max_class ) {
		global $wpdb;
		$fix_value        = 0;
		$options          = $this->settings->get_list_currencies();
		$current_currency = $this->settings->get_current_currency();
		if ( isset( $options[ $current_currency ]['rate'] ) ) {
			if ( $options[ $current_currency ]['rate'] != 1 ) {
				$fix_value = 1;
			}
		}
		if ( $options[ $current_currency ]['rate'] ) {
			$min_class = $min_class / $options[ $current_currency ]['rate'] - $fix_value;
			$max_class = $max_class / $options[ $current_currency ]['rate'] + $fix_value;
		} else {
			$min_class = 0;
			$max_class = 0;
		}


		if ( wc_tax_enabled() && 'incl' === get_option( 'woocommerce_tax_display_shop' ) && ! wc_prices_include_tax() ) {
			$data_query = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT DISTINCT ID, post_parent, post_type FROM {$wpdb->posts}
						INNER JOIN {$wpdb->postmeta} pm1 ON ID = pm1.post_id
						INNER JOIN {$wpdb->postmeta} pm2 ON ID = pm2.post_id
						WHERE post_type IN ( 'product', 'product_variation' )
						AND post_status = 'publish'
						AND pm1.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
						AND pm1.meta_value BETWEEN %f AND %f
						AND pm2.meta_key = '_tax_class'
						AND pm2.meta_value = %s
					", $min_class, $max_class, sanitize_title( $tax_class )
				), OBJECT_K
			);
		} else {
			$data_query = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT DISTINCT ID, post_parent, post_type FROM {$wpdb->posts}
					INNER JOIN {$wpdb->postmeta} pm1 ON ID = pm1.post_id
					WHERE post_type IN ( 'product', 'product_variation' )
					AND post_status = 'publish'
					AND pm1.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
					AND pm1.meta_value BETWEEN %d AND %d
				", $min_class, $max_class
				), OBJECT_K
			);
		}

		return $data_query;
	}
}

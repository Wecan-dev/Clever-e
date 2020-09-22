<?php

/*
Class Name: WOOMULTI_CURRENCY_F_Admin_Order
Author: Andy Ha (support@villatheme.com)
Author URI: http://villatheme.com
Copyright 2015-2017 villatheme.com. All rights reserved.
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOOMULTI_CURRENCY_F_Admin_Order {
	function __construct() {

		add_action( 'admin_init', array( $this, 'add_metabox' ), 1 );
	}

	/**
	 * Add metabox to order post
	 */
	public function add_metabox() {
		add_meta_box( 'wmc_order_metabox', __( 'Currency Information', 'woo-multi-currency' ), array(
			$this,
			'order_metabox'
		), 'shop_order', 'side', 'default' );
		add_action( 'manage_shop_order_posts_custom_column', array( $this, 'currency_columns' ), 2 );
		add_filter( 'woocommerce_get_formatted_order_total', array( $this, 'get_formatted_order_total' ), 10, 2 );
	}

	public function currency_columns( $col ) {
		global $post, $the_order;

		if ( empty( $the_order ) || $the_order->get_id() !== $post->ID ) {
			$the_order = wc_get_order( $post->ID );
		}
		if ( $col == 'order_total' ) { ?>
            <div class="wmc-order-currency">
				<?php echo esc_html( 'Currency: ', 'woo-multi-currency' ) . get_post_meta( $the_order->get_id(), '_order_currency', true ); ?>
            </div>
		<?php }
	}

	/**
	 * @param $post
	 */
	public function order_metabox( $post ) {
		$order = new WC_Order( $post->ID );

		$order_currency = get_post_meta( $order->get_id(), '_order_currency', true );
		$wmc_order_info = get_post_meta( $order->get_id(), 'wmc_order_info', true );

		//		$rate           = 0;
		$has_info = 1;
		if ( ! isset( $wmc_order_info ) || ! is_array( $wmc_order_info ) ) {
			$has_info = 0;
		}

		?>
        <div id="wmc_order_metabox">
			<?php if ( ! $has_info ) {
				$wmc_order_base_currency = $order_currency;
				$rate                    = 1;
			} else {
				foreach ( $wmc_order_info as $code => $currency_info ) {
					if ( isset( $currency_info['is_main'] ) && $currency_info['is_main'] == 1 ) {
						$wmc_order_base_currency = $code;
						break;
					}
				}

				$rate = $wmc_order_info[ $order_currency ]['rate'];
			}
			?>
            <div id="wmc_order_currency_text">
                <p>
					<?php esc_html_e( 'Currency', 'woo-multi-currency' ); ?> :
                    <span><?php echo $order_currency; ?></span>
                </p>
            </div>
            <div id="wmc_order_base_currency">
                <p>
					<?php esc_html_e( 'Base on Currency', 'woo-multi-currency' ); ?>
                    : <span><?php echo $wmc_order_base_currency; ?></span>
                </p>
            </div>
            <div id="wmc_order_base_currency">
                <p>
					<?php esc_html_e( 'Currency Rate', 'woo-multi-currency' ); ?>
                    : <span><?php echo $rate; ?></span>
                </p>
            </div>
            <!--			--><?php //} ?>
        </div>
	<?php }


	public function get_formatted_order_total( $formatted_total, $order ) {
		if ( ! get_post_meta( $order->get_id(), 'wmc_order_info', true ) ) {
			return $formatted_total;
		}
		$order_currency  = get_post_meta( $order->get_id(), '_order_currency', true );
		$wmc_order_info  = get_post_meta( $order->get_id(), 'wmc_order_info', true );
		$total           = get_post_meta( $order->get_id(), '_order_total', true );
		$formatted_total = $this->wc_price( $total, array(
			'currency' => $order_currency,
			'decimals' => intval( $wmc_order_info[ $order_currency ]['decimals'] )
		) );

		return $formatted_total;
	}

	public function wc_price( $price, $args = array() ) {

		extract( apply_filters( 'wc_price_args', wp_parse_args( $args, array(
			'ex_tax_label'       => false,
			'currency'           => '',
			'decimal_separator'  => wc_get_price_decimal_separator(),
			'thousand_separator' => wc_get_price_thousand_separator(),
			'decimals'           => 0,
			'price_format'       => get_woocommerce_price_format(),
		) ) ) );

		$negative = $price < 0;
		$price    = apply_filters( 'raw_woocommerce_price', floatval( $negative ? $price * - 1 : $price ) );
		$price    = apply_filters( 'formatted_woocommerce_price', number_format( $price, $decimals, $decimal_separator, $thousand_separator ), $price, $decimals, $decimal_separator, $thousand_separator );

		if ( apply_filters( 'woocommerce_price_trim_zeros', false ) && $decimals > 0 ) {
			$price = wc_trim_zeros( $price );
		}

		$formatted_price = ( $negative ? '-' : '' ) . sprintf( $price_format, '<span class="woocommerce-Price-currencySymbol">' . get_woocommerce_currency_symbol( $currency ) . '</span>', $price );
		$return          = '<span class="woocommerce-Price-amount amount">' . $formatted_price . '</span>';

		if ( $ex_tax_label && wc_tax_enabled() ) {
			$return .= ' <small class="woocommerce-Price-taxLabel tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
		}

		return $return;
	}
}

?>
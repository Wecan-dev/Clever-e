<?php

/*
Class Name: WOOMULTI_CURRENCY_F_Admin_Product
Author: Andy Ha (support@villatheme.com)
Author URI: http://villatheme.com
Copyright 2015-2017 villatheme.com. All rights reserved.
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOOMULTI_CURRENCY_F_Admin_Product {
	protected $settings;
	protected $decimal_separator;

	function __construct() {
		$this->settings = WOOMULTI_CURRENCY_F_Data::get_ins();
		if ( $this->settings->check_fixed_price() ) {
			/*Simple product*/
			add_action( 'woocommerce_product_options_pricing', array( $this, 'simple_price_input' ) );
			/*Variable product*/
			add_action( 'woocommerce_variation_options_pricing', array( $this, 'variation_price_input' ), 10, 3 );
			/*Save data*/
			add_action( 'woocommerce_process_product_meta_simple', array( $this, 'save_meta_simple_product' ) );
			add_action( 'woocommerce_process_product_meta_external', array( $this, 'save_meta_simple_product' ) );

			add_action( 'woocommerce_save_product_variation', array( $this, 'save_meta_product_variation' ), 10, 2 );

			/*Bulk action*/
			add_action( 'admin_enqueue_scripts', array( $this, 'init_scripts' ), 12 );
			add_action( 'woocommerce_variable_product_bulk_edit_actions', array( $this, 'bulk_edit_actions' ) );

		}
	}

	/**
	 * Init list currencies for bulk acction
	 */
	public function init_scripts() {
		$screen       = get_current_screen();
		$screen_id    = $screen ? $screen->id : '';
		if ( in_array( $screen_id, array( 'product', 'edit-product' ) ) ) {
			$currencies       = $this->settings->get_currencies();
			$currency_default = $this->settings->get_default_currency();

			$index = array_search( $currency_default, $currencies );
			unset( $currencies[ $index ] );
			$params = array(
				'currencies' => array_values( $currencies )
			);

			wp_localize_script( 'wc-admin-variation-meta-boxes', 'wmc_params', $params );

			wp_enqueue_script( 'woo-multi-currency-bulk-actions', WOOMULTI_CURRENCY_F_JS . 'woo-multi-currency-bulk-actions.js', array( 'jquery' ) );
		}

	}

	/**
	 * Show bulk action in product edit page
	 */
	public function bulk_edit_actions() {
		$currencies = $this->settings->get_currencies();

		?>
        <optgroup label="<?php esc_attr_e( 'Multi Currency', 'woo-multi-currency' ); ?>">
			<?php if ( count( $currencies ) ) {
				foreach ( $currencies as $currency ) {
					if ( $currency == $this->settings->get_default_currency() ) {
						continue;
					}
					?>
                    <option value="wbs_regular_price-<?php echo esc_attr( $currency ) ?>"><?php echo esc_html__( 'Set regular prices', 'woo-multi-currency' ) . ' (' . $currency . ')'; ?></option>
                    <option value="wbs_sale_price-<?php echo esc_attr( $currency ) ?>"><?php echo esc_html__( 'Set sale prices', 'woo-multi-currency' ) . ' (' . $currency . ')'; ?></option>
				<?php }
			} ?>
        </optgroup>
	<?php }

	/**
	 * Add Regular price, Sale price with Simple product
	 * Working with currency by country
	 */
	public function simple_price_input() {
		global $post;
		$currencies    = $this->settings->get_currencies();
		$regular_price = $this->adjust_fixed_price(json_decode( get_post_meta( $post->ID, '_regular_price_wmcp', true ), true ));
		$sale_price    = $this->adjust_fixed_price(json_decode( get_post_meta( $post->ID, '_sale_price_wmcp', true ), true ));
		foreach ( $currencies as $currency ) {
			if ( $currency != $this->settings->get_default_currency() ) {
				?>
                <div style="border-left: 5px solid #f78080;">
                    <p class="form-field ">
                        <label for="_regular_price_wmcp_<?php esc_attr_e( $currency ); ?>"><?php echo __( 'Regular Price', 'woo-multi-currency' ) . ' (' . $currency . ')'; ?></label>
                        <input id="_regular_price_wmcp_<?php esc_attr_e( $currency ); ?>" class="short wc_input_price"
                               type="text"
                               value="<?php ( isset( $regular_price[ $currency ] ) ) ? esc_attr_e( $regular_price[ $currency ] ) : esc_attr_e( '' ); ?>"
                               name="_regular_price_wmcp[<?php esc_attr_e( $currency ); ?>]">
                    </p>
                    <p class="form-field ">
                        <label for="_sale_price_wmcp_<?php esc_attr_e( $currency ); ?>"><?php echo __( 'Sale Price', 'woo-multi-currency' ) . ' (' . $currency . ')'; ?></label>
                        <input id="_sale_price_wmcp_<?php esc_attr_e( $currency ); ?>" class="short wc_input_price"
                               type="text"
                               value="<?php ( isset( $sale_price[ $currency ] ) ) ? esc_attr_e( $sale_price[ $currency ] ) : esc_attr_e( '' ); ?>"
                               name="_sale_price_wmcp[<?php esc_attr_e( $currency ); ?>]">
                    </p>
                </div>
				<?php
			}
		}
		wp_nonce_field( 'wmc_save_simple_product_currency', '_wmc_nonce' );

	}

	/**
	 * Add Regular price, Sale price with Variation product
	 * Working with currency by country
	 *
	 * @param $loop
	 * @param $variation_data
	 * @param $variation
	 */
	public function variation_price_input( $loop, $variation_data, $variation ) {
		$selected_currencies = $this->settings->get_currencies();
		$regular_price       = $this->adjust_fixed_price(json_decode( get_post_meta( $variation->ID, '_regular_price_wmcp', true ), true ));
		$sale_price          = $this->adjust_fixed_price(json_decode( get_post_meta( $variation->ID, '_sale_price_wmcp', true ), true ));
		foreach ( $selected_currencies as $code ) {
			$_regular_price = $_sale_price = "";
			if ( isset( $regular_price[ $code ] ) ) {
				$_regular_price = $regular_price[ $code ];
			}
			if ( isset( $sale_price[ $code ] ) ) {
				$_sale_price = $sale_price[ $code ];
			}
			if ( $code != $this->settings->get_default_currency() ) {
				?>
                <div>
                    <p class="form-row form-row-first">
                        <label><?php echo esc_html__( 'Regular Price:', 'woo-multi-currency' ) . ' (' . $code . ')'; ?></label>
                        <input type="text" size="5"
                               name="variable_regular_price_wmc[<?php echo $loop; ?>][<?php esc_attr_e( $code ); ?>]"
                               value="<?php echo ( isset( $_regular_price ) ) ? esc_attr( $_regular_price ) : '' ?>"
                               class="wc_input_price wbs-variable-regular-price-<?php echo esc_attr( $code ) ?>"/>
                    </p>
                    <p class="form-row form-row-last">
                        <label><?php echo esc_html__( 'Sale Price:', 'woo-multi-currency' ) . ' (' . $code . ')'; ?> </label>
                        <input type="text" size="5"
                               name="variables_sale_price_wmc[<?php echo $loop; ?>][<?php esc_attr_e( $code ); ?>]"
                               value="<?php echo ( isset( $_sale_price ) ) ? esc_attr( $_sale_price ) : '' ?>"
                               class="wc_input_price wbs-variable-sale-price-<?php echo esc_attr( $code ) ?>"" />
                    </p>
                </div>
				<?php
			}
		}
		wp_nonce_field( 'wmc_save_variable_product_currency', '_wmc_nonce' );

	}

	/**
	 * Save Price by country of Simple Product
	 *
	 * @param $post_id
	 */
	public function save_meta_simple_product( $post_id ) {
		/*Check Permission*/
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}
		/*Check send from product edit page*/
		if ( ! isset( $_POST['_wmc_nonce'] ) || ! wp_verify_nonce( $_POST['_wmc_nonce'], 'wmc_save_simple_product_currency' ) ) {
			return;
		}

		if ( isset( $_POST['_regular_price_wmcp'] ) ) {
			$_regular_price_wmcp = wmc_adjust_fixed_price( wc_clean( $_POST['_regular_price_wmcp'] ) );
			update_post_meta( $post_id, '_regular_price_wmcp', json_encode( $_regular_price_wmcp ) );
		}
		if ( isset( $_POST['_sale_price_wmcp'] ) && ( isset( $_POST['_sale_price'] ) && $_POST['_sale_price'] ) ) {
			$_sale_price_wmcp = wmc_adjust_fixed_price(wc_clean( $_POST['_sale_price_wmcp'] ));
			update_post_meta( $post_id, '_sale_price_wmcp', json_encode( $_sale_price_wmcp ) );
		} else {
			update_post_meta( $post_id, '_sale_price_wmcp', '' );
		}

		$date_to = isset( $_POST['_sale_price_dates_to'] ) ? wc_clean( $_POST['_sale_price_dates_to'] ) : '';

		if ( $date_to && strtotime( $date_to ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
			update_post_meta( $post_id, '_sale_price_wmcp', '' );
		}
	}

	/**
	 * Save Currency by Country of Variation product
	 *
	 * @param $variation_id
	 * @param $i
	 */
	public function save_meta_product_variation( $variation_id, $i ) {
		/*Check Permission*/
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}
		/*Check send from product edit page*/
		if ( ! isset( $_POST['_wmc_nonce'] ) || ! wp_verify_nonce( $_POST['_wmc_nonce'], 'wmc_save_variable_product_currency' ) ) {
			return;
		}

		if ( isset( $_POST['variable_regular_price_wmc'] ) ) {
			$_regular_price_wmcp = wmc_adjust_fixed_price( wc_clean( $_POST['variable_regular_price_wmc'] ) );
			update_post_meta( $variation_id, '_regular_price_wmcp', json_encode( $_regular_price_wmcp[ $i ] ) );
		}
		if ( isset( $_POST['variables_sale_price_wmc'] ) && ( isset( $_POST['variable_sale_price'][ $i ] ) && $_POST['variable_sale_price'][ $i ] ) ) {
			$_sale_price_wmcp = wmc_adjust_fixed_price(wc_clean( $_POST['variables_sale_price_wmc'] ));
			update_post_meta( $variation_id, '_sale_price_wmcp', json_encode( $_sale_price_wmcp[ $i ] ) );
		} else {
			update_post_meta( $variation_id, '_sale_price_wmcp', '' );
		}
		$variable_sale_price_dates_to = wc_clean($_POST['variable_sale_price_dates_to']);
		$date_to                      = ( $variable_sale_price_dates_to[ $i ] );
		if ( $date_to && strtotime( $date_to ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
			update_post_meta( $variation_id, '_sale_price_wmcp', '' );
		}

	}

	/**
	 * @param $fixed_price
	 *  Replace '.' with currently used decimal separator for fixed price input fields
	 * @return array
	 */
    private function adjust_fixed_price($fixed_price){
	    if(!$this->decimal_separator){
	        $this->decimal_separator=stripslashes( get_option( 'woocommerce_price_decimal_sep','.' ) );
        }
        if($this->decimal_separator!=='.'&& is_array( $fixed_price ) && count( $fixed_price ) ){
	        foreach ( $fixed_price as $key => $value ) {
		        $fixed_price[ $key ] = str_replace( '.', $this->decimal_separator, $value );
	        }
        }
        return $fixed_price;
    }

} ?>
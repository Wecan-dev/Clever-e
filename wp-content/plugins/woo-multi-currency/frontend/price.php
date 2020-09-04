<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WOOMULTI_CURRENCY_F_Frontend_Price
 */
class WOOMULTI_CURRENCY_F_Frontend_Price {
	protected $settings;
	protected $price;

	public function __construct() {

		$this->settings = WOOMULTI_CURRENCY_F_Data::get_ins();
		if ( $this->settings->get_enable() ) {
			/*Simple product*/
			add_filter(
				'woocommerce_product_get_regular_price', array(
				$this,
				'woocommerce_product_get_regular_price'
			), 99, 2 );
			add_filter(
				'woocommerce_product_get_sale_price', array(
				$this,
				'woocommerce_product_get_sale_price'
			), 99, 2
			);
			add_filter( 'woocommerce_product_get_price', array( $this, 'woocommerce_product_get_price' ), 99, 2 );
			//
			/*Variable price*/
			add_filter(
				'woocommerce_product_variation_get_price', array(
				$this,
				'woocommerce_product_variation_get_price'
			), 99, 2
			);
			add_filter(
				'woocommerce_product_variation_get_regular_price', array(
				$this,
				'woocommerce_product_variation_get_regular_price'
			), 99, 2
			);
			add_filter(
				'woocommerce_product_variation_get_sale_price', array(
				$this,
				'woocommerce_product_variation_get_sale_price'
			), 99, 2
			);

			/*Variable Parent min max price*/
			add_filter( 'woocommerce_variation_prices', array( $this, 'get_woocommerce_variation_prices' ), 99, 3 );

			/*Pay with Multi Currencies*/
			add_action( 'init', array( $this, 'init' ), 99 );

			/*Approximately*/
			add_filter( 'woocommerce_get_price_html', array( $this, 'add_approximately_price' ), 20, 2 );
			if ( $this->settings->get_price_switcher() ) {
				add_action( 'woocommerce_single_product_summary', array( $this, 'add_price_switcher' ), 20, 2 );
			}
		}
	}

	/**
	 * @param $html_price    default price
	 * @param $a
	 *
	 * @return string
	 */
	public function add_price_switcher() {

		if ( is_admin() || ! is_single() ) {
			return;
		}
		global $post;
		if ( is_object( $post ) && $post->ID && $post->post_type == 'product' && $post->post_status == 'publish' ) {
			$product          = wc_get_product( $post->ID );
			$links            = $this->settings->get_links();
			$current_currency = $this->settings->get_current_currency();
			$country          = $this->settings->get_country_data( $current_currency );
			$list_currencies  = $this->settings->get_list_currencies();
			$class            = array(
				'wmc-price-switcher'
			);

			wp_enqueue_style( 'wmc-flags', WOOMULTI_CURRENCY_F_CSS . 'flags-64.min.css' );

			?>
            <div class="woo-multi-currency <?php echo implode( ' ', $class ) ?>"
                 title="<?php esc_attr_e( 'Please select your currency', 'woo-multi-currency' ) ?>">
                <div class="wmc-currency-wrapper">
                        <span class="wmc-current-currency">
<!--                            <img alt="--><?php //echo esc_attr( $country['name'] ) ?><!--"-->
                            <!--								 src="--><?php //echo WOOMULTI_CURRENCY_F_FLAG . $country['code'] . '.png' ?><!--">-->
                              <i style="zoom: 0.8" alt="<?php echo esc_attr( $country['name'] ) ?>"
                                 class="vi-flag-64 flag-<?php echo strtolower( $country['code'] ) ?> "></i>
                        </span>
                    <div class="wmc-sub-currency">

						<?php

						foreach ( $links as $k => $link ) {
							if ( $current_currency == $k ) {
								continue;
							}
							/*End override*/
							$country = $this->settings->get_country_data( $k );

							?>
                            <div class="wmc-currency">
                                <a rel="nofollow" title="<?php echo esc_attr( $country['name'] ) ?>"
                                   href="<?php echo esc_url( $link ) ?>">
                                    <!--									<img alt="--><?php //echo esc_attr( $country['name'] ) ?><!--"-->
                                    <!--										 src="--><?php //echo WOOMULTI_CURRENCY_F_FLAG . $country['code'] . '.png' ?><!--">-->
                                    <i style="zoom: 0.8" alt="<?php echo esc_attr( $country['name'] ) ?>"
                                       class="vi-flag-64 flag-<?php echo strtolower( $country['code'] ) ?> "></i>
									<?php switch ( $this->settings->get_price_switcher() ) {
										case 2:
											echo '<span class="wmc-price-switcher-code" >' . $k . '</span>';
											break;
										case 3:
											$decimals           = $list_currencies[ $k ]['decimals'];
											$decimal_separator  = wc_get_price_decimal_separator();
											$thousand_separator = wc_get_price_thousand_separator();
											$pos                = $list_currencies[ $k ]['pos'];
											$symbol             = $list_currencies[ $k ]['custom'];
											$symbol             = $symbol ? $symbol : get_woocommerce_currency_symbol( $k );
											switch ( $pos ) {
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

											$price = 0;
											if ( $this->settings->check_fixed_price() ) {

												$product_id    = $product->get_id();
												$product_price = wmc_adjust_fixed_price( json_decode( get_post_meta( $product_id, '_regular_price_wmcp', true ), true ) );
												$sale_price    = wmc_adjust_fixed_price( json_decode( get_post_meta( $product_id, '_sale_price_wmcp', true ), true ) );
												if ( isset( $product_price[ $k ] ) && ! $product->is_on_sale() && $product_price[ $k ] > 0 ) {
													$price = $product_price[ $k ];
												} elseif ( isset( $sale_price[ $k ] ) && $sale_price[ $k ] > 0 ) {
													$price = $sale_price[ $k ];
												}
											}
											if ( ! $price ) {
												$price = $product->get_price( 'edit' );
												$price = number_format( wmc_get_price( wc_get_price_to_display( $product, array(
													'qty'   => 1,
													'price' => $price
												) ), $k ), $decimals, $decimal_separator, $thousand_separator );
											} else {
												$price = number_format( wc_get_price_to_display( $product, array(
													'qty'   => 1,
													'price' => $price
												) ), $decimals, $decimal_separator, $thousand_separator );
											}

											$pos = strpos( $symbol, '#PRICE#' );
											if ( $pos === false ) {
												$formatted_price = sprintf( $format, $symbol, $price );
											} else {
												$formatted_price = str_replace( '#PRICE#', $price, $symbol );
											}
											$max_price = '';
											if ( $product->get_type() == 'variable' ) {
												$price_max = $this->get_variation_max_price( $product, $k );
												if ( $price_max != wmc_get_price( $product->get_price( 'edit' ), $k ) ) {
													$price_max = number_format( wc_get_price_to_display( $product, array(
														'qty'   => 1,
														'price' => $price_max
													) ), $decimals, $decimal_separator, $thousand_separator );
													if ( $pos === false ) {
														$max_price = ' - ' . sprintf( $format, $symbol, $price_max );
													} else {
														$max_price = ' - ' . str_replace( '#PRICE#', $price_max, $symbol );
													}
												}
											}
											echo '<span class="wmc-price-switcher-price">' . $formatted_price . $max_price . '</span>';

									} ?>
                                </a>
                            </div>
						<?php } ?>
                    </div>
                </div>
            </div>
			<?php
		}
	}

	/**
	 * Get Product variation price
	 *
	 * @param $product
	 *
	 * @return int|string
	 */
	protected function get_variation_max_price( $product, $currency_code = false, $raw = false ) {
		$variation_ids = $product->get_visible_children();
		$price_max     = 0;
		foreach ( $variation_ids as $variation_id ) {
			$variation = wc_get_product( $variation_id );

			if ( $variation ) {
				$price = 0;
				if ( ! $currency_code ) {
					$currenct_currency = $this->settings->get_current_currency();
				} elseif ( ! $raw ) {
					$currenct_currency = $currency_code;
				}
				if ( $this->settings->check_fixed_price() && ! $raw ) {
					$product_id    = $variation_id;
					$product_price = wmc_adjust_fixed_price( json_decode( get_post_meta( $product_id, '_regular_price_wmcp', true ), true ) );
					$sale_price    = wmc_adjust_fixed_price( json_decode( get_post_meta( $product_id, '_sale_price_wmcp', true ), true ) );
					if ( isset( $product_price[ $currenct_currency ] ) && ! $product->is_on_sale() && $product_price[ $currenct_currency ] > 0 ) {
						$price = $product_price[ $currenct_currency ];
					} elseif ( isset( $sale_price[ $currenct_currency ] ) && $sale_price[ $currenct_currency ] > 0 ) {
						$price = $sale_price[ $currenct_currency ];
					}
				}

				if ( ! $price ) {
					$price = $variation->get_price( 'edit' );
					if ( ! $raw ) {
						$price = wmc_get_price( $price, $currency_code );
					}
				}
				if ( $price > $price_max ) {
					$price_max = $price;
				}
			}
		}


		return $price_max;
	}

	/**
	 * @param $html_price    default price
	 * @param $a
	 *
	 * @return string
	 */
	public function add_approximately_price( $html_price, $product ) {

		if ( is_admin() ) {
			return $html_price;
		}
		if ( $this->settings->get_auto_detect() == 2 ) {
			if ( '' === $product->get_price() || ! $product->is_in_stock() ) {
				return $html_price;
			}
			if ( ! $this->settings->getcookie( 'wmc_currency_rate' ) || ! $this->settings->getcookie( 'wmc_currency_symbol' ) || ! $this->settings->getcookie( 'wmc_ip_info' ) ) {
				return $html_price;
			}
			$geoplugin_arg = json_decode( base64_decode( $this->settings->getcookie( 'wmc_ip_info' ) ), true );

			$detect_currency_code = isset( $geoplugin_arg['currency_code'] ) ? $geoplugin_arg['currency_code'] : '';
			if ( $detect_currency_code == $this->settings->get_current_currency() ) {
				return $html_price;
			}
			$list_currencies    = $this->settings->get_list_currencies();
			$default_currency   = $this->settings->get_default_currency();
			$decimal_separator  = wc_get_price_decimal_separator();
			$thousand_separator = wc_get_price_thousand_separator();
			if ( $detect_currency_code && isset( $list_currencies[ $detect_currency_code ] ) ) {
				$decimals    = $list_currencies[ $detect_currency_code ]['decimals'];
				$current_pos = $list_currencies[ $detect_currency_code ]['pos'];
			} else {
				$decimals    = $list_currencies[ $default_currency ]['decimals'];
				$current_pos = $list_currencies[ $default_currency ]['pos'];
			}
			$rate   = $this->settings->getcookie( 'wmc_currency_rate' );
			$symbol = $this->settings->getcookie( 'wmc_currency_symbol' );
			switch ( $current_pos ) {
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


			$price = number_format( wc_get_price_to_display( $product, array(
					'qty'   => 1,
					'price' => $product->get_price( 'edit' )
				) ) * $rate, $decimals, $decimal_separator, $thousand_separator );
			$pos   = strpos( $symbol, '#PRICE#' );
			if ( $pos === false ) {
				$formatted_price = sprintf( $format, $symbol, $price );
			} else {
				$formatted_price = str_replace( '#PRICE#', $price, $symbol );
			}
			$max_price = '';
			if ( $product->get_type() == 'variable' ) {
				$price_max = $this->get_variation_max_price( $product, false, true );
				if ( $price_max != $product->get_price( 'edit' ) ) {
					$price_max = number_format( wc_get_price_to_display( $product, array(
							'qty'   => 1,
							'price' => $price_max
						) ) * $rate, $decimals, $decimal_separator, $thousand_separator );
					if ( $pos === false ) {
						$max_price = ' - ' . sprintf( $format, $symbol, $price_max );
					} else {
						$max_price = ' - ' . str_replace( '#PRICE#', $price_max, $symbol );
					}
				}
			}
			$html_price .= '<div class="wmc-approximately">' . esc_html__( 'Approximately', 'woo-multi-currency' ) . ': ' . $formatted_price . $max_price . '</div>';

		}

		return $html_price;
	}

	/**
	 * Check on checkout page
	 */
	public function init() {
		if ( is_ajax() ) {
			return;
		}
		/*Fix UX Builder of Flatsome*/
		if ( isset( $_GET['uxb_iframe'] ) ) {
			return;
		}
		$current_url = isset( $_SERVER['HTTPS'] ) && @$_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
		if ( $_SERVER['SERVER_PORT'] != '80' && $_SERVER['SERVER_PORT'] != '443' ) {
			$current_url .= $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
		} else {
			$current_url .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}
		$root = isset( $_SERVER['PHP_SELF'] ) ? $_SERVER['PHP_SELF'] : '';
		if ( $root ) {
			$root = str_replace( '/index.php', '', $root );
			if ( isset( $_SERVER['REQUEST_URI'] ) ) {
				$path = str_replace( $root, '', $_SERVER['REQUEST_URI'] );
				// Retrieve the current post's ID based on its URL

				$id = get_page_by_path( $path );
				if ( is_object( $id ) ) {
					$id = $id->ID;
				} else {
					$id = url_to_postid( $current_url );;
				}
			} else {
				// Retrieve the current post's ID based on its URL
				$id = url_to_postid( $current_url );
			}

		} else {
			// Retrieve the current post's ID based on its URL
			$id = url_to_postid( $current_url );
		}

		$allow_multi      = $this->settings->get_enable_multi_payment();
		$current_currency = $this->settings->get_current_currency();

		//		$checkout_currency && ! in_array( $current_currency, $checkout_currency_args)
		$old_currency = $this->settings->getcookie( 'wmc_current_currency_old' );
		/*Checkout && Cartpage*/
		if ( ! $allow_multi ) {
			if ( $id == get_option( 'woocommerce_checkout_page_id', 0 ) ) {
				$this->settings->set_current_currency( $this->settings->get_default_currency(), false );
			} elseif ( $old_currency && $old_currency != $current_currency ) {
				$this->settings->set_current_currency( $old_currency, false );
			}
		}
	}


	/**
	 * Variable Parent min max price
	 *
	 * @param $price_arr
	 *
	 * @return array
	 */
	public function get_woocommerce_variation_prices( $price_arr, $product, $for_display ) {
		$temp_arr = $price_arr;
		if ( is_array( $price_arr ) && ! empty( $price_arr ) ) {
			$fixed_price = $this->settings->check_fixed_price();

			foreach ( $price_arr as $price_type => $values ) {
				foreach ( $values as $key => $value ) {

					if ( $fixed_price ) {
						$current_currency = $this->settings->get_current_currency();
						if ( $temp_arr['regular_price'][ $key ] != $temp_arr['price'][ $key ] ) {
							if ( $price_type == 'regular_price' ) {
								$regular_price_wmcp = wmc_adjust_fixed_price( json_decode( get_post_meta( $key, '_regular_price_wmcp', true ), true ) );

								if ( isset( $regular_price_wmcp[ $current_currency ] ) && $regular_price_wmcp[ $current_currency ] > 0 ) {
									$price_arr[ $price_type ][ $key ] = $for_display ? $this->tax_handle( $regular_price_wmcp[ $current_currency ], $product ) : $regular_price_wmcp[ $current_currency ];
								} else {
									$price_arr[ $price_type ][ $key ] = wmc_get_price( $value );
								}
							}

							if ( $price_type == 'price' || $price_type == 'sale_price' ) {
								$sale_price_wmcp = wmc_adjust_fixed_price( json_decode( get_post_meta( $key, '_sale_price_wmcp', true ), true ) );

								if ( isset( $sale_price_wmcp[ $current_currency ] ) && $sale_price_wmcp[ $current_currency ] > 0 ) {
									$price_arr[ $price_type ][ $key ] = $for_display ? $this->tax_handle( $sale_price_wmcp[ $current_currency ], $product ) : $sale_price_wmcp[ $current_currency ];
								} elseif ( $temp_arr['regular_price'][ $key ] != $temp_arr['price'][ $key ] ) {
									$price_arr[ $price_type ][ $key ] = wmc_get_price( $value );
								} else {
									$price_arr[ $price_type ][ $key ] = wmc_get_price( $value );
								}
							}
						} else {
							$regular_price_wmcp = wmc_adjust_fixed_price( json_decode( get_post_meta( $key, '_regular_price_wmcp', true ), true ) );
							if ( isset( $regular_price_wmcp[ $current_currency ] ) && $regular_price_wmcp[ $current_currency ] > 0 ) {
								$price_arr[ $price_type ][ $key ] = $for_display ? $this->tax_handle( $regular_price_wmcp[ $current_currency ], $product ) : $regular_price_wmcp[ $current_currency ];
							} else {
								$price_arr[ $price_type ][ $key ] = wmc_get_price( $value );
							}
						}

					} else {
						$price_arr[ $price_type ][ $key ] = wmc_get_price( $value );
					}
				}
			}
		}


		return $price_arr;
	}

	public function tax_handle( $price, $product ) {
		if ( ! $price ) {
			return $price;
		}

		$data = array( 'qty' => 1, 'price' => $price, );

		return 'incl' === get_option( 'woocommerce_tax_display_shop' ) ? wc_get_price_including_tax( $product, $data ) : wc_get_price_excluding_tax( $product, $data );
	}

	/**
	 * Sale price with product variable
	 */
	public function woocommerce_product_variation_get_sale_price( $price, $product ) {
		if ( ! $price ) {
			return $price;
		}
		$product_id = $product->get_id();
		if ( isset( $this->price[ $product_id ][ $price ] ) ) {
			return $this->price[ $product_id ][ $price ];
		}
		$changes = $product->get_changes();

		if ( $this->settings->check_fixed_price() && ( is_array( $changes ) ) && count( $changes ) < 1 ) {

			$currenct_currency = $this->settings->get_current_currency();
			$product_id        = $product->get_id();
			$product_price     = wmc_adjust_fixed_price( json_decode( get_post_meta( $product_id, '_sale_price_wmcp', true ), true ) );
			if ( isset( $product_price[ $currenct_currency ] ) ) {
				if ( $product_price[ $currenct_currency ] > 0 ) {
					return $this->set_cache( $product_price[ $currenct_currency ], $product_id, $price );
				}
			}
		}

		return $this->set_cache( wmc_get_price( $price ), $product_id, $price );
		//Do nothing to remove prices hash to alway get live price.
	}

	/**
	 * Regular price with product variable
	 */
	public function woocommerce_product_variation_get_regular_price( $price, $product ) {
		if ( ! $price ) {
			return $price;
		}
		$product_id = $product->get_id();
		if ( isset( $this->price[ $product_id ][ $price ] ) ) {
			return $this->price[ $product_id ][ $price ];
		}
		$changes = $product->get_changes();

		if ( $this->settings->check_fixed_price() && ( is_array( $changes ) ) && count( $changes ) < 1 ) {

			$currenct_currency = $this->settings->get_current_currency();
			$product_id        = $product->get_id();
			$product_price     = wmc_adjust_fixed_price( json_decode( get_post_meta( $product_id, '_regular_price_wmcp', true ), true ) );
			if ( isset( $product_price[ $currenct_currency ] ) ) {
				if ( $product_price[ $currenct_currency ] > 0 ) {
					return $this->set_cache( $product_price[ $currenct_currency ], $product_id, $price );

				}
			}
		}

		return $this->set_cache( wmc_get_price( $price ), $product_id, $price );
		//Do nothing to remove prices hash to alway get live price.
	}


	/**
	 * Sale product variable price
	 *
	 * @param $price
	 * @param $product
	 */
	public function woocommerce_product_variation_get_price( $price, $product ) {
		if ( ! $price ) {
			return $price;
		}
		$product_id = $product->get_id();
		if ( isset( $this->price[ $product_id ][ $price ] ) ) {
			return $this->price[ $product_id ][ $price ];
		}
		$changes = $product->get_changes();

		if ( $this->settings->check_fixed_price() && ( is_array( $changes ) ) && count( $changes ) < 1 ) {

			$currenct_currency = $this->settings->get_current_currency();
			$product_id        = $product->get_id();
			$product_price     = wmc_adjust_fixed_price( json_decode( get_post_meta( $product_id, '_regular_price_wmcp', true ), true ) );
			$sale_price        = wmc_adjust_fixed_price( json_decode( get_post_meta( $product_id, '_sale_price_wmcp', true ), true ) );
			if ( isset( $product_price[ $currenct_currency ] ) && ! $product->is_on_sale() ) {
				if ( $product_price[ $currenct_currency ] > 0 ) {
					return $this->set_cache( $product_price[ $currenct_currency ], $product_id, $price );
				}
			} elseif ( isset( $sale_price[ $currenct_currency ] ) ) {
				if ( $sale_price[ $currenct_currency ] > 0 ) {
					return $this->set_cache( $sale_price[ $currenct_currency ], $product_id, $price );

				}
			}
		}

		return $this->set_cache( wmc_get_price( $price ), $product_id, $price );
	}

	/**
	 * Regular price of simple product
	 *
	 * @param $price
	 * @param $product
	 */
	public function woocommerce_product_get_price( $price, $product ) {
		if ( ! $price ) {
			return $price;
		}
		$product_id = $product->get_id();
		if ( isset( $this->price[ $product_id ][ $price ] ) ) {
			return $this->price[ $product_id ][ $price ];
		}
		$changes = $product->get_changes();

		if ( $this->settings->check_fixed_price() && ( is_array( $changes ) ) && count( $changes ) < 1 ) {
			$currenct_currency = $this->settings->get_current_currency();
			$product_id        = $product->get_id();
			$product_price     = wmc_adjust_fixed_price( json_decode( get_post_meta( $product_id, '_regular_price_wmcp', true ), true ) );
			$sale_price        = wmc_adjust_fixed_price( json_decode( get_post_meta( $product_id, '_sale_price_wmcp', true ), true ) );
			if ( isset( $product_price[ $currenct_currency ] ) && ! $product->is_on_sale() ) {
				if ( $product_price[ $currenct_currency ] > 0 ) {
					return $this->set_cache( $product_price[ $currenct_currency ], $product_id, $price );

				}
			} elseif ( isset( $sale_price[ $currenct_currency ] ) ) {
				if ( $sale_price[ $currenct_currency ] > 0 ) {
					return $this->set_cache( $sale_price[ $currenct_currency ], $product_id, $price );

				}
			}
		}

		return $this->set_cache( wmc_get_price( $price ), $product_id, $price );
	}

	/**
	 * @param $price
	 * @param $product
	 *
	 * @return mixed
	 */
	public function woocommerce_product_get_sale_price( $price, $product ) {
		if ( ! $price ) {
			return $price;
		}
		$product_id = $product->get_id();
		if ( isset( $this->price[ $product_id ][ $price ] ) ) {
			return $this->price[ $product_id ][ $price ];
		}
		$changes = $product->get_changes();

		if ( $this->settings->check_fixed_price() && ( is_array( $changes ) ) && count( $changes ) < 1 ) {

			$currenct_currency = $this->settings->get_current_currency();
			$product_id        = $product->get_id();
			$product_price     = wmc_adjust_fixed_price( json_decode( get_post_meta( $product_id, '_sale_price_wmcp', true ), true ) );
			if ( isset( $product_price[ $currenct_currency ] ) ) {
				if ( $product_price[ $currenct_currency ] > 0 ) {
					return $this->set_cache( $product_price[ $currenct_currency ], $product_id, $price );

				}
			}
		}

		return $this->set_cache( wmc_get_price( $price ), $product_id, $price );
	}

	/**
	 * @param $price
	 * @param $product
	 *
	 * @return mixed
	 */
	public function woocommerce_product_get_regular_price( $price, $product ) {
		if ( ! $price ) {
			return $price;
		}
		$product_id = $product->get_id();
		if ( isset( $this->price[ $product_id ][ $price ] ) ) {
			return $this->price[ $product_id ][ $price ];
		}
		$changes = $product->get_changes();

		if ( $this->settings->check_fixed_price() && ( is_array( $changes ) ) && count( $changes ) < 1 ) {

			$currenct_currency = $this->settings->get_current_currency();
			$product_id        = $product->get_id();
			$product_price     = wmc_adjust_fixed_price( json_decode( get_post_meta( $product_id, '_regular_price_wmcp', true ), true ) );
			if ( isset( $product_price[ $currenct_currency ] ) ) {
				if ( $product_price[ $currenct_currency ] > 0 ) {

					return $this->set_cache( $product_price[ $currenct_currency ], $product_id, $price );
				}
			}
		}

		return $this->set_cache( wmc_get_price( $price ), $product_id, $price );
	}

	/**
	 * Set price to global. It will help more speedy.
	 *
	 * @param $price
	 * @param $id
	 *
	 * @return mixed
	 */
	protected function set_cache( $price, $id, $key ) {
		if ( $price && $id && $key ) {
			/*Default decimal is "."*/
			$this->price[ $id ][ $key ] = str_replace( ',', '.', $price );

			return $this->price[ $id ][ $key ];
		} else {
			return $price;
		}
	}
}
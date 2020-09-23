<?php

/**
 * Class WOOMULTI_CURRENCY_F_Frontend_Shortcode
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOOMULTI_CURRENCY_F_Frontend_Shortcode {
	protected $settings;

	public function __construct() {


		$this->settings = WOOMULTI_CURRENCY_F_Data::get_ins();

		$items = $this->settings->get_list_shortcodes();
		foreach ( $items as $k => $item ) {
			if ( $k ) {
				add_shortcode( 'woo_multi_currency_' . $k, array( $this, 'shortcode_' . $k ) );
			}
		}
		add_shortcode( 'woo_multi_currency', array( $this, 'shortcode_woo_multi_currency' ) );
		add_shortcode( 'woo_multi_currency_exchange', array( $this, 'woo_multi_currency_exchange' ) );
		add_shortcode( 'woo_multi_currency_rates', array( $this, 'woo_multi_currency_rates' ) );
		add_filter( 'wmc_shortcode', array( $this, 'replace_shortcode' ), 10, 2 );

	}

	/**
	 * Shortcode Currency selector
	 */
	public function shortcode_woo_multi_currency() {
		$args = array( 'settings' => WOOMULTI_CURRENCY_F_Data::get_ins(), 'shortcode' => 'default' );
		ob_start();
		wmc_get_template( 'woo-multi-currency-selector.php', $args );

		return ob_get_clean();
	}

	/**
	 * Replace shortcode
	 *
	 * @param $shortcode
	 * @param $data
	 *
	 * @return string
	 */
	public function replace_shortcode( $shortcode, $data ) {
		$layout    = isset( $data['layout'] ) ? $data['layout'] : '';
		$flag_size = isset( $data['flag_size'] ) ? $data['flag_size'] : '';
		$attr      = '';
		if ( $flag_size ) {
			$attr = 'flag_size =1';
		}
		if ( $layout ) {
			$shortcode = '[woo_multi_currency_' . $layout . ' ' . $attr . ']';
		}

		return $shortcode;
	}

	/**
	 * Shortcode show list currency rates
	 *
	 * @param      $atts
	 * @param null $content
	 *
	 * @return float|int|string
	 */
	public function woo_multi_currency_rates( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'currencies' => '',
				), $atts
			)
		);
		if ( $currencies ) {
			$currencies = array_map( 'strtoupper', array_map( 'trim', array_filter( explode( ',', $currencies ) ) ) );
		} else {
			$currencies = array();
		}
		$list_currencies     = $this->settings->get_list_currencies();
		$list_currency_codes =
		$currency_default = $this->settings->get_default_currency();
		ob_start(); ?>
        <div class="woo-multi-currency wmc-shortcode wmc-list-currency-rates">
			<?php
			if ( count( $currencies ) ) {
				foreach ( $currencies as $currency ) {
					if ( array_key_exists( $currency, $list_currencies ) ) {
						if ( $currency == $currency_default ) {
							continue;
						} ?>
                        <div class="wmc-currency-rate">
							<?php echo $currency_default . '/' . $currency ?> = <?php

							echo $list_currencies[ $currency ]['rate'];
							?>
                        </div>
					<?php }
				}
			} else {
				foreach ( $list_currencies as $key => $currency ) {
					if ( $key == $currency_default ) {
						continue;
					} ?>
                    <div class="wmc-currency-rate">
						<?php echo $currency_default . '/' . $key ?> = <?php
						echo $currency['rate'];
						?>
                    </div>
				<?php }
			} ?>
        </div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Shortcode exchange
	 *
	 * @param      $atts
	 * @param null $content
	 *
	 * @return float|int|string
	 */
	public function woo_multi_currency_exchange( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'price'    => '',
					'currency' => '',
				), $atts
			)
		);
		if ( $price ) {
			$selected_currencies = $this->settings->get_list_currencies();

			if ( $currency && is_array( $selected_currencies[ $currency ] ) ) {
				$data = $selected_currencies[ $currency ];
				switch ( $data['pos'] ) {
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
				$args = array(
					'currency'     => $currency,
					'decimals'     => $data['decimals'],
					'price_format' => $format
				);

				return wc_price( wmc_get_price( $price, $currency ), $args );

			} else {
				return wc_price( wmc_get_price( $price ) );
			}
		} else {
			return '';
		}
	}

	public function shortcode_plain_vertical_2( $atts, $content = null ) {
		$args = array( 'settings' => WOOMULTI_CURRENCY_F_Data::get_ins(), 'shortcode' => 'listbox_code' );
		ob_start();
		wmc_get_template( 'woo-multi-currency-selector.php', $args );

		return ob_get_clean();
	}

	/**
	 * Shortcode plain horizontal
	 * @return string
	 */
	public function shortcode_plain_horizontal( $atts, $content = null ) {

		extract(
			shortcode_atts(
				array(
					'title' => ''
				), $atts
			)
		);
		ob_start();
		if ( $title ) {
			echo '<h3>' . $title . '</h3>';
		}
		$current_currency = $this->settings->get_current_currency();
		$links            = $this->settings->get_links();
		?>
        <div class="woo-multi-currency wmc-shortcode plain-horizontal">
			<?php foreach ( $links as $k => $link ) {
				if ( $current_currency ) {
					if ( $current_currency == $k ) {
						$class = "wmc-active";
					} else {
						$class = '';
					}
				}

				/*End override*/
				?>
                <div class="wmc-currency <?php echo esc_attr( $class ) ?>">

                    <a rel="nofollow" href="<?php echo $class ? '#' : esc_url( $link ) ?>">

						<?php echo esc_html( $k ) ?>
                    </a>
                </div>
			<?php } ?>
        </div>
		<?php

		$html = ob_get_clean();

		return $html;
	}

	/**
	 * Plain vertical
	 *
	 * @param      $atts
	 * @param null $content
	 *
	 * @return string
	 */
	public function shortcode_plain_vertical( $atts, $content = null ) {

		extract(
			shortcode_atts(
				array(
					'title' => '',
				), $atts
			)
		);
		$links            = $this->settings->get_links();
		$current_currency = $this->settings->get_current_currency();
		ob_start();
		if ( $title ) {
			echo '<h3>' . $title . '</h3>';
		}
		?>
        <div class="woo-multi-currency wmc-shortcode plain-vertical">
            <div class="wmc-currency-wrapper" onclick="">
				<span class="wmc-current-currency">
					<?php echo esc_html( $current_currency ) ?>
				</span>
                <div class="wmc-sub-currency">
					<?php foreach ( $links as $k => $link ) {
						if ( $current_currency == $k ) {
							continue;
						}
						?>
                        <div class="wmc-currency">

                            <a rel="nofollow" href="<?php echo esc_url( $link ) ?>">

								<?php echo esc_html( $k ) ?></a>
                        </div>
					<?php } ?>
                </div>
            </div>
        </div>
		<?php

		$html = ob_get_clean();

		return $html;
	}

	/**
	 * List Flag Horizontal
	 *
	 * @param      $atts
	 * @param null $content
	 *
	 * @return string
	 */
	public function shortcode_layout3( $atts, $content = null ) {
		$this->enqueue_flag_css();
		extract(
			shortcode_atts(
				array(
					'title'     => '',
					'flag_size' => 0.5
				), $atts
			)
		);
		$current_currency = $this->settings->get_current_currency();
		$links            = $this->settings->get_links();
		ob_start();
		if ( $title ) {
			echo '<h3>' . $title . '</h3>';
		}
		$class = '';
		?>
        <div class="woo-multi-currency wmc-shortcode plain-horizontal layout3 <?php echo esc_attr( $class ) ?>">
			<?php foreach ( $links as $k => $link ) {
				if ( $current_currency ) {
					if ( $current_currency == $k ) {
						$class = "wmc-active";
					} else {
						$class = '';
					}
				}
				/*End override*/
				$country = $this->settings->get_country_data( $k );
				?>
                <div class="wmc-currency <?php echo esc_attr( $class ) ?>">

                    <a rel="nofollow" title="<?php echo esc_attr( $country['name'] ) ?>"
                       href="<?php echo $class ? '#' : esc_url( $link ) ?>">
                        <i style="<?php echo $this->fix_style( $flag_size ) ?>"
                           class="vi-flag-64 flag-<?php echo strtolower( $country['code'] ) ?> "></i>
                    </a>
                </div>
			<?php } ?>
        </div>
		<?php

		$html = ob_get_clean();

		return $html;
	}

	public function enqueue_flag_css() {
		if ( WP_DEBUG ) {
			wp_enqueue_style( 'wmc-flags', WOOMULTI_CURRENCY_F_CSS . 'flags-64.css' );
		} else {
			wp_enqueue_style( 'wmc-flags', WOOMULTI_CURRENCY_F_CSS . 'flags-64.min.css' );
		}

	}

	public function fix_style( $flag_size ) {
		$margin_width = ( 60 - 60 * $flag_size ) / 2;
		$margin_heigh = ( 40 - 40 * $flag_size ) / 2;
		$style        = "transform: scale({$flag_size}); margin: -{$margin_heigh}px -{$margin_width}px";

		return $style;
	}

	/**
	 * List Flags vertical
	 *
	 * @param      $atts
	 * @param null $content
	 *
	 * @return string
	 */
	public function shortcode_layout4( $atts, $content = null ) {
		$this->enqueue_flag_css();
		extract(
			shortcode_atts(
				array(
					'title'     => '',
					'flag_size' => 0.5
				), $atts
			)
		);
		$links            = $this->settings->get_links();
		$current_currency = $this->settings->get_current_currency();
		$country          = $this->settings->get_country_data( $current_currency );
		ob_start();
		if ( $title ) {
			echo '<h3>' . $title . '</h3>';
		}
		$class = '';
		?>
        <div class="woo-multi-currency wmc-shortcode plain-vertical layout4 <?php echo esc_attr( $class ) ?>">
            <div class="wmc-currency-wrapper" onclick="">
				<span class="wmc-current-currency">
				  <i style="<?php echo $this->fix_style( $flag_size ) ?>"
                     alt="<?php echo esc_attr( $country['name'] ) ?>"
                     class="vi-flag-64 flag-<?php echo strtolower( $country['code'] ) ?> "> </i>
                    <span class="wmc-current-currency-arrow"> </span>
				</span>
                <div class="wmc-sub-currency">
					<?php foreach ( $links as $k => $link ) {
						if ( $current_currency == $k ) {
							continue;
						}
						/*End override*/
						$country = $this->settings->get_country_data( $k );
						?>
                        <div class="wmc-currency">

                            <a rel="nofollow" title="<?php echo esc_attr( $country['name'] ) ?>"
                               href="<?php echo esc_url( $link ) ?>">

                                <i style="<?php echo $this->fix_style( $flag_size ) ?>"
                                   alt="<?php echo esc_attr( $country['name'] ) ?>"
                                   class="vi-flag-64 flag-<?php echo strtolower( $country['code'] ) ?> "> </i>
                            </a>
                        </div>
					<?php } ?>
                </div>
            </div>
        </div>
		<?php

		$html = ob_get_clean();

		return $html;
	}

	/**
	 * List Flags + Currency code
	 *
	 * @param      $atts
	 * @param null $content
	 *
	 * @return string
	 */
	public function shortcode_layout5( $atts, $content = null ) {
		$this->enqueue_flag_css();
		extract(
			shortcode_atts(
				array(
					'title'     => '',
					'flag_size' => 0.5
				), $atts
			)
		);
		$links            = $this->settings->get_links();
		$current_currency = $this->settings->get_current_currency();
		$country          = $this->settings->get_country_data( $current_currency );
		ob_start();
		if ( $title ) {
			echo '<h3>' . $title . '</h3>';
		}
		$class = '';
		?>
        <div class="woo-multi-currency wmc-shortcode plain-vertical layout5 <?php echo esc_attr( $class ) ?>">
            <div class="wmc-currency-wrapper" onclick="">
				<span class="wmc-current-currency" style="line-height: <?php echo $flag_size * 40 ?>px">
                       <i style="<?php echo $this->fix_style( $flag_size ) ?>"
                          class="vi-flag-64 flag-<?php echo strtolower( $country['code'] ) ?> "> </i>
                      <span>
                        <?php echo esc_html( $current_currency ) ?>
                    </span>
				</span>
                <div class="wmc-sub-currency">
					<?php foreach ( $links as $k => $link ) {
						if ( $current_currency == $k ) {
							continue;
						}

						/*End override*/
						$country = $this->settings->get_country_data( $k );

						?>
                        <div class="wmc-currency">

                            <a rel="nofollow" title="<?php echo esc_attr( $country['name'] ) ?>"
                               href="<?php echo $link ?>">
                                <i style="<?php echo $this->fix_style( $flag_size ) ?>"
                                   class="vi-flag-64 flag-<?php echo strtolower( $country['code'] ) ?> "> </i>
                                <span>
									<?php echo esc_html( $k ) ?>
								</span>
                            </a>
                        </div>
					<?php } ?>
                </div>
            </div>
        </div>
		<?php

		$html = ob_get_clean();

		return $html;
	}

	/**
	 * Shortcode pain horizontal currencies
	 * @return string
	 */
	public function shortcode_layout6( $atts, $content = null ) {

		extract(
			shortcode_atts(
				array(
					'title' => '',
				), $atts
			)
		);
		$links            = $this->settings->get_links();
		$current_currency = $this->settings->get_current_currency();
		ob_start();
		if ( $title ) {
			echo '<h3>' . $title . '</h3>';
		}
		?>
        <div class="woo-multi-currency wmc-shortcode plain-horizontal layout6">
			<?php
			foreach ( $links as $k => $link ) {
				if ( $current_currency ) {
					if ( $current_currency == $k ) {
						$class = "wmc-active";
					} else {
						$class = '';
					}
				}
				?>
                <div class="wmc-currency <?php echo esc_attr( $class ) ?>">

                    <a rel="nofollow" href="<?php echo $class ? '#' : esc_url( $link ) ?>">

						<?php echo esc_html( get_woocommerce_currency_symbol( $k ) ) ?></a>
                </div>
			<?php } ?>
        </div>
		<?php

		$html = ob_get_clean();

		return $html;
	}

	/**
	 * Pain vertical currency symbols
	 *
	 * @param      $atts
	 * @param null $content
	 *
	 * @return string
	 */
	public function shortcode_layout7( $atts, $content = null ) {

		extract(
			shortcode_atts(
				array(
					'title' => '',
				), $atts
			)
		);
		ob_start();
		if ( $title ) {
			echo '<h3>' . $title . '</h3>';
		}
		$current_currency = $this->settings->get_current_currency();
		$symbol           = get_woocommerce_currency_symbol( $current_currency );
		$links            = $this->settings->get_links();
		?>
        <div class="woo-multi-currency wmc-shortcode plain-vertical vertical-currency-symbols">
            <div class="wmc-currency-wrapper" onclick="">
				<span class="wmc-current-currency">
					<?php echo $symbol ?>
				</span>

                <div class="wmc-sub-currency">
					<?php foreach ( $links as $k => $link ) {

						if ( $current_currency == $k ) {
							continue;
						}
						?>
                        <div class="wmc-currency">

                            <a rel="nofollow" href="<?php echo esc_url( $link ) ?>">

								<?php echo get_woocommerce_currency_symbol( $k ); ?></a>
                        </div>
					<?php } ?>
                </div>
            </div>
        </div>
		<?php

		$html = ob_get_clean();

		return $html;
	}

	public function shortcode_layout8( $atts, $content = null ) {
		ob_start();
		$current_currency = $this->settings->get_current_currency();
		$symbol           = get_woocommerce_currency_symbol( $current_currency );
		$links            = $this->settings->get_links();
		$fix_class        = ctype_alpha( substr( $symbol, 0, 2 ) ) && strlen( $symbol ) >= 3 ? 'wmc-fix-font' : '';
		?>
        <div class="woocommerce-multi-currency wmc-shortcode vertical-currency-symbols-circle">
            <div class="wmc-currency-wrapper" onclick="">
				<span class="wmc-current-currency <?php echo esc_attr( $fix_class ) ?>">
					<?php echo esc_html( $symbol ) ?>
				</span>

                <div class="wmc-sub-currency">
					<?php foreach ( $links as $k => $link ) {
						if ( $current_currency == $k ) {
							continue;
						}
						?>
                        <div class="wmc-currency">
							<?php
							$symbol    = esc_html( get_woocommerce_currency_symbol( $k ) );
							$fix_class = ctype_alpha( substr( $symbol, 0, 2 ) ) && strlen( $symbol ) >= 3 ? 'wmc-fix-font' : '';

							$link = esc_url( $link );
							echo "<a rel='nofollow' class='{$fix_class}' href='{$link}'>{$symbol}</a>";
							?>
                        </div>
					<?php } ?>
                </div>
            </div>
        </div>
		<?php

		return ob_get_clean();
	}

	public function shortcode_layout9( $atts, $content = null ) {
		$current_currency     = $this->settings->get_current_currency();
		$links                = $this->settings->get_links();
		$current_currency_pos = array_search( $current_currency, array_keys( $links ), true );
		$left_arr             = array_slice( $links, 0, $current_currency_pos );
		$right_arr            = array_slice( $links, $current_currency_pos );
		ob_start();
		?>
        <div class="woocommerce-multi-currency wmc-shortcode layout9 ">
            <div class="wmc-currency-wrapper">
				<?php
				if ( is_array( $left_arr ) && count( $left_arr ) ) {
					$i = 0;
					foreach ( $left_arr as $code => $link ) {
						$symbol = get_woocommerce_currency_symbol( $code );
						?>
                        <div class="wmc-currency wmc-left" style="z-index: <?php echo esc_attr( $i ++ ) ?>">
							<?php
							$link = esc_url( $link );
							echo "<a rel='nofollow' href='{$link}'>{$symbol}</a>";
							?>
                        </div>
						<?php
					}
				}

				if ( is_array( $right_arr ) && $i = count( $right_arr ) ) {
					foreach ( $right_arr as $code => $link ) {
						$active           = $current_currency == $code ? 'wmc-active' : '';
						$z_index          = $current_currency == $code ? 999 : $i --;
						$align            = $current_currency == $code ? 'wmc-current-currency' : 'wmc-right';
						$symbol           = get_woocommerce_currency_symbol( $code );
						$current_currency = $current_currency == $code && $current_currency != $symbol ? $current_currency : '';
						?>
                        <div class="wmc-currency <?php echo esc_attr( $align ) . ' ' . esc_attr( $active ) ?>" style="z-index: <?php echo esc_attr( $z_index ) ?>">
							<?php
							$link = esc_url( $link );
							echo "<a rel='nofollow' href='{$link}'>{$current_currency} {$symbol}</a>";
							?>
                        </div>
						<?php
					}
				}
				?>
            </div>
        </div>
		<?php

		return ob_get_clean();
	}

}
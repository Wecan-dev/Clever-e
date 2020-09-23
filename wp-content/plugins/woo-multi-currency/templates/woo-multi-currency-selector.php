<?php
/**
 * Show widget
 *
 * This template can be overridden by copying it to yourtheme/woo-currency/woo-currency_widget.php.
 *
 * @author        Cuong Nguyen
 * @package       Woo-currency/Templates
 * @version       1.0
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$currencies       = $settings->get_list_currencies();
$current_currency = $settings->get_current_currency();
$links            = $settings->get_links();
$currency_name    = get_woocommerce_currencies();
?>
<div class="woo-multi-currency shortcode">
    <div class="wmc-currency">
        <select class="wmc-nav"
                onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
			<?php
			foreach ( $links as $code => $link ) {
				$value = esc_url( $link );
				$name  = $shortcode == 'default' ? $currency_name[ $code ] : ( $shortcode == 'listbox_code' ? $code : '' );
				?>
                <option <?php selected( $current_currency, $code ) ?> value="<?php echo $value ?>">
					<?php echo esc_html( $name ) ?>
                </option>
			<?php } ?>

        </select>
    </div>
</div>
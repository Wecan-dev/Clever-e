<?php
/*
Plugin Name: Multi Currency for WooCommerce
Plugin URI: https://palscode.com
Description: Multi Currency for WooCommerce is a prominent currency switcher plugin for WooCommerce. This plugin allows your website or online store visitors to switch to their preferred currency or their country's currency. WC Multi-Currency has the option to select currencies that you want to enable on your online store. Currency rates can be set automatically or manually.
Version: 1.5.1
Author: palscode
Author URI: https://palscode.com
Slug: wc-multi-currency
WC requires at least: 3.3
WC tested up to: 4.1
*/


global $wpdb;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce/woocommerce.php' )  && !is_plugin_active( 'multicurrencypro/multicurrencypro.php' )) {
	include_once 'core/helper_lite.php';
	include_once 'appcore/plugin_helper.php';
	include_once 'appcore/APBDWooComMultiCurrency.php';
	$appwoomc=new APBDWooComMultiCurrency(__FILE__,"1.5");


	$appwoomc->StartPlugin();
}else{
	add_action( 'admin_notices',function (){
		?>
		<div id="message" class="error">
			<p><strong><?php _e("WC Multi Currency",'wc-multi-currency'); ?></strong><?php _e("requires WooCommerce version 3.0.0 or greater.",'wc-multi-currency'); ?></p>
		</div>
		<?php
	});
}


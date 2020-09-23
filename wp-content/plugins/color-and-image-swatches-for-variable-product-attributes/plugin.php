<?php
/*
Plugin Name: Color and Image Swatches for Variable Product Attributes
Plugin URI: http://www.phoeniixx.com
Description: By using our plugin you can generate color and image swatches to display the available product variable attributes like colors, sizes, styles etc.
Version:2.0.6
Text Domain: phoen-visual-attributes
Domain Path: /languages/
Author: Phoeniixx
Author URI: http://www.phoeniixx.com
WC requires at least: 2.6.0
WC tested up to: 3.9.0
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
{

	if (!class_exists('phoen_attr_color_add_Plugin')) {

		class phoen_attr_color_add_Plugin {
			
			private $product_attribute_images;

			public function __construct() {
				
				define('PHOEN_ARBPRPLUGURL',plugins_url(  "/", __FILE__));
				
				add_action( 'admin_menu', array( $this, 'phoe_color_swatches_admin_menu' ) ); //for admin menu

				//require 'classes/phoen-old-product-data-option.php';
				
				//require 'classes/phoen-new-swatches-product-data-tab-option.php'; 
				
				require 'classes/phoen-product-attribute-images-class.php';
				
				require 'classes/phoen-term-class.php';
				
				//$this->product_data_tab = new PHOEN_PRODUCT_CUSTOM_DATA();
				
				add_action('init', array(&$this, 'on_init'));
				
				add_action( 'admin_enqueue_scripts',array(&$this, 'wp_enqueue_color_picker') );
				
				$this->product_attribute_images = new PHOEN_PRODUCT_ATTRIBUTES_SWATCHES('swatches_id', 'attr_image_size');
				
				register_activation_hook(__FILE__, array( $this, 'phoe_color_swatches_activation' ) );
				
				add_action( 'wp_head',array(&$this, 'wp_enqueue_select2') );
				
				add_action( 'admin_head',array(&$this, 'wp_enqueue_kksjsjk') );
				
				add_action( 'wp_ajax_phoen_swatches_add_cart', array( $this, 'phoen_swatches_add_cart' ) );

				add_action( 'wp_ajax_nopriv_phoen_swatches_add_cart', array( $this, 'phoen_swatches_add_cart' ) );
				
				$enable_plugin = get_option('enable_plugin');
				
				if($enable_plugin==1)
				{
					add_action( 'woocommerce_locate_template',array(&$this, 'phoen_locate_template'), 20, 5 );
					
					
					//add_filter( 'woocommerce_loop_add_to_cart_link',  array( $this, 'phoen_variation_dropdown_on_shop_page') );
				}				
				
				
			}
			
			public	function phoe_color_swatches_activation() {

				$color_swatches_setting_values =  get_option( 'color_swatches_setting_values' );
				
				if($color_swatches_setting_values == '')
				{
					$array 	= array();
						
					$array['swatches_style']  = '1';

					update_option('color_swatches_setting_values', $array);
				
					
					
				}
				$enable_plugin = get_option('enable_plugin');
				
				if($enable_plugin==''){
					update_option('enable_plugin', 1);
				}
			}
			
			
			public function phoe_color_swatches_admin_menu() {

				add_menu_page(__('Color Swatches','phoen-visual-attributes'), __('Color Image Swatches','phoen-visual-attributes'), 'manage_options' , 'phoe_color_swatches_menu_pro' , '' , plugin_dir_url( __FILE__ )."assets/images/logo-wp.png" );

				add_submenu_page('phoe_color_swatches_menu_pro', __('Color Image Swatches','phoen-visual-attributes'), __('Color Image Swatches','phoen-visual-attributes'), 'manage_options', 'phoe_color_swatches_menu_pro', array( $this, 'phoe_color_swatches_menu_pro_func' ) );
		
			}
			
			public function phoe_color_swatches_menu_pro_func()
			{
				
					require 'classes/admin_settings.php';
					
			}
			
			public function phoen_locate_template( $template, $template_name, $template_path ) {
				
				global $product;

				if ( strstr( $template, 'variable.php' ) ) {

					//Look within passed path within the theme - this is priority
					
					$template = locate_template(
					
						array(
						
							trailingslashit( 'woocommerce-swatches' ) . 'single-product/variable.php',
							
							$template_name
							
						)
					);

					//Get default template
					
					if ( !$template ) {
						
						$template = plugin_dir_path( __FILE__ ) . 'templates/single-product/variable.php';
						
					}
					
					
				}
				
				return $template;
			}
				
			public function wp_enqueue_color_picker( $hook_suffix ) {
				
				wp_enqueue_style( 'wp-color-picker' );
				
				wp_enqueue_script( 'wp-color-picker');
				
			}
			
			public function on_init() {
				
				global $woocommerce;

				$image_size = get_option('attr_image_size', array());
				
				$size = array();

				$size['width'] = isset($image_size['width']) && !empty($image_size['width']) ? $image_size['width'] : '32';
				$size['height'] = isset($image_size['height']) && !empty($image_size['height']) ? $image_size['height'] : '32';
				$size['crop'] = isset($image_size['crop']) ? $image_size['crop'] : 1;

				$image_size = apply_filters('woocommerce_get_image_size_swatches_image_size', $size);

				add_image_size('attr_image_size', apply_filters('woocommerce_swatches_size_width_default', $image_size['width']), apply_filters('woocommerce_swatches_size_height_default', $image_size['height']), $image_size['crop']);
			} 

	
		public function phoen_swatches_add_cart(){

			if( ! isset( $_REQUEST['action'] ) || $_REQUEST['action'] != 'phoen_swatches_add_cart' || ! isset( $_REQUEST['product_id'] ) || ! isset( $_REQUEST['variation_id'] ) ) {
				die();
			}
			
			$product_id = intval( $_REQUEST['product_id'] );
			
			$variation_id = intval( $_REQUEST['variation_id'] );
			
			$quantity = isset( $_REQUEST['quantity'] ) ? $_REQUEST['quantity'] : 1;

			parse_str( $_REQUEST['attr'], $attributes );

			// get product status
			$product_status    = get_post_status( $product_id );
			
			if( WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $attributes ) && 'publish' === $product_status ) {

				do_action( 'woocommerce_ajax_added_to_cart', $product_id );

				if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
					wc_add_to_cart_message( $product_id );
				}

				// Fragments and mini cart are returned
				WC_AJAX::get_refreshed_fragments();
				
			}
			else {

				// If there was an error adding to the cart, redirect to the product page to show any errors
				$data = array(
					'error'       => true,
					'product_id' => $product_id
				);
			}
			
			wp_send_json( $data );
			die();
		}

			public function wp_enqueue_kksjsjk( $hook_suffix ) {		
			
				wp_enqueue_script('wp-color-picker');
				
				//wp_enqueue_script( 'phoeniixx_alpha_js', PHOEN_ARBPRPLUGURL. "assets/js/wp-color-picker-alpha.js",array('jquery'),'2.0.0',false);
					
				wp_enqueue_style( 'wp-color-picker' );
				
			}
				
			public function wp_enqueue_select2( $hook_suffix ) {
				
				wp_enqueue_style( 'phoeniixx_select2_css', PHOEN_ARBPRPLUGURL. "assets/css/select2.css");		
				
				wp_enqueue_style( 'phoen_font_awesome_lib112','//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');
				
				wp_enqueue_script( 'phoeniixx_select2_js', PHOEN_ARBPRPLUGURL. "assets/js/select2.js",array('jquery'),'2.21.0',false);
				
			}
			
		}
		
	}
		
	$GLOBALS['phoen_attr_color_swatches_add'] = new phoen_attr_color_add_Plugin();
}

?>

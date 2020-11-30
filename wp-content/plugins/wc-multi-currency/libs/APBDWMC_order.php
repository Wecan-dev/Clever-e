<?php
	/**
	 * @since: 06/10/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	
	class APBDWMC_order {
		/** @var APBDWMC_general $core */
		public $core;
		function __construct() {
			$this->core = APBDWMC_general::GetModuleInstance();
			add_filter( 'woocommerce_checkout_create_order', [$this,'before_checkout_create_order'], 10, 2 );
			
			
			add_action( 'manage_shop_order_posts_custom_column', [ $this, '_wc_currency_columns'], 2 );
			//add_filter( 'woocommerce_get_formatted_order_total', array( $this, 'get_formatted_order_total' ), 10, 2 );
			add_action( 'add_meta_boxes', [$this,'add_meta_box'] );
		}
		function add_meta_box(){
			add_meta_box( 'apbd_wmc_meta', $this->core->__( 'Currency Information' ), [$this, '_wc_order_meta' ], 'shop_order', 'side', 'default' );
		}
		function before_checkout_create_order( $order, $data ) {
			$base=$this->core->getBaseCurrency();
			$obj=new stdClass();
			$obj->code= $order->get_currency();
			$orderCurrency=$this->core->getCurrencyByCode($obj->code);
			$obj->rate=$orderCurrency->rate;
			$obj->base_code="Unknown";
			if(!empty($base)){
				$obj->base_code=$base->code;
			}
			$obj->ex_fee=$orderCurrency->ex_fee;
			$obj->symbol=!empty($orderCurrency->custom_symbol)?$orderCurrency->custom_symbol:APBD_get_mc_currency_symbols( $obj->code );;
			file_put_contents(WP_CONTENT_DIR."/currency.log",print_r($obj,true));
			//$order=new WC_Order();
			//$order->get_curr();
			$order->update_meta_data( '_apbd_wmc', $obj);
		}
		
		function _wc_order_meta($post ) {
			$order = new WC_Order( $post->ID );
			//echo $order
			$order_currency = get_post_meta( $order->get_id(), '_order_currency', true );
			$currency_info = get_post_meta( $post->ID, '_apbd_wmc', true );
			
				?>
				<table class="apbd-cur-info">
					<tr>
						<th><?php $this->core->_e( "Currency" ); ?></th>
						<th>:</th>
						<td><?php echo esc_attr($order_currency); ?></td>
					</tr>
				<?php if(!empty($currency_info) ){
					if((empty($currency_info->base_code) || $currency_info->base_code!=$order_currency)) {
						?>
						<tr>
							<th><?php $this->core->_e( "Exchage Rate" ); ?></th>
							<th>:</th>
							<td>
								<?php
									echo esc_attr($currency_info->rate+$currency_info->ex_fee);
									if($currency_info->ex_fee>0){
										?>
										<small> (<?php $this->core->_e("Rate %.2f + Exchange Fee %.2f",$currency_info->rate,$currency_info->ex_fee) ; ?>)</small>
									<?php } ?>
							</td>
						</tr>
						<?php
						if(!empty($currency_info->base_code)){
							?>
							<tr>
								<th><?php $this->core->_e( "Based On Currency" ); ?></th>
								<th>:</th>
								<td>
									<?php	echo esc_attr($currency_info->base_code);?>
								</td>
							</tr>
						<?php	}
					}elseif(!empty($currency_info->base_code) && $currency_info->base_code==$order_currency){
						?>
						<tr>
							<th colspan="3"><?php $this->core->_e( "It was base currency" ); ?></th>
						</tr>
						<?php
					}else{
						?>
						<tr>
							<th colspan="3">Don't know why</th>
						</tr>
						<?php
					}
				}else{
					?>
					<tr>
						<th colspan="3" class="apbd-wmc-ord-notice">
							<hr>
							<?php $this->core->_e( "The %s was disabled, when the order has been created",'<span class="apbd-wmc-product-title">'.$this->core->kernelObject->pluginName.'</span>' ); ?></th>
					</tr>
					<?php
				}?>
				
				</table>
				<?php
			
		
		}
		function _wc_currency_columns($col){
			global $post, $the_order;
			if ( empty( $the_order ) || $the_order->get_id() !== $post->ID ) {
				$the_order = wc_get_order( $post->ID );
			}
			if ( $col == 'order_total' ) { ?>
				<div class="apbd-wmc-order-currency">
					<?php echo esc_html( $this->core->__('Currency: %s', get_post_meta( $the_order->get_id(), '_order_currency', true ))); ?>
				</div>
			<?php }
		}
	}
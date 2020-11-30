<?php
	/**
	 * @since: 05/07/2020
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	
	class wc_report_currencywise extends WC_Admin_Report {
		
		/**
		 * Output the report.
		 */
		public function output_report() {
			$ranges = array(
				'year'         => __( 'Year', 'woocommerce' ),
				'last_month'   => __( 'Last month', 'woocommerce' ),
				'month'        => __( 'This month', 'woocommerce' ),
			);
			
			$current_range = ! empty( $_GET['range'] ) ? sanitize_text_field( $_GET['range'] ) : 'month';
			
			if ( ! in_array( $current_range, array( 'custom', 'year', 'last_month', '7day' ) ) ) {
				$current_range = 'month';
			}
			
			$this->check_current_range_nonce( $current_range );
			$this->calculate_current_range( $current_range );
			
			$hide_sidebar = true;
			
			include( WC()->plugin_path() . '/includes/admin/views/html-report-by-date.php' );
		}
		public function getFormat($position){
			$currency_pos = strtolower($position);
			switch ( $currency_pos ) {
				case 'left' :
					return '%1$s%2$s';
					break;
				case 'right' :
					return '%2$s%1$s';
					break;
				case 'left_space' :
					return '%1$s&nbsp;%2$s';
					break;
				case 'right_space' :
					return '%2$s&nbsp;%1$s';
					break;
				default:
					return '%1$s%2$s';
			}
        }
		/**
		 * Get the main chart.
		 */
		public function get_main_chart() {
			global $wpdb;
			$module=APBDWMC_general::GetModuleInstance();
			$query_data = array(
				'ID' => array(
					'type'     => 'post_data',
					'function' => 'COUNT',
					'name'     => 'total_orders',
					'distinct' => true,
				),
				'_order_currency' => array(
					'type'      => 'meta',
					'function'  => '',
					'name'      => 'currency'
				),
				'_order_total'   => array(
					'type'      => 'meta',
					'function'  => 'SUM',
					'name'      => 'order_total'
				),
			);
			
			$sales_by_country_orders = $this->get_order_report_data( array(
				'data'                  => $query_data,
				'query_type'            => 'get_results',
				'group_by'              => 'currency',
				'filter_range'          => true,
				'order_types'           => wc_get_order_types( 'sales-reports' ),
				'order_status'          => array( 'completed' ),
				'parent_order_status'   => false,
			) );
			?>
			<table class="wp-list-table widefat fixed striped">
				<thead>
				<tr>
					<th><strong><?php $module->_e("Currency") ; ?></strong></th>
					<th><strong><?php $module->_e("Number Of Orders") ; ?></strong></th>
					<th><strong><?php $module->_e("Sales") ; ?></strong></th>
				</tr>
				</thead>
				<tbody>
				<?php
                    if(!empty($sales_by_country_orders)) {
	                    foreach ( $sales_by_country_orders as $order ) {
		                    $currency = $module->getCurrencyByCode( $order->currency );
		
		                    ?>
                            <tr>
                                <td><?php echo $order->currency; ?></td>
                                <td><?php echo $order->total_orders; ?></td>
                                <td><?php
					                    if ( empty( $currency ) ) {
						                    echo wc_price( $order->order_total, [ 'currency' => $order->currency ] );
					                    } else {
						                    echo wc_price( $order->order_total,
							                    [
								                    'currency'           => $currency->code,
								                    'decimal_separator'  => wc_get_price_decimal_separator(),
								                    'thousand_separator' => wc_get_price_thousand_separator(),
								                    'decimals'           => $currency->dec_num,
								                    'price_format'       => $this->getFormat( $currency->position )
							                    ] );
					                    } ?>
                                </td>
                            </tr>
	                    <?php }
                    }else{
                        ?>
                        <tr class="no-items"><td class="colspanchange" colspan="3"><?php $module->_e("No currency data found") ; ?></td></tr>
                        
                        <?php
                    }
                    ?>
                <tfoot>
                <tr>
                    <th><strong><?php $module->_e("Currency") ; ?></strong></th>
                    <th><strong><?php $module->_e("Number Of Orders") ; ?></strong></th>
                    <th><strong><?php $module->_e("Sales") ; ?></strong></th>
                </tr>
                </tfoot>
				</tbody>
			</table>
			<?php
		}
	}
<?php
	/**
	 * @since: 07/09/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	if ( ! function_exists('APBD_get_mc_currency_symbols')) {
		function APBD_get_mc_currency_symbols($code='') {
			$codes=apply_filters(
				'woocommerce_currency_symbols',
				array(
					'AED' => '&#x62f;.&#x625;',
					'AFN' => '&#x60b;',
					'ALL' => 'L',
					'AMD' => 'AMD',
					'ANG' => '&fnof;',
					'AOA' => 'Kz',
					'ARS' => '&#36;',
					'AUD' => '&#36;',
					'AWG' => 'Afl.',
					'AZN' => 'AZN',
					'BAM' => 'KM',
					'BBD' => '&#36;',
					'BDT' => '&#2547;&nbsp;',
					'BGN' => '&#1083;&#1074;.',
					'BHD' => '.&#x62f;.&#x628;',
					'BIF' => 'Fr',
					'BMD' => '&#36;',
					'BND' => '&#36;',
					'BOB' => 'Bs.',
					'BRL' => '&#82;&#36;',
					'BSD' => '&#36;',
					'BTC' => '&#3647;',
					'BTN' => 'Nu.',
					'BWP' => 'P',
					'BYR' => 'Br',
					'BYN' => 'Br',
					'BZD' => '&#36;',
					'CAD' => '&#36;',
					'CDF' => 'Fr',
					'CHF' => '&#67;&#72;&#70;',
					'CLP' => '&#36;',
					'CNY' => '&yen;',
					'COP' => '&#36;',
					'CRC' => '&#x20a1;',
					'CUC' => '&#36;',
					'CUP' => '&#36;',
					'CVE' => '&#36;',
					'CZK' => '&#75;&#269;',
					'DJF' => 'Fr',
					'DKK' => 'DKK',
					'DOP' => 'RD&#36;',
					'DZD' => '&#x62f;.&#x62c;',
					'EGP' => 'EGP',
					'ERN' => 'Nfk',
					'ETB' => 'Br',
					'EUR' => '&euro;',
					'FJD' => '&#36;',
					'FKP' => '&pound;',
					'GBP' => '&pound;',
					'GEL' => '&#x20be;',
					'GGP' => '&pound;',
					'GHS' => '&#x20b5;',
					'GIP' => '&pound;',
					'GMD' => 'D',
					'GNF' => 'Fr',
					'GTQ' => 'Q',
					'GYD' => '&#36;',
					'HKD' => '&#36;',
					'HNL' => 'L',
					'HRK' => 'kn',
					'HTG' => 'G',
					'HUF' => '&#70;&#116;',
					'IDR' => 'Rp',
					'ILS' => '&#8362;',
					'IMP' => '&pound;',
					'INR' => '&#8377;',
					'IQD' => '&#x639;.&#x62f;',
					'IRR' => '&#xfdfc;',
					'IRT' => '&#x062A;&#x0648;&#x0645;&#x0627;&#x0646;',
					'ISK' => 'kr.',
					'JEP' => '&pound;',
					'JMD' => '&#36;',
					'JOD' => '&#x62f;.&#x627;',
					'JPY' => '&yen;',
					'KES' => 'KSh',
					'KGS' => '&#x441;&#x43e;&#x43c;',
					'KHR' => '&#x17db;',
					'KMF' => 'Fr',
					'KPW' => '&#x20a9;',
					'KRW' => '&#8361;',
					'KWD' => '&#x62f;.&#x643;',
					'KYD' => '&#36;',
					'KZT' => 'KZT',
					'LAK' => '&#8365;',
					'LBP' => '&#x644;.&#x644;',
					'LKR' => '&#xdbb;&#xdd4;',
					'LRD' => '&#36;',
					'LSL' => 'L',
					'LYD' => '&#x644;.&#x62f;',
					'MAD' => '&#x62f;.&#x645;.',
					'MDL' => 'MDL',
					'MGA' => 'Ar',
					'MKD' => '&#x434;&#x435;&#x43d;',
					'MMK' => 'Ks',
					'MNT' => '&#x20ae;',
					'MOP' => 'P',
					'MRU' => 'UM',
					'MUR' => '&#x20a8;',
					'MVR' => '.&#x783;',
					'MWK' => 'MK',
					'MXN' => '&#36;',
					'MYR' => '&#82;&#77;',
					'MZN' => 'MT',
					'NAD' => '&#36;',
					'NGN' => '&#8358;',
					'NIO' => 'C&#36;',
					'NOK' => '&#107;&#114;',
					'NPR' => '&#8360;',
					'NZD' => '&#36;',
					'OMR' => '&#x631;.&#x639;.',
					'PAB' => 'B/.',
					'PEN' => 'S/',
					'PGK' => 'K',
					'PHP' => '&#8369;',
					'PKR' => '&#8360;',
					'PLN' => '&#122;&#322;',
					'PRB' => '&#x440;.',
					'PYG' => '&#8370;',
					'QAR' => '&#x631;.&#x642;',
					'RMB' => '&yen;',
					'RON' => 'lei',
					'RSD' => '&#x434;&#x438;&#x43d;.',
					'RUB' => '&#8381;',
					'RWF' => 'Fr',
					'SAR' => '&#x631;.&#x633;',
					'SBD' => '&#36;',
					'SCR' => '&#x20a8;',
					'SDG' => '&#x62c;.&#x633;.',
					'SEK' => '&#107;&#114;',
					'SGD' => '&#36;',
					'SHP' => '&pound;',
					'SLL' => 'Le',
					'SOS' => 'Sh',
					'SRD' => '&#36;',
					'SSP' => '&pound;',
					'STN' => 'Db',
					'SYP' => '&#x644;.&#x633;',
					'SZL' => 'L',
					'THB' => '&#3647;',
					'TJS' => '&#x405;&#x41c;',
					'TMT' => 'm',
					'TND' => '&#x62f;.&#x62a;',
					'TOP' => 'T&#36;',
					'TRY' => '&#8378;',
					'TTD' => '&#36;',
					'TWD' => '&#78;&#84;&#36;',
					'TZS' => 'Sh',
					'UAH' => '&#8372;',
					'UGX' => 'UGX',
					'USD' => '&#36;',
					'UYU' => '&#36;',
					'UZS' => 'UZS',
					'VEF' => 'Bs F',
					'VES' => 'Bs.S',
					'VND' => '&#8363;',
					'VUV' => 'Vt',
					'WST' => 'T',
					'XAF' => 'CFA',
					'XCD' => '&#36;',
					'XOF' => 'CFA',
					'XPF' => 'Fr',
					'YER' => '&#xfdfc;',
					'ZAR' => '&#82;',
					'ZMW' => 'ZK',
				) );
			
			if(!empty($code)){
				return isset($codes[$code])? $codes[ $code ]:"";
			}
			return $codes;
		}
	}
	if ( ! function_exists('APBD_mc_get_currency_html_options')) {
		/**
		 * @return APBDWMC_currency_item|array
		 */
		function APBD_mc_get_currency_html_options( $selected = '' ) {
			$currencies=get_woocommerce_currencies();
			$currency_symbols=APBD_get_mc_currency_symbols();
			
			
			//$curItems = getCurrencyItems();
			foreach ( $currencies as $code=>$name ) {
				?>
                <option value="<?php echo $code; ?>" <?php echo $selected == $code ? " selected " : ""; ?>><?php echo $name.(!empty($currency_symbols[$code])?' ('.$currency_symbols[$code].')':''); ?></option>
				<?php
			}
		}
	}
	if ( ! function_exists('APBD_get_mc_currency_row'))
	{
		/**
		 * @param APBDWC_currency_item $currencyData
		 */
		function APBD_get_mc_currency_row($currencyData){
		    $app=APBDWooComMultiCurrency::GetInstance();
		    if(!empty($currencyData->code)){
			    $currencySymbol = APBD_get_mc_currency_symbols( $currencyData->code );
            }else {
			    $currencySymbol = APBD_get_mc_currency_symbols( 'USD' );
		    }
			?>
			<tr id="tr_<?php echo $currencyData->id; ?>" data-currency-id="<?php echo $currencyData->id; ?>" class="apbd-cur-container">
				<td>
                <h6 class="title"><?php $app->_e("Default"); ?></h6>
					<div class="wrap wrap-default">
						<div class="ht-mcs-radio">
							<input class="apbd-mc-default" id="mc-default-<?php echo $currencyData->id; ?>" data-msg="<?php $app->_e("Are you sure to change the default currency? If yes then your need to review rate of other currency"); ?>" data-title="<?php $app->_e("Confirmation") ; ?>" name="is_default" value="<?php echo $currencyData->id; ?>" type="radio" <?php echo $currencyData->is_default?' checked ':''; ?>>
							<label for="mc-default-<?php echo $currencyData->id; ?>" title="Select Default"><span class="sr-only"><?php $app->_e("check one"); ?></span></label>
						</div>
					</div>
				</td>
				<td>
					<h6 class="title"><?php $app->_e("Show"); ?></h6>
					<div class="wrap wrap-show-hide">
						<select name="mc_is_show" class="apbd-cur-input">
							<option value="Yes"><?php $app->_e("Show"); ?></option>
							<option value="No"><?php $app->_e("Hide"); ?></option>
						</select>
					</div>
				</td>
				<td>
					<h6 class="title"><?php $app->_e("Currency"); ?></h6>
					<div class="wrap wrap-currency">
						<select class="select-currency apbd-cur-input" name="mc_code" title="<?php $app->_e("Select Currency"); ?>">
                            <?php
                                APBD_GetHTMLOption("",$app->__("Select"));
                                APBD_mc_get_currency_html_options($currencyData->code);?>
                            
						</select>
					</div>
				</td>
				<td>
					<h6 class="title"><?php $app->_e("Position"); ?></h6>
					<div class="wrap wrap-position">
						<select class="select-position apbd-cur-input"  name="mc_position" title="Select symbol position">
                            <?php APBD_GetHTMLOption("left",$app->__("Left %s99",$currencySymbol),$currencyData->position); ?>
                            <?php APBD_GetHTMLOption("right",$app->__("Right 99%s",$currencySymbol),$currencyData->position); ?>
                            <?php APBD_GetHTMLOption("left_space",$app->__("Left with space %s 99",$currencySymbol),$currencyData->position); ?>
                            <?php APBD_GetHTMLOption("right_space",$app->__("Left with space 99 %s",$currencySymbol),$currencyData->position); ?>
						</select>
					</div>
				</td>
				<td>
					<h6 class="title"><?php $app->_e("Rate"); ?></h6>
					<div class="wrap wrap-fee">
                    <input type="number" class="apbd-cur-input input-field text-center" name="mc_rate" step="0.1" placeholder="Rate" value="<?php echo $currencyData->rate; ?>" title="<?php $app->_e("Exchange Rate"); ?>">
						<button class="btn btn-info btn-box apbd-mc-up-rate" title="Update Rate"><i class="fa fa-refresh"></i></button>
					</div>
				</td>
				<td>
					<h6 class="title"><?php $app->_e("Exchange Fee"); ?></h6>
					<div class="wrap wrap-rate">
						<input type="number"  class="apbd-cur-input input-field text-center" name="mc_ex_fee" step="0.1" placeholder="<?php $app->_e("Ex.Fee"); ?>" value="<?php echo $currencyData->ex_fee; ?>" title="<?php $app->_e("Exchange Fee"); ?>">
					
					</div>
				</td>
				<td>
					<h6 class="title"><?php $app->_e("Decimals"); ?></h6>
					<div class="wrap wrap-decimals"><input class="apbd-cur-input input-field text-center" name="mc_dec_num" type="number"  value="<?php echo $currencyData->dec_num; ?>" title="<?php $app->_e("Decimals"); ?>"></div>
				</td>
				<td>
					<h6 class="title"><?php $app->_e("Custom Symbol"); ?></h6>
					<div class="wrap wrap-rate"><input class="apbd-cur-input input-field text-center" type="text" name="mc_custom_symbol" value="<?php echo $currencyData->custom_symbol; ?>" placeholder="" title="<?php $app->_e("Custom Symbol"); ?>"></div>
				</td>
				<td>
					<h6 class="title"><?php $app->_e("Actions"); ?></h6>
					<div class="wrap wrap-action">
						<div class=" flex-nowrap">
							<a href="<?php echo APBDWMC_general::GetModuleActionUrl("delete-currency",["id"=>$currencyData->id]); ?>" data-msg="<?php $app->_e("Are you sure to delete?"); ?>" data-on-complete="APPSBDAPPJS_MC.General.OnRowDeleted" class="btn btn-danger btn-box ConfirmAjaxWR" title="<?php $app->_e("Remove") ; ?>"><i class="fa fa-trash-o"></i></a>
						</div>
					</div>
				</td>
			</tr>
			<?php
		}
	}
	
	if ( ! function_exists('getCurrencyCountryRow'))
	{
		/**
		 * @param APBDWC_currency_item $currencyData
		 */
		function getCurrencyCountryRow($currencyData,$selected=[]){
			$app=APBDWooComMultiCurrency::GetInstance();
			if(empty($currencyData->code)){
				$currencyName = $app->__("Not selected yet");
				$currencySymbol = "";
			}else {
				$currencies   = get_woocommerce_currencies();
				$currencyName = ! empty( $currencies[ $currencyData->code ] ) ? $currencies[ $currencyData->code ] : $currencyData->code;
				
				if ( ! empty( $currencyData->code ) ) {
					$currencySymbol = APBD_get_mc_currency_symbols( $currencyData->code );
				} else {
					$currencySymbol = APBD_get_mc_currency_symbols( 'USD' );
				}
			}
			$countries=WC()->countries->countries;
			?>
            <tr id="cloc-<?php echo $currencyData->id; ?>">
                <td class="align-top" style="width: 30%">
                    <h6 class="title"><?php $app->_e("Currency"); ?></h6>
                    <div class="wrap wrap-currency apbd-cur-title">
                        <?php
                        if(empty($currencyData->code)){
	                        echo $currencyName;
                        }else {
                            echo $currencyData->code . " - " . $currencyName . " (" . $currencySymbol . ")";
                        }?>
                    </div>
                </td>
                <td>
                    <h6 class="title"><?php $app->_e("Countries"); ?></h6>
                    <div class="">
                        <select class="select-position countries-container apbd-app-multi-select" name="currency_location[<?php echo $currencyData->id; ?>][]" multiple>
                           <?php foreach ( $countries as $ccode=>$country ) {
                                ?>
                                <option value="<?php echo $ccode; ?>" <?php echo in_array($ccode,$selected)?' selected ="selected" ':""; ?>><?php echo $country; ?></option>
                                <?php
                           } ?>
                        </select>
                        <div class="mt-1">
                            <button class="btn btn-sm btn-danger btn-icon-left mr-1 apbd-empty-country"><i class="fa fa-trash-o"></i><?php $app->_e("Empty") ?></button>
                            <button class="btn btn-sm btn-secondary btn-icon-left apbd-all-country"><i class="fa fa-star-o"></i><?php $app->_e("Select All Country") ?></button>
                        </div>
                        <div class="mt-3 form-inline">
                            <div class="form-group mt-3">
                                <div class="ht-mcs-switcher-wrap inline">
                                    <button class="ml-2 btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $app->_e("Unlock It") ; ?></button>
                                </div>
                                <label for="ht-is-dont-hide-cur-<?php echo $currencyData->id; ?>" class="ml-3 text-bold"><?php $app->_e("Do not hide this currency in dropdown or country list"); ; ?></label>

                            </div>
                        </div>
                    </div>
                </td>
            </tr>
			<?php
		}
	}
	
	if ( ! function_exists('getCurrencyPaymentGatewayRow'))
	{
		/**
		 * @param APBDWC_currency_item $currencyData
		 * @param WC_Payment_Gateway[] $gateways
		 * @param array $selected
		 */
		function getCurrencyPaymentGatewayRow($currencyData,$gateways=[],$selected=[],$non_save_mode=true){
			$app=APBDWooComMultiCurrency::GetInstance();
			
			if(empty($currencyData->code)){
				$currencyName = $app->__("Not selected yet");
				$currencySymbol = "";
			}else {
				$currencies   = get_woocommerce_currencies();
				$currencyName = ! empty( $currencies[ $currencyData->code ] ) ? $currencies[ $currencyData->code ] : $currencyData->code;
				
				if ( ! empty( $currencyData->code ) ) {
					$currencySymbol = APBD_get_mc_currency_symbols( $currencyData->code );
				} else {
					$currencySymbol = APBD_get_mc_currency_symbols( 'USD' );
				}
			}
			?>
            <tr id="cur-gtw-<?php echo $currencyData->id; ?>">
                <td class="align-top">
                    <h6 class="title"><?php $app->_e("Currency"); ?></h6>
                    <div class="wrap wrap-currency app-gt-cur">
                        <?php
                            if(empty($currencyData->code)){
	                        echo $currencyName;
                        }else {
	                        echo $currencyData->code . " - " . $currencyName . " (" . $currencySymbol . ")";
                        }?>
                    </div>
                </td>
                <td>
                    <h6 class="title"><?php $app->_e("Payment Gateway"); ?></h6>
                    <div class="wrap-position">
                        <div class="ht-mcs-checkbox-wrap inline">
                            <?php foreach ( $gateways as $gtid=>$gateway ) {
                                if(!(strtolower($gateway->enabled)=='yes') && !$non_save_mode){
                                    continue;
                                }
                               $isCheckedStr=in_array($gtid,$selected)?' checked ':'';
                                ?>
                                <div class="ht-mcs-checkbox">
                                    <input id="<?php echo $currencyData->id."_".$gtid; ?>" type="checkbox" <?php echo $non_save_mode?'  ' :' name="gateways['.$currencyData->id.'][]" ' ?>>
                                    <label for="<?php echo $currencyData->id."_".$gtid; ?>"><span><?php echo $gateway->title; ; ?></span></label>
                                </div>
                                <?php
                            } ?>
                        </div>
                    </div>
                </td>
            </tr>
			<?php
		}
	}
	
	if ( ! function_exists('APBD_get_floating_li'))
	{
		
		function APBD_get_floating_li($currency,$_default_mc_cur,$currencySymbol,$current_url,$plugin_file,$isReturn=false){
		    ob_start();
		    ?>
            <li class="<?php echo !empty($_default_mc_cur->code)&& $currency->code==$_default_mc_cur->code?" active ":"";?>">
                <a href="<?php echo $current_url; ?>?_amc-currency=<?php echo esc_attr($currency->code);?>"><span class="icon"><img src="<?php echo plugins_url("images/flags/circle/".strtoupper(esc_attr($currency->code)).'.png',$plugin_file); ?>" alt=""></span><span class="text"><?php echo esc_attr($currency->code);?>(<?php echo esc_attr($currencySymbol); ?>)</span></a>
            </li>
		    <?php
            if($isReturn){
                return ob_get_clean();
            }
            echo ob_get_clean();
        }
	}
	if ( ! function_exists('APBD_current_url'))
	{
		function APBD_current_url(){
			global $wp;
			return home_url( $wp->request );
		}
	}
	
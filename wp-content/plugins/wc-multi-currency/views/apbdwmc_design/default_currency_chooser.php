<?php /** @var APBDWMC_design $this */
	//echo $this->GetActionUrl("get-rate");
    $widpos=$this->GetOption("wid_pos","L");
    if($widpos!="N"){
?>
        <!--Float Widget Start-->
        <div class="ht-mcs-widget ht-mcs-float-widget <?php echo $widpos=="R"|| $widpos=="V"?"":"left"; ?> <?php echo ($widpos=="B"|| $widpos=="V"?" p-bottom ":""); ?>">
            <ul>
	            <?php
		            $current_url =APBD_current_url();
		            $currencies=APBDWMC_general::GetModuleInstance()->getLocalizeCurrencies();
		            $_default_mc_cur=APBDWMC_general::GetModuleInstance()->active_currency;
		            $currencies_name   = get_woocommerce_currencies();
		            $symbols=APBD_get_mc_currency_symbols();
		            $lis="";
		            foreach ( $currencies as $currency ) {
			            if(!$currency->is_show){continue;}
			            $currencyName = ! empty( $currencies_name[ $currency->code ] ) ? $currencies_name[ $currency->code ] : $currency->code;
			            $currencySymbol=!empty($currency->custom_symbol)?$currency->custom_symbol:(isset($symbols[$currency->code])?$symbols[$currency->code]:"");
			            if($widpos=="B"|| $widpos=="V"){
				            if ( ! empty( $_default_mc_cur->code ) && $currency->code == $_default_mc_cur->code ) {
					            $lis .= APBD_get_floating_li( $currency, $_default_mc_cur, $currencySymbol, $current_url, $this->pluginFile, true );
				            } else {
					            $lis = APBD_get_floating_li( $currency, $_default_mc_cur, $currencySymbol, $current_url, $this->pluginFile, true ).$lis;
				            }
                        }else {
				            if ( ! empty( $_default_mc_cur->code ) && $currency->code == $_default_mc_cur->code ) {
					            $lis = APBD_get_floating_li( $currency, $_default_mc_cur, $currencySymbol, $current_url, $this->pluginFile, true ) . $lis;
				            } else {
					            $lis .= APBD_get_floating_li( $currency, $_default_mc_cur, $currencySymbol, $current_url, $this->pluginFile, true );
				            }
			            }
		            }
		            echo $lis;
	            ?>
            </ul>
        </div>
        <!--Float Widget End-->
<?php } ?>
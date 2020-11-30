<?php
	/**
	 * @since: 07/09/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	
	class APBDWMC_design extends AppsBDLiteModule{
		function initialize() {
			parent::initialize();
			//$this->disableDefaultForm();
			/*$this->AddAjaxAction("add",[$this,"add"]);
			$this->AddAjaxAction("edit",[$this,"edit"]);
			
			jQGrid::setTranslatorMethod([$this,"__"]);*/
			
			add_shortcode( 'WCMC', [$this,'shortcodes'] );
		}
		public function OnInit() {
			parent::OnInit();
			$widpos=$this->GetOption("wid_pos","N");
			if($widpos!="N") {
				add_action( 'wp_footer', [ $this, 'addDefaultWidget' ] );
			}
		}
		public function ClientStyle() {
			//$this->AddClientStyle("apbd-mc-chooser","chooser.css");
			$this->AddClientStyle("apbd-wmc-frontend","uilib/httheme/css/frontend.css",true);
		}
		
		function addDefaultWidget() {
			$this->Display('default_currency_chooser');
		}
		function GetMenuSubTitle() {
			return $this->__("Design Settings");
		}
		
		function GetMenuIcon() {
			return 'fa fa-globe';
		}
		
		function SettingsPage() {
			$this->Display();
		}
		
		function GetMenuTitle() {
			return $this->__("Design");
		}
		
		function shortcodes($atts){
		    ob_start();
			$a = shortcode_atts( array(
				'style' => 'all',
			
			), $atts );
			$a['style']=strtolower($a['style']);
			if($a['style']=="flagonly" || $a['style']=="flag"){
				?>
				<div class="ht-mcs-widget ht-mcs-sidebar-widget-flag mb-5">
					
					
					<ul>
						<?php
							$current_url =APBD_current_url();
							$currencies=APBDWMC_general::GetModuleInstance()->getLocalizeCurrencies();
							$_default_mc_cur=APBDWMC_general::GetModuleInstance()->active_currency;
							$currencies_name   = get_woocommerce_currencies();
							$symbols=APBD_get_mc_currency_symbols();
							$lis="";
							$urlprefix=strpos($current_url,"?")===false?$current_url."?":$current_url."&";
							foreach ( $currencies as $currency ) {
								if(!$currency->is_show){continue;}
								$currencyName = ! empty( $currencies_name[ $currency->code ] ) ? $currencies_name[ $currency->code ] : $currency->code;
								$currencySymbol=!empty($currency->custom_symbol)?$currency->custom_symbol:(isset($symbols[$currency->code])?$symbols[$currency->code]:"");
								?>
								<li>
									<a class="<?php echo !empty($_default_mc_cur->code)&& $currency->code==$_default_mc_cur->code?" active ":"";?>" href="<?php echo esc_url($urlprefix); ?>_amc-currency=<?php echo esc_attr($currency->code);?>">
										<span class="icon"><img src="<?php echo plugins_url("images/flags/square/".strtoupper(esc_attr($currency->code)).'.png',$this->pluginFile); ?>" alt="<?php echo esc_attr($currency->code);?>"></span>
									
									</a>
								</li>
								<?php
							}
							echo $lis;
						?>
					</ul>
				</div>
				<?php
			}else{
				?>
				<div class="ht-mcs-widget ht-mcs-sidebar-widget-list mb-5">
					
					
					<ul>
						<?php
							$current_url =APBD_current_url();
							$currencies=APBDWMC_general::GetModuleInstance()->getLocalizeCurrencies();
							$_default_mc_cur=APBDWMC_general::GetModuleInstance()->active_currency;
							$currencies_name   = get_woocommerce_currencies();
							$symbols=APBD_get_mc_currency_symbols();
							$lis="";
							$urlprefix=strpos($current_url,"?")===false?$current_url."?":$current_url."&";
							foreach ( $currencies as $currency ) {
								if(!$currency->is_show){continue;}
								$currencyName = ! empty( $currencies_name[ $currency->code ] ) ? $currencies_name[ $currency->code ] : $currency->code;
								$currencySymbol=!empty($currency->custom_symbol)?$currency->custom_symbol:(isset($symbols[$currency->code])?$symbols[$currency->code]:"");
								?>
								<li>
									<a class="<?php echo !empty($_default_mc_cur->code)&& $currency->code==$_default_mc_cur->code?" active ":"";?>" href="<?php echo $urlprefix; ?>_amc-currency=<?php echo esc_attr($currency->code);?>">
										<span class="icon"><img src="<?php echo plugins_url("images/flags/circle/".strtoupper($currency->code).'.png',$this->pluginFile); ?>" alt="<?php echo esc_attr($currency->code);?>"></span>
										<span class="text"><?php echo esc_html($currencyName); ?> (<?php echo esc_attr($currencySymbol); ?>)</span>
									</a>
								</li>
								<?php
							}
							echo $lis;
						?>
					</ul>
				</div>
				<?php
			}
			return ob_get_clean();
		}
		
		
	}
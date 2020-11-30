<?php
	/**
	 * @since: 07/09/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	/**
	 * @property APBDWC_currency_item   $active_currency
	 */
	class APBDWMC_general extends AppsBDLiteModule{
		private $temp_code=null;
		public $active_currency;
		function initialize() {
			parent::initialize();
	
			$this->disableDefaultForm();
			$this->AddAjaxAction("add",[$this,"newCurrency"]);
			$this->AddAjaxAction("set-default",[$this,"SetDefaultCurrency"]);
			$this->AddAjaxAction("delete-currency",[$this,"DeleteCurrency"]);
			$this->AddAjaxAction("get-rate",[$this,"GetRate"]);
			$this->AddAjaxAction("update",[$this,"UpdateCurrency"]);
			$this->AddAjaxAction("update-all",[$this,"UpdateAllRateCurrency"]);
			if(isset($_GET['_amc-currency'])) {
				if ( $this->hasCurrencyItem( strtoupper( $_GET['_amc-currency'] ) ) ) {
					APBDWMC_session::SetSession("_mc_active",strtoupper( $_GET['_amc-currency']));
				}
			}
			
			$this->AddGlobalJSVar("confirmText",$this->__("Confirmation"));
			
			add_action( 'woocommerce_cart_loaded_from_session', [$this, '_wc_before_mini_cart' ], 99 );
			//APBD_GPrintDie($this->active_currency);
			
			add_filter( 'woocommerce_product_get_regular_price', [ $this, '_wc_get_product_regular_price' ], 9999, 2 );
			add_filter( 'woocommerce_product_get_sale_price', [ $this, '_wc_get_product_sale_price' ], 9999, 2 );
			add_filter( 'woocommerce_product_get_price', [ $this, '_wc_get_product_get_price' ], 99999, 2 );
			
			//variation prices
			add_filter( 'woocommerce_variation_prices', [$this,'_wc_get_variation_prices'], 99999, 3 );
			
			/*Variable price*/
			add_filter( 'woocommerce_product_variation_get_price', array( $this, '_wc_get_product_variation_price' ), 999, 2 );
			add_filter( 'woocommerce_product_variation_get_regular_price', array( $this, '_wc_get_product_variation_price' ), 99, 2 );
			add_filter( 'woocommerce_product_variation_get_sale_price', array( $this, '_wc_get_product_variation_price' ), 99, 2 );
			
			/* Product filter*/
			add_filter( 'woocommerce_price_filter_results', [ $this, '_wc_get_price_filter_results' ], 10, 3 );
			//add_filter( 'woocommerce_product_query_meta_query', [$this, '_wc_get_price_filter_results'] ,10,3);
			//add_filter( 'woocommerce_price_filter_widget_min_amount', [ $this, '_wc_get_product_price' ] );
			//add_filter( 'woocommerce_price_filter_widget_max_amount', [ $this, '_wc_get_product_price' ] );
			add_filter('woocommerce_package_rates',[ $this,'_wo_get_shipping_rates'],100,2);
			
			add_filter( 'woocommerce_general_settings',[ $this, '_wc_general_settings' ] );
			
			add_action('widgets_init', array($this, 'widgets_init'));
			
			new APBDWMC_coupon();
			new APBDWMC_order();
			add_action($this->getHookActionStr("app-footer"),[$this,"admin_app_footer"]);
			add_action( 'widgets_init', [$this,"widgets_init"]);
			
			add_action('wp_enqueue_scripts', function(){
				wp_dequeue_script('wc-price-slider');
				
			}, 200);
			
		}
		function OnInit() {
			parent::OnInit();
			
            $this->SetCurrency();
            if($this->kernelObject->isDevelopmode()){
                $this->AddAjaxNoPrivAction("ipinfo",[$this,"ipinfo"]);
            }
            $this->AddAjaxAction("ipinfo",[$this,"ipinfo"]);
            
            if(!is_admin() || is_ajax()) {
                add_filter( 'woocommerce_currency', [ $this, '_wc_set_currency' ], 9999 );
                add_filter( 'woocommerce_currency_symbol', [ $this, '_wc_set_currency_symbol' ], 9999, 2 );
                add_filter( 'woocommerce_price_format', [ $this, '_wc_set_price_format' ], 9999, 2 );
            }
			add_filter( 'woocommerce_admin_reports', [$this,'wc_report_tab'], 10, 1 );
		}
		function wc_report_tab( $reports ) {
			
			$reports['orders']['reports']['sales_by_country'] = [
				'title'       => 'Sales By Currency',
				'description' => '',
				'hide_title'  => true,
				'callback'    => [ $this, 'wc_report_callback' ],
			];
			
			//$reports['orders']['reports'] = array_merge( $reports['orders']['reports'], $sales_by_country );
			
			return $reports;
		}
		function wc_report_callback(){
			$report = new wc_report_currencywise();
			$report->output_report();
			
		}
		
		function SetCurrency(){
            $oldKey=$this->GetOption('default_cur');
            $getDefaultCurrency=get_option('woocommerce_currency','USD');
            $auto_id=$this->GetOption('next_cur_id',NULL);
            if(empty($auto_id)){
                $this->AddOption( "next_cur_id", 1 );
            }
            if($oldKey!=$getDefaultCurrency) {
                $this->AddOption( "default_cur", $getDefaultCurrency );
            }
            if(empty($this->options['currencies'])) {
                //set Default  row
                $current_decimal_value = wc_get_price_decimals();
                $currency_possition    = get_option( 'woocommerce_currency_pos' ,'left');
                $this->addCurrencyOption($getDefaultCurrency,1,$current_decimal_value,$currency_possition,0,true);
            }
            
            $cur=APBDWMC_session::GetSession("_mc_active");
            if(empty($cur) || !$this->isCountryCodeInLocalizeCurrencies($cur)){
                $this->active_currency=$this->getDefaultCurrency();
                $cur=APBDWMC_session::SetSession("_mc_active",$this->active_currency->code);
            }else{
                $this->active_currency=$this->getCurrencyByCode($cur);
            }
        }
		public function ipinfo(){
            $ip           = new WC_Geolocation();
            $geo_ip       = $ip->geolocate_ip();
            ?>
            <div style="text-align: left">
            <table style="width: 100%">
                <?php foreach ($geo_ip as $key=>$item) {
                    ?>
                    <tr>
                        <th><?php echo $key; ?></th>
                        <td><?php echo $item; ?></td>
                    </tr>
                    <?php
                } ?>
            </table>
            </div>
            <?php
            die;
        }
		public function _wc_before_mini_cart() {
			WC()->cart->calculate_totals();
		}
		public function _wc_general_settings($fields ) {
			$unsetParam=['woocommerce_currency','woocommerce_price_num_decimals','woocommerce_currency_pos'];
			foreach ( $fields as $k => $data ) {
				if ( ! empty( $data['id'] ) ) {
					if ( in_array( $data['id'], $unsetParam ) ) {
						unset( $fields[ $k ] );
					}
					if ( $data['id'] == 'pricing_options' ) {
						$fields[ $k ]['desc'] = esc_html( $this->__('The following currency options are available in ')).'<a href="' . admin_url( '?page='.$this->pluginBaseName ) . '">' . esc_html( $this->kernelObject->pluginName ) . '</a>';
					}
				}
			}
			
			return $fields;
		}
		public function _wc_get_price_filter_results( $data_query, $min_class, $max_class ) {
			global $wpdb;
			
			$tax_class=0;
			$min_class=$this->getDefaultPriceFormCurrentPrice($min_class);
			$max_class=$this->getDefaultPriceFormCurrentPrice($max_class);
			
			
			if ( wc_tax_enabled() && 'incl' === get_option( 'woocommerce_tax_display_shop' ) && ! wc_prices_include_tax() ) {
				$data_query = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT DISTINCT ID, post_parent, post_type FROM {$wpdb->posts}
						INNER JOIN {$wpdb->postmeta} pm1 ON ID = pm1.post_id
						INNER JOIN {$wpdb->postmeta} pm2 ON ID = pm2.post_id
						WHERE post_type IN ( 'product', 'product_variation' )
						AND post_status = 'publish'
						AND pm1.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
						AND pm1.meta_value BETWEEN %f AND %f
						AND pm2.meta_key = '_tax_class'
						AND pm2.meta_value = %s
					", $min_class, $max_class, sanitize_title( $tax_class )
					), OBJECT_K
				);
			} else {
				$data_query = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT DISTINCT ID, post_parent, post_type FROM {$wpdb->posts}
					INNER JOIN {$wpdb->postmeta} pm1 ON ID = pm1.post_id
					WHERE post_type IN ( 'product', 'product_variation' )
					AND post_status = 'publish'
					AND pm1.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
					AND pm1.meta_value BETWEEN %d AND %d
				", $min_class, $max_class
					), OBJECT_K
				);
			}
			
			return $data_query;
		}
		public function getDefaultPriceFormCurrentPrice($price){
			if(!$this->active_currency->is_default) {
				$currenctPriceRate = $this->active_currency->rate + floatval( $this->active_currency->ex_fee );
				///$defprice          = $this->getDefaultCurrency();
				//$defRate           = $defprice->rate;
				$price=$price/$currenctPriceRate;
				
			}
			return $price;
		}
		public function getCalculatedPrice($price,$product=NULL) {
			if(@is_string($price)){
				$price=floatval($price);
			}
			if ( ! empty( $this->active_currency ) ) {
				$price=@$price*$this->active_currency->rate+floatval($this->active_currency->ex_fee);
			}
			return $price;
		}
		
		
		function _wc_get_product_get_price($price, $product = NULL){
			return $this->_wc_get_product_price($price, $product,'price');
		}
	
		function _wc_get_product_sale_price($price, $product = NULL){
			return $this->_wc_get_product_price($price, $product,'sale_price');
		}
		function _wc_get_product_regular_price($price, $product = NULL){
		    return $this->_wc_get_product_price($price, $product,'regular_price');
		}
		
		
		/**
		 * @param $price
		 * @param WC_Product_Simple $product
		 * @param string $type
		 *
		 * @return float|int
		 */
		function _wc_get_product_price($price, $product = NULL,$type=''){
			if ( ! $price ) {
				return $price;
			}
			return $this->getCalculatedPrice($price,$product);
		}
		function _wo_get_shipping_rates($rates,$package) {
			
			foreach ($rates as $rate) {
				
				//Set the price
				$rate->cost = $this->getCalculatedPrice($rate->cost);
				
				//Set the TAX
				//$rate->taxes[1] = 1000 * 0.2;
				if(!empty($rate->taxes)){
					foreach ( $rate->taxes as $tax ) {
						if(!is_object($tax) && !is_array($tax)) {
							$tax = $this->getCalculatedPrice( $tax );
						}
					}
				}
				
			}
			
			return $rates;
		}
		function _wc_get_product_variation_price($price, $instance){
			if ( ! $price ) {
				return $price;
			}
			return $this->getCalculatedPrice($price,$instance);
		}
		function _wc_get_variation_prices($prices, $product_variable = NULL ) {
			//product main price
			
			foreach ( $prices['price'] as &$price ) {
				$price = $this->getCalculatedPrice( $price, $product_variable );
			}
			foreach ( $prices['regular_price'] as &$price ) {
				$price = $this->getCalculatedPrice( $price, $product_variable );
			}
			foreach ( $prices['sale_price'] as &$price ) {
				$price = $this->getCalculatedPrice( $price, $product_variable );
			}
			return $prices;
		}
		
		
		function _wc_set_currency($currency) {
			//$currency_symbol, $currency
			
			if ( ! empty( $this->active_currency ) ) {
				return strtoupper($this->active_currency->code);
				
			}else{
				return $currency;
			}
		}
		function _wc_set_currency_symbol($currency_symbol, $currency='') {
			//$currency_symbol, $currency
            if (  empty( $this->active_currency )) {
                $this->SetCurrency();
            }
			if ( ! empty( $this->active_currency ) && !empty( $this->active_currency->custom_symbol ) ) {
				if($currency==$this->active_currency->code) {
					return $this->active_currency->custom_symbol;
				}
			}
			
			return $currency_symbol;
			
		}
		function _wc_set_price_format($format,$pos) {
			/*$args=func_get_args();
			APBD_GPrint($args);*/
			if ( !empty( $this->active_currency )) {
				$currency_pos = strtolower($this->active_currency->position);
				$format       = '%1$s%2$s';
				switch ( $currency_pos ) {
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
			}
			return $format;
			
		}
		
		
		
		function newCurrency(){
			$obj=$this->addCurrencyOption("",1,2,'left',0);
			$response=new stdClass();
			$response->currency_obj=$obj;
			ob_start();
			APBD_get_mc_currency_row($obj);
			$response->currency_tr=ob_get_clean();
			echo json_encode($response); die;
		}
		function OnAdminGlobalScripts() {
		
		}
		public function ClientScript() {
			$this->AddClientScript( "apbd-wc-wmc-frontend-js", "frontend.min.js", false, [
				'jquery'
			]);
			wp_enqueue_script("jquery-ui-core");
			wp_enqueue_script( 'jquery-ui-selectmenu' );
			//wp_add_inline_script('apbd-wc-wmc-frontend-js', $this->inlineScript(), 'before');;
            $csymbol=!empty($this->active_currency->custom_symbol)?$this->active_currency->custom_symbol:APBD_get_mc_currency_symbols($this->active_currency->code);
			wp_localize_script( 'apbd-wc-wmc-frontend-js', 'apbd_wmc_vars',
				array(
					'wmchash'     => $this->GetUniqueHash(),
					'active_currency'     => $this->active_currency,
					'currency_symbol'     => $csymbol
				)
			);
			wp_enqueue_script('wc-price-slider-apmc');
			
		}
        function widgets_init(){
	       
		        register_widget( 'APBDWMC_widget_one' );
		        //register_widget( 'APBDWMC_widget_two' );
		        register_widget( 'APBDWMC_widget_flag_only' );
		        wp_register_script( 'wc-price-slider-apmc', plugins_url("js/ht-price-slider.js",$this->pluginFile), 'jquery', $this->kernelObject->pluginVersion );
	       
        }
		function inlineScript() {
			ob_start();
			?>
            var wmc_active_currency=<?php echo json_encode($this->active_currency); ?>;
			<?php
			return ob_get_clean();
		}
		function GetUniqueHash() {
			return hash( 'crc32b',
				serialize( $this->active_currency )
				. serialize( $this->options )
				. serialize( APBDWMC_design::GetModuleInstance()->GetOption() )
				. serialize( APBDWMC_general::GetModuleInstance()->GetOption() )
				. serialize( APBDWMC_location::GetModuleInstance()->GetOption() )
				. serialize( APBDWMC_payment_currency::GetModuleInstance()->GetOption() )
			);
		}
		
		function AdminScripts() {
			$this->AddAdminScript( "appsbd-mc-main", "js/wc_main.min.js", true );
		}
		
		function getNextId(){
			$nextId=$this->GetOption('next_cur_id',1);
			$this->AddOption("next_cur_id",$nextId+1);
			return $nextId;
		}
		function GetMenuSubTitle() {
			return $this->__("General Settings");
		}
		
		function GetMenuIcon() {
			return 'ap ap-setting';
		}
		function hasCurrencyItem($code){
			if(!empty($this->options['currencies']) && is_array($this->options['currencies'])) {
				foreach ( $this->options['currencies'] as $currency ) {
					if($currency->code==$code){
						return true;
					}
				}
			}
			return false;
			
		}
		static function getCurrentCountry(){
			$ip           = new WC_Geolocation();
			$geo_ip       = $ip->geolocate_ip();
			$country_code = isset( $geo_ip['country'] ) ? $geo_ip['country'] : '';
			if(!empty($country_code)) {
				return $country_code;
			}
			return "";
		}
		/**
		 * @return APBDWC_currency_item|null
		 */
		function getDefaultCurrency() {
			
			if ( !is_admin() && APBDWMC_location::GetModuleInstance()->GetOption( "isEnable", 'N' ) == "Y" ) {
				$country_code = self::getCurrentCountry();
				if(!empty($country_code)) {
					if(APBDWMC_location::GetModuleInstance()->GetOption("isEnable","N")=="Y") {
						$currencies_countries = APBDWMC_location::GetModuleInstance()->GetOption( "currency_location", [] );
						if ( ! empty( $currencies_countries ) ) {
							foreach ( $currencies_countries as $cur_id => $countries ) {
								foreach ( $countries as $country ) {
									if ( $country_code == $country && ! empty( $this->options['currencies'][ $cur_id ]->code ) ) {
										return $this->options['currencies'][ $cur_id ];
									}
								}
							}
						}
					}
				}
			}
			$localCurrencies=$this->getLocalizeCurrencies();
			if ( ! empty( $localCurrencies ) && is_array( $localCurrencies ) ) {
			    $first=null;
				foreach ( $localCurrencies as $currency ) {
				    if(empty($first)){
                        $first=$currency;
                    }
					if ( $currency->is_default ) {
						return $currency;
					}
				}
				return $first;
			}
			$default=$this->getActiveCurrencies();
			foreach ($default as $def){
			    if($def->is_default=="Y"){
			        return $def;
                }
            }
			
			
			return NULL;
			
		}
		function getBaseCurrency(){
			if ( ! empty( $this->options['currencies'] ) && is_array( $this->options['currencies'] ) ) {
				foreach ( $this->options['currencies'] as $currency ) {
					if ( $currency->is_default ) {
						return $currency;
					}
				}
			}
			return null;
		}
		/**
		 * @param $code
		 *
		 * @return APBDWC_currency_item |null
		 */
		function getCurrencyByCode($code){
			if(!empty($this->options['currencies']) && is_array($this->options['currencies'])) {
				foreach ( $this->options['currencies'] as $currency ) {
					if($currency->code==$code){
						return $currency;
					}
				}
			}
			return null;
		}
		function updateRateByCode($code,$rate){
			if(!empty($this->options['currencies']) && is_array($this->options['currencies'])) {
				foreach ( $this->options['currencies'] as &$currency ) {
					if($currency->code==$code){
						$currency->rate=$rate;
						$this->UpdateOption();
						return true;
					}
				}
			}
			return false;
		}
		function addCurrencyOption($code,$rate,$dec_num,$position,$ex_fee,$isDefault=false,$custom_symbol=''){
			$currencyObj=new APBDWC_currency_item();
			$currencyObj->id=$this->getNextId();
			$currencyObj->code=$code;
			$currencyObj->rate=$rate;
			$currencyObj->dec_num=$dec_num;
			$currencyObj->position=$position;
			$currencyObj->ex_fee=$ex_fee;
			$currencyObj->is_default=$isDefault;
			$currencyObj->custom_symbol=$custom_symbol;
			$this->options['currencies'][ $currencyObj->id ]=$currencyObj;
			$this->UpdateOption();
			return $currencyObj;
		}
		function updateCurrencyOption($id,$code,$rate,$dec_num,$position,$ex_fee,$isDefault=false,$custom_symbol=''){
			$currencyObj=new APBDWC_currency_item();
			$currencyObj->code=$code;
			$currencyObj->rate=$rate;
			$currencyObj->dec_num=$dec_num;
			$currencyObj->position=$position;
			$currencyObj->ex_fee=$ex_fee;
			$currencyObj->is_default=$isDefault;
			$currencyObj->custom_symbol=$custom_symbol;
			$this->options['currencies'][ $id ]=$currencyObj;
			$this->UpdateOption();
		}
		function UpdateCurrency(){
			$id=APBD_GetValue("id");
			$res=new AppsbdAjaxConfirmResponse();
			$res->SetResponse(false,$this->__("Unknown error"));
			$responseObject=new stdClass();
			$responseObject->has_currency_change=false;
			if(!empty($id)) {
				
				//is_show: "Yes", code: "ANG", position: "left", rate: "1", ex_fee: "0", dec: "2", custom_symble: ""
				if(!empty($this->options['currencies'][ $id ])){
					$responseObject->id=$id;
					$newCode=APBD_PostValue("code",$this->options['currencies'][ $id ]->code);
					$previousCode=$this->options['currencies'][ $id ]->code;
					if($previousCode!=$newCode){
						$responseObject->new_code=$newCode;
						$responseObject->has_currency_change=true;
						$currencies   = get_woocommerce_currencies();
						$currencyName = ! empty( $currencies[ $newCode ] ) ? $currencies[ $newCode ] : $newCode;
						$currencySymbol = APBD_get_mc_currency_symbols( $newCode );
						$responseObject->currency_title=$newCode . " - " . $currencyName . " (" . $currencySymbol . ")";
					}
					$this->options['currencies'][ $id ]->code=APBD_PostValue("code",$this->options['currencies'][ $id ]->code);
					$this->options['currencies'][ $id ]->position=APBD_PostValue("position",$this->options['currencies'][ $id ]->position);
					$this->options['currencies'][ $id ]->ex_fee=APBD_PostValue("ex_fee",$this->options['currencies'][ $id ]->ex_fee);
					$this->options['currencies'][ $id ]->dec_num=APBD_PostValue("dec",$this->options['currencies'][ $id ]->dec_num);
					$this->options['currencies'][ $id ]->custom_symbol=APBD_PostValue("custom_symbol",$this->options['currencies'][ $id ]->custom_symbol);
					$this->options['currencies'][ $id ]->rate=APBD_PostValue("rate",$this->options['currencies'][ $id ]->rate);
					$this->options['currencies'][ $id ]->is_show=APBD_PostValue("is_show","Yes")=="Yes";
					$responseObject->new_cur_data=$this->options['currencies'][ $id ];
					$this->UpdateOption();
					$res->SetResponse( true, $this->__( "Successfully updated" ),$responseObject);
				}
			}else{
				$res->SetResponse( false, $this->__( "ID is required" ) );
			}
			$res->Display();
		}
		function UpdateAllRateCurrency(){
			$baseCurrency=$this->getDefaultCurrency();
			if(!empty($baseCurrency)) {
				foreach ( $this->options['currencies'] as &$currency ) {
					$rrate= $this->GetRateByBaseCurrency( $baseCurrency->code, $currency->code );
					if(!empty($rrate)) {
						$currency->rate = $rrate;
					}
				}
			}
			$this->UpdateOption();
			$res=new AppsbdAjaxConfirmResponse();
			$res->DisplayWithResponse(true,"Successfully updated",$this->options['currencies']);
		}
		function GetRate(){
			$req_currency=APBD_PostValue("cur");
			$res=new AppsbdAjaxConfirmResponse();
			$res->SetResponse(false,$this->__("Unknown error"));
			if(!empty($req_currency)) {
				$currency=$this->getDefaultCurrency();
				$rate=1;
				if(!empty($currency)) {
					$rate = $this->GetRateByBaseCurrency($currency->code,$req_currency);
					if(!empty($rate)) {
						$this->updateRateByCode($req_currency,$rate);
						$res->SetResponse( true, $this->__( "Successfully found" ), $rate );
					}else{
						$res->SetResponse( false, $this->__( "Auto rate failed, please try again later or set manually" ), $rate );
					}
				}
				
			}else{
				$res->SetResponse( false, $this->__( "Request currency is required" ) );
			}
			$res->Display();
		}
		private function GetRateByBaseCurrency($base_code,$request_code){
			$base_code=strtoupper($base_code);
			$request_code=strtoupper($request_code);
			if($base_code==$request_code){
				return 1;
			}
			$exCurrencies=["USD", "AED", "ARS", "AUD", "BGN", "BRL", "BSD", "CAD", "CHF", "CLP", "CNY", "COP", "CZK", "DKK", "DOP", "EGP", "EUR", "FJD", "GBP", "GTQ", "HKD", "HRK", "HUF", "IDR", "ILS", "INR", "ISK", "JPY", "KRW", "KZT", "MXN", "MYR", "NOK", "NZD", "PAB", "PEN", "PHP", "PKR", "PLN", "PYG", "RON", "RUB", "SAR", "SEK", "SGD", "THB", "TRY", "TWD", "UAH", "UYU", "VND", "ZAR"];
			if(in_array($base_code,$exCurrencies) && in_array($request_code,$exCurrencies)){
				if(!empty($this->temp_code->rates->{$request_code})){
					return $this->temp_code->rates->{$request_code};
				}
				$response=wp_remote_get('https://api.exchangerate-api.com/v4/latest/'.$base_code, array(
						'sslverify' => false,
						'timeout' => 45
					)
				);
				
				if (!is_wp_error($response)) {
					$codes = $response['body'];
					if(!empty($codes)){
						$codes=json_decode($codes);
						$this->temp_code=$codes;
						if(!empty($codes->rates->{$request_code})){
							return round($codes->rates->{$request_code},3);
						}
					}
				}
				
			}else{
				$response=wp_remote_get('https://www.alphavantage.co/query?function=CURRENCY_EXCHANGE_RATE&from_currency='.$base_code.'&to_currency='.$request_code.'&apikey=2L2CA8N2EG78RMHL', array(
						'sslverify' => false,
						'timeout' => 45
					)
				);
				if (!is_wp_error($response)) {
					$codes = $response['body'];
					if(!empty($codes)){
						$codes=json_decode($codes);
						if(!empty($codes->{"Realtime Currency Exchange Rate"}->{"5. Exchange Rate"})){
							return round($codes->{"Realtime Currency Exchange Rate"}->{"5. Exchange Rate"},3);
						}
					}
				}
			}
			return 0;
		}
		function DeleteCurrency(){
			$id=APBD_GetValue("id");
			$res=new AppsbdAjaxConfirmResponse();
			$res->SetResponse(false,$this->__("Unknown error"));
			if(!empty($id)) {
				if( !empty($this->options['currencies'][$id])){
					if(!$this->options['currencies'][$id]->is_default){
						unset($this->options['currencies'][$id]);
						$res->SetResponse( true, $this->__( "Successfully deleted" ),$id);
						$this->UpdateOption();
						APBDWMC_location::GetModuleInstance()->deleteCurrencyData($id);
					}else{
						$res->SetResponse( false, $this->__( "The currency has been set as default. You can't delete it." ) );
					}
				}
				
			}else{
				$res->SetResponse( false, $this->__( "ID is required" ) );
			}
			$res->Display();
		}
		function SetDefaultCurrency(){
			$id=APBD_PostValue("id");
			$res=new AppsbdAjaxConfirmResponse();
			$res->SetResponse(false,$this->__("Unknown error"));
			if(!empty($id)) {
				if ( ! empty( $this->options['currencies'] ) && is_array( $this->options['currencies'] ) ) {
					foreach ( $this->options['currencies'] as &$currency ) {
						if ( $currency->id == $id ) {
							$currency->is_default = true;
							$res->SetResponse( true, $this->__( "Successfully updated" ), $currency );
                            update_option('woocommerce_currency',$currency->code);
						} else {
							$currency->is_default = false;
						}
					}
				}
				$this->UpdateOption();
			}else{
				$res->SetResponse( false, $this->__( "ID is required" ) );
			}
			$res->Display();
		}
		/**
		 * @return APBDWC_currency_item []
		 */
		function getActiveCurrencies(){
			return $this->GetOption("currencies",[]);
		}
		function isCountryCodeInLocalizeCurrencies($code){
			$currencies=$this->getLocalizeCurrencies();
			foreach ($currencies as $currency){
				if(strtoupper($code) ==$currency->code){
					return true;
				}
			}
			return false;
		}
		/**
		 * @return APBDWC_currency_item []
		 */
		function getLocalizeCurrencies(){
			$currencies=$this->getActiveCurrencies();
			if(APBDWMC_location::GetModuleInstance()->GetOption( "isEnable", 'N' ) == "Y"){
				$country_code = self::getCurrentCountry();
				$currencies_countries = APBDWMC_location::GetModuleInstance()->GetOption( "currency_location", [] );
				foreach ($currencies as $cid=>$currency){
					if(isset($currencies_countries[$cid])){
						//localize currency
						if(!empty($country_code)){
							if(!in_array($country_code,$currencies_countries[$cid])){
								unset( $currencies[ $cid ]);
							}
						}else {
							unset( $currencies[ $cid ] );
						}
					}
				}
				
			}
			if(empty($currencies) && !empty($this->active_currency->code)){
			    $currencies[$this->active_currency->code]=$this->active_currency;
            }
			
			return $currencies;
		}
		function SettingsPage() {
			
			
			$this->Display();
		}
		
		function GetMenuTitle() {
			return $this->__("Currency");
		}
		function admin_app_footer(){
			$this->Display("app-footer");
		}
		function _check_filter_query($sql, $meta_query_sql, $tax_query_sql)
        {
            file_put_contents(WP_CONTENT_DIR."/filter.sql",$sql."\n\n",FILE_APPEND);
            return $sql;
            /* global $wpdb;
             
             $args       = WC()->query->get_main_query()->query_vars;
             $tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
             $meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();
             
             if ( ! is_post_type_archive( 'product' ) && ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
                 $tax_query[] = WC()->query->get_main_tax_query();
             }
             
             foreach ( $meta_query + $tax_query as $key => $query ) {
                 if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
                     unset( $meta_query[ $key ] );
                 }
             }
             
             $meta_query = new WP_Meta_Query( $meta_query );
             $tax_query  = new WP_Tax_Query( $tax_query );
             $search     = WC_Query::get_main_search_query_sql();
             
             $meta_query_sql   = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
             $tax_query_sql    = $tax_query->get_sql( $wpdb->posts, 'ID' );
             $search_query_sql = $search ? ' AND ' . $search : '';
             
             $sql = "
             SELECT min( min_price ) as min_price, MAX( max_price ) as max_price
             FROM {$wpdb->wc_product_meta_lookup}
             WHERE product_id IN (
                 SELECT ID FROM {$wpdb->posts}
                 " . $tax_query_sql['join'] . $meta_query_sql['join'] . "
                 WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
                 AND {$wpdb->posts}.post_status = 'publish'
                 " . $tax_query_sql['where'] . $meta_query_sql['where'] . $search_query_sql . '
             )';
             
             $sql = apply_filters( 'woocommerce_price_filter_sql', $sql, $meta_query_sql, $tax_query_sql );
             
             return $wpdb->get_row( $sql ); // WPCS: unprepared SQL ok.
         }*/
        }
		
	}
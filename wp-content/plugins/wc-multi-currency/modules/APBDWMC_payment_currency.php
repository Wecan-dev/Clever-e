<?php
	/**
	 * @since: 07/09/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	
	class APBDWMC_payment_currency extends AppsBDLiteModule {
		function initialize() {
			parent::initialize();
			$this->disableDefaultForm();
			/*$this->AddAjaxAction("add",[$this,"add"]);
			$this->AddAjaxAction("edit",[$this,"edit"]);
			
			jQGrid::setTranslatorMethod([$this,"__"]);*/
			add_filter( 'woocommerce_available_payment_gateways', [$this,'filter_gateways'], 1 );
			$this->AddAjaxAction("get-html",[$this,"getHtml"]);
		}
		
		function GetMenuSubTitle() {
			return $this->__( "Payment Gateway based on Currency Settings" );
		}
		
		function filter_gateways( $gateways ) {
			global $woocommerce;
			//Remove a specific payment option
			//unset( $gateways['paypal'] );
			//APBD_GPrint($gateways);
			//die;
			return $gateways;
		}
		
		function GetMenuIcon() {
			return 'ap ap-setting';
		}
		function getHtml(){
			$this->getGatewaysCurrencyHtml();
			die;
		}
		function getGatewaysCurrencyHtml(){
			$currencies=APBDWMC_general::GetModuleInstance()->getActiveCurrencies();
			$payment_gateways_obj     = new WC_Payment_Gateways();
			$enabled_payment_gateways = $payment_gateways_obj->payment_gateways();
			//APBD_GPrint($enabled_payment_gateways);die;
			//WC_Gateway_BACS::class
			foreach ($currencies as $currency) {
				$selectedCountries=[];//$this->getSelectedCountryById($currency->id);
				getCurrencyPaymentGatewayRow( $currency, $enabled_payment_gateways,$selectedCountries);
			}
		}
		function SettingsPage() {
			$payment_gateways_obj     = new WC_Payment_Gateways();
			$enabled_payment_gateways = $payment_gateways_obj->payment_gateways();
			$this->AddViewData("gateways",$enabled_payment_gateways);
			$this->Display();
		}
		
		function GetMenuTitle() {
			return $this->__( "Currency's Payment Gateway" );
		}
		
		
	}
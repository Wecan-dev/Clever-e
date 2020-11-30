<?php
	/**
	 * @since: 07/09/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	
	class APBDWMC_location extends AppsBDLiteModule{
		function initialize() {
			parent::initialize();
			//$this->disableDefaultForm();
			$this->AddAjaxAction("get-html",[$this,"getHtml"]);
			/*$this->AddAjaxAction("edit",[$this,"edit"]);
			
			jQGrid::setTranslatorMethod([$this,"__"]);*/
		}
		function GetMenuSubTitle() {
			return $this->__("Location Settings");
		}
		
		function GetMenuIcon() {
			return 'fa fa-globe';
		}
		
		function SettingsPage() {
			$this->Display();
		}
		
		function GetMenuTitle() {
			return $this->__("Location");
		}
		
		function getSelectedCountryById($id){
			return !empty($this->options['currency_location'][$id])?$this->options['currency_location'][$id]:[];
		}
		function deleteCurrencyData($id){
			if(!empty($this->options['currency_location'][$id])){
				unset($this->options['currency_location'][$id]);
				$this->UpdateOption();
			}
		}
		function getHtml(){
			$this->getCountryCurrencyHtml();
			die;
		}
		function getCountryCurrencyHtml(){
			$currencies=APBDWMC_general::GetModuleInstance()->getActiveCurrencies();
			foreach ($currencies as $currency) {
				$selectedCountries=$this->getSelectedCountryById($currency->id);
				getCurrencyCountryRow( $currency, $selectedCountries);
			}
		}
        public function AjaxRequestCallback() {
            if(!isset($_POST['currency_location'])){
                $_POST['currency_location']=[];
            }
            parent::AjaxRequestCallback();
        }
		
		
	}
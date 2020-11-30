<?php
	/**
	 * @since: 07/09/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	
	class APBDWMC_advance extends AppsBDLiteModule{
		function initialize() {
			parent::initialize();
			//$this->disableDefaultForm();
			/*$this->AddAjaxAction("add",[$this,"add"]);
			$this->AddAjaxAction("edit",[$this,"edit"]);
			
			jQGrid::setTranslatorMethod([$this,"__"]);*/
		}
		function GetMenuSubTitle() {
			return $this->__("Advance Settings");
		}
		
		function GetMenuIcon() {
			return 'ap ap-setting';
		}
		
		function SettingsPage() {
			$this->Display();
		}
		
		function GetMenuTitle() {
			return $this->__("Advance");
		}
		
		
	}
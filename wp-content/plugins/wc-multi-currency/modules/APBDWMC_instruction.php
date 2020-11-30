<?php
	/**
	 * @since: 07/09/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	
	class APBDWMC_instruction extends AppsBDLiteModule{
		function initialize() {
			parent::initialize();
			$this->disableDefaultForm();
		}
		
		
		function GetMenuSubTitle() {
			return $this->__("Instruction");
		}
		
		function GetMenuIcon() {
			return 'fa fa-exclamation-circle';
			
		}
		
		function SettingsPage() {
			$this->Display();
		}
		
		function GetMenuTitle() {
			return $this->__("Instruction");
		}
		
		
		
		
	}
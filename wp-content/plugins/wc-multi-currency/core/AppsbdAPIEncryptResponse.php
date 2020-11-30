<?php
	/**
	 * @since: 03/02/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	if(!class_exists("AppsbdAPIEncryptResponse")) {
		class AppsbdAPIEncryptResponse {
			private static $enc_key = "";
			public $status = false;
			public $msg = "";
			public $data = NULL;
			
			function SetResponse( $status, $msg, $data = NULL ) {
				$this->status = $status;
				$this->msg    = $msg;
				$this->data   = $data;
			}
			
			function DisplayWithResponse( $status, $msg, $data = NULL ) {
				$this->SetResponse( $status, $msg, $data );
				$this->Display();
			}
			
			function Display() {
				$enckey = APBDLicenseSettings::GetModuleOption( "api_enc_key", "" );
				if ( ! empty( self::$enc_key ) ) {
					echo APBDEncryptionLib::getInstance( self::$enc_key )->encrypt( json_encode( $this ) );
					die;
				}
				die( json_encode( $this ) );
			}
			
			static function DirectDisplay( $status, $msg, $data = NULL ) {
				$n = new self();
				$n->DisplayWithResponse( $status, $msg, $data );
			}
			
			/**
			 * @param string $enc_key
			 */
			public static function setEncKey( $enc_key ) {
				self::$enc_key = $enc_key;
			}
			
		}
	}
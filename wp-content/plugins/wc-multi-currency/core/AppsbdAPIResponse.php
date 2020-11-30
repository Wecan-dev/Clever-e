<?php
	/**
	 * @since: 03/02/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	if(!class_exists("AppsbdAPIResponse")) {
		class AppsbdAPIResponse {
			
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
				die( json_encode( $this ) );
			}
			
			static function DirectDisplay( $status, $msg, $data = NULL ) {
				$n = new self();
				$n->DisplayWithResponse( $status, $msg, $data );
			}
			
		}
	}
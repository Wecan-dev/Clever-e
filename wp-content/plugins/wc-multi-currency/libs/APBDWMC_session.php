<?php
class APBDWMC_session {
	var $prefix="_dwbd";
	private static $elem=null;
	private function __construct() {
		$this->prefix="_".hash('crc32b',site_url());
		$isHealthCheck=APBD_PostValue("action","")=='health-check-loopback-requests';
		if(!session_id() && !$this->is_rest() && !$isHealthCheck){
			session_start ();
		}
		
	}
	private function is_rest() {
		$prefix = rest_get_url_prefix( );
		$routeValue=APBD_GetValue("rest_route");
		if (defined('REST_REQUEST') && REST_REQUEST // (#1)
		    || !empty($routeValue) // (#2)
		       && strpos( trim( $routeValue, '\\/' ), $prefix , 0 ) === 0)
			return true;
		// (#3)
		global $wp_rewrite;
		if ($wp_rewrite === null) $wp_rewrite = new WP_Rewrite();
		
		// (#4)
		$rest_url = wp_parse_url( trailingslashit( rest_url( ) ) );
		$current_url = wp_parse_url( add_query_arg( array( ) ) );
		return strpos( $current_url['path'], $rest_url['path'], 0 ) === 0;
	}
	private static function &getInstance(){
		if(!self::$elem){
			self::$elem=new self();
		}
		return self::$elem;
	}
	private function _SetSession($name, $obj) {
		if (isset ( $_SESSION [$this->prefix.$name] )) {
			unset ( $_SESSION [$this->prefix.$name] );
		}
		$_SESSION [$this->prefix.$name] = serialize ( $obj );
	
	}
	
	
	private function _GetSession($name, $isUnset = false,$default=null) {
		$rData = null;
		if (isset ( $_SESSION [$this->prefix.$name] )) {
			$rData = unserialize ( $_SESSION [$this->prefix.$name] );
			if ($isUnset) {
				unset ( $_SESSION [$this->prefix.$name] );
			}
			return $rData;
		} else {
			return $default;
		}
	}
	private function _IssetSession($sessionName){
		return isset ( $_SESSION [$this->prefix.$sessionName] );
	}
	private function _UnsetSession($name) {
		if (isset ( $_SESSION [$this->prefix.$name] )) {
			unset ( $_SESSION [$this->prefix.$name] );
		}
	}
	static function SetSession($name, $obj) {
		return self::getInstance()->_SetSession($name, $obj);
	}
	static function GetSession($name, $isUnset = false,$default=null) {
		return self::getInstance()->_GetSession($name, $isUnset,$default);
	}
	static function IssetSession($sessionName){
		return self::getInstance()->_IssetSession($sessionName);
	}
	static function UnsetSession($name) {
		return self::getInstance()->_UnsetSession($name);
	}
}

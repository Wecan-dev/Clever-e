<?php
if( !defined('ABSPATH')){
	exit;
}
if( !class_exists('YITH_FAV_Load_Themes_Integration')){

	class YITH_FAV_Load_Themes_Integration{
		protected static  $instance;

		public function __construct() {

			$theme_name = wp_get_theme()->get('Name') ;

			if( strpos( strtolower($theme_name), 'flatsome' )!== false || class_exists('Flatsome_Default')){

				require_once('modules/class.yith-fav-flatsome-module.php');
			}
		}

		/**
		 * @return YITH_FAV_Load_Themes_Integration
		 */
		public static function get_instance()
		{
			if( is_null( self::$instance )){
				self::$instance = new self();
			}
			return self::$instance;
		}
	}
}

function YITH_FAV_Load_Themes_Integration(){
	return YITH_FAV_Load_Themes_Integration::get_instance();
}

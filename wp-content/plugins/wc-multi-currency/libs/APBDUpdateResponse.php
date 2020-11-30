<?php
class APBDUpdateResponse
{
	public $IsStoppedUpdate; //boolean
	public $version; //String
	public $slug; //String
	public $plugin_name; //String
	public $name; //String
	public $new_version; //String
	public $requires; //String
	public $tested; //String
	public $downloaded; //int
	public $last_updated; //String
	public $url; //String
	public $download_link; //String
	public $sections=[]; //Sections
	public $icons=[];
	public $banners=[];
	public $banners_rtl=[];
	public $update_denied_type="";
	public $is_downloadable=true;
	function __construct() {
		$this->version=$this->new_version;
		$this->plugin_name=&$this->name;
	}

	function AddSection($sectionName,$text){
		$this->sections[$sectionName]=$text;
	}
}


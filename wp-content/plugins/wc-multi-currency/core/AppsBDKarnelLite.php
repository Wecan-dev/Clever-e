<?php
/**
 * @since: 03/02/2019
 * @author: Sarwar Hasan
 * @version 1.0.0
 */
APBD_LoadCore('AppsbdAjaxConfirmResponse','AppsbdAjaxConfirmResponse',__FILE__);
APBD_LoadCore('AppsbdAjaxDataResponse','AppsbdAjaxDataResponse',__FILE__);
APBD_LoadCore('AppsbdAPIResponse','AppsbdAPIResponse',__FILE__);
APBD_LoadCore('AppsbdAPIEncryptResponse','AppsbdAPIEncryptResponse',__FILE__);
APBD_LoadCore('AppsBDModel','AppsBDModel',__FILE__);
APBD_LoadCore('APPSBDQueryBuilder','APPSBDQueryBuilder',__FILE__);
APBD_LoadCore( 'AppsBDLiteModule', 'AppsBDLiteModule',__FILE__);



/**
 * @property AppsBDProModule [] moduleList
 */
if(!class_exists("AppsBDKarnelLite")) {
	abstract class AppsBDKarnelLite {
		public static $appsbd_globalJS;
		public static $appsbd_globalCss;
		public static $setAppProperies;
		
		public $moduleList = [];
		public $pluginFile;
		public $pluginSlugName;
		private static $appGlobalVar = [];
		private static $_instence = [];
		private static $_instence_base = [];
		public $pluginName;
		public $pluginVersion;
		public $isTabMenu = false;
		protected static $warningMessage;
		protected static $errorMessage = [];
		protected static $infoMessage = [];
		protected static $hiddenFilelds = [];
		protected $isDevelopmode = false;
		protected $isDemoMode = false;
		private $isLoadJqGrid = false;
		public $pluginIconClass;
		public $mainMenuIconClass;
		
		public $_topmenu = [];
		public $_set_action_prefix = "";
		
		public $licenseMessage="";
		public $showMessage=false;
		private $is_module_loaded=false;
		private $pluginSlugWitoutChar="";
		protected $menuTitle;
        protected $_admin_notice=[];
        const NoticeTypeError="E";
        const NoticeTypeInfo="I";
        const NoticeTypeAppsbd="A";
        const NoticeTypeNone="N";
        /**
		 * @return bool
		 */
		final public function isModuleLoaded() {
			return $this->is_module_loaded;
		}
		
		/**
		 * @param bool $is_module_loaded
		 */
		public function setIsModuleLoaded( $is_module_loaded ) {
			$this->is_module_loaded = $is_module_loaded;
		}
		/**
		 * @return array
		 */
		public function GetAppGlobalVar() {
			return self::$appGlobalVar;
		}
		function is_countable($vars)
		{
			if(function_exists("is_countable")){
				return is_countable($vars);
			}else{
				if(is_string($vars) || is_bool($vars)){
					return false;
				}
				return is_array($vars) || is_object($vars);
			}
		}
		function AddTopMenu( $title, $icon, $func, $class = '', $isTab = true, $attr = [] ) {
			$n        = new stdClass();
			$n->title = $title;
			$n->func  = $func;
			$n->icon  = $icon;
			$n->class = $class;
			$n->istab = $isTab;
			$n->attr  = "";
			if ($this->is_countable($attr) &&  count( $attr ) > 0 ) {
				foreach ( $attr as $ke => $v ) {
					$n->attr .= ' ' . $ke . '="' . $v . '" ';
				}
			}
			
			$this->_topmenu[] = $n;
		}
		
		/**
		 * @param array $appGlobalVar
		 */
		public function AddAppGlobalVar( $key, $value ) {
			self::$appGlobalVar[ $key ] = $this->__( $value );
		}
		
		/**
		 * @return bool
		 */
		public function isDevelopmode() {
			return $this->isDevelopmode;
		}
		
		/**
		 * @param bool $isDevelopmode
		 */
		public function setIsDevelopmode( $isDevelopmode ) {
			$this->isDevelopmode = $isDevelopmode;
		}
		
		/**
		 * @return bool
		 */
		public function isLoadJqGrid() {
			return $this->isLoadJqGrid;
		}
		
		/**
		 * @param bool $isLoadJqGrid
		 */
		public function SetIsLoadJqGrid( $isLoadJqGrid ) {
			$this->isLoadJqGrid = $isLoadJqGrid;
		}
		
		public function SetPluginIconClass( $class ,$mainMenuIconClass='') {
			$this->pluginIconClass = $class;
			$this->mainMenuIconClass = $mainMenuIconClass;
		}
		
		/**
		 * @param string $set_action_prefix
		 */
		public function setSetActionPrefix( $set_action_prefix ) {
			$this->_set_action_prefix = $set_action_prefix;
		}
		
		/**
		 * @return string
		 */
		public function getHookActionStr( $str ) {
			return $this->_set_action_prefix . "/" . $str;
		}
		
		/**
		 * @return bool
		 */
		public function isDemoMode() {
			return $this->isDemoMode;
		}
		
		/**
		 * @param bool $isDemoMode
		 */
		public function setIsDemoMode( $isDemoMode ) {
			$this->isDemoMode = $isDemoMode;
		}
		
		/**
		 * @param mixed $menuTitle
		 */
		public function setMenuTitle( $menuTitle ) {
			$this->menuTitle = $menuTitle;
		}
		
		
		abstract function GetHeaderHtml();
		
		abstract function GetFooterHtml();
		
		function __construct($pluginBaseFile,$version = '1.0.0' ) {
			$this->pluginFile                              =$pluginBaseFile;
			self::$_instence[ get_class( $this ) ]         = &$this;
			self::$_instence_base[ $this->pluginSlugName ] = &self::$_instence[ get_class( $this ) ];
			spl_autoload_register( array( $this, "_myautoload_method" ) );
			$this->pluginSlugWitoutChar =strtoupper(preg_replace('/[^a-zA-Z]/','',$this->pluginSlugName));
			$this->AddAppGlobalVar( "yesText", "Yes" );
			$this->AddAppGlobalVar( "noText", "No" );
			$this->AddAppGlobalVar( "okText", "Ok" );
			$this->AddAppGlobalVar( "Loading", "Loading" );
			$this->AddAppGlobalVar( "bs_noneResultsText", "No Results matched {0}" );
			$this->AddAppGlobalVar( "bs_noneSelectedText", "Nothing selected" );
			$this->AddAppGlobalVar( "bs_seaching", "Searching.." );
			$this->_set_action_prefix = $this->pluginSlugName;
			$this->menuTitle=$this->pluginName;
			$this->initialize();
		}
		
		function initialize() {
		
		}
		
		public static function __callStatic( $func, $args ) {
			if ( isset( self::$setAppProperies[ $func ] ) ) {
				return call_user_func_array( self::$setAppProperies[ $func ], $args );
			}
			
			return;
		}
		
		public static function SetProptety( $name, $value ) {
			self::$setAppProperies[ $name ] = $value;
		}
		
		function __destruct() {
			if ( $this->isDevelopmode ) {
				$qu   = AppsBDModel::GetTotalQueriesForLog();
				$path = plugin_dir_path( $this->pluginFile ) . "logs/";
				if ( is_writable( $path ) ) {
					if ( ! is_dir( $path ) ) {
						mkdir( $path, 0740, true );
					}
					$path .= "queries.sql";
					//if (is_writable($filename)) {
					if ( file_exists( $path ) && filesize( $path ) > ( 1024 * 500 ) ) {
						unlink( $path );
					}
					if ( ! empty( $qu ) ) {
						$fh = fopen( $path, 'a' );
						if ( $fh ) {
							$count   = AppsBDModel::GetTotalQueriesCountStr();
							$queries = "-- " . get_permalink() . "----" . ( date( 'Y-m-d h:i:s A' ) ) . "--$count\n";
							$queries .= $qu;
							$queries .= "-- -----------------------------------------------------\n\n";
							fwrite( $fh, $queries );
							fclose( $fh );
						}
					}
				}
			}
		}
		
		final function CheckPluginVersionUpdate() {
			$db_version = get_option( "APBD_pv_" . $this->pluginSlugName, "" );
			if ( empty($db_version) || $db_version != $this->pluginVersion ) {
				update_option( "APBD_pv_" . $this->pluginSlugName, $this->pluginVersion ) || add_option( "APBD_pv_" . $this->pluginSlugName, $this->pluginVersion );
				if($this->is_countable( $this->moduleList)) {
					foreach ( $this->moduleList as $moduleObject ) {
						//$moduleObject=new APPSBDBase();
						$moduleObject->OnTableCreate();
						$moduleObject->OnPluginVersionUpdated( $this->pluginVersion );
					}
				}
			}
		}
		
		public function _myautoload_method( $class ) {
			$basepath  = $path = plugin_dir_path( $this->pluginFile );
			$firstchar = substr( $class, 0, 1 );
			if ( strtoupper( $firstchar ) == "M" ) {
				$modelfilename = $basepath . "models/";
				if ( file_exists( $modelfilename . "database/{$class}.php" ) ) {
					APBD_LoadDatabaseModel( $this->pluginFile, $class, $class );
					
					return;
				}elseif ( file_exists( $modelfilename . "{$class}.php" ) ) {
					APBD_Load_Any( $modelfilename . "{$class}.php" );
				}
			} elseif ( file_exists( $basepath . "libs/{$class}.php" ) ) {
				APBD_LoadLib( $this->pluginFile, $class );
			} elseif ( file_exists( $basepath . "core/{$class}.php" ) ) {
				APBD_Load_Any( $basepath . "core/{$class}.php", $class );
			} elseif ( file_exists( $basepath . "appcore/{$class}.php" ) ) {
				APBD_Load_Any( $basepath . "appcore/{$class}.php", $class );
			}
			
		}
		
		public static function AddError( $msg ) {
			self::$errorMessage[] = $msg;
		}
		
		public static function AddWarning( $msg ) {
			self::$warningMessage[] = $msg;
		}
		
		public static function AddInfo( $msg ) {
			self::$infoMessage[] = $msg;
		}
		
		public static function GetError( $prefix = '', $postfix = '' ) {
			if ( count( self::$errorMessage ) > 0 ) {
				return $prefix . implode( $postfix . $prefix, self::$errorMessage ) . $postfix;
			}
			
			return '';
		}
		
		public static function GetInfo( $prefix = '', $postfix = '' ) {
			if ( count( self::$infoMessage ) > 0 ) {
				return $prefix . implode( $postfix . $prefix, self::$infoMessage ) . $postfix;
			}
			
			return '';
		}
		
		public static function GetWarning( $prefix = '', $postfix = '' ) {
			if ( count( self::$warningMessage ) > 0 ) {
				return $prefix . implode( $postfix . $prefix, self::$warningMessage ) . $postfix;
			}
			
			return '';
		}
		
		public static function GetMsg( $prefix1 = '', $prefix2 = '', $prefix3 = '', $postfix = '' ) {
			$str = self::GetError( $prefix2, $postfix );
			$str .= self::GetInfo( $prefix1, $postfix );
			$str .= self::GetWarning( $prefix3, $postfix );
			if ( ! empty( $str ) ) {
				return '<div class="d-m-b">' . $str . '</div>';
			}
			
			return '';
		}
		
		public static function HasUIMsg() {
			return count( self::$infoMessage ) > 0 || count( self::$errorMessage ) > 0;
		}
		
		public static function AddHiddenFields( $key, $value ) {
			self::$hiddenFilelds[ $key ] = $value;
		}
		
		public static function AddOldFields( $key, $value ) {
			self::AddHiddenFields( "old_" . $key, $value );
		}
		
		public static function GetHiddenFieldsArray() {
			return self::$hiddenFilelds;
		}
		
		public static function GetHiddenFieldsHTML() {
			ob_start();
			foreach ( self::$hiddenFilelds as $name => $value ) {
				?>
                <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>"/>
				<?php
			}
			
			return ob_get_clean();
		}
		
		function AddCoreLib( $libname ) {
			if ( ! class_exists( $libname ) ) {
				$path = dirname( __FILE__ ) . "/" . $libname . ".php";
				if ( file_exists( $path ) ) {
					@include_once( $path );
				}
			}
		}
		
		function AddLib( $libname ) {
			if ( ! class_exists( $libname ) ) {
				$path = plugin_dir_path( $this->pluginFile ) . "lib/" . $libname . ".php";
				if ( file_exists( $path ) ) {
					@include_once( $path );
				}
			}
		}
		
		/**
		 *
		 * @return self
		 */
		static function &GetInstance() {
			return self::$_instence[ static::class ];
		}
		
		/**
		 * @param $base
		 *
		 * @return self
		 */
		static function &GetInstanceByBase( $base ) {
			return self::$_instence_base[ $base ];
		}
		
		/**
		 * @param $moduleClassName
		 */
		function AddLiteModule( $moduleClassName ) {
			if ( ! class_exists( $moduleClassName ) ) {
				$path = plugin_dir_path( $this->pluginFile ) . "modules/" . $moduleClassName . ".php";
				if ( file_exists( $path ) ) {
					@include_once( $path );
				}
			}
			$module=new $moduleClassName( $this->pluginSlugName, $this );
			if( $module instanceof AppsBDLiteModule) {
				$this->moduleList[] =$module;
				if ( ! $this->isTabMenu ) {
					if ( $this->is_countable( $this->moduleList ) && count( $this->moduleList ) > 1 ) {
						$this->isTabMenu = true;
					}
				}
			}
		}
		
		function WPAdminCheckDefaultCssScript( $src ) {
			if ( empty( $src ) || $src == 1 || preg_match( "/\/wp-admin\/|\/wp-includes\//", $src ) || preg_match( "/\/woocommerce\/assets/", $src ) || preg_match( "/\/elementor\/assets/", $src )) {
				return true;
			}
			
			return false;
		}
		
		function AddJquery() {
			wp_enqueue_script( 'jquery' );
		}
		
		function WpHead() {
		
		}
		public function BasePath($relative_path=''){
			return  plugin_dir_path( $this->pluginFile ).$relative_path;
		}
		function AdminScriptData() {
			?>
            <script type="text/javascript">
                if(typeof appGlobalLang == "undefined") {
                    var appGlobalLang =<?php echo json_encode( self::$appGlobalVar ); ?>;
                }else{
                    jQuery( document ).ready(function( $ ) {
                        appGlobalLang = $.extend( appGlobalLang, <?php echo json_encode( self::$appGlobalVar ); ?>);
                    });
                }
				<?php
				foreach ( $this->moduleList as $moduleObject ) {
					//$moduleObject=new APPSBDBase();
					$moduleObject->AdminScriptData();
				}
				?>
            </script>
			<?php
		}
		
		function AddAdminStyle( $StyleId, $StyleFileName = '', $isFromRoot = false, $deps = [] ) {
			if ( $isFromRoot ) {
				$start = "/";
			} else {
				$start = "/css/";
			}
			
			if ( ! empty( $StyleFileName ) ) {
				self::RegisterAdminStyle( $StyleId, plugins_url( $start . $StyleFileName, $this->pluginFile ), $deps, $this->pluginVersion );
			} else {
				self::RegisterAdminStyle( $StyleId );
			}
			
		}
		
		function AddAdminScript( $ScriptId, $ScriptFileName = '', $isFromRoot = false, $deps = [] ) {
			if ( $isFromRoot ) {
				$start = "/";
			} else {
				$start = "/js/";
			}
			if ( ! empty( $ScriptFileName ) ) {
				self::RegisterAdminScript( $ScriptId, plugins_url( $start . $ScriptFileName, $this->pluginFile ), $deps, $this->pluginVersion );
			} else {
				self::RegisterAdminScript( $ScriptId, '' );
			}
		}
		
		static function RegisterAdminStyle( $handle, $src = "", $deps = [], $ver = false, $in_footer = false ) {
			//echo $handle.", ";
			self::$appsbd_globalCss[] = $handle;
			if ( ! empty( $src ) ) {
				wp_register_style( $handle, $src, $deps, $ver, $in_footer );
			}
			wp_enqueue_style( $handle );
		}
		
		static function RegisterAdminScript( $handle, $src = "", $deps = [], $ver = false, $in_footer = false ) {
			self::$appsbd_globalJS[] = $handle;
			if ( ! empty( $src ) ) {
				wp_deregister_script( $handle );
				wp_register_script( $handle, $src, $deps, $ver, $in_footer );
			}
			wp_enqueue_script( $handle );
		}
		
		function OnAdminMainOptionStyles() {
			
			foreach ( $this->moduleList as $moduleObject ) {
				if ( $moduleObject->OnAdminMainOptionStyles( $this ) ) {
					return true;
				}
			}
		}
        function AddAdminNoticePlain($msg){
            $id=hash("crc32b",$msg);
            $this->_admin_notice[$id]=$msg;
        }
        function AddAdminNoticeWithBg($message,$type,$isDismissible=false,$extraClass="") {
            $extraClass.=" apbd-with-bg";
            $this->AddAdminNotice($message,$type,$isDismissible,$extraClass);
        }
        function AddAdminNotice($message,$type="I",$isDismissible=false,$extraClass="") {
            if($type==self::NoticeTypeError){
                $class   = 'notice apbd-notice notice-error';
            }elseif($type==self::NoticeTypeAppsbd){
                $class   = 'notice apbd-notice notice-appsbd';
            }elseif($type==self::NoticeTypeNone){
                $class   = '';
            }else{
                $class   = 'notice apbd-notice notice-success';
            }
            if($isDismissible){
                $class.=" is-dismissible";
            }
            $class.=" ".$extraClass;
            $msg=sprintf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ),  $message  );
            $this->AddAdminNoticePlain($msg);
        }
        function OnAdminNotices() {
            echo implode("",$this->_admin_notice);
        }
		function OnAdminGlobalStyles() {
			         
            $this->AddAdminStyle( "appsbd-icon", "uilib/icon/style.css", true );
            $this->AddAdminStyle( "apsbdanimation", "uilib/app-animation/app-animation.css" ,true);
            $this->AddAdminStyle( "appsbd-product-icon", "uilib/product-icon/icon.css", true );
            $this->AddAdminStyle( $this->pluginSlugWitoutChar."-apsbdpluginall", "all-css.css" );
			
			foreach ( $this->moduleList as $moduleObject ) {
				$moduleObject->OnAdminGlobalStyles();
			}
		}
		
		function OnAdminAppStyles() {
			$this->AddAdminStyle( 'wp-color-picker' );
			$this->AddAdminStyle( "apsbdboostrap", "uilib/boostrap/4.3.1/appsbdbootstrap.css", true );
            $this->AddAdminStyle( "font-awesome-4.7.0", "uilib/font-awesome/4.7.0/css/font-awesome.min.css", true );
			$this->AddAdminStyle( "apboostrap_magnificcss", "uilib/magnific/apbd-magnific-bootstrap.css", true );
			$this->AddAdminStyle( "apboostrap_validatior_css", "uilib/bootstrapValidation/css/bootstrapValidator.min.css", true );
			
			$this->AddAdminStyle( "apboostrap_sgnofi_css1", "uilib/sliding-growl-notification/css/notify.css", true );
			$this->AddAdminStyle( "apboostrap_sweetalertcss", "uilib/sweetalert/sweetalert.css", true );
			$this->AddAdminStyle( "apboostrap_datetimepickercss", "uilib/datetimepicker/jquery.datetimepicker.css", true );
			$this->AddAdminStyle( "apboostrap_boostrap_select", "uilib/boostrap-select/css/bootstrap-select-bundle.css", true );
			//$this->AddAdminStyle("uilib/sliding-growl-notification/css/themes/right-bottom.css","apboostrap_sgnofi_css2",true);
			if ( $this->isLoadJqGrid ) {
				$this->AddAdminStyle( "jquery-grid-ui", "uilib/grid/grid-ui-helper.min.css", true );
				$this->AddAdminStyle( "jquery-grid", "uilib/grid/css/ui.jqgrid.css", true );
			}
			$this->AddAdminStyle( "appsbdcore", "admin-core-style.css" );
			
			foreach ( $this->moduleList as $moduleObject ) {
				//$moduleObject=new APPSBDBase();
				$moduleObject->AdminStyles();
			}
		}
		
		function OnAdminAppScripts() {
			$this->AddAdminScript( "boostrap4", "uilib/boostrap/4.3.1/js/bootstrap.bundle.min.js", true );
			$this->SetLocalizeScript("boostrap4");
			$this->AddAdminScript( "apboostrap_validatior_js", "uilib/bootstrapValidation/js/bootstrapValidator4.min.js", true );
			$this->AddAdminScript( "apboostrap_magnificjs", "uilib/magnific/magnific.min.js", true );
			$this->AddAdminScript( "apboostrap_sgnofi_js", "uilib/sliding-growl-notification/js/notify.min.js", true );
			$this->AddAdminScript( "apboostrap_sweetalertjs", "uilib/sweetalert/sweetalert.min.js", true );
			$this->AddAdminScript( "apboostrap_datetimepickercss", "uilib/datetimepicker/jquery.datetimepicker.js", true );
			$this->AddAdminScript( "apboostrap_boostrap_select", "uilib/boostrap-select/js/bootstrap-select.min.js", true );
			$this->AddAdminScript( "apboostrap_ajax_boostrap_select", "uilib/boostrap-select/js/ajax-bootstrap-select.js", true );
			$this->AddAdminScript( "apd-main-js", "main.min.js", false, [ 'wp-color-picker' ] );
			if ( $this->isLoadJqGrid ) {
				$this->AddAdminScript( "jquery-grid-js-118n", "uilib/grid/js/i18n/grid.locale-en.js", true, [ 'jquery' ] );
				$this->AddAdminScript( "jquery-grid-js", "uilib/grid/js/jquery.jqGrid.src.min.js", true, [ 'jquery' ] );
			}
			
			foreach ( $this->moduleList as $moduleObject ) {
				//$moduleObject=new APPSBDBase();
				$moduleObject->AdminScripts();
			}
		}
		function SetLocalizeScript($id){
			wp_localize_script( $id, $this->pluginSlugWitoutChar,	[
			    'base_url'=>plugins_url( "", $this->pluginFile )
            ]);
        }
		
		function OnAdminMainOptionScripts() {
			
			foreach ( $this->moduleList as $moduleObject ) {
				if ( $moduleObject->OnAdminMainOptionScripts() ) {
					return true;
				}
			}
		}
		
		function OnAdminGlobalScripts() {
			
			foreach ( $this->moduleList as $moduleObject ) {
				if ( $moduleObject->OnAdminGlobalScripts() ) {
				
				}
			}
		}
		
		
		final function SetAdminStyle() {
			
			
			
			if ( self::IsMainOptionPage() ) {
				$this->OnAdminMainOptionStyles();
			}
			$this->OnAdminGlobalStyles();
			
			if ( ! $this->CheckAdminPage() ) {
				return;
			}
			$this->AddAdminStyle( $this->pluginSlugWitoutChar."-apsbdanimation", "uilib/app-animation/app-animation.css" ,true);
			$this->OnAdminAppStyles();
			
			global $wp_styles;
			
			foreach ( $wp_styles->queue as $style ) {
				if ( ! in_array( $style, self::$appsbd_globalCss ) ) {
					if ( ! $this->WPAdminCheckDefaultCssScript( $wp_styles->registered[ $style ]->src ) ) {
						wp_dequeue_style( $style );
					}
				}
			}
		}
		
		function SetAdminScript() {
			if ( self::IsMainOptionPage() ) {
				$this->OnAdminMainOptionScripts();
			}
			$this->OnAdminGlobalScripts();
			if ( ! $this->CheckAdminPage() ) {
				return;
			}//if not this plugin's  admin page
			$this->OnAdminAppScripts();
			
			global $wp_scripts;
			foreach ( $wp_scripts->queue as $script ) {
				if ( ! in_array( $script, self::$appsbd_globalJS ) ) {
					if ( ! $this->WPAdminCheckDefaultCssScript( $wp_scripts->registered[ $script ]->src ) ) {
						//echo $script."<br/>";
						wp_dequeue_script( $script );
					}
				}
			}
		}
		
		
		function SetClientScript() {
			foreach ( $this->moduleList as $moduleObject ) {
				//$moduleObject=new APPSBDBase();
				if ( $moduleObject->IsActive() ) {
					$moduleObject->ClientScript();
				}
			}
		}
		
		function SetClientStyle() {
			foreach ( $this->moduleList as $moduleObject ) {
				//$moduleObject=new APPSBDBase();
				if ( $moduleObject->IsActive() ) {
					$moduleObject->ClientStyle();
				}
			}
		}
		
		function CheckAdminPage() {
			$page = ! empty( $_REQUEST['page'] ) ? sanitize_text_field($_REQUEST['page']) : "";
			$page = trim( $page );
			if ( ! empty( $page ) ) {
				if ( $page == $this->pluginSlugName ) {
					return true;
				}
				foreach ( $this->moduleList as $moduleObject ) {
					//$moduleObject=new APPSBDBase();
					if ( $moduleObject->IsPageCheck( $page ) ) {
						return true;
					}
				}
			}
			
			return false;
			
		}
		
		static function IsMainOptionPage() {
			$file = basename( $_SERVER['SCRIPT_FILENAME'] );
			if ( $file == "plugins.php" ) {
				if ( empty( $_REQUEST['page'] ) ) {
					return true;
				}
			}
			
			return false;
		}
		
		final public function _Init() {
			do_action($this->_set_action_prefix."/register_module",$this);
			load_plugin_textdomain($this->pluginSlugName, FALSE, basename( dirname( $this->pluginFile ) ) . '/languages/');
			foreach ($this->moduleList as $moduleObject){
				//$moduleObject=new APPSBDBase();
				if($moduleObject->OnInit()){
					return true;
				}
			}
			$this->OnInit();
		}
		
		final function AdminMenu() {
			add_menu_page( $this->pluginName, $this->menuTitle, 'activate_plugins', $this->pluginSlugName, [ $this, 'OptionFormCore' ], $this->mainMenuIconClass );
			foreach ( $this->moduleList as $moduleObject ) {
				$moduleObject->AdminSubMenu();
			}
		}
		
		function _e( $string, $parameter = NULL, $_ = NULL ) {
			$args = func_get_args();
			echo call_user_func_array( [ $this, "__" ], $args );
		}
		
		function _ee( $string, $parameter = NULL, $_ = NULL ) {
			$args = func_get_args();
			foreach ( $args as &$arg ) {
				if ( is_string( $arg ) ) {
					$arg = $this->__( $arg );
				}
			}
			echo call_user_func_array( "sprintf", $args );
		}
		
		function __( $string, $parameter = NULL, $_ = NULL ) {
			$args = func_get_args();
			array_splice( $args, 1, 0, array( $this->pluginSlugName ) );
			
			return call_user_func_array( "APBD_Lan__", $args );
		}
		
		function ___( $string, $parameter = NULL, $_ = NULL ) {
			$args = func_get_args();
			foreach ( $args as &$arg ) {
				if ( is_string( $arg ) ) {
					$arg = $this->__( $arg );
				}
			}
			
			return call_user_func_array( "sprintf", $args );
		}
		
		function OnInit() {
		
		}
		
		final function LinksActions( $links ) {
			//$links[] = "<a class='edit coption' href='admin.php?page=".$this->pluginNameWSp."'>".__("Settings",$this->pluginBaseName)."</a><br/><br/>".'&nbsp;&nbsp;&nbsp;<iframe layout=""  src="https://www.facebook.com/plugins/like.php?href=http://www.appsbd.com"scrolling="no" frameborder="0"style="border:none; width:200px; height:37px"></iframe><br/><iframe src="http://demo.appsbd.com/twitter.html"scrolling="no" frameborder="0"style="border:none; width:200px; height:37px"></iframe><div id="myCustom"><a id="ratethis" href="#">'.__("Rate This",$this->pluginBaseName).'</a> </div>';
			$links[] = "<a class='edit coption' href='admin.php?page=" . $this->pluginSlugName . "'>" . $this->__( "Settings", $this->pluginSlugName ) . "</a><br/><br/>";
			foreach ( $this->moduleList as $moduleObject ) {
				$moduleObject->LinksActions( $links );
			}
			
			return $links;
		}
		
		final function PluginRowMeta( $plugin_meta, $plugin_file ) {
			if ( $plugin_file == plugin_basename( $this->pluginFile ) ) {
				foreach ( $this->moduleList as $moduleObject ) {
					$moduleObject->PluginRowMeta( $plugin_meta );
				}
			}
			
			return $plugin_meta;
		}
		
		final function _ClientScriptCore() {
			$this->SetClientScript();
		}
		
		final function _ClientStyleCore() {
			$this->SetClientStyle();
		}
		
		final function _AdminScriptCore() {
			$this->SetAdminScript();
		}
		
		final function _AdminStyleCore() {
			$this->SetAdminStyle();
		}
		
		final function OnActive() {
			foreach ( $this->moduleList as $moduleObject ) {
				$moduleObject->OnTableCreate();
				$moduleObject->OnActive();
			}
		}
		
		final function OnDeactive() {
			foreach ( $this->moduleList as $moduleObject ) {
				if ( $moduleObject->OnDeactive() ) {
					return true;
				}
			}
		}
		
		function getActiveModuleId() {
			$selected = ( ! empty( $_COOKIE[ $this->pluginSlugName . '_st_menu' ] ) ) ? $_COOKIE[ $this->pluginSlugName . '_st_menu' ] : "";
			if ( ! empty( $selected ) ) {
				return $selected;
			}
			if ( $this->is_countable($this->moduleList) && count( $this->moduleList ) > 0 ) {
				return $this->moduleList[0]->GetModuleId();
			}
			
			return "";
		}
		
		/**
		 * @param AppsBDBaseModule $moduleObject
		 * @param string $currentModuleId
		 */
		function geMenuTabItem( $moduleObject, $activeModuleId ) {
			$currentModuleId = $moduleObject->GetModuleId();
			?>
            <li  class="nav-item">
                <a id="tb-<?php echo $currentModuleId; ?>" data-module-id="<?php echo $currentModuleId; ?>" title="<?php echo $moduleObject->GetMenuTitle(); ?>"
                   data-placement="right"
                   class="app-tooltip nav-link <?php echo $activeModuleId == $currentModuleId ? ' active ' : ''; ?>"
                   data-toggle="pill" href="#<?php echo $currentModuleId; ?>">
                    <i class="<?php echo $moduleObject->GetMenuIcon(); ?> pull-left"></i>
                    <span class="apd-title"><?php echo $moduleObject->GetMenuTitle(); ?></span>
					<?php echo $moduleObject->GetMenuCounter(); ?>
                    <span class="apd-sub-title"><?php echo $moduleObject->GetMenuSubTitle(); ?></span>
                </a>
            </li>
			<?php
		}
		function isMenuOpen(){
		 
			return !isset($_COOKIE[ $this->pluginSlugName . '_sel_menu' ]) || !empty( $_COOKIE[ $this->pluginSlugName . '_sel_menu' ]);
        }
		function getMenuTab() {
			if ( ! $this->isTabMenu ) {
				return;
			}
			$activeModuleId  = $this->getActiveModuleId();
			$isMenuOpen      = $this->isMenuOpen();
			$lastMenu        = NULL;
			$currentModuleId = "";
			?>
            <!-- Nav pills -->
            <nav id="apd-sidebar" class="<?php echo( $isMenuOpen ? ' active ' : '' ); ?>">
                <ul class="nav flex-column">
					<?php foreach ( $this->moduleList as $moduleObject ) {
						if ( $moduleObject->isDisabledMenu() ) {
							continue;
						}
						if ( $moduleObject->isHiddenModule() ) {
							continue;
						}
						if ( empty( $lastMenu ) && $moduleObject->isLastMenu() ) {
							$lastMenu = $moduleObject;
							continue;
						}
						$this->geMenuTabItem( $moduleObject, $activeModuleId );
					}
						if ( ! empty( $lastMenu ) ) {
							$this->geMenuTabItem( $lastMenu, $activeModuleId );
						}
					?>

                </ul>
            </nav>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    $('#apd-sidebar a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
                        e.target; // newly activated tab
                        e.relatedTarget; // previous active tab
                        var onactivated = $(e.target).data("module-id");
                        try {
                            APPSBDAPPJS.core.CallOnTabActive(onactivated);
                            APPSBDAPPJS.core.SetCookie("<?php echo $this->pluginSlugName . '_st_menu' ?>", onactivated, 30, "/");
                        } catch (e) {
                        }
                        try {
                            $('.app-right-menu .navbar-nav .nav-link').removeClass("active");
                        } catch (e) {
                        }
                    });

                    $('.app-right-menu .navbar-nav .nav-link').on('click', function (e) {
                        $("#apd-sidebar .nav .nav-item a.nav-link").removeClass("active");
                    });
                    try {
                        APPSBDAPPJS.core.CallOnTabActive("<?php echo $activeModuleId; ?>");
                    } catch (e) {
                    }
                });

            </script>
			<?php
		}
		
		function OptionFormCore() {
			$isMenuOpen = $this->isMenuOpen();
			?>

            <div id="APPSBDWP" class="APPSBDWP" data-cookie-id="<?php echo $this->pluginSlugName; ?>">
                <div class="apsbd-main-container container-fluid">

                    <div class="apsbd-main-card card">
                        <div class="card-header">
							<?php if ( $this->isTabMenu ) { ?>
                                <button type="button" id="apd-main-btn"
                                        class="btn btn-default pull-left <?php echo $isMenuOpen ? ' mini-menu on-pre-mini ' : ''; ?>">
                                    <i class="fa fa-align-justify"></i>
                                </button>
							<?php } ?>
                            <h2 class="apd-app-title">
								<?php if ( empty( $this->pluginIconClass ) ) { ?>
                                    <img class="apd-plugin-logo"
                                         src="<?php echo plugins_url( "images/logo.svg", $this->pluginFile ); ?>"
                                         alt="<?php echo $this->pluginName; ?>">
								<?php } else { ?>
                                    <i class="apnd-plugin-main-icon <?php echo $this->pluginIconClass; ?>"></i> <?php echo $this->pluginName; ?>
								<?php } ?>
                            </h2>
							<?php
								if ( $this->is_countable($this->moduleList) && count( $this->_topmenu ) > 0 ) {
									?>
                                    <div class="app-right-menu">
                                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                                    data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup"
                                                    aria-expanded="false" aria-label="Toggle navigation">
                                                <i class="fa fa-align-justify"></i>
                                            </button>
                                            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                                                <div class="navbar-nav nav-tabs nav">
													<?php foreach ( $this->_topmenu as $skey => $topmenu ) {
														?>
                                                        <a class="<?php echo $topmenu->class; ?> nav-item nav-link top-tab-link" <?php echo $topmenu->istab ? ' data-toggle="tab"  ' : ''; ?>
                                                           href="<?php echo $topmenu->istab && is_callable( $topmenu->func ) ? '#_t_tab' . $skey : $topmenu->func; ?>" <?php echo $topmenu->attr; ?> ><?php if ( ! empty( $topmenu->icon ) ) { ?>
                                                                <i class="<?php echo $topmenu->icon; ?>"></i> <?php }
																echo $topmenu->title; ?></a>
														<?php
													} ?>
                                                </div>
                                            </div>
                                        </nav>
                                    </div>
								<?php } ?>
                        </div>
                        <div class="card-body ">
							<?php
								
								if ( $this->isTabMenu ){ ?>
                            <div class="wrapper">
								<?php $this->getMenuTab(); ?>
                                <!-- Page Content  -->
                                <div id="content" class="pos-relative pt-0">
									<?php } ?>
                                    <div id="apbd-app-loader" class="apbd-app-loader ">
                                        <div class="text-center" id="apbd-app-waiting">
                                            <img src="<?php echo plugins_url( "images/lighboxloader.svg", $this->pluginFile ); ?>"
                                                 style="max-height: 50px;" alt="<?php $this->_e( "Loading.." ); ?>">
                                            <br>
                                            <h4 data-default-msg="<?php $this->_e( "Loading" ); ?>"></h4>
                                        </div>
                                    </div>
                                    <!-- Tab panes -->
                                    <div class="<?php echo( $this->isTabMenu ? ' tab-content ' : ' col-md ' ) ?>">
										<?php
											if ( $this->is_countable($this->moduleList) && count( $this->moduleList ) > 0 ) {
												$activeClassId = $this->getActiveModuleId();
												foreach ( $this->moduleList as $moduleObject ) {
													if ( $moduleObject->isHiddenModule() ) {
														continue;
													}
													$currentModuleId = $moduleObject->GetModuleId();
													?>
                                                    <div class="apbd-module-container <?php echo $this->isTabMenu ? ' tab-pane ' . ( $activeClassId == $currentModuleId ? ' active ' : '' ) : ''; ?>"
                                                         id="<?php echo $currentModuleId; ?>">
														<?php
															if ( ! $moduleObject->isDontAddDefaultForm() ){
														?>
                                                        <form class="apbd-module-form <?php echo $moduleObject->getFormClass(); ?>"
                                                              role="form"
                                                              id="<?php echo $moduleObject->GetMainFormId(); ?>"
                                                              action="<?php echo $moduleObject->GetActionUrl( "" ); ?>"
                                                              method="post" <?php echo $moduleObject->isMultipartForm() ? ' enctype="multipart/form-data" ' : ''; ?>>
															
															<?php
																}
																if ( $this->isTabMenu ) {
																	ob_start();
																	$moduleObject->OptionFormHeader();
																	$mheader = ob_get_clean();
																	if ( ! empty( $mheader ) ) {
																		?>
                                                                        <div class="app-module-title clearfix">
																			<?php
																				echo $mheader;
																			?>
                                                                        </div>
																		<?php
																	}
																}
															?>
                                                            <div class="">
																<?php
																	$moduleObject->SettingsPage(); ?>
                                                            </div>
															<?php if ( ! $moduleObject->isDontAddDefaultForm() ){ ?>
                                                        </form>
													<?php } ?>
                                                    </div>
													<?php
												}
											} else {
												?>
                                                No module added
												<?php
											}
											
											foreach ( $this->_topmenu as $skey => $topmenu ) {
												if ( $topmenu->istab && is_callable( $topmenu->func ) ) {
													?>
                                                    <div class="tab-pane fade" id="_t_tab<?php echo $skey; ?>">
														<?php call_user_func( $topmenu->func ); ?>
                                                    </div>
													<?php
												}
											} ?>
                                    </div>
									
									
									<?php if ( $this->isTabMenu ){ ?>
                                </div>
                            </div>
						<?php }
						
						do_action($this->getHookActionStr("app-content-footer"));
						
						?>
                        </div>
                        <div class="card-footer text-muted text-center">
                           <?php do_action($this->getHookActionStr("app-footer-top")); ?>
							<?php echo $this->pluginName ?>, Copyright © <?php echo date( 'Y' ); ?> <a
                                    href="https://appsbd.com">appsbd.com</a>. All rights reserved.
                            <span class="pull-right">Version : <?php echo $this->pluginVersion; ?></span>
                        </div>
                    </div>

                </div>
                    <?php do_action($this->getHookActionStr("app-footer")); ?>
            </div>
			<?php
		}
		
		final private function _getHeaderHtml() {
			$this->GetHeaderHtml();
		}
		final function StartPlugin() {
			add_filter( 'plugin_action_links_' . plugin_basename( $this->pluginFile ), [ $this, 'LinksActions' ], - 10 );
			add_filter( 'plugin_row_meta', [ $this, 'PluginRowMeta' ], 10, 2 );
			add_action( 'init', [ $this, "_Init" ] );
			register_activation_hook( $this->pluginFile, [ $this, 'OnActive' ] );
			register_deactivation_hook( $this->pluginFile, [ $this, 'OnDeactive' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'AddJquery' ] );
			add_action( 'wp_head', [ $this, 'WpHead' ], 9999 );
			add_action( 'admin_enqueue_scripts', [ $this, '_AdminScriptCore' ], 9999 );
			add_action( 'admin_print_styles', [ $this, '_AdminStyleCore' ] );
			add_action( 'admin_print_scripts', [ $this, 'AdminScriptData' ], 9999 );
			add_action( 'wp_enqueue_scripts', [ $this, '_ClientScriptCore' ], 999 );
			add_action( 'wp_print_styles', [ $this, '_ClientStyleCore' ], 998 );
			add_action( 'admin_menu', [ $this, "AdminMenu" ] );
            add_action( 'admin_notices', [ $this, "OnAdminNotices" ]);
		}
		
	}
}
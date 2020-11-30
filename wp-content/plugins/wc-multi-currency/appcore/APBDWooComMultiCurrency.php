<?php
/**
 * Woo Commerce Multi Currency
 * Author: S M Sarwar Hasan
 * A Product of appsbd.com
 */
	
APBD_LoadCore("AppsBDKarnelLite","AppsBDKarnelLite",__FILE__);
class APBDWooComMultiCurrency extends AppsBDKarnelLite {
	function __construct( $pluginBaseFile, $version = '1.0.0' ) {
		//"APBLIC","Elite Licenser","1.0.0.13"
		$this->pluginFile     = $pluginBaseFile;
		$this->pluginSlugName = 'wc-multi-currency';//'APWOMC  WCMULTICURRENCY';
		$this->pluginName     = $this->__('Multi Currency for WooCommerce');
		$this->pluginVersion  = $version;
		parent::__construct($pluginBaseFile,$version);
		$this->setMenuTitle("Multi Currency");
	}
	
	public function initialize() {
		parent::initialize();
		$this->SetPluginIconClass("ap ap-elite-licenser","dashicons-wc-multi-currency");
		$this->setSetActionPrefix("woocommultic");
		
		$this->AddLiteModule("APBDWMC_general");
		$this->AddLiteModule("APBDWMC_location");
		//$this->AddModule("APBDWMC_advance");
		$this->AddLiteModule("APBDWMC_payment_currency");
		$this->AddLiteModule("APBDWMC_design");
		$this->AddLiteModule("APBDWMC_instruction");
		$this->AddLiteModule("APBDWMC_recommended");
		add_action( 'admin_notices', array( $this, 'cachePluginAdminNote' ) );
		
	}

	function GetHeaderHtml() {
	
	}

	function GetFooterHtml() {
	
	}
	public function OnAdminAppStyles() {
		parent::OnAdminAppStyles();
		//$this->AddAdminStyle("bootstrap-material-css","uilib/material/material.css",true);
		$this->AddAdminStyle("select2-css","uilib/select2/css/select2.min.css",true);
		$this->AddAdminStyle("httheme-css","uilib/httheme/css/style.css",true);



	}
	public function OnAdminAppScripts() {
		parent::OnAdminAppScripts();
		//$this->AddAdminScript( "bootstrap-material-js", "uilib/bootstrap-material/js/material.min.js", true );
		
		$this->AddAdminScript( "appsbd-jquery-ui", "uilib/httheme/js/jquery-ui.min.js", true );
		$this->AddAdminScript( "httheme-js", "uilib/httheme/js/modernizr-3.6.0.min.js", true );
		$this->AddAdminScript("select2-js","uilib/select2/js/select2.min.js",true);
		$this->AddAdminScript( "httheme-js", "uilib/httheme/js/main.min.js", true );


	}
	function geMenuTabItem( $moduleObject, $activeModuleId ) {
		$currentModuleId = $moduleObject->GetModuleId();
		?>
        <li>
            <a id="tb-<?php echo $currentModuleId; ?>" data-module-id="<?php echo $currentModuleId; ?>" href="#<?php echo $currentModuleId; ?>" class="<?php echo $activeModuleId == $currentModuleId ? ' active ' : ''; ?>"><span> <i class="<?php echo $moduleObject->GetMenuIcon(); ?>"></i> <?php echo $moduleObject->GetMenuTitle(); ?></span></a>
        </li>
        
		<?php
	}
	public function cachePluginAdminNote() {
		if(!$this->CheckAdminPage()){
		    return;
        }
		if ( is_plugin_active( 'wp-super-cache/wp-cache.php' ) && ! is_plugin_active( 'country-caching-extension-for-wp-super-cache/cc_wpsc_init.php' ) ) { ?>
            <div class="notice notice-warning">
                <div class="appsbd-content">
                    <p>
						<?php  $this->_e( 'You are using <strong>WP Super Cache</strong>. Please install and active <strong>Country Caching For WP Super Cache</strong> that helps <strong>Multi Currency for WooCommerce</strong> is working fine with WP Super Cache.' ) ?>
                    </p>
                </div>
            </div>
		<?php }
		
		if ( is_plugin_active( 'wp-fastest-cache/wpFastestCache.php' ) ) { ?>
            <div class="notice notice-warning">

                <div class="appsbd-content">
                    <p>
						<?php  $this->_e( 'You are using <strong>WP Fastest Cache</strong>. Please make follow these steps to help <strong>Multi Currency for WooCommerce</strong> work fine with WP Fastest Cache.' ) ?>
                    </p>
                    <ul>
                        <li><?php  $this->_e( 'i. In %s  make sure you have selected: %s','<strong>WooCommerce → Settings → General → Default customer location</strong>','<strong>Geolocate with page caching support</strong>') ?></li>
                        <li><?php  $this->_e( 'ii. Open wp-config.php file via FTP then insert %s','<strong>define(\'WPFC_CACHE_QUERYSTRING\', true);</strong>') ?></li>
                    </ul>

                </div>

            </div>
		<?php }
		
	}
	function getMenuTab() {
		if ( ! $this->isTabMenu ) {
			return;
		}
		$activeModuleId  = $this->getActiveModuleId();
		$isMenuOpen      = ! isset( $_COOKIE[ $this->pluginSlugName . '_sel_menu' ] ) || ! empty( $_COOKIE[ $this->pluginSlugName . '_sel_menu' ] );
		$lastMenu        = NULL;
		$currentModuleId = "";
		?>
        <!--Tab Nav Start-->
        <ul id="ht-mcs-tab-nav" class="ht-mcs-main-tab-nav ht-mcs-tab-nav">
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
        <!--Tab Nav End-->
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('#ht-mcs-tab-nav').on('click', 'a:not(.active)',function (e) {
                    var onactivated = $(this).data("module-id");
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
	public function OptionFormCore() {
		?>
    <div id="APPSBDWP" data-cookie-id="<?php echo $this->pluginSlugName; ?>" class="APPSBDWPP">
		<!--Main Container Start-->
		<div id="ht-mcs"   class="apsbd-main-container container-fluid ht-mcs-container">
			
            <?php
	            if ( $this->isTabMenu) {
		            //--Tab Nav Start
		            $this->getMenuTab();
		            //--Tab Nav End--
	            } ?>
			<?php  ?>
			
			
			<!--Main Content Wrapper Start-->
			<div class="ht-mcs-wrapper">
				
				<!--Tab Content Start-->
				<div class="ht-mcs-tab-content">
					<?php
						if ( $this->is_countable($this->moduleList) && count( $this->moduleList ) > 0 ) {
							$activeClassId = $this->getActiveModuleId();
							foreach ( $this->moduleList as $moduleObject ) {
								if ( $moduleObject->isHiddenModule() ) {
									continue;
								}
								$currentModuleId = $moduleObject->GetModuleId();
								?>

                                <div id="<?php echo $currentModuleId; ?>" class=" <?php echo $this->isTabMenu ? ' ht-mcs-tab-pane ' . ( $activeClassId == $currentModuleId ? ' active ' : '' ) : ''; ?>">
                                    <div class="ht-mcs-tab-pane-body">
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
	                                    $moduleObject->SettingsPage();
	                                    if ( ! $moduleObject->isDontAddDefaultForm() ){ ?>
                                        </form>
                                    <?php } ?>

                                    </div>
                                </div>
								<?php
							}
						} else {
							?>
                            No module added
							<?php
						}
						do_action($this->getHookActionStr("app-content-footer"));
                    ?>
				</div>
				<!--Tab Content End-->
			
			</div>
			<!--Main Content Wrapper End-->
		
		</div>
        <?php do_action($this->getHookActionStr("app-footer")); ?>
		<!--Main Container End-->
    </div>
		<?php
	}
	
	static function StartApp( $fileName ) {

	}
}
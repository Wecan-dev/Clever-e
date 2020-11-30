<?php
	/**
	 * @since: 07/09/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	
	class APBDWMC_recommended extends AppsBDLiteModule{
		function initialize() {
			parent::initialize();
		}
		function GetMenuSubTitle() {
			return $this->__("Useful Plugins");
		}
		
		function GetMenuIcon() {
			return 'fa fa-thumbs-up';
		}
		
		function SettingsPage() {
			$this->Display();
		}
		function isInstalledAddon($plugin_path) {
			$plugins = get_plugins();
			return isset( $plugins[ $plugin_path ] );
		}
		function isActivatedAddon($plugin_path) {
			$activates = get_option( 'active_plugins' );
			return in_array($plugin_path,$activates);
		}
		function get_nonce_url($plugin_slug,$action='install-plugin'){
			return wp_nonce_url(
				add_query_arg(
					array(
						'action' => $action,
						'plugin' => $plugin_slug
					),
					admin_url( 'update.php' )
				),
				$action . '_' . $plugin_slug
			);
		}
		function get_install_url($plugin_slug) {
			return $this->get_nonce_url($plugin_slug,'install-plugin');
		}
		function get_activate_install_url($plugin_path) {
			$activateUrl = sprintf(admin_url('plugins.php?action=activate&plugin=%s&plugin_status=all&paged=1&s'), $plugin_path);
			
			// change the plugin request to the plugin to pass the nonce check
			$_REQUEST['plugin'] = $plugin_path;
			$activateUrl = wp_nonce_url($activateUrl, 'activate-plugin_' . $plugin_path);
			
			return $activateUrl;
		}
		function getButtonInstallLink($slug,$plugin_path,$pro_version_paths=[]){
			$response=new stdClass();
			$response->title="Install";
			$response->cssClass="btn-success";
			$response->isDisabled=false;
			$response->url=$this->get_install_url($slug);
			foreach ( $pro_version_paths as $pro_version_path_link ) {
				if($this->isInstalledAddon($pro_version_path_link)) {
					if (!$this->isActivatedAddon( $pro_version_path_link ) ) {
						$response             = new stdClass();
						$response->title      = "Active";
						$response->cssClass   = "btn-success";
						$response->isDisabled = false;
						$response->url        = $this->get_activate_install_url( $pro_version_path_link );
						return $response;
					}else{
						$response             = new stdClass();
						$response->title      = "Activated";
						$response->cssClass   = "btn-secondary";
						$response->isDisabled = true;
						$response->url        = "";
						return $response;
					}
				}
			}
			
			if(!$this->isInstalledAddon($plugin_path)){
				return $response;
			}elseif(!$this->isActivatedAddon($plugin_path)){
				$response=new stdClass();
				$response->title="Active";
				$response->cssClass="btn-success";
				$response->isDisabled=false;
				$response->url=$this->get_activate_install_url($plugin_path);
				return $response;
			}else{
				
				
				$response=new stdClass();
				$response->title="Activated";
				$response->cssClass="btn-secondary";
				$response->isDisabled=true;
				$response->url='';
				return $response;
			}
			
		}
		function getButtonInstallLinkHtml($slug,$plugin_path,$pro_version_paths=[]) {
			$pluginObject=$this->getButtonInstallLink($slug,$plugin_path,$pro_version_paths);
			ob_start();
			if(!empty($pluginObject->isDisabled)) {?>
			<button  class="btn  <?php echo $pluginObject->cssClass; ?> btn-sm" disabled ><?php echo $pluginObject->title; ?></button>
			<?php }else{?>
			<a href="<?php echo $pluginObject->url; ?>" target="_blank" class="btn  <?php echo $pluginObject->cssClass; ?> btn-sm" <?php echo !empty($pluginObject->isDisabled)?"disabled":""; ?> ><?php echo $pluginObject->title; ?></a>
			<?php }
			return ob_get_clean();
		}
		function GetMenuTitle() {
			return $this->__("Recommended");
		}
		
	}
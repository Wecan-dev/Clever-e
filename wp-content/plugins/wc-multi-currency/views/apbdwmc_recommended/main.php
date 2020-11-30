<?php /** @var APBDWMC_recommended $this */
	/*$plugins = get_plugins();
	APBD_GPrint($plugins);*/
?>
<div class="apbd-recommended-container mt-3">
    <div class="card-deck mb-3">
        <div class="card animated ape-fadeIn">
            <div class="card-body">
                <div class="card-title">
                    <div class="apbd-app-logo">
                        <img class="img-fluid" src="<?php echo plugins_url("images/recommended/mini-cart.png",$this->pluginFile); ?>" alt="">
                    </div>
                    <div class="apbd-app-title">
                        Mini Cart Drawer For WooCommerce
                        <small>By appsbd</small>
                    </div>
                </div>
                <div class="app-rec-dtls">
                    Mini Cart Drawer is an interaction mini cart with many styles, color and effects for WooCommerce. You can change quantity of a product and also can remove from cart. It has nice control panel aslo has customizer panel. By this you can change the its configuration with live preview. It is fully ajax based mini cart.
                </div>
                
            </div>
            <div class="card-footer app-rec-buttons text-right">
	            <?php
                    echo $this->getButtonInstallLinkHtml("woo-mini-cart-drawer","woominicartajax/woo-mini-cart-drawer.php",['woominicartpro/woominicartpro.php']);
                    
                    ?>
                    <a href="https://appsbd.com/minicartpro" target="_blank" class="btn btn-info btn-sm">View Details</a>
                
            </div>
        </div>
        <div class="card animated ape-fadeIn">
            <div class="card-body">
                <div class="card-title">
                    <div class="apbd-app-logo">
                        <img class="img-fluid" src="<?php echo plugins_url("images/recommended/elite-addons.png",$this->pluginFile); ?>" alt="">
                    </div>
                    <div class="apbd-app-title">
                        Elite Licenser for WooCommerce
                        <small>By appsbd</small>
                    </div>
                </div>
                <div class="app-rec-dtls">
                    Elite Licenser is a WordPress plugin for any types of product licensing. It also manages product updates, auto generates license code, built in Envato licensing verification system, full license control and more. It has full set of API, so you can handle it by any types of applications.
                </div>
              
            </div>
            <div class="card-footer app-rec-buttons text-right">
                <?php echo $this->getButtonInstallLinkHtml("elite-licenser-lite","elite-licenser-lite/elitelicenserlite.php",['elite-licenser/elitelicenser.php']); ?>
                <a href="https://appsbd.com/elitepro" target="_blank" class="btn btn-info btn-sm">View Details</a>
            </div>
        </div>
        <div class="card animated ape-fadeIn">
            <div class="card-body">
                <div class="card-title">
                    <div class="apbd-app-logo">
                        <img class="img-fluid" src="<?php echo plugins_url("images/recommended/woolentor.png",$this->pluginFile); ?>" alt="">
                    </div>
                    <div class="apbd-app-title">
                        WooLentor
                        <small>By HasThemes</small>
                    </div>
                </div>
                <div class="app-rec-dtls">
	               
                    WooLentor is the most popular WooCommerce Elementor addon and Page builder, trusted by more than 15000 online stores. This plugin allows creating custom templates for the shop, category, product, my account, cart, checkout pages, etc..Both the free and pro versions are available.
                </div>
            </div>
            <div class="card-footer app-rec-buttons text-right">
	            <?php echo $this->getButtonInstallLinkHtml("woolentor-addons","woolentor-addons/woolentor_addons_elementor.php"); ?>
                <a href="https://hasthemes.com/tfns" target="_blank" class="btn btn-info btn-sm">View Details</a>
            </div>
        </div>
    </div>
</div>

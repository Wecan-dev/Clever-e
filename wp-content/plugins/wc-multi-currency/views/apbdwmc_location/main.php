<?php /** @var APBDWMC_location $this */
	//echo $this->GetActionUrl("get-rate");
?>
<div class="row">
    <h3 class="w-100 pl-3"><?php $this->_e("Location Based Currency") ; ?></h3>
    <hr class="w-100">
</div>
<?php
    $ip           = new WC_Geolocation();
    $geo_ip       = $ip->geolocate_ip();
    if(version_compare(WC()->version,'4.0','>=') && (empty($geo_ip['country']))){
        ?>
        <div class="notice apbd-notice notice-error  apbd-with-bg p-3 mb-3">
            <p><b><?php $this->_e("This feature may not work properly") ; ?></b><br><?php $this->_e("Your WooCommerce(%s) geo ip API doesn't returning country based on IP, Please check WooCommerce Geolocation settings. %s to check MaxMind Settings",WC()->version,'<a class="ml-3 mr-3 btn btn-info btn-sm " href="'.admin_url('admin.php?page=wc-settings&tab=integration&section=maxmind_geolocation').'">'.$this->__("Click Here").'</a>') ; ?></p>
        </div>
        <?php
    }
?>
<div class="ht-mcs-table-responsive">
    <input type="hidden"  name="isEnable">
    <?php /*echo $this->GetActionUrl("ipinfo");*/ ?>
    <div class="card  mb-3">
        <div class="card-header app-header-color">
            <div class="row">
                <div class="form-inline col-sm">
                    <div class="form-group">
                        <label for="ht-is-enable" class="mr-3 text-bold"><?php $this->_e("Enable") ; ?></label>
                        <div class="ht-mcs-switcher-wrap inline">
                            <div class="ht-mcs-switcher">
                                <input name="isEnable" id="ht-is-enable" <?php echo $this->GetOption("isEnable","N")=="Y"?" checked ":"" ?>value="Y" type="checkbox">
                                <label for="ht-is-enable">Off</label>
                            </div>
                        </div>
                    </div>
                   
                </div>
                <div class="col-sm text-right">
                    <button type="submit" class="btn btn-success btn-icon-left"><i class="fa fa-save"></i> <?php $this->_e("Save") ; ?></button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
	       
            <table class="ht-mcs-table">
                <thead class="d-none d-sm-table-header">
                <tr>
                    <th class=""><?php $this->_e("Currency") ; ?></th>
                    <th class=""><?php $this->_e("Countries") ; ?></th>
                </tr>
                </thead>
                <tbody id="currency-location-container">
		        <?php
                    $this->getCountryCurrencyHtml();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
   
    <div class=" text-right">
        <button type="submit" class="btn btn-success btn-icon-left"><i class="fa fa-save"></i> <?php $this->_e("Save") ; ?></button>
    </div>
</div>
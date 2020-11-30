<?php /** @var APBDWMC_design $this */
	//echo $this->GetActionUrl("get-rate");
?>
<div class="row">
    <h3 class="w-100 pl-3"><?php $this->_e("Design") ; ?></h3>
    <hr class="w-100">
</div>
<div class="card ht-in-control-panel  mb-3">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-form-label col-lg-3 align-middle"  style="line-height: 5.5rem;" for="wid_pos"><?php $this->_e("Widget Position"); ?></label>
            <div class="col-lg">
                <div class="">
				    <?php
					    $app_chat_pattern_selected= $this->GetOption("wid_pos","L");
					    $app_wg_pos_option = [
						    "N"  => '<img src="' . plugins_url( 'images/wid-none-2.jpg', $this->pluginFile ) . '"/>',
						    "L"  => '<img src="' . plugins_url( 'images/left-middle.jpg', $this->pluginFile ) . '"/>',
						    "B"  => '<img src="' . plugins_url( 'images/left-bottom.jpg', $this->pluginFile ) . '"/>',
						    "R"  => '<img src="' . plugins_url( 'images/right-middle.jpg', $this->pluginFile ) . '"/>',
						    "V"  => '<img src="' . plugins_url( 'images/right-bottom.jpg', $this->pluginFile ) . '"/>',
					    ];
					    APBD_GetHTMLRadioBoxByArray("Widget Possition","wid_pos","wid_pos",true,$app_wg_pos_option,$app_chat_pattern_selected,false,"#e8fffd",'bg-green');
				    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="ht-control-title">
                <?php $this->_e("Currency Switcher To Menu") ; ?>
               
                    <button class="ml-3 btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
               
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group row mt-3">
                    <label for="ht-isDDMenu" class="mr-3 text-bold col-lg-5"><?php $this->_e("Enable") ; ?></label>
                    <div class="col-lg ht-mcs-switcher-wrap inline">
                        <div class="ht-mcs-switcher">
                            <button class="ml-3 btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
                        </div>
                    </div>
                </div>
	            <?php
		            //$locations      = get_registered_nav_menus();
		            $nav_menus  = wp_get_nav_menus();
		            //$menu_locations = get_nav_menu_locations();
	            ?>
                <div class="form-group row mt-3 ">
                    <label for="ht-isDDSymMenu" class="mr-3 text-bold col-lg-5"><?php $this->_e("Only Show Currency Flag & Symbol") ; ?></label>
                    <div class="col-lg ht-mcs-switcher-wrap inline">
                        <div class="ht-mcs-switcher">
                            <button class="ml-3 btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row mt-3 ">
                    <label for="isDDShowCode" class="mr-3 text-bold col-lg-5"><?php $this->_e("Show Currency Code instead of Symbol") ; ?></label>
                    <div class="col-lg ht-mcs-switcher-wrap inline">
                        <div class="ht-mcs-switcher">
                            <button class="ml-3 btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <label for="ht-isDDMenu" class="mr-3 text-bold col-lg-5"><?php $this->_e("Choose Menu") ; ?></label>
                    <div class="col-lg">
                        <div class="ht-mcs-switcher">
                            <button class="ml-3 btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
                        </div>

                    </div>
                </div>
                <div class="form-group row mt-3">
                    <label for="ht-isDDMenu" class="mr-3 text-bold col-lg-5 pt-3"><?php $this->_e("Menu Margin") ; ?></label>
                    <div class="col-lg">
                        <div class="ht-mcs-switcher">
                            <button class="ml-3 btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
                        </div>
                    </div>
                </div>

                <div class="form-group row mt-3">
                    <label for="menu_title_color" class="mr-3 text-bold col-lg-5 pt-3"><?php $this->_e("Menu Title Color") ; ?></label>
                    <div class="col-lg">
                        <div class="ht-mcs-switcher">
                            <button class="ml-3 btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <label for="dropdown_text_color" class="mr-3 text-bold col-lg-5 pt-3"><?php $this->_e("Dropdown Text Color") ; ?></label>
                    <div class="col-lg">
                        <div class="ht-mcs-switcher">
                            <button class="ml-3 btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
                        </div>
                    </div>
                </div>

                <div class="form-group row mt-3">
                    <label for="dropdown_bg_color" class="mr-3 text-bold col-lg-5 pt-3"><?php $this->_e("Dropdown Background") ; ?></label>
                    <div class="col-lg">
                        <div class="ht-mcs-switcher">
                            <button class="ml-3 btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <label for="dropdown_ih_color" class="mr-3 text-bold col-lg-5 pt-3"><?php $this->_e("Dropdown Item Hover Background") ; ?></label>
                    <div class="col-lg">
                        <div class="ht-mcs-switcher">
                            <button class="ml-3 btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
                        </div>
                    </div>
                </div>

                <div class="form-group row mt-3 ">
                    <label for="isDDTitleHide" class="mr-3 text-bold col-lg-5"><?php $this->_e("Hide Currency Title From Dropdown") ; ?></label>
                    <div class="col-lg">
                        <div class="ht-mcs-switcher">
                            <button class="ml-3 btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row mt-3 ">
                    <label for="isDDFlagHide" class="mr-3 text-bold col-lg-5"><?php $this->_e("Hide Flag From Dropdown") ; ?></label>
                    <div class="col-lg">
                        <div class="ht-mcs-switcher">
                            <button class="ml-3 btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row mt-3 ">
                    <label for="isDropdownHeight" class="mr-3 text-bold col-lg-5"><?php $this->_e("Dropdown Max Height") ; ?></label>
                    <div class="col-lg">
                        <div class="ht-mcs-switcher">
                            <button class="ml-3 btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
                        </div>
                    </div>
                </div>

                <div class="form-group row mt-3 ">
                    <label for="ddAnimation" class="mr-3 text-bold col-lg-5"><?php $this->_e("Choose Dropdown Animation") ; ?></label>
                    <div class="col-lg">
                        <div class="ht-mcs-switcher">
                            <button class="ml-3 btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 p-3">
                <div class="card ">
                    <img class="card-img-top" src="<?php echo plugins_url('images/top-menu.jpg',$this->pluginFile); ?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><?php $this->_e("Enable Currency Switcher Into menu") ; ?></h5>
                        <p class="card-text"><?php $this->_e("You can easily add currency switcher into menu") ; ?></p>

                        <button class="btn btn-lg btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row"></div>
    
    
</div>
<div class=" text-sm-right pr-3">
    <button type="submit" class="btn btn-success btn-icon-left"><i class="fa fa-save"></i> <?php $this->_e("Save") ; ?></button>
</div>


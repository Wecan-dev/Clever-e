<?php /** @var APBDWMC_instruction $this */
//echo $this->GetActionUrl("get-rate");
?>
<div class="row">
    <h3 class="w-100 pl-3"><?php $this->_e("Instructions") ; ?></h3>
    <hr class="w-100">
</div>
<div class="">
    <div class="row">
    <div class="col-sm-6">
        <h3  class="mt-3"><?php $this->_e("Shortcodes") ; ?></h3>
        <h5 ><?php $this->_e("Default Shortcode") ; ?></h5>

        <code>
            [WCMC]
        </code>
        <h5  class="mt-3"><?php $this->_e("Shortcode for only flag") ; ?></h5>
        <code>
            [WCMC style="flag"]
        </code>
        <div class="apbd-pro-required">
            <button class="ml-3 btn btn-lg btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
            <h5 class="mt-3"><?php $this->_e("Shortcode for dropdown") ; ?></h5>
            <code>
                [WCMC_DROPDOWN]
            </code><br>
            <code>
                [WCMC_DROPDOWN style  menu_color  ddtext ddbg ddihover ddtitlehide ddflaghide showcode ]

            </code>
            <div class="card mt-3">
                <div class="card-body p-0">
                    <table class="table ">
                        <tr>
                            <th>style</th>
                            <th>:</th>
                            <td>it can be <b>default</b> or <b>notitle</b>, it is for hide menu title</td>
                        </tr>
                        <tr>
                            <th>menu_color</th>
                            <th>:</th>
                            <td>set color code for menu title</td>
                        </tr>
                        <tr>
                            <th>ddtext</th>
                            <th>:</th>
                            <td>set color code for dropdown item text</td>
                        </tr>
                        <tr>
                            <th>ddbg</th>
                            <th>:</th>
                            <td>set color code for dropdown item background</td>
                        </tr>
                        <tr>
                            <th>ddihover</th>
                            <th>:</th>
                            <td>set color code for dropdown item hover</td>
                        </tr>
                        <tr>
                            <th>ddtitlehide</th>
                            <th>:</th>
                            <td>Set <b>Y</b> , if you want to hide <b>currency title</b></td>
                        </tr>
                        <tr>
                            <th>ddflaghide</th>
                            <th>:</th>
                            <td>Set <b>Y</b> , if you want to hide <b>flag from dropdown</b></td>
                        </tr>
                        <tr>
                            <th>showcode</th>
                            <th>:</th>
                            <td>Set <b>Y</b> , if you want to show <b>currency code</b> instead for <b>currency symbol</b></td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-danger text-center">Do not add property if you want to use default </th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
       
      

    </div>
    <div class="col-sm-6">
        <?php
            $ip           = new WC_Geolocation();
            $geo_ip       = $ip->geolocate_ip();
        ?>
        <h3><?php $this->_e("Your IP(%s) info",$ip->get_ip_address()) ; ?></h3>
        <table class="table">
                <tr>
                    <th><?php $this->_e("Country") ; ?></th>
                    <th>:</th>
                    <td><?php echo !empty($geo_ip['country'])?$geo_ip['country']:$this->__("Check you GeoLocation Settings"); ?></td>
                </tr>
        </table>
    </div>

    </div>
    
</div>
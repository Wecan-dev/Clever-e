<?php /** @var APBDWMC_general $this */
//echo $this->GetActionUrl("get-rate");
?>
<div class="ht-mcs-table-responsive">
    <table class="ht-mcs-table">
        <thead class="">
        <tr>
            <th class=""><?php $this->_e("Default") ; ?></th>
            <th class=""><?php $this->_e("Show") ; ?></th>
            <th class=""><?php $this->_e("Currency") ; ?></th>
            <th class=""><?php $this->_e("Position") ; ?></th>
            <th class=""><?php $this->_e("Rate") ; ?></th>
            <th class="" data-toggle="tooltip" title="<?php $this->_e("Final Rate = Rate + Exchange Fee") ; ?>"><?php $this->_e("Exchange Fee") ; ?> <i class="fa fa-info-circle"></i></th>
            <th class=""><?php $this->_e("Decimals") ; ?></th>
            <th class=""><?php $this->_e("Custom symbol") ; ?></th>
            <th class=""><?php $this->_e("Actions") ; ?></th>
        </tr>
        </thead>
        <tbody id="gn_currency_list">
    <?php
        $currencies=$this->getActiveCurrencies();
       /* echo "<pre>";
	    print_r($currencies);
	    echo "</pre>";*/
	    foreach ($currencies as $currency) {
	       APBD_get_mc_currency_row( $currency );
       }
	   
    ?>
        </tbody>
    </table>
    <div class="text-right">
        <button id="APBD_update_all_rate" class="btn btn-secondary btn-icon-left" data-title="<?php $this->_e("Confirmation") ; ?>" data-msg="<?php $this->_e("Are you sure to update all rates?") ; ?>" ><i class="fa fa-shopping-cart"></i><?php $this->_e("Update All Rates") ; ?></button>
        <button id="APBD_add_currency" class="btn btn-success btn-icon-left"><i class="fa fa-money"></i><?php $this->_e("Add Currency") ; ?></button>
    </div>
</div>
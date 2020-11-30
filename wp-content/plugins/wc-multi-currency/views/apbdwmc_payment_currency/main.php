<?php
	/** @var APBDWMC_payment_currency $this */
	/** @var WC_Payment_Gateways[] $gateways */
	
?>
<div class="row">
    <h3 class="w-100 pl-3"><?php $this->_e("Currency's payment Gateway") ; ?></h3>
    <hr class="w-100">
</div>
<div class="card  mb-3">
<div class="card-header app-header-color">
    <div class="row">
        <div class="form-inline col-sm">
            <div class="form-group">
                <label for="is_pmt_cur" class="mr-3 text-bold"><?php $this->_e("Enable") ; ?></label>
                <div class="ht-mcs-switcher-wrap inline">
                    <button class="btn btn-sm btn btn-warning apbd-pro-btn btn-icon-left"> <i class="fa fa-unlock"></i> <?php $this->_e("Unlock It") ; ?></button>
                </div>
            </div>

        </div>
        <div class="col-sm text-sm-right">
            <button class="btn btn-success btn-icon-left apbd-pro-btn"><i class="fa fa-save"></i> <?php $this->_e("Save") ; ?></button>
        </div>
    </div>
</div>
<div class="card-body p-0">
    <div class="ht-mcs-table-responsive">
        <table class="ht-mcs-table">
            <thead class="d-none d-sm-table-header">
            <tr>
                <th class=""><?php $this->_e("Currency") ; ?></th>
                <th class=""><?php $this->_e("Payment Gateways") ; ?></th>
            </tr>
            </thead>
            <tbody id="cur-gateway-html">
			<?php $this->getGatewaysCurrencyHtml()?>
            </tbody>
        </table>
    </div>
    
</div>
</div>
<div class=" text-sm-right pr-3">
    <button class="btn btn-success btn-icon-left apbd-pro-btn"><i class="fa fa-save"></i> <?php $this->_e("Save") ; ?></button>
</div>


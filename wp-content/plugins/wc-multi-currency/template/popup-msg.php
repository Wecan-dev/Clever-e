<?php if(empty($cboxWidth)){$cboxWidth=325;}
$cboxWidth=strtolower($cboxWidth)=="auto"?"auto":$cboxWidth."px";
$col_class=!empty($__col_class)?$__col_class:"col-md-6";
if(empty($method)){$method="post";}
if(!isset($isPopupFormMultiPath)){$isPopupFormMultiPath=false;}
if(!isset($formtype)){$formtype="";}
$__icon_class="fa fa-user";
?>

<div id="popup-container" class="mfp-with-anim mfp-dialog  <?php echo $col_class;?> clearfix pt-2">
<?php if(!empty($__icon_class)){?><div class="dialog-icon "> <i class="fa <?php echo $__icon_class;?>"></i></div><?php }?>
<div style=" position:relative;">
	<div class="hidden-xs" style="width:<?php echo $cboxWidth; ?>;"></div>
	<div class="lightboxWraper">
		<div class="lightboxWaiting text-center" id="waiting">
			<button type="button" class="btn btn-info">
				<i class="fa fa-circle-o-notch fa-spin"></i> <?php _e("Processing") ; ?></button>
		</div>
	</div>
	<div id="LightBoxBody" class="lightbox-body" style="padding:0 4px 2px;">
		<?php if(!empty($_title)){?>
			<div class="apd-lg-title">
			<h3><?php echo $_title;?>
			<?php $bkbtn=APBD_GetValue("bbtn","");
			if(!empty($bkbtn)){
			?>
			<a href="<?php echo $bkbtn;?>" data-effect="mfp-move-from-top" class="popupformWR btn btn-xs btn-default pull-right m-r-30"> <i class="fa fa-angle-double-left"></i> <?php _e("Back") ; ?></a>
			<?php }?>
			</h3>
            <?php if(!empty($_subTitle)){?>           
            <h5 class="p-0 m-t-0"><?php echo $_subTitle;?></h5>
            <?php }	?>
            <hr class="" style="margin: 0px 0px 8px;" />
		</div>
		<?php }?>
		<div class="w-100 pl-3 pr-3">
		    <div class="clearfix" style="margin-left: -15px; margin-right: -15px;"><?php echo APBD_GetMsg();?></div>
        </div>

        <div class="">
            <div class="clearfix form pb-3">
            <?php if(!empty($__message)){
                ?>
                <h5 class="pt-3 pb-3 text-center"><?php echo $__message; ?></h5>
                <?php
            } ?>


	        <?php
            if(!empty($__act)) {
		        if ( ! empty( $__rdir_page ) ) {
			        ?>
                    <p class="text-center text-success m-2">
                        <?php $this->_e( "It will redirect within %s second(s)" ,'<span id="counter">'.sprintf( "%d", $__act ).'</span>'); ?>
                    </p>
                    <script type="text/javascript">
                        $(function () {
                            window.pinterval=setInterval(function () {
                                var c = $("#counter").text();
                                if (c == 1) {
                                    try{clearInterval(window.pinterval);}catch(e){}
                                    APPSBDAPPJS.core.RedirectUrl("<?php echo $__rdir_page;?>");

                                } else {
                                    $("#counter").text(c - 1);
                                }
                            }, 1000);
                        });
                    </script>
		        <?php }else{
		            ?>
                    <p class="text-center text-success m-2"><?php $this->_e( "Close in %s second(s)" ,'<span id="counter">'.sprintf( "%d", $__act ).'</span>'); ?></p>
                    <script type="text/javascript">
                        $(function () {
                            window.pinterval=setInterval(function () {
                                var c = $("#counter").text();
                                if (c == 1) {
                                    try{clearInterval(window.pinterval);}catch(e){}
                                    APPSBDAPPJS.lightbox.CloseLightBox();

                                } else {
                                    $("#counter").text(c - 1);
                                }
                            }, 1000);
                        });
                    </script>
		            <?php
                }
	        }?>
            </div>
            <?php  if(($__force_close_dis && (! empty( $__rdir_page ))) || empty($__act)) { ?>
            <div class="btn-group-md popup-footer ">
                <div class="clearfix">
                    <div class="float-sm-left text-center text-sm-left">
                        <?php echo getCustomBackButtion(); ?>
                    </div>
                    <div class="float-sm-right text-center text-sm-right ">
                        <button type="button" class="close-pop-up btn btn-sm  btn-danger"><i class="fa fa-times"></i> <?php $this->_e("Close"); ?></button>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
        <script type="text/javascript">
			<?php if(APPSBD_IsPostBack){?>
            APPSBDAPPJS.core.SetAjaxChangeStatus(true);
			<?php if(!empty($_relaod_event)){
			?>
            APPSBDAPPJS.core.SetAjaxChangeEvent("<?php echo $_relaod_event; ?>");
			<?php
			} ?>
			<?php }?>
            window.IsValid=true;
        </script>
	 	</div>
	</div>
</div>

</div>

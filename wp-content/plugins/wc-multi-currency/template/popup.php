<?php
/** @var AppsBDBaseModule $this */

if(empty($cboxWidth)){$cboxWidth=325;}
$cboxWidth=strtolower($cboxWidth)=="auto"?"auto":$cboxWidth."px";
$col_class=!empty($__col_class)?$__col_class:"col-md-6";
if(empty($method)){$method="post";}
if(!isset($isPopupFormMultiPath)){$isPopupFormMultiPath=false;}
if(!isset($formtype)){$formtype="";}
?>

<div id="popup-container" class="mfp-with-anim mfp-dialog  <?php echo $col_class;?> clearfix pt-2">
<?php if(!empty($__icon_class)){?><div class="dialog-icon "> <i class="fa <?php echo $__icon_class;?>"></i></div><?php }?>
<div style=" position:relative;">
	<div class="hidden-xs" style="width:<?php echo $cboxWidth; ?>;"></div>
	<div class="lightboxWraper">
		<div class="lightboxWaiting text-center" id="waiting">
            <img src="<?php echo plugins_url("images/lighboxloader.svg",$this->pluginFile); ?>" style="max-height: 50px;" alt="...">
            <br>
            <h4 data-default-msg="<?php $this->_e("Processing") ; ?>"></h4>
		</div>
	</div>
	<div id="LightBoxBody" class="lightbox-body" style="padding:0 4px 2px;">
		<?php if(!empty($_title)){?>
			<div class="apd-lg-title">
			<h3><?php echo $_title;?>
			<?php $bkbtn=APBD_GetValue("bbtn","");
			if(!empty($bkbtn)){
			?>
			<a href="<?php echo $bkbtn;?>" data-effect="mfp-move-from-top" class="popupformWR btn btn-sm btn-outline-secondary pull-right" style="margin-right: 30px;"> <i class="fa fa-angle-double-left"></i> <?php _e("Back") ; ?></a>
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
		<?php if(empty($__disable_form)){?><form class="form app-lb-ajax-form <?php echo $formtype;?>" <?php echo $isPopupFormMultiPath?' data-multipart="true" enctype="multipart/form-data" ':' data-multipart="false" ';?>  action="<?php echo APBD_CurrentUrl(); ?>" method="<?php echo $method;?>">  <?php }?>
			<div class=" <?php echo !empty($__disable_form)?" form ":""?>">
			  
		 		<?php 
		 			APBD_GetHiddenFieldsHTML();
		 			echo $output; ?> 
		 	 
		 	</div>	
		 	<?php if(empty($__disable_form)){?></form>	<?php }?>

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
			<?php if(!empty($__close_popup_disable)){?>
            $(function(){
                $(".mfp-close").remove();
            });
			<?php }?>
        </script>
	 	</div>
	</div>
</div>
</div>

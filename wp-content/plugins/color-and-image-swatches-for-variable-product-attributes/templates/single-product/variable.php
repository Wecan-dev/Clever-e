<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $post, $woocommerce;

$swatch_type_options =  get_post_meta( $post->ID, 'phoe_swatch_options' );

$attribute_position = get_post_meta( $post->ID, 'attribute_position' ,true);
 
$color_swatches_setting_values = get_option('color_swatches_setting_values');

$swatches_style = isset($color_swatches_setting_values['swatches_style'])?$color_swatches_setting_values['swatches_style']:'';

// echo ;
do_action( 'woocommerce_before_add_to_cart_form' );

// wp_enqueue_style( 'phoen_font_awesome_lib112','//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');

?>

<form class="variations_form cart" method="post"  enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	
	<?php //if ( ! empty( $available_variations ) ) : ?>
		<div class="variations <?php echo $square_edge;?>">
				
			<?php 
			
			$loop = 0; foreach ( $attributes as $name => $options ) : $loop++; 
			
			$layout = isset( $swatch_type_options[0][ md5($name) ]['layout'])?$swatch_type_options[0][ md5($name) ]['layout']:'default';

			$phoen_options_type=isset($swatch_type_options[0][ md5($name) ]['type'])?$swatch_type_options[0][ md5($name) ]['type']:'term_options';
			
			// $default="";
			
			if(isset($phoen_options_type) && $phoen_options_type == 'default')
			{
				$display = 'block';
			}
			else
			{
				$display = 'none';
			}
			
			
			
			
			?>
			
				<div id="variation_<?php echo sanitize_title( $name ); ?>" class="variation">
				
						<div class="label"><label for="<?php echo sanitize_title( $name ); ?>"><?php echo wc_attribute_label( $name ); ?></label></div>
					
						<div class="value">
						
					<?php
					
					$terms = get_the_terms( $post->ID , sanitize_title( $name ) );
					
					if(isset($terms) && !empty($terms)){
						foreach($terms as $term)
						{
							$value = '';
							$value_name = isset($term->name)?$term->name:"";
							
							$phoen_term_label = "<span class='phoen_tooltip'><p>".$value_name."</p></span>";	
							
						}	
					}
					
					// $default_llk=!empty($default)?"default" : ;
					if(!empty($default)){
						$default_llk="default";
					}else{
						$default_llk=isset($swatch_type_options[0][ md5($name) ]['type'])?$swatch_type_options[0][ md5($name) ]['type']:'term_options';
					}
					
					?>
						
							<select data-type="<?php echo $phoen_options_type; ?>" style="display:<?php echo $display; ?>" id="<?php echo esc_attr( sanitize_title( $name ) ); ?>" class="<?php echo ($display!=="none" && $enable_dropdown_select2==1)?"phoen_select":''; ?>" name="attribute_<?php echo sanitize_title( $name ); ?>" data-attribute_name="attribute_<?php echo sanitize_title( $name ); ?>">
								
								<option data-type="" value=""><?php echo __( 'Choose an option', 'woocommerce' ) ?>&hellip;</option>
								
								<?php
								
									if ( is_array( $options ) ) {

										if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
											$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
										} elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
											$selected_value = $selected_attributes[ sanitize_title( $name ) ];
										} else {
											$selected_value = '';
										}

										// Get terms if this is a taxonomy - ordered
										if ( taxonomy_exists( $name ) ) {

											$terms = wc_get_product_terms( $post->ID, $name, array( 'fields' => 'all' ) );

											foreach ( $terms as $term ) {
												
												if(isset($swatch_type_options[0][ md5($name) ]['type']) && $swatch_type_options[0][ md5($name) ]['type']  == 'term_options' )
												{
													
													$term_id =  $term->term_id;
							
													$thumbnail_meta = get_woocommerce_term_meta( $term_id,'', 'phoen_color', true );
													
													$type = isset($thumbnail_meta[ sanitize_title( $name ).'_swatches_id_type'][0])?$thumbnail_meta[ sanitize_title( $name ).'_swatches_id_type'][0]:'';
									
													$value =  isset($thumbnail_meta[sanitize_title( $name ).'_swatches_id_'.$type][0])?$thumbnail_meta[sanitize_title( $name ).'_swatches_id_'.$type][0]:'';
													
													
												}
												else
												{
													
													$type = isset($swatch_type_options[0][ md5($name) ]['attributes'][md5($term->slug)]['type'])?$swatch_type_options[0][ md5($name) ]['attributes'][md5($term->slug)]['type']:'';
												
													 if($type == 'color')
													{
														$value = $swatch_type_options[0][ md5($name) ]['attributes'][md5($term->slug)]['color'];
													}
													else if($type == 'image')
													{
														$value = $swatch_type_options[0][ md5($name) ]['attributes'][md5($term->slug)]['image'];
														
													}else if($type == 'select2')
													{
														$value = $swatch_type_options[0][ md5($name) ]['attributes'][md5($term->slug)]['select2'];
													}
													
												}
											
												if ( ! in_array( $term->slug, $options ) ) {
													continue;
												}
											
												
												echo '<option data-type="'.$type.'" data-value="'.$value.'" value="' .preg_replace( '/^\_/', '', wc_sanitize_taxonomy_name( stripslashes( $term->slug ) )) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ).'</option>';
											}

										} else {

											foreach ( $options as $option ) {
												
												echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
												
											}

										} 
									}
								?>
								
							</select>
						
							<?php
							$terms = get_the_terms( $post->ID , sanitize_title( $name ) );
								
							?>
							<div class="variation_descriptions_wrapper">
							
								<div class="variation_descriptions" id="<?php echo sanitize_title( $name ); ?>_descriptions" style="display:none">
								
									<div rel="<?php echo sanitize_title( $name ); ?>_buttons" class="var-notice header-font" style="opacity: 1; right: 0px;">
									
										<div class="vertAlign" style="margin-top: 0px;"><?php _e('Please select', 'phoen-visual-attributes'); ?></div>
										
									</div>
									
									<?php
									
									if(!empty($terms))
									{
										foreach($terms as $term)
										{
											$value = '';
											
											
											$phoen_term_label = "<span class='phoen_tooltip'><p>".$term->name."</p></span>";	
												
											

											 esc_html( $term->slug );
										
											
											?>
											
											<div class="variation_description" id="<?php echo sanitize_title( $name ); ?>_<?php echo $term->slug; ?>_description" style="display:none">
												
												<?php
										
													// $swatch_type_options[0][ md5($name) ]['type'];
													
													if(isset($phoen_options_type) && $phoen_options_type  == 'term_options' )
													{
														
														$term_id =  $term->term_id;
								
														$thumbnail_meta = get_woocommerce_term_meta( $term_id,'', 'phoen_color', true );
														
														
														
														$type = isset($thumbnail_meta[ sanitize_title( $name ).'_swatches_id_type'][0])?$thumbnail_meta[ sanitize_title( $name ).'_swatches_id_type'][0]:'';
										
														$option_value =  isset($thumbnail_meta[sanitize_title( $name ).'_swatches_id_'.$type][0])?$thumbnail_meta[sanitize_title( $name ).'_swatches_id_'.$type][0]:'';
														if($type == 'phoen_color')
														{
														 
															$value = "<div class='".preg_replace( '/^\_/', '', wc_sanitize_taxonomy_name( stripslashes( $term->slug ) ))."_image type_color'>".$phoen_term_label1."<span class='phoen_swatches phoen_type_color' style='height:32px; width:32px; display:block;background-color:".$option_value."'></span>".$phoen_term_label."</div>";	
															
														}
														
														else if($type == 'phoen_image')
														{
															
															if($option_value == '' ){
																
																$option_value = $woocommerce->plugin_url() . '/assets/images/placeholder.png';
																
															}
															
															$value = "<div class='".preg_replace( '/^\_/', '', wc_sanitize_taxonomy_name( stripslashes( $term->slug ) ))."_image type_image'>".$phoen_term_label1."<span class='phoen_swatches phoen_type_image' style='height:32px; width:32px; display:block;'><img src='".$option_value."'>".$phoen_term_label."</span></div>";
														}else{
														
															$value = "<div class='".preg_replace( '/^\_/', '', wc_sanitize_taxonomy_name( stripslashes( $term->slug ) ))."_image type_normal'><span class='phoen_swatches phoen_type_other' style='height:32px; width:70px; vertical-align:middle; display:table-cell;text-align: center; padding:0 5px; margin-bottom:0;'>".$term->name."</span>".$phoen_term_label."</div>";	
														} 
														
													}
													else
													{
														$type = isset($swatch_type_options[0][ md5($name) ]['attributes'][md5($term->slug)]['type'])?$swatch_type_options[0][ md5($name) ]['attributes'][md5($term->slug)]['type']:'';
														
														
														// echo $type;
														
														
														if($type == 'color')
														{
															
															$value = "<div class='".preg_replace( '/^\_/', '', wc_sanitize_taxonomy_name( stripslashes( $term->slug ) ))."_image type_color'>".$phoen_term_label1."<span class='phoen_swatches phoen_type_color' style='height:32px; width:32px; display:block; background-color:".$swatch_type_options[0][ md5($name) ]['attributes'][md5($term->slug)]['color']."'></span>".$phoen_term_label."</div>";	
															
															
															
														}
														else if($type == 'image')
														{
															
															if($swatch_type_options[0][ md5($name) ]['attributes'][md5($term->slug)]['image'] != '' ){
																
																$phon_swatches_image = $swatch_type_options[0][ md5($name) ]['attributes'][md5($term->slug)]['image'];
																
															}else{
																
																$phon_swatches_image = $woocommerce->plugin_url() . '/assets/images/placeholder.png';
																
															}
															
															
															
															$value ="<div class='".preg_replace( '/^\_/', '', wc_sanitize_taxonomy_name( stripslashes( $term->slug ) ))."_image type_image'>".$phoen_term_label1."<span class='phoen_swatches phoen_type_image' style='height:32px; width:32px; display:block;'><img src='".$phon_swatches_image."'></span>".$phoen_term_label."</div>";
														}
														else{
															
															$value = "<div class='".preg_replace( '/^\_/', '', wc_sanitize_taxonomy_name( stripslashes( $term->slug ) ))."_image type_normal'><span class='phoen_swatches phoen_type_other' style='height:32px; width:32px; vertical-align:middle; display:table-cell;text-align: center; padding:0 5px; margin-bottom:0;'>".$term->name."</span>".$phoen_term_label."</div>";	
														} 
														
													}

													if( $type ){
												
														echo $value;	
														
													}else{
														echo "<div class='".preg_replace( '/^\_/', '', wc_sanitize_taxonomy_name( stripslashes( $term->slug ) ))."_image type_nomore'><span class='phoen_swatches phoen_type_normal' style='height:32px; width:32px; vertical-align:middle; display:table-cell;text-align: center; padding:0 5px; margin-bottom:0;'>".$term->name."</span>".$phoen_term_label."</div>";	
													}
													
													?>
													
											</div>
											
											<?php
										
										}
										
									}	
									?>
									
								</div>
							</div>

							
						
						</div>
						
						<?php
					
						
						if ( sizeof( $attributes ) === $loop ) {
							
							echo '<a class="reset_variations" href="#reset">Clear Selection</a>';
							
						}
							
						?>
				</div>
				
			<?php endforeach;?>
			
			
		</div>
		

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap" style="display:none;">
		
			<?php do_action( 'woocommerce_before_single_variation' ); ?>

			<div class="single_variation"></div>

			<div class="variations_button">
				
				<?php woocommerce_quantity_input( array(
					'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 )
				) ); ?>
		
				<button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
				
			</div>

			<input type="hidden" name="add-to-cart" value="<?php echo $product->get_id(); ?>" />
			
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
			
			<input type="hidden" name="variation_id" class="variation_id" value="" />

			<?php do_action( 'woocommerce_after_single_variation' ); ?>
			
		</div>
		
		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php /* else : ?>

		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>

	<?php endif;*/  ?>

</form>

<script type="text/javascript">

(function($){
	
jQuery(document).ready(function() {
	
	jQuery(".phoen_select").select2();
	
	/* jQuery("body").on("mouseover",".phoen_swatches",function(){
		
		if(jQuery(".variations_form .variations .variation").length < 2){
			jQuery(this).closest("a").trigger('click');
		}
	}); */
	
	jQuery(".phoen_demo").hide();
	
	if(jQuery('.variations_form').length) {
				
		makealloptions();
		
		var chocesMade = true;
		
		jQuery('.variations_form .variation select').each(function(index, element) {
			// alert(212);
			if( jQuery(this).val()=='' ){
				
				chocesMade = false;
			}
			
		});
		
		if(chocesMade) {
			
			makealloptions();
		
		}
	} 
	
	jQuery(document).on('click','.reset_variations',function(){
		
		jQuery('.selected').each(function(index, element){
			
			jQuery(this).removeClass('selected').addClass('unselected');  
					
		});
	
	});
	
	jQuery(document).on('click','.variation_button',function() {
		
	
		if( jQuery('#'+jQuery(this).attr('rel')).val()==jQuery(this).attr('id') ){
			
			jQuery('#'+jQuery(this).attr('rel')).val('');
			
			jQuery(this).removeClass('selected').addClass('unselected');
		
		}else{
			
			jQuery('#'+jQuery(this).attr('rel')).val(jQuery(this).attr('id'));
			
			jQuery('#'+jQuery(this).attr('rel')+'_buttons .variation_button').removeClass('selected').addClass('unselected');
			
			jQuery(this).removeClass('unselected').addClass('selected');
			
				var notTarget = jQuery(this).attr('rel')+'_'+jQuery(this).attr('id')+'_description';
				
				jQuery('#'+jQuery(this).attr('rel')+'_descriptions .variation_description').each(function(){
					
					if(jQuery(this).attr('id')!=notTarget){
						
						jQuery(this).hide();
						
					}
					
				});
				
		}
		
		 jQuery('#'+jQuery(this).attr('rel')).change();
		
	});
	
	jQuery(document).on('click','.variation_button',function() {
		// alert();
		jQuery('.selected').each(function(){
			
			jQuery(this).closest('.variation_button').find('.phoen_term_label').css('display','block');
			
		});
		
		jQuery('.unselected').each(function(){
			
			jQuery(this).closest('.variation_button').find('.phoen_term_label').css('display','none');
			
		});
	});
	
	jQuery('.variation_descriptions_wrapper:first-child').append('');
	
	jQuery(document).on('change','.variations_form select',function(){
		
		makealloptions();
	
	});
	
	function makealloptions(){
		// alert(212);
		jQuery('.variations_form select').each(function(index, element) {
			
			var curr_select = jQuery(this).attr('id');
			
			if( jQuery(this).attr('data-type') == 'default' )
			{
				
				var type = 'none';
				
			}
			else
			{
				
				var type = 'block';
				
			}
			
			if(jQuery('#'+curr_select+'_buttons').length){
				
				if(!jQuery('#'+curr_select+'_buttons').find('.selected').length){
					
					jQuery('#'+curr_select+'_buttons').html('');
					
					jQuery('#'+curr_select+'_descriptions .variation_description').stop(true,true).slideUp("fast");
					
				}
				
			}else{
				
				jQuery( '<div class="variation_buttons_wrapper"><div style="display:'+type+'" id="'+curr_select+'_buttons" class="variation_buttons"></div></div><div class="variation_descriptions_wrapper"><div id="'+curr_select+'_descriptions" class="variation_descriptions"></div></div>' ).insertBefore( jQuery(this) );
				
			}
			
			jQuery('#'+jQuery(this).attr('id')+' option').each(function(index, element) {
				
				
				if(jQuery(this).val()!=''){
					
					// Get Image
					var image = jQuery('#'+curr_select+'_'+jQuery(this).val()+'_description .image img');
				
					if(jQuery('#'+jQuery(this).val()).length && jQuery('#'+jQuery(this).val()).hasClass('variation_button') ) {
						
						jQuery('#'+jQuery(this).val()).show();
						
					}
					else
					{ 
						//var postion_class='<?php echo $position_class ; ?>';
						
						var phoen_only_radio="";
						
						
						jQuery( "#"+curr_select+'_buttons' ).append( '<a href="javascript:void(0);" class="position_before variation_button'+((jQuery('#'+curr_select).val()==jQuery(this).val())?' selected':' unselected')+phoen_only_radio+'" id="'+jQuery(this).val()+'"  rel="'+curr_select+'">'+jQuery('.'+jQuery(this).val()+'_image').html()+'</a>' );
						
						if(jQuery('#'+curr_select).val()==jQuery(this).val()){
							
							jQuery('#'+curr_select+'_'+jQuery(this).val()+'_description .var-notice').stop(true,true).hide();
							
							jQuery('#'+curr_select+'_'+jQuery(this).val()+'_description').stop(true,true).slideDown("fast");
							
						} 
					}
				}else{
					
					if( jQuery('#'+curr_select+' option').length == 1 && jQuery('#'+curr_select+' option[value=""]').length){
						alert("Combination Not Avalable");
								
						// jQuery( "#"+curr_select+'_buttons' ).append( 'Combination Not Avalable <a href="javascript:void(0);" class="variation_reset">Reset</a>' );
						
					}
				}
				
			}); 
				
		});
		
		jQuery('form.variations_form').fadeIn();
		
		jQuery('.product_meta').fadeIn();
		
	}
	
});

})(jQuery)
	
</script>

<style type="text/css">

.label{ color:#363636; line-height: 1;}

.variations_form .variations .value select {
	-moz-appearance: none;
	-webkit-appearance: none;
	background-image: url("<?php echo PHOEN_ARBPRPLUGURL."assets/images/drop-down.png";?>");
	background-color: transparent;
	background-position: 96% center;
	background-repeat: no-repeat;
	border: 2px solid #ccc;
	border-radius: 5px;
	cursor: pointer;
	font-size: 14px;
	height: auto;
	margin-bottom: 5px;
	padding: 8px 25px 8px  10px;
	width: auto;
}


.variation_buttons_wrapper .variation_button { display:inline-block; vertical-align:top; margin-right:7px; margin-bottom: 5px; } 

.variations .variation_buttons_wrapper a{text-decoration:none;text-align:center; position: relative;}

.variations .variation_buttons_wrapper a:focus,
.variations .variation_buttons_wrapper a:hover {outline: none; text-decoration: none; box-shadow: none;}

.variations .variation {margin-bottom: 15px;}
	
.select-wrapper{ display:none!important; }

.variation_buttons .variation_button,
.variation_buttons .variation_button:hover {box-shadow: none;}

.variations .variation_buttons_wrapper a span.phoen_swatches img { border-radius: 0px; height: 100%; object-fit: contain; width: 100%; }

.variations.phoen_sharp_square .variation_buttons_wrapper a span.phoen_swatches,
.variations.phoen_sharp_square .variation_buttons_wrapper a span.phoen_swatches img { border-radius: 0px; }

.variations .variation_buttons_wrapper a .phoen_swatches > img {transition: all 0.5s ease 0s; -webkit-transition: all 0.5s ease 0s; -moz-transition: all 0.5s ease 0s; -ms-transition: all 0.5s ease 0s; -o-transition: all 0.5s ease 0s;}

/* tooltip css */
.value .variation_buttons_wrapper .variation_button.position_after {
	vertical-align: bottom;
	position: relative;
}

.value .variation_buttons_wrapper .variation_button.position_before {
	vertical-align: top;
	position: relative;
}

.phoen_tooltip p { position:relative; margin-bottom: 0; }

span.phoen_swatches span.phoen_tooltip {
    display: inherit;
}

.phoen_tooltip {
		border-radius: 0px;
		font-size: 13px;
		height: auto;
		line-height: 1.3;
		left: 50%;
		margin-bottom: 10px;
		opacity: 0;
		position: absolute;
		visibility: hidden;
		width: auto;
		text-align: center;
		z-index: 99;
		transform: translateX(-50%);
		-webkit-transform: translateX(-50%);
		-moz-transform: translateX(-50%);
		transition: all 300ms ease 0s;
		-webkit-transition: all 300ms ease 0s;
		-moz-transition: all 300ms ease 0s;
		margin-top: 0px;
}
span.phoen_tooltip img {
    border: 1px solid;
}
.variation .variation_button span.phoen_below_radio {
	display: inline-block;
	font-size:13px;
	line-height: 1;
	margin: 0 6px 0px 4px;
	text-transform: capitalize;
	vertical-align: middle;
}
.phoen_tooltip p {
	display: inline-block;
	width: 84px;
	padding: 7px 10px;
	text-transform: capitalize;
	text-align: center;
	color :#ffffff;
	background:#222222;	
}
.position_before:hover .phoen_tooltip {
	top: 100%;
	margin-top: 8px;
	margin-bottom: 0;
	visibility: visible;
	opacity: 1;
}
.phoen_tooltip p::after {
	border-color: transparent transparent #222222 transparent;
	border-style: solid;
	border-width: 6px;
	content: "";
	left: 50%;
	position: absolute;
	top: inherit;
	transform: translateX(-50%);
	-webkit-transform: translateX(-50%);
	-moz-transform: translateX(-50%);
	bottom: 100%;
}
.variations .value {
    display: inline-block;
    margin-left: 12px;
}
.variations .label {
    display: inline-block;
	width: 62px;
}
.variations .value .variation_button.unselected span.phoen_swatches {
	border: 2px solid #fff;
    box-shadow: 0 0 0 1px rgba(0,0,0,.3);
}
.variations .value .variation_button.selected span.phoen_swatches {
    border: #fff solid 2px;
    box-shadow: 0 0 1px 2px rgba(0,0,0,.9);
}
.variations .variation a.reset_variations {
    display: block!important;
    margin-top: 11px;
    margin-bottom: 18px;
}					


<?php

	if($swatches_style == 2)
	{
		
		?>
			.variations .variation_buttons_wrapper a span.phoen_swatches{ border-radius:50px; }

			.variations .variation_buttons_wrapper a span.phoen_swatches img { border-radius:50px;}
		
		
		<?php
		
	}

?>

</style>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
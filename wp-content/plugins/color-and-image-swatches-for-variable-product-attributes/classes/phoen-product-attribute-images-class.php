<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PHOEN_PRODUCT_ATTRIBUTES_SWATCHES {
	
	private $taxonomy;
	
	private $meta_key;
	
	private $image_size = 'shop_thumb';
	
	private $image_width = 40;
	
	private $image_height = 40; 

	public function __construct($attribute_image_key = 'thumbnail_id', $image_size = 'shop_thumb') {
		
		$this->meta_key = $attribute_image_key;
		
		$this->image_size = $image_size;

		if (is_admin()) {
			
			add_action('admin_enqueue_scripts', array(&$this, 'on_admin_scripts'));
			
			add_action('current_screen', array(&$this, 'init_attribute_image_selector'));

			add_action('created_term', array(&$this, 'woocommerce_attribute_thumbnail_field_save'), 10, 3);
			
			add_action('edit_term', array(&$this, 'woocommerce_attribute_thumbnail_field_save'), 10, 3);
			
		}
	}

	public function on_admin_scripts() {
		
		global $woocommerce_swatches;
		
		$screen = get_current_screen();
		
		if (strpos($screen->id, 'pa_') !== false) :
		
			wp_enqueue_media();
					
		endif;
	}
	
	public function init_attribute_image_selector() {
		
		global $woocommerce, $_wp_additional_image_sizes;
		
		$screen = get_current_screen();

		if (strpos($screen->id, 'pa_') !== false) :

			$this->taxonomy = $_REQUEST['taxonomy'];

			$attribute_taxonomies = wc_get_attribute_taxonomies();

			if ($attribute_taxonomies) {
				
				foreach ($attribute_taxonomies as $tax) {

					add_action('pa_' . $tax->attribute_name . '_add_form_fields', array(&$this, 'woocommerce_add_attribute_thumbnail_field'));
					
					add_action('pa_' . $tax->attribute_name . '_edit_form_fields', array(&$this, 'woocommerce_edit_attributre_thumbnail_field'), 10, 2);

					add_filter('manage_edit-pa_' . $tax->attribute_name . '_columns', array(&$this, 'woocommerce_product_attribute_columns'));
					
					add_filter('manage_pa_' . $tax->attribute_name . '_custom_column', array(&$this, 'woocommerce_product_attribute_column'), 10, 3);
				}
			}

		endif;
	} 
 
	//The field used when adding a new term to an attribute taxonomy
	public function woocommerce_add_attribute_thumbnail_field() {
				
		wp_enqueue_style( 'phoen_font_awesome_lib11','//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');
		
		wp_enqueue_style( 'style-name2', plugin_dir_url(__FILE__). "./../assets/css/fontawesome-iconpicker.css" );
		
		wp_enqueue_script( 'script-name', plugin_dir_url(__FILE__)."./../assets/js/fontawesome-iconpicker.js");
				
		global $woocommerce;
		
		?>
		
		<div class="form-field ">
			
			<label for="product_attribute_swatchtype_<?php echo $this->meta_key; ?>"><?php _e( 'Swatch Type.', 'phoen-visual-attributes' ); ?></label>
			
			<select name="product_attribute_meta[<?php echo $this->meta_key; ?>][type]" id="product_attribute_swatchtype_<?php echo $this->meta_key; ?>" class="postform">
			
				<option value="-1"><?php _e( 'Text', 'phoen-visual-attributes' ); ?></option>
				
				<option value="phoen_color"><?php _e( 'Color', 'phoen-visual-attributes' ); ?></option>
				
				<option value="phoen_image"><?php _e( 'Image', 'phoen-visual-attributes' ); ?></option>
				
			</select>

			<script type="text/javascript">
				
				jQuery(document).ready(function($) {

					$('#product_attribute_swatchtype_<?php echo $this->meta_key; ?>').change(function() {
						alert();
						
						$('.swatch-field-active').hide().removeClass('swatch-field-active');
						
						$('.swatch-field-' + $(this).val()).slideDown().addClass('swatch-field-active');
					
					});
					
					$('.icon_for_swatches').iconpicker({

						placement: 'top',
						
					});					
						
				});

			</script>
			
		</div>
		
		<!--Color Swatches Div-->
		
		<div class="form-field swatch-field swatch-field-phoen_color" style="overflow:visible;display:none;">
			
			<div id="swatch-color" class="<?php echo sanitize_title($this->meta_key); ?>-phoen_color">
		           
				<label><?php _e('Color:', 'phoen-visual-attributes'); ?></label>
		                
		       <div >
					
					<input type="hidden" id="product_attribute_<?php echo $this->meta_key; ?>" name="product_attribute_meta[<?php echo $this->meta_key; ?>][phoen_color]" />
					
					<input type='text' class="text_for_swatches" name="product_attribute_meta[<?php echo $this->meta_key; ?>][phoen_color]" value="" >
		       </div>
			   
				
				<script type="text/javascript">
						
					jQuery(document).ready(function(){
							
						jQuery('.text_for_swatches').wpColorPicker();
							
					});
					
						
				</script>
		       
			   <div class="clear"></div>
			
			</div>
		
		</div>
	
		<!--Image Swatches Div-->
		
		<div class="form-field swatch-field swatch-field-phoen_image" style="overflow:visible;display:none;">
			
			<div id="swatch-photo" class="<?php echo sanitize_title($this->meta_key); ?>-phoen_image">
				
				<label><?php _e('Thumbnail', 'phoen-visual-attributes'); ?></label>
				
				<div id="product_attribute_thumbnail_<?php echo $this->meta_key; ?>" style="float:left;margin-right:10px;">
					 <img src="<?php echo $woocommerce->plugin_url() . '/assets/images/placeholder.png' ?>" width="<?php echo $this->image_width; ?>px" height="<?php echo $this->image_height; ?>px" />
				</div>
				
				<div style="line-height:60px;">
					<input type="hidden" class="phoen_swatch_image_" id="product_attribute_<?php echo $this->meta_key; ?>" value="" name="product_attribute_meta[<?php echo $this->meta_key; ?>][phoen_image]" />
					<button type="submit" class="upload_image_button button"><?php _e('Upload/Add image', 'phoen-visual-attributes'); ?></button>
					<button type="submit" class="remove_image_button button"><?php _e('Remove image', 'phoen-visual-attributes'); ?></button>
				</div>
				
				<script type="text/javascript">
					var custom_upload;

					jQuery(document).on("click",".upload_image_button",uploadimage_button);

					function uploadimage_button(){

						var custom_upload = wp.media({

						title: 'Add Media',

						button: {

							text: 'Insert Image'

						},

						multiple: false  // Set this to true to allow multiple files to be selected

					})

					.on('select', function() {

						var attachment = custom_upload.state().get('selection').first().toJSON();

						jQuery('#product_attribute_thumbnail_swatches_id img').attr('src', attachment.url);

						jQuery('#product_attribute_swatches_id').val( attachment.id);
						
						jQuery('.phoen_swatch_image_').val(attachment.url);

					})

					.open();

				 
						return false;
					}
					
			
					jQuery('.remove_image_button').live('click', function() {
						jQuery('#product_attribute_thumbnail_swatches_id img').attr('src', '<?php echo $woocommerce->plugin_url() . '/assets/images/placeholder.png'; ?>');
						jQuery('#product_attribute_swatches_id').val('');
						jQuery('.phoen_swatch_image_').val();
						return false;
					});

				</script>
				<div class="clear"></div>
			</div>
		</div>
		<!--Add Icon-->
		<div class="form-field swatch-field swatch-field-phoen_icon" style="overflow:visible;display:none;">
			
			<div id="swatch-color" class="<?php echo sanitize_title($this->meta_key); ?>-phoen_icon">
				
				<label><?php _e('Icon:', 'phoen-visual-attributes'); ?></label>
		               
				<div >
				
					<input type="hidden" id="product_attribute_<?php echo $this->meta_key; ?>" name="product_attribute_meta[<?php echo $this->meta_key; ?>][phoen_icon]" />
					
					<input type='text' class="icon_for_swatches" name="product_attribute_meta[<?php echo $this->meta_key; ?>][phoen_icon]" value="" >
				
				</div>
					
		       <div class="clear"></div>
			   
			</div>
			
		</div>
		<?php
		
	}

	
	public function woocommerce_edit_attributre_thumbnail_field($term, $taxonomy) {
		
		global $woocommerce;
		
		wp_enqueue_style( 'phoen_font_awesome_lib11','//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');
		
		wp_enqueue_style( 'style-name2', plugin_dir_url(__FILE__). "./../assets/css/fontawesome-iconpicker.css" );
		
		wp_enqueue_script( 'script-name', plugin_dir_url(__FILE__)."./../assets/js/fontawesome-iconpicker.js");
			
		$swatch_term = new PHOEN_ADD_TERM_($this->meta_key, $term->term_id, $taxonomy, false, $this->image_size);
		
		$image = ''; 
				
		?>

		<tr class="form-field ">
			
			<th scope="row" valign="top"><label><?php _e('Type', 'phoen-visual-attributes'); ?></label></th>
			
			<td>
				<label for="product_attribute_swatchtype_<?php echo $this->meta_key; ?>"><?php _e( 'Swatch Type', 'phoen-visual-attributes' ); ?></label>
				
				<select name="product_attribute_meta[<?php echo $this->meta_key; ?>][type]" id="product_attribute_swatchtype_<?php echo $this->meta_key; ?>" class="postform">
					
					<option <?php selected('Text', $swatch_term->get_type()); ?> value="-1"><?php _e('Text', 'phoen-visual-attributes'); ?></option>
					
					<option <?php selected('phoen_color', $swatch_term->get_type()); ?> value="phoen_color"><?php _e('Color', 'phoen-visual-attributes'); ?></option>
					
					<option <?php selected('phoen_image', $swatch_term->get_type()); ?> value="phoen_image"><?php _e('Image', 'phoen-visual-attributes'); ?></option>
										
					
				</select>
				
				<script type="text/javascript">
					
					jQuery(document).ready(function($) {

						$('#product_attribute_swatchtype_<?php echo $this->meta_key; ?>').change(function() {
							
							$('.swatch-field-active').hide().removeClass('swatch-field-active');
							
							$('.swatch-field-' + $(this).val()).show().addClass('swatch-field-active');
						
						});
							
						$('.icon_for_swatches').iconpicker({

							placement: 'top',
						
						});	

					});
					
				</script>
			</td>
		</tr>

		<?php $style = $swatch_term->get_type();  ?>
		
		<tr class="form-field swatch-field-<?php echo ($style == 'phoen_color')?'active':''; ?> swatch-field-phoen_color " style="overflow:visible;<?php echo ($style != 'phoen_color')?'display:none;':''; ?>">
			
			<th scope="row" valign="top"><label><?php _e('Color', 'phoen-visual-attributes'); ?></label></th>
			
			<td>
			
				<div>
					
					<input type="hidden" id="product_attribute_<?php echo $this->meta_key; ?>" name="product_attribute_meta[<?php echo $this->meta_key; ?>][phoen_color]" value="<?php echo $swatch_term->phoen_color; ?>" />
					
					<input type='text' class="text_for_swatches" name='product_attribute_meta[<?php echo $this->meta_key; ?>][phoen_color]' value="<?php echo $swatch_term->phoen_color; ?>" >
				
				</div>
				
				
				<script type="text/javascript">
					
					jQuery(document).ready(function(){
						
						jQuery('.text_for_swatches').wpColorPicker();
						
					});
					
				</script>
				
				<div class="clear"></div>
			   
			</td>
			
		</tr>
		<tr class="form-field swatch-field-<?php echo ($style == 'phoen_image')?'active':''; ?> swatch-field-phoen_image" style="overflow:visible;<?php echo ($style != 'phoen_image')?'display:none;':''; ?>">
			
			<th scope="row" valign="top"><label><?php _e('Image', 'phoen-visual-attributes'); ?></label></th>
			
			<td>
				<div id="product_attribute_thumbnail_<?php echo $this->meta_key; ?>" style="float:left;margin-right:10px;">
					<img src="<?php echo ($swatch_term->phoen_image != '' )?$swatch_term->phoen_image:$swatch_term->get_image_src(); ?>"  width="<?php echo $swatch_term->get_width(); ?>px" height="<?php echo $swatch_term->get_height(); ?>px" />
				</div>
					
				<div style="line-height:60px;">
					
					<input type="hidden" class="phoen_swatch_image_" id="product_attribute_<?php echo $this->meta_key; ?>" name="product_attribute_meta[<?php echo $this->meta_key; ?>][phoen_image]" value="<?php echo $swatch_term->phoen_image; ?>" />
					
					<button type="submit" class="upload_image_button button"><?php _e('Upload/Add image', 'phoen-visual-attributes'); ?></button>
				
					<button type="submit" class="remove_image_button button"><?php _e('Remove image', 'phoen-visual-attributes'); ?></button>
				
				</div>
				
				<script type="text/javascript">

					var custom_uploadd;
					
					jQuery(document).on("click",".upload_image_button",uploadimage_buttonn);

					function uploadimage_buttonn(){

						var custom_uploadd = wp.media({

							title: 'Add Media',

							button: {

								text: 'Insert Image'

							},

							multiple: false  // Set this to true to allow multiple files to be selected

						})

						.on('select', function() {

							var attachment = custom_uploadd.state().get('selection').first().toJSON();

							jQuery('#product_attribute_thumbnail_swatches_id img').attr('src', attachment.url);
							
							jQuery('#product_attribute_swatches_id').val( attachment.id);
							
							jQuery('.phoen_swatch_image_').val(attachment.url);
							
						})

						.open();
					
						return false;
					}

					jQuery('.remove_image_button').live('click', function() {
						
						jQuery('#product_attribute_thumbnail_<?php echo $this->meta_key; ?> img').attr('src', '<?php echo $woocommerce->plugin_url() . '/assets/images/placeholder.png'; ?>');
						
						jQuery('#product_attribute_<?php echo $this->meta_key; ?>').val('');
						
						return false;
					});

				</script>
				<div class="clear"></div>
			</td>
		</tr>
		
		
		<tr class="form-field swatch-field-<?php echo ($style == 'phoen_icon')?'active':''; ?> swatch-field-phoen_icon" style="overflow:visible;<?php echo ($style != 'phoen_icon')?'display:none;':''; ?>">
			
			<th scope="row" valign="top"><label><?php _e('Icon', 'phoen-visual-attributes'); ?></label></th>
			
			<td>
				
				<div >
				
					<input type="hidden" id="product_attribute_<?php echo $this->meta_key; ?>" name="product_attribute_meta[<?php echo $this->meta_key; ?>][phoen_icon]" value="<?php echo $swatch_term->phoen_icon; ?>" />
					
					<input type='text' class="icon_for_swatches" name='product_attribute_meta[<?php echo $this->meta_key; ?>][phoen_icon]' value="<?php echo $swatch_term->phoen_icon; ?>" >
				
				</div>
				
				<script type="text/javascript">

					jQuery(document).ready(function(){
						
						jQuery('.icon_for_swatches').iconpicker({
						
							placement:'top',
							
						});
						
					});
				
				</script>
					
		       <div class="clear"></div>
			   
			</td>
			
		</tr>
		
		<?php
	}
	
	//Saves the product attribute taxonomy term data
	public function woocommerce_attribute_thumbnail_field_save($term_id, $tt_id, $taxonomy) {

		if(isset($_POST['product_attribute_meta'])){

			$metas = $_POST['product_attribute_meta'];
			
			$data = $metas[$this->meta_key];
			
			if(isset($metas[$this->meta_key])){
				
				$data = $metas[$this->meta_key];
				
				$type = isset($data['type']) ? $data['type'] : '';
				
				update_woocommerce_term_meta($term_id, $taxonomy . '_' . $this->meta_key . '_type', $type);
				if($type == 'phoen_icon'){
					
					$phoen_icon = isset($data['phoen_icon']) ? $data['phoen_icon'] : '';
					update_woocommerce_term_meta($term_id, $taxonomy . '_' . $this->meta_key . '_phoen_icon', $phoen_icon);
					
				}
				elseif($type == 'phoen_color'){
					$phoen_color = isset($data['phoen_color']) ? $data['phoen_color'] : '';
					$phoen_bicolor = isset($data['phoen_bicolor']) ? $data['phoen_bicolor'] : '#fff';
					$phoen_bicolor_enable = isset($data['phoen_bicolor_enable']) ? $data['phoen_bicolor_enable'] : '';
					/* echo '<pre>';
					print_r($data);
					echo '</pre>';die(); */
					
					update_woocommerce_term_meta($term_id, $taxonomy . '_' . $this->meta_key . '_phoen_color', $phoen_color);
					update_woocommerce_term_meta($term_id, $taxonomy . '_' . $this->meta_key . '_phoen_bicolor', $phoen_bicolor);
					update_woocommerce_term_meta($term_id, $taxonomy . '_' . $this->meta_key . '_phoen_bicolor_enable', $phoen_bicolor_enable);
					
				}elseif($type == 'phoen_image'){
					$phoen_image = isset($data['phoen_image']) ? $data['phoen_image'] : '';
					update_woocommerce_term_meta($term_id, $taxonomy . '_' . $this->meta_key . '_phoen_image', $phoen_image);
					
				}
				
			}
			
		}
		
		
	}

	//Registers a column for this attribute taxonomy for this image
	public function woocommerce_product_attribute_columns($columns) {
		
		$new_columns = array();
		
		$new_columns['cb'] = $columns['cb'];
		
		$new_columns[$this->meta_key] = __('Thumbnail', 'woo-attr-img-add');
		
		unset($columns['cb']);
		
		$columns = array_merge($new_columns, $columns);
		
		return $columns;
	}

	//Renders the custom column as defined in woocommerce_product_attribute_columns
	public function woocommerce_product_attribute_column($columns, $column, $id) {
		
		if ($column == $this->meta_key) :
			
			$swatch_term = new PHOEN_ADD_TERM_($this->meta_key, $id, $this->taxonomy, false, $this->image_size);
			
			$columns .= $swatch_term->get_output();
		
		endif;
		
		return $columns;
	}

}
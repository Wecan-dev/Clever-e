<style>
		.form-table th {
			width: 270px;
			padding: 25px;
		}

		.form-table td {
			
			padding: 20px 10px;
		}

		.form-table {
			background-color: #fff;
		}

		h3 {
			padding: 10px;
		}

		.px-multiply{ color:#ccc; vertical-align:bottom;}

		.long{ display:inline-block; vertical-align:middle; }

		.wid{ display:inline-block; vertical-align:middle;}

		.up{ display:block;}

		.grey{ color:#b0adad;}
	</style>
	
<form action="" id="form7-12" method="post">
	<?php wp_nonce_field( 'color_swatches_setting_form_action', 'color_swatches_setting_form_nonce_field' ); ?>
	
	<div class="wrap" id="profile-page" >
					
		<table class="form-table">
		
			<tbody>
				
				<tr class="popup-user-nickname-wrap">

					<th><label for="enable_plugin"><?php _e('Enable plugin','phoen-visual-attributes'); ?> :</label></th>

					<td>
					
						<input id="enable_plugin" class='enable_plugin' type="checkbox" <?php if($enable_plugin == 1){ echo "checked"; } ?> value="1" name="enable_plugin">

					</td>

				</tr>
				
				<tr class="popup-user-nickname-wrap">

					<th><label for="swatches_style"><?php _e('Swatch style','phoen-visual-attributes'); ?> :</label></th>

					<td>
						<select id="swatches_style" name="swatches_style">
							<option value="1" <?php if($swatches_style == 1){ echo "selected"; } ?>><?php _e('Square', 'phoen-visual-attributes'); ?></option>
							<option value="2" <?php if($swatches_style == 2){ echo "selected"; } ?>><?php _e('Circle', 'phoen-visual-attributes'); ?></option>
							
						</select>
						
					</td>

				</tr>
				
			</tbody>
			
		</table>
		
		<p>
		
			<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save', 'phoen-visual-attributes'); ?>" /> 
		
			<input type="submit" name="reset" id="phoe_reset_form" class="button button-primary" value="<?php _e('Reset', 'phoen-visual-attributes'); ?>" /> 
		
		</p>
		
</div>
</form>
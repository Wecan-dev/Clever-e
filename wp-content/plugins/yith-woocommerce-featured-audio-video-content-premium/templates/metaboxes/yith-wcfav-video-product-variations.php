<?php
if( !defined( 'ABSPATH' ) )
    exit;


$variation_id   =   $variation->ID;

$video_params=   get_post_meta( $variation_id, '_ywcfav_variation_video', true );
$show_form_add      =    !empty( $video_params )? 'display:none;' : 'display:block;';

?>
<div class="ywcfav_variable_video" style="margin-top: 25px;">

<div class="ywcfav_variable_video_container" data-loop="<?php echo $loop;?>">
    <?php if ( !empty( $video_params ) ): 
        $args = array( 'video_params' => $video_params, 'loop' =>$loop, 'product_id' => $variation_id );
        wc_get_template( 'metaboxes/views/html-product-variation-video.php', $args, '', YWCFAV_TEMPLATE_PATH );
     endif;?>
</div>
  <div class="ywcfav_variable_video_add_container" style="<?php echo $show_form_add;?>">
    <p class="form-row form-row-full">
        <label><?php _e( 'Add Video', 'yith-woocommerce-featured-video');?></label>
        <select class="ywcfav_variation_video_add_by">
            <option value=""><?php _e( 'Select By...', 'yith-woocommerce-featured-video' );?></option>
            <option value="id"><?php _e( 'By ID', 'yith-woocommerce-featured-video' );?></option>
            <option value="url"><?php _e( 'By URL', 'yith-woocommerce-featured-video' );?></option>
            <option value="embd"><?php _e( 'By Embedded code', 'yith-woocommerce-featured-video' );?></option>
            <option value="upload"><?php _e( 'By Upload', 'yith-woocommerce-featured-video' );?></option>
        </select>
    </p>

     <p class="variation_video_title form-row form-row-full" style="display: none;">
        <label><?php _e( 'Video Title', 'yith-woocommerce-featured-video' );?></label>
        <input type="text" class="ywcfav_variation_video_title" />
    </p>
    <p class="variation_video_add_by_id form-row form-row-first" style="display: none;">
        <label><?php _e( 'Video ID', 'yith-woocommerce-featured-video' );?><a class="tips" data-tip="<?php _e( 'YouTube and Vimeo are supported', 'yith-woocommerce-featured-video' ); ?>" href="#">[?]</a></label>
        <input type="text" class="ywcfav_variation_video_add_by_id" />
    </p>

    <p class="variation_video_add_by_url form-row form-row-first" style="display: none;">
        <label><?php _e( 'Video URL', 'yith-woocommerce-featured-video' );?> <a class="tips" data-tip="<?php _e( 'YouTube and Vimeo are supported', 'yith-woocommerce-featured-video' ); ?>" href="#">[?]</a></label>
        <input type="text" class="ywcfav_variation_video_add_by_url" />
    </p>
    <p class="variation_video_add_by_embedded form-row form-row-full" style="display: none;">
        <label><?php _e( 'Embedded code', 'yith-woocommerce-featured-video' );?></label>
        <textarea class="ywcfav_variation_video_add_by_embedded" style="width: 100%;" rows="4"></textarea>
    </p>

    <p class="variation_video_type form-row form-row-last" style="display: none;">
        <label for="ywcfav_variation_video_type_host"><?php _e( 'Host', 'yith-woocommerce-featured-video' );?></label>
        <select class="ywcfav_variation_video_type_host">
            <option value="youtube"><?php _e('YouTube','yith-woocommerce-featured-video');?></option>
            <option value="vimeo"><?php _e('Vimeo', 'yith-woocommerce-featured-video');?></option>
        </select>
    </p>
            <p class="variation_video_button_add form-row form-row-first" style="display: none;">
                <button type="button" class="button button-primary ywcfav_add_variable_video"><?php _e( 'Add Video', 'yith-woocommerce-featured-video' ) ?></button>
            </p>
    <p class="variation_video_add_by_upload form-row form-row-first" style="display: none;">
        <button type="button" class="ywcfav_variation_video_add_by_upload button button-primary" data-choose="<?php _e('Select Video', 'yith-woocommerce-featured-video');?>"><?php _e( 'Upload', 'yith-woocommerce-featured-video');?></button>
        <input type="hidden" name="ywcfav_variation_video_id_up" value="" class="ywcfav_variation_video_id" />
    </p>
  </div>
</div>

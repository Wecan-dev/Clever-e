<?php
if( !defined( 'ABSPATH' ) )
    exit;

global $post, $product_object;

$product_id = ! empty( $product_object ) && is_callable( array( $product_object, 'get_id' ) ) ? $product_object->get_id() : $post->ID;

$product_video = get_post_meta( $product_id, '_ywcfav_video', true );

?>

<div id="ywcfav_video_data" class="panel wc-metaboxes-wrapper">
    <div class="toolbar toolbar-top">
	    <span class="expand-close">
		    <a href="#" class="expand_all"><?php _e( 'Expand', 'woocommerce' ); ?></a> / <a href="#" class="close_all"><?php _e( 'Close', 'woocommerce' ); ?></a>
		</span>
        <strong><?php _e( 'Product Video', 'yith-woocommerce-featured-video' );?></strong>
    </div>
    <div class="product_video wc-metaboxes">
        <?php
            if( !empty( $product_video ) ){

                $loop=0;
                foreach( $product_video as $video ){

                    $args = array( 'video_params' => $video, 'loop' =>$loop, 'product_id' => $product_id );

                    wc_get_template( 'metaboxes/views/html-product-video.php', $args, '', YWCFAV_TEMPLATE_PATH );
                    $loop++;
                }
            }
        ?>
    </div>
    <?php do_action( 'ywcfav_woocommerce_product_options_videos' ); ?>

        <div id="ywcfav_form_container">

            <p class="video_add_by form-field">
                <label for="ywcfav_video_add_by"><?php _e( 'Add Video', 'yith-woocommerce-featured-video' );?></label>
                <select id="ywcfav_video_add_by">
                    <option value=""><?php _e( 'Select By...', 'yith-woocommerce-featured-video' );?></option>
                    <option value="id"><?php _e( 'By ID', 'yith-woocommerce-featured-video' );?></option>
                    <option value="url"><?php _e( 'By URL', 'yith-woocommerce-featured-video' );?></option>
                    <option value="embd"><?php _e( 'By Embedded code', 'yith-woocommerce-featured-video' );?></option>
                    <option value="upload"><?php _e( 'By Upload', 'yith-woocommerce-featured-video' );?></option>
                </select>
            </p>
            <p class="video_name form-field" style="display: none;">
                <label for="ywcfav_video_name"><?php _e( 'Video Name', 'yith-woocommerce-featured-video' );?></label>
                <input type="text" id="ywcfav_video_name" />
            </p>
            <p class="video_type_host form-field" style="display: none;">
                <label for="ywcfav_video_type_host"><?php _e( 'Host', 'yith-woocommerce-featured-video' );?></label>
                <select id="ywcfav_video_type_host">
                    <option value="youtube"><?php _e('YouTube','yith-woocommerce-featured-video');?></option>
                    <option value="vimeo"><?php _e('Vimeo', 'yith-woocommerce-featured-video');?></option>
                </select>
            </p>
            <p class="video_add_by_id form-field" style="display: none;">
                <label for="ywcfav_video_add_by_id"><?php _e( 'Video ID', 'yith-woocommerce-featured-video' );?></label>
                <span class="description"><?php _e( 'YouTube and Vimeo are supported', 'yith-woocommerce-featured-video' );?></span>
                <input type="text" id="ywcfav_video_add_by_id" />
            </p>

            <p class="video_add_by_url form-field" style="display: none;">
                <label for="ywcfav_video_add_by_url"><?php _e( 'Video URL', 'yith-woocommerce-featured-video' );?></label>
                <span class="description"><?php _e( 'YouTube and Vimeo are supported', 'yith-woocommerce-featured-video' );?></span>
                <input type="text" id="ywcfav_video_add_by_url" />
            </p>
            <p class="video_add_by_embedded form-field" style="display: none;">
                <label for="ywcfav_video_add_by_embedded"><?php _e( 'Embedded code', 'yith-woocommerce-featured-video' );?></label>
                <textarea id="ywcfav_video_add_by_embedded" style="width: 100%;" rows="4"></textarea>
            </p>
            <p class="video_add_by_upload form-field" style="display: none;">
                <button type="button" id="ywcfav_video_add_by_upload" class="button button-primary" data-choose="<?php _e('Select Video', 'yith-woocommerce-featured-video');?>"><?php _e( 'Upload', 'yith-woocommerce-featured-video');?></button>
                <input type="hidden" name="ywcfav_video_id_up" value="" id="ywcfav_video_id_up" />
                <input type="hidden" name="ywcfav_video_url_up" value="" id="ywcfav_video_url_up" />
            </p>
            <p class="toolbar">
                <button type="button" class="button button-primary ywfav_add_video" ><?php _e( 'Add Video', 'yith-woocommerce-featured-video' ) ?></button>
            </p>

        </div>

</div>
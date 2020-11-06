<?php
if( !defined( 'ABSPATH' ) )
    exit;

$audio_label = empty ( $audio_params['name'] ) ? 'Audio '.$loop : $audio_params['name'];
$thumbnail =      $audio_params['thumbn'];

if( is_numeric( $thumbnail ) ) {
    $url = wp_get_attachment_image_src( $thumbnail, 'full');
    $url = $url[0];

}
else
    $url = $thumbnail;


$featured_content_meta = get_post_meta( $product_id, '_ywcfav_featured_content', true );

$is_featured = ( isset( $featured_content_meta['id'] ) && $featured_content_meta['id'] === $audio_params['id'] ) ;
$featured_label = $is_featured ? '( '.__( 'Featured', 'yith-woocommerce-featured-video' ).' )' : '' ;

?>
<div class="ywcfav_woocommerce_audio wc-metabox closed">
    <h3>
        <a href="#" class="ywcfav_delete_audio delete"><?php _e( 'Remove', 'woocommerce' ); ?></a>
        <div class="handlediv" title="<?php esc_attr_e( 'Click to toggle', 'woocommerce' ); ?>"></div>
        <strong class="attribute_name"><?php echo esc_html( $audio_label ); ?></strong>
        <span class="label_is_featured"><?php echo $featured_label;?></span>
    </h3>
    <div class="ywcfav_woocommerce_audio_data wc-metabox-content">
        <table cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td class="ywcfav_audio_image">
                    <label><?php _e( 'Audio Thumbnail:', 'yith-woocommerce-featured-video' );?></label>
                    <a href="#" class="ywcfav_upload_image_button" data-choose="<?php _e('Select Thumbnail','yith-woocommerce-featured-video');?>" >
                        <img src="<?php echo $url;?>" class="ywcfav_thumbn upload_image_id"/>
                    </a>
                    <input type="hidden" class="thumbn_id" name="ywcfav_audio[<?php echo $loop;?>][thumbn]" value="<?php echo $thumbnail;?>" />
                    <input type="hidden" class="ywcfav_audio_id" name="ywcfav_audio[<?php echo $loop;?>][id]" value="<?php echo $audio_params['id'];?>" />
					 <input type="hidden" class="ywcfav_audio_id" name="ywcfav_audio[<?php echo $loop;?>][featured]" value="<?php echo $is_featured? 'featured' : 'no';?>"/>
                </td>

            </tr>
            <tr class="ywcfav_extra_info">
                <td class="ywcfav_audio_title">
                    <label><?php _e( 'Audio Title', 'yith-woocommerce-featured-video' );?></label>
                    <input type="text" name="ywcfav_audio[<?php echo $loop;?>][name]" value="<?php echo $audio_label;?>" />
                </td>
                <td class="ywcfav_audio_url">
                        <label><?php _e( 'Audio Url', 'yith-woocommerce-featured-video' );?></label>
                        <span class="ywcfav_audio_content_label"><?php echo $audio_params['url'];?></span>
                        <input type="hidden" class="ywcfav_audio_url" name="ywcfav_audio[<?php echo $loop;?>][url]" value="<?php esc_attr_e( $audio_params['url'] );?>">
                    </div>
                </td>

            </tr>
            </tbody>
        </table>
    </div>
</div>
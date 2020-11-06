<?php
if( !defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$video_data = array(
	'volume'       => $volume,
	'loop'         => $loop,
	'is_stoppable' => $is_stoppable,
	'force_muted'  => isset( $force_muted ),
);

$video_data = htmlspecialchars( wp_json_encode( $video_data ) );

if ( 'youtube' == $host ) {
	$video_class = 'youtube';

	$query_args = array(
		'enablejsapi' => 1,
		'version'     => 3,
		'origin'      => get_site_url(),
		'controls'    => 'yes' == $show_controls ? 1 : 0,
		'color'       => $color,
		'loop'        => 'yes' == $loop ? 1 : 0,
		'rel'         => 'yes' == $show_rel ? 1 : 0,
		'autoplay'    => 'yes' == $autoplay  ? 1 : 0,
		'theme'       => $theme,
		'videoId'     => $video_id

	);

	$data = htmlspecialchars( wp_json_encode( $query_args ) );


} elseif ( 'vimeo' == $host ) {
	$video_class = 'vimeo';
	$url         = "//player.vimeo.com/video/" . $video_id;

	$query_args = array(
		'id' => $video_id,
		'loop' => 'yes' == $loop,
		'autoplay' => 'yes' == $autoplay ,
		'muted'   => isset( $force_muted ),
		'title' => 'yes' == $show_info,
		'color' => str_replace('#','',$color )
	);
	$data = htmlspecialchars( wp_json_encode( $query_args ) );
}elseif( 'host' == $host ){
	$video_class = 'host';
	$query_args = array(
		'loop' => 'yes' == $loop,
		'autoplay' => 'yes' == $autoplay ,
		'muted'   => 'yes' == $autoplay,
		'controls' => 'yes' == $show_controls,
		'poster'  => '',
		'volume'       => $volume,
		'is_stoppable' => $is_stoppable,
		'video_id' => $video_id

	);

}else{
	$video_class = 'embedded';
}
$custom_css = '';

$aspect_ratio = explode('_', $aspect_ratio );
$aspect_ratio_value= apply_filters( 'ywfav_video_aspect_ratio', ( $aspect_ratio[1]/$aspect_ratio[0] )*100, $aspect_ratio );
if( 'host' !== $video_class ){
	$custom_css = 'padding-bottom:'.$aspect_ratio_value.'%;';
}
$id = $id.'_modal';
?>
<div class="ywcfav-video-content <?php echo $video_class;?>" style="<?php echo $custom_css;?>">
	<?php

	include_once( YWCFAV_DIR.'templates/template_video_' . $video_class . '_player.php' );
	?>
</div>


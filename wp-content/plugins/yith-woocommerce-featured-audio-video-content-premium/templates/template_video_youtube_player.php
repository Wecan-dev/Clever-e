<?php
$url = "https://www.youtube.com/embed/".$video_id;

$args = array(
        'enablejsapi' => '1',
        'origin' => get_site_url(),
        'rel'         => 'yes' == $show_rel ? 1 : 0,

);

$url = esc_url( add_query_arg( $args, $url));
?>
<iframe id="<?php echo $id; ?>" onload="onYouTubeIframeAPIReady()" src="<?php echo $url;?>" data-video="<?php echo $video_data; ?>"
        data-ytb="<?php echo $data; ?>" frameborder="0" scrolling="no" allowfullscreen allow="autoplay; accelerometer; encrypted-media; gyroscope; picture-in-picture">
</iframe>
<?php
include ( YWCFAV_DIR.'assets/php/youtube_manager.php');
?>
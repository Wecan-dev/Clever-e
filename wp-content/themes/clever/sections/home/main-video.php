  <section class="main-video">
    <div class="padding-top-bottom">
      <div class="padding-right-left">
        <div class="main-video__title">
          <h2 class="main-general__title--light">
            <?php echo get_theme_mod('video_title_light_'.lang().''); ?>
          </h2>
          <h2 class="main-general__title--bold">
            <?php echo get_theme_mod('video_title_bold_'.lang().''); ?>
          </h2>
        </div>
      </div>
      <div class="main-video__carousel">
      <?php $args = array('post_type' => 'itemsvideo', 'order'=> 'ASC','post_status' => 'publish', 'posts_per_page' => 100); ?>        
      <?php $loop = new WP_Query( $args ); ?>
      <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>        
        <div class="main-video__item">
          <img src="<?php the_field('image_items_video'); ?>">
        </div>
      <?php endwhile; ?> 
      </div>
    </div>
  </section>

  <section class="main-banner">
    <div class="main-banner__content">
      <?php $args = array('post_type' => 'itemsbanner', 'order'=> 'ASC','post_status' => 'publish', 'posts_per_page' => 100); ?>        
      <?php $loop = new WP_Query( $args ); ?>
      <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>     
      <div class="main-banner__item">
        <div class="main-banner__text wow animated fadeIn" style="visibility: visible; animation-delay: .3s  ;">
          <div class="main-banner__width">
            <h2 class="main-banner__title">
              <?php the_field('banner_subtitle'); ?>
            </h2>
            <p class="main-banner__subtitle">
              <?php the_field('banner_description'); ?>
            </p>
            <br>
            <a class="main-general__button main-general__button--white" href="<?php the_field('banner_urlbutton'); ?>"><?php the_field('banner_button'); ?></a>
          </div>
        </div>
        <div class="main-banner__img">
          <img alt="Imagen Banner" src="<?php the_field('banner_image'); ?>">
        </div>
      </div>
    <?php endwhile; ?>   
    </div>
  </section>
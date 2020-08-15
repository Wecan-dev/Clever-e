  <section class="main-products">
    <div class="padding-top-bottom">
      <div class="padding-right-left">
        <h2 class="main-general__title--light">
          <?php echo get_theme_mod('products_title_'.lang().''); ?>
        </h2>
        <h2 class="main-general__title--bold">
          <?php echo get_theme_mod('products_subtitle_'.lang().''); ?>
        </h2>
      </div>
      <div class="main-products__carousel">
        <?php
          $args = array (
             'post_type' => 'product',
             'posts_per_page' => 100,
             'post_status' => 'publish'

          );
        $loop = new WP_Query( $args ); 
        while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>       
        <div class="main-products__item">
          <div class="main-products__img">
            <div class="main-products__mask">
              <div class="main-products__icon">
              <?php if (variation(get_the_ID()) <= 0){ ?>
                <a href="?add-to-cart=<?php echo get_the_ID(); ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/card.png">
                </a>
              <?php } ?>  
              <?php if (variation(get_the_ID()) > 0){ ?>
               <a href="<?php the_permalink(); ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/card.png">
                </a>              
              <?php } ?>   
                <a href="?add_to_wishlist=<?php echo get_the_ID(); ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/heart.png">
                </a>
                <a href="<?php echo get_home_url() ?>/search">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/search.png">
                </a>
              </div>
            </div>
            <img src="<?php the_post_thumbnail_url('full');?>">
          </div>
          <div class="main-products__body">
            <a class="main-products__title" href="">
              <?php the_title(); ?>
            </a>
            <p class="main-products__categorie">
              categoría <?php echo get_term(get_the_ID())->name; ?>
            </p>
            <p class="main-products__price">
              <?php echo $product->get_price_html(); ?>
            </p>
          </div>
        </div>
      <?php endwhile; ?>   
      </div>
    </div>
  </section>

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
                <a href="<?php the_permalink(); ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/search.png">
                </a>
              </div>
            </div>
            <img src="<?php the_post_thumbnail_url('full');?>">
          </div>
          <div class="main-products__body">
            <a class="main-products__title" href="<?php the_permalink(); ?>">
              <?php the_title(); ?>
            </a>
            <p class="main-products__categorie">
              <?php if(lang() == 'es'){echo "categoría ";}if(lang() == 'en'){echo "category ";}  echo array_shift( wp_get_post_terms( get_the_ID(), 'product_cat' ))->name;?>
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
<script type="text/javascript">
      $(document).ready(function() {       
        var langu = "<?= get_bloginfo('language') ?>";         
        if (langu == 'en-US'){ 
          $(".be").html(function(serachreplace, replace) {
            return replace.replace('Antes', 'Before');
          });          
          $(".af").html(function(serachreplace, replace) {
            return replace.replace('Después', 'After');
          }); 
        }         

    }); 
</script>
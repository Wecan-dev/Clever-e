<?php get_header(); 
 while ( have_posts() ) : the_post();
 ?>


<!--None template -->
<?php if( get_the_content() != NULL){ ?>
    <?php
              // Include the page content template.
    /*  get_template_part( 'content', 'page' );*/
    the_content();

              // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
      comments_template();
    endif;           
    ?>  
<?php } ?>   

<?php if(get_field('template_clever') == 'Página General'){ ?>  
  <section class="banner-small banner-catalogo">
    <img class="banner-small__img" src="<?php the_field('image-banner-general-page'); ?>">
    <div class="banner-small__text">
      <p class="banner-small__title--small">
        <?php the_field('title-banner-general-page'); ?>
      </p>
      <h2 class="banner-small__title">
        <?php the_field('subtitle-banner-general-page'); ?>
      </h2>
    </div>
  </section>
  <section class="main-categories catalogo">
    <div class="padding-top-bottom">
      <?php
              // Include the page content template.
      /*  get_template_part( 'content', 'page' );*/
      the_content();

              // If comments are open or we have at least one comment, load up the comment template.
      if ( comments_open() || get_comments_number() ) :
        comments_template();
      endif;           
      ?>    
    </div>
  </section>  

<?php } ?> 

<?php if(get_field('template_clever') == 'Catálogo'){ ?>  
  <section class="banner-small banner-catalogo">
    <img class="banner-small__img" src="<?php the_field('image-banner-catalogo'); ?>">
    <div class="banner-small__text">
      <p class="banner-small__title--small">
        <?php the_field('title-banner-catalogo'); ?>
      </p>
      <h2 class="banner-small__title">
        <?php the_field('subtitle-banner-catalogo'); ?>
      </h2>
    </div>
  </section>
  <section class="main-categories catalogo">
    <div class="padding-top-bottom">
      <div class="main-categories__flex">
      <?php $product_categories = get_categories( array( 'taxonomy' => 'product_cat', 'orderby' => 'menu_order', 'order' => 'asc' ));  ?>
      <?php foreach($product_categories as $category):  global $wpdb;?>
      <?php $result = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."term_taxonomy where taxonomy = 'product_cat'");?>               
        <div class="main-categories__item">
          <img src="<?php echo wp_get_attachment_url( get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true ) );?>">
          <a class="main-categories__mask" href="<?php echo get_category_link( $category->term_id ); ?>">
            <h2 class="main-categories__title">
             <?=$category->name ?>
            </h2>
          </a>
        </div>
      <?php endforeach; ?>   
      </div>
    </div>
  </section>
<?php } ?> 

<?php  endwhile; ?>
<?php get_footer(); ?>
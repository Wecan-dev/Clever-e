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

<?php if(get_field('template_clever') == 'Shop'){  
   require_once trailingslashit( get_template_directory() ) . 'woocommerce/archive-product.php';
} ?>

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

<?php if(get_field('template_clever') == 'Contacto'){ ?>  
  <!-- Modal HTML -->
  <div class="contact-modal">
    <div class="modal fade" id="myModal">
      <div class="modal-dialog modal-login">
        <div class="modal-content">
          <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
          <div class="modal-body">
            <div class="d-flex justify-content-center">
              <img class="contact-modal__icon" src="<?php echo get_template_directory_uri();?>/assets/img/contact/mail.png">
            </div>
            <h2 class="contact-modal__title">
              <?php the_field('title-contacto'); ?>
            </h2>
            <?php if (lang() == "es") {
              echo do_shortcode('[formidable id=3]');
            }?>
            <?php if (lang() == "en") {
              echo do_shortcode('[formidable id=4]');
            }?>           
          </div>
        </div>
      </div>
    </div>
  </div>
  <section class="contact">
    <div class="padding-top-bottom padding-right-left">
      <h2 class="contact-title">
         <?php the_field('subtitle-distribuidor'); ?>
      </h2>
      <div class="container-grid">
        <div class="contact-item">
          <div class="contact-item__img">
            <img src="<?php the_field('image-national-distribuidor'); ?>">
            <a class="main-categories__mask" data-target="#myModal" data-toggle="modal">
              <h2 class="main-categories__title">
                 <?php the_field('title-national-distribuidor'); ?>
              </h2>
            </a>
          </div>
          <ul class="content-item__list">
            <li>
              <a href="tel:+<?php the_field('phone-national-distribuidor'); ?>">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/phone.png">
                <?php the_field('phone-national-distribuidor'); ?>
              </a>
            </li>
            <li>
              <a href="https://api.whatsapp.com/send?phone=<?php the_field('whatsapp-national-distribuidor'); ?>">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/ws.png">
                <?php the_field('whatsapp-national-distribuidor'); ?>
              </a>
            </li>
            <li>
              <a href="mailto:ventasonline@clevermoda.com">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/icon.png">
                <?php the_field('email-national-distribuidor'); ?>
              </a>
            </li>
          </ul>
        </div>
        <div class="contact-item">
          <div class="contact-item__img">
            <img src="<?php the_field('image-international-distribuidor'); ?>">
            <a class="main-categories__mask" data-target="#myModal" data-toggle="modal">
              <h2 class="main-categories__title">
                <?php the_field('title-international-distribuidor'); ?>
              </h2>
            </a>
          </div>
          <ul class="content-item__list">
            <li>
              <a href="tel:+<?php the_field('phone-international-distribuidor'); ?>">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/phone.png">
                <?php the_field('phone-international-distribuidor'); ?>
              </a>
            </li>
            <li>
              <a href="https://api.whatsapp.com/send?phone=<?php the_field('whatsapp-international-distribuidor'); ?>">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/ws.png">
               <?php the_field('whatsapp-international-distribuidor'); ?>
              </a>
            </li>
            <li>
              <a href="mailto:ventasonline@clevermoda.com">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/icon.png">
                <?php the_field('email-international-distribuidor'); ?>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section class="contact-sitemap">
    <?php the_field('map_contacto'); ?>
  </section>
<?php } ?> 

<?php  endwhile; ?>
<?php get_footer(); ?>
<?php get_header(); 
 while ( have_posts() ) : the_post();
 
 
 ?>

<?php if( get_the_content() != NULL){ ?> 
<section class="main-blog">
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

<?php if(get_field('template_clever') == 'General Page'){ ?>  
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

<?php if(get_field('template_clever') == 'Catalogo'){ ?>  
  <section class="banner-small banner-catalogo">
    <img class="banner-small__img" src="<?php echo get_template_directory_uri();?>/assets/img/categorie/catalogo.png">
    <div class="banner-small__text">
      <p class="banner-small__title--small">
        Clever style
      </p>
      <h2 class="banner-small__title">
        compra aquí
      </h2>
    </div>
  </section>
  <section class="main-categories catalogo">
    <div class="padding-top-bottom">
      <div class="main-categories__flex">
        <div class="main-categories__item">
          <img src="<?php echo get_template_directory_uri();?>/assets/img/catalogo/luxury.png">
          <a class="main-categories__mask" href="categoria.html">
            <h2 class="main-categories__title">
              Luxury
            </h2>
          </a>
        </div>
        <div class="main-categories__item">
          <img src="<?php echo get_template_directory_uri();?>/assets/img/catalogo/pick go.png">
          <a class="main-categories__mask" href="categoria.html">
            <h2 class="main-categories__title">
              Pick & go
            </h2>
          </a>
        </div>
        <div class="main-categories__item">
          <img src="<?php echo get_template_directory_uri();?>/assets/img/catalogo/swimwear.png">
          <a class="main-categories__mask" href="categoria.html">
            <h2 class="main-categories__title">
              swimwear
            </h2>
          </a>
        </div>
        <div class="main-categories__item">
          <img src="<?php echo get_template_directory_uri();?>/assets/img/catalogo/sports.png">
          <a class="main-categories__mask" href="categoria.html">
            <h2 class="main-categories__title">
              sports wear
            </h2>
          </a>
        </div>
        <div class="main-categories__item">
          <img src="<?php echo get_template_directory_uri();?>/assets/img/catalogo/basic.png">
          <a class="main-categories__mask" href="categoria.html">
            <h2 class="main-categories__title">
              basic
            </h2>
          </a>
        </div>
        <div class="main-categories__item">
          <img src="<?php echo get_template_directory_uri();?>/assets/img/catalogo/sale.png">
          <a class="main-categories__mask" href="categoria.html">
            <h2 class="main-categories__title">
              sale
            </h2>
          </a>
        </div>
      </div>
    </div>
  </section>

<?php } ?> 

<?php  endwhile; ?>
<?php get_footer(); ?>
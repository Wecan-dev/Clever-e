  <section class="main-categories">
    <div class="padding-top-bottom">
      <h2 class="main-general__title--light">
        <?php echo get_theme_mod('categories_title_'.lang().''); ?>
      </h2>
      <h2 class="main-general__title--bold">
        <?php echo get_theme_mod('categories_subtitle_'.lang().''); ?>
      </h2>
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

  <section class="main-seller">
    <div class="padding-top-bottom">
      <h2 class="main-general__title--bold">
        <?php echo get_theme_mod('seller_title_'.lang().''); ?>
      </h2>
      <div class="container-grid">
        <?php for ($i=1; $i <=5 ; $i++) { 
          if (get_theme_mod('seller'.$i.'_image') != NULL) {?>
            <img class="main-seller__img" src="<?php echo get_theme_mod('seller'.$i.'_image'); ?>">
        <?php }} ?>
      </div>
      <div class="d-flex justify-content-center">
        <a class="main-general__button" href="<?php get_theme_mod('seller_urlbuttom_'.lang().'');?>"><?php echo  get_theme_mod('seller_buttom_'.lang().''); ?></a>
      </div>
    </div>
  </section>

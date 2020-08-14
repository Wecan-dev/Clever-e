  <section class="main-banner">
    <div class="main-banner__content">
      <?php for ($i=1; $i <= 2; $i++) { ?>
      <?php if (get_theme_mod('banner'.$i.'_image')!= NULL ) { ?>     
      <div class="main-banner__item">
        <div class="main-banner__text wow animated fadeIn" style="visibility: visible; animation-delay: .3s  ;">
          <div class="main-banner__width">
            <div class="main-banner__title--small">
              <p>
                <?php echo get_theme_mod('banner'.$i.'_title_'.lang().''); ?>
              </p>
            </div>
            <h2 class="main-banner__title">
              <?php echo get_theme_mod('banner'.$i.'_subtitle_'.lang().''); ?>
            </h2>
            <p class="main-banner__subtitle">
              <?php echo get_theme_mod('banner'.$i.'_description_'.lang().''); ?>
            </p>
            <br>
            <a class="main-general__button main-general__button--white" href="<?php echo get_theme_mod('banner'.$i.'_urlbutton_'.lang().''); ?>"><?php echo get_theme_mod('banner'.$i.'_button_'.lang().''); ?></a>
          </div>
        </div>
        <div class="main-banner__img">
          <img alt="Imagen Banner" src="<?php echo get_theme_mod('banner'.$i.'_image'); ?>">
        </div>
      </div>
    <?php }} ?>  
    </div>
  </section>
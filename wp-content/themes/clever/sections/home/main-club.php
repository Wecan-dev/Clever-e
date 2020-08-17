  <section class="main-club">
    <div class="padding-top-bottom padding-right-left">
      <div class="container-grid">
        <div class="main-club__text">
          <p class="main-club__title--light">
            <?php echo get_theme_mod('club_title_light_'.lang().''); ?>
          </p>
          <p class="main-club__title--italic">
            <?php echo get_theme_mod('club_title_italic_'.lang().''); ?>
          </p>
          <p class="main-club__title--bold">
            <?php echo get_theme_mod('club_title_bold_'.lang().''); ?>
          </p>
          <p class="main-club__description">
            <?php echo get_theme_mod('club_description_'.lang().''); ?>
          </p>
        </div>
        <div class="main-club__form">
          <div class="main-club__content">
            <?php if (lang() == "es") {
              echo do_shortcode('[formidable id=1]');
            }?>
            <?php if (lang() == "en") {
              echo do_shortcode('[formidable id=2]');
            }?>      
            
          </div>
        </div>
      </div>
    </div>
  </section>

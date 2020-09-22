  <section class="main-newsletter">
    <div class="main-newsletter__bg"></div>
    <div class="padding-top-bottom padding-right-left">
      <div class="d-flex justify-content-center">
        <div class="main-newsletter__content">
          <h2><?php echo get_theme_mod('newsletter_title_'.lang().''); ?></h2>
          <p>
            <?php echo str_replace("\n", "<br>", get_theme_mod('newsletter_subtitle_'.lang().'')); ?>
          </p>
          <form class="main-newsletter__form">
            <label for="new">
              <img src="<?php echo get_template_directory_uri();?>/assets/img/icon.png">
            </label>
            <input id="new" name="new" placeholder="Tu correo electrónico" type="text">
            <a class="main-general__button" href="">Enviar</a>
          </form>
        </div>
      </div>
    </div>
  </section>

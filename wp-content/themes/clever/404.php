<?php  get_header();?>
  <section class="error-404">
    <h2 class="error-404__title">
      <?php if(lang() == 'es'){echo "Lo sentimos";}if(lang() == 'en'){echo "We are sorry";}?>
    </h2>
    <h2 class="error-404__subtitle">
      <?php if(lang() == 'es'){echo "No encontramos la pagina que buscas";}if(lang() == 'en'){echo "We can't find the page you're looking for";}?>
    </h2>
    <img src="<?php echo get_template_directory_uri();?>/assets/img/404/404.png">
    <h2 class="error-404__subtitle">
      <?php if(lang() == 'es'){echo "Te llevaremos de vuelta";}if(lang() == 'en'){echo "We will take you back";}?>
    </h2>
    <a class="main-general__button" href="<?php echo get_home_url() ?>"><?php if(lang() == 'es'){echo "Volver al inicio";}if(lang() == 'en'){echo "back to top";}?></a>
  </section>
<?php  get_footer(); ?>
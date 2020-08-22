  <footer class="main-footer">
    <div class="padding-top-bottom padding-right-left">
      <div class="container-grid">
        <div class="main-footer__item">
          <div class="main-footer__logo">
            <img src="<?php echo get_template_directory_uri();?>/assets/img/logo-black.png">
          </div>
          <p class="main-footer__description">
            <?php echo str_replace("\n", "<br>", get_theme_mod('description_'.lang().'')); ?>
          </p>
          <div class="main-footer__rrss">
            <?php if (get_theme_mod('facebook_'.lang().'') != NULL) { ?>         
              <a class="rrss__item" href="<?php echo get_theme_mod('facebook_'.lang().''); ?>" target="_blank">
                <img alt="Facebook" src="<?php echo get_template_directory_uri();?>/assets/img/fb.png">
              </a>
            <?php } ?>
            <?php if (get_theme_mod('instagram_'.lang().'') != NULL) { ?>         
              <a class="rrss__item" href="<?php echo get_theme_mod('instagram_'.lang().''); ?>" target="_blank">
                <img alt="Instagram" src="<?php echo get_template_directory_uri();?>/assets/img/instagram.png">
              </a>
            <?php } ?>  
            <?php if (get_theme_mod('youtube_'.lang().'') != NULL) { ?>         
              <a class="rrss__item" href="<?php echo get_theme_mod('youtube_'.lang().''); ?>" target="_blank">
                <img alt="Youtube" src="<?php echo get_template_directory_uri();?>/assets/img/youtube.png">
              </a>
            <?php } ?>  
                                 
          </div>
        </div>
        <div class="main-footer__item">
          <h2 class="main-footer__title">
            <?php if(lang() == 'es'){echo "Menú";}if(lang() == 'en'){echo "Menu";}?>
          </h2>
          <ul class="site-map">
            <?php $product_categories = get_categories( array( 'taxonomy' => 'product_cat', 'orderby' => 'menu_order', 'order' => 'asc' ));  ?>
            <?php foreach($product_categories as $category):  global $wpdb;?>
            <?php $result = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."term_taxonomy where taxonomy = 'product_cat'");?>                   
            <li>
              <a href="<?php echo get_category_link( $category->term_id ); ?>">
                <?=$category->name ?>
              </a>
            </li>
            <?php endforeach; ?> 
          </ul>
        </div>
        <div class="main-footer__item">
          <ul class="list-contact">
            <li>
              <a href="">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/business.png">
                <?php if(lang() == 'es'){echo "Ventas nacionales e internacionales";}if(lang() == 'en'){echo "National and international sales";}?>
              </a>
            </li>
            <li>
              <a href="">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/symbol.png">
                <?php if(lang() == 'es'){echo "Información de interés";}if(lang() == 'en'){echo "Information of interest";}?>
              </a>
            </li>
            <li>
              <a href="">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/tools-and-utensils.png">
                <?php if(lang() == 'es'){echo "Compra seguras";}if(lang() == 'en'){echo "Buy safe";}?>
              </a>
            </li>
            <li>
              <a href="">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/dollar.png">
                <?php if(lang() == 'es'){echo "Múltiples medios de pago";}if(lang() == 'en'){echo "Multiple payment methods";}?>
              </a>
            </li>
            <li>
              <a href="">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/mover.png">
                <?php if(lang() == 'es'){echo "Envíos a todo nacionales e internacionales";}if(lang() == 'en'){echo "Shipments to all national and international";}?>
              </a>
            </li>
            <li>
              <a href="">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/24h.png">
                <?php if(lang() == 'es'){echo "Abierto 24/7";}if(lang() == 'en'){echo "Open 24/7";}?>
              </a>
            </li>
          </ul>
        </div>
        <div class="main-footer__item">
          <h2 class="main-footer__title">
            <?php if(lang() == 'es'){echo "Contacto";}if(lang() == 'en'){echo "Contact";}?>
          </h2>
          <ul class="list-contact">
          <?php if (get_theme_mod('address1_'.lang().'') != NULL) { ?>
            <li>            
              <a href="">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/place.png">
                <?php echo get_theme_mod('address1_'.lang().''); ?>
              </a>
            </li>
          <?php } ?>  
          <?php if (get_theme_mod('address2_'.lang().'') != NULL) { ?>
            <li>            
              <a href="">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/place.png">
                <?php echo get_theme_mod('address2_'.lang().''); ?>
              </a>
            </li>
          <?php } ?>  
          <?php if (get_theme_mod('phone1_'.lang().'') != NULL) { ?>         
            <li>
              <a href="tel:<?php echo get_theme_mod('phone1_'.lang().''); ?>">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/phone.png">
                <?php echo get_theme_mod('phone1_'.lang().''); ?>
              </a>
            </li>
          <?php } ?> 
          <?php if (get_theme_mod('phone2_'.lang().'') != NULL) { ?>         
            <li>
              <a href="tel:<?php echo get_theme_mod('phone1_'.lang().''); ?>">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/phone.png">
                <?php echo get_theme_mod('phone2_'.lang().''); ?>
              </a>
            </li>
          <?php } ?>           
            <li>
              <a href="mailto:ventasonline@clevermoda.com">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/icon.png">
                <?php echo get_theme_mod('email_'.lang().''); ?>
              </a>
            </li>
            <li>
              <a href="www.clevermoda.com">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/www.png">
                <?php echo get_theme_mod('web_'.lang().''); ?>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <div class="main-powered">
    <div class="container">
      <div class="d-flex justify-content-center p-4 main-powered__flex">
        <p>Copyright © <?php echo date("Y"); ?> Branch</p>
      </div>
    </div>
  </div>
  <?php if (get_theme_mod('whatsapp_'.lang().'') != NULL) { ?>  
  <div class="main-whatsapp">
    <a href="https://api.whatsapp.com/send?phone=<?php echo get_theme_mod('whatsapp_'.lang().''); ?>">
      <img alt="icon whatsapp" src="<?php echo get_template_directory_uri();?>/assets/img/whatsapp.png">
    </a>
  <?php } ?>  
  </div>
  <a class="boton-subir slider-top" href="#" id="js_up">
    <img src="<?php echo get_template_directory_uri();?>/assets/img/up.png">
  </a>
  <script src="<?php echo get_template_directory_uri();?>/assets/js/setting-slick.js"></script>
</body>
<?php wp_footer(); ?>
</html>
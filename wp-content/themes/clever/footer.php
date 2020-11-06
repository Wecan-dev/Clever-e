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
              <a href="<?php echo file_customizer(get_theme_mod('envios_online_'.lang().'')); ?>" download="Envios Online">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/business.png">
                <?php if(lang() == 'es'){echo "Envios Online";}if(lang() == 'en'){echo "Shipping Online";}?>
              </a>
            </li>
            <li>
              <a href="<?php echo file_customizer(get_theme_mod('terms_conditions_'.lang().'')); ?>" download="Términos y Condiciones">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/symbol.png">
                <?php if(lang() == 'es'){echo "Términos y Condiciones";}if(lang() == 'en'){echo "Terms and Conditions";}?>
              </a>
            </li>
            <li>
              <a href="<?php echo file_customizer(get_theme_mod('personal_data_processing_policy_'.lang().'')); ?>" download="Política de Tratamiento de Datos Personales">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/tools-and-utensils.png">
                <?php if(lang() == 'es'){echo "Política de Tratamiento de Datos Personales";}if(lang() == 'en'){echo "Personal Data Processing Policy";}?>
              </a>
            </li>
            <li>
              <a href="<?php echo file_customizer(get_theme_mod('guarantee_policy_'.lang().'')); ?>" download="Política de Garantía">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/dollar.png">
                <?php if(lang() == 'es'){echo "Política de Garantía";}if(lang() == 'en'){echo "Guarantee Policy";}?>
              </a>
            </li>
  
            <li>
              <a href="<?php echo file_customizer(get_theme_mod('our_history_'.lang().'')); ?>" download="Nuestra Historia">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/history.png">
                <?php if(lang() == 'es'){echo "Nuestra Historia";}if(lang() == 'en'){echo "Our History";}?>
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
              <a href="<?php echo get_theme_mod('address1_map_'.lang().''); ?>">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/place.png">
                <?php echo get_theme_mod('address1_'.lang().''); ?>
              </a>
            </li>
          <?php } ?>  
          <?php if (get_theme_mod('address2_'.lang().'') != NULL) { ?>
            <li>            
              <a href="<?php echo get_theme_mod('address2_map_'.lang().''); ?>">
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
              <a href="tel:<?php echo get_theme_mod('phone2_'.lang().''); ?>">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/phone.png">
                <?php echo get_theme_mod('phone2_'.lang().''); ?>
              </a>
            </li>
          <?php } ?>           
            <li>
              <a href="mailto:<?php echo get_theme_mod('email_'.lang().''); ?>">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/icon.png">
                <?php echo get_theme_mod('email_'.lang().''); ?>
              </a>
            </li>
            <li>
              <a href="<?php echo get_theme_mod('web_'.lang().''); ?>">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/www.png">
                <?php echo get_theme_mod('web_'.lang().''); ?>
              </a>
            </li>
          </ul>
        </div>
		   <div class="img-pasarelas" >
			  <img src="<?php echo get_template_directory_uri();?>/assets/img/epayco.png">
			  <img src="<?php echo get_template_directory_uri();?>/assets/img/paypal.png">
			  <img src="<?php echo get_template_directory_uri();?>/assets/img/payu.png">
				  
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
    <a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo get_theme_mod('whatsapp_'.lang().''); ?>">
      <img alt="icon whatsapp" src="<?php echo get_template_directory_uri();?>/assets/img/whatsapp.png">
    </a>
  <?php } ?>  
  </div>
  <a class="boton-subir slider-top" href="#" id="js_up">
    <img src="<?php echo get_template_directory_uri();?>/assets/img/up.png">
  </a>
  <script src="<?php echo get_template_directory_uri();?>/assets/js/setting-slick.js"></script>
</body>
<script type="text/javascript">
  $(document).ready(function() {       
    var langu = "<?= get_bloginfo('language') ?>";         
    if (langu == 'en-US'){ 
      $(".lang-item-en").hide();
    } 
    else 
    {
      $(".lang-item-es").hide();
    }

  }); 
</script>
<?php wp_footer(); ?>
</html>
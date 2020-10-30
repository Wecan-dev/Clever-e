<!DOCTYPE html>
<html lang="<?php bloginfo('language'); ?>">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php wp_title('|', true, 'right'); ?></title>
  <?php wp_head(); ?>  
</head>
<body>
  <div class="pre-navbar__carousel">
    <?php for ($i=1; $i <= 2; $i++) { ?>
    <?php if (get_theme_mod('prenavbar'.$i.'_image')!= NULL ) { ?>   
    <div class="pre-navbar__item">
      <div class="pre-navbar">
        <img class="icon-tarjeta" src="<?php echo get_theme_mod('prenavbar'.$i.'_image'); ?>">
        <p>
          <?php echo get_theme_mod('prenavbar'.$i.'_title_'.lang().''); ?>
        </p>
        <img class="icon-line" src="<?php echo get_template_directory_uri();?>/assets/img/line-2.png">
        <p>
          <?php echo get_theme_mod('prenavbar'.$i.'_line1_'.lang().''); ?>
        </p>
        <img class="icon-line" src="<?php echo get_template_directory_uri();?>/assets/img/line.png">
        <p>
          <?php echo get_theme_mod('prenavbar'.$i.'_line2_'.lang().''); ?>
        </p>
        <a class="main-general__button" href="<?php echo get_theme_mod('prenavbar'.$i.'_urlbutton_'.lang().''); ?>"><?php echo get_theme_mod('prenavbar'.$i.'_button_'.lang().''); ?><img class="icon-tarjeta" src="<?php echo get_template_directory_uri();?>/assets/img/next.png"></a>
      </div>
    </div>
   <?php }} ?>
  </div>
  <?php if ( is_home() ) : ?>
  <header class="nav-custom">
    <nav class="navbar navbar-expand-lg">
      <div class="nav-padding">
        <div class="main-brand__top">
          <div class="main-brand">
            <a class="navbar-brand" href="<?php echo get_home_url() ?>">
              <img alt="Logo Clever" id="iso" src="<?php echo get_template_directory_uri();?>/assets/img/logo.png">
            </a>
          </div>
        </div>
        <div class="main-brand__fixed">
          <div class="main-brand">
            <a class="navbar-brand" href="<?php echo get_home_url() ?>">
              <img alt="Logo Clever" id="iso" src="<?php echo get_template_directory_uri();?>/assets/img/logo.png">
            </a>
          </div>
        </div>
        <div class="main-brand brand-responsive">
          <a class="navbar-brand" href="<?php echo get_home_url() ?>">
            <img alt="Logo Clever" id="iso" src="<?php echo get_template_directory_uri();?>/assets/img/logo-black.png">
          </a>
          <button class="navbar-toggler p-2 border-0 hamburger hamburger--elastic ml-autos" data-toggle="offcanvas" type="button">
            <span class="hamburger-box"></span>
            <span class="hamburger-inner"></span>
          </button>
        </div>
        <div class="navbar-collapse offcanvas-collapse">
          <ul class="navbar-nav mr-autos">
            <li class="nav-item nav-item__custom dropdown">
              <a aria-expanded="false" aria-haspopup="true" class="nav-link"  href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "catalogo";}else{echo "catalogue ";} ?>" role="button"><?php if(lang() == 'es'){echo "Categorías";}if(lang() == 'en'){echo "Category ";} ?></a>
              <div class="dropdown-menu">
                <?php $product_categories = get_categories( array( 'taxonomy' => 'product_cat', 'orderby' => 'menu_order', 'order' => 'asc' ));  ?>
                <?php foreach($product_categories as $category):  global $wpdb;?>
                <?php $result = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."term_taxonomy where taxonomy = 'product_cat'");?>                       
                  <a class="dropdown-item" href="<?php echo get_category_link( $category->term_id ); ?>"><?=$category->name ?></a>
                <?php endforeach; ?> 
              </div>
            </li>
            <li class="nav-item nav-item__custom">
              <a class="nav-link nav-link-p" data="offcanvas" href="<?php if(lang() == 'es'){echo ''.get_home_url().'/best-seller';}if(lang() == 'en'){echo ''.get_home_url().'/best-seller-en';}  ?>">Best Seller</a>
            </li>
            <li class="nav-item nav-item__custom">
              <a class="nav-link nav-link-p" data="offcanvas" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "contacto";}else{echo "contact ";} ?>"><?php if(lang() == 'es'){echo "Contacto";}if(lang() == 'en'){echo "Contact ";} ?></a>
            </li>            
            <li class="nav-item nav-responsive">
              <div class="content-icon">
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "mi-cuenta";}else{echo "my-account";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/user.png">
                </a>
               <?php if(is_user_logged_in() != NULL){ ?>
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "lista-de-deseos";}else{echo "wishlist";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/heart.png">
                  <span class="nav-item__number">
                  <?php $wishlist_count = YITH_WCWL()->count_products(); echo esc_html( $wishlist_count ); ?>
                  </span>
                </a>
                <?php }else { ?>
                    <div data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if(lang() == 'es'){echo "Debes estar iniciar sesión";}else{echo "You must be logged";} ?>" class="collection-item__icon nav-icon" >
                      <img src="<?php echo get_template_directory_uri();?>/assets/img/heart.png">
                    </div>                
                <?php } ?>
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "carrito";}else{echo "cart";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/card.png">
                  <span class="nav-item__number">
                    <?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?>
                  </span>
                </a>              
              </div>
              <ul class="navbar-nav mr-autos">
                <li class="nav-item dropdown drop-money">
                  <a aria-expanded="false" aria-haspopup="true" class="nav-world nav-link" data-toggle="" href="catalogo.html"><img src="<?php echo get_template_directory_uri();?>/assets/img/world.png"></a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item woocs_flag_view_item" href="?wmc-currency=USD" data-currency="USD" title="USD, $ USA dollar">USD, $</a>
                    <a href="?wmc-currency=COP" class="dropdown-item woocs_flag_view_item" data-currency="COP" title="COP, $ Peso Colombiano">COP, $</a>
                  </div>
                </li>
              </ul>  
                <ul class="navbar-nav mr-autos">
                  <li class="nav-item dropdown drop-money">
                    <a aria-expanded="false" aria-haspopup="true" class="nav-world nav-link dropdown-toggle" data-toggle="dropdown" href="catalogo.html" role="button"><?php if (lang() == 'es'){ echo "Idioma"; }else{ echo "Language"; } $url = explode('en', $_SERVER['REQUEST_URI'], 2); ?></a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item woocs_flag_view_item" title="English" lang="en-US" hreflang="en-US" href="<?php echo $url[0]; ?>en/">English</a>
                      <a class="dropdown-item woocs_flag_view_item" title="Español"lang="es-CO" hreflang="es-CO" href="<?php echo $url[0]; ?>">Español</a>
                    </div>
                  </li>
                </ul>                          
              <!--<?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
              <aside class="in-header widget-area right" role="complementary">
                <?php dynamic_sidebar( 'sidebar-1' ); ?>
              </aside>
              <?php } ?>-->
            </li>
            <li class="nav-item nav-flex">
              <div class="content-icon">
              
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "mi-cuenta";}else{echo "my-account";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/user-2.png">
                </a>
                <?php if(is_user_logged_in() != NULL){ ?>
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "lista-de-deseos";}else{echo "wishlist";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/love.png">
                  <span class="nav-item__number">
                    <?php $wishlist_count = YITH_WCWL()->count_products(); echo esc_html( $wishlist_count ); ?>
                  </span>                  
                </a>
                <?php }else { ?>
                    <div data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if(lang() == 'es'){echo "Debes estar iniciar sesión";}else{echo "You must be logged";} ?>" class="collection-item__icon nav-icon" >
                      <img src="<?php echo get_template_directory_uri();?>/assets/img/love.png">
                    </div>                
                <?php } ?>
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "carrito";}else{echo "cart";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/card-2.png">
                  <span class="nav-item__number">
                    <?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?>
                  </span>                  
                </a>              
                <ul class="navbar-nav mr-autos">
                  <li class="nav-item dropdown drop-money">
                    <a aria-expanded="false" aria-haspopup="true" class="nav-world nav-link dropdown-toggle" data-toggle="dropdown" href="catalogo.html" role="button"><img src="<?php echo get_template_directory_uri();?>/assets/img/world.png"></a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item woocs_flag_view_item" href="?wmc-currency=USD" data-currency="USD" title="USD, $ USA dollar">USD, $</a>
                      <a href="?wmc-currency=COP" class="dropdown-item woocs_flag_view_item" data-currency="COP" title="COP, $ Peso Colombiano">COP, $</a>
                    </div>
                  </li>
                </ul>

                <ul class="navbar-nav mr-autos">
                  <li class="nav-item dropdown drop-money">
                    <a aria-expanded="false" aria-haspopup="true" class="nav-world nav-link dropdown-toggle" data-toggle="dropdown" href="catalogo.html" role="button"><?php if (lang() == 'es'){ echo "Idioma"; }else{ echo "Language"; } $url = explode('en', $_SERVER['REQUEST_URI'], 2); ?></a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item woocs_flag_view_item" title="English" lang="en-US" hreflang="en-US" href="<?php echo $url[0]; ?>en/">English</a>
                      <a class="dropdown-item woocs_flag_view_item" title="Español"lang="es-CO" hreflang="es-CO" href="<?php echo $url[0]; ?>">Español</a>
                    </div>
                  </li>
                </ul> 

              <!--<?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
              <aside class="in-header widget-area right" role="complementary">
                <?php dynamic_sidebar( 'sidebar-1' ); ?>
              </aside>
              <?php } ?>-->
              </div>
            

            </li>
            <div class="pre-navbar pre-navbar--mobile">
              <img class="icon-tarjeta" src="<?php echo get_theme_mod('prenavbar1_image'); ?>">
              <p>
                <?php echo get_theme_mod('prenavbar1_title_'.lang().''); ?>
              </p>
              <img class="icon-line" src="<?php echo get_template_directory_uri();?>/assets/img/line-2.png">
              <p>
                <?php echo get_theme_mod('prenavbar1_line1_'.lang().''); ?>
              </p>
              <img class="icon-line" src="<?php echo get_template_directory_uri();?>/assets/img/line.png">
              <p>
                <?php echo get_theme_mod('prenavbar1_line2_'.lang().''); ?>
              </p>
              <a class="main-general__button" href="<?php echo get_theme_mod('prenavbar1_urlbutton_'.lang().''); ?>">
                <?php echo get_theme_mod('prenavbar1_button_'.lang().''); ?>
                <img class="icon-tarjeta" src="<?php echo get_template_directory_uri();?>/assets/img/next.png">
              </a>
            </div>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <?php else: ?> 


    <header class="header-gray nav-custom" >
    <nav class="navbar navbar-expand-lg">
      <div class="nav-padding">
        <div class="main-brand__top">
          <div class="main-brand">
            <a class="navbar-brand" href="<?php echo get_home_url() ?>">
              <img alt="Logo Clever" id="iso" src="<?php echo get_template_directory_uri();?>/assets/img/logo.png">
            </a>
          </div>
        </div>
        <div class="main-brand__fixed">
          <div class="main-brand">
            <a class="navbar-brand" href="<?php echo get_home_url() ?>">
              <img alt="Logo Clever" id="iso" src="<?php echo get_template_directory_uri();?>/assets/img/logo.png">
            </a>
          </div>
        </div>
        <div class="main-brand brand-responsive">
          <a class="navbar-brand" href="<?php echo get_home_url() ?>">
            <img alt="Logo Clever" id="iso" src="<?php echo get_template_directory_uri();?>/assets/img/logo-black.png">
          </a>
          <button class="navbar-toggler p-2 border-0 hamburger hamburger--elastic ml-autos" data-toggle="offcanvas" type="button">
            <span class="hamburger-box"></span>
            <span class="hamburger-inner"></span>
          </button>
        </div>
        <div class="navbar-collapse offcanvas-collapse">
          <ul class="navbar-nav mr-autos">
                       <li class="nav-item  dropdown">
              <a aria-expanded="false" aria-haspopup="true" class="nav-link"  href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "catalogo";}else{echo "catalogue ";} ?>" role="button"><?php if(lang() == 'es'){echo "Categorías";}if(lang() == 'en'){echo "Category ";} ?></a>
              <div class="dropdown-menu">
                <?php $product_categories = get_categories( array( 'taxonomy' => 'product_cat', 'orderby' => 'menu_order', 'order' => 'asc' ));  ?>
                <?php foreach($product_categories as $category):  global $wpdb;?>
                <?php $result = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."term_taxonomy where taxonomy = 'product_cat'");?>                       
                  <a class="dropdown-item" href="<?php echo get_category_link( $category->term_id ); ?>"><?=$category->name ?></a>
                <?php endforeach; ?> 
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-p" data="offcanvas" href="<?php if(lang() == 'es'){echo ''.get_home_url().'/best-seller';}if(lang() == 'en'){echo ''.get_home_url().'/best-seller-en';} ?>">Best Seller</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-p" data="offcanvas" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "contacto";}else{echo "contact ";} ?>"><?php if(lang() == 'es'){echo "Contacto";}if(lang() == 'en'){echo "Contact ";} ?></a>
            </li>
            <li class="nav-item nav-responsive">
              
              <div class="content-icon">
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "mi-cuenta";}else{echo "my-account";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/user.png">
                </a>
                <?php if(is_user_logged_in() != NULL){ ?> 
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "lista-de-deseos";}else{echo "wishlist";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/heart.png">
                  <span class="nav-item__number">
                  <?php $wishlist_count = YITH_WCWL()->count_products(); echo esc_html( $wishlist_count ); ?>
                  </span>
                </a>
                <?php }else { ?>
                    <div data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if(lang() == 'es'){echo "Debes estar iniciar sesión";}else{echo "You must be logged";} ?>" class="collection-item__icon nav-icon" >
                      <img src="<?php echo get_template_directory_uri();?>/assets/img/heart.png">
                    </div>                
                <?php } ?>
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "carrito";}else{echo "cart";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/card.png">
                  <span class="nav-item__number">
                    <?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?>
                  </span>
                </a>                
                <ul class="navbar-nav mr-autos">
                  <li class="nav-item dropdown drop-money">
                    <a aria-expanded="false" aria-haspopup="true" class="nav-world nav-link dropdown-toggle" data-toggle="dropdown" href="catalogo.html" role="button"><img src="<?php echo get_template_directory_uri();?>/assets/img/world.png"></a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item woocs_flag_view_item" href="?wmc-currency=USD" data-currency="USD" title="USD, $ USA dollar">USD, $</a>
                      <a href="?wmc-currency=COP" class="dropdown-item woocs_flag_view_item" data-currency="COP" title="COP, $ Peso Colombiano">COP, $</a>
                    </div>
                  </li>
                </ul>              
              </div>

                <ul class="navbar-nav mr-autos">
                  <li class="nav-item dropdown drop-money">
                    <a aria-expanded="false" aria-haspopup="true" class="nav-world nav-link dropdown-toggle" data-toggle="dropdown" href="catalogo.html" role="button"><?php if (lang() == 'es'){ echo "Idioma"; }else{ echo "Language"; } $url = explode('en', $_SERVER['REQUEST_URI'], 2); ?></a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item woocs_flag_view_item" title="English" lang="en-US" hreflang="en-US" href="<?php echo $url[0]; ?>en/">English</a>
                      <a class="dropdown-item woocs_flag_view_item" title="Español"lang="es-CO" hreflang="es-CO" href="<?php echo $url[0]; ?>">Español</a>
                    </div>
                  </li>
                </ul>               
              <!--<?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
              <aside class="in-header widget-area right" role="complementary">
                <?php dynamic_sidebar( 'sidebar-1' ); ?>
              </aside>
              <?php } ?>-->

            </li>
            <li class="nav-item nav-flex">
              <div class="content-icon">
              
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "mi-cuenta";}else{echo "my-account";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/user-2.png">
                </a>
                <?php if(is_user_logged_in() != NULL){ ?>
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "lista-de-deseos";}else{echo "wishlist";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/love.png">
                  <span class="nav-item__number">
                    <?php $wishlist_count = YITH_WCWL()->count_products(); echo esc_html( $wishlist_count ); ?>
                  </span >                 
                </a>
                <?php }else { ?>
                    <div data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if(lang() == 'es'){echo "Debes estar iniciar sesión";}else{echo "You must be logged";} ?>" class="collection-item__icon nav-icon" >
                      <img src="<?php echo get_template_directory_uri();?>/assets/img/love.png">
                    </div>                
                <?php } ?>
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "carrito";}else{echo "cart";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/card-2.png">
                  <span class="nav-item__number">
                    <?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?>
                  </span>                  
                </a>                
                <ul class="navbar-nav mr-autos">
                  <li class="nav-item dropdown drop-money">
                    <a aria-expanded="false" aria-haspopup="true" class="nav-world nav-link dropdown-toggle" data-toggle="dropdown" href="catalogo.html" role="button"><img src="<?php echo get_template_directory_uri();?>/assets/img/world.png"></a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item woocs_flag_view_item" href="?wmc-currency=USD" data-currency="USD" title="USD, $ USA dollar">USD, $</a>
                      <a href="?wmc-currency=COP" class="dropdown-item woocs_flag_view_item" data-currency="COP" title="COP, $ Peso Colombiano">COP, $</a>
                    </div>
                  </li>
                </ul>
              </div>
      

            </li>
            <div class="pre-navbar pre-navbar--mobile">
              <img class="icon-tarjeta" src="<?php echo get_theme_mod('prenavbar1_image'); ?>">
              <p>
                <?php echo get_theme_mod('prenavbar1_title_'.lang().''); ?>
              </p>
              <img class="icon-line" src="<?php echo get_template_directory_uri();?>/assets/img/line-2.png">
              <p>
                <?php echo get_theme_mod('prenavbar1_line1_'.lang().''); ?>
              </p>
              <img class="icon-line" src="<?php echo get_template_directory_uri();?>/assets/img/line.png">
              <p>
                <?php echo get_theme_mod('prenavbar1_line2_'.lang().''); ?>
              </p>
              <a class="main-general__button" href="<?php echo get_theme_mod('prenavbar1_urlbutton_'.lang().''); ?>">
                <?php echo get_theme_mod('prenavbar1_button_'.lang().''); ?>
                <img class="icon-tarjeta" src="<?php echo get_template_directory_uri();?>/assets/img/next.png">
              </a>
            </div>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <?php endif; ?>
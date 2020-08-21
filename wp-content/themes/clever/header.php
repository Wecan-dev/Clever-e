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
  <header>
    <nav class="navbar navbar-expand-lg">
      <div class="nav-padding">
        <div class="main-brand__top">
          <div class="main-brand">
            <a class="navbar-brand" href="<?php echo get_home_url() ?>">
              <img alt="Logo Ekored" id="iso" src="<?php echo get_template_directory_uri();?>/assets/img/logo.png">
            </a>
          </div>
        </div>
        <div class="main-brand__fixed">
          <div class="main-brand">
            <a class="navbar-brand" href="<?php echo get_home_url() ?>">
              <img alt="Logo Ekored" id="iso" src="<?php echo get_template_directory_uri();?>/assets/img/logo.png">
            </a>
          </div>
        </div>
        <div class="main-brand brand-responsive">
          <a class="navbar-brand" href="<?php echo get_home_url() ?>">
            <img alt="Logo Ekored" id="iso" src="<?php echo get_template_directory_uri();?>/assets/img/logo-black.png">
          </a>
          <button class="navbar-toggler p-2 border-0 hamburger hamburger--elastic ml-autos" data-toggle="offcanvas" type="button">
            <span class="hamburger-box"></span>
            <span class="hamburger-inner"></span>
          </button>
        </div>
        <div class="navbar-collapse offcanvas-collapse">
          <ul class="navbar-nav mr-autos">
            <li class="nav-item dropdown">
              <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="catalogo.html" role="button"><?php if(lang() == 'es'){echo "Categorías";}if(lang() == 'en'){echo "Category ";} ?></a>
              <div class="dropdown-menu">
                <?php $product_categories = get_categories( array( 'taxonomy' => 'product_cat', 'orderby' => 'menu_order', 'order' => 'asc' ));  ?>
                <?php foreach($product_categories as $category):  global $wpdb;?>
                <?php $result = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."term_taxonomy where taxonomy = 'product_cat'");?>                       
                  <a class="dropdown-item" href="<?php echo get_category_link( $category->term_id ); ?>"><?=$category->name ?></a>
                <?php endforeach; ?> 
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-p" data="offcanvas" href="<?php if(lang() == 'es'){echo ''.get_home_url().'/tienda';}if(lang() == 'en'){echo ''.get_home_url().'/shop';} ?>">Best Seller</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-p" data="offcanvas" href="contacto.html"><?php if(lang() == 'es'){echo "Contacto";}if(lang() == 'en'){echo "Contact ";} ?></a>
            </li>
            <li class="nav-item nav-responsive">
              
              <div class="content-icon">
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "mi-cuenta";}else{echo "my-account";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/user.png">
                </a>
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "lista-de-deseos";}else{echo "wishlist";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/heart.png">
                  <span class="nav-item__number">
                  <?php $wishlist_count = YITH_WCWL()->count_products(); echo esc_html( $wishlist_count ); ?>
                  </span>
                </a>
                <a class="nav-icon" href="<?php echo get_home_url() ?>/cart">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/card.png">
                  <span class="nav-item__number">
                    <?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?>
                  </span>
                </a>                
                <a class="nav-world" href="">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/world.png">
                </a>
              </div>
              <?php echo dynamic_sidebar( 'sidebar-1' ); ?>
              <a class="nav-money" href="">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/money-box.png">
              </a>
            </li>
            <li class="nav-item nav-flex">
              <div class="content-icon">
              
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "mi-cuenta";}else{echo "my-account";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/user-2.png">
                </a>
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "lista-de-deseos";}else{echo "wishlist";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/love.png">
                  <span class="nav-item__number">
                    <?php $wishlist_count = YITH_WCWL()->count_products(); echo esc_html( $wishlist_count ); ?>
  </span>                  
                </a>
                <a class="nav-icon" href="<?php echo get_home_url() ?>/cart">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/card-2.png">
                  <span class="nav-item__number">
                    <?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?>
                  </span>                  
                </a>                
                <a class="nav-world" href="">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/world.png">
                </a>
              </div>
              <?php echo dynamic_sidebar( 'sidebar-1' ); ?>
              <a class="nav-money" href="">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/money-box.png">
              </a>
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


    <header class="header-gray" >
    <nav class="navbar navbar-expand-lg">
      <div class="nav-padding">
        <div class="main-brand__top">
          <div class="main-brand">
            <a class="navbar-brand" href="<?php echo get_home_url() ?>">
              <img alt="Logo Ekored" id="iso" src="<?php echo get_template_directory_uri();?>/assets/img/logo.png">
            </a>
          </div>
        </div>
        <div class="main-brand__fixed">
          <div class="main-brand">
            <a class="navbar-brand" href="<?php echo get_home_url() ?>">
              <img alt="Logo Ekored" id="iso" src="<?php echo get_template_directory_uri();?>/assets/img/logo.png">
            </a>
          </div>
        </div>
        <div class="main-brand brand-responsive">
          <a class="navbar-brand" href="<?php echo get_home_url() ?>">
            <img alt="Logo Ekored" id="iso" src="<?php echo get_template_directory_uri();?>/assets/img/logo-black.png">
          </a>
          <button class="navbar-toggler p-2 border-0 hamburger hamburger--elastic ml-autos" data-toggle="offcanvas" type="button">
            <span class="hamburger-box"></span>
            <span class="hamburger-inner"></span>
          </button>
        </div>
        <div class="navbar-collapse offcanvas-collapse">
          <ul class="navbar-nav mr-autos">
            <li class="nav-item dropdown">
              <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="catalogo.html" role="button"><?php if(lang() == 'es'){echo "Categorías";}if(lang() == 'en'){echo "Category ";} ?></a>
              <div class="dropdown-menu">
                <?php $product_categories = get_categories( array( 'taxonomy' => 'product_cat', 'orderby' => 'menu_order', 'order' => 'asc' ));  ?>
                <?php foreach($product_categories as $category):  global $wpdb;?>
                <?php $result = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."term_taxonomy where taxonomy = 'product_cat'");?>                       
                  <a class="dropdown-item" href="<?php echo get_category_link( $category->term_id ); ?>"><?=$category->name ?></a>
                <?php endforeach; ?> 
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-p" data="offcanvas" href="<?php if(lang() == 'es'){echo ''.get_home_url().'/tienda';}if(lang() == 'en'){echo ''.get_home_url().'/shop';} ?>">Best Seller</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-p" data="offcanvas" href="contacto.html"><?php if(lang() == 'es'){echo "Contacto";}if(lang() == 'en'){echo "Contact ";} ?></a>
            </li>
            <li class="nav-item nav-responsive">
              
              <div class="content-icon">
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "mi-cuenta";}else{echo "my-account";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/user.png">
                </a>
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "lista-de-deseos";}else{echo "wishlist";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/heart.png">
                  <span class="nav-item__number">
                  <?php $wishlist_count = YITH_WCWL()->count_products(); echo esc_html( $wishlist_count ); ?>
                  </span>
                </a>
                <a class="nav-icon" href="<?php echo get_home_url() ?>/cart">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/card.png">
                  <span class="nav-item__number">
                    <?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?>
                  </span>
                </a>                
                <a class="nav-world" href="">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/world.png">
                </a>
              </div>
              <?php echo dynamic_sidebar( 'sidebar-1' ); ?>
              <a class="nav-money" href="">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/money-box.png">
              </a>
            </li>
            <li class="nav-item nav-flex">
              <div class="content-icon">
              
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "mi-cuenta";}else{echo "my-account";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/user-2.png">
                </a>
                <a class="nav-icon" href="<?php echo get_home_url() ?>/<?php if(lang() == 'es'){echo "lista-de-deseos";}else{echo "wishlist";} ?>">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/love.png">
                  <span class="nav-item__number">
                    <?php $wishlist_count = YITH_WCWL()->count_products(); echo esc_html( $wishlist_count ); ?>
  </span >                 
                </a>
                <a class="nav-icon" href="<?php echo get_home_url() ?>/cart">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/card-2.png">
                  <span class="nav-item__number">
                    <?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?>
                  </span>                  
                </a>                
                <a class="nav-world" href="">
                  <img src="<?php echo get_template_directory_uri();?>/assets/img/world.png">
                </a>
              </div>
              <?php echo dynamic_sidebar( 'sidebar-1' ); ?>
              <a class="nav-money" href="">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/money-box.png">
              </a>
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
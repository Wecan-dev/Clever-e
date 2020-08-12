<!DOCTYPE html>
<html lang="<?php bloginfo('language'); ?>">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php wp_title('|', true, 'right'); ?></title>
  <link crossorigin="anonymous" href="<?php echo get_template_directory_uri();?>/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo get_template_directory_uri();?>/assets/css/font-awesome.css" rel="stylesheet">
  <link href="<?php echo get_template_directory_uri();?>/assets/css/font-awesome.css" rel="stylesheet">
  <link href="<?php echo get_template_directory_uri();?>/assets/css/slick-theme.css" rel="stylesheet">
  <link href="<?php echo get_template_directory_uri();?>/assets/css/slick.css" rel="stylesheet">
  <link href="<?php echo get_template_directory_uri();?>/assets/css/main.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
  <link href="<?php echo get_template_directory_uri();?>/assets/img/favicon.png" rel="shortcut icon">
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
  <?php wp_head(); ?>
</head>
<body>
  <div class="pre-navbar__carousel">
    <div class="pre-navbar__item">
      <div class="pre-navbar">
        <img class="icon-tarjeta" src="<?php echo get_template_directory_uri();?>/assets/img/tarjetas.png">
        <p>
          Aprovecha las ofertas &
          <b>
promociones
</b>
        </p>
        <img class="icon-line" src="<?php echo get_template_directory_uri();?>/assets/img/line-2.png">
        <p>
          Tarjetas de regalo
        </p>
        <img class="icon-line" src="<?php echo get_template_directory_uri();?>/assets/img/line.png">
        <p>
          Sorprende a tus seres queridos con un
          <b>
regalo muy especial
</b>
        </p>
        <a class="main-general__button" href="">
comprar ahora
<img class="icon-tarjeta" src="<?php echo get_template_directory_uri();?>/assets/img/next.png">
</a>
      </div>
    </div>
    <div class="pre-navbar__item">
      <div class="pre-navbar">
        <img class="icon-tarjeta" src="<?php echo get_template_directory_uri();?>/assets/img/tarjetas.png">
        <p>
          Aprovecha las ofertas &
          <b>
promociones
</b>
        </p>
        <img class="icon-line" src="<?php echo get_template_directory_uri();?>/assets/img/line-2.png">
        <p>
          Tarjetas de regalo
        </p>
        <img class="icon-line" src="<?php echo get_template_directory_uri();?>/assets/img/line.png">
        <p>
          Sorprende a tus seres queridos con un
          <b>
regalo muy especial
</b>
        </p>
        <a class="main-general__button" href="">
comprar ahora
<img class="icon-tarjeta" src="<?php echo get_template_directory_uri();?>/assets/img/next.png">
</a>
      </div>
    </div>
  </div>
  <header>
    <nav class="navbar navbar-expand-lg">
      <div class="nav-padding">
        <div class="main-brand__top">
          <div class="main-brand">
            <a class="navbar-brand" href="index.html">
<img alt="Logo Ekored" id="iso" src="<?php echo get_template_directory_uri();?>/assets/img/logo.png">
</a>
          </div>
        </div>
        <div class="main-brand__fixed">
          <div class="main-brand">
            <a class="navbar-brand" href="index.html">
<img alt="Logo Ekored" id="iso" src="<?php echo get_template_directory_uri();?>/assets/img/logo.png">
</a>
          </div>
        </div>
        <div class="main-brand brand-responsive">
          <a class="navbar-brand" href="index.html">
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
              <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="catalogo.html" role="button">Categorías</a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="categoria.html">Luxury</a>
                <a class="dropdown-item" href="categoria.html">Pick & Go</a>
                <a class="dropdown-item" href="categoria.html">Swimwear</a>
                <a class="dropdown-item" href="categoria.html">Sportswear</a>
                <a class="dropdown-item" href="categoria.html">Basic</a>
                <a class="dropdown-item" href="categoria.html">Sale</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-p" data="offcanvas" href="basicos-e-infaltables.html">
Best Seller
</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-p" data="offcanvas" href="contacto.html">
contacto
</a>
            </li>
            <li class="nav-item nav-responsive">
              <a class="nav-idioma" href="">
<span>
ESP /
</span>
ENG
</a>
              <div class="content-icon">
                <a class="nav-icon" href="">
<img src="<?php echo get_template_directory_uri();?>/assets/img/user.png">
</a>
                <a class="nav-icon" href="">
<img src="<?php echo get_template_directory_uri();?>/assets/img/heart.png">
</a>
                <a class="nav-icon" href="">
<img src="<?php echo get_template_directory_uri();?>/assets/img/card.png">
</a>
                <a class="nav-world" href="">
<img src="<?php echo get_template_directory_uri();?>/assets/img/world.png">
</a>
              </div>
              <a class="nav-money" href="">
<img src="<?php echo get_template_directory_uri();?>/assets/img/money-box.png">
</a>
            </li>
            <li class="nav-item nav-flex">
              <div class="content-icon">
                <a class="nav-idioma" href="">
<span>
ESP /
</span>
ENG
</a>
                <a class="nav-icon" href="">
<img src="<?php echo get_template_directory_uri();?>/assets/img/user-2.png">
</a>
                <a class="nav-icon" href="">
<img src="<?php echo get_template_directory_uri();?>/assets/img/love.png">
</a>
                <a class="nav-icon" href="">
<img src="<?php echo get_template_directory_uri();?>/assets/img/card-2.png">
</a>
                <a class="nav-world" href="">
<img src="<?php echo get_template_directory_uri();?>/assets/img/world.png">
</a>
              </div>
              <a class="nav-money" href="">
<img src="<?php echo get_template_directory_uri();?>/assets/img/money-box.png">
</a>
            </li>
            <div class="pre-navbar pre-navbar--mobile">
              <img class="icon-tarjeta" src="<?php echo get_template_directory_uri();?>/assets/img/tarjetas.png">
              <p>
                Aprovecha las ofertas &
                <b>
promociones
</b>
              </p>
              <img class="icon-line" src="<?php echo get_template_directory_uri();?>/assets/img/line-2.png">
              <p>
                Tarjetas de regalo
              </p>
              <img class="icon-line" src="<?php echo get_template_directory_uri();?>/assets/img/line.png">
              <p>
                Sorprende a tus seres queridos con un
                <b>
regalo muy especial
</b>
              </p>
              <a class="main-general__button" href="">
comprar ahora
<img class="icon-tarjeta" src="<?php echo get_template_directory_uri();?>/assets/img/next.png">
</a>
            </div>
          </ul>
        </div>
      </div>
    </nav>
  </header>
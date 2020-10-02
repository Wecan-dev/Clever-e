<?php
  /////seller
  
  $wp_customize->add_section('seller', array (
    'title' => 'Main seller',
    'panel' => 'panel2'
  ));
  
  for ($i=1; $i <=5 ; $i++) { 
    $wp_customize->add_setting('seller'.$i.'_image');

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'seller'.$i.'_image_control', array (
      'description' => 'Imagen '.$i.'',
      'section' => 'seller',
      'settings' => 'seller'.$i.'_image'
      )));
  }

  // es
  $wp_customize->add_setting('seller_title_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'seller_title_es_control', array (
    'description' => 'Texto ESP <img src="' . get_stylesheet_directory_uri() . '/assets/img/esp.png"><br><br>Título',
    'section' => 'seller',
    'settings' => 'seller_title_es',
  )));

  $wp_customize->add_setting('seller_buttom_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'seller_buttom_es_control', array (
    'description' => 'Botón',
    'section' => 'seller',
    'settings' => 'seller_buttom_es',
  )));

  $wp_customize->add_setting('seller_urlbuttom_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'seller_urlbuttom_es_control', array (
    'description' => 'Url Botón',
    'section' => 'seller',
    'settings' => 'seller_urlbuttom_es',
  )));  

  // en
   $wp_customize->add_setting('seller_title_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'seller_title_en_control', array (
    'description' => 'Texto ENG <img src="' . get_stylesheet_directory_uri() . '/assets/img/eng.png"><br><br>Title',
    'section' => 'seller',
    'settings' => 'seller_title_en',
  )));

  $wp_customize->add_setting('seller_buttom_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'seller_buttom_en_control', array (
    'description' => 'Buttom',
    'section' => 'seller',
    'settings' => 'seller_buttom_en',
  )));

  $wp_customize->add_setting('seller_urlbuttom_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'seller_urlbuttom_en_control', array (
    'description' => 'Url Buttom',
    'section' => 'seller',
    'settings' => 'seller_urlbuttom_en',
  )));

?>
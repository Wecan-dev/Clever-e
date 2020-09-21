<?php
  /////products
  
  $wp_customize->add_section('products', array (
    'title' => 'Main Productos',
    'panel' => 'panel2'
  ));
  
 
  // es
  $wp_customize->add_setting('products_title_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'products_title_es_control', array (
    'description' => 'Texto ESP <img src="' . get_stylesheet_directory_uri() . '/assets/img/esp.png"><br><br>Título',
    'section' => 'products',
    'settings' => 'products_title_es',
  )));

  $wp_customize->add_setting('products_subtitle_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'products_subtitle_es_control', array (
    'description' => 'Subtitle',
    'section' => 'products',
    'settings' => 'products_subtitle_es',
  )));

  // en
   $wp_customize->add_setting('products_title_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'products_title_en_control', array (
    'description' => 'Texto ENG <img src="' . get_stylesheet_directory_uri() . '/assets/img/eng.png"><br><br>Title',
    'section' => 'products',
    'settings' => 'products_title_en',
  )));

  $wp_customize->add_setting('products_subtitle_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'products_subtitle_en_control', array (
    'description' => 'Subtitle',
    'section' => 'products',
    'settings' => 'products_subtitle_en',
  )));



  
?>
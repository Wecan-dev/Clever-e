<?php
  /////categories
  
  $wp_customize->add_section('categories', array (
    'title' => 'Main Categorías',
    'panel' => 'panel2'
  ));
  
 
  // es
  $wp_customize->add_setting('categories_title_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'categories_title_es_control', array (
    'description' => 'Texto ESP <img src="' . get_stylesheet_directory_uri() . '/assets/img/esp.png"><br><br>Título',
    'section' => 'categories',
    'settings' => 'categories_title_es',
  )));

  $wp_customize->add_setting('categories_subtitle_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'categories_subtitle_es_control', array (
    'description' => 'Subtitle',
    'section' => 'categories',
    'settings' => 'categories_subtitle_es',
  )));

  // en
   $wp_customize->add_setting('categories_title_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'categories_title_en_control', array (
    'description' => 'Texto ENG <img src="' . get_stylesheet_directory_uri() . '/assets/img/eng.png"><br><br>Title',
    'section' => 'categories',
    'settings' => 'categories_title_en',
  )));

  $wp_customize->add_setting('categories_subtitle_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'categories_subtitle_en_control', array (
    'description' => 'Subtitle',
    'section' => 'categories',
    'settings' => 'categories_subtitle_en',
  )));



  
?>
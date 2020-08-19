<?php
  /////newsletter
  
  $wp_customize->add_section('newsletter', array (
    'title' => 'Main Newsletter',
    'panel' => 'panel2'
  ));
  
 
  // es
  $wp_customize->add_setting('newsletter_title_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'newsletter_title_es_control', array (
    'description' => 'Texto ESP <img src="' . get_stylesheet_directory_uri() . '/assets/img/esp.png"><br><br>Título',
    'section' => 'newsletter',
    'settings' => 'newsletter_title_es',
  )));

  $wp_customize->add_setting('newsletter_subtitle_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'newsletter_subtitle_es_control', array (
    'description' => 'Subtitle',
    'section' => 'newsletter',
    'settings' => 'newsletter_subtitle_es',
    'type' => 'textarea'
  )));

  // en
   $wp_customize->add_setting('newsletter_title_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'newsletter_title_en_control', array (
    'description' => 'Texto ENG <img src="' . get_stylesheet_directory_uri() . '/assets/img/eng.png"><br><br>Title',
    'section' => 'newsletter',
    'settings' => 'newsletter_title_en',
  )));

  $wp_customize->add_setting('newsletter_subtitle_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'newsletter_subtitle_en_control', array (
    'description' => 'Subtitle',
    'section' => 'newsletter',
    'settings' => 'newsletter_subtitle_en',
    'type' => 'textarea'
  )));



  
?>
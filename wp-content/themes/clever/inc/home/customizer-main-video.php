<?php
  /////video
  
  $wp_customize->add_section('video', array (
    'title' => 'Main Vídeo',
    'panel' => 'panel2'
  ));
  
  // es
  $wp_customize->add_setting('video_title_light_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'video_title_light_es_control', array (
    'description' => 'Texto ESP <img src="' . get_stylesheet_directory_uri() . '/assets/img/esp.png"><br><br>Título Light',
    'section' => 'video',
    'settings' => 'video_title_light_es',
  )));

  $wp_customize->add_setting('video_title_bold_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'video_title_bold_es_control', array (
    'description' => 'Título Bold',
    'section' => 'video',
    'settings' => 'video_title_bold_es',
  )));


  // en
  $wp_customize->add_setting('video_title_light_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'video_title_light_en_control', array (
    'description' => 'Texto ENG <img src="' . get_stylesheet_directory_uri() . '/assets/img/eng.png"><br><br>Title Light',
    'section' => 'video',
    'settings' => 'video_title_light_en',
  )));

  $wp_customize->add_setting('video_title_bold_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'video_title_bold_en_control', array (
    'description' => 'Title Bold',
    'section' => 'video',
    'settings' => 'video_title_bold_en',
  )));

?>
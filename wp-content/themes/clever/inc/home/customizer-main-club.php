<?php
  /////club
  
  $wp_customize->add_section('club', array (
    'title' => 'Main Club',
    'panel' => 'panel2'
  ));
  

  // es
  $wp_customize->add_setting('club_title_light_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'club_title_light_es_control', array (
    'description' => 'Texto ESP <img src="' . get_stylesheet_directory_uri() . '/assets/img/esp.png"><br><br>Título Light',
    'section' => 'club',
    'settings' => 'club_title_light_es',
  )));

  $wp_customize->add_setting('club_title_italic_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'club_title_italic_es_control', array (
    'description' => 'Título Italic',
    'section' => 'club',
    'settings' => 'club_title_italic_es',
  )));

  $wp_customize->add_setting('club_title_bold_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'club_title_bold_es_control', array (
    'description' => 'Título Bold',
    'section' => 'club',
    'settings' => 'club_title_bold_es',
  )));

  $wp_customize->add_setting('club_description_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'club_description_es_control', array (
    'description' => 'Descripción',
    'section' => 'club',
    'settings' => 'club_description_es',
    'type' => 'textarea'
  )));

  // en
   $wp_customize->add_setting('club_title_light_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'club_title_light_en_control', array (
    'description' => 'Texto ENG <img src="' . get_stylesheet_directory_uri() . '/assets/img/eng.png"><br><br>Title Light',
    'section' => 'club',
    'settings' => 'club_title_light_en',
  )));

  $wp_customize->add_setting('club_title_italic_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'club_title_italic_en_control', array (
    'description' => 'Title Italic',
    'section' => 'club',
    'settings' => 'club_title_italic_en',
  )));

  $wp_customize->add_setting('club_title_bold_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'club_title_bold_en_control', array (
    'description' => 'Title Bold',
    'section' => 'club',
    'settings' => 'club_title_bold_en',
  )));

  $wp_customize->add_setting('club_description_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'club_description_en_control', array (
    'description' => 'Description',
    'section' => 'club',
    'settings' => 'club_description_en',
    'type' => 'textarea'
  )));



  
?>
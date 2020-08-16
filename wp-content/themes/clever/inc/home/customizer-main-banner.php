<?php
  /////Banner
  
  $wp_customize->add_section('banner', array (
    'title' => 'Main Banner',
    'panel' => 'panel2'
  ));
  
  /*****************banner1 ******************/
  $wp_customize->add_setting('banner1_image');
  
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'banner1_image_control', array (
    'label' => 'Banner 1',
    'description' => 'Imagen',
    'section' => 'banner',
    'settings' => 'banner1_image'
  )));

  // es
  $wp_customize->add_setting('banner1_title_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner1_title_es_control', array (
    'description' => 'Texto ESP <img src="' . get_stylesheet_directory_uri() . '/assets/img/esp.png"><br><br>Título',
    'section' => 'banner',
    'settings' => 'banner1_title_es',
  )));

  $wp_customize->add_setting('banner1_subtitle_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner1_subtitle_es_control', array (
    'description' => 'Subtítulo',
    'section' => 'banner',
    'settings' => 'banner1_subtitle_es',
  )));

  $wp_customize->add_setting('banner1_description_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner1_description_es_control', array (
    'description' => 'Descripción',
    'section' => 'banner',
    'settings' => 'banner1_description_es',
  )));  

  $wp_customize->add_setting('banner1_button_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner1_button_es_control', array (
    'description' => 'Botón',
    'section' => 'banner',
    'settings' => 'banner1_button_es',
  ))); 

  $wp_customize->add_setting('banner1_urlbutton_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner1_urlbutton_es_control', array (
    'description' => 'Url Botón',
    'section' => 'banner',
    'settings' => 'banner1_urlbutton_es',
  )));

  // en
   $wp_customize->add_setting('banner1_title_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner1_title_en_control', array (
    'description' => 'Texto ENG <img src="' . get_stylesheet_directory_uri() . '/assets/img/eng.png"><br><br>Title',
    'section' => 'banner',
    'settings' => 'banner1_title_en',
  )));

  $wp_customize->add_setting('banner1_subtitle_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner1_subtitle_en_control', array (
    'description' => 'Subtitle',
    'section' => 'banner',
    'settings' => 'banner1_subtitle_en',
  )));

  $wp_customize->add_setting('banner1_description_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner1_description_en_control', array (
    'description' => 'Description',
    'section' => 'banner',
    'settings' => 'banner1_description_en',
  )));  

  $wp_customize->add_setting('banner1_button_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner1_button_en_control', array (
    'description' => 'Button',
    'section' => 'banner',
    'settings' => 'banner1_button_en',
  ))); 

  $wp_customize->add_setting('banner1_urlbutton_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner1_urlbutton_en_control', array (
    'description' => 'Url Button',
    'section' => 'banner',
    'settings' => 'banner1_urlbutton_en',
  )));  


  /*****************banner2 ******************/
  $wp_customize->add_setting('banner2_image');
  
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'banner2_image_control', array (
    'label' => 'Banner 2',
    'description' => 'Imagen',
    'section' => 'banner',
    'settings' => 'banner2_image'
  )));

  // es
  $wp_customize->add_setting('banner2_title_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner2_title_es_control', array (
    'description' => 'Texto ESP <img src="' . get_stylesheet_directory_uri() . '/assets/img/esp.png"><br><br>Título',
    'section' => 'banner',
    'settings' => 'banner2_title_es',
  )));

  $wp_customize->add_setting('banner2_subtitle_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner2_subtitle_es_control', array (
    'description' => 'Subtítulo',
    'section' => 'banner',
    'settings' => 'banner2_subtitle_es',
  )));

  $wp_customize->add_setting('banner2_description_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner2_description_es_control', array (
    'description' => 'Descripción',
    'section' => 'banner',
    'settings' => 'banner2_description_es',
  )));  

  $wp_customize->add_setting('banner2_button_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner2_button_es_control', array (
    'description' => 'Botón',
    'section' => 'banner',
    'settings' => 'banner2_button_es',
  ))); 

  $wp_customize->add_setting('banner2_urlbutton_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner2_urlbutton_es_control', array (
    'description' => 'Url Botón',
    'section' => 'banner',
    'settings' => 'banner2_urlbutton_es',
  )));

  // en
   $wp_customize->add_setting('banner2_title_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner2_title_en_control', array (
    'description' => 'Texto ENG <img src="' . get_stylesheet_directory_uri() . '/assets/img/eng.png"><br><br>Title',
    'section' => 'banner',
    'settings' => 'banner2_title_en',
  )));

  $wp_customize->add_setting('banner2_subtitle_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner2_subtitle_en_control', array (
    'description' => 'Subtitle',
    'section' => 'banner',
    'settings' => 'banner2_subtitle_en',
  )));

  $wp_customize->add_setting('banner2_description_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner2_description_en_control', array (
    'description' => 'Description',
    'section' => 'banner',
    'settings' => 'banner2_description_en',
  )));  

  $wp_customize->add_setting('banner2_button_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner2_button_en_control', array (
    'description' => 'Button',
    'section' => 'banner',
    'settings' => 'banner2_button_en',
  ))); 

  $wp_customize->add_setting('banner2_urlbutton_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner2_urlbutton_en_control', array (
    'description' => 'Url Button',
    'section' => 'banner',
    'settings' => 'banner2_urlbutton_en',
  )));  

  
?>
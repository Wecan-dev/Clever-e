<?php
  /////Pre- navbar
  
  $wp_customize->add_section('prenavbar', array (
    'title' => 'Pre-Navbar',
    'panel' => 'panel1'
  ));
  
  /*****************prenavbar1 ******************/
  $wp_customize->add_setting('prenavbar1_image');
  
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'prenavbar1_image_control', array (
    'label' => 'Item 1',
    'description' => 'Ícono',
    'section' => 'prenavbar',
    'settings' => 'prenavbar1_image'
  )));

  // es
  $wp_customize->add_setting('prenavbar1_title_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar1_title_es_control', array (
    'description' => 'Texto ESP <img src="' . get_stylesheet_directory_uri() . '/assets/img/esp.png"><br><br>Título',
    'section' => 'prenavbar',
    'settings' => 'prenavbar1_title_es',
  )));

  $wp_customize->add_setting('prenavbar1_line1_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar1_line1_es_control', array (
    'description' => 'Línea 1',
    'section' => 'prenavbar',
    'settings' => 'prenavbar1_line1_es',
  )));

  $wp_customize->add_setting('prenavbar1_line2_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar1_line2_es_control', array (
    'description' => 'Línea 2',
    'section' => 'prenavbar',
    'settings' => 'prenavbar1_line2_es',
  )));

  $wp_customize->add_setting('prenavbar1_button_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar1_button_es_control', array (
    'description' => 'Botón',
    'section' => 'prenavbar',
    'settings' => 'prenavbar1_button_es',
  ))); 

  $wp_customize->add_setting('prenavbar1_urlbutton_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar1_urlbutton_es_control', array (
    'description' => 'Url Botón',
    'section' => 'prenavbar',
    'settings' => 'prenavbar1_urlbutton_es',
  )));

  // en
  $wp_customize->add_setting('prenavbar1_title_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar1_title_en_control', array (
    'description' => 'Texto ENG <img src="' . get_stylesheet_directory_uri() . '/assets/img/eng.png"><br><br>Title',
    'section' => 'prenavbar',
    'settings' => 'prenavbar1_title_en',
  )));

  $wp_customize->add_setting('prenavbar1_line1_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar1_line1_en_control', array (
    'description' => 'Line 1',
    'section' => 'prenavbar',
    'settings' => 'prenavbar1_line1_en',
  )));

  $wp_customize->add_setting('prenavbar1_line2_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar1_line2_en_control', array (
    'description' => 'Line 2',
    'section' => 'prenavbar',
    'settings' => 'prenavbar1_line2_en',
  )));

  $wp_customize->add_setting('prenavbar1_button_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar1_button_en_control', array (
    'description' => 'Buttom',
    'section' => 'prenavbar',
    'settings' => 'prenavbar1_button_en',
  ))); 

  $wp_customize->add_setting('prenavbar1_urlbutton_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar1_urlbutton_en_control', array (
    'description' => 'Url Buttom',
    'section' => 'prenavbar',
    'settings' => 'prenavbar1_urlbutton_en',
  )));

  /*****************prenavbar2 ******************/
  $wp_customize->add_setting('prenavbar2_image');
  
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'prenavbar2_image_control', array (
    'label' => 'Item 2',
    'description' => 'Ícono',
    'section' => 'prenavbar',
    'settings' => 'prenavbar2_image'
  )));

  // es
  $wp_customize->add_setting('prenavbar2_title_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar2_title_es_control', array (
    'description' => 'Texto ESP <img src="' . get_stylesheet_directory_uri() . '/assets/img/esp.png"><br><br>Título',
    'section' => 'prenavbar',
    'settings' => 'prenavbar2_title_es',
  )));

  $wp_customize->add_setting('prenavbar2_line1_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar2_line1_es_control', array (
    'description' => 'Línea 1',
    'section' => 'prenavbar',
    'settings' => 'prenavbar2_line1_es',
  )));

  $wp_customize->add_setting('prenavbar2_line2_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar2_line2_es_control', array (
    'description' => 'Línea 2',
    'section' => 'prenavbar',
    'settings' => 'prenavbar2_line2_es',
  )));

  $wp_customize->add_setting('prenavbar2_button_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar2_button_es_control', array (
    'description' => 'Botón',
    'section' => 'prenavbar',
    'settings' => 'prenavbar2_button_es',
  ))); 

  $wp_customize->add_setting('prenavbar2_urlbutton_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar2_urlbutton_es_control', array (
    'description' => 'Url Botón',
    'section' => 'prenavbar',
    'settings' => 'prenavbar2_urlbutton_es',
  )));

  // en
  $wp_customize->add_setting('prenavbar2_title_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar2_title_en_control', array (
    'description' => 'Texto ENG <img src="' . get_stylesheet_directory_uri() . '/assets/img/eng.png"><br><br>Título',
    'section' => 'prenavbar',
    'settings' => 'prenavbar2_title_en',
  )));

  $wp_customize->add_setting('prenavbar2_line1_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar2_line1_en_control', array (
    'description' => 'Line 1',
    'section' => 'prenavbar',
    'settings' => 'prenavbar2_line1_en',
  )));

  $wp_customize->add_setting('prenavbar2_line2_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar2_line2_en_control', array (
    'description' => 'Line 2',
    'section' => 'prenavbar',
    'settings' => 'prenavbar2_line2_en',
  )));

  $wp_customize->add_setting('prenavbar2_button_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar2_button_en_control', array (
    'description' => 'Buttom',
    'section' => 'prenavbar',
    'settings' => 'prenavbar2_button_en',
  ))); 

  $wp_customize->add_setting('prenavbar2_urlbutton_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'prenavbar2_urlbutton_en_control', array (
    'description' => 'Url Buttom',
    'section' => 'prenavbar',
    'settings' => 'prenavbar2_urlbutton_en',
  )));
  
?>
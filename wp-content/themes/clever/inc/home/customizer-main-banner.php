<?php
  /////Banner
  
  $wp_customize->add_section('banner', array (
    'title' => 'Main Banner',
    'panel' => 'panel2'
  ));
  

  $wp_customize->add_setting('banner_link', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner_link_control', array (
    'label' => 'Agregar textos e imágenes del banner',
    'description' => '<hr>Añadir Banner <a target=”_blank href="edit.php?post_type=itemsbanner">here </a><hr>',
    'section' => 'banner',
    'settings' => 'banner_link',
    'type' => 'hidden'
  )));
  
?>
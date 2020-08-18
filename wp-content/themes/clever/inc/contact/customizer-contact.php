 <?php
   //////////////CONTACT  
  $wp_customize->add_section('contact', array (
    'title' => 'Info Contacto',
    'panel' => 'panel3'
  ));
  
 //ESP 
  $wp_customize->add_setting('description_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'description_es_control', array (
    'description' => 'Texto ESP <img src="' . get_stylesheet_directory_uri() . '/assets/img/esp.png"><br><br>Descripción',
    'section' => 'contact',
    'settings' => 'description_es',
    'type' => 'textarea'
  )));

  $wp_customize->add_setting('address_es', array(
    'default' => ''
  ));

  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'address_es_control', array (
    'description' => 'Dirección',
    'section' => 'contact',
    'settings' => 'address_es',
    'type' => 'textarea'
  )));    

  $wp_customize->add_setting('phone_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'phone_es_control', array (
    'label' => 'Teléfonos',
    'section' => 'contact',
    'settings' => 'phone_es'
  ))); 

  $wp_customize->add_setting('email_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'email_es_control', array (
    'label' => 'Email',
    'section' => 'contact',
    'settings' => 'email_es'
  )));

  $wp_customize->add_setting('web_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'web_es_control', array (
    'label' => 'Url Web',
    'section' => 'contact',
    'settings' => 'web_es'
  )));    

  //ENG
  $wp_customize->add_setting('description_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'description_en_control', array (
    'description' => 'Texto ENG <img src="' . get_stylesheet_directory_uri() . '/assets/img/eng.png"><br><br>Description',
    'section' => 'contact',
    'settings' => 'description_en',
    'type' => 'textarea'
  )));

  $wp_customize->add_setting('address_en', array(
    'default' => ''
  ));

  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'address_en_control', array (
    'description' => 'Address',
    'section' => 'contact',
    'settings' => 'address_en',
    'type' => 'textarea'
  )));    

  $wp_customize->add_setting('phone_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'phone_en_control', array (
    'label' => 'Phone',
    'section' => 'contact',
    'settings' => 'phone_en'
  )));       

  $wp_customize->add_setting('email_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'email_en_control', array (
    'label' => 'Email',
    'section' => 'contact',
    'settings' => 'email_en'
  )));

  $wp_customize->add_setting('web_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'web_en_control', array (
    'label' => 'Url Web',
    'section' => 'contact',
    'settings' => 'web_en'
  )));    





 



?>
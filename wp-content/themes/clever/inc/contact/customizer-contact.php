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

  $wp_customize->add_setting('address1_es', array(
    'default' => ''
  ));

  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'address1_es_control', array (
    'description' => 'Dirección 1',
    'section' => 'contact',
    'settings' => 'address1_es',
    'type' => 'textarea'
  ))); 

  $wp_customize->add_setting('address1_map_es', array(
    'default' => ''
  ));

  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'address1_map_es_control', array (
    'description' => 'Map Dirección 1',
    'section' => 'contact',
    'settings' => 'address1_map_es',
    'type' => 'textarea'
  ))); 

  $wp_customize->add_setting('address2_es', array(
    'default' => ''
  ));

  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'address2_es_control', array (
    'description' => 'Dirección 2',
    'section' => 'contact',
    'settings' => 'address2_es',
    'type' => 'textarea'
  )));

  $wp_customize->add_setting('address2_map_es', array(
    'default' => ''
  ));

  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'address2_map_es_control', array (
    'description' => 'Map Dirección 2',
    'section' => 'contact',
    'settings' => 'address2_map_es',
    'type' => 'textarea'
  )));

  $wp_customize->add_setting('phone1_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'phone1_es_control', array (
    'label' => 'Teléfonos 1',
    'section' => 'contact',
    'settings' => 'phone1_es'
  )));

  $wp_customize->add_setting('phone2_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'phone2_es_control', array (
    'label' => 'Teléfonos 2',
    'section' => 'contact',
    'settings' => 'phone2_es'
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

  $wp_customize->add_setting('address1_en', array(
    'default' => ''
  ));

  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'address1_en_control', array (
    'description' => 'Address 1',
    'section' => 'contact',
    'settings' => 'address1_en',
    'type' => 'textarea'
  ))); 

  $wp_customize->add_setting('address1_map_en', array(
    'default' => ''
  ));

  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'address1_map_en_control', array (
    'description' => 'Map Address 1',
    'section' => 'contact',
    'settings' => 'address1_map_en',
    'type' => 'textarea'
  )));   

  $wp_customize->add_setting('address2_en', array(
    'default' => ''
  ));

  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'address2_en_control', array (
    'description' => 'Address 2',
    'section' => 'contact',
    'settings' => 'address2_en',
    'type' => 'textarea'
  )));    

  $wp_customize->add_setting('address2_map_en', array(
    'default' => ''
  ));

  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'address2_map_en_control', array (
    'description' => 'Map Address 2',
    'section' => 'contact',
    'settings' => 'address2_map_en',
    'type' => 'textarea'
  ))); 

  $wp_customize->add_setting('phone1_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'phone1_en_control', array (
    'label' => 'Phone 1',
    'section' => 'contact',
    'settings' => 'phone1_en'
  )));       

  $wp_customize->add_setting('phone2_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'phone2_en_control', array (
    'label' => 'Phone 2',
    'section' => 'contact',
    'settings' => 'phone2_en'
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
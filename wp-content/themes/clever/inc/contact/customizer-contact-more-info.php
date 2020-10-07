 <?php
   //////////////CONTACT MORE INFO
  $wp_customize->add_section('contact_more_info', array (
    'title' => 'Más información',
    'panel' => 'panel3'
  ));
  
 //ESP 
  $wp_customize->add_setting('shipping_online_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'shipping_online_es_control', array (
    'description' => 'Archivo ESP <img src="' . get_stylesheet_directory_uri() . '/assets/img/esp.png"><br><br>Envíos Online',
    'section' => 'contact_more_info',
    'settings' => 'shipping_online_es',
  )));

  $wp_customize->add_setting('terms_conditions_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'terms_conditions_es_control', array (
    'description' => 'Términos y Condiciones',
    'section' => 'contact_more_info',
    'settings' => 'terms_conditions_es',
  )));
 
  $wp_customize->add_setting('personal_data_processing_policy_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'personal_data_processing_policy_es_control', array (
    'description' => 'Política de Tratamiento de Datos Personales',
    'section' => 'contact_more_info',
    'settings' => 'personal_data_processing_policy_es',
  )));

  $wp_customize->add_setting('guarantee_policy_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'guarantee_policy_es_control', array (
    'description' => 'Política de Garantía',
    'section' => 'contact_more_info',
    'settings' => 'guarantee_policy_es',
  )));  

  $wp_customize->add_setting('our_history_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'our_history_es_control', array (
    'description' => 'Nuestra Historia',
    'section' => 'contact_more_info',
    'settings' => 'our_history_es',
  )));



  //ENG
  $wp_customize->add_setting('shipping_online_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'shipping_online_en_control', array (
    'description' => 'Archivo ENG <img src="' . get_stylesheet_directory_uri() . '/assets/img/eng.png"><br><br>Shipping Online',
    'section' => 'contact_more_info',
    'settings' => 'shipping_online_en',
  )));

  $wp_customize->add_setting('terms_conditions_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'terms_conditions_en_control', array (
    'description' => 'Terms and Conditions',
    'section' => 'contact_more_info',
    'settings' => 'terms_conditions_en',
  )));

  $wp_customize->add_setting('personal_data_processing_policy_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'personal_data_processing_policy_en_control', array (
    'description' => 'Personal Data Processing Policy',
    'section' => 'contact_more_info',
    'settings' => 'personal_data_processing_policy_en',
  )));

  $wp_customize->add_setting('guarantee_policy_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'guarantee_policy_en_control', array (
    'description' => 'Guarantee Policy',
    'section' => 'contact_more_info',
    'settings' => 'guarantee_policy_en',
  )));   

  $wp_customize->add_setting('our_history_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'our_history_en_control', array (
    'description' => 'Our History',
    'section' => 'contact_more_info',
    'settings' => 'our_history_en',
  )));  

?>
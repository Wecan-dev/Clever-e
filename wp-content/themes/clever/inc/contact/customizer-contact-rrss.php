 <?php
   //////////////CONTACT_rrss RRSS
  $wp_customize->add_section('contact_rrss', array (
    'title' => 'RRSS Contacto',
    'panel' => 'panel3'
  ));
  

 //ESP 
  $wp_customize->add_setting('facebook_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'facebook_es_control', array (
    'label' => 'Url RRSS',
    'description' => 'Url ESP <img src="' . get_stylesheet_directory_uri() . '/assets/img/esp.png"><br><br>Facebook',
    'section' => 'contact_rrss',
    'settings' => 'facebook_es',
  )));

  $wp_customize->add_setting('instagram_es', array(
    'default' => ''
  ));

  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'instagram_es_control', array (
    'description' => 'Instagram',
    'section' => 'contact_rrss',
    'settings' => 'instagram_es',
  )));    

  $wp_customize->add_setting('twitter_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'twitter_es_control', array (
    'label' => 'Twitter',
    'section' => 'contact_rrss',
    'settings' => 'twitter_es'
  )));    

  $wp_customize->add_setting('youtube_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'youtube_es_control', array (
    'label' => 'Youtube',
    'section' => 'contact_rrss',
    'settings' => 'youtube_es'
  )));

  $wp_customize->add_setting('linkedin_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'linkedin_es_control', array (
    'label' => 'Linkedin',
    'section' => 'contact_rrss',
    'settings' => 'linkedin_es'
  )));  

  $wp_customize->add_setting('whatsapp_es', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'whatsapp_es_control', array (
    'label' => 'Whatsapp',
    'section' => 'contact_rrss',
    'settings' => 'whatsapp_es'
  ))); 

  //ENG 
  $wp_customize->add_setting('facebook_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'facebook_en_control', array (
    'description' => 'Url ENG <img src="' . get_stylesheet_directory_uri() . '/assets/img/eng.png"><br><br>Facebook',
    'section' => 'contact_rrss',
    'settings' => 'facebook_en',
  )));

  $wp_customize->add_setting('instagram_en', array(
    'default' => ''
  ));

  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'instagram_en_control', array (
    'description' => 'Instagram',
    'section' => 'contact_rrss',
    'settings' => 'instagram_en',
  )));    

  $wp_customize->add_setting('twitter_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'twitter_en_control', array (
    'description' => 'Twitter',
    'section' => 'contact_rrss',
    'settings' => 'twitter_en'
  )));    

  $wp_customize->add_setting('youtube_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'youtube_en_control', array (
    'description' => 'Youtube',
    'section' => 'contact_rrss',
    'settings' => 'youtube_en'
  )));

  $wp_customize->add_setting('linkedin_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'linkedin_en_control', array (
    'description' => 'Linkedin',
    'section' => 'contact_rrss',
    'settings' => 'linkedin_en'
  ))); 

  $wp_customize->add_setting('whatsapp_en', array(
    'default' => ''
  ));
  
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'whatsapp_en_control', array (
    'description' => 'Whatsapp',
    'section' => 'contact_rrss',
    'settings' => 'whatsapp_en'
  )));  

?>
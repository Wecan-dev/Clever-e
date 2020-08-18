<?php 

/****************** Styles *****************/
function clever_styles(){
  wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css' );
  wp_enqueue_style('font-awesome', get_stylesheet_directory_uri() . '/assets/css/font-awesome.css' );
  wp_enqueue_style('slick-theme', get_stylesheet_directory_uri() . '/assets/css/slick-theme.css' );
  wp_enqueue_style('slick', get_stylesheet_directory_uri() . '/assets/css/slick.css' );
  wp_enqueue_style('main', get_stylesheet_directory_uri() . '/assets/css/main.css' );
  wp_enqueue_style('animate', "https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" );
  wp_enqueue_style('favicon', get_stylesheet_directory_uri() . '/assets/img/favicon.png' ); 
  wp_enqueue_style('googleapis', "https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&amp;display=swap" );


  wp_enqueue_script( 'jquerymin',get_bloginfo('stylesheet_directory') . '/assets/js/jquery.min.js', array( 'jquery' ) ); 
  wp_enqueue_script( 'popper','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js');
  wp_enqueue_script( 'bootstrap-min',get_bloginfo('stylesheet_directory') . '/assets/js/bootstrap.min.js', array( 'jquery' ) );   
  wp_enqueue_script( 'slick-min',get_bloginfo('stylesheet_directory') . '/assets/js/slick.min.js', array( 'jquery' ) );  
  wp_enqueue_script( 'setting-slick',get_bloginfo('stylesheet_directory') . '/assets/js/setting-slick.js', array( 'jquery' ) );
  wp_enqueue_script( 'wow','https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js');
  wp_enqueue_script( 'blazy','https://cdnjs.cloudflare.com/ajax/libs/blazy/1.8.2/blazy.min.js'); 
  wp_enqueue_script( 'main-js',get_bloginfo('stylesheet_directory') . '/assets/js/main.js', array( 'jquery' ) ); 
  wp_enqueue_script( 'ctext',get_bloginfo('stylesheet_directory') . '/assets/js/ctext.js', array( 'jquery' ) ); 

}

add_action('wp_enqueue_scripts', 'clever_styles');

/***************Functions theme ********************/

function theme_customize_register($wp_customize){

  $wp_customize->add_panel('panel1',
        array(
            'title' => 'Header Pre-navbar',
            'priority' => 1,
            )
        );
  require_once trailingslashit( get_template_directory() ) . 'inc/header/customizer-pre-navbar.php';

  $wp_customize->add_panel('panel2',
        array(
            'title' => 'Secciones Home',
            'priority' => 2,
            )
        );
  require_once trailingslashit( get_template_directory() ) . 'inc/home/customizer-main-banner.php';
  require_once trailingslashit( get_template_directory() ) . 'inc/home/customizer-main-categories.php';
  require_once trailingslashit( get_template_directory() ) . 'inc/home/customizer-main-products.php';
  require_once trailingslashit( get_template_directory() ) . 'inc/home/customizer-main-club.php';
  require_once trailingslashit( get_template_directory() ) . 'inc/home/customizer-main-video.php';  
  require_once trailingslashit( get_template_directory() ) . 'inc/home/customizer-main-newsletter.php';
  require_once trailingslashit( get_template_directory() ) . 'inc/home/customizer-main-seller.php';
  

  $wp_customize->add_panel('panel3',
        array(
            'title' => 'Contacto',
            'priority' => 3,
            )
        );
  require_once trailingslashit( get_template_directory() ) . 'inc/contact/customizer-contact.php';
  require_once trailingslashit( get_template_directory() ) . 'inc/contact/customizer-contact-rrss.php';

  
} 
add_action('customize_register','theme_customize_register');

/***************** FNT General ************/

require_once trailingslashit( get_template_directory() ) . 'inc/fnc/fnc.php';

/***************** Local field group ************/

//require_once trailingslashit( get_template_directory() ) . 'inc/local-field-group.php';

/*********** ITEMS Video***********/
function custom_post_type_Items_video() {

  $labels = array(
    'name'                  => _x( 'Items Video', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'Items Video', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'             => __( 'Items Video', 'text_domain' ),
    'name_admin_bar'        => __( 'Items Video', 'text_domain' ),
    'archives'              => __( 'Archives', 'text_domain' ),
    'attributes'            => __( 'Attributes', 'text_domain' ),
    'parent_item_colon'     => __( 'Main Items Video', 'text_domain' ),
    'all_items Video'             => __( 'All Items Video', 'text_domain' ),
    'add_new_item'          => __( 'Add New Items Video', 'text_domain' ),
    'add_new'               => __( 'Add New', 'text_domain' ),
    'new_item'              => __( 'New Items Video', 'text_domain' ),
    'edit_item'             => __( 'Edit Items Video', 'text_domain' ),
    'update_item'           => __( 'Update Items Video', 'text_domain' ),
    'view_items Video'            => __( 'See Items Video', 'text_domain' ),
    'search_items Video'          => __( 'Search Items Video', 'text_domain' ),
    'not_found'             => __( 'Not found', 'text_domain' ),
    'not_found_in_trash'    => __( 'It is not in the trash', 'text_domain' ),
    'featured_image'        => __( 'Featured Image', 'text_domain' ),
    'set_featured_image'    => __( 'Set Featured Image', 'text_domain' ),
    'remove_featured_image' => __( 'Remove Featured Image', 'text_domain' ),
    'use_featured_image'    => __( 'Use Featured Image', 'text_domain' ),
    'insert_into_item'      => __( 'Insert Into Item', 'text_domain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
    'items Video_list'            => __( 'items Video List', 'text_domain' ),
    'items Video_list_navigation' => __( 'items Video List Navigation', 'text_domain' ),
    'filter_items Video_list'     => __( 'filter Items Video List', 'text_domain' ),
  );
  $args = array(
    'label'                 => __( 'Items Video', 'text_domain' ),
    'description'           => __( 'Items Video image', 'text_domain' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'custom-fields' ),
    'taxonomies'            => array( '' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-format-video',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page', 
  );
  register_post_type( 'Items Video', $args );

}
add_action( 'init', 'custom_post_type_Items_video', 0 );

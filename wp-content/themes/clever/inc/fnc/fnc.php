<?php

/************* General wordpress ************/

the_post_thumbnail();
the_post_thumbnail('thumbnail');       
the_post_thumbnail('medium');          
the_post_thumbnail('large');           
the_post_thumbnail('full');            

add_theme_support( 'post-thumbnails' );
the_post_thumbnail( array(100,100) ); 
set_post_thumbnail_size( 1568, 9999 );

// Add default posts and comments RSS feed links to head.
add_theme_support( 'automatic-feed-links' );

/*
 * Let WordPress manage the document title.
 * By adding theme support, we declare that this theme does not use a
 * hard-coded <title> tag in the document head, and expect WordPress to
 * provide it for us.
 *
 */add_theme_support( 'title-tag' );

/*
 * Enable support for Post Thumbnails on posts and pages.
*
* @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
 */
add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in one location.
register_nav_menus( array(
  'primary' => __( 'Primary Menu', 'store' ),
  'top' => __( 'Top Menu', 'store' ),
) );

/*
 * Switch default core markup for search form, comment form, and comments
 * to output valid HTML5.
 */
add_theme_support( 'html5', array(
  'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
) );

/*
 * Enable support for Post Formats.
 * See http://codex.wordpress.org/Post_Formats
 */
add_theme_support( 'post-formats', array(
    'aside', 'image', 'video', 'quote', 'link',
) );

// Set up the WordPress core custom background feature.
add_theme_support( 'custom-background', apply_filters( 'store_custom_background_args', array(
    'default-color' => 'f7f5ee',
    'default-image' => '',
) ) );

add_image_size('store-sq-thumb', 600,600, true );
add_image_size('store-thumb', 540,450, true );
add_image_size('pop-thumb',542, 340, true );

//Declare woocommerce support
add_theme_support('woocommerce');
add_theme_support( 'wc-product-gallery-lightbox' );

/*********** Woocommerce **********************/

function my_theme_setup() {
  add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'my_theme_setup' );

add_action( 'after_setup_theme', 'yourtheme_setup' );

function yourtheme_setup() {


add_theme_support( 'wc-product-gallery-slider' );
} 

/*****************Widget ************************/
function clever_widgets_init() {

  register_sidebar(
    array(
      'name'          => __( 'Lang', 'Clever' ),
      'id'            => 'sidebar-1',
      'description'   => __( 'Add widgets here to appear in your header.', 'Clever' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );

}
add_action( 'widgets_init', 'clever_widgets_init' );

/****************Excerpt general****************/

function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}

/***************** Lang ********************/

function lang(){
    $currentlang = get_bloginfo('language');
    if ($currentlang == 'en-US') {
     $lang="en";
    }
    else $lang="es";
    return $lang;
}

/************ variation ***********************/
function variation($id)
{
    global $wpdb;
    $count = 0;
      $result1 = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."posts where post_parent = '$id' and post_type = 'product_variation' and post_status = 'publish'");
      foreach ( $result1 as $page1 )
      { $count = $count+1;}
   
    return $count;
}

/************ product sku ***********************/
function woocommerce_template_single_sku(){
  require_once trailingslashit( get_template_directory() ) . 'woocommerce/content-single-product.php';
  $id = products();
  global $wpdb;  
  $result_link = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."postmeta WHERE meta_key = '_sku' and post_id = '$id'"); 
  foreach($result_link as $r)
  {
          //$value = '<div class="product_meta"><span class="sku_wrapper">Ref: '.$r->meta_value.'</span></div>'; 
          $value = '<div class="product_metas"><span class="sku_wrapper">Ref: '.$r->meta_value.'</span></div>';                    
  }
  echo $value;
}



?>
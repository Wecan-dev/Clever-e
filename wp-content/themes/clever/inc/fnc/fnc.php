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
      'name'          => __( 'Sidebar Header', 'Clever' ),
      'id'            => 'sidebar-1',
      'description'   => __( 'Add widgets here to appear in your header.', 'Clever' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );

  register_sidebar(
    array(
      'name'          => __( 'Sidebar-2 Header', 'Clever' ),
      'id'            => 'sidebar-2',
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



/***************** Tags ***********************/
function verify_tags($var)
{
    global $wpdb;
    $tag = 0;
    $result = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."term_relationships where object_id = $var");
    foreach ( $result as $page )
    { 
      $valor=$page->term_taxonomy_id;
      $result = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."term_taxonomy where term_taxonomy_id = $valor and taxonomy = 'post_tag'");
      foreach ( $result as $page )
      { $tag = $tag+1;}
    }  
    return $tag;
}

/***************** Author ***********************/
function author_name($id_author)
{
    global $wpdb;
    $result = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."users where ID = $id_author");
    foreach ( $result as $page )
    { 
      return $valor=$page->user_nicename;
    } 
}   

/************** Count post cat ****************/
function count_post($cat_id)
{
    global $wpdb;
    $count = 0;
    $result = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."term_relationships where term_taxonomy_id = $cat_id");
    foreach ( $result as $page )
    { 
      $valor=$page->object_id;
      $result1 = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."posts where ID = $valor and post_status = 'publish'");
      foreach ( $result1 as $page1 )
      { $count = $count+1;}
    }  
    return $count;
}  

/************** Count post tag ****************/
function count_post_tag($tag_id)
{
    global $wpdb;
    $count = 0;
    $result = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."term_relationships where term_taxonomy_id = $tag_id");
    foreach ( $result as $page )
    { 
      $valor=$page->object_id;
      $result1 = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."posts where ID = $valor and post_status = 'publish'");
      foreach ( $result1 as $page1 )
      { $count = $count+1;}
    }  
    return $count;
} 
/************** Count product ****************/
 
function count_post_product($cat,$tax,$lower,$upper,$category_name,$page_name)
{ $count = 0;


  if ($category_name == NULL){ 
  if ($page_name == "Best Seller"){   
    if ($cat != NULL) {
        $args = 
        array(
          'post_type' => 'product',
          'post_status' => 'publish',
          'posts_per_page' => 99999,
          'meta_key' => 'total_sales',
          'orderby' => 'meta_value_num', 
          'meta_query' => array(
            array(
                'key' => 'total_sales',
                'value' => 0,
                'compare' => '>'
            )
          ),          
          'tax_query' => array(
             'relation'=>'AND', // 'AND' 'OR' ...
              array(
                'taxonomy'        => $tax,
                'field'           => 'slug',
                'terms'           => array($cat),
                'operator'        => 'IN',
               )),
          ); 
      }  
    if ($cat == NULL AND $lower == NULL) {
        $args = 
        array(
          'post_type' => 'product',
          'post_status' => 'publish',
          'posts_per_page' => 99999,
          'meta_key' => 'total_sales',
          'orderby' => 'meta_value_num', 
          'meta_query' => array(
            array(
                'key' => 'total_sales',
                'value' => 0,
                'compare' => '>'
            )
          ),          
        ); 
    }
    if ($lower != NULL) {
    if($lower > 100){
      $lower = $lower/1000;
    } 
    if($upper > 100){
      $upper = $upper/1000;
    }      
        $args = 
        array(
          'post_type' => 'product',
          'posts_per_page' => 99999,        
          'post_status' => 'publish',
          'meta_key' => 'total_sales',
          'orderby' => 'meta_value_num', 
          'meta_query' => array(
             'relation'=>'AND', // 'AND' 'OR' ...
             array(
                 'key' => 'total_sales',
                 'value' => 0,
                 'compare' => '>'
             ),
             'relation'=>'AND', // 'AND' 'OR' ...
              array(
                'key' => '_price',
                'value' => array($lower, $upper),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
               )),
          );
        
      } 
  }//if category_name    

if ($page_name != "Best Seller"){   
    if ($cat != NULL) {
        $args = 
        array(
          'post_type' => 'product',
          'post_status' => 'publish',
          'posts_per_page' => 99999,
          'tax_query' => array(
             'relation'=>'AND', // 'AND' 'OR' ...
              array(
                'taxonomy'        => $tax,
                'field'           => 'slug',
                'terms'           => array($cat),
                'operator'        => 'IN',
               )),
          ); 
      }  
    if ($cat == NULL AND $lower == NULL) {
        $args = 
        array(
          'post_type' => 'product',
          'post_status' => 'publish',
          'posts_per_page' => 99999,
          ); 
    }
    if ($lower != NULL) {
    if($lower > 100){
      $lower = $lower/1000;
    } 
    if($upper > 100){
      $upper = $upper/1000;
    }      
        $args = 
        array(
          'post_type' => 'product',
          'posts_per_page' => 99999,        
          'post_status' => 'publish',
          'meta_query' => array(
             'relation'=>'AND', // 'AND' 'OR' ...
              array(
                'key' => '_price',
                'value' => array($lower, $upper),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
               )),
          );
        
      } 
  }}//if category_name      

if ($category_name != NULL){ 
    if ($cat != NULL) {
        $args = 
        array(
          'post_type' => 'product',
          'post_status' => 'publish',
          'posts_per_page' => 99999,
          'tax_query' => array(
             'relation'=>'AND', // 'AND' 'OR' ...
              array(
                'taxonomy'        => $tax,
                'field'           => 'slug',
                'terms'           => array($cat),
                'operator'        => 'IN',
               ),
             'relation'=>'AND', // 'AND' 'OR' ...
              array(
                'taxonomy'        => 'product_cat',
                'field'           => 'slug',
                'terms'           => array($category_name),
                'operator'        => 'IN',
               )),              
          ); 
      }

    if ($cat == NULL AND $lower == NULL) {
        $args = 
        array(
          'post_type' => 'product',
          'post_status' => 'publish',
          'posts_per_page' => 99999,
          'tax_query' => array(
             'relation'=>'AND', // 'AND' 'OR' ...
              array(
                'taxonomy'        => 'product_cat',
                'field'           => 'slug',
                'terms'           => array($category_name),
                'operator'        => 'IN',
               )),                 
          ); 
    }

    if ($lower != NULL) {
    if($lower > 100){
      $lower = $lower/1000;
    } 
    if($upper > 100){
      $upper = $upper/1000;
    }      
        $args = 
        array(
          'post_type' => 'product',
          'posts_per_page' => 99999,        
          'post_status' => 'publish',
          'tax_query' => array(
             'relation'=>'AND', // 'AND' 'OR' ...
              array(
                'taxonomy'        => 'product_cat',
                'field'           => 'slug',
                'terms'           => array($category_name),
                'operator'        => 'IN',
               )),           
          'meta_query' => array(
             'relation'=>'AND', // 'AND' 'OR' ...
              array(
                'key' => '_price',
                'value' => array($lower, $upper),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
               )),
          );
        
      } 
  }//if category_name       

         $loop = new WP_Query( $args ); 
         while ( $loop->have_posts() ) : $loop->the_post(); global $product;
              $count = $count+1;
         endwhile; 
          return $count;    
}

/************** Count product taxonomy****************/
 
function count_post_product_taxonomy($cat,$tax,$categor)
{ $count = 0;
    if ($cat != NULL) {
        $args = 
        array(
          'post_type' => 'product',
          'post_status' => 'publish',
          'posts_per_page' => 99999,
          'tax_query' => array(
             'relation'=>'AND', // 'AND' 'OR' ...
              array(
                'taxonomy'        => $tax,
                'field'           => 'slug',
                'terms'           => $cat,
                'operator'        => 'IN',
               ),
             'relation'=>'AND', // 'AND' 'OR' ...
              array(
                'taxonomy'        => 'collection',
                'field'           => 'slug',
                'terms'           => $categor,
                'operator'        => 'IN',
               )),          
          ); 
      }  
    if ($cat == NULL) {
        $args = 
        array(
          'post_type' => 'product',
          'post_status' => 'publish',
          'posts_per_page' => 99999,
          'tax_query' => array(
             'relation'=>'AND', // 'AND' 'OR' ...
              array(
                'taxonomy'        => 'collection',
                'field'           => 'slug',
                'terms'           => array($categor),
                'operator'        => 'IN',
               )),          
          ); 
      }      
         $loop = new WP_Query( $args ); 
         while ( $loop->have_posts() ) : $loop->the_post(); global $product;
              $count = $count+1;
         endwhile; 
          return $count;    
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

/************ color ***********************/
function color($id)
{
    global $wpdb;
    $count = 0;
      $result1 = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."termmeta where term_id = '$id' and meta_key = 'pa_color_swatches_id_phoen_color'");
      foreach ( $result1 as $page1 )
      { $color = $page1->meta_value;}
   
    return $color;
}



function arg($cat,$tax,$lower,$upper,$orderby,$paged,$category_name,$page_name){ 
if ($category_name == NULL){  
if ($page_name != "Best Seller"){    
  if ($cat != NULL) {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'tax_query' => array(
      'relation'=>'AND', // 'AND' 'OR' ...
        array(
        'taxonomy'        => $tax,
        'field'           => 'slug',
        'terms'           => array($cat),
        'operator'        => 'IN',
        )),
    );
  } 
        
  if ($cat == NULL AND $lower == NULL) {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' =>12,
    );
  } 
        
  if ($lower != NULL) {
    if($lower > 100){
      $lower = $lower/1000;
    } 
    if($upper > 100){
      $upper = $upper/1000;
    }    
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'meta_query' => array(
          'relation'=>'AND', // 'AND' 'OR' ...
          array(
            'key' => '_price',
            'value' => array($lower, $upper),
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC'
          )),
    );
  }  
       
  if ($orderby == 'rating') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'orderby' => 'meta_value', // orderby the meta_value of the following meta_key
      'meta_key' => '_wc_average_rating', // the custom meta_key name
      'order'=> 'DESC' // sort descending
    );
  } 
        
  if ($orderby == 'popularity') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'orderby' => 'meta_value', // orderby the meta_value of the following meta_key
      'meta_key' => 'total_sales', // the custom meta_key name
      'order'=> 'DESC' // sort descending
    );
  }          
        
  if ($orderby == 'menu_order') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'orderby' => 'menu_order',
      'order' => 'ASC'
    );
  }  
        
  if ($orderby == 'date') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'orderby' => 'date',
      'order' => 'DESC'
    );
  }  
        
  if ($orderby == 'price') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'orderby' => 'meta_value', // orderby the meta_value of the following meta_key
      'meta_key' => '_price', // the custom meta_key name
      'order'=> 'ASC' // sort descending
    );
  } 
        
  if ($orderby == 'price-desc') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'orderby' => 'meta_value', // orderby the meta_value of the following meta_key
      'meta_key' => '_price', // the custom meta_key name
      'order'=> 'DESC' // sort descending
    );
  } 
 } 

if ($page_name == "Best Seller"){    
  if ($cat != NULL) {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,     
      'meta_key' => 'total_sales',
      'orderby' => 'meta_value_num', 
      'meta_query' => array(
        array(
            'key' => 'total_sales',
            'value' => 0,
            'compare' => '>'
        )
      ),
      'post_status' => 'publish',
      'tax_query' => array(
      'relation'=>'AND', // 'AND' 'OR' ...
        array(
        'taxonomy'        => $tax,
        'field'           => 'slug',
        'terms'           => array($cat),
        'operator'        => 'IN',
        )),
    );
  } 
        
  if ($cat == NULL AND $lower == NULL) {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' =>12,
      'meta_key' => 'total_sales',
      'orderby' => 'meta_value_num',   
      'meta_query' => array(
        array(
            'key' => 'total_sales',
            'value' => 0,
            'compare' => '>'
        )
      ),

    );
  } 
        
  if ($lower != NULL) {
    if($lower > 100){
      $lower = $lower/1000;
    } 
    if($upper > 100){
      $upper = $upper/1000;
    }    
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,  
      'meta_key' => 'total_sales',
      'orderby' => 'meta_value_num',             
      'post_status' => 'publish',
      'meta_query' => array(
          'relation'=>'AND', // 'AND' 'OR' ...
          array(
            'key' => '_price',
            'value' => array($lower, $upper),
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC'
          ),
          'relation'=>'AND', // 'AND' 'OR' ...
          array(
            'key' => 'total_sales',
            'value' => 0,
            'compare' => '>',
          )
      ),
    );
  }  
       
  if ($orderby == 'rating') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'orderby' => 'meta_value', // orderby the meta_value of the following meta_key
      'meta_key' => '_wc_average_rating', // the custom meta_key name
      'order'=> 'DESC', // sort descending
      'meta_query' => array(
        array(
            'key' => 'total_sales',
            'value' => 0,
            'compare' => '>'
        )
      ),      
    );
  } 
        
  if ($orderby == 'popularity') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'orderby' => 'meta_value', // orderby the meta_value of the following meta_key
      'meta_key' => 'total_sales', // the custom meta_key name
      'order'=> 'DESC', // sort descending
      'meta_query' => array(
        array(
            'key' => 'total_sales',
            'value' => 0,
            'compare' => '>'
        )
      ),      
    );
  }          
        
  if ($orderby == 'menu_order') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'orderby' => 'menu_order',
      'order' => 'ASC',
      'meta_query' => array(
        array(
            'key' => 'total_sales',
            'value' => 0,
            'compare' => '>'
        )
      ),      

    );
  }  
        
  if ($orderby == 'date') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'orderby' => 'date',
      'order' => 'DESC',
      'meta_query' => array(
        array(
            'key' => 'total_sales',
            'value' => 0,
            'compare' => '>'
        )
      ),      
    );
  }  
        
  if ($orderby == 'price') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'orderby' => 'meta_value', // orderby the meta_value of the following meta_key
      'meta_key' => '_price', // the custom meta_key name
      'order'=> 'ASC', // sort descending
      'meta_query' => array(
        array(
            'key' => 'total_sales',
            'value' => 0,
            'compare' => '>'
        )
      ),

    );
  } 
        
  if ($orderby == 'price-desc') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'orderby' => 'meta_value', // orderby the meta_value of the following meta_key
      'meta_key' => '_price', // the custom meta_key name
      'order'=> 'DESC', // sort descending
      'meta_query' => array(
        array(
            'key' => 'total_sales',
            'value' => 0,
            'compare' => '>'
        )
      ),      
    );
  } 
} 
}//if category_name

if ($category_name != NULL){   
  if ($cat == NULL AND $category_name != NULL) {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'tax_query' => array(
      'relation'=>'AND', // 'AND' 'OR' ...
        array(
        'taxonomy'        => 'product_cat',
        'field'           => 'slug',
        'terms'           => array($category_name),
        'operator'        => 'IN',
        )),
    );
  } 
        
  if ($cat != NULL) {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'tax_query' => array(
      'relation'=>'AND', // 'AND' 'OR' ...
        array(
        'taxonomy'        => $tax,
        'field'           => 'slug',
        'terms'           => array($cat),
        'operator'        => 'IN',
        ),
      'relation'=>'AND', // 'AND' 'OR' ...
        array(
        'taxonomy'        => 'product_cat',
        'field'           => 'slug',
        'terms'           => array($category_name),
        'operator'        => 'IN',
        )),        
    );
  } 
       
  if ($lower != NULL) {
    if($lower > 100){
      $lower = $lower/1000;
    } 
    if($upper > 100){
      $upper = $upper/1000;
    }    
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'tax_query' => array(
      'relation'=>'AND', // 'AND' 'OR' ...
        array(
        'taxonomy'        => 'product_cat',
        'field'           => 'slug',
        'terms'           => array($category_name),
        'operator'        => 'IN',
        )),      
      'meta_query' => array(
          'relation'=>'AND', // 'AND' 'OR' ...
          array(
            'key' => '_price',
            'value' => array($lower, $upper),
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC'
          )),
    );
  }  
       
  if ($orderby == 'rating') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'tax_query' => array(
      'relation'=>'AND', // 'AND' 'OR' ...
        array(
        'taxonomy'        => 'product_cat',
        'field'           => 'slug',
        'terms'           => array($category_name),
        'operator'        => 'IN',
        )),      
      'orderby' => 'meta_value', // orderby the meta_value of the following meta_key
      'meta_key' => '_wc_average_rating', // the custom meta_key name
      'order'=> 'DESC' // sort descending
    );
  } 
        
  if ($orderby == 'popularity') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'tax_query' => array(
      'relation'=>'AND', // 'AND' 'OR' ...
        array(
        'taxonomy'        => 'product_cat',
        'field'           => 'slug',
        'terms'           => array($category_name),
        'operator'        => 'IN',
        )),      
      'orderby' => 'meta_value', // orderby the meta_value of the following meta_key
      'meta_key' => 'total_sales', // the custom meta_key name
      'order'=> 'DESC' // sort descending
    );
  }          
        
  if ($orderby == 'menu_order') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'tax_query' => array(
      'relation'=>'AND', // 'AND' 'OR' ...
        array(
        'taxonomy'        => 'product_cat',
        'field'           => 'slug',
        'terms'           => array($category_name),
        'operator'        => 'IN',
        )),      
      'orderby' => 'menu_order',
      'order' => 'ASC'
    );
  }  
        
  if ($orderby == 'date') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'tax_query' => array(
      'relation'=>'AND', // 'AND' 'OR' ...
        array(
        'taxonomy'        => 'product_cat',
        'field'           => 'slug',
        'terms'           => array($category_name),
        'operator'        => 'IN',
        )),      
      'orderby' => 'date',
      'order' => 'DESC'
    );
  }  
        
  if ($orderby == 'price') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'tax_query' => array(
      'relation'=>'AND', // 'AND' 'OR' ...
        array(
        'taxonomy'        => 'product_cat',
        'field'           => 'slug',
        'terms'           => array($category_name),
        'operator'        => 'IN',
        )),      
      'orderby' => 'meta_value', // orderby the meta_value of the following meta_key
      'meta_key' => '_price', // the custom meta_key name
      'order'=> 'ASC' // sort descending
    );
  } 
        
  if ($orderby == 'price-desc') {
    $args = 
    array(
      'post_type' => 'product',
      'paged' => $paged,
      'posts_per_page' => 12,        
      'post_status' => 'publish',
      'tax_query' => array(
      'relation'=>'AND', // 'AND' 'OR' ...
        array(
        'taxonomy'        => 'product_cat',
        'field'           => 'slug',
        'terms'           => array($category_name),
        'operator'        => 'IN',
        )),      
      'orderby' => 'meta_value', // orderby the meta_value of the following meta_key
      'meta_key' => '_price', // the custom meta_key name
      'order'=> 'DESC' // sort descending
    );
  }    
}//else       
  return $args; 
}  

/***************** File Customizer ***********************/
function file_customizer($id_file)
{
    global $wpdb;
    $result = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."posts where ID = $id_file");
    foreach ( $result as $page )
    { 
      return $valor=$page->guid;
    } 
}   

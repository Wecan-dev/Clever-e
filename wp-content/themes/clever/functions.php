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
  wp_enqueue_style('googleapis', "https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" );


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
  require_once trailingslashit( get_template_directory() ) . 'inc/contact/customizer-contact-more-info.php';

  
} 
add_action('customize_register','theme_customize_register');

/***************** FNT General ************/

require_once trailingslashit( get_template_directory() ) . 'inc/fnc/fnc.php';

/***************** Local field group ************/

require_once trailingslashit( get_template_directory() ) . 'inc/fnc/local-field-group.php';

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

/*********** ITEMS Banner***********/
function custom_post_type_Items_banner() {

  $labels = array(
    'name'                  => _x( 'Items Banner', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'Items Banner', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'             => __( 'Items Banner', 'text_domain' ),
    'name_admin_bar'        => __( 'Items Banner', 'text_domain' ),
    'archives'              => __( 'Archives', 'text_domain' ),
    'attributes'            => __( 'Attributes', 'text_domain' ),
    'parent_item_colon'     => __( 'Main Items Banner', 'text_domain' ),
    'all_items Banner'             => __( 'All Items Banner', 'text_domain' ),
    'add_new_item'          => __( 'Add New Items Banner', 'text_domain' ),
    'add_new'               => __( 'Add New', 'text_domain' ),
    'new_item'              => __( 'New Items Banner', 'text_domain' ),
    'edit_item'             => __( 'Edit Items Banner', 'text_domain' ),
    'update_item'           => __( 'Update Items Banner', 'text_domain' ),
    'view_items Banner'            => __( 'See Items Banner', 'text_domain' ),
    'search_items Banner'          => __( 'Search Items Banner', 'text_domain' ),
    'not_found'             => __( 'Not found', 'text_domain' ),
    'not_found_in_trash'    => __( 'It is not in the trash', 'text_domain' ),
    'featured_image'        => __( 'Featured Image', 'text_domain' ),
    'set_featured_image'    => __( 'Set Featured Image', 'text_domain' ),
    'remove_featured_image' => __( 'Remove Featured Image', 'text_domain' ),
    'use_featured_image'    => __( 'Use Featured Image', 'text_domain' ),
    'insert_into_item'      => __( 'Insert Into Item', 'text_domain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
    'items Banner_list'            => __( 'items Banner List', 'text_domain' ),
    'items Banner_list_navigation' => __( 'items Banner List Navigation', 'text_domain' ),
    'filter_items Banner_list'     => __( 'filter Items Banner List', 'text_domain' ),
  );
  $args = array(
    'label'                 => __( 'Items Banner', 'text_domain' ),
    'description'           => __( 'Items Banner image', 'text_domain' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'custom-fields' ),
    'taxonomies'            => array( '' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-format-gallery',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page', 
  );
  register_post_type( 'Items Banner', $args );

}
add_action( 'init', 'custom_post_type_Items_banner', 0 );


// Minimum CSS to remove +/- default buttons on input field type number
add_action( 'wp_head' , 'custom_quantity_fields_css' );
function custom_quantity_fields_css(){
    ?>
    <style>
    .quantity input::-webkit-outer-spin-button,
    .quantity input::-webkit-inner-spin-button {
        display: none;
        margin: 0;
    }
    .quantity input.qty {
        appearance: textfield;
        -webkit-appearance: none;
        -moz-appearance: textfield;
    }
    </style>
    <?php
}


add_action( 'wp_footer' , 'custom_quantity_fields_script' );
function custom_quantity_fields_script(){
    ?>
    <script type='text/javascript'>
    jQuery( function( $ ) {
        if ( ! String.prototype.getDecimals ) {
            String.prototype.getDecimals = function() {
                var num = this,
                    match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                if ( ! match ) {
                    return 0;
                }
                return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
            }
        }
        // Quantity "plus" and "minus" buttons
        $( document.body ).on( 'click', '.plus, .minus', function() {
            var $qty        = $( this ).closest( '.quantity' ).find( '.qty'),
                currentVal  = parseFloat( $qty.val() ),
                max         = parseFloat( $qty.attr( 'max' ) ),
                min         = parseFloat( $qty.attr( 'min' ) ),
                step        = $qty.attr( 'step' );

            // Format values
            if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
            if ( max === '' || max === 'NaN' ) max = '';
            if ( min === '' || min === 'NaN' ) min = 0;
            if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

            // Change the value
            if ( $( this ).is( '.plus' ) ) {
                if ( max && ( currentVal >= max ) ) {
                    $qty.val( max );
                } else {
                    $qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            } else {
                if ( min && ( currentVal <= min ) ) {
                    $qty.val( min );
                } else if ( currentVal > 0 ) {
                    $qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            }

            // Trigger change event
            $qty.trigger( 'change' );
        });
    });
    </script>
    <?php
}
?>


<?php
//* Personalization page of product WooCommerce
/**
 * Displays a language list
 *
 * @since 1.2
 */
class PLL_Walker_List extends Walker { 
  public $db_fields = array( 'parent' => 'parent', 'id' => 'id' );

  /**
   * Outputs one element
   *
   * @since 1.2
   *
   * @param string $output            Passed by reference. Used to append additional content.
   * @param object $element           The data object.
   * @param int    $depth             Depth of the item.
   * @param array  $args              An array of additional arguments.
   * @param int    $current_object_id ID of the current item.
   */


  public function start_el( &$output, $element, $depth = 0, $args = array(), $current_object_id = 0 ) {
    if (lang() == 'es'){
      $img_lang = get_template_directory_uri().'/assets/img/esp.png';
      $text_lang = "Español";
    }
    if (lang() == 'en'){
      $img_lang = get_template_directory_uri().'/assets/img/eng.png';
      $text_lang = "Inglès";
    }   

$output .= sprintf(
      '%6$s<li class="%1$s"><a lang="%2$s" hreflang="%2$s" href="%3$s">%2$s</a></li>%7$s',
      esc_attr( implode( ' ', $element->classes ) ),
      esc_attr( $element->locale ),
      esc_url( $element->url ),
      $element->flag,
      $args['show_flags'] && $args['show_names'] ? sprintf( '<span style="margin-%1$s:0.3em;">%2$s</span>', is_rtl() ? 'right' : 'left', esc_html( $element->name ) ) : esc_html( $element->name ),
      'discard' === $args['item_spacing'] ? '' : "\t",
      'discard' === $args['item_spacing'] ? '' : "\n"
    );

    
 
  }

  /**
   * Overrides Walker::display_element as it expects an object with a parent property
   *
   * @since 1.2
   *
   * @param object $element           Data object.
   * @param array  $children_elements List of elements to continue traversing.
   * @param int    $max_depth         Max depth to traverse.
   * @param int    $depth             Depth of current element.
   * @param array  $args              An array of arguments.
   * @param string $output            Passed by reference. Used to append additional content.
   */
  public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
    $element = (object) $element; // Make sure we have an object
    $element->parent = $element->id = 0; // Don't care about this
    parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
  }

  /**
   * Overrides Walker:walk to set depth argument
   *
   * @since 1.2
   * @since 2.6.7 Use $max_depth and ...$args parameters to follow the move of WP 5.3
   *
   * @param array $elements  An array of elements.
   * @param int   $max_depth The maximum hierarchical depth.
   * @param mixed ...$args   Additional arguments.
   * @return string The hierarchical item output.
   */
  public function walk( $elements, $max_depth, ...$args ) { // phpcs:ignore WordPressVIPMinimum.Classes.DeclarationCompatibility.DeclarationCompatibility
    if ( is_array( $max_depth ) ) {
      // Backward compatibility with Polylang < 2.6.7
      if ( WP_DEBUG ) {
        trigger_error( // phpcs:ignore WordPress.PHP.DevelopmentFunctions
          sprintf(
            '%s was called incorrectly. The method expects an integer as second parameter since Polylang 2.6.7',
            __METHOD__
          )
        );
      }
      $args = $max_depth;
      $max_depth = -1;
    } else {
      $args = isset( $args[0] ) ? $args[0] : array();
    }

    return parent::walk( $elements, $max_depth, $args );
  }
}
 //////////////////custm /////////////////////////
function ayudawp_custom_pre_get_posts( $query ) {
if( $query->is_main_query() && !$query->is_feed() && !is_admin() && is_category()) {
    $query->set( 'paged', str_replace( '/', '', get_query_var( 'page' ) ) );  }  }

add_action('pre_get_posts','ayudawp_custom_pre_get_posts');

function ayudawp_custom_request($query_string ) {
     if( isset( $query_string['page'] ) ) {
         if( ''!=$query_string['page'] ) {
             if( isset( $query_string['name'] ) ) { unset( $query_string['name'] ); } } } return $query_string; }

add_filter('request', 'ayudawp_custom_request');

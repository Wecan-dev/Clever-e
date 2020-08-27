<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mar de Rosas
 */
function header_white(){
 return $home = "blog";
}

if ((get_post()->post_type) == 'sizing'){
  header('Location: '.get_home_url().'/sizings');
}
get_header();
   global $wpdb;  
   foreach((get_the_terms(get_the_ID(), 'collection' )) as $category) {                
      echo $categor = $category->slug;
       $category_id = $category->term_id;               
   }
   $result = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."term_taxonomy where term_taxonomy_id = $category_id and taxonomy = 'collection'");
   foreach ( $result as $page )
   { $description = $page->description; }     
?> 
  <section class="main-banner main-banner__small main-banner__shop">
    <div class="main-banner__item">
      <div class="main-banner__text main-banner__text--general wow animated fadeIn"
        style="visibility: visible; animation-delay: .3s  ;">
        <div class="main-banner__flex">
          <div class="main-banner__title">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/brush.png">
            <p>
              <?php echo termmeta_value( 'title_collection', $category_id ); ?>
            </p>
          </div>
          <div class="main-banner__subtitle">
            <p>
              <?php echo $description;?>
            </p>
          </div>
        </div>
      </div>
      <div class="main-banner__img main-banner__img--new">
        <img alt="Imagen Banner" src="<?php echo get_theme_mod('shop_banner_image');?>">
      </div>
    </div>
  </section>
  <section class="shop">
    <div class="main-general__bg">
      <h2 class="main-general__title main-general__title--center">
        <?php echo get_theme_mod('favorite_collection_title');?>
      </h2>
      <p class="main-general__subtitle main-general__subtitle--center">
        <?php echo get_theme_mod('favorite_collection_subtitle');?>
      </p>
    </div>  
    <div class="padding-left-right padding-top-bottom">
      <div class="container">
        
        <div class="shop-products">
          <div class="shop-products__header">
            <?php 
            //$published_posts = wp_count_posts()->publish;

            $published_posts = count_post_product_taxonomy($_GET["cat"],$_GET["tax"],$categor);
           // $posts_per_page = get_option('posts_per_page');
            $posts_per_page = 9;
            $page_number_max = ceil($published_posts / $posts_per_page);
            $max_page = $page_number_max;
            if (!$paged && $max_page >= 1) {
               $current_page = 1;
            }
            else {
              $current_page = $paged;
            } ?>          
            <h2>Showing <?php echo ''.$current_page.'-'.$max_page.' of '.$published_posts.''; ?> results</h2>
            <ul>
              <li><a data-toggle="tab" href="#list"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/shop/list.png"></a></li>
              <li class="active"><a data-toggle="tab" href="#menu"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/shop/menu.png"></a></li>
            </ul>
          </div>

    <div class="tab-content">
      <div id="menu" class="tab-pane fade in active show">    
          <div class="shop-product__gridd" >
        <?php
        $args = 
        array(
          'post_type' => 'product',
          'paged' => $paged,
          'posts_per_page' => 9,
          'tax_query' => array(
             'relation'=>'AND', // 'AND' 'OR' ...
              array(
                'taxonomy'        => 'collection',
                'field'           => 'slug',
                'terms'           => array($categor),
                'operator'        => 'IN',
               )),          
          );                
          ?>
        <?php $loop = new WP_Query( $args ); ?>
        <?php while ( $loop->have_posts() ) : $loop->the_post(); global $product;?>             
          <div class="main-collection__item">
           <a class="product-link" href="<?php the_permalink(); ?>"> 

              <div class="collection-item__mask">
                <div class="collection-item__icon">
                  <?php if (variation(get_the_ID()) <= 0){ ?>
                    <a href="?add-to-cart=<?php echo get_the_ID(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/bag2.png"></a>
                  <?php } ?>  
                  <?php if (variation(get_the_ID()) > 0){ ?>
                    <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/bag2.png"></a>
                  <?php } ?>                  
                </div>
                <div class="collection-item__icon">
                  <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/visibility.png"></a>
                </div>
                <div class="collection-item__icon">
                  <a href="?add_to_wishlist=<?php echo get_the_ID(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/heart2.png"></a>
                </div>
              </div>
           </a>
            <img src="<?php the_post_thumbnail_url('full'); ?>">
            <p class="collection-item__title">
              <?php the_title(); ?>
            </p>

            <p class="collection-item__price">
              <?php echo $product->get_price_html(); ?>
            </p>
            <p class="collection-item__description">
              <?php  echo strip_tags(cut_text(content(get_the_ID(),'product'),10));?>
            </p>
          </div>
        <?php endwhile; ?>  
        </div><!--grid-->
      </div><!--tab-menu -->

      <div id="list" class="tab-pane fade">
        <?php $loop = new WP_Query( $args ); ?>
        <?php while ( $loop->have_posts() ) : $loop->the_post(); global $product;?>             
          <div class="list_div" id="view" style="display:">
          <table class="shop_table cart wishlist_table wishlist_view traditional responsive  list_table " data-pagination="no" data-per-page="5" data-page="1" data-id="5" data-token="6OL1RPFP5C1P">  
            <tbody class="wishlist-items-wrapper list">
              <tr id="yith-wcwl-row-20" data-row-id="20">        
                <td class="product-thumbnail list">
                  <a href="http://localhost/mar-de-rosas/product/set-frida-swimwear2/">
                    <img class="list" src="<?php the_post_thumbnail_url('full'); ?>">          
                  </a> 
                  <table class="list_table">
                    <tr>
                      <td class="listt"> <p class="collection-item__title list"><?php the_title(); ?></p></td>
                    </tr>
                    <tr>
                      <td class="listd"><p class="collection-item__description"><?php  echo strip_tags(cut_text(content(get_the_ID(),'product'),10));?></p> </td>
                    </tr>          
                  </table>                         
                </td>  
                <td class="product-price list">              
                  <span class="woocommerce-Price-amount amount list"><span class="woocommerce-Price-currencySymbol">$</span>29.99</span>
                </td>
                <td class="product-add-to-cart list">
                  <span>
                    <?php if (variation(get_the_ID()) <= 0){ ?>
                      <a href="?add-to-cart=<?php echo get_the_ID(); ?>"><img class="lists" src="<?php echo get_template_directory_uri(); ?>/assets/img/bag2.png"></a>
                    <?php } ?>  
                     <?php if (variation(get_the_ID()) > 0){ ?>
                      <a href="<?php the_permalink(); ?>"><img class="lists" src="<?php echo get_template_directory_uri(); ?>/assets/img/bag2.png"></a>
                    <?php } ?> 
                    <a href="<?php the_permalink(); ?>"><img class="lists" src="<?php echo get_template_directory_uri(); ?>/assets/img/visibility.png"></a>         
                    <a href="?add_to_wishlist=<?php echo get_the_ID(); ?>"><img class="lists" src="<?php echo get_template_directory_uri(); ?>/assets/img/heart2.png"></a>          
                  </span>             
                </td>                    
              </tr>    
            </tbody>
          </table>
          </div>
        <?php endwhile; ?>      
      </div><!--tab list-->
    </div><!--tab-->    
    
        <div class="pagination">
          <div id="pagination">
            <div class="page-nav fix">
               <div class="suf-page-nav fix">
                  <?php echo paginate_links(array(
                  "base" => add_query_arg("paged", "%#%"),
                  "format" => '',
                  "type" => "plain",
                  "total" => $max_page,
                  "current" => $current_page,
                  "show_all" => false,
                  "end_size" => 2,
                  "mid_size" => 2,
                  "prev_next" => true,
                  "next_text" => __('<img src="http://localhost/mar-de-rosas/wp-content/themes/Mar_de_rosas/assets/img/shop/arrow.png">'),
                  "prev_text" => __('<img src="http://localhost/mar-de-rosas/wp-content/themes/Mar_de_rosas/assets/img/shop/prev.png">'),
                  )); ?>
                </div>
            </div>
          </div>
        </div>

        </div>
      </div>
    </div>
  </section>
<script>
$('#pagination a').on('click', function(event){
event.preventDefault();
var link = $(this).attr('href'); //Get the href attribute
$('#content').fadeOut(500, function(){ });//fade out the content area
$('#content').load(link + ' #content', function() { });
$('#content').fadeIn(500, function(){ });//fade in the content area

});
</script>
<script>
  $(document).ready(function () {

    $(".toggle-accordion").on("click", function () {
      var accordionId = $(this).attr("accordion-id"),
        numPanelOpen = $(accordionId + ' .collapse.in').length;

      $(this).toggleClass("active");

      if (numPanelOpen == 0) {
        openAllPanels(accordionId);
      } else {
        closeAllPanels(accordionId);
      }
    })

    openAllPanels = function (aId) {
      console.log("setAllPanelOpen");
      $(aId + ' .panel-collapse:not(".in")').collapse('show');
    }
    closeAllPanels = function (aId) {
      console.log("setAllPanelclose");
      $(aId + ' .panel-collapse.in').collapse('hide');
    }

  });

  var lowerSlider = document.querySelector('#lower');
  var upperSlider = document.querySelector('#upper');

  document.querySelector('#two').value = upperSlider.value;
  document.querySelector('#one').value = lowerSlider.value;

  var lowerVal = parseInt(lowerSlider.value);
  var upperVal = parseInt(upperSlider.value);

  upperSlider.oninput = function () {
    lowerVal = parseInt(lowerSlider.value);
    upperVal = parseInt(upperSlider.value);

    if (upperVal < lowerVal + 4) {
      lowerSlider.value = upperVal - 4;
      if (lowerVal == lowerSlider.min) {
        upperSlider.value = 4;
      }
    }
    document.querySelector('#two').value = this.value
  };

  lowerSlider.oninput = function () {
    lowerVal = parseInt(lowerSlider.value);
    upperVal = parseInt(upperSlider.value);
    if (lowerVal > upperVal - 4) {
      upperSlider.value = lowerVal + 4;
      if (upperVal == upperSlider.max) {
        lowerSlider.value = parseInt(upperSlider.max) - 4;
      }
    }
    document.querySelector('#one').value = this.value
  };
</script>
<?php
get_footer();

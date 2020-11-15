  <section class="main-products">
    <div class="padding-top-bottom">
      <div class="padding-right-left">
        <h2 class="main-general__title--light">
          <?php echo get_theme_mod('products_title_'.lang().''); ?>
        </h2>
        <h2 class="main-general__title--bold">
          <?php echo get_theme_mod('products_subtitle_'.lang().''); ?>
        </h2>
      </div>
      <div class="main-products__carousel">
        <?php $product_categories = get_categories( array( 'taxonomy' => 'product_cat', 'orderby' => 'menu_order', 'order' => 'asc' ));
          foreach($product_categories as $category):  global $wpdb;
          $result = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."term_taxonomy where taxonomy = 'product_cat'");
          $array_cat[] = $category->slug;
          endforeach;
          $count_cat=count($array_cat);
        ?>  
        <?php
          for ($i=0; $i < $count_cat; $i++) { 
              $j = 0;         
              $args = array (
                 'post_type' => 'product',
                 'posts_per_page' => 10,
                 'post_status' => 'publish',
                 'order'=> 'ASC',
                 'tax_query' => array(
                 'relation'=>'AND', // 'AND' 'OR' ...
                   array(
                   'taxonomy'        => 'product_cat',
                   'field'           => 'slug',
                   'terms'           => array($array_cat[$i]),
                   'operator'        => 'IN',
                  )),               
              );
              $loop = new WP_Query( $args ); 
              while ( $loop->have_posts() ) : $loop->the_post(); global $product;     
              $array[$i][$j] = get_the_ID();  
              $j = $j + 1;
              endwhile; 
           }
 
           $count_mat=count($array);  
           for ($a=0; $a <=10 ; $a++) { 
             for ($j=0; $j <=$count_cat ; $j++) { 
              $id_cat = $array[$j][$a];    

              $cont = $cont +1;
              if ($id_cat != NULL) {
   

        ?>
              
              <div class="main-products__item">
                <div class="main-products__img">
                  <div class="main-products__mask">
                    <a href="<?php echo get_post($id_cat)->guid; ?>" class="product-link" > </a>
                    <div class="main-products__icon">
                    <?php if (variation($id_cat) <= 0){ ?>
                      <a href="?add-to-cart=<?php echo $id_cat; ?>">
                        <img src="<?php echo get_template_directory_uri();?>/assets/img/card.png">
                      </a>
                    <?php } ?>  
                    <?php if (variation($id_cat) > 0){ ?>
                     <a href="<?php echo get_post($id_cat)->guid; ?>">
                        <img src="<?php echo get_template_directory_uri();?>/assets/img/card.png">
                      </a>              
                    <?php } ?> 
                    <?php// if (is_user_logged_in()){ ?>    
                      <a href="?add_to_wishlist=<?php echo $id_cat; ?>">
                        <img src="<?php echo get_template_directory_uri();?>/assets/img/heart.png">
                      </a>
                    <?php// }else { ?>  
                    <!--<div data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if(lang() == 'es'){echo "Debes estar iniciar sesión";}else{echo "You must be logged";} ?>" class="collection-item__icon" >
                      <img src="<?php echo get_template_directory_uri();?>/assets/img/heart.png">
                    </div> -->             
                    <?php// } ?>
                      <a href="<?php echo get_post($id_cat)->guid; ?>">
                        <img src="<?php echo get_template_directory_uri();?>/assets/img/search.png">
                      </a>
                    </div>
                  </div>
                  <img src="<?php echo meta_value_img( '_thumbnail_id', $id_cat );?>">
                </div>
                <div class="main-products__body">
                  <a class="main-products__title" href="<?php echo get_post($id_cat)->guid; ?>">
                    <?php echo get_post($id_cat)->post_title; ?>
                  </a>
                  <p class="main-products__categorie">
                    <?php if(lang() == 'es'){echo "categoría: ";}if(lang() == 'en'){echo "category: ";}  
                    $product_categories = wp_get_post_terms( $id_cat, 'product_cat' ); $i = 0;
                    foreach($product_categories as $category):
                      if ($i > 0 ) {echo " / "; } echo $category->name; $i=$i+1;
                    endforeach;?>
                  </p>
                  <p class="main-products__price">
                    <?php $product = new WC_Product($id_cat);  echo $product->get_price_html(); ?>
                  </p>
                </div>
              </div>

            <?php
           
             }}
           }
           
        ?>      
     
      <?php// endwhile; ?>   
      </div>
    </div>
  </section>
<script type="text/javascript">
      $(document).ready(function() {       
        var langu = "<?= get_bloginfo('language') ?>";         
        if (langu == 'en-US'){ 
          $(".be").html(function(serachreplace, replace) {
            return replace.replace('Antes', 'Before');
          });          
          $(".af").html(function(serachreplace, replace) {
            return replace.replace('Después', 'After');
          }); 
        }         

    }); 
</script>
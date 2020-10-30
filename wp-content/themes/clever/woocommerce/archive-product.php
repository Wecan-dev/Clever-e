<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */


defined( 'ABSPATH' ) || exit;

if (strpos($_SERVER['REQUEST_URI'],'wp-admin') === false) {

get_header();
if ($_GET['orderby'] == 'menu_order' ){ $selectm = 'selected="selected"';}
if ($_GET['orderby'] == 'popularity' ){ $selectp = 'selected="selected"';}
if ($_GET['orderby'] == 'rating' ){ $selectr = 'selected="selected"';}
if ($_GET['orderby'] == 'date' ){ $selectd = 'selected="selected"';}
if ($_GET['orderby'] == 'price' ){ $selectpr = 'selected="selected"';}
if ($_GET['orderby'] == 'price-desc' ){ $selectpr_desc = 'selected="selected"';}    

global $wp_query;
$category_id = get_queried_object_id();
$category_name = get_queried_object()->slug; 
$current_uri = home_url( add_query_arg( NULL, NULL ) );

$page_name = get_post(get_the_ID())->post_title;

$urlsinparametros= explode('?', $_SERVER['REQUEST_URI'], 2);
if ($category_name == NULL){ 
    $urlsinparametros = get_home_url().'/'.get_post(get_the_ID())->post_name;
}else{
	$urlsinparametros = get_home_url().'/product-category/'.$category_name;
}    
if (lang() == "es") {
	$sizetalla = "pa_talla";
	$colorpattern = "pa_color";
	$siluet = "pa_silueta";
	$pa_color_swatches = "pa_color_swatches_id_phoen_color";
}
else{
	$sizetalla = "pa_size";
	$colorpattern = "pa_colors";
	$siluet = "pa_silhouette";
	$pa_color_swatches = "pa_colors_swatches_id_phoen_color";
}


$args = arg($_GET["cat"],$_GET["tax"],$_GET["lower"],$_GET["upper"],$_GET['orderby'],$paged,$category_name,$page_name);         
?>
<?php if ($category_name == NULL) { ?>
    <?php if ($page_name == "Best Seller"){ $page_name1 = 1; ?>
    <section class="banner-small banner-small--bs">
	    <img class="banner-small__img" src="<?php echo get_template_directory_uri();?>/assets/img/categorie/best-seller.jpg">
	    <div class="banner-small__text">
		    <h2 class="banner-small__title">
                  Best Seller		     	
		    </h2>
	    </div>
    </section>
    <?php } ?>
    <?php if ($page_name == "Básicos e infaltables" OR $page_name == "Basic and unavoidable"){ $page_name1 = 1; ?>
    <section class="banner-small banner-small--bs">
	    <img class="banner-small__img" src="<?php echo get_template_directory_uri();?>/assets/img/categorie/best-seller.jpg">
	    <div class="banner-small__text">
		    <h2 class="banner-small__title">       
			       <?php if(lang() == 'es'){echo "Básicos e infaltables";}else{echo "Basic and unavoidable";} ?>
		    </h2>
	    </div>
    </section>
    <?php } ?>    
    <?php if ($page_name1 != 1){ ?>
    <section class="banner-small banner-small--bs">
	    <img class="banner-small__img" src="<?php echo get_template_directory_uri();?>/assets/img/categorie/best-seller.jpg">
	    <div class="banner-small__text">
		    <h2 class="banner-small__title">
		        <?php if(lang() == 'es'){echo "Tienda"; $urlsinparametros = get_home_url()."/tienda";}else{echo "Shop"; $urlsinparametros = get_home_url()."/shop";} ?>		       
		    </h2>
	    </div>
    </section>
    <?php } ?>
<?php } 
else { ?>
  <section class="banner-small">
	     <?php   if ( wp_is_mobile() ) {  ?>
	     <img src="<?php echo wp_get_attachment_url( get_woocommerce_term_meta( $category_id, 'thumbnail_id', true ) );?>">
	        <?php    } else {  ?>
	      <img class="banner-small__img" src="<?php echo termmeta_value_img( 'image_banner_categories', $category_id ); ?>">

	   <?php  } ?>
    <div class="banner-small__text">
      <h2 class="banner-small__title">
        <?php echo single_cat_title("", false); ?>
      </h2>
    </div>
  </section>
<?php } ?>
<section class="categories <?php if ($page_name == "Best Seller"){ echo "categories-bs";}?>">
	<div class="container-grid">
		<div class="categories-sidebar">
			<div class="categories-sidebar__item">
				<h2 class="categories-sidebar__title">
					<?php if(lang() == 'es'){echo "Precio";}else{echo "Price";} ?>
				</h2>
				<div class="filter-price">
					<form method="get">
						<div id="slider-distance" slider="">
							<div>
								<div inverse-left="" style="width:70%;"></div>
								<div inverse-right="" style="width:70%;"></div>
								<div range="" style="left:0%;right:0%;"></div>
								<span style="left:0%;" thumb=""></span>
								<span style="left:100%;" thumb=""></span>
								<div sign="" style="left:0%;">
									Price:
									<span class="value-1" id="value">0</span>
								</div>
								<div sign="" style="left:100%;">
									<span id="value"><?php if (get_woocommerce_currency() != "COP"){ echo "100"; $max = "100";}else{echo "100000"; $max = "100000";} ?></span>
								</div>
								<div><button class="shop-btn trans main-general__button" type="submit"><?php if(lang() == 'es'){echo "Filtrar";}else{echo "Filter";} ?></button></div>
							</div>
							<input name="lower" max="<?php echo $max; ?>" min="0" oninput="
							this.value=Math.min(this.value,this.parentNode.childNodes[5].value-1);
							let value = (this.value/parseInt(this.max))*100
							var children = this.parentNode.childNodes[1].childNodes;
							children[1].style.width=value+&#39;%&#39;;
							children[5].style.left=value+&#39;%&#39;;
							children[7].style.left=value+&#39;%&#39;;children[11].style.left=value+&#39;%&#39;;
							children[11].childNodes[1].innerHTML=this.value;" step="1" type="range" value="0">
							<input name="upper" max="<?php echo $max; ?>" min="0" oninput="
							this.value=Math.max(this.value,this.parentNode.childNodes[3].value-(-1));
							let value = (this.value/parseInt(this.max))*100
							var children = this.parentNode.childNodes[1].childNodes;
							children[3].style.width=(100-value)+&#39;%&#39;;
							children[5].style.right=(100-value)+&#39;%&#39;;
							children[9].style.left=value+&#39;%&#39;;children[13].style.left=value+&#39;%&#39;;
							children[13].childNodes[1].innerHTML=this.value;" step="1" type="range" value="<?php echo $max; ?>">
						</div>
					</form>
				</div>
			</div> 
			<div class="categories-sidebar__item">
				<h2 class="categories-sidebar__title">
					<?php if(lang() == 'es'){echo "Talla";}else{echo "Size";} ?>
				</h2>
				<div class="categories-sidebar__list">
					<?php
					global $wpdb;
					$product_categories = get_categories( array( 'taxonomy' => $sizetalla, 'orderby' => 'menu_order', 'order' => 'asc' ));  
					?>                                                        
					<?php foreach($product_categories as $category): ?>
						<?php $checked =NULL;  if ($category->slug == $_GET['cat']) { $checked = "checked='checked'"; } $categoria = $category->name; $category_id = $category->term_id; $category_link = get_category_link( $category_id ); ?> 				
						<label>
							<a href="<?php echo $urlsinparametros.'/?cat='.$category->slug.'&tax='.$sizetalla.'';?>"><?= $categoria ?>
								<input <?php echo $checked; ?> name="radio" type="radio">
								<span class="checkmark"></span>
							</a>		
						</label>
						<?php $i=$i+1;?>
					<?php endforeach; ?>					
				</div>
			</div>
			<div class="categories-sidebar__item">
				<h2 class="categories-sidebar__title">
					<?php if(lang() == 'es'){echo "Categorías";}else{echo "Categories";} ?>
				</h2>
				<div class="categories-sidebar__list">
					<?php
					global $wpdb;
					$product_categories = get_categories( array( 'taxonomy' => 'product_cat', 'orderby' => 'menu_order', 'order' => 'asc' ));  
					?>                                                        
					<?php foreach($product_categories as $category): ?>
						<?php $checked =NULL;  if ($category->slug == $_GET['cat']) { $checked = "checked='checked'"; } $categoria = $category->name; $category_id = $category->term_id; $category_link = get_category_link( $category_id ); ?> 				
						<?php if ($category_name == NULL) { ?>		
						<label>
							<a href="<?php echo $urlsinparametros.'/?cat='.$category->slug.'&tax=product_cat'?>"><?= $categoria ?>
								<input <?php echo $checked; ?> name="radio" type="radio">
								<span class="checkmark"></span>
							</a>
						</label>
						<?php } 
						else { ?>		
						<label>
							<a href="<?php echo get_category_link( $category->term_id ); ?>"><?= $categoria ?>
								<input <?php echo $checked; ?> name="radio" type="radio">
								<span class="checkmark"></span>
							</a>
						</label>
						<?php } ?>						
					<?php endforeach; ?>
				</div>
			</div>
			<div class="categories-sidebar__item">
				<h2 class="categories-sidebar__title">
					<?php if(lang() == 'es'){echo "Color / Estampado";}else{echo "Color / Pattern";} ?>
				</h2>
				<div class="categories-sidebar__list">
					<?php
					global $wpdb;
					$product_categories = get_categories( array( 'taxonomy' => $colorpattern, 'orderby' => 'menu_order', 'order' => 'asc' ));  
					?>                                                        
					<?php foreach($product_categories as $category): ?>
						<?php $checked = NULL; $categoria = $category->name; $category_id = $category->term_id; $category_link = get_category_link( $category_id ); ?> 
						<?php 
						if ($category->slug == $_GET['cat']) { $checked = "checked='checked'"; }
						global $wpdb;
						$count = 0;
						$result1 = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."termmeta where term_id = '$category_id' and meta_key = '$pa_color_swatches'");
						foreach ( $result1 as $page1 )
							{  $color = $page1->meta_value;}
						?>				
						<li>
							<a href="<?php echo $urlsinparametros.'/?cat='.$category->slug.'&tax='.$colorpattern.'';?>"><?= $categoria ?>
							    <input <?php echo $checked; ?> name="radio" type="radio">
								<span style="background: <?php echo $color; ?>">&nbsp;</span>
							</a>
						</li>
					<?php endforeach; ?>		
				</div>
			</div>
			<div class="categories-sidebar__item">
				<h2 class="categories-sidebar__title">
					<?php if(lang() == 'es'){echo "Silueta";}else{echo "Silhouette";} ?>
				</h2>
				<div class="categories-sidebar__list">
					<?php
					global $wpdb;
					$product_categories = get_categories( array( 'taxonomy' => $siluet, 'orderby' => 'menu_order', 'order' => 'asc' ));  
					?>                                                        
					<?php foreach($product_categories as $category): ?>
						<?php $checked = NULL; $categoria = $category->name; $category_id = $category->term_id; $category_link = get_category_link( $category_id ); 
						if ($category->slug == $_GET['cat']) { $checked = "checked='checked'"; }?> 
						<label>
							<a href="<?php echo $urlsinparametros.'/?cat='.$category->slug.'&tax='.$siluet.''?>"><?= $categoria ?>
								<input <?php echo $checked; ?> name="radio" type="radio">
								<span class="checkmark"></span>
							</a>
						</label>
					<?php endforeach; ?> 		
				</div>
				<?php // get_template_part('sections/products/medidas'); ?>
<!-- Medidas -->
<div class="categories-sidebar__size">
	<img src="<?php echo get_template_directory_uri();?>/assets/img/categorie/size.png">
	<div class="categories-sidebar__text">
		<p><?php if(lang() == 'es'){echo "Tabla de medidas de <br> acuerdo con tu cuerpo";}else{echo "Measurement table <br> according to your body";} ?></p>
		<a data-target="#exampleModal" data-toggle="modal"><?php if(lang() == 'es'){echo "VER MÁS";}else{echo "SEE MORE";} ?></a>
	</div>
	<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade modal-size" id="exampleModal" role="dialog" tabindex="-1">
		<div class="modal-dialog" role="document">
        <?php if (terms_silueta( terms_id( $_GET["cat"] ) ) == "pa_silueta" OR terms_silueta( terms_id( $_GET["cat"] ) ) == "pa_silhouette") { ?>
            <div class="modal-content" style="background-image: url(<?php echo termmeta_value_img( 'image_banner_categories', terms_id( $_GET["cat"] ) ); ?>);">
        <?php }else { ?>
	        <div class="modal-content">
	    <?php } ?>			
				<button aria-label="Close" class="close" data-dismiss="modal" type="button">
					<span aria-hidden="true">×</span>
				</button>
				<div class="modal-body">
			
		
				</div>
			</div>
		</div>
	</div>
</div>
				
			</div>
		</div>
		<div class="categories-product">
			<div class="categories-product__header">
				<div class="categories-product__view">
					<p>
						<?php if(lang() == 'es'){echo "VER COMO";}else{echo "VIEW AS";} ?>
					</p>

					<!-- Nav tabs -->
					<ul class="nav " id="myTab" role="tablist">
						<li class="nav-item">
							<a class=" active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><img src="<?php echo get_template_directory_uri();?>/assets/img/categorie/grid.png"></a>
						</li>
						<li class="nav-item">
							<a class="" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><img src="<?php echo get_template_directory_uri();?>/assets/img/categorie/open-menu.png"></a>
						</li>
					</ul>

				</div>
				<div class="categories-product__order">
					<form class="woocommerce-ordering" method="get">
						<select name="orderby" class="orderby" aria-label="Shop order">
							<option selected="selected" ><?php if(lang() == 'es'){echo "ORDENAR POR";}else{echo "SORT BY";} ?></option>
							<option value="menu_order" <?php echo $selectm ?>><?php if(lang() == 'es'){echo "Por defecto";}else{echo "Default sorting";} ?></option>
							<option value="popularity" <?php echo $selectp ?>><?php if(lang() == 'es'){echo "Por popularidad";}else{echo "Sort by popularity";} ?></option>
							<option value="rating" <?php echo $selectr ?>><?php if(lang() == 'es'){echo "Por calificación promedio";}else{echo "Sort by average rating";} ?></option>
							<option value="date" <?php echo $selectd ?>><?php if(lang() == 'es'){echo "Por último";}else{echo "Sort by latest";} ?></option>
							<option value="price" <?php echo $selectpr ?>><?php if(lang() == 'es'){echo "Por precio: de menor a mayor";}else{echo "Sort by price: low to high";} ?></option>
							<option value="price-desc" <?php echo $selectpr_desc ?>><?php if(lang() == 'es'){echo "Por precio: de mayor a menor";}else{echo "Sort by price: high to low";} ?></option>
						</select>
					</form>  					
				</div>
			</div>



			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">

					<div class="categorie-product__grid">
						<?php $loop = new WP_Query( $args ); ?>
						<?php while ( $loop->have_posts() ) : $loop->the_post(); global $product;?>			
							<div class="main-products__item">
								<div class="main-products__img">
									<div class="main-products__mask">
										<div class="main-products__icon">
											<?php if (variation(get_the_ID()) <= 0){ ?>
											<a href="?add-to-cart=<?php echo get_the_ID(); ?>">
												<img src="<?php echo get_template_directory_uri();?>/assets/img/card.png">
											</a>
											<?php } ?>  
											<?php if (variation(get_the_ID()) > 0){ ?>	
											<a href="<?php the_permalink(); ?>">
												<img src="<?php echo get_template_directory_uri();?>/assets/img/card.png">
											</a>
											<?php } ?> 
											<?php if (is_user_logged_in()){ ?>               							
											<a href="?add_to_wishlist=<?php echo get_the_ID(); ?>">
												<img src="<?php echo get_template_directory_uri();?>/assets/img/heart.png">
											</a>
                                            <?php }else { ?>  
                                                <div data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if(lang() == 'es'){echo "Debes estar iniciar sesión";}else{echo "You must be logged";} ?>" class="collection-item__icon" >
                                                  <img src="<?php echo get_template_directory_uri();?>/assets/img/heart.png">
                                                </div>              
                                            <?php } ?>											
											<a href="<?php the_permalink(); ?>">
												<img src="<?php echo get_template_directory_uri();?>/assets/img/search.png">
											</a>
										</div>
									</div>
									<img src="<?php the_post_thumbnail_url('full');?>">
								</div>
								<div class="main-products__body">
									<a class="main-products__title" href="<?php the_permalink(); ?>">
										<?php the_title();?>
									</a>
									<p class="main-products__categorie">
										<?php if(lang() == 'es'){echo "categoría: ";}if(lang() == 'en'){echo "category: ";}  
										$product_categories = wp_get_post_terms( get_the_ID(), 'product_cat' ); $i = 0;
										foreach($product_categories as $category):
											if ($i > 0 ) {echo " / "; } echo $category->name; $i=$i+1;
										endforeach;?>

									</p>
									<p class="main-products__price">
										<?php echo $product->get_price_html(); ?>
									</p>
									<a class="main-general__button" href="<?php the_permalink(); ?>"><?php if(lang() == 'es'){echo "Comprar";}if(lang() == 'en'){echo "To buy";}?></a>
								</div>
							</div>
						<?php endwhile; ?>  	
					</div>


				</div>
				<div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<?php $loop = new WP_Query( $args ); ?>
					<?php while ( $loop->have_posts() ) : $loop->the_post(); global $product;?>             
						<div class="list_div" id="view" style="display:">
							<table class="shop_table cart wishlist_table wishlist_view traditional responsive  list_table " data-pagination="no" data-per-page="5" data-page="1" data-id="5" data-token="6OL1RPFP5C1P">  
								<tbody class="wishlist-items-wrapper list">
									<tr id="yith-wcwl-row-20 " class="list-product" data-row-id="20">        
										<td class="product-thumbnail list">
											<a href="<?php the_permalink(); ?>">
												<img class="list" src="<?php the_post_thumbnail_url('full'); ?>">          
											</a> 
											<table class="list_table">
												<tr>
													<td class="listt"> <a href="<?php the_permalink(); ?>" class="collection-item__title list"><?php the_title(); ?></a></td>
												</tr>
												<tr>
													<td class="listd"><p class="main-products__categorie"><?php if(lang() == 'es'){echo "Categoría: ";}if(lang() == 'en'){echo "Category: ";}  
														$product_categories = wp_get_post_terms( get_the_ID(), 'product_cat' ); $i = 0;
														foreach($product_categories as $category):
															if ($i > 0 ) {echo " / "; } echo $category->name; $i=$i+1;
														endforeach;?></p></td>
												</tr>          
											</table>                         
										</td>  
										<td class="product-price list">              
											<span class="woocommerce-Price-amount amount list"><?php echo $product->get_price_html(); ?>
											</td>
											<td class="product-add-to-cart list">
												<span>
													<?php if (variation(get_the_ID()) <= 0){ ?>
													<a href="?add-to-cart=<?php echo get_the_ID(); ?>"><img src="<?php echo get_template_directory_uri();?>/assets/img/card.png"></a>
													<?php } ?>  
													<?php if (variation(get_the_ID()) > 0){ ?>
													<a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri();?>/assets/img/card.png"></a>
													<?php } ?> 
													<a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri();?>/assets/img/search.png"></a> 
													<?php if (is_user_logged_in()){ ?>   
													   <a href="?add_to_wishlist=<?php echo get_the_ID(); ?>"><img src="<?php echo get_template_directory_uri();?>/assets/img/heart.png"></a>  
															<?php }else { ?>  
															<div data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if(lang() == 'es'){echo "Debes estar iniciar sesión";}else{echo "You must be logged";} ?>" class="collection-item__icon" >
																<img src="<?php echo get_template_directory_uri();?>/assets/img/heart.png">
															</div>              
															<?php } ?>
												</span>             
											</td>                    
										</tr>    
									</tbody>
								</table>
							</div>
						<?php endwhile; ?>        	
					</div>
				</div>

				<?php
            //$published_posts = wp_count_posts()->publish;
				$published_posts = count_post_product($_GET["cat"],$_GET["tax"],$_GET["lower"],$_GET["upper"],$category_name,$page_name);
           // $posts_per_page = get_option('posts_per_page');
				$posts_per_page = 12;
				$page_number_max = ceil($published_posts / $posts_per_page);
				$max_page = $page_number_max;
				if (!$paged && $max_page >= 1) {
					$current_page = 1;
				}
				else {
					$current_page = $paged;
				} ?>     


				<div class="categories-paginator">
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
									"next_text" => __('<img src="'.get_template_directory_uri().'/assets/img/categorie/next-2.png">'),
									"prev_text" => __('<img src="'.get_template_directory_uri().'/assets/img/categorie/prev-2.png">'),
									)); ?>
								</div>
							</div>
						</div>
					</div>


				</div>
			</div>
		</section>

		<style type="text/css">
			a.page-numbers {
				width: 42px;
				background: #fff;
				height: 42px;
				margin: 0 5px;
				border: 2px solid #dfdfdf;
				font-size: 15px;
				font-weight: 600;
				color: #161616;
				display: flex;
				justify-content: center;
				align-items: center;
			}
			span.page-numbers.current {
				background: #161616;
				color: #fff;
				border: #000;
				width: 42px;
				/* background: #fff; */
				height: 42px;
				margin: 0 5px;
				/* border: 2px solid #dfdfdf; */
				font-size: 15px;
				font-weight: 600;
				/* color: #ffffff; */
				display: flex;
				justify-content: center;
				align-items: center;
			}
			.suf-page-nav.fix {
				width: 100%;
				justify-content: center;
				display: flex;
				/* margin-top: 81px; */
			}	
			a.prev.page-numbers img {
				width: 18px;
				height: 18px;
				object-fit: contain;
			}
			a.next.page-numbers img {
				width: 18px;
				height: 18px;
				object-fit: contain;
			}
			table.shop_table.cart.wishlist_table.wishlist_view.traditional.responsive.list_table {
				border: solid 1px #d7d3cd;
				margin-bottom: 20px;
				width: 100%;
			}

			.wishlist_table .product-add-to-cart a>img {
				max-width: 23px;
    margin: 5px;
			}
			.wishlist_table tr td.product-thumbnail a {
				max-width:118px;
			}
			.listt {
				padding: 0!important;
			}

			.listt a {
				max-width: 100%!important;
				font-size: 15px;
    font-weight: 600;
    letter-spacing: 3px;
    color: #161616;
		margin-bottom: 2px;
		text-align: initial;
		display: -webkit-box;
  display: -moz-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  -moz-box-orient: vertical;
  overflow: hidden;			}

			.listd {
				padding: 0!important;

			}

			.list-product {
				display: grid;
		grid-template-columns: 50% 1fr 1fr;
		width: 100%;
			}

			.listd p {
				display: -webkit-box;
  display: -moz-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  -moz-box-orient: vertical;
  overflow: hidden;
				text-align: initial;
			}
		.product-add-to-cart.list > span {
				display: flex;
			} 

			.list_table {
				margin-left: 15px;
			}

			.wishlist_table .product-add-to-cart a {
				border: none!important;
				background-color: transparent!important;
			}

			.list_div table {
		    margin-left: 10px;

			}

			.product-price>.list del {
				text-decoration: line-through!important;
			}

			.list {
				display: flex;
				text-align: center;
    /* justify-content: center; */
    align-items: center;
			}

			@media (min-width: 768px) and (max-width: 997px) {

				.list-product {	
		grid-template-columns: 1fr 1fr 1fr;
		width: 100%;
			}

		}
			@media (min-width: 0px) and (max-width: 767px) {

.list-product {	
grid-template-columns: 100%;
width: 100%;
}
}


			
		</style>

<?php get_footer(); 

}
?>
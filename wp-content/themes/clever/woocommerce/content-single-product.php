<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<section class="product-details padding-left-right">

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
<?php $product_categories_en = wp_get_post_terms( get_the_ID(), 'pa_silhouette' )[0]->term_id; ?>
<?php $product_categories_es = wp_get_post_terms( get_the_ID(), 'pa_silueta' )[0]->term_id; ?>
	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
    <div class="nav-content-product">
    </div>

    <div class="categories-paginator next-product" style="margin-top:0px !important">
      <div class='dcms-prev categories-paginator__item'><?php echo previous_post_link( '%link', '<i class="fa fa-angle-left"></i>
', '' ,'product_cat' );?></div>
      <div class='dcms-next categories-paginator__item'><?php echo next_post_link( '%link', '<i class="fa fa-angle-right"></i>
', '' , 'product_cat' ); ?> </div>

    </div> 

		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		?>
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
        <?php if($product_categories_en != NULL OR $product_categories_es != NULL){ ?>
            <?php if(lang() == 'es'){ ?>
                <div class="modal-content" style="background-image: url(<?php echo termmeta_value_img( 'image_banner_categories', $product_categories_es ); ?>);">
            <?php } ?> 
            <?php if(lang() == 'en'){ ?>
                <div class="modal-content" style="background-image: url(<?php echo termmeta_value_img( 'image_banner_categories', $product_categories_en ); ?>);">
            <?php } ?>               
        <?php }else { ?>
	        <div class="modal-content">
	    <?php } ?>			
				<button aria-label="Close" class="close" data-dismiss="modal" type="button">
					<span aria-hidden="true">×</span>
				</button>
				<div class="modal-body">
					<h2 class="modal-size__title">
						<?php if(lang() == 'es'){echo "Tabla de <br><span>Medidas</span>";}else{echo "measurement <br><span>table</span>";} ?>
					</h2>
					<div class="modal-size-tab">
						<img src="<?php echo get_template_directory_uri();?>/assets/img/categorie/lines.png">
						<p class="modal-size__header">
							<?php if(lang() == 'es'){echo "Prendas inferiores";}else{echo "Lower garments";} ?>
						</p>
						<div class="modal-size__ref">
							<div class="modal-size__item">
								<p><?php if(lang() == 'es'){echo "Categorías";}else{echo "Categories";} ?></p>
							</div>
							<div class="modal-size__item">
								<p>S</p>
							</div>
							<div class="modal-size__item">
								<p>M</p>
							</div>
							<div class="modal-size__item">
								<p>L</p>
							</div>
							<div class="modal-size__item">
								<p>XL</p>
							</div>
						</div>
						<div class="modal-size__row">
							<div class="modal-size__row--item">
								<p><?php if(lang() == 'es'){echo "Cintura";}else{echo "Waist";} ?></p>
							</div>
							<div class="modal-size__row--item">
								<p>28-30</p>
							</div>
							<div class="modal-size__row--item">
								<p>30-32</p>
							</div>
							<div class="modal-size__row--item">
								<p>32-36</p>
							</div>
							<div class="modal-size__row--item">
								<p>34-36</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

	<!-- <?php//
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	//do_action( 'woocommerce_after_single_product_summary' );
	?> -->
</div>
<?php //do_action( 'woocommerce_after_single_product' ); ?>
</section>



	<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade modal-size" id="exampleModal" role="dialog" tabindex="-1">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button">
					<span aria-hidden="true">×</span>
				</button>
				<div class="modal-body">
					<h2 class="modal-size__title">
						<?php if(lang() == 'es'){echo "Tabla de <br><span>Medidas</span>";}else{echo "measurement <br><span>table</span>";} ?>
					</h2>
					<div class="modal-size-tab">
						<img src="<?php echo get_template_directory_uri();?>/assets/img/categorie/lines.png">
						<p class="modal-size__header">
							<?php if(lang() == 'es'){echo "Prendas inferiores";}else{echo "Lower garments";} ?>
						</p>
						<div class="modal-size__ref">
							<div class="modal-size__item">
								<p><?php if(lang() == 'es'){echo "Categorías";}else{echo "Categories";} ?></p>
							</div>
							<div class="modal-size__item">
								<p>S</p>
							</div>
							<div class="modal-size__item">
								<p>M</p>
							</div>
							<div class="modal-size__item">
								<p>L</p>
							</div>
							<div class="modal-size__item">
								<p>XL</p>
							</div>
						</div>
						<div class="modal-size__row">
							<div class="modal-size__row--item">
								<p><?php if(lang() == 'es'){echo "Cintura";}else{echo "Waist";} ?></p>
							</div>
							<div class="modal-size__row--item">
								<p>28-30</p>
							</div>
							<div class="modal-size__row--item">
								<p>30-32</p>
							</div>
							<div class="modal-size__row--item">
								<p>32-36</p>
							</div>
							<div class="modal-size__row--item">
								<p>34-36</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


<script type="text/javascript">
  $('.woocommerce-breadcrumb').appendTo('.nav-content-product');
    var langu = "<?= lang() ?>";  
    var url = "<?= get_home_url() ?>";       
    if (langu == 'en'){ 
       var url_en = "<?= get_home_url() ?>/cart";   
       $('.woocommerce-message a').prop('href', url_en);
    } 
    else 
    {
       var url_es = "<?= get_home_url() ?>/carrito";
       $('.woocommerce-message a').prop('href', url_es);
    }  
</script>

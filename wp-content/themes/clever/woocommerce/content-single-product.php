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
//do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<section class="product-details padding-left-right">

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

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
	<div class="categories-sidebar__size">
            <img src="<?php echo get_template_directory_uri();?>/assets/img/categorie/size.png">
            <div class="categories-sidebar__text">
              <p>
                Tabla de medidas de
                <br> acuerdo con tu cuerpo
              </p>
              <a data-target="#exampleModal" data-toggle="modal">VER MÁS</a>
            </div>
            <!-- Modal -->
            <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade modal-size" id="exampleModal"
              role="dialog" tabindex="-1">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">×</span>
                  </button>
                  <div class="modal-body">
                    <h2 class="modal-size__title">
                      Tabla de
                      <br>
                      <span>
                        Medidas
                      </span>
                    </h2>
                    <div class="modal-size-tab">
                      <img src="<?php echo get_template_directory_uri();?>/assets/img/categorie/lines.png">
                      <p class="modal-size__header">
                        Prendas inferiores
                      </p>
                      <div class="modal-size__ref">
                        <div class="modal-size__item">
                          <p>Tallas</p>
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
                          <p>Cintura</p>
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

<script type="text/javascript">
  $('.woocommerce-breadcrumb').appendTo('.nav-content-product');
</script>

<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
 <section class="banner-small banner-catalogo">
    <img class="banner-small__img" src="<?php echo get_template_directory_uri();?>/assets/img/cart.png">
    <div class="banner-small__text">
      <p class="banner-small__title--small">
        Clever style
      </p>
      <h2 class="banner-small__title">
			Carrito de compra
      </h2>
    </div>
  </section>

<div class="padding-left-right checkout-custom">
	<?php echo do_shortcode('[woocommerce_cart]'); ?>
</div>

<?php get_footer();?>
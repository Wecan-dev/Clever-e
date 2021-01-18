<?php
/**
 * Carousel next button template
 *
 * This template can be overridden by copying it to yourtheme/wp-grid-builder/templates/carousel/next-button.php.
 *
 * Template files can change and you will need to copy the new files to your theme to
 * maintain compatibility.
 *
 * @package   wp-grid-builder/templates
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 * @version   1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<button type="button" class="wpgb-next-button" aria-label="<?php esc_attr_e( 'Next slide', 'wp-grid-builder' ); ?>" hidden>
	<?php wpgb_svg_icon( 'wpgb/arrows/arrow-right' ); ?>
</button>
<?php

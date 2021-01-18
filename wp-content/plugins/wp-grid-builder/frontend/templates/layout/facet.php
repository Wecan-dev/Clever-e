<?php
/**
 * Facet template
 *
 * This template can be overridden by copying it to yourtheme/wp-grid-builder/templates/layout/facet.php.
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

if ( empty( $wpgb_template['html'] ) ) {
	return;
}

$legend = $wpgb_template['title'] ?: $wpgb_template['name'];

if ( ! empty( $wpgb_template['title'] ) ) {

	?>
	<h4 class="wpgb-facet-title"><?php echo esc_html( $wpgb_template['title'] ); ?></h4>
	<?php

}

if ( 'load' !== $wpgb_template['action'] ) {

	?>
	<fieldset>
		<legend class="wpgb-facet-title wpgb-sr-only"><?php echo esc_html( $legend ); ?></legend>
		<?php echo $wpgb_template['html']; // WPCS: XSS ok. ?>
	</fieldset>
	<?php

} else {
	echo $wpgb_template['html']; // WPCS: XSS ok.
}

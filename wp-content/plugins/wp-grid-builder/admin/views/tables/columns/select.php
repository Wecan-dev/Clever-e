<?php
/**
 * Table select field
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

use WP_Grid_Builder\Includes\Helpers;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="wpgb-list-table-column" data-colname="select">
	<input type="checkbox" id="<?php echo esc_attr( 'wpgb-' . $this->item['id'] ); ?>" class="wpgb-input wpgb-select-item wpgb-sr-only" name="<?php echo esc_attr( $this->table ); ?>[]" value="<?php echo esc_attr( $this->item['id'] ); ?>">
	<label for="<?php echo esc_attr( 'wpgb-' . $this->item['id'] ); ?>">
		<span>
			<?php
			/* translators: %s: $name Grid name */
			echo esc_html( sprintf( 'Select %s', $this->item['name'] ), 'wp-grid-builder' );
			?>
		</span>
		<?php Helpers::get_icon( 'check' ); ?>
	</label>
</div>
<?php

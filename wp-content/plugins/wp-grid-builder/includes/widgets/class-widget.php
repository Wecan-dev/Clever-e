<?php
/**
 * Widget Helper
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\Includes\Widgets;

use WP_Grid_Builder\Includes\Database;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Widget Helper
 *
 * @class WP_Grid_Builder\Includes\Widgets\Widget
 * @since 1.0.0
 */
class Widget {

	/**
	 * Holds all grids
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array
	 */
	protected static $grids;

	/**
	 * Holds all facets
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array
	 */
	protected static $facets;

	/**
	 * Get facets
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $object Object type to query.
	 * @return array
	 */
	public static function get( $object ) {

		if ( self::${$object} ) {
			return self::${$object};
		}

		self::${$object} = Database::query_results(
			[
				'select'  => 'id, name',
				'from'    => $object,
				'orderby' => 'modified_date',
			]
		);

		return self::${$object};

	}

	/**
	 * Output grids or facets select list
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $label    Field label.
	 * @param string $id       Field id.
	 * @param string $name     Field name.
	 * @param string $object   Object type to list..
	 * @param mixed  $selected Selected value.
	 */
	public static function output_list( $label, $id, $name, $object, $selected ) {

		echo '<p>';
		echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
		echo '<select id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" style="width:100%">';

		foreach ( self::${$object} as $item ) {

			printf(
				'<option value="%d" %s>%s</option>',
				esc_attr( absint( $item['id'] ) ),
				selected( absint( $item['id'] ), absint( $selected ), false ),
				esc_html( $item['name'] )
			);

		}

		echo '</select>';
		echo '</p>';

	}
}

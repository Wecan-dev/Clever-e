<?php
/**
 * Checkbox facet
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\FrontEnd\Facets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Checkbox
 *
 * @class WP_Grid_Builder\FrontEnd\Facets\Checkbox
 * @since 1.0.0
 */
class Checkbox {

	/**
	 * Rendered items counter
	 *
	 * @since 1.0.0
	 * @var integer
	 */
	public $count = 0;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {}

	/**
	 * Query facet choices
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet Holds facet settings.
	 * @return array Holds facet items.
	 */
	public function query_facet( $facet ) {

		// Only one query needed if no facets selected.
		if ( ! wpgb_has_selected_facets() ) {
			return $this->get_facet_items( $facet, false );
		}

		// If we do not show empty items and do not order by item count.
		// In these cases order does not rely on unfiltered facet order.
		if ( ! $facet['show_empty'] && 'count' !== $facet['orderby'] ) {
			return $this->get_facet_items( $facet );
		}

		// If show empty items or count order.
		return $this->merge_facets(
			$this->get_facet_items( $facet ),
			$this->get_facet_items( $facet, false )
		);

	}

	/**
	 * Query facet items from object ids
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array   $facet Holds facet settings.
	 * @param boolean $filtered Where clause state.
	 * @return array Holds facet items.
	 */
	public function get_facet_items( $facet, $filtered = true ) {

		global $wpdb;

		$order_clause = wpgb_get_orderby_clause( $facet );

		if ( $filtered ) {
			$where_clause = wpgb_get_filtered_where_clause( $facet, $facet['logic'] );
		} else {
			$where_clause = wpgb_get_unfiltered_where_clause();
		}

		$facet_values = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT facet_name, facet_value, facet_id, facet_parent, COUNT(DISTINCT object_id) AS count
				FROM {$wpdb->prefix}wpgb_index
				WHERE slug = %s
				AND $where_clause
				GROUP BY facet_value
				ORDER BY $order_clause
				LIMIT %d",
				$facet['slug'],
				$facet['limit']
			)
		); // WPCS: unprepared SQL ok.

		return $facet_values;

	}

	/**
	 * Merge facet items
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $filtered_facet   Holds filtered facet items.
	 * @param array $unfiltered_facet Holds unfiltered facet items.
	 * @return array Holds facet items.
	 */
	public function merge_facets( $filtered_facet, $unfiltered_facet ) {

		$filtered   = [];
		$unfiltered = [];

		// Rebuild filtered facet items with value as key.
		foreach ( $filtered_facet as $item ) {
			// Key as string (in case it's an integer) to preserve order.
			$filtered[ '_' . $item->facet_value ] = $item;
		}

		// Rebuild unfiltered facet items with value as key.
		foreach ( $unfiltered_facet as $item ) {
			$unfiltered[ '_' . $item->facet_value ] = $item;
		}

		// Preserve filtered item count.
		$facet = array_map(
			function( $item ) use ( $filtered ) {

				$facet_value = '_' . $item->facet_value;
				$is_filtered = isset( $filtered[ $facet_value ] );
				$item->count = $is_filtered ? $filtered[ $facet_value ]->count : 0;

				return $item;

			},
			$unfiltered
		);

		return array_values( $facet );

	}

	/**
	 * Render facet
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet Holds facet settings.
	 * @param array $items Holds facet items.
	 * @return string Facet markup.
	 */
	public function render_facet( $facet, $items ) {

		$list = $this->render_list( $facet, $items );

		if ( empty( $list ) ) {
			return;
		}

		$output  = '<div class="wpgb-checkbox-facet">';
		$output .= $list;
		$output .= '</div>';

		return $output;

	}

	/**
	 * Render list
	 *
	 * @since 1.2.0 Handle shortcode [number] in button label.
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array   $facet  Holds facet settings.
	 * @param array   $items  Holds facet items.
	 * @param integer $parent Parent id to process children.
	 * @return string List markup.
	 */
	public function render_list( $facet, $items, $parent = 0 ) {

		$list = '';

		foreach ( $items as $index => $item ) {

			// If hierarchical list and is not a child item.
			if ( $facet['hierarchical'] && (int) $item->facet_parent !== (int) $parent ) {
				continue;
			}

			// Hide Children if not hierarchical list.
			if ( ! $facet['hierarchical'] && ! $facet['children'] && (int) $item->facet_parent > 0 ) {
				continue;
			}

			// Hide empty item if allowed.
			if ( ! $facet['show_empty'] && ! $item->count ) {
				continue;
			}

			$hidden = $this->count >= $facet['display_limit'] ? ' hidden' : '';

			$list .= '<li' . esc_attr( $hidden ) . '>';
			$list .= $this->render_checkbox( $facet, $item );

			// Count rendered items.
			$this->count++;

			// Recursively get children.
			if ( $facet['hierarchical'] ) {
				$list .= $this->render_list( $facet, $items, $item->facet_id );
			}

			$list .= '</li>';

			unset( $items[ $index ] );

		}

		if ( empty( $list ) ) {
			return;
		}

		$output  = '<ul class="wpgb-hierarchical-list">';
		$output .= $list;
		$output .= '</ul>';

		if ( 0 === $parent && $this->count > $facet['display_limit'] ) {

			$output .= '<button type="button" class="wpgb-toggle-hidden" aria-expanded="false">';
			$output .= esc_html( str_replace( '[number]', $this->count - $facet['display_limit'], $facet['show_more_label'] ) );
			$output .= '</button>';

		}

		return $output;

	}

	/**
	 * Render Checkbox
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet Holds facet settings.
	 * @param array $item  Holds current list item.
	 * @return string Checkbox item markup.
	 */
	public function render_checkbox( $facet, $item ) {

		$disabled = ! isset( $item->count ) ? false : ! $item->count;
		$checked  = in_array( $item->facet_value, $facet['selected'], true );
		$pressed  = $checked ? 'true' : 'false';
		$tabindex = $disabled ? -1 : 0;

		$output = '<div class="wpgb-checkbox" role="button" aria-pressed="' . esc_attr( $pressed ) . '" tabindex="' . esc_attr( $tabindex ) . '">';
			$output .= $this->render_input( $facet, $item, $disabled );
			$output .= '<span class="wpgb-checkbox-control"></span>';
			$output .= '<span class="wpgb-checkbox-label">';
				$output .= esc_html( $item->facet_name );
				$output .= $facet['show_count'] ? '&nbsp;<span>(' . (int) $item->count . ')</span>' : '';
			$output .= '</span>';
		$output .= '</div>';

		return apply_filters( 'wp_grid_builder/facet/checkbox', $output, $facet, $item );

	}

	/**
	 * Render checkbox input
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array   $facet    Holds facet settings.
	 * @param array   $item     Holds current list item.
	 * @param boolean $disabled Input disabled state.
	 * @return string Checkbox input markup.
	 */
	public function render_input( $facet, $item, $disabled ) {

		return sprintf(
			'<input type="hidden" name="%1$s[]" value="%2$s"%3$s>',
			esc_attr( $facet['slug'] ),
			esc_attr( $item->facet_value ),
			disabled( $disabled, true, false )
		);

	}

	/**
	 * Query object ids (post, user, term) for selected facet values
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet Holds facet settings.
	 * @return array Holds queried facet object ids.
	 */
	public function query_objects( $facet ) {

		global $wpdb;

		$object_ids = [];
		$values = $facet['selected'];

		if ( 'OR' === $facet['logic'] ) {

			$placeholders = rtrim( str_repeat( '%s,', count( $values ) ), ',' );

			return $wpdb->get_col(
				$wpdb->prepare(
					"SELECT DISTINCT object_id
					FROM {$wpdb->prefix}wpgb_index
					WHERE slug = %s
					AND facet_value IN ($placeholders)",
					array_merge( (array) $facet['slug'], $values )
				)
			); // WPCS: unprepared SQL ok.

		}

		// Making several queries is faster than using one query with HAVING clause.
		foreach ( $values as $index => $value ) {

			$results = $wpdb->get_col(
				$wpdb->prepare(
					"SELECT DISTINCT object_id
					FROM {$wpdb->prefix}wpgb_index
					WHERE slug = %s
					AND facet_value IN (%s)",
					$facet['slug'],
					$value
				)
			);

			$object_ids = $index > 0 ? array_intersect( $object_ids, $results ) : $results;

			if ( empty( $object_ids ) ) {
				break;
			}
		}

		return $object_ids;

	}
}

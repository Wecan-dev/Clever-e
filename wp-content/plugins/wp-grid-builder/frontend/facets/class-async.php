<?php
/**
 * Handle asynchronous facet
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
 * Async
 *
 * @class WP_Grid_Builder\FrontEnd\Facets\Async
 * @since 1.0.0
 */
class Async {

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

		if ( ! wpgb_has_selected_facets() ) {
			$items = $this->get_facet_items( $facet, false );
		} elseif ( ! $facet['show_empty'] ) {
			$items = $this->get_facet_items( $facet );
		} else {

			$items = $this->merge_facets(
				$this->get_facet_items( $facet ),
				$this->get_facet_items( $facet, false )
			);

		}

		return $this->normalize( $facet, $items );

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

		// Make sure we can select any value if single selection.
		if ( ! $facet['multiple'] ) {
			$facet['logic'] = 'OR';
		}

		$order_clause = wpgb_get_orderby_clause( $facet );

		if ( $filtered ) {
			$where_clause = wpgb_get_filtered_where_clause( $facet, $facet['logic'] );
		} else {
			$where_clause = wpgb_get_unfiltered_where_clause();
		}

		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT facet_name, facet_value, COUNT(DISTINCT object_id) AS count
				FROM {$wpdb->prefix}wpgb_index
				WHERE slug = %s
				AND $where_clause
				AND facet_name LIKE %s
				GROUP BY facet_name
				ORDER BY $order_clause
				LIMIT %d",
				$facet['slug'],
				'%' . $wpdb->esc_like( $facet['search'] ) . '%',
				$facet['limit']
			)
		); // WPCS: unprepared SQL ok.

	}

	/**
	 * Normalize facet length and name
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array   $facet Holds facet settings.
	 * @param boolean $items Hold facet items.
	 * @return array Holds facet items.
	 */
	public function normalize( $facet, $items ) {

		$count = $facet['show_count'];
		$items = array_slice( $items, 0, $facet['limit'] );

		return array_map(
			function( $item ) use ( $count ) {

				// Item value is used in combobox and added with .textContent method in JS so we need to decode.
				$item->facet_name  = html_entity_decode( esc_html( $item->facet_name ), ENT_QUOTES, 'UTF-8' );
				$item->facet_name .= $count ? ' (' . (int) $item->count . ')' : '';
				return $item;

			},
			$items
		);

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

		// Remove filtered values.
		$unfiltered = array_filter(
			$unfiltered,
			function( $item ) use ( $filtered ) {
				return ! isset( $filtered[ $item->facet_value ] );
			}
		);

		$facet = $filtered + $unfiltered;

		$facet = array_map(
			function( $facet ) use ( $filtered ) {

				$is_filtered = isset( $filtered[ '_' . $facet->facet_value ] );
				$facet->count = $is_filtered ? $facet->count : 0;
				$facet->disabled = ! $facet->count;

				return $facet;

			},
			$facet
		);

		return array_values( $facet );

	}

	/**
	 * Query selected facet choices
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet Holds facet settings.
	 * @return array Holds facet items.
	 */
	public function query_selected( $facet ) {

		if ( empty( $facet['selected'] ) ) {
			return [];
		}

		// Make sure we can select any value if single selection.
		if ( ! $facet['multiple'] ) {
			$facet['logic'] = 'OR';
		}

		$selected = $this->get_selected_items( $facet );

		// If no selected values found with current query.
		// Get selected values from unfiltered query.
		if ( empty( $selected ) ) {

			$selected = $this->get_selected_items( $facet, false );
			// Set count to 0 because the values do not exist initially (because of a search for example).
			$selected = array_map(
				function( $item ) {

					$item->count = 0;
					return $item;

				},
				$selected
			);

		}

		return $selected;

	}

	/**
	 * Query selected facet items from object ids
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array   $facet Holds facet settings.
	 * @param boolean $filtered Where clause state.
	 * @return array Holds facet items.
	 */
	public function get_selected_items( $facet, $filtered = true ) {

		global $wpdb;

		if ( wpgb_has_selected_facets() && $filtered ) {
			$where_clause = wpgb_get_filtered_where_clause( $facet, $facet['logic'] );
		} else {
			$where_clause = wpgb_get_unfiltered_where_clause();
		}

		$placeholders = rtrim( str_repeat( '%s,', count( $facet['selected'] ) ), ',' );

		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT facet_name, facet_value, facet_id, facet_parent, COUNT(DISTINCT object_id) AS count
				FROM {$wpdb->prefix}wpgb_index
				WHERE slug = %s
				AND $where_clause
				AND facet_value IN($placeholders)
				GROUP BY facet_value
				ORDER BY FIELD(facet_value, $placeholders)
				LIMIT %d",
				array_merge(
					(array) $facet['slug'],
					$facet['selected'],
					$facet['selected'],
					(array) count( $facet['selected'] )
				)
			)
		); // WPCS: unprepared SQL ok.

	}
}

<?php
/**
 * Selection facet
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
 * Selection
 *
 * @class WP_Grid_Builder\FrontEnd\Facets\Selection
 * @since 1.0.0
 */
class Selection {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {}

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

		$items  = '';
		$facets = $this->get_facets();

		foreach ( $facets as $slug => $facet ) {

			if ( ! $facet ) {
				continue;
			}

			$items .= $this->render_selection( $slug, $facet );

		}

		if ( empty( $items ) ) {
			return;
		}

		$output  = '<div class="wpgb-selection-facet">';
			$output .= '<ul class="wpgb-inline-list">';
				$output .= $items;
			$output .= '</ul>';
		$output .= '</div>';

		return $output;

	}

	/**
	 * Get all facets with selections
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Facet selections.
	 */
	public function get_facets() {

		// Keep selected order from query strings.
		$strings = wpgb_get_query_string();
		$strings = array_keys( $strings );
		$strings = array_flip( $strings );

		// Get facets from query string (selected facets).
		$facets = wpgb_get_facets();
		$facets = array_merge( $strings, $facets );
		$facets = array_filter( $facets );
		$facets = $this->set_selection( $facets );

		return $facets;

	}

	/**
	 * Set facet selection
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facets Holds selected facets.
	 * @return array Facet selections.
	 */
	public function set_selection( $facets ) {

		return array_map(
			function( $facet ) {

				if ( empty( $facet['selected'] ) ) {
					return;
				}

				switch ( $facet['type'] ) {
					case 'range':
						$facet['selection'] = $this->get_range_selection( $facet );
						break;
					case 'rating':
						$facet['selection'] = $this->get_rating_selection( $facet );
						break;
					case 'date':
						$facet['selection'] = $this->get_date_selection( $facet );
						break;
					case 'search':
						$facet['selection'] = $this->get_search_selection( $facet );
						break;
					default:
						$facet['selection'] = $this->get_facet_selection( $facet );
						break;
				}

				return $facet;

			},
			$facets
		);

	}

	/**
	 * Get range values
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param  array $facet Holds facet settings.
	 * @return array Holds selected facet name/value.
	 */
	public function get_range_selection( $facet ) {

		if ( empty( $facet['selected'] ) ) {
			return [];
		}

		$range = [
			min( $facet['selected'] ),
			max( $facet['selected'] ),
		];

		$range = array_unique( $range );
		$name = array_map(
			function( $value ) use ( $facet ) {
				return $facet['prefix'] . $value . $facet['suffix'];
			},
			$range
		);

		return [
			(object) [
				'facet_value' => json_encode( $range ),
				'facet_name'  => implode( ' - ', $name ),
			],
		];

	}

	/**
	 * Get rating value
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param  array $facet Holds facet settings.
	 * @return array Holds selected facet name/value.
	 */
	public function get_rating_selection( $facet ) {

		if ( empty( $facet['selected'] ) ) {
			return [];
		}

		$value = (int) reset( $facet['selected'] );
		/* translators: %d: number of stars */
		$name = _n( '%d star', '%d stars', $value, 'wp-grid-builder' );
		$name = sprintf( $name, $value );

		return [
			(object) [
				'facet_value' => $value,
				'facet_name'  => $name,
			],
		];

	}

	/**
	 * Get date values
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param  array $facet Holds facet settings.
	 * @return array Holds selected facet name/value.
	 */
	public function get_date_selection( $facet ) {

		if ( empty( $facet['selected'] ) ) {
			return [];
		}

		$value = (array) $facet['selected'];
		$format = $facet['date_format'] ?: 'Y-m-d';

		$name = array_map(
			function( $date ) use ( $format ) {
				return date_i18n( $format, strtotime( $date ) );
			},
			$value
		);

		return [
			(object) [
				'facet_value' => json_encode( $value ),
				'facet_name'  => implode( ' - ', $name ),
			],
		];

	}

	/**
	 * Get search value
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param  array $facet Holds facet settings.
	 * @return array Holds selected facet name/value.
	 */
	public function get_search_selection( $facet ) {

		if ( empty( $facet['selected'] ) ) {
			return [];
		}

		// Revert array to string.
		$value = (array) $facet['selected'];

		return [
			(object) [
				'facet_value' => json_encode( $value ),
				'facet_name'  => implode( ',', $value ),
			],
		];

	}

	/**
	 * Get facet values
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param  array $facet Holds facet settings.
	 * @return array Holds selected facet name/value.
	 */
	public function get_facet_selection( $facet ) {

		// If hide empty allowed then we need to fetch selected values from unfiltered query if missing (because of a search for example).
		if ( empty( $facet['items'] ) ) {
			$facet['items'] = ( new Async() )->get_selected_items( $facet, false );
		}

		$items  = array_column( (array) $facet['items'], null, 'facet_value' );
		$values = array_flip( $facet['selected'] );
		$values = array_intersect_key( $items, $values );

		// If nothing match, it means that facet items are not available at this stage (because of a search for example).
		// We query items from selected value in this case.
		if ( empty( $values ) && ! empty( $facet['items'] ) ) {

			$items  = ( new Async() )->get_selected_items( $facet, false );
			$values = array_column( $items, null, 'facet_value' );

		}

		return $values;

	}

	/**
	 * Render facet selections
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $slug  Prefixed facet slug.
	 * @param array $facet Holds facet settings.
	 * @return string Selection item.
	 */
	public function render_selection( $slug, $facet ) {

		$output = '';

		foreach ( $facet['selection'] as $item ) {

			$output .= '<li>';
			$output .= $this->render_button( $slug, $item );
			$output .= '</li>';

		}

		return $output;

	}

	/**
	 * Render button
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $slug Holds facet slug.
	 * @param array  $item Holds selection item.
	 * @return string Selection button markup.
	 */
	public function render_button( $slug, $item ) {

		$input = sprintf(
			'<input type="hidden" name="%1$s" value="%2$s">',
			esc_attr( $slug ),
			esc_attr( $item->facet_value )
		);

		$output  = '<div class="wpgb-button" role="button" aria-pressed="true" tabindex="0">';
			$output .= $input;
			$output .= '<span class="wpgb-button-control"></span>';
			$output .= '<span class="wpgb-button-label">' . esc_html( $item->facet_name ) . '</span>';
		$output .= '</div>';

		return apply_filters( 'wp_grid_builder/facet/selection', $output, $slug, $item );

	}
}

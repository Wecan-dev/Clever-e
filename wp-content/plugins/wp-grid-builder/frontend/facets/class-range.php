<?php
/**
 * Range facet
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
 * Range
 *
 * @class WP_Grid_Builder\FrontEnd\Facets\Range
 * @since 1.0.0
 */
class Range {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		add_filter( 'wp_grid_builder/facet/response', [ $this, 'get_settings' ], 10, 3 );

	}

	/**
	 * Filter facet response to set range settings
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @param array $response Holds facet response.
	 * @param array $facet    Holds facet settings.
	 * @param array $items    Holds facet items.
	 * @return array
	 */
	public function get_settings( $response, $facet, $items ) {

		// Skip other facets or if already set.
		if ( 'range' !== $facet['type'] || isset( $facet['settings']['rightToLeft'] ) ) {
			return $response;
		}

		$options = [ 'rightToLeft' => is_rtl() ];
		$convert = [ 'thousands_separator', 'decimal_separator', 'decimal_places', 'reset_range' ];

		foreach ( $convert as $key ) {

			if ( ! isset( $facet[ $key ] ) ) {
				continue;
			}

			// To be compliant with JS syntax.
			$js_key = ucwords( str_replace( '_', ' ', $key ) );
			$js_key = lcfirst( str_replace( ' ', '', $js_key ) );
			$response['settings'][ $js_key ] = $facet[ $key ];
			unset( $response['settings'][ $key ] );

		}

		return $response;

	}

	/**
	 * Query facet range (min & max values)
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet Holds facet settings.
	 * @return object Min/max range values.
	 */
	public function query_facet( $facet ) {

		global $wpdb;

		$where_clause = wpgb_get_filtered_where_clause( $facet, 'OR' );

		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT MIN(facet_value + 0) AS min, MAX(facet_value + 0) AS max
				FROM {$wpdb->prefix}wpgb_index
				WHERE slug = %s
				AND facet_value != ''
				AND $where_clause",
				$facet['slug']
			)
		); // WPCS: unprepared SQL ok.

	}

	/**
	 * Render facet
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array  $facet Holds facet settings.
	 * @param object $range Holds range min/max values.
	 * @return string Facet markup.
	 */
	public function render_facet( $facet, $range ) {

		$values  = $facet['selected'];

		if (
			'' === trim( $range->min ) &&
			'' === trim( $range->max ) &&
			! $facet['show_empty']
		) {
			return;
		}

		// If no values selected, select full range.
		if ( empty( $values ) ) {
			$values = [ $range->min, $range->max ];
		}

		$output = sprintf(
			'<div class="wpgb-range-facet">
				<input type="range" class="wpgb-range" name="%1$s[]" min="%2$g" max="%3$g" step="%4$g" value="%5$g" aria-label="min" hidden>
				<input type="range" class="wpgb-range" name="%1$s[]" min="%2$g" max="%3$g" step="0.00001" value="%6$g" aria-label="max" hidden>
				%7$s
			</div>',
			esc_attr( $facet['slug'] ),
			(float) $range->min,
			(float) $range->max,
			(float) $facet['step'],
			min( $values ),
			max( $values ),
			$this->range_skeleton( $facet )
		);

		return apply_filters( 'wp_grid_builder/facet/range', $output, $facet, $range );

	}

	/**
	 * Range skeleton loader
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet Holds facet settings.
	 * @return string Facet markup.
	 */
	public function range_skeleton( $facet ) {

		$loader  = '<div class="wpgb-range-facet-loader">';
		$loader .= '<div class="wpgb-range-slider">';
		$loader .= '<div class="wpgb-range-thumb"></div>';
		$loader .= '<div class="wpgb-range-thumb"></div>';
		$loader .= '</div>';
		$loader .= '<span class="wpgb-range-label">&nbsp;</span>';

		if ( ! empty( $facet['reset_range'] ) ) {
			$loader .= '<div class="wpgb-range-clear">' . esc_html( $facet['reset_range'] ) . '</div>';
		}

		$loader .= '</div>';

		return $loader;

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

		$where  = '';
		$values = $facet['selected'];

		$min = is_array( $values ) ? (float) min( $values ) : false;
		$max = is_array( $values ) ? (float) max( $values ) : false;

		if ( false !== $min ) {
			$where .= " AND (facet_value + 0) >= $min";
		}

		if ( false !== $max ) {
			$where .= " AND (facet_value + 0) <= $max";
		}

		return $wpdb->get_col(
			$wpdb->prepare(
				"SELECT DISTINCT object_id
				FROM {$wpdb->prefix}wpgb_index
				WHERE slug = %s
				$where",
				$facet['slug']
			)
		); // WPCS: unprepared SQL ok.

	}
}

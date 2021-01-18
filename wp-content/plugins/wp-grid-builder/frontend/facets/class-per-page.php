<?php
/**
 * Per Page facet
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
 * Per Page
 *
 * @class WP_Grid_Builder\FrontEnd\Facets\Per_Page
 * @since 1.0.0
 */
class Per_Page {

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
	 * @return string Facet markup.
	 */
	public function render_facet( $facet ) {

		$query_vars    = wpgb_get_unfiltered_query_vars();
		$found_objects = wpgb_get_found_objects();
		$query_number  = (int) $query_vars['number'];

		$options = $query_number . ',' . $facet['per_page_options'];
		$options = explode( ',', $options );
		$options = array_map( 'intval', $options );
		$options = array_filter( array_unique( $options ) );
		$current = (int) reset( $facet['selected'] );

		// If no selected page, set queried number.
		if ( empty( $current ) ) {
			$current = $query_number;
		}

		sort( $options );

		// Do not show if less results than minium amout of posts per page.
		if ( empty( $options ) || min( $options ) >= (int) $found_objects ) {
			return;
		}

		$label    = $facet['title'] ?: __( 'Select number per page', 'wp-grid-builder' );
		$combobox = $facet['combobox'] ? ' wpgb-combobox' : '';

		$output  = '<div class="wpgb-per-page-facet">';
		$output .= '<label>';
		$output .= '<span class="wpgb-sr-only">' . esc_html( $label ) . '</span>';
		$output .= '<select class="wpgb-per-page wpgb-select' . esc_attr( $combobox ) . '" name="' . esc_attr( $facet['slug'] ) . '">';

		foreach ( $options as $number ) {

			if ( (int) $number < 1 ) {
				continue;
			}

			$selected = selected( $current, $number, false );
			$output  .= '<option value="' . (int) $number . '"' . $selected . '>' . esc_html( $number ) . '</option>';

		}

		$output .= '</select>';
		$output .= ( new Select() )->select_icon( $facet );
		$output .= '</label>';
		$output .= '</div>';

		return apply_filters( 'wp_grid_builder/facet/per_page', $output, $options );

	}

	/**
	 * Query vars
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet Holds facet settings.
	 * @param array $query_vars Holds query vars.
	 * @return array Holds query vars to override.
	 */
	public function query_vars( $facet, $query_vars ) {

		$number = reset( $facet['selected'] );

		if ( empty( $number ) ) {
			return;
		}

		return [
			'number' => (int) $number,
		];

	}
}

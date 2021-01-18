<?php
/**
 * Date facet
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
 * Date
 *
 * @class WP_Grid_Builder\FrontEnd\Facets\Date
 * @since 1.0.0
 */
class Date {

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
	 * Filter facet response to set date settings
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
		if ( 'date' !== $facet['type'] || isset( $facet['settings']['mode'] ) ) {
			return $response;
		}

		$response['settings'] = wp_parse_args(
			[
				'mode'        => $facet['date_type'],
				'locale'      => get_locale(),
				'altInput'    => true,
				'altFormat'   => $facet['date_format'] ?: 'Y-m-d',
				'defaultDate' => $facet['selected'],
			],
			$response['settings']
		);

		return $response;

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

		$label  = $facet['title'] ?: __( 'Date', 'wp-grid-builder' );
		$holder = $facet['date_placeholder'] ?: __( 'Select a Date', 'wp-grid-builder' );

		$output = sprintf(
			'<div class="wpgb-date-facet">
				<label>
					<span class="wpgb-sr-only">%1$s</span>%2$s
					<input type="text" class="wpgb-date" name="%3$s" placeholder="%4$s">
				</label>
				<button type="button" class="wpgb-date-clear">
					<span class="wpgb-sr-only">%5$s</span>%6$s
				</button>
			</div>',
			esc_html( $label ),
			$this->calendar_icon(),
			esc_attr( $facet['slug'] ),
			esc_attr( $holder ),
			esc_html__( 'Clear', 'wp-grid-builder' ),
			$this->clear_icon()
		);

		return apply_filters( 'wp_grid_builder/facet/date', $output, $facet );

	}

	/**
	 * Calendar icon
	 *
	 * @since 1.2.1 Change SVG icon markup
	 * @since 1.0.0
	 * @access public
	 */
	public function calendar_icon() {

		$icon  = '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">';
		$icon .= '<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M23 9v14H1V9M1 3h22v6H1zM12 1v4M6 1v4M18 1v4"></path>';
		$icon .= '</svg>';

		$icon  = '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">';
		$icon .= '<path fill="none" stroke="currentColor" stroke-linecap="round" d="M4.25 3.205h15.5a3 3 0 013 3V19.75a3 3 0 01-3 3H4.25a3 3 0 01-3-3V6.205a3 3 0 013-3zM22.262 9.557H1.739 M7.114 5.65v-4.4M16.886 5.65v-4.4"></path>';
		$icon .= '</svg>';

		return $icon;

	}

	/**
	 * Clear icon
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function clear_icon() {

		$icon  = '<svg viewBox="0 0 20 20" aria-hidden="true" focusable="false">';
		$icon .= '<path d="M14.348 14.849c-.469.469-1.229.469-1.697 0L10 11.819l-2.651 3.029c-.469.469-1.229.469-1.697 0-.469-.469-.469-1.229 0-1.697l2.758-3.15-2.759-3.152c-.469-.469-.469-1.228 0-1.697s1.228-.469 1.697 0L10 8.183l2.651-3.031c.469-.469 1.228-.469 1.697 0s.469 1.229 0 1.697l-2.758 3.152 2.758 3.15c.469.469.469 1.229 0 1.698z"></path>';
		$icon .= '</svg>';

		return $icon;

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

		$values  = $facet['selected'];
		$min_val = min( $values ) ?: '';
		$max_val = max( $values ) ?: '';

		if ( '' === $min_val && '' === $max_val ) {
			return [];
		}

		if ( 'range' === $facet['date_type'] ) {

			return $wpdb->get_col(
				$wpdb->prepare(
					"SELECT DISTINCT object_id
					FROM {$wpdb->prefix}wpgb_index
					WHERE slug = %s
					AND LEFT(facet_value, 10) >= %s
					AND LEFT(facet_value, 10) <= %s",
					$facet['slug'],
					$min_val,
					$max_val
				)
			);

		}

		return $wpdb->get_col(
			$wpdb->prepare(
				"SELECT DISTINCT object_id
				FROM {$wpdb->prefix}wpgb_index
				WHERE slug = %s
				AND LEFT(facet_value, 10) = %s",
				$facet['slug'],
				$min_val
			)
		);

	}
}

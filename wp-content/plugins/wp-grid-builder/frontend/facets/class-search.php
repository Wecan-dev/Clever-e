<?php
/**
 * Search facet
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\FrontEnd\Facets;

use WP_Grid_Builder\Includes\Helpers;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Search
 *
 * @class WP_Grid_Builder\FrontEnd\Facets\Search
 * @since 1.0.0
 */
class Search {

	/**
	 * Render facet
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array   $facet  Holds facet settings.
	 * @param array   $items  Holds facet items.
	 * @param integer $parent Parent id to process children.
	 * @return string Facet markup.
	 */
	public function render_facet( $facet, $items, $parent = 0 ) {

		$label = $facet['title'] ?: __( 'Search content', 'wp-grid-builder' );
		$value = $this->get_facet_value( $facet );
		$input = sprintf(
			'<label>
				<span class="wpgb-sr-only">%1$s</span>%2$s
				<input type="search" name="%3$s" placeholder="%4$s" value="%5$s" autocomplete="off">
			</label>',
			esc_html( $label ),
			$this->search_icon(),
			esc_attr( $facet['slug'] ),
			esc_attr( $facet['search_placeholder'] ),
			esc_attr( $value )
		);

		$output  = '<div class="wpgb-search-facet">';
		$output .= $input;
		$output .= '</div>';

		return apply_filters( 'wp_grid_builder/facet/search', $output, $facet );

	}

	/**
	 * Search icon
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Select icon.
	 */
	public function search_icon() {

		$output  = '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">';
		$output .= '<path fill="currentColor" d="M18.932 16.845a10.206 10.206 0 0 0 2.087-6.261A10.5 10.5 0 0 0 10.584 0a10.584 10.584 0 0 0 0 21.168 9.9 9.9 0 0 0 6.261-2.087l4.472 4.472a1.441 1.441 0 0 0 2.087 0 1.441 1.441 0 0 0 0-2.087zm-8.348 1.193a7.508 7.508 0 0 1-7.6-7.453 7.6 7.6 0 0 1 15.2 0 7.508 7.508 0 0 1-7.6 7.452z"></path>';
		$output .= '</svg>';

		return $output;

	}

	/**
	 * Query object ids
	 *
	 * @since 1.1.9 Add post_status in search query.
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet Holds facet settings.
	 * @return array Holds queried facet object ids.
	 */
	public function query_objects( $facet ) {

		$object = wpgb_get_queried_object_type();
		$search = $this->get_facet_value( $facet );
		$number = $facet['search_number'];

		switch ( $object ) {
			case 'post':
				$query_vars = wpgb_get_unfiltered_query_vars();
				$query['s'] = $search;
				$query['post_type'] = isset( $query_vars['post_type'] ) ? $query_vars['post_type'] : 'any';
				$query['post_status'] = isset( $query_vars['post_status'] ) ? $query_vars['post_status'] : 'any';
				$query = apply_filters( 'wp_grid_builder/facet/search_query_args', $query, $facet );
				return Helpers::get_post_ids( $query, $number );
			case 'term':
				$query['search'] = $search;
				$query = apply_filters( 'wp_grid_builder/facet/search_query_args', $query, $facet );
				return Helpers::get_term_ids( $query, $number );
			case 'user':
				$query['search'] = '*' . trim( $search ) . '*';
				$query = apply_filters( 'wp_grid_builder/facet/search_query_args', $query, $facet );
				return Helpers::get_user_ids( $query, $number );
		}

	}

	/**
	 * Get string to search.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet Holds facet settings.
	 * @return string Selected facet value.
	 */
	public function get_facet_value( $facet ) {

		// Revert array to string.
		$value = (array) $facet['selected'];
		$value = implode( ',', $value );

		return $value;

	}

	/**
	 * Query vars
	 *
	 * @since 1.1.5
	 * @access public
	 *
	 * @param array $facet Holds facet settings.
	 * @param array $query_vars Holds query vars.
	 * @return array Holds query vars to override.
	 */
	public function query_vars( $facet, $query_vars ) {

		if ( ! $facet['search_relevancy'] || ! empty( $query_vars['orderby'] ) ) {
			return;
		}

		return [
			'orderby' => 'post__in',
			'order'   => '',
		];

	}
}

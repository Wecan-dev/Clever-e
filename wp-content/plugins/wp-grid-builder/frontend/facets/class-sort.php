<?php
/**
 * Sort facet
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
 * Sort
 *
 * @class WP_Grid_Builder\FrontEnd\Facets\Sort
 * @since 1.0.0
 */
class Sort {

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

		$options  = $this->render_options( $facet );
		$combobox = $facet['combobox'] ? ' wpgb-combobox' : '';
		$label    = $facet['title'] ?: __( 'Sort content', 'wp-grid-builder' );

		if ( empty( $options ) ) {
			return;
		}

		$output  = '<div class="wpgb-sort-facet">';
			$output .= '<label>';
				$output .= '<span class="wpgb-sr-only">' . esc_html( $label ) . '</span>';
				$output .= '<select class="wpgb-sort wpgb-select' . esc_attr( $combobox ) . '" name="' . esc_attr( $facet['slug'] ) . '">';
					$output .= $options;
				$output .= '</select>';
				$output .= ( new Select() )->select_icon( $facet );
			$output .= '</label>';
		$output .= '</div>';

		return $output;

	}

	/**
	 * Render sort options
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet Holds facet settings.
	 * @return string Options markup.
	 */
	public function render_options( $facet ) {

		$output  = '';
		$options = (array) $facet['sort_options'];

		if ( empty( $options ) ) {
			return;
		}

		foreach ( $options as $option ) {

			if ( empty( $option['label'] ) ) {
				continue;
			}

			$output .= $this->render_option( $facet, $option );
		}

		return $output;

	}

	/**
	 * Render sort option
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet  Holds facet settings.
	 * @param array $option Holds current select option.
	 * @return string Option markup.
	 */
	public function render_option( $facet, $option ) {

		$value   = $this->get_sort_value( $option );
		$current = reset( $facet['selected'] );

		$output = sprintf(
			'<option value="%1$s"%2$s>%3$s</option>',
			esc_attr( $value ),
			selected( $current, $value, false ),
			esc_html( $option['label'] )
		);

		return apply_filters( 'wp_grid_builder/facet/sort', $output, $facet, $option );

	}

	/**
	 * Get sort value
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $options Holds sort options.
	 * @return string Sort option value.
	 */
	public function get_sort_value( $options ) {

		if ( $this->is_meta_key( $options ) ) {
			$value = isset( $options['meta_key'] ) ? $options['meta_key'] : '';
		} else {
			$value = isset( $options['orderby'] ) ? $options['orderby'] : '';
		}

		if ( ! empty( $value ) && isset( $options['order'] ) ) {
			$value .= '_' . $options['order'];
		}

		return $value;

	}

	/**
	 * Check if orderby value is a metadata key
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $options Holds sort options.
	 * @return boolean
	 */
	public function is_meta_key( $options ) {

		$orderby = isset( $options['orderby'] ) ? $options['orderby'] : '';

		return isset( $options['meta_key'] ) && ( 'meta_value' === $orderby || 'meta_value_num' === $orderby );

	}

	/**
	 * Get ACF meta key name
	 *
	 * @since 1.1.5
	 * @access public
	 *
	 * @param string $key Meta Key.
	 * @return string
	 */
	public function get_acf_key( $key ) {

		$acf = explode( 'acf/', $key );

		if ( empty( $acf[1] ) ) {
			return $key;
		}

		$keys = explode( '/', $acf[1] );

		// Try to handle repeater but we should not...
		if ( count( $keys ) > 1 ) {
			$acf = implode( '_$_', $keys );
		} else {
			$acf = $acf[1];
		}

		return $acf;

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

		$selected = reset( $facet['selected'] );
		$selected = explode( '_', $selected );
		$order    = array_pop( $selected );
		$orderby  = implode( '_', $selected );
		$current  = $orderby . '_' . $order;

		if ( empty( $orderby ) ) {
			return;
		}

		$sort_option = array_filter(
			(array) $facet['sort_options'],
			function( $option ) use ( $current ) {

				$sort_value = $this->get_sort_value( $option );

				if ( $sort_value === $current ) {
					return true;
				}

			}
		);

		$sort_option = reset( $sort_option );

		if ( empty( $sort_option ) ) {
			return;
		}

		if ( $this->is_meta_key( $sort_option ) ) {

			return [
				'meta_key' => $this->get_acf_key( $sort_option['meta_key'] ),
				'orderby'  => $sort_option['orderby'],
				'order'    => $order,
			];

		}

		return [
			'orderby' => $orderby,
			'order'   => $order,
		];

	}
}

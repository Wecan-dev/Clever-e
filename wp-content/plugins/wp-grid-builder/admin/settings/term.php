<?php
/**
 * Term settings
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$term_settings = [
	'id'         => 'term',
	'taxonomies' => get_taxonomies(
		[
			'publicly_queryable' => true,
			'public'             => true,
		]
	),
	'fields' => [
		// color.
		[
			'id'    => 'color',
			'type'  => 'color',
			'label' => sprintf(
				/* translators: %s Plugin name */
				__( '%s - Color', 'wp-grid-builder' ),
				esc_html( WPGB_NAME )
			),
			'description' => __( 'Color used in cards (Taxonomy terms block)', 'wp-grid-builder' ),
		],
		// background.
		[
			'id'    => 'background',
			'type'  => 'color',
			'label' => sprintf(
				/* translators: %s Plugin name */
				__( '%s - Background', 'wp-grid-builder' ),
				esc_html( WPGB_NAME )
			),
			'description' => __( 'Background used in cards (Taxonomy terms block)', 'wp-grid-builder' ),
		],
	],
];

wp_grid_builder()->settings->register( $term_settings );

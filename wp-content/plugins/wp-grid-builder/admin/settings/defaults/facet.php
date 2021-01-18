<?php
/**
 * Default Facet settings
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return [
	// Naming.
	'id'                    => '',
	'name'                  => '',
	'title'                 => '',
	'slug'                  => '',
	'shortcode'             => '',
	// Behaviour.
	'action'                => 'filter',
	'filter_type'           => 'checkbox',
	// Source content.
	'source'                => 'taxonomy',
	'post'                  => '',
	'taxonomy'              => 'category',
	'parent'                => '',
	'include'               => [],
	'exclude'               => [],
	'field_type'            => 'post',
	'post_field'            => 'post_type',
	'user_field'            => 'display_name',
	'term_field'            => 'term_name',
	'meta_key'              => '',
	'hierarchical'          => '',
	'children'              => 1,
	// Logic and number.
	'show_empty'            => 1,
	'show_count'            => 1,
	'logic'                 => 'AND',
	'limit'                 => 10,
	'display_limit'         => 10,
	'show_more_label'       => __( '+ Show [number] more', 'wp-grid-builder' ),
	'show_less_label'       => __( '- Show less', 'wp-grid-builder' ),
	'orderby'               => 'count',
	'order'                 => 'DESC',
	// Range facet.
	'prefix'                => '',
	'suffix'                => '',
	'step'                  => 1,
	'thousands_separator'   => '',
	'decimal_separator'     => '.',
	'decimal_places'        => 0,
	'reset_range'           => __( 'Reset', 'wp-grid-builder' ),
	// Date facet.
	'date_type'             => '',
	'date_format'           => 'Y-m-d',
	'date_placeholder'      => __( 'Select a Date', 'wp-grid-builder' ),
	// Select facet.
	'combobox'              => 0,
	'clearable'             => 0,
	'searchable'            => 0,
	'async'                 => 0,
	'no_results'            => __( 'No Results Found.', 'wp-grid-builder' ),
	'loading'               => __( 'Loading...', 'wp-grid-builder' ),
	'search'                => __( 'Please enter 1 or more characters.', 'wp-grid-builder' ),
	// Sort facet.
	'sort_options'          => [],
	// button facet.
	'multiple'              => 0,
	'all_label'             => _x( 'All', 'Default Facet Label', 'wp-grid-builder' ),
	// select facet.
	'select_placeholder'    => _x( 'None', 'Select Placeholder', 'wp-grid-builder' ),
	// Search facet.
	'search_placeholder'    => '',
	'search_engine'         => 'wordpress',
	'search_number'         => 200,
	'search_relevancy'      => 1,
	'instant_search'        => 0,
	// Loader facet.
	'load_type'             => 'pagination',
	// Pagination facet.
	'pagination'            => 'numbered',
	'show_all'              => 0,
	'mid_size'              => 2,
	'end_size'              => 2,
	'show_all'              => 0,
	'prev_next'             => 0,
	'prev_text'             => __( '&laquo; Previous', 'wp-grid-builder' ),
	'next_text'             => __( 'Next &raquo;', 'wp-grid-builder' ),
	'dots_page'             => '&hellip;',
	// Per page facet.
	'per_page_options'      => '10, 25, 50, 100',
	// Load more facet.
	'load_posts_number'     => 10,
	'load_more_event'       => 'onclick',
	'load_more_remain'      => 1,
	'load_more_text'        => __( 'Load more', 'wp-grid-builder' ),
	'loading_text'          => __( 'Loading...', 'wp-grid-builder' ),
	// Result count facet.
	'result_count_singular' => __( '1 post found', 'wp-grid-builder' ),
	'result_count_plural'   => __( '[from] - [to] of [total] posts', 'wp-grid-builder' ),
	// Reset facet.
	'reset_label'          => __( 'Reset', 'wp-grid-builder' ),
	'reset_facet'          => 0,
	// Dynamic vars.
	'html'                 => '',
	// Unecessary common values for facet ajax response.
	'common'               => [
		'name'           => '',
		'slug'           => '',
		'title'          => '',
		'action'         => '',
		'source'         => '',
		'post'           => '',
		'taxonomy'       => '',
		'taxonomy_terms' => '',
		'field_type'     => '',
		'filter_type'    => '',
		'load_type'      => '',
		'post_field'     => '',
		'user_field'     => '',
		'term_field'     => '',
		'meta_key'       => '',
		'hierarchical'   => '',
		'children'       => '',
		'show_empty'     => '',
		'show_count'     => '',
		'logic'          => '',
		'limit'          => '',
		'display_limit'  => '',
		'orderby'        => '',
		'order'          => '',
	],
];

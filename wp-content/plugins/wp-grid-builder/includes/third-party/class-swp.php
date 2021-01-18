<?php
/**
 * Add SearchWP support
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\Includes\Third_Party;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle SearchWP search feature
 *
 * @class WP_Grid_Builder\Includes\Third_Party\SWP
 * @since 1.0.0
 */
class SWP {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		if ( ! class_exists( 'SWP_Query' ) ) {
			return;
		}

		add_filter( 'wp_grid_builder/facet/search_query_args', [ $this, 'search_terms' ], 10, 2 );
		add_filter( 'wp_grid_builder/facet/query_objects', [ $this, 'query_objects' ], 10, 2 );

	}

	/**
	 * Prevent running SearchWP if enabled
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param  array $query_args Holds WP query args.
	 * @param  array $facets Holds facet settings.
	 * @return array Wp Query args.
	 */
	public function search_terms( $query_args, $facets ) {

		$query_args['suppress_filters'] = true;
		return $query_args;

	}

	/**
	 * Query object ids
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param mixed $match Match state.
	 * @param array $facet Holds facet settings.
	 * @return array Holds queried facet object ids.
	 */
	public function query_objects( $match, $facet ) {

		if (
			empty( $facet['type'] ) ||
			'search' !== $facet['type'] ||
			empty( $facet['search_engine'] ) ||
			'searchwp' !== $facet['search_engine']
		) {
			return $match;
		}

		$object = wpgb_get_queried_object_type();

		if ( 'post' !== $object ) {
			return $match;
		}

		return $this->query_posts( $facet ) ?: [ 0 ];

	}

	/**
	 * Query post ids
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet Holds facet settings.
	 * @return array Queried post ids.
	 */
	public function query_posts( $facet ) {

		$query_vars = wpgb_get_unfiltered_query_vars();

		if ( empty( $query_vars['post_type'] ) ) {
			$query_vars['post_type'] = 'any';
		}

		$search = (array) $facet['selected'];
		$search = implode( ',', $search );
		$number = $facet['search_number'];

		$query_vars = [
			's'              => $search,
			'paged'          => 1,
			'posts_per_page' => $number,
			'fields'         => 'ids',
		];

		$post_ids = (array) ( new \SWP_Query( $query_vars ) )->posts;
		wp_reset_postdata();

		return $post_ids;

	}
}

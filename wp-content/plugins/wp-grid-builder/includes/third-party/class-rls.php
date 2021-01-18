<?php
/**
 * Add Relevanssi support
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
 * Handle Relevanssi search feature
 *
 * @class WP_Grid_Builder\Includes\Third_Party\RLS
 * @since 1.0.0
 */
class RLS {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		if ( ! function_exists( 'relevanssi_search' ) ) {
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
			'relevanssi' !== $facet['search_engine']
		) {
			return $match;
		}

		$object = wpgb_get_queried_object_type();

		if ( 'post' !== $object ) {
			return $match;
		}

		$posts = $this->query_posts( $facet ) ?: [ 0 ];
		$posts = array_filter( $posts );

		return array_map(
			function( $post ) {
				return $post->ID;
			},
			$posts
		);

	}

	/**
	 * Query post ids
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet Holds facet settings.
	 * @return array Queried posts.
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
			's'                      => $search,
			'paged'                  => 1,
			'posts_per_page'         => $number,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'cache_results'          => false,
			'no_found_rows'          => true,
			// Relevanssi trigger warnings if we only fetch Ids in relevanssi_do_query().
			'fields'                 => 'id=>parent',
		];

		$query = new \WP_Query();
		$query->parse_query( $query_vars );

		relevanssi_do_query( $query );
		wp_reset_postdata();

		return (array) $query->posts;

	}
}

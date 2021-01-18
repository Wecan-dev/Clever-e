<?php
/**
 * Facets
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\FrontEnd;

use WP_Grid_Builder\FrontEnd\Facets;
use WP_Grid_Builder\Includes\Helpers;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add facets in layout
 *
 * @class WP_Grid_Builder\FrontEnd\Facets
 * @since 1.0.0
 */
final class Facets implements Models\Facets_Interface {

	/**
	 * Holds grid settings
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var object
	 */
	public $settings = [];

	/**
	 * Holds filtered object ids
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array
	 */
	protected $filtered_object_ids;

	/**
	 * Holds unfiltered object ids
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array
	 */
	protected $unfiltered_object_ids;

	/**
	 * Holds imploded filtered object ids
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string
	 */
	protected $imploded_filtered_object_ids;

	/**
	 * Holds imploded unfiltered object ids
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string
	 */
	protected $imploded_unfiltered_object_ids;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param object $settings Hold Settings.
	 */
	public function __construct( $settings ) {

		$this->settings = $settings;

	}

	/**
	 * Query and render facets
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Holds all facets data.
	 */
	public function render() {

		$output    = [];
		$facet_ids = array_map( 'intval', $this->settings['facets'] );
		$facets    = wpgb_query_facets( $facet_ids );

		foreach ( (array) $facets as $id => $facet ) {

			if ( ! in_array( $id, $facet_ids, true ) ) {
				continue;
			}

			if ( 'selection' === $facet['type'] ) {

				$selection = $facet;
				continue;

			}

			$output[ $id ] = $this->do_facet( $facet );

		}

		if ( isset( $selection ) ) {
			$output[ $selection['id'] ] = $this->do_facet( $selection );
		}

		return $output;

	}

	/**
	 * Search for facet values/names (async method)
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Holds facet value/name.
	 */
	public function search() {

		if (
			empty( $this->settings['search']['facet'] ) ||
			empty( $this->settings['search']['string'] )
		) {
			return [];
		}

		$facet_id = $this->settings['search']['facet'];
		$facet = wpgb_query_facets( $facet_id );

		if ( empty( $facet[ $facet_id ] ) ) {
			return [];
		}

		$facet = $facet[ $facet_id ];
		$facet['search'] = $this->settings['search']['string'];
		$output = ( new Facets\Async() )->query_facet( $facet );

		return $output;

	}

	/**
	 * Process facet query and output facet
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet Hold Facet settings.
	 * @return array Facet settings.
	 */
	public function do_facet( $facet ) {

		$items = [];

		if ( method_exists( $facet['instance'], 'query_facet' ) ) {
			$items = $facet['instance']->query_facet( $facet );
		}

		if ( method_exists( $facet['instance'], 'render_facet' ) ) {

			// Add number of posts and offset parameters to load more facet.
			if ( 'load_more' === $facet['type'] ) {

				$query_vars = wpgb_get_filtered_query_vars();
				$facet['settings']['number'] = $query_vars['number'];
				$facet['settings']['offset'] = $query_vars['offset'];

			}

			// Get facet content.
			$facet['html'] = $facet['instance']->render_facet( $facet, $items );
			$facet['html'] = apply_filters( 'wp_grid_builder/facet/html', $facet['html'], $facet['id'] );

			ob_start();
			Helpers::get_template( 'layout/facet', $facet );
			$facet['html'] = ob_get_clean();

			// To handle selection facet.
			$this->facets[ $facet['slug'] ] = array_merge( $facet, [ 'items' => $items ] );
			// Add markup in transient.
			$this->cache_facet( $facet );

		}

		return apply_filters(
			'wp_grid_builder/facet/response',
			[
				'name'     => $facet['name'],
				'slug'     => $facet['slug'],
				'type'     => $facet['type'],
				'html'     => $facet['html'],
				'settings' => $facet['settings'],
				'selected' => $facet['selected'],
			],
			$facet,
			$items
		);

	}

	/**
	 * Cache facet output
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $facet Hold Facet settings.
	 */
	public function cache_facet( $facet ) {

		// Only cache unfiltered facets.
		if ( wpgb_has_selected_facets() ) {
			return;
		}

		$grid_id   = $this->settings['id'];
		$language  = $this->settings['lang'];
		$transient = WPGB_SLUG . '_G' . $grid_id . 'F' . $facet['id'] . $language;

		set_transient( $transient, $facet['html'] );

	}

	/**
	 * Query object ids from current query vars
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $query_vars Holds current query arguments.
	 * @return array Holds object ids.
	 */
	public function get_object_ids( $query_vars ) {

		$object_type = wpgb_get_queried_object_type();

		if ( empty( $object_type ) ) {
			return [];
		}

		switch ( $object_type ) {
			case 'post':
				return Helpers::get_post_ids( $query_vars, -1 );
			case 'term':
				return Helpers::get_term_ids( $query_vars, '' );
			case 'user':
				return Helpers::get_user_ids( $query_vars, -1 );
		}

	}

	/**
	 * Get filtered object ids
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Object ids.
	 */
	public function get_filtered_object_ids() {

		if ( ! empty( $this->filtered_object_ids ) ) {
			return $this->filtered_object_ids;
		}

		$query_vars = wpgb_get_filtered_query_vars();
		$this->filtered_object_ids = $this->get_object_ids( $query_vars );

		return $this->filtered_object_ids;

	}

	/**
	 * Get unfiltered object ids
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Object ids.
	 */
	public function get_unfiltered_object_ids() {

		if ( ! empty( $this->unfiltered_object_ids ) ) {
			return $this->unfiltered_object_ids;
		}

		$query_vars = wpgb_get_unfiltered_query_vars();
		$this->unfiltered_object_ids = $this->get_object_ids( $query_vars );

		return $this->unfiltered_object_ids;

	}

	/**
	 * Implode filtered object ids
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Object ids comma separated.
	 */
	public function implode_filtered_object_ids() {

		if ( ! empty( $this->imploded_filtered_object_ids ) ) {
			return $this->imploded_filtered_object_ids;
		}

		$this->imploded_filtered_object_ids = implode( ',', $this->get_filtered_object_ids() );

		// Return 0 if falsy to make sure where clause is valid.
		return $this->imploded_filtered_object_ids ?: 0;

	}

	/**
	 * Implode unfiltered object ids
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Object ids comma separated.
	 */
	public function implode_unfiltered_object_ids() {

		if ( ! empty( $this->imploded_unfiltered_object_ids ) ) {
			return $this->imploded_unfiltered_object_ids;
		}

		$this->imploded_unfiltered_object_ids = implode( ',', $this->get_unfiltered_object_ids() );

		// Return 0 if falsy to make sure where clause is valid.
		return $this->imploded_unfiltered_object_ids ?: 0;

	}
}

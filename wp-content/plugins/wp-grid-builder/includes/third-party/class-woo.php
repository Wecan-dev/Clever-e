<?php
/**
 * Add WooCommerce support
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\Includes\Third_Party;

use WP_Grid_Builder\Includes\Helpers;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle WooCommerce facet values
 *
 * @class WP_Grid_Builder\Includes\Third_Party\WOO
 * @since 1.0.0
 */
class WOO {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		add_filter( 'wp_grid_builder/custom_fields', [ $this, 'custom_fields' ] );
		add_filter( 'wp_grid_builder/indexer/index_object', [ $this, 'index' ], 10, 3 );
		add_filter( 'wp_grid_builder/grid/the_object', [ $this, 'featured_product_field' ] );

		// Sort by featured products.
		add_action( 'pre_get_posts', [ $this, 'set_featured_orderby' ], PHP_INT_MAX );
		add_filter( 'posts_orderby', [ $this, 'posts_orderby_featured' ], 10, 2 );

	}

	/**
	 * Retrieve WC custom fields
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $fields Holds registred custom fields.
	 * @return array
	 */
	public function custom_fields( $fields ) {

		$fields['WooCommerce'] = array_map(
			function( $field ) {
				return 'WC &rsaquo; ' . $field;
			},
			[
				'_price'                 => __( 'Price', 'wp-grid-builder' ),
				'_sale_price'            => __( 'Sale Price', 'wp-grid-builder' ),
				'_regular_price'         => __( 'Regular Price', 'wp-grid-builder' ),
				'_on_sale'               => __( 'On Sale', 'wp-grid-builder' ),
				'_stock_status'          => __( 'Stock Status', 'wp-grid-builder' ),
				'_product_type'          => __( 'Product Type', 'wp-grid-builder' ),
				'_wpgb_featured_product' => __( 'Featured Product', 'wp-grid-builder' ),
				'_average_rating'        => __( 'Average Rating', 'wp-grid-builder' ),
			]
		);

		return $fields;

	}

	/**
	 * Index WooCommerce field
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $rows      Holds rows to index.
	 * @param array $object_id Object id to index.
	 * @param array $facet     Holds facet settings.
	 */
	public function index( $rows, $object_id, $facet ) {

		$source = explode( '/', $facet['source'] );
		$source = reset( $source );

		if ( 'post_meta' !== $source ) {
			return $rows;
		}

		$post_type = get_post_type( $object_id );

		if ( 'product' !== $post_type && 'product_variation' !== $post_type ) {
			return $rows;
		}

		return $this->index_metadata( $rows, $object_id, $facet );

	}

	/**
	 * Index WooCommerce metadata
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $rows      Holds rows to index.
	 * @param array $object_id Object id to index.
	 * @param array $facet     Holds facet settings.
	 */
	public function index_metadata( $rows, $object_id, $facet ) {

		$product = wc_get_product( $object_id );
		$field   = explode( '/', $facet['source'] );
		$field   = end( $field );

		switch ( $field ) {
			case '_price':
			case '_sale_price':
			case '_regular_price':
				if ( $product->is_type( 'variable' ) ) {

					$method = 'get_variation' . $field;
					$value  = $product->$method( 'min' );
					$name   = $product->$method( 'max' );

				} else {

					$method = 'get' . $field;
					$value  = $product->$method();
					$name   = $value;

				}

				if ( 'incl' === get_option( 'woocommerce_tax_display_shop' ) ) {

					$value = wc_get_price_including_tax( $product, [ 'price' => $value ] );
					$name  = wc_get_price_including_tax( $product, [ 'price' => $name ] );

				}

				break;
			case '_average_rating':
				$value = (float) $product->get_average_rating();
				$name  = $value;
				break;
			case '_stock_status':
				$value = (int) $product->is_in_stock();
				$name  = $value ? __( 'In Stock', 'wp-grid-builder' ) : __( 'Out of Stock', 'wp-grid-builder' );
				break;
			case '_on_sale':
				$value = $product->is_on_sale() ? 1 : '';
				$name  = $value ? __( 'On Sale', 'wp-grid-builder' ) : '';
				break;
			case '_product_type':
				$value = ucfirst( $product->get_type() );
				$name  = $value;
				break;
			case '_wpgb_featured_product':
				$value = $product->is_featured() ? 1 : '';
				$name  = $value ? __( 'Featured', 'wp-grid-builder' ) : '';
				break;
			default:
				return $rows;
		}

		if ( isset( $value, $name ) ) {

			$rows[] = [
				'facet_value' => $value,
				'facet_name'  => $name,
			];

		}

		return $rows;

	}

	/**
	 * Set featured post meta for the card builder
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @param object $post Holds post object.
	 */
	public function featured_product_field( $post ) {

		if ( isset( $post->product->featured ) ) {
			$post->metadata['_wpgb_featured_product'] = $post->product->featured ? __( 'Featured', 'wp-grid-builder' ) : '';
		}

		return $post;

	}

	/**
	 * Unset orderby value and set custom property to set post orderby later
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @param object $query Holds WP query object.
	 */
	public function set_featured_orderby( $query ) {

		$post_types   = (array) $query->get( 'post_type' );
		$is_product   = in_array( 'product', $post_types );
		$is_variation = in_array( 'product_variation', $post_types );
		$is_metadata  = 'meta_value' === $query->get( 'orderby' );
		$is_featured  = '_wpgb_featured_product' === $query->get( 'meta_key' );

		if ( ( $is_product || $is_variation ) && $is_metadata && $is_featured ) {

			$query->set( 'orderby', '' );
			$query->set( 'meta_key', '' );
			$query->set( 'wpgb_featured_products', $this->get_featured_product_ids() );

		}

	}

	/**
	 * Order by featured product ids.
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @param string   $orderby The ORDER BY clause of the query.
	 * @param WP_Query $query   The WP_Query instance (passed by reference).
	 */
	public function posts_orderby_featured( $orderby, $query ) {

		global $wpdb;

		$products = $query->get( 'wpgb_featured_products' );

		if ( ! empty( $products ) ) {

			$products = implode( ',', $products );
			$orderby  = "FIELD({$wpdb->posts}.ID,{$products}) ";
			$orderby .= $query->get( 'order' );

		}

		return $orderby;

	}

	/**
	 * WooCommerce only queries visible products from wc_get_featured_product_ids()
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @return array
	 */
	public function get_featured_product_ids() {

		$wc_featured = get_transient( 'wc_featured_products' );
		$wpgb_featured = get_transient( 'wpgb_featured_products' );

		// We return ids from transient only if original WC transient exists.
		// If it does not exist we query featured products like WC does (to take into account any change).
		if ( false !== $wc_featured && false !== $wpgb_featured ) {
			return $wpgb_featured;
		}

		$wpgb_featured = Helpers::get_post_ids(
			[
				'post_type'           => [ 'product', 'product_variation' ],
				'post_status'         => 'any',
				'orderby'             => 'ID',
				'order'               => 'DESC',
				'tax_query'           => [
					[
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
						'operator' => 'IN',
					],
				],
			],
			-1
		);

		set_transient( 'wpgb_featured_products', $wpgb_featured, DAY_IN_SECONDS * 30 );

		return $wpgb_featured;

	}
}

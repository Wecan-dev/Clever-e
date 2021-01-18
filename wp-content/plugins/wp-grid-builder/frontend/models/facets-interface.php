<?php
/**
 * Facets Interface
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\FrontEnd\Models;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Facets_Interface {

	/**
	 * Render facets
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function render();

	/**
	 * Search in facets
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function search();

}

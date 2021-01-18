<?php
/**
 * Query Interface
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

interface Query_Interface {

	/**
	 * Get posts
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_posts();

}

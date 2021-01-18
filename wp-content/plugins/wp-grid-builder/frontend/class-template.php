<?php
/**
 * Template
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\FrontEnd;

use WP_Grid_Builder\Includes\File;
use WP_Grid_Builder\Includes\Helpers;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle custom template
 *
 * @class WP_Grid_Builder\FrontEnd\Template
 * @since 1.0.0
 */
final class Template {

	/**
	 * Holds template settings
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array
	 */
	protected $settings;

	/**
	 * Holds template settings
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string
	 */
	protected static $style = '';

	/**
	 * Holds defaults settings
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array
	 */
	protected $defaults = [
		'id'                 => 'template',
		'class'              => '',
		'source_type'        => 'post_type',
		'is_template'        => true,
		'is_main_query'      => false,
		'query_args'         => [],
		'render_callback'    => '',
		'noresults_callback' => '',
	];

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $settings Holds template settings.
	 */
	public function __construct( $settings = [] ) {

		$this->normalize( $settings );

	}

	/**
	 * Output template section and posts.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function render() {

		if ( ! $this->check_callback() ) {
			return;
		}

		$this->query();
		$this->set_options();
		$this->set_classes();
		$this->render_template();
		$this->generate_style();

		add_filter( 'wp_grid_builder/frontend/register_styles', [ $this, 'register_style' ] );
		add_filter( 'wp_grid_builder/frontend/add_inline_style', [ $this, 'inline_style' ] );
		add_filter( 'wp_grid_builder/frontend/add_inline_script', [ $this, 'inline_script' ] );

	}

	/**
	 * Output template posts.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function refresh() {

		if ( ! $this->check_callback() ) {
			return;
		}

		$this->query();
		$this->loop();

	}

	/**
	 * Check render callback
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function check_callback() {

		$callback = $this->settings->render_callback;

		if ( is_callable( $callback ) ) {
			return true;
		}

		echo '<pre class="wpgb-error">';
			esc_html_e( "Invalid \"render_callback\". The callback must be a function or a class method name.\nThe callback must be declared in your functions.php file of your theme or in a plugin.", 'wp-grid-builder' );
		echo '</pre>';

	}

	/**
	 * Normalize settings
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $settings Holds template settings.
	 */
	public function normalize( $settings ) {

		$this->settings = (object) array_merge(
			$this->template_settings( $settings ),
			wpgb_get_global_settings()
		);

	}

	/**
	 * Normalize template settings
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $settings Holds template settings.
	 * @return array
	 */
	public function template_settings( $settings ) {

		$settings = wp_parse_args( $settings, $this->defaults );
		$settings = apply_filters( 'wp_grid_builder/template/args', $settings );
		$settings['id'] = trim( $settings['id'] );

		return $settings;

	}

	/**
	 * Run query
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function query() {

		$query_args = $this->settings->query_args;
		$query_args['wp_grid_builder'] = $this->settings->id;

		switch ( $this->settings->source_type ) {
			case 'user':
				$this->query = new \WP_User_Query( $query_args );
				break;
			case 'term':
				$this->query = new \WP_Term_Query( $query_args );
				break;
			default:
				if ( $this->settings->is_main_query ) {
					$this->query = $this->main_query();
				} else {
					$this->query = new \WP_Query( $query_args );
				}
		}

	}

	/**
	 * Get main WP query
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function main_query() {

		global $wp_query;

		if ( wp_doing_ajax() && ! empty( $this->settings->main_query ) ) {

			// Turns off SQL_CALC_FOUND_ROWS even when limits are present.
			$this->settings->main_query['no_found_rows'] = true;
			// Add language to prevent issue when querying asynchronously.
			$this->settings->main_query['lang'] = $this->settings->lang;
			// Add WP Grid Builder to query args.
			$this->settings->main_query['wp_grid_builder'] = $this->settings->id;

			return new \WP_Query( $this->settings->main_query );

		} elseif ( is_main_query() && ! is_admin() ) {
			return $wp_query;
		}

	}

	/**
	 * Loop through queried posts/users/temrs
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function loop() {

		switch ( $this->settings->source_type ) {
			case 'user':
				$loop = $this->user_loop();
				break;
			case 'term':
				$loop = $this->term_loop();
				break;
			default:
				$loop = $this->post_loop();
		}

		if ( ! $loop ) {
			$this->no_results();
		}

	}

	/**
	 * Display no results message
	 *
	 * @since 1.1.5 Disable no results if callback set to false.
	 * @since 1.0.0
	 * @access public
	 */
	public function no_results() {

		$callback = $this->settings->noresults_callback;

		if ( false === $callback ) {
			return;
		}

		if ( ! empty( $callback ) && is_callable( $callback ) ) {
			call_user_func( $callback );
		} else {
			echo '<p class="wpgb-noresults">' . esc_html__( 'Sorry, no results match your search criteria.', 'wp-grid-builder' ) . '</p>';
		}

	}

	/**
	 * Loop through posts
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return boolean
	 */
	public function post_loop() {

		if ( ! $this->query->have_posts() ) {
			return false;
		}

		while ( $this->query->have_posts() ) {

			global $post;

			$this->query->the_post();
			call_user_func( $this->settings->render_callback, $post );

		}

		wp_reset_postdata();

		return true;

	}

	/**
	 * Loop through users
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return boolean
	 */
	public function user_loop() {

		$users = $this->query->get_results();

		if ( empty( $users ) ) {
			return false;
		}

		foreach ( $users as $user ) {
			call_user_func( $this->settings->render_callback, $user );
		}

		return true;

	}

	/**
	 * Loop through terms
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return boolean
	 */
	public function term_loop() {

		$terms = $this->query->get_terms();

		if ( empty( $terms ) ) {
			return false;
		}

		foreach ( $terms as $term ) {
			call_user_func( $this->settings->render_callback, $term );
		}

		return true;

	}

	/**
	 * Generate main template
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function render_template() {

		$tag_name = apply_filters( 'wp_grid_builder/layout/wrapper_tag', 'div', $this->settings );

		Helpers::get_template( 'layout/icons', '', true );

		echo '<!-- Gridbuilder ᵂᴾ Plugin (https://wpgridbuilder.com) -->';
		echo '<' . tag_escape( $tag_name ) . ' class="' . esc_attr( $this->settings->class ) . '" data-options="' . esc_attr( $this->settings->js_options ) . '">';
			$this->loop();
		echo '</' . tag_escape( $tag_name ) . '>';

	}

	/**
	 * Get class names
	 *
	 * @since 1.0.4 Allow multiple custom class names.
	 * @since 1.0.0
	 * @access public
	 */
	public function set_classes() {

		$classes  = 'wp-grid-builder wpgb-template';
		$classes .= ' ' . sanitize_html_class( 'wpgb-grid-' . $this->settings->id );
		$classes .= ' ' . Helpers::sanitize_html_classes( $this->settings->class );

		$this->settings->class = $classes;

	}

	/**
	 * Prepare data attribute JSON options for JS.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function set_options() {

		$options = [];

		foreach ( $this->defaults as $key => $val ) {

			// To be compliant with JS syntax.
			$js_key = ucwords( str_replace( '_', ' ', $key ) );
			$js_key = lcfirst( str_replace( ' ', '', $js_key ) );

			$options[ $js_key ] = $this->settings->{$key};

		}

		$options = array_filter( $options );

		$this->settings->js_options = wp_json_encode( $options );

	}

	/**
	 * Generate template stylesheet
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function generate_style() {

		$this->stylesheet = File::get_url( 'grids', 'template.css' );

		if ( $this->stylesheet ) {
			return;
		}

		$css = ( new Colors( $this->settings ) )->get();
		$css = wp_strip_all_tags( $css );

		$this->stylesheet = File::put_contents( 'grids', 'template.css', $css );

	}

	/**
	 * Register template style.
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @param array $styles Halds registered styles.
	 * @return array
	 */
	public function register_style( $styles ) {

		if ( $this->stylesheet ) {

			$styles[] = [
				'handle'  => WPGB_SLUG . '-template',
				'source'  => esc_url_raw( File::get_url( 'grids', 'template.css' ) ),
				'version' => filemtime( File::get_path( 'grids', 'template.css' ) ),
			];

		}

		return $styles;

	}

	/**
	 * Inline style if no stylesheet generated
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @param string $style Style to inline.
	 * @return string
	 */
	public function inline_style( $style ) {

		// We inline only once if not stylesheet generated.
		if ( ! $this->stylesheet && empty( self::$style ) ) {

			self::$style = ( new Colors( $this->settings ) )->get();
			self::$style = wp_strip_all_tags( self::$style );
			// We inline first (global CSS).
			$style = self::$style . $style;

		}

		return $style;

	}

	/**
	 * Add inline javascript code to instantiate template
	 *
	 * @since 1.1.5 Added wpgb.loaded event to support defer and async scripts.
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $script Inline script.
	 * @return string
	 */
	public function inline_script( $script ) {

		$class = sanitize_html_class( 'wpgb-grid-' . $this->settings->id );

		$script .= 'window.addEventListener(\'wpgb.loaded\',function(){';
		$script .= 'var template = document.querySelector(' . wp_json_encode( '.wpgb-template.' . $class ) . ');';
		$script .= 'if(template){';
		$script .= 'var wpgb = WP_Grid_Builder.instantiate(template);';
		$script .= 'wpgb.init && wpgb.init()';
		$script .= '}});';

		return apply_filters( 'wp_grid_builder/template/inline_script', $script );

	}
}

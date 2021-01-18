<?php
/**
 * Grid Widget
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\Includes\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Grid Widget
 *
 * @class WP_Grid_Builder\Includes\Widgets\Grid_Widget
 * @since 1.0.0
 */
final class Grid_Widget extends \WP_Widget {

	/**
	 * Register widget with WordPress
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		parent::__construct(
			WPGB_SLUG . '_grid',
			WPGB_NAME . ' - ' . __( 'Grid', 'wp-grid-builder' ),
			[ 'description' => esc_html__( 'Displays a grid.', 'wp-grid-builder' ) ]
		);

	}

	/**
	 * Front-end display of widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		if ( empty( $instance['id'] ) ) {
			return;
		}

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo wp_kses_post( $args['before_widget'] );

		if ( $title ) {

			echo wp_kses_post( $args['before_title'] );
			echo esc_html( $title );
			echo wp_kses_post( $args['after_title'] );

		}

		wpgb_render_grid( $instance['id'] );
		echo wp_kses_post( $args['after_widget'] );

	}

	/**
	 * Back-end widget form.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$id    = isset( $instance['id'] ) ? $instance['id'] : '';
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$grids = Widget::get( 'grids' );

		if ( empty( $grids ) ) {

			$this->button();
			return;

		}

		printf(
			'<p>
				<label for="%1$s">%2$s</label>
				<input id="%1$s" class="widefat" name="%3$s" value="%4$s">
			</p>',
			esc_attr( $this->get_field_id( 'title' ) ),
			esc_html__( 'Title:', 'wp-grid-builder' ),
			esc_attr( $this->get_field_name( 'title' ) ),
			esc_attr( $title )
		);

		Widget::output_list(
			__( 'Grid:', 'wp-grid-builder' ),
			$this->get_field_id( 'id' ),
			$this->get_field_name( 'id' ),
			'grids',
			$id
		);

	}

	/**
	 * Output edit button
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function button() {

		$query_args = [
			'page'   => WPGB_SLUG . '-grid-settings',
			'create' => 'true',
		];

		$url = add_query_arg( $query_args, admin_url( 'admin.php' ) );

		echo '<p>';
			echo '<h2>';
				esc_html_e( 'You don\'t have any grid yet!', 'wp-grid-builder' );
			echo '</h2>';
			echo '<a class="button button-primary" href="' . esc_url( $url ) . '" target="_blank">';
				esc_html_e( 'Create a Grid', 'wp-grid-builder' );
			echo '</a>';
		echo '</p>';

	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		return [
			'title' => isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '',
			'id'    => isset( $new_instance['id'] ) ? absint( $new_instance['id'] ) : '',
		];

	}
}

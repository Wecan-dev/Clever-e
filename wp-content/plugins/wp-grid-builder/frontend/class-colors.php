<?php
/**
 * Colors
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\FrontEnd;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Generate global color schemes
 *
 * @class WP_Grid_Builder\FrontEnd\Colors
 * @since 1.1.5
 */
final class Colors {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $settings Holds global settings.
	 */
	public function __construct( $settings ) {

		$this->settings = $settings;

	}

	/**
	 * Generate global CSS
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string
	 */
	public function get() {

		$css  = $this->color_schemes();
		$css .= $this->lightbox();
		$css .= $this->facets();

		return $css;

	}

	/**
	 * Build CSS color schemes
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function color_schemes() {

		$schemes = '';
		$accent = $this->settings->accent_scheme_1;

		// Accent color.
		if ( ! empty( $accent ) ) {

			$schemes .= '.wp-grid-builder [class*="wpgb-scheme-"] .wpgb-idle-accent-1,';
			$schemes .= '.wp-grid-builder [class*="wpgb-scheme-"] [class^="wpgb-block-"].wpgb-hover-accent-1:hover';
			$schemes .= '{color:' . esc_attr( $accent ) . '}';

		}

		// Color schemes.
		foreach ( [ 'dark', 'light' ] as $scheme ) {

			for ( $i = 1; $i < 4; $i++ ) {

				$color = $this->settings->{$scheme . '_scheme_' . $i};

				if ( empty( $color ) ) {
					continue;
				}

				// Idle and hover scheme.
				$schemes .= '.wp-grid-builder .wpgb-scheme-' . $scheme . ' .wpgb-idle-scheme-' . $i . ',';
				$schemes .= '.wp-grid-builder .wpgb-scheme-' . $scheme . ' [class^="wpgb-block-"].wpgb-hover-scheme-' . $i . ':hover';
				$schemes .= '{color:' . esc_attr( $color ) . '}';

			}
		}

		return $schemes;

	}

	/**
	 * Build CSS facet colors
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function facets() {

		$accent = $this->settings->accent_scheme_1;

		if ( empty( $accent ) ) {
			return '';
		}

		// Button active background color.
		$facets  = '.wpgb-facet .wpgb-button[aria-pressed="true"]';
		$facets .= '{background:' . esc_attr( $accent ) . ';border-color:' . esc_attr( $accent ) . '}';

		// Range slider progress color.
		$facets .= '.wpgb-facet .wpgb-range-facet .wpgb-range-slider .wpgb-range-progress';
		$facets .= '{background:' . esc_attr( $accent ) . '}';

		// Range slider thumb border color.
		$facets .= '.wpgb-facet .wpgb-range-facet .wpgb-range-slider .wpgb-range-thumb';
		$facets .= '{border-color:' . esc_attr( $accent ) . '}';

		// Checkbox button checked border color.
		$facets .= '.wpgb-facet .wpgb-checkbox-facet .wpgb-checkbox[aria-pressed="true"] .wpgb-checkbox-control';
		$facets .= '{border-color:' . esc_attr( $accent ) . ';background:' . esc_attr( $accent ) . '}';

		// Radio button checked border color.
		$facets .= '.wpgb-facet .wpgb-radio-facet .wpgb-radio[aria-pressed="true"] .wpgb-radio-control';
		$facets .= '{border-color:' . esc_attr( $accent ) . '}';
		$facets .= '.wpgb-facet .wpgb-radio-facet .wpgb-radio-control:after';
		$facets .= '{background-color:' . esc_attr( $accent ) . '}';

		// Pagination Selected page color.
		$facets .= '.wpgb-facet .wpgb-pagination li a[aria-current]';
		$facets .= '{color:' . esc_attr( $accent ) . '}';

		// Load more button background color.
		$facets .= '.wpgb-facet .wpgb-load-more';
		$facets .= '{background:' . esc_attr( $accent ) . '}';

		// For 3rd party facets from add-ons for example.
		$facets = apply_filters( 'wp_grid_builder/facet/style', $facets, $this->settings );

		return $facets;

	}

	/**
	 * Build CSS lightbox colors
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function lightbox() {

		$lightbox = '';

		if ( ! empty( $this->settings->lightbox_background ) ) {

			$lightbox .= '.wpgb-lightbox-holder';
			$lightbox .= '{background:' . esc_attr( $this->settings->lightbox_background ) . '}';

		}

		if ( ! empty( $this->settings->lightbox_controls_color ) ) {

			$lightbox .= '.wpgb-lightbox-holder button,';
			$lightbox .= '.wpgb-lightbox-holder .wpgb-lightbox-counter';
			$lightbox .= '{color:' . esc_attr( $this->settings->lightbox_controls_color ) . '}';

		}

		if ( ! empty( $this->settings->lightbox_spinner_color ) ) {

			$lightbox .= '.wpgb-lightbox-holder:before';
			$lightbox .= '{color:' . esc_attr( $this->settings->lightbox_spinner_color ) . '}';

		}

		if ( ! empty( $this->settings->lightbox_title_color ) ) {

			$lightbox .= '.wpgb-lightbox-holder .wpgb-lightbox-title,';
			$lightbox .= '.wpgb-lightbox-holder .wpgb-lightbox-error';
			$lightbox .= '{color:' . esc_attr( $this->settings->lightbox_title_color ) . '}';

		}

		if ( ! empty( $this->settings->lightbox_desc_color ) ) {

			$lightbox .= '.wpgb-lightbox-holder .wpgb-lightbox-desc';
			$lightbox .= '{color:' . esc_attr( $this->settings->lightbox_desc_color ) . '}';

		}

		return $lightbox;

	}
}

<?php
/**
 * Updater
 *
 * @package   WP Grid Builder
 * @author    Loïc Blascos
 * @copyright 2019-2020 Loïc Blascos
 */

namespace WP_Grid_Builder\Includes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Update plugin from API
 *
 * @class WP_Grid_Builder\Admin\Updater
 * @since 1.0.0
 */
final class Updater {

	/**
	 * API Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param object $plugin Holds plugin info.
	 */
	public function __construct( $plugin ) {

		$this->plugin = $plugin;

		add_action( 'upgrader_package_options', [ $this, 'maybe_deferred_download' ], 99 );
		add_action( 'after_plugin_row_' . $this->plugin->slug, [ $this, 'update_notification' ], 10, 2 );
		add_action( 'in_plugin_update_message-' . $this->plugin->slug, [ $this, 'plugin_message' ] );
		add_action( 'admin_menu', [ $this, 'menu_notification' ] );

		add_filter( 'pre_set_site_transient_update_plugins', [ $this, 'update_plugins' ] );
		add_filter( 'site_transient_update_plugins', [ $this, 'update_state' ] );
		add_filter( 'plugins_api', [ $this, 'plugins_api' ], 10, 3 );

	}

	/**
	 * Check if it is a subsite
	 *
	 * @since 1.0.2
	 * @access public
	 *
	 * @return boolean
	 */
	public function is_subsite() {

		return is_multisite() && ! is_network_admin();

	}

	/**
	 * Check if plugin has an update
	 *
	 * @since 1.0.2
	 * @access public
	 *
	 * @return boolean
	 */
	public function has_update() {

		if ( empty( $this->plugin->new_version ) ) {
			return false;
		}

		return version_compare( (string) $this->plugin->new_version, $this->plugin->version, '>' );

	}

	/**
	 * Check if plugin license is expired
	 *
	 * @since 1.0.2
	 * @access public
	 *
	 * @return boolean
	 */
	public function is_expired() {

		if ( empty( $this->plugin->expires ) ) {
			return false;
		}

		if ( 'lifetime' === $this->plugin->expires ) {
			return false;
		}

		return $this->plugin->expires <= current_time( 'timestamp' );

	}

	/**
	 * Generate deferred plugin package url
	 * To manage short lifetime package url.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string
	 */
	public function deferred_url() {

		if ( empty( $this->plugin->name ) ) {
			return '';
		}

		if ( $this->is_expired() ) {
			return '';
		}

		return add_query_arg(
			[
				'deferred' => true,
				'plugin'   => $this->plugin->name,
			],
			admin_url( 'admin.php' )
		);

	}

	/**
	 * Filters the package options before running an update.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $options Holds plugin options.
	 * @return array $options.
	 */
	public function maybe_deferred_download( $options ) {

		$package = $options['package'];
		$parsed  = wp_parse_url( $package, PHP_URL_QUERY );

		wp_parse_str( $parsed, $query );

		// Check if url needs to be deferred.
		if ( ! isset( $query['plugin'], $query['deferred'] ) ) {
			return $options;
		}

		// If deferred url matches plugin.
		if ( $this->plugin->name !== $query['plugin'] ) {
			return $options;
		}

		$update = $this->plugin->get_update();

		// Update deferred url with downloadable url.
		if ( ! empty( $update->package ) ) {
			$options['package'] = $update->package;
		}

		return $options;

	}

	/**
	 * Show update nofication row for subsites on multisite
	 *
	 * @since 1.0.2
	 * @access public
	 *
	 * @param string $file   Path to the plugin file relative to the plugins directory.
	 * @param array  $plugin An array of plugin data.
	 */
	public function update_notification( $file, $plugin ) {

		if ( empty( $this->plugin->slug ) || $this->plugin->slug != $file ) {
			return;
		}

		if ( ! current_user_can( 'update_plugins' ) ) {
			return;
		}

		if ( ! $this->is_subsite() ) {
			return;
		}

		if ( ! $this->has_update() ) {
			return;
		}

		echo '<tr class="plugin-update-tr active" id="' . esc_attr( $file ) . '-update" data-slug="' . esc_attr( $file ) . '" data-plugin="' . esc_attr( $file ) . '">';
		echo '<td colspan="3" class="plugin-update colspanchange">';
		echo '<div class="update-message notice inline notice-warning notice-alt"><p>';

		if ( ! $this->is_expired() ) {

			$update_link = wp_nonce_url(
				add_query_arg(
					[
						'action' => 'upgrade-plugin',
						'plugin' => $file,
					],
					self_admin_url( 'update.php' )
				),
				'upgrade-plugin_' . $file
			);

			printf(
				/* translators: %1$s: plugin name, %2$s: plugin update link, %3$s: plugin update link class, %4$s: plugin update version */
				wp_kses_post( __( 'There is a new version of %1$s available. <a href="%2$s" class="%3$s">Update now</a> to version %4$s.', 'wp-grid-builder' ) ),
				esc_html( $this->plugin->name ),
				esc_url( $update_link ),
				'update-link',
				esc_html( $this->plugin->new_version )
			);

		}

		do_action( "in_plugin_update_message-$file", $plugin, $this->plugin );

		echo '</p></div></td></tr>';

	}

	/**
	 * Add counter notification in plugins.php menu item
	 *
	 * @since 1.0.2
	 * @access public
	 */
	public function menu_notification() {

		global $menu;

		if ( ! $this->has_update() || ! $this->is_subsite() ) {
			return;
		}

		$menu = array_map( // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			function( $item ) {

				if ( isset( $item[2] ) && 'plugins.php' === $item[2] ) {

					$updates = wp_get_update_data();

					$item[0] .= sprintf(
						'<span class="update-plugins count-%1$s"><span class="plugin-count">%2$s</span></span>',
						sanitize_html_class( $updates['counts']['plugins'] ),
						number_format_i18n( $updates['counts']['plugins'] )
					);

				}

				return $item;

			},
			(array) $menu
		);

	}

	/**
	 * Display renew license message
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function plugin_message() {

		if ( ! $this->is_expired() ) {
			return;
		}

		$account = 'https://wpgridbuilder.com/account/';
		$dashboard = add_query_arg(
			[ 'page' => 'wpgb-dashboard' ],
			admin_url( 'admin.php' )
		);

		$message = sprintf(
			/* translators: %1$s: plugin url, %2$s: dashboard ulr */
			__( 'Please <a href="%1$s" target="_blank" rel="external noopener noreferrer">renew your license</a> to update. You can also change your license key in <a href="%2$s">plugin dahsboard</a>.', 'tg-text-domain' ),
			esc_url( $account ),
			esc_url( $dashboard )
		);

		echo wp_kses_post( '&nbsp;' . $message );

	}

	/**
	 * Check for updates against the License API.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param  mixed $transient The value of site transient.
	 * @return mixed $transient Updated value of site transient.
	 */
	public function update_plugins( $transient ) {

		// Check if the plugin is proceed.
		if ( empty( $transient->checked[ $this->plugin->slug ] ) ) {
			return $transient;
		}

		// Update info only once.
		if ( ! isset( $this->refreshed ) ) {

			$this->plugin->refresh();
			$this->refreshed = true;

		}

		return $transient;

	}

	/**
	 * Check for updates against license status.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param  mixed $transient The value of site transient.
	 * @return mixed $transient Updated value of site transient.
	 */
	public function update_state( $transient ) {

		// Add plugin into response to push update instantly.
		if ( $this->has_update() ) {

			$transient->response[ $this->plugin->slug ] = (object) [
				'slug'        => $this->plugin->slug,
				'name'        => $this->plugin->name,
				'new_version' => $this->plugin->new_version,
				'tested'      => $this->plugin->tested,
				'icons'       => $this->plugin->icons,
				'package'     => $this->deferred_url(),
				'plugin'      => $this->plugin->slug,
				'update'      => true,
			];

			$this->update_upgrade();

		} elseif ( isset( $transient->response[ $this->plugin->slug ] ) ) {
			unset( $transient->response[ $this->plugin->slug ] );
		}

		return $transient;

	}

	/**
	 * Update upgrade counter in multisite to add active class on plugin row table.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function update_upgrade() {

		global $totals;

		if ( ! $this->is_subsite() ) {
			return;
		}

		if ( ! current_user_can( 'manage_network_plugins' ) ) {
			return;
		}

		if ( ! isset( $totals['upgrade'] ) ) {
			$totals['upgrade'] = 0; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		}

		$totals['upgrade'] += 1; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

	}

	/**
	 * Get plugin information from API.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param bool|stdClass|array $result The result object or array. Default false.
	 * @param string              $action The type of information being requested from the Plugin Install API.
	 * @param stdClass            $args   Plugin API arguments.
	 * @return array Updated array of result
	 */
	public function plugins_api( $result, $action, $args ) {

		if ( 'plugin_information' !== $action ) {
			return $result;
		}

		if ( $this->plugin->slug !== $args->slug ) {
			return $result;
		}

		// Only fetch info if missing.
		if ( ! empty( $this->plugin->info ) ) {
			$info = $this->plugin->info;
		} else {
			$info = $this->plugin->get_info();
		}

		if ( isset( $info->sections ) ) {
			return $info;
		}

		return $result;

	}
}

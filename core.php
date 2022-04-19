<?php declare(strict_types=1);

/**
 * Plugin Name:       Tribe Alerts
 * Plugin URI:        https://github.com/moderntribe/tribe-alerts
 * Description:       Tribe Alerts WordPress Plugin
 * Version:           1.0.0
 * Requires PHP:      7.4
 * Author:            Modern Tribe
 * Author URI:        https://tri.be
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tribe-alerts
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Prevent duplicate autoloading during tests
if ( ! class_exists( \Tribe\Alert\Core::class ) ) {
	// Require the vendor folder via multiple locations
	$autoloaders = (array) apply_filters( 'tribe/alerts/autoloaders', [
		trailingslashit( WP_CONTENT_DIR ) . '../vendor/autoload.php',
		trailingslashit( WP_CONTENT_DIR ) . 'vendor/autoload.php',
		trailingslashit( __DIR__ ) . 'vendor/autoload.php',
	] );

	$autoload = current( array_filter( $autoloaders, 'file_exists' ) );

	require_once $autoload;
}

add_action( 'plugins_loaded', static function (): void {
	if ( ! class_exists( 'ACF' ) ) {
		add_action(
			'admin_notices',
			static function (): void { ?>
				<div class="notice notice-error">
					<p><?php esc_html_e( 'Tribe Alerts requires Advanced Custom Fields Pro to be installed and activated!', 'tribe-alerts' ); ?></p>
				</div>
			<?php }
		);

		return;
	}

	tribe_alert()->init( __FILE__ );
}, 5, 0 );


function tribe_alert(): \Tribe\Alert\Core {
	return \Tribe\Alert\Core::instance();
}

register_activation_hook( __FILE__, new \Tribe\Alert\Activation\Activator() );
register_deactivation_hook( __FILE__, new \Tribe\Alert\Activation\Deactivator() );

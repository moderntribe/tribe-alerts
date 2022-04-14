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
	require trailingslashit( __DIR__ ) . 'vendor/autoload.php';
}

add_action( 'plugins_loaded', static function (): void {
	tribe_alert()->init( __FILE__ );
}, 1, 0 );


function tribe_alert(): \Tribe\Alert\Core {
	return \Tribe\Alert\Core::instance();
}

register_activation_hook( __FILE__, new \Tribe\Alert\Activation\Activator() );
register_deactivation_hook( __FILE__, new \Tribe\Alert\Activation\Deactivator() );

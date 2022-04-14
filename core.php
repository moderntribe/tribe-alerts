<?php declare(strict_types=1);

/**
 * Plugin Name:       :package_name
 * Plugin URI:        https://github.com/:vendor_slug/:package_slug
 * Description:       :package_description
 * Version:           1.0.0
 * Requires PHP:      7.4
 * Author:            Modern Tribe
 * Author URI:        https://tri.be
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       :package_slug
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Prevent duplicate autoloading during tests
if ( ! class_exists( \Tribe\Starter\Core::class ) ) {
	require trailingslashit( __DIR__ ) . 'vendor/autoload.php';
}

add_action( 'plugins_loaded', static function (): void {
	tribe_starter()->init( __FILE__ );
}, 1, 0 );


function tribe_starter(): \Tribe\Starter\Core {
	return \Tribe\Starter\Core::instance();
}

register_activation_hook( __FILE__, new \Tribe\Starter\Activation\Activator() );
register_deactivation_hook( __FILE__, new \Tribe\Starter\Activation\Deactivator() );

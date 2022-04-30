<?php declare(strict_types=1);

ini_set( 'memory_limit', '1024M' );

use Isolated\Symfony\Component\Finder\Finder;

/**
 * Exclude WordPress functions/classes via auto generated excludes.
 *
 * @link https://github.com/snicco/php-scoper-wordpress-excludes
 *
 * @param string $file The name of the file in the generated folder.
 *
 * @return array
 */
function scoper_wp_file( string $file ): array {
	return json_decode( file_get_contents(
			sprintf(
				'https://raw.githubusercontent.com/snicco/php-scoper-wordpress-excludes/master/generated/%s',
				$file )
		)
	);
}

function poly_str_ends_with( string $haystack, string $needle ): bool {
	if ( '' === $needle || $needle === $haystack ) {
		return true;
	}

	if ( '' === $haystack ) {
		return false;
	}

	$needleLength = strlen( $needle );

	return $needleLength <= strlen( $haystack ) && 0 === substr_compare( $haystack, $needle, - $needleLength );
}

// You can do your own things here, e.g. collecting symbols to expose dynamically
// or files to exclude.
// However beware that this file is executed by PHP-Scoper, hence if you are using
// the PHAR it will be loaded by the PHAR. So it is highly recommended to avoid
// to auto-load any code here: it can result in a conflict or even corrupt
// the PHP-Scoper analysis.

return [
	// The prefix configuration. If a non null value is be used, a random prefix
	// will be generated instead.
	//
	// For more see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#prefix
	'prefix'                  => 'Tribe\\Alert_Scoped',

	// By default when running php-scoper add-prefix, it will prefix all relevant code found in the current working
	// directory. You can however define which files should be scoped by defining a collection of Finders in the
	// following configuration key.
	//
	// This configuration entry is completely ignored when using Box.
	//
	// For more see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#finders-and-paths
	'finders'                 => [
		Finder::create()->files()->in( 'src' ),
		Finder::create()
			  ->files()
			  ->ignoreVCS( true )
			  ->notName( '/LICENSE|.*\\.md|.*\\.dist|Makefile|composer\\.json|composer\\.lock/' )
			  ->exclude( [
				  'doc',
				  'test',
				  'test_old',
				  'tests',
				  'Tests',
				  'vendor-bin',
			  ] )
			  ->in( 'vendor' ),
		Finder::create()->append( [
			'composer.json',
			'core.php',
		] ),
	],

	// List of excluded files, i.e. files for which the content will be left untouched.
	// Paths are relative to the configuration file unless if they are already absolute
	//
	// For more see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#patchers
	'exclude-files'           => [
		//'src/a-whitelisted-file.php',
	],

	// When scoping PHP files, there will be scenarios where some of the code being scoped indirectly references the
	// original namespace. These will include, for example, strings or string manipulations. PHP-Scoper has limited
	// support for prefixing such strings. To circumvent that, you can define patchers to manipulate the file to your
	// heart contents.
	//
	// For more see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#patchers
	'patchers'                => [
		static function ( string $filePath, string $prefix, string $content ): string {

			if ( ! poly_str_ends_with( $filePath, 'tribe-alerts/core.php' ) &&
			     ! poly_str_ends_with( $filePath, 'tribe-alerts/src/functions.php' )
			) {
				return $content;
			}

			// scoper is putting this in a global namespace for some reason
			return str_replace( '\\tribe_alert()->', 'tribe_alert()->', $content );
		},
	],

	// List of symbols to consider internal i.e. to leave untouched.
	//
	// For more information see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#excluded-symbols
	'exclude-namespaces'      => [
		'Tribe\Alert',
		// 'Acme\Foo'                     // The Acme\Foo namespace (and sub-namespaces)
		// '~^PHPUnit\\\\Framework$~',    // The whole namespace PHPUnit\Framework (but not sub-namespaces)
		// '~^$~',                        // The root namespace only
		// '',                            // Any namespace
	],
	'exclude-classes'         => array_merge( [
		'ACF',
	], scoper_wp_file( 'exclude-wordpress-classes.json' ) ),
	'exclude-functions'       => array_merge( [
		'/^acf_/',
	], scoper_wp_file( 'exclude-wordpress-functions.json' ) ),
	'exclude-constants'       => scoper_wp_file( 'exclude-wordpress-constants.json' ),

	// List of symbols to expose.
	// See: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#exposed-symbols
	'expose-global-constants' => true,
	'expose-global-classes'   => true,
	'expose-global-functions' => true,
	'expose-namespaces'       => [
		// 'Acme\Foo'                     // The Acme\Foo namespace (and sub-namespaces)
		// '~^PHPUnit\\\\Framework$~',    // The whole namespace PHPUnit\Framework (but not sub-namespaces)
		// '~^$~',                        // The root namespace only
		// '',                            // Any namespace
	],
	'expose-classes'          => [],
	'expose-functions'        => [],
	'expose-constants'        => [],
];

<?php declare(strict_types=1);

namespace Tribe\Alert\Resources;

use DI;
use Psr\Container\ContainerInterface;
use Tribe\Libs\Container\Definer_Interface;
use Tribe\Alert\Core;

class Resource_Definer implements Definer_Interface {

	public function define(): array {
		return [
			// Define the location of Laravel Mix's mix-manifest.json
			Manifest_Loader::class => DI\autowire()
				->constructorParameter( 'manifest_path', static function ( ContainerInterface $c ) {
					return sprintf( '%s/%s', $c->get( Core::DIST_DIR_PATH ), '/mix-manifest.json' );
				} )
				->constructorParameter( 'dist_uri', DI\get( Core::DIST_DIR_URI ) ),
		];
	}

}

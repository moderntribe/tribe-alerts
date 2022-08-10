<?php declare(strict_types=1);

namespace Tribe\Alert\View;

use DI;
use League\Plates\Engine;
use Psr\Container\ContainerInterface;
use Tribe\Alert\Core;
use Tribe\Libs\Container\Definer_Interface;

class View_Definer implements Definer_Interface {

	public const VIEW_DIRECTORY = 'views';

	public function define(): array {
		return [
			// Configure the path to our views
			Engine::class => DI\autowire()
				->constructorParameter(
					'directory',
					static fn ( ContainerInterface $c ) => apply_filters( 'tribe/alerts/view_directory', sprintf(
						'%s/%s',
						$c->get( Core::RESOURCES_PATH ),
						self::VIEW_DIRECTORY
					) )
				),
		];
	}

}

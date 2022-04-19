<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert;

use DI;
use Psr\Container\ContainerInterface;
use Tribe\Alert\Components\Alert\Rules\Display_All_Rule;
use Tribe\Alert\Components\Alert\Rules\Excluded_Posts_Rule;
use Tribe\Alert\Components\Alert\Rules\Included_Posts_Rule;
use Tribe\Libs\Container\Definer_Interface;
use Tribe\Libs\Pipeline\Contracts\Pipeline;

class Alert_Definer implements Definer_Interface {

	public function define(): array {
		return [
			Alert_Rule_Manager::class => DI\autowire()
				->constructorParameter(
					'pipeline',
					static function ( ContainerInterface $c ) {
						$pipeline = $c->get( Pipeline::class );

						// Display alert rules, processed in order.
						return $pipeline->through( [
							$c->get( Display_All_Rule::class ),
							$c->get( Excluded_Posts_Rule::class ),
							$c->get( Included_Posts_Rule::class ),
						] );
					}
				),
		];
	}

}

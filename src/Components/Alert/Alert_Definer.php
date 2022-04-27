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

	public const COLOR_OPTIONS = 'alert.color_options';

	public function define(): array {
		return [
			Color_Options_Manager::class => Alert_Color_Options::class,
			self::COLOR_OPTIONS          => DI\add( [
				'#737373' => [ 'name' => __( 'Grey', 'tribe' ), 'class' => 'grey' ],
				'#F25022' => [ 'name' => __( 'Red', 'tribe' ), 'class' => 'red' ],
				'#7FBA00' => [ 'name' => __( 'Green', 'tribe' ), 'class' => 'green' ],
				'#00A4EF' => [ 'name' => __( 'Blue', 'tribe' ), 'class' => 'blue' ],
				'#FFB900' => [ 'name' => __( 'Yellow', 'tribe' ), 'class' => 'yellow' ],
			] ),
			Alert_Color_Options::class   => DI\autowire()
				->constructorParameter(
					'color_options',
					static fn( ContainerInterface $c ) => $c->get( self::COLOR_OPTIONS )
				),
			Alert_Rule_Manager::class    => DI\autowire()
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

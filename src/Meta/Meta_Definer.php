<?php declare(strict_types=1);

namespace Tribe\Alert\Meta;

use DI;
use Psr\Container\ContainerInterface;
use Tribe\Alert\Post_Types\Alert\Alert;
use Tribe\Alert\Settings\Alert_Settings;
use Tribe\Libs\Container\Definer_Interface;
use Tribe\Libs\Object_Meta\Object_Meta_Definer;

class Meta_Definer implements Definer_Interface {

	public function define(): array {
		return [
			Object_Meta_Definer::GROUPS => DI\add( [
				DI\get( Alert_Settings_Meta::class ),
				DI\get( Alert_Meta::class ),
			] ),

			Alert_Settings_Meta::class  => DI\autowire()
				->constructorParameter( 'object_types', static fn( ContainerInterface $c ) => [
					'settings_pages' => [ $c->get( Alert_Settings::class )->get_slug() ],
				] ),

			Alert_Meta::class           => DI\autowire()
				->constructorParameter( 'object_types', static fn() => [
					'post_types' => [ Alert::NAME ],
				] ),
		];
	}

}

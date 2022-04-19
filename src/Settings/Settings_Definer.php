<?php declare(strict_types=1);

namespace Tribe\Alert\Settings;

use DI;
use Tribe\Libs\Container\Definer_Interface;

class Settings_Definer implements Definer_Interface {

	public function define(): array {
		return [
			// add acf settings screens
			\Tribe\Libs\Settings\Settings_Definer::PAGES => DI\add( [
				DI\get( Alert_Settings::class ),
			] ),
		];
	}

}

<?php declare(strict_types=1);

namespace Tribe\Starter\Activation;

/**
 * Invoked during plugin deactivation.
 *
 * @package Tribe\Starter\Activation
 */
class Deactivator implements Operable {

	public function __invoke( bool $network_wide = false ): void {
		delete_option( self::OPTION_NAME );
	}

}

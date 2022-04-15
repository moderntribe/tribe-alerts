<?php declare(strict_types=1);

namespace Tribe\Alert;

use Tribe\Alert\Components\Alert\Alert_Controller;

/**
 * Render the alert output.
 *
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
function render_alert(): void {
	tribe_alert()->get_container()->get( Alert_Controller::class )->render();
}

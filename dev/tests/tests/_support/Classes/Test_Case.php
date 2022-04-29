<?php declare(strict_types=1);

namespace Tribe\Tests;

use Codeception\TestCase\WPTestCase;
use Psr\Container\ContainerInterface;

use function Tribe\Alert\tribe_alert;

/**
 * Class Test_Case
 * Test case with specific actions for Square One projects.
 *
 * @package Tribe\Tests
 */
class Test_Case extends WPTestCase {

	protected ContainerInterface $container;

	protected function setUp(): void {
		parent::setUp();

		$this->container = tribe_alert()->get_container();
	}

}

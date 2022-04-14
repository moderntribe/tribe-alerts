<?php declare(strict_types=1);

namespace Tribe\Starter;

use Tribe\Starter\Activation\Operable;
use Tribe\Tests\Test_Case;

final class Core_Test extends Test_Case {

	public function test_it_set_up_the_test_suite_correctly() {
		$this->assertTrue( true );
		$this->assertTrue( is_plugin_active( ':package_slug/core.php' ) );
	}

	public function test_it_has_a_stored_plugin_version() {
		$this->assertSame( Core::VERSION, get_option( Operable::OPTION_NAME ) );
	}

}

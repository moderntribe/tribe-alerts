<?php declare(strict_types=1);

namespace Tribe\Alert\Rule_Processing\Factories;

use Tribe\Alert\Meta\Alert_Meta;
use Tribe\Alert\Rule_Processing\Processor_Factory;
use Tribe\Alert\Rule_Processing\Processors\Front_Page_Processor;
use Tribe\Tests\Test_Case;

final class Front_Page_Factory_Test extends Test_Case {

	private string $request_uri;

	protected function setUp(): void {
		parent::setUp();

		$this->request_uri = $_SERVER['REQUEST_URI'];
	}

	protected function tearDown(): void {
		parent::tearDown();

		// Restore original request_uri.
		$_SERVER['REQUEST_URI'] = $this->request_uri;
	}

	public function test_it_makes_a_front_page_processor(): void {
		$factory = $this->container->make( Processor_Factory::class );

		// Mock we're visiting the front page.
		$_SERVER['REQUEST_URI'] = '/';

		$rules = [
			Alert_Meta::FIELD_RULES_APPLY_TO_FRONT_PAGE => true,
		];

		$this->assertInstanceOf( Front_Page_Processor::class, $factory->get_processor( $rules ) );
	}

	public function test_it_makes_a_front_page_processor_with_a_query_string(): void {
		$factory = $this->container->make( Processor_Factory::class );

		// Mock we're visiting the front page.
		$_SERVER['REQUEST_URI'] = '/?test=true';

		$rules = [
			Alert_Meta::FIELD_RULES_APPLY_TO_FRONT_PAGE => true,
		];

		$this->assertInstanceOf( Front_Page_Processor::class, $factory->get_processor( $rules ) );
	}

	public function test_it_ignores_the_search(): void {
		$factory = $this->container->make( Processor_Factory::class );

		// Mock we're visiting the search results.
		$_SERVER['REQUEST_URI']         = '/?s=a+search+term';
		$GLOBALS['wp_query']->is_search = true;

		$rules = [
			Alert_Meta::FIELD_RULES_APPLY_TO_FRONT_PAGE => true,
		];

		$this->assertNull( $factory->get_processor( $rules ) );
	}

	public function test_it_does_make_a_front_page_processor(): void {
		$factory = $this->container->make( Processor_Factory::class );

		$rules = [
			Alert_Meta::FIELD_RULES_APPLY_TO_FRONT_PAGE => true,
		];

		$this->assertNull( $factory->get_processor( $rules ) );
	}

	public function test_it_does_make_a_front_page_processor_with_invalid_request_uri(): void {
		$factory = $this->container->make( Processor_Factory::class );

		// Mock we're visiting a different page
		$_SERVER['REQUEST_URI'] = '/blog/page/2/';

		$rules = [
			Alert_Meta::FIELD_RULES_APPLY_TO_FRONT_PAGE => true,
		];

		$this->assertNull( $factory->get_processor( $rules ) );
	}

}

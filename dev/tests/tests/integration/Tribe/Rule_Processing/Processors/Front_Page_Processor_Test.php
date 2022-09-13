<?php declare(strict_types=1);

namespace Tribe\Alert\Rule_Processing\Processors;

use Tribe\Alert\Meta\Alert_Meta;
use Tribe\Tests\Test_Case;

final class Front_Page_Processor_Test extends Test_Case {

	public function test_it_processes_the_front_page(): void {
		$processor = $this->container->make( Front_Page_Processor::class );
		$rules     = [
			Alert_Meta::FIELD_RULES_APPLY_TO_FRONT_PAGE => true,
		];

		$this->assertTrue( $processor->process( $rules ) );
	}

	public function test_it_does_not_process_the_front_page(): void {
		$processor = $this->container->make( Front_Page_Processor::class );
		$rules     = [
			Alert_Meta::FIELD_RULES_APPLY_TO_FRONT_PAGE => false,
		];

		$this->assertFalse( $processor->process( $rules ) );
	}

	public function test_it_does_not_process_the_front_page_with_empty_rules(): void {
		$processor = $this->container->make( Front_Page_Processor::class );
		$rules     = [];

		$this->assertFalse( $processor->process( $rules ) );
	}

}

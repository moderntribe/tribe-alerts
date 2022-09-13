<?php declare(strict_types=1);

namespace Tribe\Alert\Rule_Processing\Factories;

use Tribe\Alert\Meta\Alert_Meta;
use Tribe\Alert\Rule_Processing\Processor_Factory;
use Tribe\Alert\Rule_Processing\Processors\Post_Type_Archive_Processor;
use Tribe\Tests\Test_Case;

final class Post_Type_Archive_Factory_Test extends Test_Case {

	public function test_it_makes_a_post_type_archive_processor(): void {
		$factory = $this->container->make( Processor_Factory::class );

		// Mock we're visiting a post type archive.
		$GLOBALS['wp_query']->is_archive           = true;
		$GLOBALS['wp_query']->is_post_type_archive = true;

		$rules = [
			Alert_Meta::FIELD_POST_TYPE_ARCHIVES => [
				'post',
			],
		];

		$this->assertInstanceOf( Post_Type_Archive_Processor::class, $factory->get_processor( $rules ) );
	}

	public function test_it_does_not_make_a_post_type_archive_processor(): void {
		$factory = $this->container->make( Processor_Factory::class );

		$rules = [
			Alert_Meta::FIELD_POST_TYPE_ARCHIVES => [
				'post',
			],
		];

		$this->assertNull( $factory->get_processor( $rules ) );
	}

}

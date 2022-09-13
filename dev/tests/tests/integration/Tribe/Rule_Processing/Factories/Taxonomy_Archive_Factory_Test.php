<?php declare(strict_types=1);

namespace Tribe\Alert\Rule_Processing\Factories;

use Tribe\Alert\Meta\Alert_Meta;
use Tribe\Alert\Rule_Processing\Processor_Factory;
use Tribe\Alert\Rule_Processing\Processors\Taxonomy_Archive_Processor;
use Tribe\Tests\Test_Case;

final class Taxonomy_Archive_Factory_Test extends Test_Case {

	public function test_it_makes_a_taxonomy_archive_processor_when_visiting_a_category(): void {
		$factory = $this->container->make( Processor_Factory::class );

		// Mock we're visiting a category archive.
		$GLOBALS['wp_query']->is_archive  = true;
		$GLOBALS['wp_query']->is_category = true;

		$rules = [
			Alert_Meta::FIELD_TAXONOMY_ARCHIVES => [
				'category',
			],
		];

		$this->assertInstanceOf( Taxonomy_Archive_Processor::class, $factory->get_processor( $rules ) );
	}

	public function test_it_makes_a_taxonomy_archive_processor_when_visiting_a_tag(): void {
		$factory = $this->container->make( Processor_Factory::class );

		// Mock we're visiting a tag archive.
		$GLOBALS['wp_query']->is_archive = true;
		$GLOBALS['wp_query']->is_tag     = true;

		$rules = [
			Alert_Meta::FIELD_TAXONOMY_ARCHIVES => [
				'post_tag',
			],
		];

		$this->assertInstanceOf( Taxonomy_Archive_Processor::class, $factory->get_processor( $rules ) );
	}

	public function test_it_makes_a_taxonomy_archive_processor_when_visiting_a_custom_taxonomy(): void {
		$factory = $this->container->make( Processor_Factory::class );

		// Mock we're visiting a tag archive.
		$GLOBALS['wp_query']->is_archive = true;
		$GLOBALS['wp_query']->is_tax     = true;

		$rules = [
			Alert_Meta::FIELD_TAXONOMY_ARCHIVES => [
				'custom_tax',
			],
		];

		$this->assertInstanceOf( Taxonomy_Archive_Processor::class, $factory->get_processor( $rules ) );
	}

	public function test_it_does_not_make_a_post_type_archive_processor(): void {
		$factory = $this->container->make( Processor_Factory::class );

		$rules = [
			Alert_Meta::FIELD_TAXONOMY_ARCHIVES => [
				'category',
			],
		];

		$this->assertNull( $factory->get_processor( $rules ) );
	}

}

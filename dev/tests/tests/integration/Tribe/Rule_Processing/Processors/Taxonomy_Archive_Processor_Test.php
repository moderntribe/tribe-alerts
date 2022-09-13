<?php declare(strict_types=1);

namespace Tribe\Alert\Rule_Processing\Processors;

use stdClass;
use Tribe\Alert\Meta\Alert_Meta;
use Tribe\Tests\Test_Case;
use WP_Term;

final class Taxonomy_Archive_Processor_Test extends Test_Case {

	public function test_it_processes_a_category_archive(): void {
		$processor = $this->container->make( Taxonomy_Archive_Processor::class );
		$rules     = [
			Alert_Meta::FIELD_TAXONOMY_ARCHIVES => [
				'category',
			],
		];

		// Mock we're visiting a category archive.
		$GLOBALS['wp_query']->is_archive  = true;
		$GLOBALS['wp_query']->is_category = true;

		$this->assertTrue( $processor->process( $rules ) );
	}

	public function test_it_processes_a_tag_archive(): void {
		$processor = $this->container->make( Taxonomy_Archive_Processor::class );
		$rules     = [
			Alert_Meta::FIELD_TAXONOMY_ARCHIVES => [
				'post_tag',
			],
		];

		// Mock we're visiting a tag archive.
		$GLOBALS['wp_query']->is_archive = true;
		$GLOBALS['wp_query']->is_tag     = true;

		$this->assertTrue( $processor->process( $rules ) );
	}

	public function test_it_processes_a_custom_taxonomy_archive(): void {
		$processor = $this->container->make( Taxonomy_Archive_Processor::class );
		$rules     = [
			Alert_Meta::FIELD_TAXONOMY_ARCHIVES => [
				'custom_tax',
			],
		];

		// Mock we have a custom taxonomy and are visiting its archive.
		$GLOBALS['wp_query']->is_archive = true;
		$GLOBALS['wp_query']->is_tax     = true;
		$GLOBALS['wp_taxonomies']        = [
			'custom_tax' => '',
		];

		$term           = new stdClass();
		$term->taxonomy = 'custom_tax';

		$GLOBALS['wp_query']->queried_object = new WP_Term( $term );

		$this->assertTrue( $processor->process( $rules ) );
	}

	public function test_it_does_not_process_the_incorrect_taxonomy_archive(): void {
		$processor = $this->container->make( Taxonomy_Archive_Processor::class );
		$rules     = [
			Alert_Meta::FIELD_TAXONOMY_ARCHIVES => [
				'post_tag',
			],
		];

		// Mock we're visiting a category archive.
		$GLOBALS['wp_query']->is_archive  = true;
		$GLOBALS['wp_query']->is_category = true;

		$this->assertFalse( $processor->process( $rules ) );
	}

	public function test_it_does_not_process_taxonomy_archive_with_empty_rules(): void {
		$processor = $this->container->make( Taxonomy_Archive_Processor::class );
		$rules     = [
			// User did not select any taxonomies.
			Alert_Meta::FIELD_TAXONOMY_ARCHIVES => [],
		];

		// Mock we're visiting all archives at once.
		$GLOBALS['wp_query']->is_archive  = true;
		$GLOBALS['wp_query']->is_category = true;
		$GLOBALS['wp_query']->is_tag      = true;

		$this->assertFalse( $processor->process( $rules ) );
	}

}

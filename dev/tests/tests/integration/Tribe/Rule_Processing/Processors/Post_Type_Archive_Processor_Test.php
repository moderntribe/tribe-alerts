<?php declare(strict_types=1);

namespace Tribe\Alert\Rule_Processing\Processors;

use Tribe\Alert\Meta\Alert_Meta;
use Tribe\Tests\Test_Case;

final class Post_Type_Archive_Processor_Test extends Test_Case {

	public function test_it_processes_a_post_type_archive(): void {
		$processor = $this->container->make( Post_Type_Archive_Processor::class );
		$rules     = [
			Alert_Meta::FIELD_POST_TYPE_ARCHIVES => [
				'custom_cpt',
				'some_other_post_type',
				'post',
			],
		];

		// Mock the user is viewing a post type archive
		$GLOBALS['wp_query']->is_archive           = true;
		$GLOBALS['wp_query']->is_post_type_archive = true;
		$GLOBALS['wp_query']->set( 'post_type', 'post' );

		$this->assertTrue( $processor->process( $rules ) );
	}

	public function test_it_does_not_process_a_post_type_archive(): void {
		$processor = $this->container->make( Post_Type_Archive_Processor::class );
		$rules     = [
			Alert_Meta::FIELD_POST_TYPE_ARCHIVES => [
				'cpt_does_not_exist',
			],
		];

		// Mock the user is viewing a post type archive
		$GLOBALS['wp_query']->is_archive           = true;
		$GLOBALS['wp_query']->is_post_type_archive = true;
		$GLOBALS['wp_query']->set( 'post_type', 'post' );

		$this->assertFalse( $processor->process( $rules ) );
	}

	public function test_it_does_not_process_a_post_type_archive_with_empty_rules(): void {
		$processor = $this->container->make( Post_Type_Archive_Processor::class );
		$rules     = [
			Alert_Meta::FIELD_POST_TYPE_ARCHIVES => [],
		];

		// Mock the user is viewing a post type archive
		$GLOBALS['wp_query']->is_archive           = true;
		$GLOBALS['wp_query']->is_post_type_archive = true;
		$GLOBALS['wp_query']->set( 'post_type', 'post' );

		$this->assertFalse( $processor->process( $rules ) );
	}

}

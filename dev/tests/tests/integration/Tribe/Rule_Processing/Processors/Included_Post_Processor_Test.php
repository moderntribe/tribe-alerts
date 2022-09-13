<?php declare(strict_types=1);

namespace Tribe\Alert\Rule_Processing\Processors;

use Tribe\Alert\Meta\Alert_Meta;
use Tribe\Tests\Test_Case;

final class Included_Post_Processor_Test extends Test_Case {

	protected function tearDown(): void {
		parent::tearDown();

		$GLOBALS['post'] = null;
	}

	public function test_it_includes_a_post(): void {
		$post_id = $this->factory()->post->create();
		$post    = get_post( $post_id );

		// Mock we're viewing a post.
		$GLOBALS['post']                  = $post;
		$GLOBALS['wp_query']->is_singular = true;

		$processor = $this->container->make( Included_Post_Processor::class );
		$rules     = [
			Alert_Meta::FIELD_RULES_INCLUDE_PAGES => [
				$post,
			],
		];

		$this->assertTrue( $processor->process( $rules ) );
	}

	public function test_it_does_not_include_a_post(): void {
		$post   = get_post( $this->factory()->post->create() );
		$post_2 = get_post( $this->factory()->post->create() );

		// Mock we're viewing a post, but not one in the list of exclusions.
		$GLOBALS['post']                  = $post;
		$GLOBALS['wp_query']->is_singular = true;

		$processor = $this->container->make( Included_Post_Processor::class );
		$rules     = [
			Alert_Meta::FIELD_RULES_INCLUDE_PAGES => [
				$post_2,
			],
		];

		$this->assertFalse( $processor->process( $rules ) );
	}

	public function test_it_does_not_include_posts_with_empty_include_rules(): void {
		$post = get_post( $this->factory()->post->create() );

		// Mock we're viewing a post, but not one in the list of exclusions.
		$GLOBALS['post']                  = $post;
		$GLOBALS['wp_query']->is_singular = true;

		$processor = $this->container->make( Included_Post_Processor::class );
		$rules     = [
			// User didn't specify any specific posts to include.
			Alert_Meta::FIELD_RULES_INCLUDE_PAGES => [],
		];

		$this->assertFalse( $processor->process( $rules ) );
	}

}

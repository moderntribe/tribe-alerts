<?php declare(strict_types=1);

namespace Tribe\Alert\Rule_Processing\Factories;

use Tribe\Alert\Meta\Alert_Meta;
use Tribe\Alert\Rule_Processing\Processor_Factory;
use Tribe\Alert\Rule_Processing\Processors\Excluded_Post_Processor;
use Tribe\Alert\Rule_Processing\Processors\Included_Post_Processor;
use Tribe\Tests\Test_Case;
use Tribe\Tests\Traits\Alert_Generator;

final class Post_Factory_Test extends Test_Case {

	use Alert_Generator;

	public function test_it_makes_an_excluded_post_processor(): void {
		// Mock we're visiting a singular post.
		$post_id                          = $this->factory()->post->create();
		$GLOBALS['post']                  = get_post( $post_id );
		$GLOBALS['wp_query']->is_singular = true;

		$factory = $this->container->make( Processor_Factory::class );

		$rules = [
			Alert_Meta::FIELD_RULES_DISPLAY_TYPE => Alert_Meta::OPTION_EXCLUDE,
		];

		$this->assertInstanceOf( Excluded_Post_Processor::class, $factory->get_processor( $rules ) );
	}

	public function test_it_makes_an_included_post_processor(): void {
		// Mock we're visiting a singular post.
		$post_id                          = $this->factory()->post->create();
		$GLOBALS['post']                  = get_post( $post_id );
		$GLOBALS['wp_query']->is_singular = true;

		$factory = $this->container->make( Processor_Factory::class );

		$rules = [
			Alert_Meta::FIELD_RULES_DISPLAY_TYPE => Alert_Meta::OPTION_INCLUDE,
		];

		$this->assertInstanceOf( Included_Post_Processor::class, $factory->get_processor( $rules ) );
	}

	public function test_it_does_not_make_a_post_processor_with_invalid_display_type(): void {
		// Mock we're visiting a singular post.
		$post_id                          = $this->factory()->post->create();
		$GLOBALS['post']                  = get_post( $post_id );
		$GLOBALS['wp_query']->is_singular = true;

		$factory = $this->container->make( Processor_Factory::class );

		// Incorrect display type.
		$rules = [
			Alert_Meta::FIELD_RULES_DISPLAY_TYPE => Alert_Meta::OPTION_EVERY_PAGE,
		];

		$this->assertNull( $factory->get_processor( $rules ) );
	}

}

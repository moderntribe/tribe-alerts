<?php declare(strict_types=1);

namespace Tribe\Alert\Post_Fetcher\Strategies;

use Tribe\Tests\Test_Case;

final class Singular_Post_Fetcher_Test extends Test_Case {

	protected Singular_Post_Fetcher $post_fetcher;

	protected function setUp(): void {
		parent::setUp();

		$this->post_fetcher = $this->container->make( Singular_Post_Fetcher::class );
	}

	protected function tearDown(): void {
		parent::tearDown();

		// Clean up $post global after each test
		$GLOBALS['post'] = null;
	}

	public function test_it_does_not_find_a_post(): void {
		$this->assertNull( $this->post_fetcher->get_post() );
	}

	public function test_it_finds_the_current_post(): void {
		$p = $this->factory()->post->create_and_get();
		$p = get_post( $p );

		$GLOBALS['post'] = $p;

		// Force WP to think we're on a singular page
		$GLOBALS['wp_query']->is_singular = true;

		$this->assertEquals( $p, $this->post_fetcher->get_post() );
	}

}

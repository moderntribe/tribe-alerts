<?php declare(strict_types=1);

namespace Tribe\Alert\Post_Fetcher\Strategies;

use Tribe\Tests\Test_Case;

final class Posts_Page_Fetcher_Test extends Test_Case {

	public function test_it_gets_the_currently_set_posts_page(): void {
		$p = $this->factory()->post->create_and_get();
		$p = get_post( $p );

		// WordPress sets the current queried object when a posts page has been selected and a user is visting it.
		$GLOBALS['wp_query']->queried_object = $p;

		$post_fetcher = $this->container->make( Posts_Page_Fetcher::class );

		$this->assertEquals( $p, $post_fetcher->get_post() );
	}

}

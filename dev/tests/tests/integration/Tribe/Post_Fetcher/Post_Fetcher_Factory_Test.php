<?php declare(strict_types=1);

namespace Tribe\Alert\Post_Fetcher;

use Tribe\Alert\Post_Fetcher\Strategies\Home_Page_Fetcher;
use Tribe\Alert\Post_Fetcher\Strategies\Posts_Page_Fetcher;
use Tribe\Alert\Post_Fetcher\Strategies\Singular_Post_Fetcher;
use Tribe\Tests\Test_Case;

final class Post_Fetcher_Factory_Test extends Test_Case {

	protected Post_Fetcher_Factory $post_fetcher_factory;

	protected function setUp(): void {
		parent::setUp();

		$this->post_fetcher_factory = $this->container->make( Post_Fetcher_Factory::class );
	}

	protected function tearDown(): void {
		parent::tearDown();

		// Clean up $post global after each test
		$GLOBALS['post'] = null;
	}

	public function test_it_makes_the_singular_post_fetcher(): void {
		$this->assertInstanceOf( Singular_Post_Fetcher::class, $this->post_fetcher_factory->make() );
	}

	public function test_it_makes_the_home_page_post_fetcher(): void {
		$p = $this->factory()->post->create_and_get();
		$p = get_post( $p );

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $p->ID );

		$GLOBALS['post'] = $p;

		// Force WP to think we're on the home page
		$GLOBALS['wp_query']->is_home = true;

		$this->assertInstanceOf( Home_Page_Fetcher::class, $this->post_fetcher_factory->make() );
	}

	public function test_it_makes_the_posts_page_post_fetcher(): void {
		$p = $this->factory()->post->create_and_get();
		$p = get_post( $p );

		// Force WP to think we're on the assigned posts page
		$GLOBALS['wp_query']->is_posts_page     = true;
		$GLOBALS['wp_query']->queried_object    = $p;
		$GLOBALS['wp_query']->queried_object_id = $p->ID;

		$this->assertInstanceOf( Posts_Page_Fetcher::class, $this->post_fetcher_factory->make() );
	}

}

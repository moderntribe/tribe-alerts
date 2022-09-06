<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert;

use Tribe\Tests\Test_Case;
use WP_Query;

final class Post_Fetcher_Test extends Test_Case {

	protected Post_Fetcher $post_fetcher;

	protected function setUp(): void {
		parent::setUp();

		$this->post_fetcher = $this->container->make( Post_Fetcher::class );

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
		global $wp_query;
		$wp_query        = new WP_Query();
		$wp_query->is_singular = true;

		$this->assertEquals( $p, $this->post_fetcher->get_post() );
	}

	public function test_it_finds_the_blog_posts_page(): void {
		$p = $this->factory()->post->create_and_get();
		$p = get_post( $p );

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $p->ID );

		$GLOBALS['post'] = $p;

		// Force WP to think we're on the home (aka post listing) page
		global $wp_query;
		$wp_query          = new WP_Query();
		$wp_query->is_home = true;

		$this->assertEquals( $p, $this->post_fetcher->get_post() );
	}

}

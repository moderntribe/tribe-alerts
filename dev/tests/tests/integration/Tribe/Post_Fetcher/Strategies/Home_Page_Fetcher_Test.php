<?php declare(strict_types=1);

namespace Tribe\Alert\Post_Fetcher\Strategies;

use Tribe\Tests\Test_Case;

final class Home_Page_Fetcher_Test extends Test_Case {

	public function test_it_gets_page_on_front(): void {
		$p = $this->factory()->post->create_and_get();
		$p = get_post( $p );

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $p->ID );

		$post_fetcher = $this->container->make( Home_Page_Fetcher::class );

		$this->assertEquals( $p, $post_fetcher->get_post() );
	}

}

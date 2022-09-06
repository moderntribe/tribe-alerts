<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert;

use WP_Post;

class Post_Fetcher {

	/**
	 * Fetch the current post, with support for the configured
	 * Posts Page under Settings > Reading.
	 */
	public function get_post(): ?WP_Post {
		if ( is_home() ) {
			return get_post( (int) get_option( 'page_on_front' ) );
		}

		if ( ! is_singular() ) {
			return null;
		}

		return get_post();
	}

}

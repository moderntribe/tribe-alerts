<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert\Rules;

use Closure;
use Tribe\Alert\Components\Alert\Rule;
use Tribe\Alert\Components\Alert\Rules\Traits\With_Front_Page_Rule;
use Tribe\Alert\Meta\Alert_Meta;
use Tribe\Alert\Post_Fetcher\Post_Fetcher;

class Included_Posts_Rule implements Rule {

	use With_Front_Page_Rule;

	protected Post_Fetcher $post_fetcher;

	public function __construct( Post_Fetcher $post_fetcher ) {
		$this->post_fetcher = $post_fetcher;
	}

	/**
	 * Show only on these posts.
	 *
	 * @inheritDoc
	 */
	public function handle( bool $display, Closure $next, array $rules ): bool {
		$type = $rules[ Alert_Meta::FIELD_RULES_DISPLAY_TYPE ] ?? '';

		if ( $type === Alert_Meta::OPTION_INCLUDE ) {
			// If "always apply to front page" is checked.
			if ( is_front_page() && $this->apply_to_front_page( $rules ) ) {
				return true;
			}

			$post = $this->post_fetcher->get_post();

			if ( ! isset( $post->ID ) ) {
				return $next( $display );
			}

			$included_posts = $rules[ Alert_Meta::FIELD_RULES_INCLUDE_PAGES ] ?? [];

			if ( ! $included_posts ) {
				return false;
			}

			foreach ( $included_posts as $included_post ) {
				if ( $post->ID === $included_post->ID ) {
					return true;
				}
			}

			return false;
		}

		return $next( $display );
	}

}

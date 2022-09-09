<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert\Rules;

use Closure;
use Tribe\Alert\Components\Alert\Rule;
use Tribe\Alert\Components\Alert\Rules\Traits\With_Front_Page_Rule;
use Tribe\Alert\Meta\Alert_Meta;
use Tribe\Alert\Post_Fetcher\Post_Fetcher;

class Excluded_Posts_Rule implements Rule {

	use With_Front_Page_Rule;

	protected Post_Fetcher $post_fetcher;

	public function __construct( Post_Fetcher $post_fetcher ) {
		$this->post_fetcher = $post_fetcher;
	}

	/**
	 * Show on every post besides the ones included here.
	 *
	 * @inheritDoc
	 */
	public function handle( bool $display, Closure $next, array $rules ): bool {
		$type = $rules[ Alert_Meta::FIELD_RULES_DISPLAY_TYPE ] ?? '';

		if ( $type === Alert_Meta::OPTION_EXCLUDE ) {
			// If "always apply to front page" is checked.
			if ( $this->is_frontpage() && $this->apply_to_front_page( $rules ) ) {
				return false;
			}

			$post = $this->post_fetcher->get_post();

			if ( ! isset( $post->ID ) ) {
				return $next( $display );
			}

			$excluded_posts = $rules[ Alert_Meta::FIELD_RULES_EXCLUDE_PAGES ] ?? [];

			if ( ! $excluded_posts ) {
				return true;
			}

			foreach ( $excluded_posts as $excluded_post ) {
				if ( $post->ID === $excluded_post->ID ) {
					return false;
				}
			}

			return true;
		}

		return $next( $display );
	}

}

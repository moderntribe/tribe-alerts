<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert\Rules;

use Closure;
use Tribe\Alert\Components\Alert\Rule;
use Tribe\Alert\Meta\Alert_Meta;

class Included_Posts_Rule implements Rule {

	/**
	 * Show only on these posts.
	 *
	 * @inheritDoc
	 */
	public function handle( bool $display, Closure $next, array $rules ): bool {
		$type = $rules[ Alert_Meta::FIELD_RULES_DISPLAY_TYPE ] ?? '';

		if ( $type === Alert_Meta::OPTION_INCLUDE ) {
			if ( ! is_singular() ) {
				return false;
			}

			$post = get_post();

			if ( ! isset( $post->ID ) ) {
				return $next( $display );
			}

			$included_posts = $rules[ Alert_Meta::FIELD_RULES_INCLUDE_PAGES ] ?? [];

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

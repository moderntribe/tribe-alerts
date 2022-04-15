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
	public function handle( array $rules, Closure $next ): bool {
		$type = $rules[ Alert_Meta::FIELD_RULES_DISPLAY_TYPE ] ?? '';

		if ( $type === Alert_Meta::OPTION_INCLUDE ) {
			global $post;

			if ( ! isset( $post->ID ) ) {
				return $next( $rules );
			}

			$included_posts = $rules[ Alert_Meta::FIELD_RULES_SPECIFY_PAGES ] ?? [];

			foreach ( $included_posts as $excluded_post ) {
				if ( $post->ID === $excluded_post->ID ) {
					return true;
				}
			}

			return false;
		}

		return $next( $rules );
	}

}

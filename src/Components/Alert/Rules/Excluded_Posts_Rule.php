<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert\Rules;

use Closure;
use Tribe\Alert\Components\Alert\Rule;
use Tribe\Alert\Meta\Alert_Meta;

class Excluded_Posts_Rule implements Rule {

	/**
	 * Show on every post besides the ones included here.
	 *
	 * @inheritDoc
	 */
	public function handle( array $rules, Closure $next ): bool {
		$type = $rules[ Alert_Meta::FIELD_RULES_DISPLAY_TYPE ] ?? '';

		if ( $type === Alert_Meta::OPTION_EXCLUDE ) {
			global $post;

			if ( ! isset( $post->ID ) ) {
				return $next( $rules );
			}

			$excluded_posts = $rules[ Alert_Meta::FIELD_RULES_EXCLUDE_PAGES ] ?? [];

			foreach ( $excluded_posts as $excluded_post ) {
				if ( $post->ID === $excluded_post->ID ) {
					return false;
				}
			}

			return true;
		}

		return $next( $rules );
	}

}

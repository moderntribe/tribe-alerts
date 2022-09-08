<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert\Rules\Traits;

use Tribe\Alert\Meta\Alert_Meta;

/**
 * @mixin \Tribe\Alert\Components\Alert\Rule
 */
trait With_Front_Page_Rule {

	/**
	 * Determine if the rules currently being processed include the option to
	 * always apply on the front page.
	 *
	 * @param mixed[] $rules The Alert Meta ACF Rules Group.
	 */
	protected function apply_to_front_page( array $rules ): bool {
		$display_type = $rules[ Alert_Meta::FIELD_RULES_DISPLAY_TYPE ] ?? '';

		if ( ! $display_type || $display_type === Alert_Meta::OPTION_EVERY_PAGE ) {
			return false;
		}

		return (bool) ( $rules[ Alert_Meta::FIELD_RULES_APPLY_TO_FRONT_PAGE ] ?? false );
	}

}

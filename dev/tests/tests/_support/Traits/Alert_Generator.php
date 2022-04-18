<?php declare(strict_types=1);

namespace Tribe\Tests\Traits;

use Tribe\Alert\Meta\Alert_Meta;
use Tribe\Alert\Post_Types\Alert\Alert;

/**
 * @mixin \Codeception\TestCase\WPTestCase
 */
trait Alert_Generator {

	/**
	 * Generate an alert and return the post ID.
	 *
	 * @param string $title The alert title.
	 * @param string $message The alert message to display.
	 * @param string $display_type The display rule selected.
	 *
	 * @return array{id: int, included: int[], excluded: int[]}
	 */
	protected function generate_alert(
		string $title,
		string $message,
		string $display_type = Alert_Meta::OPTION_EVERY_PAGE ): array {

		$alert = $this->factory()->post->create( [
			'post_type'   => Alert::NAME,
			'post_status' => 'publish',
			'post_title'  => $title,
		] );

		$included = [];
		$excluded = [];

		$rules = [
			Alert_Meta::FIELD_RULES_DISPLAY_TYPE  => $display_type,
			Alert_Meta::FIELD_RULES_INCLUDE_PAGES => $included,
			Alert_Meta::FIELD_RULES_EXCLUDE_PAGES => $excluded,
		];

		if ( $display_type === Alert_Meta::OPTION_INCLUDE ) {
			$included = $this->factory()->post->create_many( 5 );

			$rules = array_merge( $rules, [
				Alert_Meta::FIELD_RULES_INCLUDE_PAGES => $included,
			] );
		}

		if ( $display_type === Alert_Meta::OPTION_EXCLUDE ) {
			$excluded = $this->factory()->post->create_many( 5 );

			$rules = array_merge( $rules, [
				Alert_Meta::FIELD_RULES_EXCLUDE_PAGES => $excluded,
			] );
		}

		$results = [
			update_field( Alert_Meta::FIELD_MESSAGE, $message, $alert ),
			update_field( Alert_Meta::GROUP_RULES, $rules, $alert ),
		];

		foreach ( $results as $result ) {
			$this->assertGreaterThan( 0, $result );
		}

		return [
			'id'       => $alert,
			'included' => $included,
			'excluded' => $excluded,
		];
	}

}

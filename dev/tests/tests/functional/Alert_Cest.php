<?php declare(strict_types=1);

use Tribe\Alert\Meta\Alert_Meta;
use Tribe\Alert\Meta\Alert_Settings_Meta;
use Tribe\Alert\Post_Types\Alert\Alert;

class Alert_Cest {

	public function test_it_displays_a_global_alert_on_the_homepage( FunctionalTester $I ) {
		$alert_id = $I->havePostInDatabase( [
			'post_type'   => Alert::NAME,
			'post_status' => 'publish',
			'post_title'  => 'Test global alert',
		] );

		update_field( Alert_Meta::FIELD_MESSAGE, 'Test alert message', $alert_id );
		update_field( Alert_Meta::GROUP_RULES, [
			Alert_Meta::FIELD_RULES_DISPLAY_TYPE => Alert_Meta::OPTION_EVERY_PAGE,
		], $alert_id );

		update_field( Alert_Settings_Meta::FIELD_ACTIVE_ALERT, [ $alert_id ], 'option' );

		$I->amOnPage( '/' );

		$I->seeInSource( 'const tribeAlert = ' );
	}
}

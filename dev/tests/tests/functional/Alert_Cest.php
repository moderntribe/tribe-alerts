<?php declare(strict_types=1);

use Tribe\Alert\Components\Alert\Alert_Color_Options;
use Tribe\Alert\Components\Alert\Alert_Controller;
use Tribe\Alert\Meta\Alert_Meta;
use Tribe\Alert\Meta\Alert_Settings_Meta;
use Tribe\Alert\Post_Types\Alert\Alert;

final class Alert_Cest {

	public function test_it_excludes_alert_from_post( FunctionalTester $I ) {
		$alert_id = $I->havePostInDatabase( [
			'post_type'   => Alert::NAME,
			'post_status' => 'publish',
			'post_title'  => 'Test excluded alert',
		] );

		$I->havePostInDatabase( [
			'post_type'   => 'post',
			'post_status' => 'publish',
			'post_title'  => 'Regular post',
			'post_name'   => 'regular-post',
		] );

		$excluded_id = $I->havePostInDatabase( [
			'post_type'   => 'post',
			'post_status' => 'publish',
			'post_title'  => 'Excluded alert',
			'post_name'   => 'excluded-alert',
		] );

		$excluded_id_2 = $I->havePostInDatabase( [
			'post_type'   => 'post',
			'post_status' => 'publish',
			'post_title'  => 'Another excluded alert',
			'post_name'   => 'another-excluded-alert',
		] );

		update_field( Alert_Meta::FIELD_MESSAGE, 'Test excluded alert message', $alert_id );
		update_field( Alert_Meta::GROUP_RULES, [
			Alert_Meta::FIELD_RULES_DISPLAY_TYPE  => Alert_Meta::OPTION_EXCLUDE,
			Alert_Meta::FIELD_RULES_EXCLUDE_PAGES => [ $excluded_id, $excluded_id_2 ],
		], $alert_id );

		update_field( Alert_Settings_Meta::FIELD_ACTIVE_ALERT, [ $alert_id ], 'option' );

		$I->amOnPage( '/excluded-alert' );
		$I->seeResponseCodeIs( 200 );

		$I->seeInSource( '<!-- tribe alerts -->' );
		$I->dontSeeElement( '.tribe-alerts' );

		$I->amOnPage( '/another-excluded-alert' );
		$I->seeResponseCodeIs( 200 );

		$I->seeInSource( '<!-- tribe alerts -->' );
		$I->dontSeeElement( '.tribe-alerts' );

		$I->amOnPage( '/regular-post' );
		$I->seeResponseCodeIs( 200 );

		$I->seeInSource( '<!-- tribe alerts -->' );
		$I->seeElement( '.tribe-alerts' );
		$I->see( 'Test excluded alert message' );

		// Validate pipeline bug was fixed on search page (or any page without a $post global)
		$I->amOnPage( '/?s=meep' );
		$I->seeResponseCodeIs( 200 );
		$I->seeInSource( '<!-- tribe alerts -->' );
		$I->dontSeeElement( '.tribe-alerts' );
		$I->dontSee( 'Fatal error', 'b' );
		$I->dontSeeInSource( 'Uncaught TypeError' );

		$I->amOnPage( '/category/uncategorized/' );
		$I->seeResponseCodeIs( 200 );
		$I->seeInSource( '<!-- tribe alerts -->' );
		$I->dontSeeElement( '.tribe-alerts' );
		$I->dontSee( 'Fatal error', 'b' );
		$I->dontSeeInSource( 'Uncaught TypeError' );
	}

	public function test_it_includes_alert_on_specific_posts( FunctionalTester $I ) {
		$alert_id = $I->havePostInDatabase( [
			'post_type'   => Alert::NAME,
			'post_status' => 'publish',
			'post_title'  => 'Test included alert',
		] );

		$I->havePostInDatabase( [
			'post_type'   => 'post',
			'post_status' => 'publish',
			'post_title'  => 'Regular post',
			'post_name'   => 'regular-post',
		] );

		$included_id = $I->havePostInDatabase( [
			'post_type'   => 'post',
			'post_status' => 'publish',
			'post_title'  => 'Another included alert',
			'post_name'   => 'another-included-alert',
		] );

		$included_id_2 = $I->havePostInDatabase( [
			'post_type'   => 'post',
			'post_status' => 'publish',
			'post_title'  => 'Included alert',
			'post_name'   => 'included-alert',
		] );

		update_field( Alert_Meta::FIELD_MESSAGE, 'Test included alert message', $alert_id );
		update_field( Alert_Meta::GROUP_RULES, [
			Alert_Meta::FIELD_RULES_DISPLAY_TYPE  => Alert_Meta::OPTION_INCLUDE,
			Alert_Meta::FIELD_RULES_INCLUDE_PAGES => [ $included_id, $included_id_2 ],
		], $alert_id );

		update_field( Alert_Settings_Meta::FIELD_ACTIVE_ALERT, [ $alert_id ], 'option' );

		$I->amOnPage( '/regular-post' );
		$I->seeResponseCodeIs( 200 );

		$I->seeInSource( '<!-- tribe alerts -->' );
		$I->dontSeeElement( '.tribe-alerts' );

		$I->amOnPage( '/included-alert' );
		$I->seeResponseCodeIs( 200 );

		$I->seeInSource( '<!-- tribe alerts -->' );
		$I->seeElement( '.tribe-alerts' );
		$I->see( 'Test included alert message' );

		$I->amOnPage( '/another-included-alert' );
		$I->seeResponseCodeIs( 200 );

		$I->seeInSource( '<!-- tribe alerts -->' );
		$I->seeElement( '.tribe-alerts' );
		$I->see( 'Test included alert message' );

		$I->amOnPage( '/?s=meep' );
		$I->seeResponseCodeIs( 200 );
		$I->seeInSource( '<!-- tribe alerts -->' );
		$I->dontSeeElement( '.tribe-alerts' );

		$I->amOnPage( '/category/uncategorized/' );
		$I->seeResponseCodeIs( 200 );
		$I->seeInSource( '<!-- tribe alerts -->' );
		$I->dontSeeElement( '.tribe-alerts' );
	}

	public function test_it_displays_a_global_alert_on_multiple_urls( FunctionalTester $I ) {
		$alert_id = $I->havePostInDatabase( [
			'post_type'   => Alert::NAME,
			'post_status' => 'publish',
			'post_title'  => 'Test global alert',
		] );

		$I->havePostInDatabase( [
			'post_type'   => 'post',
			'post_status' => 'publish',
			'post_title'  => 'Regular post',
			'post_name'   => 'regular-post',
		] );

		update_field( Alert_Meta::FIELD_MESSAGE, 'Test alert message', $alert_id );
		update_field( Alert_Meta::GROUP_RULES, [
			Alert_Meta::FIELD_RULES_DISPLAY_TYPE  => Alert_Meta::OPTION_EVERY_PAGE,
			Alert_Meta::FIELD_RULES_INCLUDE_PAGES => [],
			Alert_Meta::FIELD_RULES_EXCLUDE_PAGES => [],
		], $alert_id );

		update_field( Alert_Settings_Meta::FIELD_ACTIVE_ALERT, [ $alert_id ], 'option' );

		$I->amOnPage( '/' );

		$I->seeElement( '.tribe-alerts' );
		$I->see( 'Test alert message' );

		$I->amOnPage( '/regular-post' );
		$I->seeResponseCodeIs( 200 );

		$I->seeInSource( '<!-- tribe alerts -->' );
		$I->seeElement( '.tribe-alerts' );
		$I->see( 'Test alert message' );

		$I->amOnPage( '/?s=meep' );
		$I->seeResponseCodeIs( 200 );
		$I->seeInSource( '<!-- tribe alerts -->' );
		$I->seeElement( '.tribe-alerts' );
		$I->see( 'Test alert message' );

		$I->amOnPage( '/category/uncategorized/' );
		$I->seeResponseCodeIs( 200 );
		$I->seeInSource( '<!-- tribe alerts -->' );
		$I->seeElement( '.tribe-alerts' );
		$I->see( 'Test alert message' );
	}

	public function test_it_does_not_display_on_a_404_page( FunctionalTester $I ) {
		$alert_id = $I->havePostInDatabase( [
			'post_type'   => Alert::NAME,
			'post_status' => 'publish',
			'post_title'  => 'Test global alert',
		] );

		update_field( Alert_Meta::FIELD_MESSAGE, 'Test alert message', $alert_id );
		update_field( Alert_Meta::GROUP_RULES, [
			Alert_Meta::FIELD_RULES_DISPLAY_TYPE  => Alert_Meta::OPTION_EVERY_PAGE,
			Alert_Meta::FIELD_RULES_INCLUDE_PAGES => [],
			Alert_Meta::FIELD_RULES_EXCLUDE_PAGES => [],
		], $alert_id );

		update_field( Alert_Settings_Meta::FIELD_ACTIVE_ALERT, [ $alert_id ], 'option' );

		$I->amOnPage( '/' );

		$I->seeElement( '.tribe-alerts' );
		$I->see( 'Test alert message' );

		$I->amOnPage( '/a-missing-url' );
		$I->seeResponseCodeIs( 404 );

		$I->seeInSource( '<!-- tribe alerts -->' );
		$I->dontSeeElement( '.tribe-alerts' );
		$I->dontSee( 'Test alert message' );
	}

	public function test_it_does_not_display_color_css_classes_when_not_active( FunctionalTester $I ): void {
		$alert_id = $I->havePostInDatabase( [
			'post_type'   => Alert::NAME,
			'post_status' => 'publish',
			'post_title'  => 'Test global alert',
		] );

		update_field( Alert_Meta::FIELD_MESSAGE, 'Test alert message', $alert_id );
		update_field( Alert_Meta::GROUP_RULES, [
			Alert_Meta::FIELD_RULES_DISPLAY_TYPE  => Alert_Meta::OPTION_EVERY_PAGE,
			Alert_Meta::FIELD_RULES_INCLUDE_PAGES => [],
			Alert_Meta::FIELD_RULES_EXCLUDE_PAGES => [],
		], $alert_id );

		update_field( Alert_Settings_Meta::FIELD_ACTIVE_ALERT, [ $alert_id ], 'option' );

		$I->amOnPage( '/' );

		$I->seeElement( '.tribe-alerts' );
		$I->see( 'Test alert message' );
		$I->dontSeeElement( Alert_Controller::COLOR_THEME_CLASS );
	}

	public function test_it_displays_color_css_classes_when_active( FunctionalTester $I ): void {
		putenv( 'TRIBE_ALERTS_COLOR_OPTIONS=true' );

		$alert_id = $I->havePostInDatabase( [
			'post_type'   => Alert::NAME,
			'post_status' => 'publish',
			'post_title'  => 'Test global alert',
		] );

		update_field( Alert_Meta::FIELD_MESSAGE, 'Test alert message', $alert_id );
		update_field( Alert_Meta::GROUP_RULES, [
			Alert_Meta::FIELD_RULES_DISPLAY_TYPE  => Alert_Meta::OPTION_EVERY_PAGE,
			Alert_Meta::FIELD_RULES_INCLUDE_PAGES => [],
			Alert_Meta::FIELD_RULES_EXCLUDE_PAGES => [],
		], $alert_id );
		update_field( Alert_Meta::FIELD_COLOR, '#ffffff', $alert_id );

		update_field( Alert_Settings_Meta::FIELD_ACTIVE_ALERT, [ $alert_id ], 'option' );

		$I->amOnPage( '/' );

		$I->seeElement( '.tribe-alerts' );
		$I->see( 'Test alert message' );
		$I->seeElement( '.' . Alert_Controller::COLOR_THEME_CLASS );
		$I->seeElement( sprintf( '.%s-white', Alert_Color_Options::CSS_CLASS_PREFIX ) );
	}

}

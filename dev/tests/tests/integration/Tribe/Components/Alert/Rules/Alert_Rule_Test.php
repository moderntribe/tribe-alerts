<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert\Rules;

use Tribe\Alert\Meta\Alert_Meta;
use Tribe\Tests\Test_Case;
use Tribe\Tests\Traits\Alert_Generator;

final class Alert_Rule_Test extends Test_Case {

	use Alert_Generator;

	protected function tearDown(): void {
		parent::tearDown();

		// Clean up $post global after each test
		$GLOBALS['post'] = null;
	}

	public function test_it_would_display_on_all_pages(): void {
		$title   = 'Alert on all pages';
		$message = 'My custom alert message';

		$alert = $this->generate_alert( $title, $message );
		$id    = $alert['id'];

		$this->assertSame( $title, get_post( $id )->post_title );
		$this->assertSame( $message, get_field( Alert_Meta::FIELD_MESSAGE, $id ) );

		$rules = get_field( Alert_Meta::GROUP_RULES, $id );
		$this->assertSame( Alert_Meta::OPTION_EVERY_PAGE, $rules[ Alert_Meta::FIELD_RULES_DISPLAY_TYPE ] );
		$this->assertEmpty( $rules[ Alert_Meta::FIELD_RULES_EXCLUDE_PAGES ] );
		$this->assertEmpty( $rules[ Alert_Meta::FIELD_RULES_INCLUDE_PAGES ] );

		$rule    = $this->container->make( Display_All_Rule::class );
		$closure = static fn() => false;

		$this->assertTrue( $rule->handle( false, $closure, $rules ) );
	}

	public function test_it_would_only_display_on_certain_pages(): void {
		$title   = 'Alert on certain pages';
		$message = 'My custom alert message';

		$alert = $this->generate_alert( $title, $message, Alert_Meta::OPTION_INCLUDE );
		$id    = $alert['id'];

		$this->assertSame( $title, get_post( $id )->post_title );
		$this->assertSame( $message, get_field( Alert_Meta::FIELD_MESSAGE, $id ) );

		$rules    = get_field( Alert_Meta::GROUP_RULES, $id );
		$included = $rules[ Alert_Meta::FIELD_RULES_INCLUDE_PAGES ];

		$this->assertSame( $alert['included'], array_column( $included, 'ID' ) );
		$this->assertSame( Alert_Meta::OPTION_INCLUDE, $rules[ Alert_Meta::FIELD_RULES_DISPLAY_TYPE ] );
		$this->assertEmpty( $rules[ Alert_Meta::FIELD_RULES_EXCLUDE_PAGES ] );
		$this->assertNotEmpty( $included );

		$rule    = $this->container->make( Included_Posts_Rule::class );
		$closure = static fn() => false;

		// Test each post would show the alert.
		$GLOBALS['wp_query']->is_singular = true;

		foreach ( $included as $post_id ) {
			$GLOBALS['post'] = get_post( $post_id );

			$this->assertTrue( $rule->handle( false, $closure, $rules ) );
		}

		// Mock the current post is not in the included list.
		$_post           = clone $GLOBALS['post'];
		$_post->ID       = 99999;
		$GLOBALS['post'] = $_post;

		$this->assertFalse( $rule->handle( false, $closure, $rules ) );
	}

	public function test_it_would_exclude_certain_pages(): void {
		$title   = 'Alert excluded on specific pages';
		$message = 'My custom alert message';

		$alert = $this->generate_alert( $title, $message, Alert_Meta::OPTION_EXCLUDE );
		$id    = $alert['id'];

		$this->assertSame( $title, get_post( $id )->post_title );
		$this->assertSame( $message, get_field( Alert_Meta::FIELD_MESSAGE, $id ) );

		$rules    = get_field( Alert_Meta::GROUP_RULES, $id );
		$excluded = $rules[ Alert_Meta::FIELD_RULES_EXCLUDE_PAGES ];

		$this->assertSame( $alert['excluded'], array_column( $excluded, 'ID' ) );
		$this->assertSame( Alert_Meta::OPTION_EXCLUDE, $rules[ Alert_Meta::FIELD_RULES_DISPLAY_TYPE ] );
		$this->assertEmpty( $rules[ Alert_Meta::FIELD_RULES_INCLUDE_PAGES ] );
		$this->assertNotEmpty( $excluded );

		$rule    = $this->container->make( Excluded_Posts_Rule::class );
		$closure = static fn() => false;

		// Test each post would NOT display the alert.
		foreach ( $excluded as $post_id ) {
			$GLOBALS['post'] = get_post( $post_id );

			$this->assertFalse( $rule->handle( false, $closure, $rules ) );
		}

		// Mock the current post is not in the excluded list.
		$_post                            = clone $GLOBALS['post'];
		$_post->ID                        = 99999;
		$GLOBALS['post']                  = $_post;
		$GLOBALS['wp_query']->is_singular = true;

		$this->assertTrue( $rule->handle( false, $closure, $rules ) );
	}

}

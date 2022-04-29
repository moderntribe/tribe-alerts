<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert;

use Tribe\Tests\Test_Case;

final class Alert_Color_Options_Test extends Test_Case {

	public function test_it_finds_correct_class_names(): void {
		$class_manager = new Alert_Color_Options( $this->get_test_color_options() );

		$black = $class_manager->get_color_class( '#000000' );
		$this->assertSame( $black, 'tribe_alerts--black' );

		$white = $class_manager->get_color_class( '#ffffff' );
		$this->assertSame( $white, 'tribe_alerts--white' );

		$white_uppercase = $class_manager->get_color_class( '#FFFFFF' );
		$this->assertSame( $white_uppercase, '' );

		$white_mixed_case = $class_manager->get_color_class( '#FFfFfF' );
		$this->assertSame( $white_mixed_case, '' );

		$null = $class_manager->get_color_class( '' );
		$this->assertSame( $null, '' );

		$missing_color = $class_manager->get_color_class( '#99ksss' );
		$this->assertSame( $missing_color, '' );

		$this->assertSame( $this->get_test_color_options(), $class_manager->get_all_options() );
	}

	public function test_it_gets_colors_for_acf(): void {
		$class_manager = new Alert_Color_Options( $this->get_test_color_options() );

		$this->assertSame( [
			'#ffffff' => 'White',
			'#000000' => 'Black',
		], $class_manager->get_acf_options() );

	}

	private function get_test_color_options(): array {
		return [
			'#ffffff' => [
				'name'  => __( 'White', 'tribe-alerts' ),
				'class' => 'white',
			],
			'#000000' => [
				'name'  => __( 'Black', 'tribe-alerts' ),
				'class' => 'black',
			],
		];
	}

}

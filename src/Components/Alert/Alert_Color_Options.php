<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert;

class Alert_Color_Options implements Color_Options_Manager {

	/**
	 * @var array{name: string, class: string}
	 */
	protected array $color_options;

	public function __construct( array $color_options ) {
		$this->color_options = $color_options;
	}

	public function get_all_options(): array {
		return $this->color_options;
	}

	/**
	 * @return string[]
	 */
	public function get_acf_options(): array {
		return wp_list_pluck( $this->color_options, 'name' );
	}

	public function get_color_class( string $hex ): string {
		$color = $this->color_options[ $hex ] ?? '';

		return $color ? sanitize_html_class( sprintf( 'tribe_alerts--%s', $color['class'] ) ) : '';
	}

}

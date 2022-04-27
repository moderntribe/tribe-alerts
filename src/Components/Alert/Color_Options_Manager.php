<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert;

interface Color_Options_Manager {

	/**
	 * Should return multidimensional array where key is HEX color and value is array of a color name and class name.
	 *
	 * @return array
	 */
	public function get_all_options(): array;

	public function get_acf_options(): array;

	public function get_color_class( string $hex ): string;

}

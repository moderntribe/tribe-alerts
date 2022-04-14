<?php declare(strict_types=1);

namespace Tribe\Alert\Traits;

use InvalidArgumentException;

/**
 * Additional Block Field functionality.
 *
 * @mixin \Tribe\Libs\ACF\ACF_Meta_Group
 */
trait With_Field_Prefix {

	/**
	 * The ACF field prefix.
	 */
	protected string $field_prefix = 'field';

	/**
	 * Get an ACF field with the proper prefix.
	 *
	 * @param string $name The ACF field name.
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @return string The prefixed key.
	 */
	protected function get_key_with_prefix( string $name ): string {
		if ( ! defined( 'self::NAME' ) ) {
			throw new InvalidArgumentException( 'Cannot find the NAME constant. This trait should be used in an extended Block_Config class' );
		}

		return sprintf( '%s_%s_%s', $this->field_prefix, self::NAME, $name );
	}

}

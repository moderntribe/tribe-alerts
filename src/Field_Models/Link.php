<?php declare(strict_types=1);

namespace Tribe\Alert\Field_Models;

use Spatie\DataTransferObject\FlexibleDataTransferObject;

/**
 * Represents an ACF Link field.
 */
class Link extends FlexibleDataTransferObject {

	public string $url          = '';
	public string $title        = '';
	public string $target       = '';
	public string $aria_label   = '';
	public bool $add_aria_label = false;

}

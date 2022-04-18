<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert;

use Spatie\DataTransferObject\FlexibleDataTransferObject;
use Tribe\Alert\Field_Models\Link;

class Alert_Dto extends FlexibleDataTransferObject {

	public int $id         = 0;
	public string $title   = '';
	public string $content = '';
	public ?Link $cta      = null;

}

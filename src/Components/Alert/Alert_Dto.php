<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert;

use Spatie\DataTransferObject\FlexibleDataTransferObject;
use Tribe\Alert\Field_Models\Alert_Cta;

class Alert_Dto extends FlexibleDataTransferObject {

	public int $id         = 0;
	public string $title   = '';
	public string $content = '';
	public ?Alert_Cta $cta = null;

}

<?php declare(strict_types=1);

namespace Tribe\Alert\Post_Types\Alert;

use Tribe\Libs\Post_Type\Post_Type_Subscriber;

class Subscriber extends Post_Type_Subscriber {

	// phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingAnyTypeHint
	protected $config_class = Config::class;

}

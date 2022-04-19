<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert;

use Tribe\Libs\Pipeline\Contracts\Pipeline;

class Alert_Rule_Manager {

	protected Pipeline $pipeline;

	public function __construct( Pipeline $pipeline ) {
		$this->pipeline = $pipeline;
	}

	/**
	 * Determine if an alert will be displayed.
	 *
	 * @see \Tribe\Alert\Meta\Alert_Meta::GROUP_RULES
	 *
	 * @param array $rules
	 *
	 * @return bool
	 */
	public function should_display( array $rules ): bool {
		if ( empty( $rules ) ) {
			return false;
		}

		return $this->pipeline->send( $rules )->thenReturn();
	}

}

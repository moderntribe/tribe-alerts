<?php declare(strict_types=1);

namespace Tribe\Alert\Field_Models;

use Spatie\DataTransferObject\FlexibleDataTransferObject;

/**
 * Represents a custom CTA field.
 */
class Alert_Cta extends FlexibleDataTransferObject {

	public ?Link $alert_cta_link      = null;
	public string $alert_aria_label   = '';
	public bool $alert_add_aria_label = false;

	public function __construct( array $parameters = [] ) {
		// ACF will send an empty Link field as a string, cast it properly
		$parameters['alert_cta_link'] = (array) $parameters['alert_cta_link'] ?? [];

		parent::__construct( $parameters );
	}

}

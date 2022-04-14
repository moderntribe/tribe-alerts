<?php declare(strict_types=1);

namespace Tribe\Starter\Resources;

/**
 * Abstract Script and Style Loader.
 */
abstract class Loader {

	protected Manifest_Loader $manifest_loader;

	abstract public function enqueue(): void;

	public function __construct( Manifest_Loader $manifest_loader ) {
		$this->manifest_loader = $manifest_loader;
	}

}

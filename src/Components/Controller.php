<?php declare(strict_types=1);

namespace Tribe\Alert\Components;

use League\Plates\Engine;

abstract class Controller {

	/**
	 * The Plates View Engine.
	 */
	protected Engine $view;

	/**
	 * Echo the plates view.
	 */
	abstract public function render(): void;

	/**
	 * @param \League\Plates\Engine $view
	 */
	public function __construct( Engine $view ) {
		$this->view = $view;
	}

}

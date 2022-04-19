<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert;

use League\Plates\Engine;
use Tribe\Alert\Components\Controller;

class Alert_Controller extends Controller {

	public const VIEW = 'alert';

	protected Alert_Model $model;

	public function __construct( Engine $view, Alert_Model $model ) {
		parent::__construct( $view );

		$this->model = $model;
	}

	public function render(): void {
		$alert = $this->model->get_data();

		if ( ! $alert->id ) {
			return;
		}

		echo $this->view->render( self::VIEW, [
			'dto' => $alert,
		] );
	}

}

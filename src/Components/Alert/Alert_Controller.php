<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert;

use League\Plates\Engine;
use Tribe\Alert\Components\Controller;
use Tribe\Libs\Utils\Markup_Utils;

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
			'dto'             => $alert,
			'link_attributes' => $this->get_link_attributes( $alert ),
		] );
	}

	protected function get_link_attributes( Alert_Dto $alert ): string {
		return Markup_Utils::concat_attrs( array_filter( [
			'target'     => $alert->cta->target,
			'aria-label' => $alert->cta->add_aria_label ? $alert->cta->aria_label : '',
		] ) );
	}

}

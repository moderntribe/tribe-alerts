<?php declare(strict_types=1);

namespace Tribe\Alert\Theme;

use Tribe\Libs\Container\Abstract_Subscriber;

use function Tribe\Alert\render_alert;

class Theme_Subscriber extends Abstract_Subscriber {

	public function register(): void {
		add_action( 'wp_footer', static function (): void {
			echo '<!-- tribe alerts -->';
			render_alert();
		} );
	}

}

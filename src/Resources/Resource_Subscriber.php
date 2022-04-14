<?php declare(strict_types=1);

namespace Tribe\Alert\Resources;

use Tribe\Libs\Container\Abstract_Subscriber;
use Tribe\Alert\Resources\Admin\Admin_Script_Loader;
use Tribe\Alert\Resources\Admin\Editor_Script_Loader;
use Tribe\Alert\Resources\Theme\Script_Loader;

/**
 * Class Asset_Subscriber
 *
 * @package Tribe\Alert
 */
class Resource_Subscriber extends Abstract_Subscriber {

	public function register(): void {
		add_action( 'wp_enqueue_scripts', function (): void {
			$this->container->get( Script_Loader::class )->enqueue();
		} );

		add_action( 'admin_enqueue_scripts', function (): void {
			$this->container->get( Admin_Script_Loader::class )->enqueue();
		} );

		add_action( 'enqueue_block_editor_assets', function (): void {
			$this->container->get( Editor_Script_Loader::class )->enqueue();
		} );
	}

}

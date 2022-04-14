<?php declare(strict_types=1);

namespace Tribe\Starter\Resources\Admin;

use Tribe\Starter\Resources\Loader;

/**
 * Block editor script & style loader.
 */
class Editor_Script_Loader extends Loader {

	/**
	 * @action enqueue_block_editor_assets
	 */
	public function enqueue(): void {
		wp_enqueue_script( ':package_slug-editor-js', $this->manifest_loader->get_manifest()['/js/admin/editor.js'] );
		wp_enqueue_style( ':package_slug-editor-css', $this->manifest_loader->get_manifest()['/css/admin/editor.css'] );
	}

}

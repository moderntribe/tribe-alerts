<?php declare(strict_types=1);

namespace Tribe\Alert\Components\Alert;

use Closure;

interface Rule {

	/**
	 * Determine if we should display an alert. A rule can return
	 * a result or pass itself onto the next rule for processing.
	 *
	 * @param mixed[]  $rules The Alert Meta ACF Rules Group.
	 * @param \Closure $next  The next rule in the pipeline.
	 *
	 * @return bool
	 */
	public function handle( array $rules, Closure $next ): bool;

}

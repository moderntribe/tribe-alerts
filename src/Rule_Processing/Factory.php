<?php declare(strict_types=1);

namespace Tribe\Alert\Rule_Processing;

use Closure;

interface Factory {

	/**
	 * Make the correct Processor based on the current page being viewed.
	 *
	 * @param \Tribe\Alert\Rule_Processing\Processor|null $processor Which processor was selected, if any.
	 * @param \Closure                                    $next      The next stage in the pipeline.
	 * @param mixed[]                                     $rules     The ACF rule group data.
	 *
	 * @return \Tribe\Alert\Rule_Processing\Processor|null
	 */
	public function make( ?Processor $processor, Closure $next, array $rules ): ?Processor;

}

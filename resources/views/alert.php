<?php declare(strict_types=1);

/**
 * @var \League\Plates\Template\Template        $this
 * @var \Tribe\Alert\Components\Alert\Alert_Dto $dto
 */
?>

<div
	class="tribe-alerts"
	id="tribe-alerts"
	data-alert-id="<?php echo $this->escape( $dto->id ) ?>"
>
	<div class="tribe-alerts__container">

		<button
			class="tribe-alerts__close icon icon-close"
			data-alert-btn="close"
		>
			<span class="u-visually-hidden">Close alert</span>
		</button>

		<?php

		if( $dto->title ) :

			printf('<h2 class="tribe-alerts__title">%s</h2>',
				$this->escape( $dto->title )
			);

		endif;

		if( $dto->content ) :

			printf( '<div class="tribe-alerts__content">%s</div>',
				$this->escape( $dto->content )
			);

		endif;

		if( $dto->cta->url ) :

			printf( '<a class="a-link tribe-alerts__link" href="%1$s" %3$s %4$s >%2$s</a>',
				$this->escape( $dto->cta->url, 'esc_url' ),
				$dto->cta->title ? $this->escape( $dto->cta->title ) : __('Find out more', 'tribe'),
				$dto->cta->target ? 'target="' . $this->escape( $dto->cta->target ) . '"' : '',
				$dto->cta->aria_label ? 'aria-label="' . $this->escape( $dto->cta->aria_label ) . '"' : '',
			);

		endif;

		?>
	</div>

</div>

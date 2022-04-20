<?php declare(strict_types=1);

/**
 * @var \League\Plates\Template\Template        $this
 * @var \Tribe\Alert\Components\Alert\Alert_Dto $dto
 * @var string                                  $link_attributes
 */
?>

<div
	class="tribe-alerts"
	id="tribe-alerts"
	data-alert-id="<?php echo $this->e( $dto->id ) ?>"
>
	<div class="tribe-alerts__container">

		<button
			class="tribe-alerts__close icon icon-close"
			data-alert-btn="close"
		>
			<span class="u-visually-hidden">Close alert</span>
		</button>

		<?php if ( $dto->title ) : ?>
			<h2 class="tribe-alerts__title"><?php echo $this->e( $dto->title ) ?></h2>
		<?php endif; ?>

		<?php if ( $dto->content ) : ?>
			<div class="tribe-alerts__content"><?php echo $this->e( $dto->content ) ?></div>
		<?php endif; ?>

		<?php if ( $dto->cta->url ) : ?>
			<a class="a-link tribe-alerts__link"
				<?php echo $link_attributes ?>
			   href="<?php echo $this->e( $dto->cta->url, 'esc_url' ) ?>">
				<?php echo $this->e( $dto->cta->title ) ?>
			</a>
		<?php endif; ?>
	</div>

</div>

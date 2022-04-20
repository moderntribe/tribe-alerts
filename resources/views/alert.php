<?php declare(strict_types=1);

/**
 * @var \League\Plates\Template\Template        $this
 * @var \Tribe\Alert\Components\Alert\Alert_Dto $dto
 */
?>

<div data-alert-id="<?php echo $this->escape( $dto->id ) ?>"
	 data-alert-title="<?php echo $this->escape( $dto->title ) ?>"
	 data-alert-content="<?php echo $this->escape( $dto->content ) ?>"
	 data-alert-link="<?php echo $this->escape( $dto->cta->url, 'esc_url' ) ?>"
	 data-alert-link-title="<?php echo $this->escape( $dto->cta->title ) ?>"
	 data-alert-link-target="<?php echo $this->escape( $dto->cta->target ) ?>"
>
	<script>
		// @TODO FE: unsure you how you want to build this, using data objects, or we can just output
		// everything in a global JS object.
		const tribeAlert = <?php echo wp_json_encode( $dto->toArray() ) ?>;
	</script>

	<?php $test = [
		'break_php_cs' => true,
	];
	?>
</div>

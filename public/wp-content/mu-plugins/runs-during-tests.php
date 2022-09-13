<?php declare(strict_types=1);
/*
  Plugin Name: Runs during tests
  Plugin URI: https://tri.be
  Description: This Must Use Plugin should only run when automated tests are being executed to create required test data.
  Version: 1.0
  Author: Justin Frydman
*/
add_action( 'init', static function (): void {
	if ( ! tribe_getenv( 'TRIBE_TEST_ENVIRONMENT', false ) ) {
		return;
	}

	register_extended_post_type( 'project', [
		'taxonomies' => [
			'category',
			'post_tag',
			'location',
		],
	], [
		'singular' => 'Project',
		'plural'   => 'Projects',
		'slug'     => 'projects',
	] );

	register_extended_taxonomy( 'location', [
		'project',
		'post',
		'page',
	] );

	flush_rewrite_rules( false );
}, 0 );

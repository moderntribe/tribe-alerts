<?php declare(strict_types=1);
/*
  Plugin Name: Functional Tests: Create Project CPT
  Plugin URI: https://tri.be
  Description: Creates a Project Custom Post Type when functional tests are running.
  Version: 1.0
  Author: Justin Frydman
*/
add_action( 'init', static function (): void {
	if ( ! tribe_getenv( 'TRIBE_TEST_ENVIRONMENT', false ) ) {
		return;
	}

	register_extended_post_type( 'project', [
		'taxonomies' => [ 'category', 'post_tag' ],
	], [
		'singular' => 'Project',
		'plural'   => 'Projects',
		'slug'     => 'projects',
	] );

	flush_rewrite_rules( false );
}, 0 );

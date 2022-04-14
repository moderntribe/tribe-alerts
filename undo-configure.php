#!/usr/bin/env php
<?php declare(strict_types=1);

function run( string $command ): string {
	return trim( shell_exec( $command ) ?: '' );
}

run( 'git reset --hard HEAD' );
run( 'git clean -f -d' );
run( 'rm -rf vendor' );
run( 'rm -rf composer.lock' );

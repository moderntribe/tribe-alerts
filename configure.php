#!/usr/bin/env php
<?php declare(strict_types=1);

function ask( string $question, string $default = '' ): string {
	$answer = readline( $question . ( $default ? " ($default)" : null ) . ': ' );

	if ( ! $answer ) {
		return $default;
	}

	return $answer;
}

function confirm( string $question, bool $default = false ): bool {
	$answer = ask( $question . ' (' . ( $default ? 'Y/n' : 'y/N' ) . ')' );

	if ( ! $answer ) {
		return $default;
	}

	return strtolower( $answer ) === 'y';
}

function writeln( string $line ): void {
	echo $line . PHP_EOL;
}

function run( string $command ): string {
	return trim( shell_exec( $command ) ?: '' );
}

function str_after( string $subject, string $search ): string {
	$pos = strrpos( $subject, $search );

	if ( $pos === false ) {
		return $subject;
	}

	return substr( $subject, $pos + strlen( $search ) );
}

function slugify( string $subject ): string {
	return strtolower( trim( preg_replace( '/[^A-Za-z0-9-]+/', '-', $subject ), '-' ) );
}

function title_case( string $subject ): string {
	return str_replace( ' ', '', ucwords( str_replace( [ '-', '_' ], ' ', $subject ) ) );
}

function sentence_case( string $subject ): string {
	return ucwords( str_replace( [ '-', '_' ], ' ', $subject ) );
}

function snake_case( string $subject ): string {
	return preg_replace( '/(?<!^)[A-Z]/', '_$0', title_case( $subject ) );
}

function replace_in_file( string $file, array $replacements ): void {
	$contents = file_get_contents( $file );

	file_put_contents(
		$file,
		str_replace(
			array_keys( $replacements ),
			array_values( $replacements ),
			$contents
		)
	);
}

$authorName = ask( 'Author name', 'Modern Tribe' );

$authorEmail = ask( 'Author email', 'admin@tri.be' );

$vendorName      = ask( 'Vendor name', 'Modern Tribe' );
$vendorSlug      = $vendorName === 'Modern Tribe' ? 'moderntribe' : slugify( $vendorName );
$vendorNamespace = ucwords( $vendorName );
$vendorNamespace = ask( 'Vendor namespace', 'Tribe' );

$currentDirectory = getcwd();
$folderName       = basename( $currentDirectory );

$packageName = ask( 'Plugin name', sentence_case( $folderName ) );
$packageSlug = slugify( $packageName );

$className   = snake_case( $packageName );
$className   = ask( 'Class name', $className );
$description = ask( 'Plugin description', "$packageName WordPress Plugin" );

$functionName = sprintf( 'tribe_%s', strtolower( $className ) );

writeln( '------' );
writeln( "Author        : $authorName ($authorEmail)" );
writeln( "Vendor        : $vendorName ($vendorSlug)" );
writeln( "Plugin        : $packageSlug <$description>" );
writeln( "Namespace     : $vendorNamespace\\$className" );
writeln( "Class name    : $className" );
writeln( "Function name : $functionName" );
writeln( '------' );

writeln( 'This script will replace the above values in all relevant files in the project directory.' );

if ( ! confirm( 'Modify files?', true ) ) {
	exit( 1 );
}

$files = explode( PHP_EOL, run( 'grep -E -r -l -i ":author|:vendor|:package|VendorName|starter|vendor_name|vendor_slug|author@domain.com" --exclude-dir={vendor,.git} ./* | grep -v ' . basename( __FILE__ ) ) );
$files = array_filter( $files );

foreach ( $files as $file ) {
	replace_in_file( $file, [
			':author_name'         => $authorName,
			'author@domain.com'    => $authorEmail,
			':vendor_name'         => $vendorName,
			':vendor_slug'         => $vendorSlug,
			'VendorName'           => $vendorNamespace,
			':package_name'        => $packageName,
			':package_slug'        => $packageSlug,
			'Starter'              => $className,
			':package_description' => $description,
			'tribe_starter'        => $functionName,
	] );
}

confirm( 'Let this script delete itself?', true ) && unlink( __FILE__ );

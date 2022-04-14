/**
 * Laravel Mix Configuration File.
 *
 * @link https://laravel-mix.com/docs/6.0/api
 *
 * @type {exports | Api}
 */
let mix = require('laravel-mix');

require('laravel-mix-esbuild');

/**
 * The location to output files. If you change this, change the path
 * to the mix-manifest.json in Asset_Definer.php.
 */
mix.setPublicPath('resources/dist');

/**
 * Javascript entry points.
 */
mix.js('resources/src/js/theme/index.js', 'js/theme')
	.js('resources/src/js/admin/index.js', 'js/admin')
	.esbuild();

mix.js('resources/src/js/admin/editor.js', 'js/admin')
	.esbuild('jsx').react();

/**
 * PostCSS entry points.
 */
mix.postCss('resources/src/css/theme/main.pcss', 'css/theme')
	.postCss('resources/src/css/admin/main.pcss', 'css/admin')
	.postCss('resources/src/css/admin/editor.pcss', 'css/admin');

mix.options({
	postCss: [
		require('postcss-custom-properties'),
		require('postcss-import-ext-glob'),
		require('postcss-mixins'),
		require('postcss-import'),
		require('postcss-custom-media'),
		require('postcss-nested'),
		require('postcss-assets')({
			baseUrl: '/wp-content/plugins/:package_slug/assets/',
		})
	]
});

mix.browserSync({
	proxy: ':package_slug.tribe',
});

/**
 * Alias for JS imports.
 */
mix.alias({
	'@': './'
});

# Tribe Alerts

Displays a customizable banner on that screen and remembers when users have dismissed it.

---
Display custom banner alerts on your website.
---

### Requirements
- php7.4+
- Advanced Custom Fields Pro
- nvm or fnm
- node 16+
- yarn 1.22+
- npm 8.3+

### Quick Start First Run

1. Install [SquareOne Docker (so)](https://github.com/moderntribe/square1-global-docker#squareone-docker)
2. Run: `so bootstrap`
3. Run: `nvm use`
4. Run: `yarn install`
5. Run: `yarn mix`
6. Activate your plugins in the WordPress dashboard and start developing!

### Pull Requests / Building

Ensure you run `yarn prod` before submitting a PR to ensure the `resources/dist` folder is updated with the latest build.

### Front end

Front end building is powered by [Laravel Mix](https://laravel-mix.com/).

#### Building
```bash
nvm use
```

```bash
yarn install
```

#### Usage

Build for development:

```bash
yarn dev
```

Watch for file changes:

```bash
yarn watch
```

Poll for file changes:

```bash
yarn watch-poll
```

Watch with hot module replacement:

```bash
yarn hot
```

Build for production:

```bash
yarn production
```

See more options: `yarn mix --help`

### Installing this plugin

Every published [release](https://github.com/moderntribe/tribe-alerts/releases) automatically creates a `tribe-alerts.zip` which is a fully built and vendor scoped WordPress plugin, about a minute after the release is published. To manually install, visit a release and download and extract the zip in your WordPress plugins folder.

#### Composer

The best way to include the release zip is by using the fantastic [ffraenz/private-composer-installer](https://github.com/ffraenz/private-composer-installer) plugin. 

Add a custom repository to your project's `repository` key in `composer.json`:

```json
  "repositories": [
    {
      "type": "package",
      "package": {
        "name": "moderntribe/tribe-alerts",
        "version": "1.1.0",
        "type": "wordpress-plugin",
        "dist": {
          "type": "zip",
          "url": "https://github.com/moderntribe/tribe-alerts/releases/download/{%VERSION}/tribe-alerts.zip"
        },
        "require": {
          "ffraenz/private-composer-installer": "^5.0"
        }
      }
    },
 ],
```

> NOTE: Simply update the version above and run `composer update` to upgrade the plugin in the future.

Then, add the plugin definition to the require section:

```json
  "require": {
    "moderntribe/tribe-alerts": "*",
  }
```

Tell composer where to put your WordPress plugins/themes via the `extra` section.

> NOTE: Adjust the paths based on your project.

```json
  "extra": {
    "wordpress-install-dir": "wp",
    "installer-paths": {
      "wp-content/mu-plugins/{$name}": [
        "type:wordpress-muplugin"
      ],
      "wp-content/plugins/{$name}": [
        "type:wordpress-plugin"
      ],
      "wp-content/themes/{$name}": [
        "type:wordpress-theme"
      ]
    }
  },
```  

You may have to allow this plugin in your config as well:

```json
    "allow-plugins": {
      "composer/installers": true,
      "ffraenz/private-composer-installer": true,
    }
```

Finally, install the plugin:

```bash
composer update
```

### Displaying an Alert

The banner is set to automatically display using the `wp_footer` hook. If you need to manually add it to a theme or a plugin, add the following code to render the alert view:

```php

<?php if ( function_exists( '\Tribe\Alert\tribe_alert' ) && function_exists( '\Tribe\Alert\render_alert' ) ) {
    \Tribe\Alert\render_alert();
} ?>

```

You can hide the automatic `wp_footer` output by defining the following in your wp-config.php:

```php
define( 'TRIBE_ALERTS_AUTOMATIC_OUTPUT', false );
```

### ACF Swatch Field Options

Color options are disabled by default. You can enable it by defining the following in your wp-config.php:

```php
define( 'TRIBE_ALERTS_COLOR_OPTIONS', true );
```

Filter the color options provided to the ACF swatch field:

```php
add_filter( 'tribe/alerts/color_options', static fn ( array $options ) => [
    '#880ED4' => [
        'name'  => esc_html__( 'Purple', 'tribe-alerts' ),
        'class' => 'purple-mono',
    ],
    '#8155BA' => [
        'name'  => esc_html__( 'Violet', 'tribe-alerts' ),
        'class' => 'violet',
    ],
    '#323E42' => [
        'name'  => esc_html__( 'Charcoal', 'tribe-alerts' ),
        'class' => 'charcoal',
    ],          
], 10, 1 );
```

The default CSS class prefix for the color theme is `tribe-alerts__theme`, which ends up being `tribe-alerts__theme-$name` once a color is selected.

Filter the CSS class prefix:

```php
add_filter( 'tribe/alerts/color_options/css_class_prefix', static fn ( string $prefix ) => 'new-prefix', 10, 1 );
```

### Credits

- Based on [Spatie Skeleton](https://github.com/spatie/package-skeleton-php)

### License

GNU General Public License GPLv2 (or later). Please see [License File](LICENSE.md) for more information.

### Modern Tribe

![https://tri.be/contact/](https://moderntribe-common.s3.us-west-2.amazonaws.com/marketing/ModernTribe-Banner.png)

# Tribe Alerts

Tribe Alerts WordPress Plugin

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

### Front end

Front end building is powered by [Laravel Mix](https://laravel-mix.com/).

#### Installation
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

### Displaying an Alert

The alert front-end is set to automatically display using the `wp_footer` hook. If you need to manually add it to a theme or a plugin, add the following code to render the alert view:

```php

<?php if ( function_exists( '\Tribe\Alert\render_alert' ) ) {
    \Tribe\Alert\render_alert();
} ?>

```

You can hide the automatic `wp_footer` output by defining the following in your wp-config.php:

```php
define( 'TRIBE_ALERTS_AUTOMATIC_OUTPUT', false );
```

### Credits

- Based on [Spatie Skeleton](https://github.com/spatie/package-skeleton-php)

### License

GNU General Public License GPLv2 (or later). Please see [License File](LICENSE.md) for more information.

# :package_name

:package_description

---
This package can be used to scaffold a modern WordPress plugin. Follow these steps to get started:

1. Press the "Use template" button at the top of this repo to create a new repo with the contents of this skeleton.
2. Run `php ./configure.php` to run a script that will replace all placeholders throughout all the files.
3. Manually delete `undo-configure.php` once you're satisfied with the replacement.
4. Commit the `composer.lock` file.
5. Adjust this README to suit your plugin.
---

### Requirements
- php7.4+
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

### Credits

- Based on [Spatie Skeleton](https://github.com/spatie/package-skeleton-php)

### License

GNU General Public License GPLv2 (or later). Please see [License File](LICENSE.md) for more information.
